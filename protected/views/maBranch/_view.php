<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Branch_Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Branch_Id), array('view', 'id'=>$data->Branch_Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Branch')); ?>:</b>
	<?php echo CHtml::encode($data->Branch); ?>
	<br />


</div>