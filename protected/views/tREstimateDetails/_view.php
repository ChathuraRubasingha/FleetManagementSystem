<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estimate_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Estimate_ID), array('view', 'id'=>$data->Estimate_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Accident_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Accident_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Damage_Estimate')); ?>:</b>
	<?php echo CHtml::encode($data->Damage_Estimate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estimated_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Estimated_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Description')); ?>:</b>
	<?php echo CHtml::encode($data->Description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_by')); ?>:</b>
	<?php echo CHtml::encode($data->add_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_date')); ?>:</b>
	<?php echo CHtml::encode($data->add_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('edit_by')); ?>:</b>
	<?php echo CHtml::encode($data->edit_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('edit_date')); ?>:</b>
	<?php echo CHtml::encode($data->edit_date); ?>
	<br />

	*/ ?>

</div>