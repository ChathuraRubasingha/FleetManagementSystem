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
/*
$this->menu=array(
	//array('label'=>'Garages', 'url'=>array('index')),
	array('label'=>'Manage Garages', 'url'=>array('admin')),
);*/
?>
<div class="group" style="width:75%; margin-left:30%">
   <div class="manage">
             <?php  echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""  />',array('maGarages/admin'));?> 	
        </div>
<h1>Add Garage Details</h1>

<?php echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
</div>