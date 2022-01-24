
<?php
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

$header = "Select Assigned Booking Requests for Odometer Details";
    $driveHeader = "Driver";
    $approvedDate = "Approved Date";
    $fromDate = "From Date/Time";
    $toDateTime = "To Date/Time";
    $placeFrom = "Place From";
    $placeTo = "Place(s) To";
//if (($userRole !== '3') && ($userRole !== '4'))
//{
//
//    $header = "Select Assigned Booking Requests for Odometer Details";
//    $driveHeader = "Driver";
//    $approvedDate = "Approved Date";
//    $fromDate = "From Date/Time";
//    $toDateTime = "To Date/Time";
//    $placeFrom = "Place From";
//    $placeTo = "Place(s) To";
//}
//else
//{
//    $header = "ඔඩෝමීටර විස්තරය සම්පූර්ණ කිරිම සඳහා අනුමත වෙන් කල අයදුම තෝරාගන්න  ";
//
//    $driveHeader = "රියැදුරු";
//    $approvedDate = "අනුමත කල දිනය/වෙලාව";
//    $fromDate = "දිනය/වෙලාව සිට";
//    $toDateTime = "දිනය/වෙලාව දක්වා";
//    $placeFrom = "ස්ථානයේ සිට";
//    $placeTo = "ස්ථාන(ය)";
//
//
//}

?>


<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    if (($userRole !== '3') && ($userRole !== '4'))
                    {
                    $this->breadcrumbs = array(
                        'Vehicle Booking' => array('tRVehicleBooking/booking'),
                        'Odometer',);

                    } ?>

                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $header; ?></h1>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'trvehicle-booking-grid',
                            'dataProvider' => $modelApprovedBooking->getApprovedBookingRequests(),
                            //'filter'=>$model,
                            'rowCssClassExpression' => '($data->Out_Time !== null)? "warning":"even"',
                            'columns' => array(
                                'Vehicle_No',
                                array('name' => 'Driver_ID', 'header' => $driveHeader, 'value' => '$data->drivers->Full_Name'),
                                array('header' => $placeFrom, 'value' => function($data) {
                                        $placesArray = array();
                                        $plsFrom = '';
                                        $criteria = new CDbCriteria;
                                        $criteria->select = array('Place_from');
                                        $criteria->condition = "Booking_Approval_ID='$data->Booking_Approval_ID' and Booking_Status='Assigned'";
                                        $arr = TRVehicleBooking::model()->findAll($criteria);
                                        foreach ($arr as $place) {
                                            $placesArray[] = $place["Place_from"];
                                        }
                                        if (count($arr) > 0) {
                                            $plsFrom = $arr[0]["Place_from"];
                                        }
                                        return $plsFrom;
                                    }
                                ),
                                array('header' => $placeTo, 'value' => function($data) {
                                        $placesArray = array();
                                        $criteria = new CDbCriteria;
                                        $criteria->select = array('Place_to');
                                        $criteria->condition = "Booking_Approval_ID 	='$data->Booking_Approval_ID' and Booking_Status='Assigned'";
                                        $arr = TRVehicleBooking::model()->findAll($criteria);
                                        foreach ($arr as $place) {
                                            $placesArray[] = $place["Place_to"];
                                        }
                                        return implode(", ", $placesArray);
                                    }
                                ),
                                array('name' => 'New_Booking_Request_Date', 'header' => $fromDate),
                                array('name' => 'New_Booking_To_Date', 'header' => $toDateTime),
                                array('name' => 'Approved_Date', 'header' => $approvedDate, 'value' => '$data->Approved_Date'),
								array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Vehicle',
                                        'imageUrl'=>Yii::app()->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/bookingApproval/odometer", array("vehicleId" =>
			$data["Vehicle_No"],"Booking_Approval_ID" => $data["Booking_Approval_ID"], "menuId"=>"vehibooking"))'
                                    ))
                                    
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