<?php

/**
 * file:Controller.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc:控制器基类
 */
class Controller extends RedController
{
    public $name;
    public $keyword = array('toruneko', '特鲁尼克', '戴建豪', 'PHP', 'Java', '设计模式', 'OpenResty', 'Lua');
    public $description = '戴建豪(Toruneko)的博客.';

    public function init()
    {
        parent::init();

        $this->cs->registerPackage('bootstrap');
    }

    public function setName($name)
    {
        $this->name .= $name;
    }

    public function setKeyword($keyword)
    {
        $this->keyword[] = $keyword;
    }

    public function setDescription($desc)
    {
        $this->description = $desc;
    }

    public function getFilters()
    {
        return array(
            array('Server'),
        );
    }

    public function allowAjaxRequest()
    {
        return true;
    }

    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        $domain = $this->app->params['domain'];
        if (array_key_exists($route, $domain)) {
            return trim($this->app->createUrl(trim($domain[$route], '/'), $params, $ampersand), '/');
        }
        //return parent::createUrl($route, $params, $ampersand);

        if ($route === '')
            $route = $this->getId() . '/' . $this->getAction()->getId();
        elseif (strpos($route, '/') === false)
            $route = $this->getId() . '/' . $route;
        if ($route[0] !== '/' && ($module = $this->getModule()) !== null)
            $route = $module->getId() . '/' . $route;

        $url = $this->app->createAbsoluteUrl($route, $params, '', $ampersand);
        if (HOST == "www.toruneko.net") {
            $url = str_replace("www", "blog", $url);
        }
        return $url;
    }
}