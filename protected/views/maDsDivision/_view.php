<?php
/* @var $this MaDsDivisionController */
/* @var $data MaDsDivision */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('DS_Division_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->DS_Division_ID), array('view', 'id'=>$data->DS_Division_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DS_Division')); ?>:</b>
	<?php echo CHtml::encode($data->DS_Division); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('District_ID')); ?>:</b>
	<?php echo CHtml::encode($data->District_ID); ?>
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


</div>