<?php
$this->breadcrumbs=array(
	'Ma Makes',
);

$this->menu=array(
	array('label'=>'Create MaMake', 'url'=>array('create')),
	array('label'=>'Manage MaMake', 'url'=>array('admin')),
);
?>

<h1>Ma Makes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
