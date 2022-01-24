<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Row')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Row), array('view', 'id'=>$data->Row)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Configuration_Name')); ?>:</b>
	<?php echo CHtml::encode($data->Configuration_Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Value')); ?>:</b>
	<?php echo CHtml::encode($data->Value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Description')); ?>:</b>
	<?php echo CHtml::encode($data->Description); ?>
	<br />


</div>