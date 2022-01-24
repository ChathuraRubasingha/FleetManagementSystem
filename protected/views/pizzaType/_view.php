<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pizza_type_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pizza_type_id), array('view', 'id'=>$data->pizza_type_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pizza_type')); ?>:</b>
	<?php echo CHtml::encode($data->pizza_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pizza_price')); ?>:</b>
	<?php echo CHtml::encode($data->pizza_price); ?>
	<br />


</div>