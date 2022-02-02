<style type="text/css">

.manage{
	margin-left:87%;
	margin-top:-1.9%;
}


</style>


<?php
$this->breadcrumbs=array(
	'Vehicle Registry'=>array('maVehicleRegistry/edit'),
	'Select Vehicle to Assign Driver',
	
);
?>
<?php  
/*$this->menu=array(
	//array('label'=>'List New Vehicle Registry', 'url'=>array('index')),
	//array('label'=>'Create New Vehicle Registry', 'url'=>array('create')),
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
	$.fn.yiiGridView.update('ma-vehicle-location-grid', {
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
<!--<div class="manage">
	<?php  #echo  CHtml::link('<img src="images/allocatedDrivers.png" style="height:70px; width="70px""  />',array('vehicleDriver/admin'));?> 
</div>-->
<h1 style="margin-top:10px;">Select Vehicle to Assign Driver</h1>



<div style="margin-left:93%; margin-top:-46px;">
	<?php echo CHtml::link('<img src="images/search_btn2.png"  width="38px" height="38px"/>','#',array('class'=>'search-button')); ?>
</div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); 
?>
</div><!-- search-form -->
	
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ma-vehicle-location-grid',
	'dataProvider'=>$model->getAssignedVehiclesLocationwise(),
	//'filter'=>$model,
	'enableSorting' => false,

	'columns'=>array(
		#'Location_Name',
		array('name'=>'Current_Location_ID', 'header'=>'Current Location', 'value'=>'$data->locations->Location_Name'),
		'Vehicle_No',
		array('name'=>'Vehicel Category', 'type'=>'raw', 'value'=>array($this,'gridCategoryName')),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			#Yii::app()->session['VehicleNo'] = 'fromTransfer',
			'viewButtonUrl'=>'Yii::app()->createUrl("/vehicleDriver/create", array("vNo" => $data["Vehicle_No"], "loc" => $data["locations"]["Location_ID"], "menuId"=>"vreg"))',
		),
	),
)); ?>


</div>

</div>
