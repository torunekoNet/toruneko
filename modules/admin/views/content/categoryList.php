<?php
/**
 * File: categoryList.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-5 21:42
 * Description:
 */
?>
<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->name; ?></td>
    <td><?php echo $data->post_count; ?></td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-search"></span>',
            $this->createUrl('content/blog', array('BlogPost[category_id]' => $data->id)),
            array('title' => '搜索')); ?>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-trash"></span>',
            $this->createUrl('content/categoryDelete', array('id' => $data->id)),
            array('title' => '删除')); ?>
    </td>
</tr>