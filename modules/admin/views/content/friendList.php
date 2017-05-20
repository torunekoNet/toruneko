<?php
/**
 * File: friendList.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 10:36
 * Description:
 */
?>
<tr>
    <td><?php echo $data->name; ?></td>
    <td><?php echo $data->value; ?></td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-trash"></span>',
            $this->createUrl('content/friendDelete', array('name' => $data->name)),
            array('title' => '删除')); ?>
    </td>
</tr>