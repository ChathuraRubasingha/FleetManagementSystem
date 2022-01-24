<?php
$this->breadcrumbs=array(
	'Odometer Update Remarks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OdometerUpdateRemark', 'url'=>array('index')),
	array('label'=>'Manage OdometerUpdateRemark', 'url'=>array('admin')),
);
?>

<h1>Create Odometer Update Remark</h1>

<?php echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>