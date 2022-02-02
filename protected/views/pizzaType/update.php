<?php
$this->breadcrumbs=array(
	'Pizza Types'=>array('index'),
	$model->pizza_type_id=>array('view','id'=>$model->pizza_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PizzaType', 'url'=>array('index')),
	array('label'=>'Create PizzaType', 'url'=>array('create')),
	array('label'=>'View PizzaType', 'url'=>array('view', 'id'=>$model->pizza_type_id)),
	array('label'=>'Manage PizzaType', 'url'=>array('admin')),
);
?>

<h1>Update PizzaType <?php echo $model->pizza_type_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>