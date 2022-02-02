<style type="text/css">

.manage{
	margin-left:94.4%;
	margin-top:-8.6px;
}

h1{
	/*margin-bottom:5%px;*/
}
</style>
<?php
/* @var $this MaDistrictController */
/* @var $model MaDistrict */

$this->breadcrumbs=array(
	'Manage'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	//array('label'=>'List District', 'url'=>array('index')),
	array('label'=>'Manage District', 'url'=>array('admin')),
);*/
?>
<div class="group" style="width:75%; margin-left:30%">
   <div class="manage">
             <?php  echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""  />',array('maDistrict/admin'));?> 	
        </div>
        
        <h1>Add District</h1>

<?php echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
</div>