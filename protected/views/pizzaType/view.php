<?php
$this->breadcrumbs=array(
	'Pizza Types'=>array('index'),
	$model->pizza_type_id,
);

$this->menu=array(
	array('label'=>'List PizzaType', 'url'=>array('index')),
	array('label'=>'Create PizzaType', 'url'=>array('create')),
	array('label'=>'Update PizzaType', 'url'=>array('update', 'id'=>$model->pizza_type_id)),
	array('label'=>'Delete PizzaType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pizza_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PizzaType', 'url'=>array('admin')),
);
?>

<h1>View PizzaType #<?php echo $model->pizza_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pizza_type_id',
		'pizza_type',
		'pizza_price',
	),
)); ?>
