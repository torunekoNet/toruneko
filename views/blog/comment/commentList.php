<?php
/**
 * File: commentList.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 21:31
 * Description: 留言列表
 */
?>
<li class="list-group-item">
    <div class="floor">
        <a name="comment<?php echo $data->id; ?>"></a>
        <span>#<?php echo $index + 1; ?></span>
    </div>
    <div class="nickname">
        <?php if ($viewTag == 0) { ?>
            <span>
    		<ul>
                <li><a class="commentReply"
                       href="<?php echo CHtml::encode($data->username); ?>#<?php echo $data->id; ?>">回复</a></li>
            </ul>
    	</span>
        <?php } ?>
        <?php echo date('Y-m-d H:i:s', $data->time) . ' ' . CHtml::encode($data->username); ?>
    </div>
    <div class="message"><?php echo CHtml::encode($data->content); ?></div>
    <div class="clear">
        <ul class="list-group">
            <?php $this->widget('red.zii.widget.RedListView', array(
                'dataProvider' => new RedArrayDataProvider($data->reply),
                'itemView' => '/blog/comment/replyList',
                'template' => '{items}',
                'emptyText' => '',
            )); ?>
        </ul>
    </div>
</li>