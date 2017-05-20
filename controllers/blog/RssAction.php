<?php

/**
 * File: RssAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/2/15 18:20
 * Description: RSS
 */
class RssAction extends Action
{

    public function run()
    {
        if (($res = $this->app->cache->get('feed')) == false) {
            $blog = BlogPost::model()->findAll(array(
                'condition' => 'post_state=0',
                'order' => 'time desc',
                'limit' => 10,
            ));

            $res = $this->getRssString($blog, time());
            $this->app->cache->set('feed', $res, 3600);
        }

        header('Content-type: text/xml');
        echo $res;
    }

    private $rssTpl = <<<RSS
<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
<title type="text"><![CDATA[title]]></title>
<updated><![CDATA[updated]]></updated>
<author><![CDATA[author]]></author>
<generator>blog.toruneko.net</generator>
<![CDATA[item]]>
</feed>
RSS;

    private $rssHodler = array(
        '<![CDATA[title]]>',
        '<![CDATA[updated]]>',
        '<![CDATA[author]]>',
        '<![CDATA[item]]>'
    );

    private $rssItemTpl = <<<RSSITEM
<item><id><![CDATA[id]]></id>
<title><![CDATA[title]]></title>
<summary><![CDATA[summary]]></summary>
<published><![CDATA[published]]></published>
<updated><![CDATA[updated]]></updated>
<category><![CDATA[category]]></category>
<link><![CDATA[link]]></link>
</item>
RSSITEM;

    private $rssItemHolder = array(
        '<![CDATA[id]]>',
        '<![CDATA[title]]>',
        '<![CDATA[summary]]>',
        '<![CDATA[published]]>',
        '<![CDATA[updated]]>',
        '<![CDATA[category]]>',
        '<![CDATA[link]]>'
    );

    private function getRssString($blog, $time)
    {
        $data = array();
        foreach ($blog as $item) {
            $data[] = str_replace($this->rssItemHolder, array(
                $item->id,
                $item->title,
                CHtml::encode($item->abstract),
                date('Y-m-d H:i:s', $item->time),
                date('Y-m-d H:i:s', $item->modified_time),
                $item->category_name,
                $this->createUrl('blog/post', array('id' => $item->id))
            ), $this->rssItemTpl);
        }

        return str_replace($this->rssHodler, array(
            $this->app->name,
            date('Y-m-d H:i:s', $time),
            'Toruneko',
            join('', $data)
        ), $this->rssTpl);
    }
}