<?php

/**
 * File: SearchAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/5 16:10
 * Description: 站内搜索
 */
class SearchAction extends Action
{

    public function run($kw)
    {
        $engine = $this->app->getComponent('search');
        if (empty($engine)) {
            $this->searchFromDefault($kw);
        } else {
            $this->searchFromEngine($kw, $engine);
        }
    }

    public function searchFromEngine($kw, $engine)
    {
        $meta = $engine->createSearchQuery($kw); //创建搜索元数据
        $search = $engine->search($meta); //送入检索
        if (empty($search)) {
            $condition = "post_state=0";
            $order = 'time desc';
        } else {
            $search = $search['keys'];
            $condition = "id IN (" . join(',', $search) . ") AND post_state=0";
            $order = "FIND_IN_SET(id, '" . join(',', $search) . "')";
        }
        $params = array();

        $this->search($condition, $params, $order);
    }

    public function searchFromDefault($kw)
    {
        $condition = "post_state=0 and content like '%" . $kw . "%'";
        $params = array();

        $this->search($condition, $params);
    }
}