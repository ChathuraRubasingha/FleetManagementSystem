<?php
$this->breadcrumbs=array(
	'Fuel Request Details'=>array('index'),
	'Fuel Request To Approve',
);
$this->menu=array(
	//array('label'=>'List TRFuelRequestDetails', 'url'=>array('index')),
	//array('label'=>'Make New Request', 'url'=>array('maVehicleRegistry/fuelRequest')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trfuel-request-details-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
$vehicleId = Yii::app()->session['VehicleIdFuel'];
$aid=Yii::app()->session['VehicleIdAllocationID'];
?>

<div class="group" style="width:200px; float:left; margin-left:65px; margin-top:-3px; height:150px;">
    <div id="menu"  style="width:200px; float:left; padding-left:10px; padding-top:20px">

            <ul>
            
               <?php /*?> <li><?php echo CHtml::link('Fuel Requests',array('/tRFuelRequestDetails/admin&id='.$vehicleId)); ?></li><?php */?>
            <?php echo CHtml::link('<img src="images/back.png" alt="back" width="25px" style="padding:0 80px 0 50px;"/>',array('/tRFuelProvidingDetails/fuelProvidingHistory&id='.$vehicleId.'&aid='.$aid)); ?>
              <li><?php echo CHtml::link('Back to Main',array('tRFuelProvidingDetails/fuelProvidingHistory&id='.$vehicleId.'&aid='.$aid)); ?></li>
                <?php /*?><li><?php echo CHtml::link('Approve Fuel Request',array('/tRFuelRequestDetails/approvePendingList')); ?></li><?php */?>
                 <li><?php echo CHtml::link('Add Fuel Requests',array('/tRFuelRequestDetails/create')); ?></li>
                <li><?php echo CHtml::link('Add Fuel Providing Details',array('/tRFuelRequestDetails/approvedRequests')); ?></li>

                            
            </ul>

	</div>
</div>

<div class="group" style="margin-left:350px;">

<h1>Select Fuel Request to Approve</h1>
<div class="classname" style="width:200px; height:28px; margin-left:300px; font-size:25px"><p align="center"><b><?php echo $vehicleId; ?></b></p></div>

<?php #echo CHtml::link('','',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
));*/ ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trfuel-request-details-grid',
	'dataProvider'=>$model->getFuelRequestDetails(),
	//'filter'=>$model,
	'columns'=>array(
		'Request_Date',
		'Vehicle_No',
		//'Driver_ID',
		array('name'=>'Driver', 'header'=>'Driver Name', 'value'=>'$data->driver->Full_Name'),
		'Required_Fuel_Capacity',
		//'Driver_ID',
		//array('name'=>'Driver_ID', 'header'=>'driver Name', 'value'=>'$data->driver->Full_Name'),
	
		//'Fuel_Balance',
		
		/*
		'Meter_Reading',
		'Approve_Status',
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
	array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'viewButtonUrl'=>'Yii::app()->createUrl("/tRFuelRequestDetails/approveFuelRequest", array("requestId" =>     
			$data["Fuel_Request_ID"]))',
		),
		
	),
)); ?>
</div>