<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fuel_Providing_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Fuel_Providing_ID), array('view', 'id'=>$data->Fuel_Providing_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fuel_Request_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Fuel_Request_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fuel_Order_No')); ?>:</b>
	<?php echo CHtml::encode($data->Fuel_Order_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fuel_Station')); ?>:</b>
	<?php echo CHtml::encode($data->Fuel_Station); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fuel_Type_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Fuel_Type_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fuel_Pumped_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Fuel_Pumped_Date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Fuel_Amount')); ?>:</b>
	<?php echo CHtml::encode($data->Fuel_Amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Payable_Amount')); ?>:</b>
	<?php echo CHtml::encode($data->Payable_Amount); ?>
	<br />

	*/ ?>

</div>