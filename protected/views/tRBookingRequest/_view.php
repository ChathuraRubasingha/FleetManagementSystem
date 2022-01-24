<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Booking_Request_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Booking_Request_ID), array('view', 'id'=>$data->Booking_Request_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('User_ID')); ?>:</b>
	<?php echo CHtml::encode($data->User_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_Category_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_Category_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('From')); ?>:</b>
	<?php echo CHtml::encode($data->From); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('To')); ?>:</b>
	<?php echo CHtml::encode($data->To); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('No_of_Passengers')); ?>:</b>
	<?php echo CHtml::encode($data->No_of_Passengers); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Booking_Status')); ?>:</b>
	<?php echo CHtml::encode($data->Booking_Status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Allocation_Type_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Allocation_Type_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Description')); ?>:</b>
	<?php echo CHtml::encode($data->Description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Requested_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Requested_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_by')); ?>:</b>
	<?php echo CHtml::encode($data->add_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_date')); ?>:</b>
	<?php echo CHtml::encode($data->add_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('edit_by')); ?>:</b>
	<?php echo CHtml::encode($data->edit_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('edit_date')); ?>:</b>
	<?php echo CHtml::encode($data->edit_date); ?>
	<br />

	*/ ?>

</div>