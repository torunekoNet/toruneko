<?php

/**
 * File: TagAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/5 16:07
 * Description: 分类标签
 */
class TagAction extends Action
{

    public function run($id)
    {
        $condition = 'post_state=0 and category_id=:i';
        $params = array('i' => $id);

        $this->search($condition, $params);
    }
}