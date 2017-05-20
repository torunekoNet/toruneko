<?php

/**
 * File: CategoryDeleteAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 10:27
 * Description: 删除分类标签
 */
class CategoryDeleteAction extends RedAction
{
    public function run($id)
    {
        $model = BlogCategory::model()->findByPk($id);
        if ($model) {
            if ($model->post_count > 0) {
                $this->response(500, '不能删除的类型');
            } elseif ($model->delete()) {
                $this->response(200, '删除成功');
            } else {
                $this->response(500, '删除失败');
            }
        } else {
            $this->response(404, '不存在的类型');
        }
    }
}