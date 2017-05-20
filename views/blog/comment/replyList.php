<?php
/**
 * File: replyList.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/1/13 22:03
 * Description: 回复列表
 */
?>
<li class="list-group-item">
    <div class="nickname"><?php echo date('Y-m-d H:i:s', $data->time) . ' ' . CHtml::encode($data->username); ?></div>
    <div class="message"><?php echo CHtml::encode($data->content); ?></div>
</li>