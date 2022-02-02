

    <?php
    $userRole = Yii::app()->getModule('user')->user()->Role_ID;

    Yii::app()->session['status'] = 'update';
    $vehicleId = $model->Vehicle_No;
    $Booking_Request_ID = Yii::app()->request->getQuery('id');




    if (($userRole === '3') || ($userRole === '4'))
    {   //trans lating to sinhala
        $vehicle = "වාහන අංකය";
        $requestedBy = "අයදුම්කරු ";
        $placeFrom = "ස්ථානයේ සිට ";
        $placeTo = "ස්ථානය දක්වා ";
        $driveHeader = "රියැදුරු";
        $approvedDate = "අනුමත දිනය/වෙලාව";
        $fromDate = "දිනය/වෙලාව සිට";
        $toDateTime = "දිනය/වෙලාව දක්වා";
        $mileage = "කිලෝමීටර ගණන";
        $avarageDistance = "සාමාන්‍ය දුර(km)";
        $numberOfPassengeres = "මගින් ගණන ";
        $in_Time = "පැමිණි දිනය/ වෙලාව";
        $out_Time = "පිට වූ දිනය/ වෙලාව";
    }
    else
    {
        $vehicle = "Vehicle No";
        $requestedBy = "Requested By";
        $placeFrom = "Place From";
        $placeTo = "Place To (Nearest City)";
        $driveHeader = "Driver";
        $approvedDate = "Approved Date";
        $fromDate = "From Date/Time";
        $toDateTime = "To Date/Time";
        $mileage = "Mileage";
        $avarageDistance = "Average Distance (km)";
        $numberOfPassengeres = "Number of Passengers";
        $in_Time = "In Date/Time";
        $out_Time = "Out Date/Time";
    }
?>




            <?php
            if (($userRole !== '3') && ($userRole !== '4')) {
                $header ="View Odometer Details";

        } else {
           $header="ඔඩෝමීටර විස්තරය";
        }
        ?>





<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    if (($userRole !== '3') && ($userRole !== '4')) {
                        $this->breadcrumbs = array(
                            'Vehicle Booking' => array('tRVehicleBooking/booking'),
                            'View Odometer'
                        );
                    }

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $header?></h1>
                        <div style="float: right; margin-top: -30px">
<?php  echo  CHtml::link('<img src="images/add.png" class="addIcon"  />',array('bookingApproval/odometer&vehicleId=' . $vehicleId . '&Booking_Approval_ID=' . $model->Booking_Approval_ID . '&status=update'), array('title'=>'Add'))?>
                        </div>
                    </div>

                    
                </div>

                <div class="panel panel-default">
                

                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php
                        if (($userRole === '3') || ($userRole === '4')) {

                            $this->widget('zii.widgets.CDetailView', array(
                                'data' => $model,
                                'attributes' => array(
                                    array('label' => $vehicle, 'type' => 'raw', 'value' => CHtml::encode($model->approval->Vehicle_No)),
                                    array('label' => $fromDate, 'type' => 'raw', 'value' => CHtml::encode($model->approval->New_Booking_Request_Date)),
                                    array('label' => $toDateTime, 'type' => 'raw', 'value' => CHtml::encode($model->approval->New_Booking_To_Date)),
                                    array('label' => $placeFrom, 'type' => 'raw', 'value' => CHtml::encode($model->Place_from)),
                                    array('label' => $placeTo, 'type' => 'raw', 'value' => CHtml::encode($model->Place_to)),
                                    array('label' => $avarageDistance, 'type' => 'raw', 'value' => (!empty($model->Average_km)) ? CHtml::encode($model->Average_km) : '-'),
                                    array('label' => $numberOfPassengeres, 'type' => 'raw', 'value' => (!empty($model->approval->No_of_Pessengers)) ? CHtml::encode($model->approval->No_of_Pessengers) : '-'),
                                    array('label' => $out_Time, 'type' => 'raw', 'value' => CHtml::encode($model->approval->Out_Time)),
                                    array('label' => $in_Time, 'type' => 'raw', 'value' => CHtml::encode($model->approval->In_Time)),
                                    array('label' => $mileage, 'type' => 'raw', 'value' => (!empty($model->approval->Mileage)) ? CHtml::encode($model->approval->Mileage) : '-'),
                                ),
                            ));
                        } else {

                            $this->widget('zii.widgets.CDetailView', array(
                                'data' => $model,
                                'attributes' => array(
                                    array('label' => $vehicle, 'type' => 'raw', 'value' => CHtml::encode($model->approval->Vehicle_No)),
                                    array('label' => $fromDate, 'type' => 'raw', 'value' => CHtml::encode($model->approval->New_Booking_Request_Date)),
                                    array('label' => $toDateTime, 'type' => 'raw', 'value' => CHtml::encode($model->approval->New_Booking_To_Date)),
                                    array('label' => $placeFrom, 'type' => 'raw', 'value' => CHtml::encode($model->Place_from)),
                                    array('label' => $placeTo, 'type' => 'raw', 'value' => CHtml::encode($model->Place_to)),
                                    array('label' => $avarageDistance, 'type' => 'raw', 'value' => (!empty($model->Average_km)) ? CHtml::encode($model->Average_km) : '-'),
                                    array('label' => $numberOfPassengeres, 'type' => 'raw', 'value' => (!empty($model->approval->No_of_Pessengers)) ? CHtml::encode($model->approval->No_of_Pessengers) : '-'),
                                    array('label' => $out_Time, 'type' => 'raw', 'value' => CHtml::encode($model->approval->Out_Time)),
                                    array('label' => $in_Time, 'type' => 'raw', 'value' => CHtml::encode($model->approval->In_Time)),
                                    array('label' => $mileage, 'type' => 'raw', 'value' => (!empty($model->approval->Mileage)) ? CHtml::encode($model->approval->Mileage) : '-'),
                                    array('label' => 'Approved By', 'type' => 'raw', 'value' => (!empty($model->Approved_By)) ? CHtml::encode($model->Approved_By) : '-'),
                                    array('label' => 'Approved Date', 'type' => 'raw', 'value' => (!empty($model->Approved_Date)) ? CHtml::encode($model->Approved_Date) : '-'),
                                    'add_by',
                                    'add_date',
                                    $model->edit_by == 'Not Edited' ? array('label' => 'Edit By', 'value' => $model->edit_by, 'visible' => false) : array('label' => 'Edit By', 'value' => $model->edit_by, 'visible' => true),
                                    $model->edit_date == 'Not Edited' ? array('label' => 'Edit Date', 'value' => $model->edit_date, 'visible' => false) : array('label' => 'Edit Date', 'value' => $model->edit_date, 'visible' => true),
                                ),
                            ));
                        }
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