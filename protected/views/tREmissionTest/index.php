<?php
$this->breadcrumbs=array(
	'Tremission Tests',
);

$this->menu=array(
	array('label'=>'Create Emission Test', 'url'=>array('create')),
	array('label'=>'Manage Emission Test', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Eemission Tests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>
