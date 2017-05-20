<?php

/**
 * File: PostAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 10:25
 * Description: 发表博客
 */
class PostAction extends RedAction
{
    public function run()
    {
        $model = new PostForm();

        if (($post = $this->request->getPost('PostForm', false)) !== false) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->response(200, '更新文章成功');
                $this->app->end();
            }
        } elseif (($id = $this->request->getQuery('id', 0)) != false) {
            if (($blog = BlogPost::model()->findByPk($id)) != false) {
                $model->attributes = array(
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'abstract' => $blog->abstract,
                    'content' => $blog->content,
                    'category' => $blog->category_id,
                    'post_state' => $blog->post_state ? 0 : 1,
                    'comment_state' => $blog->comment_state ? 0 : 1,
                );
            }
        }

        $this->render('post', array(
            'model' => $model,
            'category' => BlogCategory::model()->renderDropDownList()
        ));
    }
}