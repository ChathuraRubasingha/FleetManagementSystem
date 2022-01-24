<?php
$this->breadcrumbs=array(
	'Trservices',
);

$this->menu=array(
	array('label'=>'Create Services', 'url'=>array('create')),
	array('label'=>'Manage Services', 'url'=>array('admin')),
);
?>

<h1>services</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
