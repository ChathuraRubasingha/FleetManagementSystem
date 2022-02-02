	<?php
/* @var $this MaDsDivisionController */
/* @var $model MaDsDivision */
/* @var $form CActiveForm */
?>


<div class="form" id="MaDsDivisionDialogForm">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-ds-division-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>
<?php /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-ds-division-form',
	'enableAjaxValidation'=>false,
));*/ ?>
<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550">
	<div class="row">
 		<tr><td width="160px">
		<?php echo $form->labelEx($model,'District_ID'); ?>
        </td>
       <!-- <td> <div id="MaDistrict">
    <?php echo $form->dropDownList($model,'District_ID',CHtml::listData(MaDistrict::model()->findAll(),'District_ID','District_Name'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
    <?php echo CHtml::ajaxButton(Yii::t('MaDistrict',' '),$this->createUrl('MaDistrict/addNew'),array(
        'onclick'=>'if (MaDistrictAjaxComplete) { $("#MaDistrictDialog").dialog("open"); return false; } else { MaDistrictAjaxComplete = true; }',
        'update'=>'#MaDistrictDialog'
        ),array('id'=>'showMaDistrictDialog'));?>
        
    <div id="MaDistrictDialog"></div>
</div>


 <?php echo $form->error($model,'District_ID'); ?>
                    
</td>-->
        <td>
		<?php #echo $form->textField($model,'District_ID'); ?>
        <?php 
		
		
$dist = Yii::app()->session["district"];
/*if (isset($_POST['answers'])) { 
   //$dist = $_POST['answers']; 
}else{ 
   die('error'); 
}
if ($dist != '')
{
	*/
	#echo $form->dropdownlist($model,'District_ID',CHtml::listData(MaDistrict::model()->findAll(),'District_ID','District_Name'),array('empty'=>'--please select--')); 
	
	//echo $dist;exit;
	echo $form->dropdownlist($model,'District_ID',CHtml::listData(MaDistrict::model()->findAllDistricts(),'District_ID','District_Name'),array('empty'=>'--- Please Select ---', 'options'=>array($dist=>Array('selected'=>'selected')))); 
/*}
else
{
	#echo $form->dropdownlist($model,'District_ID',CHtml::listData(MaDistrict::model()->findAll(),'District_ID','District_Name'),array('empty'=>'--- Please Select ---')); 
}*/

	
    
     ?>
		<?php echo $form->error($model,'District_ID'); ?>
        </td></tr>
	</div>
    
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'DS_Division'); ?>
        </td><td>
		<?php echo $form->textField($model,'DS_Division',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'DS_Division'); ?>
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
    </table>

	<div class="row buttons" style="margin-left:67%;">
		 <?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeMaDsDivisionDialog').click(function()
			{
				$('#MaDsDivision_DS_Division').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaDsDivision','Create'),CHtml::normalizeUrl(array('MaDsDivision/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			  $("#MaGnDivision_DS_Division_ID").append(data);
			  $("#MaLocation_DS_Division_ID").append(data);
			  $("#MaDsDivisionDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			                    
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaDsDivisionDialog')); 
	 
	 ?>
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaDsDivision','Create'),CHtml::normalizeUrl(array('MaDsDivision/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaGnDivision_DS_Division_ID").append(data);
						$("#MaLocation_DS_Division_ID").append(data);
						
                        $("#MaDsDivisionDialog").dialog("close");
                    }'),array('id'=>'closeMaDsDivisionDialog'));*/ ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->