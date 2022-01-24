<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trvehicle-booking-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
			$id = Yii::app()->request->getQuery('id');
			/*echo $id;
			echo "<br>";*/
			$from = Yii::app()->request->getQuery('from');
			/*echo $from;
			echo "<br>";*/
			
			$to = Yii::app()->request->getQuery('to');
			/*echo $to;
			echo "<br>";*/
			
			$cv = Yii::app()->request->getQuery('cv');
			/*echo $cv;exit;
			echo "<br>";*/
		?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table >
	 <tr><td>
		<?php echo $form->labelEx($model,'Vehicle_No'); ?>
        </td><td>
        <?php echo $form->dropdownlist($model,'Vehicle_No',CHtml::listData(TRVehicleBooking::model()->getVehicleForAllocate($cv),'Vehicle_No','Vehicle_No'),array('width'=> '25', 'empty'=>'please select'));  ?>
		<?php echo $form->error($model,'Vehicle_No'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Driver_ID'); ?>
        </td><td>
        <?php echo $form->dropdownlist($model,'Driver_ID',CHtml::listData(TRVehicleBooking ::model()->findAll(),'Driver_ID','Full_Name'),array('width      	'=> '25', 'empty'=>'please select'));  ?>
		<?php echo $form->error($model,'Driver_ID'); ?>
        </td></tr>
	</div>

	<?php date_default_timezone_set('Asia/Colombo'); ?>

	<div class="row" >
     <tr  style="display:none"><td>
     
		<?php echo $form->labelEx($model,'Approved_By'); ?>
         </td><td>
		<?php  $id= Yii::app()->getModule('user')->user()->username;
				echo $form->textField($model,'Approved_By',array('value'=>''.$id.''),array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'Approved_By'); ?>
         </td></tr>
	</div>

	<div class="row">
     <tr  style="display:none"><td>
		<?php echo $form->labelEx($model,'Approved_Date'); ?>
         </td><td>
		<?php echo $form->textField($model,'Approved_Date',array('value'=>date("Y-m-d : H:i:s", time()))); ?>
		<?php echo $form->error($model,'Approved_Date'); ?>
         </td></tr>
	</div>


</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Approvel'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->