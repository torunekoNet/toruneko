<?php
/**
 * File: post.php
 * User: daijianhao@zhubajie.com
 * Date: 14-9-22 11:39
 * Description:
 */
$this->cs->registerScript('post', "
var editor = KindEditor.create('#post_content',{
    resizeType : 0,
    width : '100%',
    height : '400px',
    uploadJson: '" . $this->createUrl('upload/file') . "',
    afterBlur:function(){this.sync();}
})
", RedClientScript::POS_END);
?>
<div class="panel panel-default">
    <div class="panel-heading">发表</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'action' => $this->createUrl('content/post'),
            'htmlOptions' => array(
                'class' => 'form-horizontal'
            )
        )); ?>
        <?php echo $form->hiddenField($model, 'id'); ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'title', array('class' => 'col-md-1 control-label')); ?>
            <div class="col-md-9">
                <?php echo $form->textField($model, 'title', array('class' => 'form-control')) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'title'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'abstract', array('class' => 'col-md-1 control-label')); ?>
            <div class="col-md-9">
                <?php echo $form->textArea($model, 'abstract', array('class' => 'form-control', 'height' => '200')) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'abstract'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'content', array('class' => 'col-md-1 control-label')); ?>
            <div class="col-md-9">
                <?php echo $form->textArea($model, 'content', array('class' => 'form-control', 'id' => 'post_content')) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'content'); ?></div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'category', array('class' => 'col-md-1 control-label')); ?>
            <div class="col-md-2">
                <?php echo $form->dropDownList($model, 'category', $category, array('class' => 'form-control')) ?>
            </div>
            <div class="col-md-2">
                <div class="checkbox">
                    <label>
                        <?php echo $form->checkBox($model, 'post_state'); ?>
                        <?php echo $form->label($model, 'post_state', array('style' => 'padding-left:0')); ?>
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="checkbox">
                    <label>
                        <?php echo $form->checkBox($model, 'comment_state'); ?>
                        <?php echo $form->label($model, 'comment_state', array('style' => 'padding-left:0')); ?>
                    </label>
                </div>
            </div>
            <div class="col-md-1">
                <?php echo CHtml::submitButton('发表', array('class' => 'btn btn-default')); ?>
            </div>
            <div class="col-md-1">
                <?php echo CHtml::resetButton('重置', array('class' => 'btn btn-default')); ?>
            </div>
            <div class="col-md-offset-1 col-md-2">
                <?php echo $form->error($model, 'category'); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>