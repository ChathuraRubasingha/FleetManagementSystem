<?php
$this->breadcrumbs=array(
	'Accidents Details',
);

$this->menu=array(
	array('label'=>'Add New Accident Details', 'url'=>array('create')),
	array('label'=>'Manage Accident Details', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Accident Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>
