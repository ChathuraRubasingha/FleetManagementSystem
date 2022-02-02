<style type="text/css">

.add{
	margin-top:-0.8%;
	margin-left:88%;
		
}


</style>

<?php
$this->breadcrumbs=array(
	'Vehicle Registry'=>array('maVehicleRegistry/edit'),
	'Assigned Location History',
);

/*$this->menu=array(
//	array('label'=>'List VehicleLocation', 'url'=>array('index')),
	array('label'=>'Create Vehicle Location', 'url'=>array('create')),
);*/

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
	$.fn.yiiGridView.update('vehicle-location-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="group" style="height:115px; width:20%; float:left; margin-left:3%; margin-top:2.4%">
        <div id="menu" style="padding-left:2%; padding-top:2%;">
        
        <ul>
        
        <li><?php echo CHtml::link('Vehicle Registry',array('/maVehicleRegistry/edit')); ?></li>
        <li><?php echo CHtml::link('Assign Location',array('/tRVehicleLocation/admin')); ?></li>
        <li><?php echo CHtml::link('Assign Driver',array('/tRVehicleLocation/notAssignedVehicles')); ?></li>    
        <li><?php echo CHtml::link('Transfer Vehicle',array('/tRVehicleLocation/transferVehicle')); ?></li>     
        </ul>
        
        </div>
</div>
    <div  style="width:900px; float:left; ">
<div class="group" style="width:90%; margin-left:33%; float:left; margin-top:-17.4%; margin-bottom:20px;">
<!--<div class="add">
 <?php  #echo  CHtml::link('<img src="images/assign.png" style="height:58px; width="58px""  />',array('maVehicleRegistry/vehicleAsign&assign=true'));?> 
</div>-->
<h1>Select Vehicle for Assigned Location History</h1>

<div style="margin-left:93%; margin-top:-40px; margin-bottom:20px;">
	<?php echo CHtml::link('<img src="images/search_btn2.png"  width="40px" height="40px"/>','#',array('class'=>'search-button')); ?>
</div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vehicle-location-grid',
	'dataProvider'=>$model->searchVehicles(),
	//'filter'=>$model,
	'columns'=>array(
		//'Vehicle_Location_ID',
		#'Location_ID',
		array('name'=>'Location_ID', 'header'=>'Location', 'value'=>'$data->location->Location_Name'),
		'Vehicle_No',
		array('name'=>'Vehicle_Category_ID', 'type'=>'raw', 'value'=>array($this,'gridCategoryName')),
		'From_Date',
		'To_Date',
		//'Driver_ID',
		/*
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			#Yii::app()->session['VehicleNo'] = 'fromTransfer',
			'viewButtonUrl'=>'Yii::app()->createUrl("/vehicleTransfer/locationHistory", array("id" => $data["Vehicle_No"], "loc" => $data["locations"]["Location_ID"], "menuId"=>"vreg"))',
		),
	),
)); ?>

</div>
</div>