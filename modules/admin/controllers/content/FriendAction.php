<?php

/**
 * File: FriendAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 10:32
 * Description: 隔壁小屋
 */
class FriendAction extends RedAction
{
    public function run()
    {
        $query = $this->request->getPost('Setting', array());
        $query['section'] = 'friendlink';
        $model = Setting::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $data = $model->findAll($condition);
        $this->render('friend', array(
            'data' => new RedArrayDataProvider($data),
            'pager' => $pager,
            'model' => $model,
        ));
    }
}