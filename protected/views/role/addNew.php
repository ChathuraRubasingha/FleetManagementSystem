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
	'Manage'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	//array('label'=>'List Allocation Type', 'url'=>array('index')),
	array('label'=>'Manage Allocation Type', 'url'=>array('admin')),
);*/
?>
<div class="group" style="width:75%; margin-left:30%">
   <div class="manage">
            
        </div>
<h1  style="margin-top:-40px;">Add Role</h1>

<?php echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
</div>