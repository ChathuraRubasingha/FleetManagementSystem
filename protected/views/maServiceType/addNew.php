<style type="text/css">

.manage{
	margin-left:94.4%;
	margin-top:-8.6px;
}</style>

<?php
$this->breadcrumbs=array(
	'Manage'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	//array('label'=>'Service Type', 'url'=>array('index')),
	array('label'=>'Manage Service Type', 'url'=>array('admin')),
);*/
?>
<div class="group" style="width:75%; margin-left:30%">
   <div class="manage">
             <?php  echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""  />',array('maServiceType/admin'));?> 	
        </div>
<h1>Add Service Type</h1>

<?php echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
</div>