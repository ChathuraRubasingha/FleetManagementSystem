<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('VehicleTransfer_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->VehicleTransfer_ID), array('view', 'id'=>$data->VehicleTransfer_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('From_Location_ID')); ?>:</b>
	<?php echo CHtml::encode($data->From_Location_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('To_Location_ID')); ?>:</b>
	<?php echo CHtml::encode($data->To_Location_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('From_Date')); ?>:</b>
	<?php echo CHtml::encode($data->From_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('To_Date')); ?>:</b>
	<?php echo CHtml::encode($data->To_Date); ?>
	<br />


</div>