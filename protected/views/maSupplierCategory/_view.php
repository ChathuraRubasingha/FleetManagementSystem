<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Supplier_Category_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Supplier_Category_ID), array('view', 'id'=>$data->Supplier_Category_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Replacement_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Replacement_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Supplier_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Supplier_ID); ?>
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