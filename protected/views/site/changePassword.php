<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'changePassword-form',
//    'inlineErrors' => true,
//    'enableAjaxValidation'=>true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ), 'htmlOptions' => array('enctype' => 'multipart/form-data'),));
?>

<div class="group" style="width:10.5%; margin-left:2%; float:left; margin-top:2.8%">
    <div class="form">
        <p class="note">Field with <span class="required">*</span> is required.</p>


        <div class="row">
            <?php echo $form->labelEx($model, 'currentPassword'); ?>
        </div>
        <div class="row">
            <?php echo $form->passwordField($model, 'currentPassword', array('autofill' => 'false')); ?>
            <?php echo $form->error($model, 'currentPassword'); ?>

        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'newPassword'); ?>
        </div>
        <div class="row">
            <?php echo $form->passwordField($model, 'newPassword'); ?>
            <?php echo $form->error($model, 'newPassword'); ?>

        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'newPassword_repeat'); ?>
        </div>
        <div class="row">
            <?php echo $form->passwordField($model, 'newPassword_repeat'); ?>
            <?php echo $form->error($model, 'newPassword_repeat'); ?>

        </div>
        <div class="row buttons" >
            <?php echo CHtml::submitButton('Submit'); ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>
</div>

