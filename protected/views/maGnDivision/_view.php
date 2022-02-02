<?php
/* @var $this MaGnDivisionController */
/* @var $data MaGnDivision */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('GN_Division_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->GN_Division_ID), array('view', 'id'=>$data->GN_Division_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GN_Division')); ?>:</b>
	<?php echo CHtml::encode($data->GN_Division); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DS_Division_ID')); ?>:</b>
	<?php echo CHtml::encode($data->DS_Division_ID); ?>
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