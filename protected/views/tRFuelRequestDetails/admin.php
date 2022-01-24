<?php

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

    $vehicleId = Yii::app()->session['VehicleIdFuel'];
    $aid =Yii::app()->session['VehicleIdAllocationID'];

    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
    if($userRole !=='3')
    {
        $title="Fuel Requests Registry";
    }
    else
    {
        $title ="ඉන්ධන අයදුම්";

    }
?>


        <div class="container body">
            <div id="main" role="main">
                <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

                    <div class="col-xs-12">
                        <ul class="breadcrumb">
                            <?php
                            if($userRole !=='3')
                            {
                                $this->breadcrumbs=array(
                                    'Fuel'=>array('/maVehicleRegistry/fuelRequest'),
                                    'Fuel Requests'=>array('/tRFuelProvidingDetails/fuelProvidingHistory&id='.$vehicleId.'&aid='.$aid),
                                    'Fuel Requests Registry',
                                );
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-xs-8">
                        <div class="panel panel-default">
                            <div class="panel-heading large">
                                <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
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
                                    'id'=>'trfuel-request-details-grid',
                                    'dataProvider'=>$model->getFuelRequestDetails(),
                                    'columns'=>array(
                                        'Request_Date',
                                        array('name'=>'Driver_ID', 'value'=>'$data->driver->Full_Name'),
                                        'Required_Fuel_Capacity',
                                        'Fuel_Balance',

                                        array(
                                            'class'=>'CButtonColumn',
                                            'updateButtonUrl'=>'Yii::app()->createUrl("/tRFuelRequestDetails/update", array("id" =>
                                                $data["Fuel_Request_ID"], "menuId"=>"fuel"))',
                                            'viewButtonUrl'=>'Yii::app()->createUrl("/tRFuelRequestDetails/view", array("id" =>
                                                $data["Fuel_Request_ID"], "menuId"=>"fuel"))',
                                            'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
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
                                    if($userRole !=='3')
                                    {
                                        echo MaVehicleRegistry::model()->menuarray('Fuel');
                                    }
                                    else
                                    {
                                        echo MaVehicleRegistry::model()->menuarray('FuelForDriver');
                                    }?>
                                </ul>
                            </div>
                            <div class="panel-footer text-center"> </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>