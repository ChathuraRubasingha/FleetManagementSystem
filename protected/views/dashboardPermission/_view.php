<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Role_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Role_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Dashboard_Item_ID')); ?>:</b>
	<?php echo CHtml::encode($data->Dashboard_Item_ID); ?>
	<br />


</div>