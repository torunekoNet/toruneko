<?php

/**
 * File: IndexAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/5 16:11
 * Description: 博客首页
 */
class IndexAction extends Action
{

    public function run()
    {
        $condition = 'post_state=0';
        $params = array();

        $this->search($condition, $params);
    }
}