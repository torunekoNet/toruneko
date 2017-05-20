<?php

/**
 * File: PostFrom.php
 * User: daijianhao@zhubajie.com
 * Date: 14-9-22 14:56
 * Description: 文章表单
 */
class PostForm extends CFormModel
{
    public $id;
    public $title;
    public $abstract;
    public $content;
    public $category;
    public $post_state;
    public $comment_state;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('title', 'required', 'message' => '请输入' . $labels['title']),
            array('abstract', 'required', 'message' => '请输入' . $labels['abstract']),
            array('content', 'required', 'message' => '请输入' . $labels['content']),
            array('category', 'required', 'message' => '请选择' . $labels['category']),
            array('post_state, comment_state, id', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'title' => '标题',
            'abstract' => '摘要',
            'content' => '内容',
            'category' => '类型',
            'post_state' => '是否直接发表',
            'comment_state' => '是否允许评论'
        );
    }

    public function save()
    {
        $app = Yii::app();
        $user = $app->user;
        $time = time();
        $date = date('Ym', $time);

        $transaction = $app->db->beginTransaction();
        try {
            if (!$this->validate()) throw new CDbException('参数出错', 0, array());
            if ($this->id) {
                $blog = BlogPost::model()->findByPk($this->id);
                //合法性验证
                if (!$blog) throw new CDbException('参数出错', 1, array());
            } else {
                $blog = new BlogPost();
            }
            $category = BlogCategory::model()->findByPk($this->category);
            //更新旧category
            if ($blog->category_id && $blog->category_id != $category->id) {
                $res = BlogCategory::model()->updateCounters(array(
                    'post_count' => -1
                ), 'id=:i', array('i' => $blog->category_id));
                if (!$res) throw new CDbException('更新类型出错', 10, array());
            }
            //更新新category
            if (empty($blog->category_id) || $blog->category_id != $category->id) {
                $category->post_count += 1;
                if ($category->save() === false)
                    throw new CDbException('更新类型出错', 11, $category->getErrors());
            }

            //更新post
            if ($this->id) {
                $attributes = array(
                    'modified_time' => $time,
                );
            } else {
                //更新archive
                if (!($archive = BlogArchive::model()->findByPk($date))) {
                    $archive = new BlogArchive();
                    $archive->attributes = array(
                        'id' => $date,
                        'name' => date('Y年n月', $time),
                        'post_count' => 1
                    );
                    if ($archive->save() === false) throw new CDbException('更新归档出错', 20, $archive->getErrors());
                } else {
                    $archive->post_count += 1;
                    if ($archive->save() === false) throw new CDbException('更新归档出错', 21, $archive->getErrors());
                }
                $attributes = array(
                    'user_id' => $user->getState('id', 0),
                    'username' => $user->getState('nickname', '匿名'),
                    'time' => $time,
                    'date' => $archive->id,
                    'comment_count' => 0,
                );
            }
            $attributes = array_merge($attributes, array(
                'title' => $this->title,
                'abstract' => $this->abstract,
                'content' => $this->content,
                'category_id' => $category->id,
                'category_name' => $category->name,
                'post_state' => $this->post_state ? 0 : 1,
                'comment_state' => $this->comment_state ? 0 : 1,
            ));
            $blog->attributes = $attributes;
            if ($blog->save() === false) throw new CDbException('更新文章出错', 30, $blog->getErrors());

            $transaction->commit();
        } catch (CDbException $e) {
            $transaction->rollback();
            $this->addErrors($e->errorInfo);
            return false;
        }

        //前端可见时，加入爬虫队列
        if ($blog->post_state == 0) {
            $queue = Yii::app()->getComponent('queue');
            if (!empty($queue)) {
                $queue->addTask('/queue/update?id=' . $blog->id);
                $queue->push();
            }
        }

        return true;
    }
}
