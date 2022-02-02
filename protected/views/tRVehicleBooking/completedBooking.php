<?php
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
if (($userRole !== '3') && ($userRole !== '4')) {


} else {
    
}


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('completed-booking-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php
if (($userRole === '3') || ($userRole === '4')) {   //trans lating to sinhala
    $vehicle = "වාහන අංකය";
    $requestedBy = "අයදුම්කරු ";
    $placeFrom = "ස්ථානයේ සිට ";
    $placeTo = "ස්ථානය දක්වා ";
    $driveHeader = "රියැදුරු";
    $approvedDate = "අනුමත දිනය/වෙලාව";
    $in_Time = "පැමිණි  දිනය/ වෙලාව ";
    $out_Time = "පිට වූ දිනය/ වෙලාව ";
    $mileage = "කිලෝමීටර ගණන";
    $newBookinRequestDate = "";
} else {
    $vehicle = "Vehicle No";
    $requestedBy = "Requested By";
    $placeFrom = "Place From";
    $placeTo = "Place To (Nearest City)";
    $driveHeader = "Driver";
    $approvedDate = "Approved Date";
    $in_Time = "In Date/Time";
    $out_Time = "Out Date/Time";
    $mileage = "Mileage";
    $newBookinRequestDate = "New Booking Request Date";
}

  ?>



    <?php
    if (($userRole !== '3') && ($userRole !== '4')) {
        $header ="Completed Vehicle Booking Requests Registry";

    } else {
       $header="සම්පූර්ණ කල අයදුම් විස්තරය ";
    }
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
                            'Completed Booking Requests'
                        );
                    }


                    ?>
                </ul>
            </div>
            <div class="col-xs-8">


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $header?></h1>
                    </div>

                </div>
                <div class="panel panel-default">
                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'completed-booking-grid',
                            'dataProvider' => $model->getCompletedBooking(),
                            //'filter'=>$model,
                            'columns' => array(
                                array('name' => 'Vehicle_No', 'header' => $vehicle, 'value' => '$data->Vehicle_No'),
                                'Requested_Date',
                                array('name' => 'Place_from', 'header' => $placeFrom, 'value' => '$data->Place_from'),
                                array('name' => 'Place_to', 'header' => $placeTo, 'value' => '$data->Place_to'),
                                array('name' => 'In_Time', 'header' => $in_Time, 'value' => '$data->In_Time'),
                                array('name' => 'Out_Time', 'header' => $out_Time, 'value' => '$data->Out_Time'),
                                array('name' => 'Mileage', 'header' => $mileage, 'value' => '$data->Mileage'),
                                array(
                                    'class' => 'CButtonColumn',
                                    'template' => '{view}',
                                    'viewButtonUrl' => 'Yii::app()->createUrl("/tRVehicleBooking/viewOdometer", array("id" =>
					$data["Booking_Request_ID"], "vehicleNo" =>$data["Vehicle_No"], "status"=>"completed", "menuId"=>"vehibooking"))',
                                )),
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