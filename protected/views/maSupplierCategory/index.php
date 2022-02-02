<?php
$this->breadcrumbs=array(
	'Supplier Categories',
);

$this->menu=array(
	array('label'=>'Create Supplier Category', 'url'=>array('create')),
	array('label'=>'Manage Supplier Category', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Supplier Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>
