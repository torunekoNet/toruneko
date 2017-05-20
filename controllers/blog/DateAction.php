<?php

/**
 * File: DateAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/5 16:08
 * Description: 归档日期
 */
class DateAction extends Action
{

    public function run($id)
    {
        $condition = 'post_state=0 and date=:d';
        $params = array('d' => $id);

        $this->search($condition, $params);
    }
}