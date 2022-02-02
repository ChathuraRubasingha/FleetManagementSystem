<?php
$this->breadcrumbs=array(
'Report'=>array('notificationConfiguration/report'),
	'Vehicle Inventory',
);?>
<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'householderListing-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),'htmlOptions'=>array('target'=>'_blank'))); 
		
	?>
<h1 >Vehicle Inventory</h1>
<div id="report_body" > 
    <div  class="group" style="width:600px; margin-left:180px"  > 
       
        <h2> Customizable Reports</h2>
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
            <br/>
            <u><h3>Columns to be displayed in the Report</h3> </u><br />
               
        <input type="checkbox" name='c1' value="check me 1" style="margin-left: 100px; width:26px" onclick="showMe('Citizen', this) " 
        <?php echo $name_text = isset($_REQUEST['c1']) ? 'checked':'';?> /> Statutory Requirements<p/>
         



         <br/>
           
               
        <input type="checkbox" name='c1' value="check me 1" style="margin-left: 100px; width:26px" onclick="showMe('Citizen', this) " 
        <?php echo $name_text = isset($_REQUEST['c1']) ? 'checked':'';?> /> Vehicle Information<p/> 


          <input type="checkbox" name='c1' value="check me 1" style="margin-left: 100px; width:26px" onclick="showMe('Citizen', this) " 
        <?php echo $name_text = isset($_REQUEST['c1']) ? 'checked':'';?> /> Service and Repair<p/>   



        <input type="checkbox" name='c1' value="check me 1" style="margin-left: 100px; width:26px" onclick="showMe('Citizen', this) " 
        <?php echo $name_text = isset($_REQUEST['c1']) ? 'checked':'';?> /> Other Information<p/>


            <div class="row buttons" style="margin-left:180px">
            <?php echo CHtml::submitButton('Preview'); ?>
            </div>
           </div>
    </div>
    
<?php $this->endWidget(); ?>
</div>	