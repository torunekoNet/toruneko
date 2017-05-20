<?php
/**
 * File: contactBox.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/1/13 19:47
 * Description: 评论回复窗口
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'commentBox',
    'method' => 'post',
    'action' => $this->createUrl('blog/post', array('id' => $post->id)) . '#comment',
    'htmlOptions' => array(
        'class' => 'form-horizontal'
    )
)); ?>
    <div class="form-group" id="commentReply">
        <label class="col-md-2 control-label">回复</label>

        <div class="col-md-6">
            <input class="form-control" type="text" disabled="disabled">
            <?php echo $form->hiddenField($model, 'fid', array('value' => 0)); ?>
        </div>
        <div class="col-md-2">
            <?php echo CHtml::link('取消', '##', array('class' => 'btn btn-default cancel')); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'username', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-6">
            <?php echo $form->textField($model, 'username', array('class' => 'form-control')) ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($model, 'username'); ?></div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'email', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-6">
            <?php echo $form->textField($model, 'email', array('class' => 'form-control')) ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($model, 'email'); ?></div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'content', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-6">
            <?php echo $form->textArea($model, 'content', array('class' => 'form-control', 'style' => 'height:150px')) ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($model, 'content'); ?></div>
    </div>
    <div class="form-group">
        <?php if (false && CCaptcha::checkRequirements()) { ?>
            <?php echo $form->labelEx($model, 'verifyCode', array('class' => 'col-md-2 control-label')); ?>
            <div class="col-md-2">
                <?php $this->widget('CCaptcha', array(
                    'showRefreshButton' => false,
                    'clickableImage' => false,
                    'imageOptions' => array(
                        'height' => '34px',
                        'width' => '116px',
                        'id' => 'verifyCode'
                    ),
                )); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->textField($model, 'verifyCode', array('class' => 'form-control')) ?>
            </div>
        <?php } ?>
        <div class="col-md-offset-7 col-md-1">
            <?php echo CHtml::submitButton('提交', array('class' => 'btn btn-default')); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($model, 'verifyCode'); ?></div>
    </div>
<?php $this->endWidget(); ?>