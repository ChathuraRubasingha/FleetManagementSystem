<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fitness_Test_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Fitness_Test_ID), array('view', 'id'=>$data->Fitness_Test_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Garage_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Garage_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Valid_From')); ?>:</b>
	<?php echo CHtml::encode($data->Valid_From); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Valid_To')); ?>:</b>
	<?php echo CHtml::encode($data->Valid_To); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fitness_Test_Result')); ?>:</b>
	<?php echo CHtml::encode($data->Fitness_Test_Result); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Amount')); ?>:</b>
	<?php echo CHtml::encode($data->Amount); ?>
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