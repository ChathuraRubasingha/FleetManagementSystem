<?php
$this->breadcrumbs=array(
	'Pizza Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PizzaType', 'url'=>array('index')),
	array('label'=>'Manage PizzaType', 'url'=>array('admin')),
);
?>

<h1>Create PizzaType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>