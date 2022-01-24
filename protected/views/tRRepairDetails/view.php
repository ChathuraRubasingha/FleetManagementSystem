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
	'View',

);

/*$this->menu=array(
	//array('label'=>'Repair Details', 'url'=>array('index')),
	array('label'=>'Create Repair Details', 'url'=>array('create')),
	//array('label'=>'Update Repair Details', 'url'=>array('update', 'id'=>$model->Repair_Details_ID)),
	//array('label'=>'Delete Repair Details', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Repair_Details_ID),'confirm'=>'Are you sure you want to delete this item?')),
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
<h1>View Repair Details</h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'Repair_Details_ID',
		//'Repairs_ID',
		//'Description',
		//'Replacement_ID',
			array('label'=>'Replacement', 'value'=>$model->replacement->Replacement),
		'Approved_By',
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
	),
)); ?>
</div>
