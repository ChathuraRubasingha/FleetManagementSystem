<?php
$vehicleId = Yii::app()->session['OdoUpdateVehicle'];
$aid = Yii::app()->session['VehicleIdAllocationID'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

if($vehicleId == null)
{
    $vehicleId = Yii::app()->request->getQuery('vid');
}
 $title = 'View Odometer Update';
    $driverTitle = 'Driver';
    $remarkTile = 'Remark';
    $inTimeTitle = 'In Time';
    $manageReturnLink = '/odometerUpdate/vehicleListForOdometer';
    $inOdoReading = 'In Odo Reading(km)';
//if (($userRole !== '3') && ($userRole !== '4'))
//{
//    $title = 'View Odometer Update';
//    $driverTitle = 'Driver';
//    $remarkTile = 'Remark';
//    $inTimeTitle = 'In Time';
//    $manageReturnLink = '/odometerUpdate/vehicleListForOdometer';
//    $inOdoReading = 'In Odo Reading(km)';
//}
//else
//{
//    $title = 'යාවත්කාලීන ඔඩෝමීටරය කියවීම ';
//    $driverTitle = 'රියැදුරු';
//    $remarkTile = "සටහන";
//    $inTimeTitle = 'දිනය/වෙලාව දක්වා';
//    $manageReturnLink = '/odometerUpdate/vehicleListForOdometer';
//   // $inOdoReading = "ආපසු පැමිණි විට ඔඩෝමීටර් කියවීම (කි.මී)";
//}


?>


<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    if (($userRole !== '3') && ($userRole !== '4')) {
                    $this->breadcrumbs = array(
                        'Fuel' => array('maVehicleRegistry/fuelRequest'),
                    );
                    }

                    ?>
                </ul>
            </div>
            <div class="col-xs-8" style="margin-left: 20%">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title;?></h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('/odometerUpdate/vehicleListForOdometer',"menuId"=>"odometerMnu"),array('title'=>'Manage')); ?>
                        </div>
                    </div>

                    
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h2><center><?php echo $vehicleId; ?></center></h2>
                    </div>

                    <div class="panel-body">

                        <?php
                        $this->widget('zii.widgets.CDetailView', array(
                            'data' => $model,
                            'attributes' => array(
                                array(
                                    'name' => 'Driver_ID',
                                    'label'=> $driverTitle,
                                    'value' => $model->driverid->Full_Name
                                ),
                                array(
                                    'name' => 'Remark',
                                    'label'=> $remarkTile,
                                    'value' => $model->remark->description),
                                'out_time',
                                'out_odo_reading',
                                array(
                                    'visible' => $model->in_time == '0000-00-00 00:00:00' ? false : true,
                                    'name' => 'In Time',
                                    'label'=> $inTimeTitle,
                                    'value' => $model->in_time
                                ),
                                array(
                                    'visible' => $model->in_odo_reading === '0' ? false : true,
                                    'name'=>'in_odo_reading',
                                    'value' => $model->in_odo_reading
                                ),
                                array(
                                    'visible'=> $model->description == '' ? false : true,
                                    'name'=>'description',
                                    'value'=>$model->description,
                                ),
                                array(
                                    'visible'=> $model->added_by == '' ? false : true,
                                    'name'=>'added_by',
                                    'value'=>$model->added_by ,
                                ),
                                array(
                                    'visible'=> $model->edit_by == '' ? false : true,
                                    'name'=>'edit_by',
                                    'value'=>$model->edit_by ,
                                )
                            ),

                        ));
                        ?>
                    </div>




                </div>
            </div>
<!--            <div class="col-xs-4">




                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">
                            Menu
                        </h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <?php
                            if(($userRole ==='2')||($userRole ==='6'))
                            {
                                echo MaVehicleRegistry::model()->menuarray('VehicleBookingLow');
                            }
                            elseif($userRole ==='3' || $userRole ==='4')
                            {
                                echo MaVehicleRegistry::model()->menuarray('OdometerSinhala');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('VehicleBooking');
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>-->
        </div>

    </div>
</div>
