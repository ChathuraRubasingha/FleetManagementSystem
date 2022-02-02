<?php
$this->breadcrumbs=array(
	'Manage'=>array('admin'),
	'View',

);

$this->menu=array(
	//array('label'=>'Repairs', 'url'=>array('index')),
	array('label'=>'Create Repairs', 'url'=>array('create')),
	//array('label'=>'Update Repairs', 'url'=>array('update', 'id'=>$model->Repairs_ID)),
	//array('label'=>'Delete Repairs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Repairs_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Repairs', 'url'=>array('admin')),
);
?>

<?php
  	$vehicleId = Yii::app()->session['vehicleId'];
?>

<div class="group">
<h1>Repairs Details</h1>
<div style="margin-left:-20px;">

<div class="classname" style="width:200px; height:28px; margin-left:200px; font-size:25px"><p align="center"><b><?php echo $vehicleId; ?></b></p></div>

<br/>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'Repairs_ID',
		//'Vehicle_No',
		'Total_Cost',
		'Repairs_Date',
		//'Garage_ID',
		array('label'=>'Garage Name', 'value'=>$model->garage->Garage_Name),
		'Repairs_Type_ID',
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
	),
)); ?></div>
</div>
