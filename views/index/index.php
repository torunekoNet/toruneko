<?php
/**
 * File: index.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/20 23:50
 * Description: 首页
 */
$this->cs->registerPackage('prettify');
$this->cs->registerScript('run_prettify', 'prettyPrint();');
$this->cs->registerScript('scrollOffset', "var offset = 40;");
?>
<div class="row">
    <h1></h1>

    <div class="col-md-9 blog-container-content">
        <div class="page-header">
            <h2>
                <a href="<?php echo $this->createUrl('blog/post', array('id' => $post->id)); ?>">
                    <?php echo $post->title; ?>
                </a>
            </h2>
        </div>
        <div class="panel">
            <div class="panel-body">
                <!--<pre><?php echo CHtml::encode($post->abstract); ?></pre>-->
                <?php echo $post->content; ?>
                <?php $url = $this->createUrl('blog/post', array('id' => $post->id)); ?>
                <p>本文地址：<a href="<?php echo $url; ?>"><?php echo $url; ?></a></p>
            </div>
        </div>
    </div>
    <?php $this->renderPartial('/blog/sidebar', array(
        'archive' => $archive,
        'category' => $category,
        'link' => $link,
    )); ?>
</div>