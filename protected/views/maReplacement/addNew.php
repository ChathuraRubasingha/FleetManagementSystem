<style type="text/css">

.manage{
	margin-left:90%;
}

h1{
	margin-bottom:5%;
}
</style>

<?php
$this->breadcrumbs=array(
	'Manage'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	//array('label'=>'List MaReplacement', 'url'=>array('index')),
	array('label'=>'Manage Replacement', 'url'=>array('admin')),
);*/
?>
<div class="group" style="width:75%; margin-left:30%">
   <div class="manage">
             <?php  echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""  />',array('maReplacement/admin'));?> 	
        </div>
<h1>Add Replacement Details</h1>

<?php echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
</div>