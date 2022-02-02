<div class="view">
	    
	

	<b><?php echo CHtml::encode($data->getAttributeLabel('Accident_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Accident_ID), array('view', 'id'=>$data->Accident_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Accident_Place')); ?>:</b>
	<?php echo CHtml::encode($data->Accident_Place); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Date_and_Time')); ?>:</b>
	<?php echo CHtml::encode($data->Date_and_Time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Details')); ?>:</b>
	<?php echo CHtml::encode($data->Details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Police_Station')); ?>:</b>
	<?php echo CHtml::encode($data->Police_Station); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Address')); ?>:</b>
	<?php echo CHtml::encode($data->Address); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Driver_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Driver_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Police_Report_No')); ?>:</b>
	<?php echo CHtml::encode($data->Police_Report_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Accident_Type')); ?>:</b>
	<?php echo CHtml::encode($data->Accident_Type); ?>
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