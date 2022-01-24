<?php
$this->breadcrumbs=array(
	'Trclaime Details',
);

$this->menu=array(
	array('label'=>'Create TRClaimeDetails', 'url'=>array('create')),
	array('label'=>'Manage TRClaimeDetails', 'url'=>array('admin')),
);
?>

<h1>Trclaime Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
