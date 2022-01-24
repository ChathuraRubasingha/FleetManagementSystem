<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Battery_Details_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Battery_Details_ID), array('view', 'id'=>$data->Battery_Details_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Driver_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Driver_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Battery_Type_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Battery_Type_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Approved_By')); ?>:</b>
	<?php echo CHtml::encode($data->Approved_By); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Approved_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Approved_Date); ?>
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