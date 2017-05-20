<?php
/**
 * file:index.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc: 首页
 */
$this->cs->registerScript('scrollOffset', "var offset = 20;");
?>
<div class="row">
    <div class="col-md-9 blog-container-list">
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $blog,
            'itemView' => '/blog/index/blogList',
            'template' => '{items}',
            'emptyText' => '',
        ));
        $this->widget('RedLinkPager', array('pages' => $pager)); ?>
    </div>
    <?php $this->renderPartial('sidebar', array(
        'archive' => $archive,
        'category' => $category,
        'link' => $link,
    )); ?>
</div>