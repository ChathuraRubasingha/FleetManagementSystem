<?php
$this->breadcrumbs=array(
'Report'=>array('notificationConfiguration/report'),
	'Regulatory Requirments',
);?>
<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'householderListing-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),'htmlOptions'=>array('target'=>'_blank'))); 
		
	?>
<div id="report_body" > 
    <div  class="group" style="width:600px; margin-left:180px"  > 
       
        <h2>Regulatory Requirements Pending List </h2>
     </div>
     <div  class="group" style="width:600px; margin-left:180px" >

        
         
           <div class="row">
               
                  <?php echo $form->labelEx($modelvl,'Location_ID'); ?>
                 <?php echo $form->dropDownList($modelvl, 'Location_ID',CHtml::listData(MaLocation::model()->findAll(),'Location_ID','Location_Name'),array('empty'=>' Please Select ')
                );?>
                <?php echo $form->error($modelvl,'Location_ID'); ?>
                
            </div>
            <div class="row">
                 <?php echo $form->label($modelvc,'Vehicle_Category_ID'); ?>
                 <?php echo $form->dropdownlist($modelvc,'Vehicle_Category_ID',CHtml::listData(VehicleCategory::model()->findAll(),'Vehicle_Category_ID','Category_Name'),array('empty'=>' Please Select ')); ?>
            <?php echo $form->error($modelvc,'Vehicle_Category_ID'); ?>
               
            </div>
         
         

            <div class="row buttons" style="margin-left:180px">
            <?php echo CHtml::submitButton('Preview'); ?>
            </div>
           </div>
    </div>
    
<?php $this->endWidget(); ?>
</div>	