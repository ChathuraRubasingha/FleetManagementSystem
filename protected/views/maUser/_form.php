

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table width="550">
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Full_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'Full_Name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Full_Name'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Address'); ?>
        </td><td>
		<?php echo $form->textField($model,'Address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Address'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'NIC'); ?>
        </td><td>
		<?php echo $form->textField($model,'NIC',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'NIC'); ?>
        </td></tr>
	</div>

	 <div class="row">
     <tr><td>
       <?php  echo $form->labelEx($model,'Location_ID'); ?>
     </td><td>
       <?php echo $form->dropDownList($model, 'Location_ID', CHtml::listData(
    maLocation::model()->findAll(), 'Location_ID', 'Location_Name'),array('prompt' => 'Select Stream'));   ?>
       <?php echo $form->error($model,'Location_ID'); ?>
    </td></tr>
    </div>


	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Mobile'); ?>
        </td><td>
		<?php echo $form->textField($model,'Mobile',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Mobile'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Email'); ?>
        </td><td>
		<?php echo $form->textField($model,'Email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Email'); ?>
        </td></tr>
	</div>

	 <div class="row">
     <tr><td>
       <?php  echo $form->labelEx($model,'Designation_ID'); ?>
     </td><td>
       <?php echo $form->dropDownList($model, 'Designation_ID', CHtml::listData(
    maDesignation::model()->findAll(), 'Designation_ID', 'Designation'),array('prompt' => 'Select Location'));   ?>
       <?php echo $form->error($model,'Designation_ID'); ?>
    </td></tr>
    </div>

	

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'UserName'); ?>
        </td><td>
		<?php echo $form->textField($model,'UserName',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'UserName'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Password'); ?>
        </td><td>
		<?php echo $form->passwordField($model,'Password',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'Password'); ?>
        </td></tr>
	</div>

	<div class="row">
     <tr><td>
       <?php  echo $form->labelEx($model,'Role_ID'); ?>
     </td><td>
       <?php echo $form->dropDownList($model, 'Role_ID', CHtml::listData(
    role::model()->findAll(), 'Role_ID', 'Role'),array('prompt' => 'Select Role'));   ?>
       <?php echo $form->error($model,'Role_ID'); ?>
    </td></tr>
    </div>

	

	<?php date_default_timezone_set('Asia/Colombo'); ?>
	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
		}
		 ?>
	</div>

	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>date("Y-m-d : H:i:s", time())));
		} else {
		echo $form->hiddenField($model,'add_date',array());	
		}
		?>
	</div>
    
   <div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));   	
		}
		?>
	</div>

	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_date',array('value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_date',array('value'=>date("Y-m-d : H:i:s", time())));	
		}
		?>
	</div>
    <?php
	
	/*
    $controllers = array();
	$files = CFileHelper::findFiles(realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'controllers'));
	foreach($files as $file)
		{
			$filename = basename($file, '.php');
			if( ($pos = strpos($filename, 'Controller')) > 0)
				{
						$controllers[] = substr($filename, 0, $pos);
				}
		}
 echo $form->checkBoxList($model, 'edit_date',$controllers); */
//print_r($controllers);
?>
</table>
	<div class="row buttons" style="padding-left:75%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->