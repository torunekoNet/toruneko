<?php

/**
 * File: PostAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/5 16:09
 * Description: 博客最终页
 */
class PostAction extends Action
{

    public function run($id)
    {
        $next = BlogPost::model()->find(array(
            'condition' => 'id<:id and post_state=0',
            'params' => array('id' => $id),
            'order' => 'time desc',
            'limit' => 1
        ));
        $prev = BlogPost::model()->find(array(
            'condition' => 'id>:id and post_state=0',
            'params' => array('id' => $id),
            'order' => 'time asc',
            'limit' => 1
        ));
        $key = $this->request->getRequestUri();
        if (($post = $this->app->cache->get($key)) == false) {
            $post = BlogPost::model()->findByPk($id);

            $this->app->cache->set($key, $post);
        }
        if (!$post) throw new CHttpException(404, '找不到该文章');
        if ($this->user->isGuest && $post->post_state != 0) {
            throw new CHttpException(404, '找不到该文章');
        }

        $model = new ContactForm();
        if ($post->comment_state == 0 && ($data = $this->request->getPost('ContactForm', false)) != false) {
            $data['post_id'] = $id;
            $model->attributes = $data;
            if ($model->validate() && $model->save()) {
                $model = new ContactForm();
            }
        }

        $pager = new CPagination(BlogComment::model()->count('post_id=' . $id . ' and fid=0 and approved>0'));
        $pager->setPageSize(10);
        $comment = BlogComment::model()->with('reply')->findAll(array(
            'condition' => 'post_id=' . $id . ' and fid=0 and approved>0',
            'order' => 'time asc',
            'offset' => $pager->getOffset(),
            'limit' => $pager->getLimit(),
        ));

        $this->setName($post->title . ' | ');
        $this->setDescription($post->abstract);
        $this->render('blog', array(
            'post' => $post,
            'next' => $next === null ? $id : $next->id,
            'prev' => $prev === null ? $id : $prev->id,
            'archive' => new RedArrayDataProvider(BlogArchive::model()->renderArchive()),
            'category' => new RedArrayDataProvider(BlogCategory::model()->renderArchive()),
            'link' => new RedArrayDataProvider(Setting::model()->getFriendLink()),
            'comment' => new RedArrayDataProvider($comment),
            'pager' => $pager,
            'model' => $model,
        ));
    }
}