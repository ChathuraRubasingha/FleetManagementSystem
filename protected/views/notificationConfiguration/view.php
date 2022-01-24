<style type="text/css">

.add{
	margin-left:84%;
	float:left;
	margin-top:-12px;
}

.manage{
	margin-left:87%;
	margin-top:-12px;
	

}

.update{
	margin-left:95%;
	margin-top:-50px;
	float:left;
;
}


</style>`   

<?php
$this->breadcrumbs=array(
	'Notification Configurations'=>array('index'),
	$model->Row,
);

//$this->menu=array(
//	array('label'=>'List NotificationConfiguration', 'url'=>array('index')),
//	array('label'=>'Create NotificationConfiguration', 'url'=>array('create')),
//	array('label'=>'Update NotificationConfiguration', 'url'=>array('update', 'id'=>$model->Row)),
//	array('label'=>'Delete NotificationConfiguration', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Row),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage NotificationConfiguration', 'url'=>array('admin')),
//);
?>
<div class="group" style="width:85%; margin-left:20%">
<div class="manage">
	<?php  echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""  />',array('notificationConfiguration/admin'));?> 
</div>    
<h1>Notification Configuration </h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'Row',
//		'Configuration_Name',
                'Description',
		'Value',
		
	),
)); ?>
</div>