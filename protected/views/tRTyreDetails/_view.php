
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tyre_Details_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Tyre_Details_ID), array('view', 'id'=>$data->Tyre_Details_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Driver_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Driver_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tyre_Type_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Tyre_Type_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tyre_Size_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Tyre_Size_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Approved_By')); ?>:</b>
	<?php echo CHtml::encode($data->Approved_By); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Approved_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Approved_Date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Replace_Status')); ?>:</b>
	<?php echo CHtml::encode($data->Replace_Status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Replace_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Replace_Date); ?>
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

	*/ ?>

</div>