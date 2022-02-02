<?php
/* @var $this MaProvincialCouncilsController */
/* @var $data MaProvincialCouncils */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Provincial_Councils_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Provincial_Councils_ID), array('view', 'id'=>$data->Provincial_Councils_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Provincial_Councils_Name')); ?>:</b>
	<?php echo CHtml::encode($data->Provincial_Councils_Name); ?>
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