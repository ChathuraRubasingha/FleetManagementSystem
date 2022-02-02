<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Insurance_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Insurance_ID), array('view', 'id'=>$data->Insurance_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Insurance_Company_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Insurance_Company_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Insurance_Type_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Insurance_Type_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Amount')); ?>:</b>
	<?php echo CHtml::encode($data->Amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Date_of_Insurance')); ?>:</b>
	<?php echo CHtml::encode($data->Date_of_Insurance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Valid_From')); ?>:</b>
	<?php echo CHtml::encode($data->Valid_From); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Valid_To')); ?>:</b>
	<?php echo CHtml::encode($data->Valid_To); ?>
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