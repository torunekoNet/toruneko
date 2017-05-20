<?php
/**
 * File: blog.php
 * User: daijianhao@zhubajie.com
 * Date: 14-9-22 17:11
 * Description:
 */
$this->cs->registerScript('blog', "
$('.table').on('click','tbody a',function(){
    if($(this).attr('target') == '_blank') return true;
    var title = $(this).attr('title');
    if(title == '刷新缓存'){
        $.get($(this).attr('href'), function(m){
            $.facebox(m.info);
        });
        return false;
    }else if(title == '删除'){
        if(confirm('确定要删除此文章吗？') == false) return false;
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
    if(title == '刷新缓存'){
        $.get($(this).attr('href'), function(m){
            $.facebox(m.info);
        });
    }
    return false;
});
", RedClientScript::POS_END);
?>
<div class="panel panel-default">
    <div class="panel-heading">文章</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'action' => $this->createUrl('content/blog'),
            'htmlOptions' => array(
                'class' => 'form-inline'
            )
        ));
        ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'id', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'id', array('class' => 'form-control', 'placeholder' => '文章ID')) ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'username', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => '用户名')) ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'date', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'date', array('class' => 'form-control', 'placeholder' => '归档日期')) ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'category_id', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->dropDownList($model, 'category_id', $category, array('class' => 'form-control')) ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::submitButton('搜索', array('class' => 'btn btn-default')); ?>
            <?php echo CHtml::link('刷新首页缓存', $this->createUrl('api/deleteMemcacheByKey') . '?key=index',
                array('title' => '刷新缓存', 'class' => 'btn btn-default')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <td style="width: 5%">ID</td>
            <td style="width: 10%">发布者</td>
            <td>标题</td>
            <td style="width: 5%">分类</td>
            <td style="width: 5%">归档</td>
            <td style="width: 10%">发表时间</td>
            <td style="width: 10%">修改时间</td>
            <td style="width: 5%">状态</td>
            <td style="width: 5%">评论</td>
            <td style="width: 10%"></td>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="10">
                <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $data,
            'itemView' => 'blogList',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
        </tbody>
    </table>
</div>