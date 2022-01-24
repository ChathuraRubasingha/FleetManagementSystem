<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Claime_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Claime_ID), array('view', 'id'=>$data->Claime_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Insurance_Company_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Insurance_Company_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Claime_Amount')); ?>:</b>
	<?php echo CHtml::encode($data->Claime_Amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Claime_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Claime_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Recovered_from_Driver')); ?>:</b>
	<?php echo CHtml::encode($data->Recovered_from_Driver); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estimate_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Estimate_ID); ?>
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