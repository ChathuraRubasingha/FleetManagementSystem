<?php
$this->breadcrumbs=array(
	'Roles',
);

$this->menu=array(
	array('label'=>'Create New Role', 'url'=>array('create')),
	array('label'=>'Manage Role', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Roles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>