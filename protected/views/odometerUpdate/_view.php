<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->update_id), array('view', 'id'=>$data->update_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Driver_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Driver_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remark_id')); ?>:</b>
	<?php echo CHtml::encode($data->remark_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_time')); ?>:</b>
	<?php echo CHtml::encode($data->in_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_time')); ?>:</b>
	<?php echo CHtml::encode($data->out_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_odo_reading')); ?>:</b>
	<?php echo CHtml::encode($data->out_odo_reading); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('in_odo_reading')); ?>:</b>
	<?php echo CHtml::encode($data->in_odo_reading); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_by')); ?>:</b>
	<?php echo CHtml::encode($data->added_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	*/ ?>

</div>