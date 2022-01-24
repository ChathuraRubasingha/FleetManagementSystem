<style type="text/css">

.add{
	margin-left:80%;
	float:left;
}

.manage{
	margin-left:90%px;
	
}
</style>


<?php
$this->breadcrumbs=array(
	'Manage'=>array('admin'),
	'Update',

);

/*$this->menu=array(
	//array('label'=>'Repair Details', 'url'=>array('index')),
	array('label'=>'Create Repair Details', 'url'=>array('create')),
	//array('label'=>'View Repair Details', 'url'=>array('view', 'id'=>$model->Repair_Details_ID)),
	array('label'=>'Manage Repair Details', 'url'=>array('admin')),
);*/
?>
<div class="group" style="width:75%; margin-left:30%">
        <div class="add">
			 <?php  echo  CHtml::link('<img src="images/add.png" style="height:50px; width="50px""  />',array('tRRepairDetails/create',"menuId"=>"maintenance"));?> 
		</div>
        <div class="manage">
			 <?php  #echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""  />',array('maVehicleRegistry/admin'));?> 
             <?php  echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""  />',array('tRRepairDetails/admin',"menuId"=>"maintenance"));?> 
		
        </div>
<h1>Update Repair Details</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>