<?php
$this->breadcrumbs=array(
	//'Management'=>array('notificationConfiguration/management'),
	'Accident',
);

$this->menu=array(
	//array('label'=>'List New Vehicle Registry', 'url'=>array('index')),
	//array('label'=>'Create New Vehicle Registry', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function()
{
	
	if ($('.search-form').is(':hidden')) 
	{
		$('.search-form').toggle();
		return false;
	}
	else 
	{
		location.reload();
		return false;
	}
	
	
});	
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ma-vehicle-registry-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="group" style="margin-left:280px;">
<h1>Accident History Listing</h1>
<div style="margin-left:630px">
<?php echo CHtml::link('<img src="images/Search.gif"  width="0px" height="0px"/>','#',array('class'=>'search-button')); ?>
</div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search1',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'traccident-grid',
	'dataProvider'=>$model->getAccidentHistory(),
	//'filter'=>$model,
'columns'=>array(
		//'Accident_ID',
		'Vehicle_No',
		array('name'=>'Driver_ID', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
		'Accident_Place',
		'Date_and_Time',
		'Details',
		'Police_Station',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'viewButtonUrl'=>'Yii::app()->createUrl("/maVehicleRegistry/accidentView", array("id" =>     
			$data["Vehicle_No"]))',
		),
	),
));

 ?>
</div>
