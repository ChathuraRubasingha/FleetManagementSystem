<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Request_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Request_ID), array('view', 'id'=>$data->Request_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Driver_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Driver_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Description_Of_Failure')); ?>:</b>
	<?php echo CHtml::encode($data->Description_Of_Failure); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Request_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Request_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Request_Status')); ?>:</b>
	<?php echo CHtml::encode($data->Request_Status); ?>
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