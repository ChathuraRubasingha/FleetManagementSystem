<?php
$this->breadcrumbs=array(
	'Pizza Types',
);

$this->menu=array(
	array('label'=>'Create PizzaType', 'url'=>array('create')),
	array('label'=>'Manage PizzaType', 'url'=>array('admin')),
);
?>

<h1>Pizza Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
