<style type="text/css">

.manage{
	margin-left:94.4%;
	margin-top:-8.6px;
}


</style>

<?php
$this->breadcrumbs=array(
	'Repair Details'=>array('admin'),
	'Add Repair Details',
);

/*$this->menu=array(
	//array('label'=>'Repair Details', 'url'=>array('index')),
	#array('label'=>'Manage Repair Details', 'url'=>array('admin')),
);*/
?>

<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
?>

<div class="group" style="width:20%; height:250px; float:left; margin-left:3%; margin-top:2.4%">
    <div id="menu"  style="width:20%; float:left; padding-left:2%; padding-top:2%;">
    
        <ul>
            <li><?php echo CHtml::link('Back to main',array('maVehicleRegistry/maintanenceview&id='.$vehicleId)); ?></li>
            <li><?php echo CHtml::link('New Repair Request',array('/tRRepairRequest/create')); ?></li>           
            <li><?php echo CHtml::link('Estimate Repair Requests',array('/tRRepairRequest/admin')); ?></li>
            <!-- <li><?php #echo CHtml::link('Approve Repair Estimate',array('/tRRepairEstimateDetails/estimate')); ?></li>-->           
            <li><?php echo CHtml::link('Add Repair Details',array('/tRRepairEstimateDetails/approvedEstimates')); ?></li>           
            <li><?php echo CHtml::link('Pending Repair Details',array('/tRRepairEstimateDetails/pendingRepairDetails')); ?></li>
            <li><?php echo CHtml::link('Approved Repair Details',array('/tRRepairEstimateDetails/approvedRepairDetails')); ?></li>
            <li><?php echo CHtml::link('Disapproved Repair Details',array('/tRRepairEstimateDetails/disapprovedRepairDetails')); ?></li>
            <li><?php echo CHtml::link('Rejected Repair Details',array('/tRRepairEstimateDetails/rejectedRepairDetails')); ?></li>
            <li><?php echo CHtml::link('Completed Repair Details',array('/tRRepairEstimateDetails/completedRepairDetails')); ?></li>
        </ul>
    
    </div>
</div>


<div  style="width:90%; float:left; ">
    <div class="group" style="padding-left:4%; margin-left:33%; margin-top:-32.9%">   <div class="manage">
             <?php  echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""  />',array('tRRepairDetails/admin',"menuId"=>"maintenance"));?> 	
        </div>
<h1>Add Repair Details</h1>

<div class="classname" style="width:200px; height:28px; margin-left:270px; margin-bottom:50px; font-size:25px">
	<p align="center"><b><?php echo $vehicleId; ?></b></p>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div></div>