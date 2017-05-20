<?php
/**
 * File: friend.php
 * User: daijianhao@zhubajie.com
 * Date: 14-10-6 10:34
 * Description:
 */
$this->cs->registerScript('category', "
$('.table').on('click','tbody a',function(){
    if($(this).attr('target') == '_blank') return true;
    if($(this).attr('title') == '删除'){
        if(confirm('确定要删除此小屋吗？') == false) return false;
    }
    admin.hide('#content', 100, function(\$this){
        $.get(\$this.attr('href'),function(m){
            if(m.status){
                if(m.status == 200){
                    \$this.parent().parent().remove();
                }
                $.facebox(m.info);
            }else{
                $('#content').html(m);
            }
            admin.show('#content', 100);
        });
    }, $(this));
    return false;
});

$('#form').on('click', 'a', function(){
    var title = $(this).attr('title');
    console.log(title);
    if(title == '刷新缓存'){
        $.get($(this).attr('href'), function(m){
            $.facebox(m.info);
        });
    }else if(title == '添加'){
        $.post($(this).attr('href'), $('#form').serialize(), function(m){
            if(m.status){
                $.facebox(m.info);
            }else{
                $('#content').html(m);
            }
        });
    }
    return false;
});
", RedClientScript::POS_END);
?>
<script type="application/javascript">

</script>
<div class="panel panel-default">
    <div class="panel-heading">隔壁小屋</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'action' => $this->createUrl('content/friend'),
            'htmlOptions' => array(
                'class' => 'form-inline'
            )
        ));
        ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => 'key')) ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'value', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'value', array('class' => 'form-control', 'placeholder' => 'value')) ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::submitButton('搜索', array('class' => 'btn btn-default')); ?>
            <?php echo CHtml::link('添加', $this->createUrl('content/doFriend'), array('class' => 'btn btn-default', 'title' => '添加')); ?>
            <?php echo CHtml::link('刷新缓存', $this->createUrl('api/deleteMemcacheByKey') . '?key=' . $this->app->params['cache']['friend'],
                array('title' => '刷新缓存', 'class' => 'btn btn-default')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <td>key</td>
            <td>value</td>
            <td></td>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="3">
                <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $data,
            'itemView' => 'friendList',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
        </tbody>
    </table>
</div>