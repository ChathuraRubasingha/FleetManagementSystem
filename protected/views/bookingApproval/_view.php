<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Booking_Approval_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Booking_Approval_ID), array('view', 'id'=>$data->Booking_Approval_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Approved_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Approved_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('New_Booking_Request_Date')); ?>:</b>
	<?php echo CHtml::encode($data->New_Booking_Request_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('In_Time')); ?>:</b>
	<?php echo CHtml::encode($data->In_Time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Out_Time')); ?>:</b>
	<?php echo CHtml::encode($data->Out_Time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Mileage')); ?>:</b>
	<?php echo CHtml::encode($data->Mileage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('No_of_Pessengers')); ?>:</b>
	<?php echo CHtml::encode($data->No_of_Pessengers); ?>
	<br />


</div>