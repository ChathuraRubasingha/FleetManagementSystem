<?php
/* @var $this MaLocationController */
/* @var $data MaLocation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Location_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Location_ID), array('view', 'id'=>$data->Location_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Provincial_Councils_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Provincial_Councils_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('District_ID')); ?>:</b>
	<?php echo CHtml::encode($data->District_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DS_Division_ID')); ?>:</b>
	<?php echo CHtml::encode($data->DS_Division_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GN_Division_ID')); ?>:</b>
	<?php echo CHtml::encode($data->GN_Division_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Location_Name')); ?>:</b>
	<?php echo CHtml::encode($data->Location_Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Address')); ?>:</b>
	<?php echo CHtml::encode($data->Address); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Telephone')); ?>:</b>
	<?php echo CHtml::encode($data->Telephone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fax')); ?>:</b>
	<?php echo CHtml::encode($data->Fax); ?>
	<br />

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