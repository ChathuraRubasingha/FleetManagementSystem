

<?php $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime"); ?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-service-station-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <div class="formTable">
            
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Srvice_Station_Name'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Srvice_Station_Name',array('size'=>60,'maxlength'=>200)); ?>
                    <?php echo $form->error($model,'Srvice_Station_Name'); ?></div>
            </div>

            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Land_phone_No'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Land_phone_No',array('size'=>20,'maxlength'=>10)); ?>
                    <?php echo $form->error($model,'Land_phone_No'); ?>
                </div>
            </div>

            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Mobile_No'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Mobile_No',array('size'=>20,'maxlength'=>10)); ?>
                    <?php echo $form->error($model,'Mobile_No'); ?></div>
            </div>
	
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Fax'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Fax',array('size'=>20,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Fax'); ?></div>
            </div>

            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Contact_Person'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Contact_Person',array('size'=>60,'maxlength'=>100)); ?>
                    <?php echo $form->error($model,'Contact_Person'); ?></div>
            </div>

            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Registration_No'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Registration_No',array('size'=>60,'maxlength'=>50)); ?>
                    <?php echo $form->error($model,'Registration_No'); ?></div>
            </div>

            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Owner_Name'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Owner_Name',array('size'=>60,'maxlength'=>100)); ?>
                    <?php echo $form->error($model,'Owner_Name'); ?></div>
            </div>
	
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Email'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Email'); ?></div>
            </div>
	
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Address'); ?></div>
                <div class="tdTwo"><?php echo $form->textArea($model,'Address',array('rows'=>6, 'cols'=>56)); ?>
                    <?php echo $form->error($model,'Address'); ?></div>
            </div>
	
	<?php date_default_timezone_set('Asia/Colombo'); ?>

		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
		}
		 ?>

		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>$curDateTime));
		} else {
		echo $form->hiddenField($model,'add_date',array());	
		}
		?>
	
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));   	
		}
		?>

		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_date',array('value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_date',array('value'=>$curDateTime));
		}
		?>

    </table>

	<div class="row" style="padding-left:37%;font-weight:bold">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->