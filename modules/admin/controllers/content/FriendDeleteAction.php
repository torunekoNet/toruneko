<?php

/**
 * File: FriendDeleteAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 11:00
 * Description: 删除隔壁小屋
 */
class FriendDeleteAction extends RedAction
{
    public function run($name)
    {
        $model = Setting::model()->find('section=:sec and name=:name', array(
            'sec' => 'friendlink', 'name' => $name
        ));
        if ($model) {
            if ($model->delete()) {
                $this->response(200, '删除成功');
            } else {
                $this->response(500, '删除失败');
            }
        } else {
            $this->response(404, '不存在的小屋');
        }
    }
}