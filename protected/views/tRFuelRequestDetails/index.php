<?php
$this->breadcrumbs=array(
	'Fuel Request Details',
);

$this->menu=array(
	array('label'=>'Create Fuel Request Details', 'url'=>array('create')),
	array('label'=>'Manage Fuel Request Details', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Fuel Request Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>