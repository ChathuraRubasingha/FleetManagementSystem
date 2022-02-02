<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Services_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Services_ID), array('view', 'id'=>$data->Services_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Service_Station_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Service_Station_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Service_Type_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Service_Type_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Service_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Service_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Meter_Reading')); ?>:</b>
	<?php echo CHtml::encode($data->Meter_Reading); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Driving_Distance')); ?>:</b>
	<?php echo CHtml::encode($data->Driving_Distance); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Description')); ?>:</b>
	<?php echo CHtml::encode($data->Description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estimate_Cost')); ?>:</b>
	<?php echo CHtml::encode($data->Estimate_Cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Approved_By')); ?>:</b>
	<?php echo CHtml::encode($data->Approved_By); ?>
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