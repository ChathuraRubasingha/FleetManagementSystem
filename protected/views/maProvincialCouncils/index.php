<?php
/* @var $this MaProvincialCouncilsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Provincial Councils',
);

$this->menu=array(
	array('label'=>'Create Provincial Councils', 'url'=>array('create')),
	array('label'=>'Manage Provincial Councils', 'url'=>array('admin')),
);
?>

<h1>Provincial Councils</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
