<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fuel_Request_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Fuel_Request_ID), array('view', 'id'=>$data->Fuel_Request_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Required_Fuel_Capacity')); ?>:</b>
	<?php echo CHtml::encode($data->Required_Fuel_Capacity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Driver_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Driver_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Request_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Request_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fuel_Balance')); ?>:</b>
	<?php echo CHtml::encode($data->Fuel_Balance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Meter_Reading')); ?>:</b>
	<?php echo CHtml::encode($data->Meter_Reading); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Approve_Status')); ?>:</b>
	<?php echo CHtml::encode($data->Approve_Status); ?>
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