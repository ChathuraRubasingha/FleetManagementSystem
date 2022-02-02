<?php
/* @var $this MaLocationController */
/* @var $model MaLocation */
/* @var $form CActiveForm */
$AccessModule = new Access();
?>


<div class="form" style="padding-left:5px;">
<?php /*$form=$this->beginWidget('CActiveForm', array(       
'id'=>'ma-location-form',        
'enableAjaxValidation'=>true,        
'enableClientValidation'=>true,        
//'clientOptions' => array(                
//'validateOnSubmit'=>true,                
//'validateOnChange'=>true,                
//'validateOnType'=>false,        ),        
//'htmlOptions' => array('enctype'=>'multipart/form-data'),)

);
*/


?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-location-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php /*?><?php ?><div class="row">
		<?php echo $form->labelEx($model,'Provincial_Councils_ID'); ?>		
        <?php echo $form->dropdownlist($model,'Provincial_Councils_ID',CHtml::listData(MaProvincialCouncils::model()->findAll(),'Provincial_Councils_ID','Provincial_Councils_Name'),array('empty'=>'please select'));  
		 
		?>       
		<?php echo $form->error($model,'Provincial_Councils_ID'); ?>
	</div><?php ?><?php */?> 
    <table width="550" border="1">
    
    <div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'District_ID'); ?>
        </td>
         <td>
    <?php $Division = CHtml::listData(MaDistrict::model()->findAllDistricts(),'District_ID','District_Name');
                   echo $form->DropDownList($model,'District_ID',$Division,
                 array('ajax' =>
                    array(
					
                          'type'=>'POST', //request type
                          'url'=>CController::createUrl('MaDsDivision/DynamicDsDivisions'), //url to call.
                          'update'=>'#'.CHtml::activeId($model,'DS_Division_ID'),
                       
                         // 'data'=>'js:jQuery(this).serialize()'
                          ),
                    'empty'=>'--- Please Select ---', 'class'=>'midSelect')
                ); ?><!--<div id="MaDistrict">
    <?php /*echo CHtml::ajaxButton(Yii::t('MaDistrict',' '),$this->createUrl('maDistrict/addNew'),array(
        'onclick'=>'if (MaDistrictAjaxComplete) { $("#MaDistrictDialog").dialog("open"); return false; } else { MaDistrictAjaxComplete = true; }',
        'update'=>'#MaDistrictDialog'
        ),array('id'=>'showMaDistrictDialog', 'class'=>'addBtn', 'title'=>'Add New Item'));*/?>
    <div id="MaDistrictDialog"></div>
</div>-->


 <?php echo $form->error($model,'District_ID'); ?>
                    
</td>
        
        
       <!-- <td>
		 <?php //echo $form->dropdownlist($model,'District_ID',CHtml::listData(MaDistrict::model()->findAll(),'District_ID','District_Name'),array('empty'=>'--please select--'));  ?>

<?php /*$Division = CHtml::listData(MaDistrict::model()->findAll(),'District_ID','District_Name');
                   echo $form->DropDownList($model,'District_ID',$Division,
                 array('ajax' =>
                    array(
					
                          'type'=>'POST', //request type
                          'url'=>CController::createUrl('MaDsDivision/DynamicDsDivisions'), //url to call.
                          'update'=>'#'.CHtml::activeId($model,'DS_Division_ID'),
                       
                         // 'data'=>'js:jQuery(this).serialize()'
                          ),
                    'empty'=>'--- Please Select ---')
                );*/ ?>
 <?php //echo CHtml::dropDownList('GN_Division_ID','', array()); ?>
		<?php #echo $form->error($model,'District_ID'); ?>
        </td>--></tr>
	</div>
    


	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'DS_Division_ID'); ?>
        </td>
        <td> <div id="MaDsDivision">
    <?php echo $form->dropdownlist($model,'DS_Division_ID',array(),
          array('ajax' =>
                    array(
					
                          'type'=>'POST', //request type
                          'url'=>CController::createUrl('MaGnDivision/DynamicGnDivisions'), //url to call.
                          'update'=>'#'.CHtml::activeId($model,'GN_Division_ID'),
                       
                         // 'data'=>'js:jQuery(this).serialize()'
                          ),
                    'empty'=>'--- Please Select ---', 'class'=>'midSelect')
                );?>
    <?php echo CHtml::ajaxButton(Yii::t('MaDsDivision',' '),$this->createUrl('MaDsDivision/addNew'),array(
        'onclick'=>'if (MaDsDivisionAjaxComplete) { $("#MaDsDivisionDialog").dialog("open"); return false; } else { MaDsDivisionAjaxComplete = true; }',
        'update'=>'#MaDsDivisionDialog'
        ),array('id'=>'showMaDsDivisionDialog', 'class'=>'addBtn', 'title'=>'Add New Item'));?>
    <div id="MaDsDivisionDialog"></div>
