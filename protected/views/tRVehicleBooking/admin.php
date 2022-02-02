<?php
$this->breadcrumbs=array(
	'Vehicle Booking'=>array('tRVehicleBooking/booking'),
	'Booking For Approval'
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trvehicle-booking-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>




<div class="group" style="height:235px; width:20%; float:left; margin-left:3%; margin-top:2.3%">
        <div id="menu" style="padding-left:2%; padding-top:2%;">
        
        <ul>
        
        <li><?php echo CHtml::link('Booking Requests',array('/tRVehicleBooking/booking')); ?></li>
    <!--    <li><?php #echo CHtml::link('Bookings for Approvel',array('/tRVehicleBooking/admin')); ?></li>-->
        <li><?php echo CHtml::link('Pending Booking Requests',array('/tRVehicleBooking/pendingBooking')); ?></li>
        <li><?php echo CHtml::link('Approved Booking Requests',array('/tRVehicleBooking/approvedBooking')); ?></li>
        <li><?php echo CHtml::link('Assigned Booking Requests',array('/tRVehicleBooking/assignedVehicle')); ?></li>
        <li><?php echo CHtml::link('Disapproved Booking Requests',array('/tRVehicleBooking/RejectedBooking')); ?></li>
        <li><?php echo CHtml::link('Rejected Booking Requests',array('/tRVehicleBooking/RejectedBooking')); ?></li>
        <li><?php echo CHtml::link('Odometer',array('/tRVehicleBooking/vehiclelist')); ?></li>
        
        </ul>
        
        </div>
</div>



    

<a href="#" class="show_hide" style="padding-left:40px; display:none"><img src="images/Approved-1.png" /></a>
<?php echo CHtml::link('<img src="images/Approved-1.png"  width="0px" height="0px"/>','#',array('class'=>'show_hide')); ?>
   
    <div class="slidingDiv">
    
        <div class="group" style="width:80%; margin-left:33%; margin-top:2.4%">
                <h1>Approved Vehicle Booking Requests</h1>
                
                <div style="margin-left:80%">
                <?php echo CHtml::link('<img src="images/Search.gif"  width="0px" height="0px"/>','#',array('class'=>'search-button')); ?>
                </div>
                <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                    'model'=>$model, 
                )); ?>
                </div><!-- search-form -->
                
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'trvehicle-booking-grid',
                    'dataProvider'=>$model->search(),
                    //'filter'=>$model,
                    'columns'=>array(
                        //array('name'=>'Requested vehicle Category', 'header'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
						'Requested_Date',
                      array('name'=>'username', 'header'=>'Requested By', 'value'=>'$data->user->username'),
						'Place_from',
                        'Place_to',
                        //'From',
                        //'To',
						
						array('name'=>'Vehicle_No', 'header'=>'Assigned Vehicle'),
						#array('name'=>'Full_Name', 'header'=>'Assigned Driver', 'value'=>'$data->driver->Full_Name'),
						#array('name'=>'Full_Name', 'header'=>'Assigned Driver', 'value'=>'$data->driver->Full_Name'),
						'Approved_Date',
						'Approved_By',
						array(
			'class'=>'CButtonColumn'),
                      ),
                )); ?>
        </div>
    <!--<a href="#" class="show_hide">hide</a></div>
    -->
    </div> 
   
   
