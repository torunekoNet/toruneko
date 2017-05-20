<?php

/**
 * file:SiteController.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc: 主站
 */
class IndexController extends Controller
{

    public function init()
    {
        parent::init();

        $this->cs->registerPackage('blog');
    }

    public function actionIndex()
    {
        if (($post = $this->app->cache->get('index')) == false) {
            $post = BlogPost::model()->find(array(
                'condition' => 'post_state=0',
                'order' => 'time desc',
                'limit' => 1,
            ));

            $this->app->cache->set('index', $post, 3600);
        }

        $this->setDescription($post->abstract);
        $this->render('index', array(
            'archive' => new RedArrayDataProvider(BlogArchive::model()->renderArchive()),
            'category' => new RedArrayDataProvider(BlogCategory::model()->renderArchive()),
            'link' => new RedArrayDataProvider(Setting::model()->getFriendLink()),
            'post' => $post,
        ));
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        } else {
            $this->render('error');
        }
    }

    public function actionTest()
    {
        $hedaer = CJSON::encode($_SERVER);
        $content = file_get_contents("php://input");
        Yii::log($hedaer . "\n" . $content, CLogger::LEVEL_ERROR);
    }

    public function actionBaecheck()
    {
        Yii::app()->end();
    }
}