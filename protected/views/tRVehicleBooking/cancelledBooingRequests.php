<?php
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
if (($userRole !== '3') && ($userRole !== '4')) {

    $this->breadcrumbs = array(
        'Vehicle Booking' => array('tRVehicleBooking/booking'),
        'Completed Booking Requests'
    );
} else {
    
}


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cancelled-booking-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<script type="text/javascript">

    /*$(document).ready(function(){
     
     $(".slidingDiv").hide();
     $(".show_hide").show();
     
     $('.show_hide').click(function(){
     $(".slidingDiv").slideToggle();
     });
     
     });*/

</script>
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
}

if (($userRole === '3') || ($userRole === '4')) {
    ?>
    <div class="group" style="height:60px; width:20%; float:left; margin-left:3%; margin-top:0">
        <div id="menu" style="padding-left:0%; padding-top:2%;"> 
            <ul>
                <li><?php echo CHtml::link('ඔඩෝමීටර විස්තරය සම්පූර්ණ කිරිම', array('/tRVehicleBooking/vehiclelist')); ?></li>

            </ul>

        </div></div>

    <?php
} else {
    ?>  

    <div class="group" style="height:290px; width:20%; float:left; margin-left:3%; margin-top:0">
        <div id="menu" style="padding-left:0%; padding-top:2%;">

            <ul>


                <li><?php echo CHtml::link('Booking Requests', array('/tRVehicleBooking/booking')); ?></li>
            <!--    <li><?php #echo CHtml::link('Bookings for Approvel',array('/tRVehicleBooking/admin'));   ?></li>-->
                <li><?php echo CHtml::link('Pending Booking Requests', array('/tRVehicleBooking/pendingBooking')); ?></li>
                <li><?php echo CHtml::link('Approved Booking Requests', array('/tRVehicleBooking/approvedBooking')); ?></li>
                <li><?php echo CHtml::link('Assigned Booking Requests', array('/tRVehicleBooking/assignedVehicle')); ?></li>
                <li><?php echo CHtml::link('Disapproved Booking Requests', array('/tRVehicleBooking/disapprovedBooking')); ?></li>
                <li><?php echo CHtml::link('Rejected Booking Requests', array('/tRVehicleBooking/RejectedBooking')); ?></li>
                <li><?php echo CHtml::link('Odometer', array('/tRVehicleBooking/vehiclelist')); ?></li>
                <li><?php echo CHtml::link('Completed Booking Requests', array('/tRVehicleBooking/completedBooking')); ?></li>
            </ul>

        </div>
    </div>

    <?php
}
?>






<?php #echo CHtml::link('<img src="images/Approved-1.png"  width="0px" height="0px"/>','#',array('class'=>'show_hide'));  ?>



<div class="group" style="width:86.67%; margin-left:29.7%; margin-top:2.4%">
<?php
if (($userRole !== '3') && ($userRole !== '4')) {
    ?>
        <h1>Completed Vehicle Booking Requests Registry</h1>
        <?php
    } else {
        ?>
        <h1>සම්පූර්ණ කල අයදුම් විස්තරය </h1>
        <?php
    }
    ?>


    <!-- <div style="margin-left:800px">
    <?php #echo CHtml::link('<img src="images/Search.gif"  width="0px" height="0px"/>','#',array('class'=>'search-button')); ?>
     </div>
     <div class="search-form" style="display:none">
    <?php /* $this->renderPartial('_search',array(
      'model'=>$model,
      )); */ ?>
     </div>  search-form -->

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'cancelled-booking-grid',
        'dataProvider' => $model->getCancelledBooking(),
        //'filter'=>$model,
        'columns' => array(
            array('name' => 'Vehicle_No', 'header' => $vehicle, 'value' => '$data->approval->Vehicle_No'),
//            'Vehicle_No',
            # array('name'=>'Requested vehicle Category', 'header'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
            'Requested_Date',
            array('name' => 'username', 'header' => $requestedBy, 'value' => '$data->user->username'),
            array('name' => 'Place_from', 'header' => $placeFrom, 'value' => '$data->Place_from'),
//            'Place_from',
            array('name' => 'Place_to', 'header' => $placeTo, 'value' => '$data->Place_to'),
//            'Place_to',
            array('name' => 'In_Time', 'header' => $in_Time, 'value' => '$data->getRelated("approval")->In_Time'),
            array('name' => 'Out_Time', 'header' => $out_Time, 'value' => '$data->getRelated("approval")->Out_Time'),
//                        'In_Time',
//                        'Out_Time',
//			  'Mileage',
            array('name' => 'Mileage', 'header' => $mileage, 'value' => '$data->getRelated("approval")->Mileage'), #array('name'=>'Vehicle_No', 'header'=>'Assigned Vehicle'),
            #array('name'=>'Full_Name', 'header'=>'Assigned Driver', 'value'=>'$data->driver->Full_Name'),
            #array('name'=>'Full_Name', 'header'=>'Assigned Driver', 'value'=>'$data->driver->Full_Name'),
            #'Approved_Date',
            #'Approved_By',
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}',
                'viewButtonUrl' => 'Yii::app()->createUrl("/tRVehicleBooking/viewOdometer", array("id" =>     
					$data["Booking_Request_ID"], "vehicleNo" =>$data["Vehicle_No"], "status"=>"completed"))',
            )),
    ));
    ?>
</div>
<!--<a href="#" class="show_hide">hide</a></div>
-->

