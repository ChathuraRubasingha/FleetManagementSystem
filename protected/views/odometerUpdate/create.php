    <?php
    $vehicleId = Yii::app()->session['OdoUpdateVehicle'];
    $userRole = Yii::app()->getModule('user')->user()->Role_ID;

    if (($userRole !== '3') && ($userRole !== '4'))
    {
        $marign_Top = "-16.2%;";
        $marign_TopMenu = "0px;";
        $manageLink = '/odometerUpdate/vehicleListForOdometer';
    }
    else
    {
        $marign_Top = "-20.6%;";
        $marign_TopMenu = "0px;";
        $manageLink = "/odometerUpdate/vehicleListForOdometer";
    }
    ?>

    <?php
     $title ="Update Odometer";
//        if (($userRole !== '3') && ($userRole !== '4'))
//        {
//            $title ="Update Odometer";
//        }
//        else
//        {
//            $title= "ඔඩෝමීටරය යාවත්කාලීන කිරීම";
//        }
    ?>





<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php

                    $this->breadcrumbs=array(
                        'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                        'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                        'Insurance' =>array('tRInsurance/admin'),
                        'Add Insurance Details',
                    );?>
                </ul>
            </div>
            <div class="col-xs-8" style="margin-left: 20%">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('/odometerUpdate/vehicleListForOdometer',"menuId"=>"odometerMnu"),array('title'=>'Manage')); ?>
                        </div>
                    </div>


                    
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><center><?php echo $vehicleId?></center></h1>
                    </div>


                    <div class="panel-body">
                        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
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