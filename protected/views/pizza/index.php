<?php
$this->breadcrumbs=array(
	'Pizzas',
);

$this->menu=array(
	array('label'=>'Create Pizza', 'url'=>array('create')),
	array('label'=>'Manage Pizza', 'url'=>array('admin')),
);
?>

<h1>Pizzas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
