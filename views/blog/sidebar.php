<?php
/**
 * File: sidebar.php
 * User: daijianhao@zhubajie.com
 * Date: 14/10/27 10:19
 * Description: 右侧边栏
 */
?>
<div class="col-md-3 blog-container-sidebar" id="sidebar">
    <div class="page-header">
        <span class="glyphicon glyphicon-chevron-up sidebar-toggle" for="#archive"></span>
        <h6>日期归档</h6>
    </div>
    <div class="list-group" id="archive">
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $archive,
            'viewTag' => 'blog/date',
            'itemView' => '/blog/sidebar/archives',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
    </div>
    <div class="page-header">
        <span class="glyphicon glyphicon-chevron-up sidebar-toggle" for="#category"></span>
        <h6>分类标签</h6>
    </div>
    <div class="list-group" id="category">
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $category,
            'viewTag' => 'blog/tag',
            'itemView' => '/blog/sidebar/archives',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
    </div>
    <div class="page-header">
        <span class="glyphicon glyphicon-chevron-up sidebar-toggle" for="#neighbor"></span>
        <h6>隔壁小屋</h6>
    </div>
    <div class="list-group" id="neighbor">
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $link,
            'itemView' => '/blog/sidebar/neighbor',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
    </div>
</div>