<?php
$this->breadcrumbs=array(
	'Notification Configurations',
);

$this->menu=array(
	array('label'=>'Create NotificationConfiguration', 'url'=>array('create')),
	array('label'=>'Manage NotificationConfiguration', 'url'=>array('admin')),
);
?>

<h1>Notification Configurations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
