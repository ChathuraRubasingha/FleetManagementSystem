<?php
$this->breadcrumbs=array(
	'Trrepair Requests',
);

$this->menu=array(
	array('label'=>'Create TRRepairRequest', 'url'=>array('create')),
	array('label'=>'Manage TRRepairRequest', 'url'=>array('admin')),
);
?>

<h1>Trrepair Requests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
