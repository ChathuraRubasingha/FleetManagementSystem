<?php
$this->breadcrumbs=array(
	'Ma Branches',
);

$this->menu=array(
	array('label'=>'Create MaBranch', 'url'=>array('create')),
	array('label'=>'Manage MaBranch', 'url'=>array('admin')),
);
?>

<h1>Ma Branches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
