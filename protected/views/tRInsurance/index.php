<?php
$this->breadcrumbs=array(
	'Insurances',
);

$this->menu=array(
	//array('label'=>'Create Insurance', 'url'=>array('create')),
	array('label'=>'Manage Insurance', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Insurances</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>
