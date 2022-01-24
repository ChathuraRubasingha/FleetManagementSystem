<?php
$this->breadcrumbs=array(
	'Profiles Fields',
);

$this->menu=array(
	array('label'=>'Create ProfilesFields', 'url'=>array('create')),
	array('label'=>'Manage ProfilesFields', 'url'=>array('admin')),
);
?>

<h1>Profiles Fields</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
