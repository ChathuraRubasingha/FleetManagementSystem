<?php
$this->breadcrumbs=array(
	'Reject Request'=>array('tRVehicleBooking/approvedBooking'),
	'Reject Request',
);
?>

<div class="group" style="width:220px; height:270px; float:left; margin-left:65px; margin-top:24px">
        <div id="menu" style="padding-left:10px; padding-top:15px; height:50px ">
        
        <ul>
        
        
        <li><?php echo CHtml::link('Booking Requests',array('/tRVehicleBooking/booking')); ?></li>
    <!--    <li><?php #echo CHtml::link('Bookings for Approvel',array('/tRVehicleBooking/admin')); ?></li>-->
        <li><?php echo CHtml::link('Pending Booking Requests',array('/tRVehicleBooking/pendingBooking')); ?></li>
        <li><?php echo CHtml::link('Approved Booking Requests',array('/tRVehicleBooking/approvedBooking')); ?></li>
        <li><?php echo CHtml::link('Disapproved Booking Requests',array('/tRVehicleBooking/disapprovedBooking')); ?></li>
        <li><?php echo CHtml::link('Rejected Booking Requests',array('/tRVehicleBooking/RejectedBooking')); ?></li>
        <li><?php echo CHtml::link('Odometer',array('/tRVehicleBooking/vehiclelist')); ?></li>
        <li><?php echo CHtml::link('Completed Booking Requests',array('/tRVehicleBooking/completedBooking')); ?></li>
        </ul>
        
        </div>
</div>



<div class="groups" style="margin-left:360px; height:160px">

<h1>Reject Approved Booking Request</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
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
	),
)); ?>
<div class="row buttons" style="margin-left:500px; margin-top:10px">
<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Approve'); ?>
            <?php //echo CHtml::button('Disapprove', array('submit' => array('TRVehicleBooking/DisApprove')),array('id'=>$id)); ?>
           
            <?php echo CHtml::submitbutton('Reject', array('id'=>'Reject_btn')); ?> 
             &nbsp;&nbsp;&nbsp;&nbsp;
           	<?php # echo CHtml::submitbutton('Disapprove', array('id'=>'Disapprove_btn')); ?>
            
         
			 <script type="text/javascript">
             $(document).ready(function(){
            
                $('#Reject_btn').click(function(){
                    window.location = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=/tRVehicleBooking/rejectRequest&ReqID=<?php echo Yii::app()->request->getQuery('ReqID'); ?>";
                    });	 
            });
           </script>
</div>

</div>

