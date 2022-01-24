<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('remark_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->remark_id), array('view', 'id'=>$data->remark_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_by')); ?>:</b>
	<?php echo CHtml::encode($data->added_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_date')); ?>:</b>
	<?php echo CHtml::encode($data->added_date); ?>
	<br />


</div>