<?php
$this->breadcrumbs=array(
	'Pizzas'=>array('index'),
	$model->pizza_id,
);

$this->menu=array(
	array('label'=>'List Pizza', 'url'=>array('index')),
	array('label'=>'Create Pizza', 'url'=>array('create')),
	array('label'=>'Update Pizza', 'url'=>array('update', 'id'=>$model->pizza_id)),
	array('label'=>'Delete Pizza', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pizza_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pizza', 'url'=>array('admin')),
);
?>

<h1>View Pizza #<?php echo $model->pizza_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pizza_id',
		'pizza_name',
		'pizza_type_id',
	),
)); ?>
