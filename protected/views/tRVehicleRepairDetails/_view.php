<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Repair_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Repair_ID), array('view', 'id'=>$data->Repair_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estimate_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Estimate_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Garage_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Garage_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Repair_Cost')); ?>:</b>
	<?php echo CHtml::encode($data->Repair_Cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Description_Of_Repair')); ?>:</b>
	<?php echo CHtml::encode($data->Description_Of_Repair); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Repaired_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Repaired_Date); ?>
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