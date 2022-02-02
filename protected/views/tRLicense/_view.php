<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('License_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->License_ID), array('view', 'id'=>$data->License_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Amount')); ?>:</b>
	<?php echo CHtml::encode($data->Amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Date_of_License')); ?>:</b>
	<?php echo CHtml::encode($data->Date_of_License); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Valid_From')); ?>:</b>
	<?php echo CHtml::encode($data->Valid_From); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Valid_To')); ?>:</b>
	<?php echo CHtml::encode($data->Valid_To); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Emission_test_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Emission_test_ID); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Fitness_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Fitness_ID); ?>
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