<?php
$this->breadcrumbs=array(
	'Download'=>array('maVehicleRegistry/download'),
	'Vehicle Registry',
);

$this->menu=array(
	//array('label'=>'List New Vehicle Registry', 'url'=>array('index')),
	//array('label'=>'Add New Vehicle to Registry', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ma-vehicle-registry-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="group" style="width:20%;  height:60px; float:left; margin-left:3%; margin-top:2.4%">
    <div id="menu"  style="width:20%; float:left; padding-left:2%; padding-top:2%">


<ul>
<li><?php echo CHtml::link('Request Vehicle Service',array('/maVehicleRegistry/requestService')); ?></li>
<li><?php echo CHtml::link('Request New Tyre Tube',array('/maVehicleRegistry/newTyreTube')); ?></li>

</ul>
</div>

</div>
    <div  style="width:90%; float:left; ">
<div class="group" style="margin-left:33%; margin-top:-11.8%">

<div align="center"><h1>Select Vehicle for Tyre Tube Request Form</h1></div>



<?php /*?><?php echo CHtml::link('<img src="images/Search.gif"  width="70px" height="40px"/>','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><?php */?><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ma-vehicle-registry-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'Vehicle_No',
		array('name'=>'Category_Name', 'header'=>'Vehicle Category Name', 'value'=>'$data->vehicleCategory->Category_Name'),
		array('name'=>'Make_ID', 'header'=>'Make', 'value'=>'$data->makeID->Make'),
		
		//array('name'=>'Model_ID', 'header'=>'Model', 'value'=>'$data->modelID->Model'),
		array('name'=>'Model', 'type'=>'raw', //because of using html-code
            'value'=>array($this,'gridModel'), //call this controller method for each row
        ),
		
		array('name'=>'Fuel_Type', 'header'=>'Fuel Type', 'value'=>'$data->fuelType->Fuel_Type'),
		array('name'=>'Vehicle_Status', 'header'=>'Vehicle Status', 'value'=>'$data->vehicleStatus->Vehicle_Status'),
				
		//'Vehicle_Category_ID',
		/*'Purchase_Value',
		'Purchase_Date',
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
			'template'=>'{view}',
			'viewButtonUrl'=>'Yii::app()->createUrl("/maVehicleRegistry/form01", array("id" =>     
			$data["Vehicle_No"]))',
		),
	),
)); ?></div>
</div>