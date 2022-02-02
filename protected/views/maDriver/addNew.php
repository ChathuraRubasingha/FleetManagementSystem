<style type="text/css">

.manage{
	margin-left:95%;
	margin-top:-12px;
}
</style>


<?php
$this->breadcrumbs=array(
	'Driver'=>array('admin'),
	'Add New Driver',
);

/*$this->menu=array(
	//array('label'=>'List MaDriver', 'url'=>array('index')),
	array('label'=>'Manage Driver', 'url'=>array('admin')),
);*/
?>
<div class="group" style="width:85%; margin-left:20%">
<div class="manage">
	<?php echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""/>',array('maDriver/admin'));?> 
</div>
<h1>Add New Driver</h1>

<?php echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
</div>