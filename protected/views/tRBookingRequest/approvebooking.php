<?php
/*$this->breadcrumbs=array(
	'Manage'=>array('admin'),
	'View',

);*/
?>

<h1>Approve Booking Request </h1>

<!--<div id="booking_approve" > 

     <div  class="group" style="width:400px; margin-left:80px" >-->

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$rr,
			'attributes'=>array(
				'Booking_Request_ID',
				'User_ID',
				array('label'=>'Category Name', 'value'=>$rr->vehicleCategory->Category_Name),
				'From',
				'To',
				'No_of_Passengers',
				array('label'=>'Allocation Type', 'value'=>$rr->allocationType->Allocation_Type),
				'Description',
				'Requested_Date',
			),
		)); ?>

	<!--</div>
    
    <br/>
    
    <div  class="group" style="width:400px; margin-left:80px" >-->
    
		<?php /*?><?php echo $this->renderPartial('//tRVehicleBooking/create', array('Booking'=>$Booking)); ?><?php */?>

    <!--</div>
    
</div>-->
