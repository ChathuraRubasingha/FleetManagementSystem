<?php
/* @var $this MaDsDivisionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ds Divisions',
);

$this->menu=array(
	array('label'=>'Create Ds Division', 'url'=>array('create')),
	array('label'=>'Manage Ds Division', 'url'=>array('admin')),
);
?>

<h1>Ds Divisions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
