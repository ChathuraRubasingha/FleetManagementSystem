<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Garage_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Garage_ID), array('view', 'id'=>$data->Garage_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Garage_Type_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Garage_Type_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Garage_Name')); ?>:</b>
	<?php echo CHtml::encode($data->Garage_Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Land_Phone_No')); ?>:</b>
	<?php echo CHtml::encode($data->Land_Phone_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Mobile_No')); ?>:</b>
	<?php echo CHtml::encode($data->Mobile_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fax')); ?>:</b>
	<?php echo CHtml::encode($data->Fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Email')); ?>:</b>
	<?php echo CHtml::encode($data->Email); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Contact_No')); ?>:</b>
	<?php echo CHtml::encode($data->Contact_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Registration_No')); ?>:</b>
	<?php echo CHtml::encode($data->Registration_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Owner_Name')); ?>:</b>
	<?php echo CHtml::encode($data->Owner_Name); ?>
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