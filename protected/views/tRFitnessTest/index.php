<?php
$this->breadcrumbs=array(
	'Trfitness Tests',
);

$this->menu=array(
	array('label'=>'Create Fitness Test', 'url'=>array('create')),
	array('label'=>'Manage Fitness Test', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Fitness Tests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>
