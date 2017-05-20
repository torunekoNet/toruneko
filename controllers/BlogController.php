<?php

/**
 * file:SiteController.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc: 博客
 */
class BlogController extends Controller
{
    public function getActions()
    {
        return array(
            'index', 'post', 'date', 'tag', 'search', 'rss'
        );
    }

    public function init()
    {
        parent::init();

        $this->cs->registerPackage('blog');
    }

    public function search($condition, $params, $order = 'time desc')
    {
        $key = $this->request->getRequestUri();
        if (($res = $this->app->cache->get($key)) == false) {
            $pager = new CPagination(BlogPost::model()->count(array(
                'condition' => $condition,
                'params' => $params,
            )));
            $pager->setPageSize(8);
            $blog = BlogPost::model()->findAll(array(
                'condition' => $condition,
                'params' => $params,
                'order' => $order,
                'offset' => $pager->getOffset(),
                'limit' => $pager->getLimit(),
            ));
            $res = array('pager' => $pager, 'blog' => new RedArrayDataProvider($blog));

            $this->app->cache->set($key, $res, 3600);
        }

        $this->render('index', array(
            'archive' => new RedArrayDataProvider(BlogArchive::model()->renderArchive()),
            'category' => new RedArrayDataProvider(BlogCategory::model()->renderArchive()),
            'link' => new RedArrayDataProvider(Setting::model()->getFriendLink()),
            'blog' => $res['blog'],
            'pager' => $res['pager']
        ));
    }
}