<?php
$this->breadcrumbs=array(
	'Manage'=>array('admin'),
	'View',

);

/*$this->menu=array(
	array('label'=>'List TRBookingRequest', 'url'=>array('index')),
	array('label'=>'Create TRBookingRequest', 'url'=>array('create')),
	array('label'=>'Update TRBookingRequest', 'url'=>array('update', 'id'=>$model->Booking_Request_ID)),
	array('label'=>'Delete TRBookingRequest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Booking_Request_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TRBookingRequest', 'url'=>array('admin')),
);*/
?>

<h1>View Booking Request </h1>

<div id="booking_approve" > 

     <div  class="group" style="width:400px; margin-left:80px" >

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'Booking_Request_ID',
				'User_ID',
				array('label'=>'Category Name', 'value'=>$model->vehicleCategory->Category_Name),
				'From',
				'To',
				'No_of_Passengers',
				array('label'=>'Allocation Type', 'value'=>$model->allocationType->Allocation_Type),
				'Description',
				'Requested_Date',
			),
		)); ?>

	</div>
       
</div>
