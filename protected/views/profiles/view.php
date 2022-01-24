<?php
$this->breadcrumbs=array(
	'Profiles'=>array('index'),
	$model->user_id,
);

$this->menu=array(
	array('label'=>'List Profiles', 'url'=>array('index')),
	array('label'=>'Create Profiles', 'url'=>array('create')),
	array('label'=>'Update Profiles', 'url'=>array('update', 'id'=>$model->user_id)),
	array('label'=>'Delete Profiles', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Profiles', 'url'=>array('admin')),
);
?>

<h1>View Profiles #<?php echo $model->user_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'lastname',
		'firstname',
	),
)); ?>
