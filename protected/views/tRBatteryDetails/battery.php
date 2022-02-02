
<?php

$id = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$vehicleId = Yii::app()->session['maintenVehicleId'];


if($userRole !=='3')
{
    $title="Battery Request History of the Vehicle";
}
else
{
	$title="වාහනයේ පෙර කරන ලද බැටරි ප්‍රතිස්ථාපන පිළිබඳ දත්ත";
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
                                'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$id),
                                'Battery Requests',
                            );
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-xs-8">
                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title; ?></h1>
                            <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRBatteryDetails/create'), array('title'=>'Add'));?>
                            </div>
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
                                'id'=>'trbattery-details-grid',
                                'dataProvider'=>$model->getBatteryReplacementHistory(),
                                //'filter'=>$model,
                                'columns'=>array(
                                    'Battery_Details_ID',
                                    array('name'=>'Driver_ID', 'value'=>'$data->driver->Full_Name'),
                                    array('name'=>'Battery_Type_ID',  'value'=>'$data->batteryType->Battery_Type'),
                                    'Approved_Status',
                                    'Replace_Status',
                                    'Replace_Date',
                                    array('name'=>'Cost', 'value'=>'number_format($data->Cost,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right:50px;')),
                                    array(
                                        'class'=>'CButtonColumn',
                                        'template'=>'{view}{update}{delete}{pdf}',									     
										'buttons' => array ('pdf' => array
											(
												'imageUrl' => Yii::app()->request->baseUrl . '/images/updat1e.png',
												'type' => 'raw',
												'url' => 'Yii::app()->createUrl("/tRBatteryDetails/batteryRequestReport", array("id" =>     
												$data["Battery_Details_ID"], "viewType" =>"pdf"))',
												'options' => array('target' => '_blank', 'title'=>'Repair Request'),
											),),			
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