<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tyre_Size_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Tyre_Size_ID), array('view', 'id'=>$data->Tyre_Size_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tyre_Size')); ?>:</b>
	<?php echo CHtml::encode($data->Tyre_Size); ?>
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