<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Repairs_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Repairs_ID), array('view', 'id'=>$data->Repairs_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Total_Cost')); ?>:</b>
	<?php echo CHtml::encode($data->Total_Cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Repairs_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Repairs_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Garage_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Garage_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Repairs_Type_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Repairs_Type_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_by')); ?>:</b>
	<?php echo CHtml::encode($data->add_by); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('add_date')); ?>:</b>
	<?php echo CHtml::encode($data->add_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('edit_by')); ?>:</b>
	<?php echo CHtml::encode($data->edit_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('edit_date')); ?>:</b>
	<?php echo CHtml::encode($data->edit_date); ?>
	<br />

	*/ ?>

</div>