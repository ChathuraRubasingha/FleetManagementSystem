<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_Location_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Vehicle_Location_ID), array('view', 'id'=>$data->Vehicle_Location_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Location_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Location_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('From_Date')); ?>:</b>
	<?php echo CHtml::encode($data->From_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('To_Date')); ?>:</b>
	<?php echo CHtml::encode($data->To_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Driver_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Driver_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_by')); ?>:</b>
	<?php echo CHtml::encode($data->add_by); ?>
	<br />

	<?php /*
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