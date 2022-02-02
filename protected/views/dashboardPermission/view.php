<?php
$this->breadcrumbs=array(
	'Dashboard Permissions'=>array('index'),
	$model->ID,
);

$this->menu=array(
	array('label'=>'List DashboardPermission', 'url'=>array('index')),
	array('label'=>'Create DashboardPermission', 'url'=>array('create')),
	array('label'=>'Update DashboardPermission', 'url'=>array('update', 'id'=>$model->ID)),
	array('label'=>'Delete DashboardPermission', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DashboardPermission', 'url'=>array('admin')),
);
?>

<h1>View DashboardPermission #<?php echo $model->ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ID',
		'Role_ID',
		'Dashboard_Item_ID',
	),
)); ?>
