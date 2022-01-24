<?php
$this->breadcrumbs=array(
	'Pizzas'=>array('index'),
	$model->pizza_id=>array('view','id'=>$model->pizza_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pizza', 'url'=>array('index')),
	array('label'=>'Create Pizza', 'url'=>array('create')),
	array('label'=>'View Pizza', 'url'=>array('view', 'id'=>$model->pizza_id)),
	array('label'=>'Manage Pizza', 'url'=>array('admin')),
);
?>

<h1>Update Pizza <?php echo $model->pizza_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>