<?php

/**
 * File: ContentController.php
 * User: daijianhao@zhubajie.com
 * Date: 14-8-18 11:44
 * Description: 内容管理
 */
class ContentController extends Controller
{

    public function getActions()
    {
        return array('blog', 'post', 'postDelete',
            'category', 'doCategory', 'categoryDelete',
            'friend', 'doFriend', 'friendDelete');
    }

    public function createSearchCriteria($data = array())
    {
        $condition = '';
        $params = array();
        if (!empty($data)) {
            $con = array();
            foreach ($data as $key => $value) {
                if (empty($value)) continue;
                $con[] = $key . '=:' . $key;
                $params[$key] = $value;
            }
            $condition = join(' AND ', $con);
        }
        return array('condition' => $condition, 'params' => $params);
    }
}