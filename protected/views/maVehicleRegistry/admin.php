<style type="text/css">

.add{
	margin-top:.3%;
	margin-left:95%;
	float:left;
}


</style>

<?php
$this->breadcrumbs=array(
	'Accident Details'=>array('maVehicleRegistry/accidentView&id='.Yii::app()->session["accidentVehicleId"].''),
	'Select Vehicle for Accident Details'=>array(),
	'Add Accident Details'
	
);

/*$this->menu=array(
	//array('label'=>'List New Vehicle Registry', 'url'=>array('index')),
	array('label'=>'Add New Vehicle to Registry', 'url'=>array('create')),
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
	$.fn.yiiGridView.update('ma-vehicle-registry-grid', {
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
 <?php  #echo  CHtml::link('<img src="images/add.png" style="height:60px; width="60px""  />',array('maVehicleRegistry/create'));?> 
</div>-->

<h1>Vehicle Registry</h1>

<div style="margin-left:93%; margin-top:-50px;">
	<?php echo CHtml::link('<img src="images/search_btn2.png"  width="36px" height="36px" />','#',array('class'=>'search-button')); ?>
</div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div id="statusMsg">
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ma-vehicle-registry-grid',
	'dataProvider'=>$model->getVehicleListByLocation(),
	//'filter'=>$model,
	'columns'=>array(
		'Vehicle_No',
		array('name'=>'Category_Name', 'header'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
		//'Model',
		array('name'=>'Make_ID', 'header'=>'Make', 'value'=>'$data->makeID->Make'),
		//array('name'=>'Model_ID', 'header'=>'Model', 'value'=>'$data->maModels->Model'),
		array('name'=>'Model', 'type'=>'raw', //because of using html-code
            'value'=>array($this,'gridModel'), //call this controller method for each row
        ),
		//array('name'=>'Purchase_Value', 'value' => 'number_format($data->Purchase_Value,2)', 'htmlOptions'=>array(                                'style'=>'text-align: right;'),),
		array('name'=>'Fuel_Type', 'header'=>'Fuel Type', 'value'=>'$data->fuelType->Fuel_Type'),
		array('name'=>'Vehicle_Status', 'header'=>'Vehicle Status', 'value'=>'$data->vehicleStatus->Vehicle_Status'),
		//'Vehicle_Category_ID',
	
		'Purchase_Date',
		/*'Purchase_Value',
		
		'Engine_No',
		'Chassis_No',
		'Fuel_Type_ID',
		'Tyre_Size_ID',
		'Tyre_type',
		'No_of_Tyres',
		'Make',
		'Fuel_Consumption',
		'Battery_Type',
		'Vehicle_Status_ID',
		'Service_Mileage',
		'Servicing_Period',
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',*/
	
		array(
        'class'=>'CButtonColumn',
            'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
    ),
    ),
)); ?>
</div>
</div>