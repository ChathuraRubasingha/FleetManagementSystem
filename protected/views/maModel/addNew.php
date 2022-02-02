<style type="text/css">

.manage{
	margin-left:90%;
}

h1{
	margin-bottom:5%px;
}
</style>

<?php
$this->breadcrumbs=array(
	'Ma Models'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List MaModel', 'url'=>array('index')),
	array('label'=>'Manage MaModel', 'url'=>array('admin')),
);*/
?>
<div class="group" style="width:75%; margin-left:30%">
   <div class="manage">
             <?php  echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""  />',array('MaModel/admin'));?> 	
        </div>


<h1  style="margin-top:-40px;">Create New Model</h1>

<?php echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>