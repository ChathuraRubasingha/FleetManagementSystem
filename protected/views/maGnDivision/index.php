<?php
/* @var $this MaGnDivisionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Gn Divisions',
);

$this->menu=array(
	array('label'=>'Create New Gn Division', 'url'=>array('create')),
	array('label'=>'Manage Gn Division', 'url'=>array('admin')),
);
?>

<h1>Ma Gn Divisions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
