<style type="text/css">

.add{
	margin-top:-12px;
	margin-left:95%;
		
}


</style>

<?php
$this->breadcrumbs=array(
	'Vehicle Transfers'=>array('index'),
	'Manage',
);

$vNo = Yii::app()->request->getQuery('id');

/*$this->menu=array(
	array('label'=>'List VehicleTransfer', 'url'=>array('index')),
	array('label'=>'Create VehicleTransfer', 'url'=>array('create')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('vehicle-transfer-grid', {
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
<div class="group" style="width:90%; margin-left:33%; float:left; margin-top:-17.4%">

<!--<div class="add">
 <?php  #echo  CHtml::link('<img src="images/assign.png" style="height:58px; width="58px""  />',array('maVehicleRegistry/vehicleAsign&assign=true'));?> 
</div>-->

<h1>Assigned Location History of the Vehicle</h1>

<div class="classname" style="width:200px; height:28px; margin-left:300px; margin-bottom:20px; font-size:25px"><p align="center"><b><?php echo $vNo; ?></b></p></div>

<?php #echo CHtml::link('<img src="images/search.gif"  width="0px" height="0px" />','#',array('class'=>'search-button')); ?>
<!--<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
));*/ ?>
</div> search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vehicle-location-grid',
	'dataProvider'=>$model->getLocationHistory(),
	//'filter'=>$model,
	'columns'=>array(
		//'Vehicle_Location_ID',
		#'Location_ID',
		#'Vehicle_No',
		#array('name'=>'Location_ID', 'header'=>'From', 'value'=>'$data->fromLocation->Location_Name'),
		array('name'=>'Location_ID', 'header'=>'Location', 'value'=>'$data->location->Location_Name'),
		#'Vehicle_No',
		array('name'=>'Vehicle_Category_ID', 'type'=>'raw', 'value'=>array($this,'gridCategoryName')),
		'From_Date',
		'To_Date',
		#array('name'=>'Location_ID', 'header'=>'To', 'value'=>'$data->toLocation->Location_Name'),
		//'Driver_ID',
		#array('name'=>'Driver', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),

		array(
			'class'=>'CButtonColumn',
			/*'template'=>'{view}'*/
		),
	),
)); ?></div></div>
