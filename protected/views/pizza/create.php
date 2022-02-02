<?php
$this->breadcrumbs=array(
	'Pizzas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pizza', 'url'=>array('index')),
	array('label'=>'Manage Pizza', 'url'=>array('admin')),
);
?>

<h1>Create Pizza</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>