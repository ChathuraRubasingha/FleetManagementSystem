<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Make_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Make_ID), array('view', 'id'=>$data->Make_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Make')); ?>:</b>
	<?php echo CHtml::encode($data->Make); ?>
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