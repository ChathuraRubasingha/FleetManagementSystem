<?php
$this->breadcrumbs=array(
	'Fuel Providing Details',
);

$this->menu=array(
	array('label'=>'Create Fuel Providing Details', 'url'=>array('create')),
	array('label'=>'Manage Fuel Providing Details', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Fuel Providing Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>
