<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pizza_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pizza_id), array('view', 'id'=>$data->pizza_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pizza_name')); ?>:</b>
	<?php echo CHtml::encode($data->pizza_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pizza_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->pizza_type_id); ?>
	<br />


</div>