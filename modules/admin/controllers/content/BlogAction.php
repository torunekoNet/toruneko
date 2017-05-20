<?php

/**
 * File: BlogAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 10:29
 * Description: 博客列表
 */
class BlogAction extends RedAction
{
    public function run()
    {
        $query = $this->request->getPost('BlogPost', array());
        $model = BlogPost::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $condition['order'] = 'time desc';
        $data = $model->findAll($condition);
        $this->render('blog', array(
            'data' => new RedArrayDataProvider($data),
            'pager' => $pager,
            'model' => $model,
            'category' => BlogCategory::model()->renderDropDownList('选择'),
        ));
    }
}