<?php
$vehicleId = Yii::app()->request->getQuery('vehicleId');
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
  $header = "Completed Vehicle Booking Details";
//if (($userRole !== '3') && ($userRole !== '4')) {
//    $header = "Completed Vehicle Booking Details";
//
//} else {
//    $header="සම්පූර්ණකල අනුමත වෙන්කල අයදුම";
//
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
                            'Vehicle Booking' => array('site/booking'),
                            'Odometer' => array('tRVehicleBooking/vehiclelist'),
                            'Odometer Details' => array('bookingApproval/odometer&vehicleId=' . $vehicleId . '&Booking_Approval_ID=' . $model->Booking_Approval_ID),
                            'Completed Vehicle Booking Details'
                        );
                    }

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $header;  ?></h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('/tRVehicleBooking/vehiclelist'), array('title'=>'Add'));?>
                        </div>
                    </div>

                    
                </div>

                <div class="panel panel-default">

                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php
                        $this->widget('zii.widgets.CDetailView', array(
                            'data' => $model,
                            'attributes' => array(
                                //	'Booking_Approval_ID',
                                'Approved_Date',
                                'New_Booking_Request_Date',
                                'Out_Time',
                                array(
                                    'visible' => $model->In_Time == null ? false : true,
                                    'name' => 'In_Time',
                                    'value' => $model->In_Time
                                ),
                                array(
                                    'visible' => $model->Mileage == null ? false : true,
                                    'name' => 'Mileage',
                                    'value' => $model->Mileage
                                ),
                                array(
                                    'visible' => $model->No_of_Pessengers == null ? false : true,
                                    'name' => 'No_of_Pessengers',
                                    'value' => $model->No_of_Pessengers
                                ),
                            ),
                        ));
                        ?>
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

            </div>
        </div>

    </div>
</div>