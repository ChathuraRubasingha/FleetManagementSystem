<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Supplier_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Supplier_ID), array('view', 'id'=>$data->Supplier_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Supplier_Name')); ?>:</b>
	<?php echo CHtml::encode($data->Supplier_Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Address')); ?>:</b>
	<?php echo CHtml::encode($data->Address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Contact_Person')); ?>:</b>
	<?php echo CHtml::encode($data->Contact_Person); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Land_phone_No')); ?>:</b>
	<?php echo CHtml::encode($data->Land_phone_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Mobile')); ?>:</b>
	<?php echo CHtml::encode($data->Mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fax')); ?>:</b>
	<?php echo CHtml::encode($data->Fax); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Email')); ?>:</b>
	<?php echo CHtml::encode($data->Email); ?>
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