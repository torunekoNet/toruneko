<?php

/**
 * File: PostDeleteAction.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 10:26
 * Description: 删除博客
 */
class PostDeleteAction extends RedAction
{
    public function run($id)
    {
        $model = BlogPost::model()->findByPk($id);
        if ($model) {
            $transaction = $this->app->db->beginTransaction();
            try {
                //更新类型计数
                $res = BlogCategory::model()->updateCounters(array(
                    'post_count' => -1
                ), 'id=:i', array('i' => $model->category_id));
                if (!$res) throw new CDbException('更新类型计数出错', 10);
                //更新归档计数
                $res = BlogArchive::model()->updateCounters(array(
                    'post_count' => -1
                ), 'id=:i', array('i' => $model->date));
                if (!$res) throw new CDbException('更新归档计数出错', 20);
                //删除文章
                if (!$model->delete()) throw new CDbException('删除文章出错', 30);

                $transaction->commit();
                $this->response(200, '删除文章成功');
            } catch (CDbException $e) {
                $transaction->rollback();
                $this->response(500, $e->getMessage());
            }
        } else {
            $this->response(404, '不存在的文章');
        }
    }
}