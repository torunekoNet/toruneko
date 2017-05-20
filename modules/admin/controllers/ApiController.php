<?php

/**
 * File: ApiController.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-14 13:16
 * Description:
 */
class ApiController extends Controller
{

    public function actionDeleteMemcacheByKey()
    {
        $key = $this->request->getQuery('key');
        if ($this->app->cache->delete($key)) {
            $this->response(200, '清除缓存成功');
        } else {
            $this->response(500, '清除缓存失败');
        }
    }
}