<?php 

$vehicleId = Yii::app()->session['VehicleIdFuel'];
$aid =Yii::app()->session['VehicleIdAllocationID'];



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('completed-fuel-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php

                    $this->breadcrumbs=array(
                        'Fuel'=>array('/maVehicleRegistry/fuelRequest'),
                        'Completed Fuel Requests',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Completed Fuel Requests</h1>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $vehicleId; ?></h1></center>
                    </div>

                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'completed-fuel-grid',
                            'dataProvider'=>$model2->getCompletedFuelRequests(),
                            'columns'=>array(
                                array('name'=>'Request Date', 'value'=>'$data->fuelRequest->Request_Date'),
                                array('name'=>'Driver', 'value'=>'$data->fuelRequest->driver->Full_Name'),
                                array('name'=>'Required Fuel Capacity (l)', 'value'=>'$data->fuelRequest->Required_Fuel_Capacity'),
                                'Fuel_Pumped_Date',
                                'Fuel_Amount',
                                array('name'=>'Payable Amount    (Rs)', 'value'=>'number_format($data->Payable_Amount,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right:20px;')),
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRFuelProvidingDetails/view", array("id"=>$data["Fuel_Providing_ID"], "type"=>"completed", "menuId"=>"fuel"))'
                                ),
                            ),
                        )); ?>
                    </div>
                </div>




            </div>
            <div class="col-xs-4">




                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">
                            Menu
                        </h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <?php
                            echo MaVehicleRegistry::model()->menuarray('Fuel');
                           ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>