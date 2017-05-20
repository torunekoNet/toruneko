<?php
/**
 * File: blogList.php
 * User: daijianhao@zhubajie.com
 * Date: 14-9-22 17:18
 * Description:
 */
?>
<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->username; ?></td>
    <td><?php echo $data->title; ?></td>
    <td><?php echo $data->category_name; ?></td>
    <td><?php echo $data->date; ?></td>
    <td><?php echo date('Y-m-d H:i', $data->time); ?></td>
    <td><?php echo $data->modified_time ? date('Y-m-d H:i', $data->modified_time) : '未修改'; ?></td>
    <td><?php echo $data->post_state ? '不显示' : '显示' ?></td>
    <td><?php echo $data->comment_state ? '关闭' : '开启' ?></td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-refresh"></span>',
            $this->createUrl('api/deleteMemcacheByKey') . '?key=' . $this->createUrl('/blog/post', array('id' => $data->id)),
            array('title' => '刷新缓存')); ?>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-search"></span>',
            $this->createUrl('/blog/post', array('id' => $data->id)),
            array('title' => '前台查看', 'target' => '_blank')); ?>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-edit"></span>',
            $this->createUrl('content/post', array('id' => $data->id)),
            array('title' => '编辑')); ?>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-trash"></span>',
            $this->createUrl('content/postDelete', array('id' => $data->id)),
            array('title' => '删除')); ?>
    </td>
</tr>