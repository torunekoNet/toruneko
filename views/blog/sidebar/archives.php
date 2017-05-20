<?php
/**
 * file:archives.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc:
 */
?>
<a href="<?php echo $this->createUrl($viewTag, array('id' => $data->id)); ?>" class="list-group-item">
    <span class="badge"><?php echo $data->post_count; ?></span>
    <?php echo $data->name; ?>
</a>