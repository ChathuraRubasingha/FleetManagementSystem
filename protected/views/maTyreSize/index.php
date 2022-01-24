<?php
$this->breadcrumbs=array(
	'Ma Tyre Sizes',
);

$this->menu=array(
	array('label'=>'Create Tyre Size', 'url'=>array('create')),
	array('label'=>'Manage Tyre Size', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Tyre Sizes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>