</div>
 <?php echo $form->error($model,'DS_Division_ID'); ?>
                    
</td>
        
        
        <!--<td>
         <?php /*echo $form->dropdownlist($model,'DS_Division_ID',array(),
          array('ajax' =>
                    array(
					
                          'type'=>'POST', //request type
                          'url'=>CController::createUrl('MaGnDivision/DynamicGnDivisions'), //url to call.
                          'update'=>'#'.CHtml::activeId($model,'GN_Division_ID'),
                       
                         // 'data'=>'js:jQuery(this).serialize()'
                          ),
                    'empty'=>'--- Please Select ---')
                );*/ ?>
      
		<?php #echo $form->error($model,'DS_Division_ID'); ?>
        </td>--></tr>
	</div>



	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'GN_Division_ID'); ?>
        </td>
        <td> <div id="MaGnDivision">
    <?php echo $form->dropdownlist($model,'GN_Division_ID',array(),array('empty'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
    <?php echo CHtml::ajaxButton(Yii::t('MaDsDivision',' '),$this->createUrl('MaGnDivision/addNew'),array(
        'onclick'=>'if (MaGnDivisionAjaxComplete) { $("#MaGnDivisionDialog").dialog("open"); return false; } else { MaGnDivisionAjaxComplete = true; }',
        'update'=>'#MaGnDivisionDialog'
        ),array('id'=>'showMaGnDivisionDialog', 'class'=>'addBtn', 'title'=>'Add New Item'));?>
    <div id="MaGnDivisionDialog"></div>
</div>
 <?php echo $form->error($model,'GN_Division_ID'); ?>
                    
</td>
        
       <!-- <td>
		<?php /*?><?php echo $form->textField($model,'GN_Division_ID'); ?><?php */?>
        <?php //echo $form->dropdownlist($model,'GN_Division_ID',CHtml::listData(MaGnDivision::model()->findAll(),'GN_Division_ID','GN_Division'),array('empty'=>'-Please Select-'));  ?>
		<?php #echo $form->dropdownlist($model,'GN_Division_ID',array(),array('empty'=>'--- Please Select ---')); ?>
		<?php #echo $form->error($model,'GN_Division_ID'); ?>
       
        </td>--></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Location_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'Location_Name',array('size'=>50,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Location_Name'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Address'); ?>
        </td><td>
		<?php echo $form->textField($model,'Address',array('size'=>50,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Address'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Telephone'); ?>
        </td><td>
		<?php echo $form->textField($model,'Telephone',array('size'=>20,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Telephone'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Fax'); ?>
        </td><td>
		<?php echo $form->textField($model,'Fax',array('size'=>20,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Fax'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Email'); ?>
        </td><td>
		<?php echo $form->textField($model,'Email',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Email'); ?>
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

	<div class="row buttons" style="margin-left:80%;">
    
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaLocation','Create'),CHtml::normalizeUrl(array('MaLocation/addNew','render'=>false)),array('success'=>'js: function(data) 
		{
           	$("#TRVehicleLocation_Location_ID").append(data);
			$("#MaDriver_Location_ID").append(data);
			$("#VehicleTransfer_To_Location_ID").append(data);
			$("#MaLocationDialog").dialog("close");
		}'),array('id'=>'closeMaLocationDialog')); */
					?>
        
        <?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeMaLocationDialog').click(function()
			{
				$('#MaLocation_DS_Division_ID').focus();
				$('#MaLocation_GN_Division_ID').focus();
				$('#MaLocation_Location_Name').focus();
				$('#MaLocation_Address').focus();
				
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaLocation','Create'),CHtml::normalizeUrl(array('MaLocation/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#TRVehicleLocation_Location_ID").append(data);
			$("#MaDriver_Location_ID").append(data);
			$("#VehicleTransfer_To_Location_ID").append(data);
			$("#MaBranch_Location_ID").append(data);
			$("#MaLocationDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			$("#Location_Name").focus();                       
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaLocationDialog')); 
	 
	 ?>
        
        
        
        
        <!--$("#ma-location-form")[0].reset();-->
        
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaLocation','Create'),CHtml::normalizeUrl(array('MaLocation/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#TRVehicleLocation_Location_ID").append(data);
						$("#MaDriver_Location_ID").append(data);
						$("#VehicleTransfer_To_Location_ID").append(data);
					    $("#MaLocationDialog").dialog("close");
                    }'),array('id'=>'closeMaLocationDialog')); */
					?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->