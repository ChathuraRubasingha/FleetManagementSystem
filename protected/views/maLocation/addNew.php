<style type="text/css">

.manage{
	margin-left:94.4%;
	margin-top:-8.6px;
}</style>

<?php
/* @var $this MaLocationController */
/* @var $model MaLocation */

$this->breadcrumbs=array(
	'Manage'=>array('admin'),
	'Add New Location',
);

/*$this->menu=array(
	//array('label'=>'List Location', 'url'=>array('index')),
	array('label'=>'Manage Location', 'url'=>array('admin')),
);*/
?>
<div class="group" style="width:850px; margin-left:200px">
<div class="manage">
	<?php echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""/>',array('maLocation/admin'));?> 
</div>

<h1 style="margin-bottom:50px;">Add New Location</h1>

<?php echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
</div>