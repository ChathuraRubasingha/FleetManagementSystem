<?php
/* @var $this MaUserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
	array('label'=>'Create New User', 'url'=>array('create')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Ma Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
