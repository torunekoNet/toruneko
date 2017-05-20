<?php

/**
 * File: CategoryAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 10:28
 * Description: 分类标签列表
 */
class CategoryAction extends RedAction
{
    public function run()
    {
        $query = $this->request->getPost('BlogCategory', array());
        $model = BlogCategory::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $data = $model->findAll($condition);
        $this->render('category', array(
            'data' => new RedArrayDataProvider($data),
            'pager' => $pager,
            'model' => $model,
        ));
    }
}