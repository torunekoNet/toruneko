<?php

/**
 * File: ContactForm.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 21:23
 * Description:
 */
class ContactForm extends CFormModel
{
    public $post_id;
    public $fid = 0;
    public $user_id;
    public $username;
    public $email;
    public $content;
//    public $verifyCode;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('username', 'required', 'message' => '请输入' . $labels['username']),
            array('content', 'required', 'message' => '请输入' . $labels['content']),
            array('email', 'required', 'message' => '请输入' . $labels['email']),
            array('post_id, fid', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'post_id' => '博文ID',
            'content' => '留言',
            'username' => '昵称',
            'email' => '邮箱',
        );
    }

    public function save()
    {
        $app = Yii::app();

        $transaction = $app->db->beginTransaction();
        try {
            $result = Yii::app()->fraudmetrix->invoke(array(
                'event_id' => 'post_web',
                'account_login' => $this->email,
                'posting_title' => $this->username,
                'posting_content' => $this->content,
            ));
            if ($result['success'] == false || ($result['success'] == true && $result['final_decision'] == 'Reject')) {
                throw new CDbException('评论失败', 100, array());
            }
            //更新comment计数
            $res = BlogPost::model()->updateCounters(array(
                'comment_count' => 1
            ), 'id=' . $this->post_id);
            if (!$res) throw new CDbException('更新评论计数出错', 10, array());

            //插入评论
            $model = new BlogComment();
            $model->attributes = array(
                'fid' => $this->fid,
                'post_id' => $this->post_id,
                'user_id' => $this->user_id ? $this->user_id : 0,
                'username' => $this->username,
                'email' => $this->email,
                'time' => time(),
                'ip' => $app->request->getUserHostAddress(),
                'content' => $this->content,
            );
            if ($model->save() == false) throw new CDbException('插入评论出错', 10, $model->getErrors());

            $transaction->commit();
        } catch (CDbException $e) {
            $transaction->rollback();
            $this->addErrors($e->errorInfo);
            return false;
        }

        $post = BlogPost::model()->findByPk($this->post_id);
        Mail::quickSend('toruneko@outlook.com',
            $this->username . '在您的博客留下了足迹', $this->username .
            '在《' . $post->title . '》里留下了足迹：' . "\n\r" . $this->content);

        //发送邮件通知评论者
        if (!empty($this->fid)) {
            $comment = BlogComment::model()->findByPk($this->fid);
            if (!empty($comment) && !empty($comment->email)) {
                Mail::quickSend($comment->email,
                    $this->username . '回复了你的留言',
                    $this->username . '在《' . $post->title . '》[' . Yii::app()->createAbsoluteUrl(
                        'blog/post', array('id' => $this->post_id)
                    ) . '] 里回复了你的留言：' . "\n\r" . $this->content);
            }
        }

        return true;
    }
}