<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Driver_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Driver_ID), array('view', 'id'=>$data->Driver_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Full_Name')); ?>:</b>
	<?php echo CHtml::encode($data->Full_Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Location_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Location_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NIC')); ?>:</b>
	<?php echo CHtml::encode($data->NIC); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Status')); ?>:</b>
	<?php echo CHtml::encode($data->Status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Mobile')); ?>:</b>
	<?php echo CHtml::encode($data->Mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Private_Address')); ?>:</b>
	<?php echo CHtml::encode($data->Private_Address); ?>
	<br />

	<?php /*
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