<?php

/**
 * File: Server.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/29 00:46
 * Description: 域名控制
 */
class Server extends CFilter
{

    protected function preFilter($filterChain)
    {
        if (HOST == "www.toruneko.net") {
            $controller = $filterChain->controller;
            $action = $controller->getAction();
            if ($controller->getId() != 'index') {
                $app = $controller->app;
                $url = $app->createAbsoluteUrl($controller->getId() . '/' . $action->getId(), $_GET);
                $url = str_replace("www", "blog", $url);
                $app->request->redirect($url);
            }
        }
        return true;
    }
}