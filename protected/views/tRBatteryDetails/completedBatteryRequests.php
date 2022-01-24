<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

if($userRole !=='3')
{
    $title = "Completed Battery Requests Registry";
}
else
{
    $title = "Completed Battery Requests Registry";
}
?>


<?php


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('disapproved-battery-grid', {
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
                    if($userRole !=='3')
                    {
                        $this->breadcrumbs=array(
                            'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                            'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                            'Battery'=>array('tRBatteryDetails/battery'),
                            'Completed Battery Requests'
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
                            'id'=>'disapproved-battery-grid',
                            'dataProvider'=>$model->getCompletedBatteryRequests(),
                            #'filter'=>$model,
                            'columns'=>array(
                                'Battery_Details_ID',
                                array('name'=>'Full_Name', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
                                array('name'=>'Battery_Type', 'header'=>'Battery Type', 'value'=>'$data->batteryType->Battery_Type'),
                                array('name'=>'Cost', 'value'=>'number_format($data->Cost,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right:50px;')),
                                'Approved_By',
                                'Approved_Date',

                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRBatteryDetails/view2", array("id"=>$data["Battery_Details_ID"], "type"=>"completed","menuId"=>"maintenance"))',
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