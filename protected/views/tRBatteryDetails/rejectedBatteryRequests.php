<?php


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rejected-battery-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$vehicleId = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

if($userRole !=='3')
{
    $title="Rejected Battery Requests Registry";
    $reject="Rejected";
    $rejDate ="Rejected Date";
}
else
{
	$title="ප්‍රතික්‍ෂේප කරන ලද බැටරි අයදුම්";
	$reject="ප්‍රතික්‍ෂේප කළේ";
	$rejDate ="ප්‍රතික්‍ෂේප කළ දිනය";
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
                                'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                                'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                                'Battery'=>array('tRBatteryDetails/battery'),
                                'Rejected Battery Requests'
                            );

                        }
                        ?>
                    </ul>
                </div>
                <div class="col-xs-8">
                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title ?></h1>
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
                                'id'=>'rejected-battery-grid',
                                'dataProvider'=>$model->getRejectedBatteryRequests(),
                                #'filter'=>$model,
                                'columns'=>array(
                                    'Battery_Details_ID',
                                    array('name'=>'Driver_ID', 'value'=>'$data->driver->Full_Name'),
                                    array('name'=>'Battery_Type_ID', 'value'=>'$data->batteryType->Battery_Type'),
                                    array('header'=>$reject, 'value'=>'$data->Approved_By'),
                                    array('header'=>$rejDate, 'value'=>'$data->Approved_Date'),

                                    array(
                                        'class'=>'CButtonColumn',
                                        'template'=>'{view}',
                                        'viewButtonUrl'=>'Yii::app()->createUrl("/tRBatteryDetails/view", array("id"=>$data["Battery_Details_ID"], "type"=>"rejected"))',
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

                                <?php if($userRole !=='3')
                                {
                                    echo MaVehicleRegistry::model()->menuarray('MaintenanceBattery');
                                }
                                else
                                {
                                    echo MaVehicleRegistry::model()->menuarray('MaintenanceBatteryForDriver');
                                }?>
                            </ul>
                        </div>
                        <div class="panel-footer text-center"> </div>
                    </div>

                </div>
            </div>

        </div>
    </div>