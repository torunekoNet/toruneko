<?php

/**
 * File: DoFriendAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 10:50
 * Description:  增加隔壁小屋
 */
class DoFriendAction extends RedAction
{
    public function run()
    {
        $model = new Setting();

        if (($post = $this->request->getPost('Setting', false)) !== false) {
            $post['section'] = 'friendlink';
            $model->attributes = $post;
            if ($model->save()) {
                $this->response(200, '添加小屋成功');
            } else {
                $this->response(500, '添加小屋出错');
            }
        } else {
            $this->response(404, '参数出错');
        }
    }
}