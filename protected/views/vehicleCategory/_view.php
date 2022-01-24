<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_Category_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Vehicle_Category_ID), array('view', 'id'=>$data->Vehicle_Category_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Category_Name')); ?>:</b>
	<?php echo CHtml::encode($data->Category_Name); ?>
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