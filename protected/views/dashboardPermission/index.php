<?php
$this->breadcrumbs=array(
	'Dashboard Permissions',
);

$this->menu=array(
	array('label'=>'Create DashboardPermission', 'url'=>array('create')),
	array('label'=>'Manage DashboardPermission', 'url'=>array('admin')),
);
?>

<h1>Dashboard Permissions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
