<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estimate_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Estimate_ID), array('view', 'id'=>$data->Estimate_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Request_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Request_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vehicle_No')); ?>:</b>
	<?php echo CHtml::encode($data->Vehicle_No); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Garage_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Garage_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Total_Estimate')); ?>:</b>
	<?php echo CHtml::encode($data->Total_Estimate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estimate_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Estimate_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Approved_By')); ?>:</b>
	<?php echo CHtml::encode($data->Approved_By); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Approved_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Approved_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estimate_Status')); ?>:</b>
	<?php echo CHtml::encode($data->Estimate_Status); ?>
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