<?php

/**
 * File: DoCategoryAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 10:29
 * Description: 添加分类标签
 */
class DoCategoryAction extends RedAction
{
    public function run()
    {
        $model = new BlogCategory();

        if (($post = $this->request->getPost('BlogCategory', false)) !== false) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->response(200, '添加类型成功');
            } else {
                $this->response(500, '添加类型出错');
            }
        } else {
            $this->response(404, '参数出错');
        }
    }
}