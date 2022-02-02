<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
	$userRole = Yii::app()->getModule('user')->user()->Role_ID;
if($userRole !=='3')
{
$title="Approved Battery Requests Registry";


}
else
{
	$title="අනුමත කළ බැටරි අයදුම්";

}

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $.fn.yiiGridView.update('approved-battery-grid', {
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
                                'Approved Battery Requests'
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
                                'id'=>'approved-battery-grid',
                                'dataProvider'=>$model->getApprovedBatteryRequests(),
                                #'filter'=>$model,
                                'columns'=>array(
                                    'Battery_Details_ID',
                                    //'Vehicle_No',
                                    array('name'=>'Driver_ID', 'value'=>'$data->driver->Full_Name'),
                                    //'Driver_ID',
                                    array('name'=>'Battery_Type_ID',  'value'=>'$data->batteryType->Battery_Type'),

                                    //'Cost',
                                    //'Battery_Type_ID',
                                    'Approved_By',
                                    'Approved_Date',
                                    //'Approved_Date',
                                    /*
                                    'add_by',
                                    'add_date',
                                    'edit_by',
                                    'edit_date',
                                    */

                                    array(
                                        'class'=>'CButtonColumn',
                                        'template'=>'{view}',
                                        'viewButtonUrl'=>'Yii::app()->createUrl("/tRBatteryDetails/view", array("id"=>$data["Battery_Details_ID"], "type"=>"approved","menuId"=>"maintenance"))'
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