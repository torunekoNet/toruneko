<?php
/**
 * file:blog.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc:
 */
?>
<div class="page-header">
    <h2><a href="<?php echo $this->createUrl('blog/post', array('id' => $data->id)); ?>"><?php echo $data->title; ?></a>
    </h2>
</div>
<div class="panel">
    <div class="panel-body">
        <?php echo CHtml::encode($data->abstract); ?>
    </div>
    <div class="panel-footer">
        <span>这里<?php echo $data->comment_count ? '有' . $data->comment_count . '个' : '还没有'; ?>足迹</span>
        创建于：<?php echo date('Y-m-d', $data->time); ?>
        By <?php echo $data->username; ?>
    </div>
</div>
