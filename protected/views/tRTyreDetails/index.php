<div class="group">

<?php
$this->breadcrumbs=array(
	'Tyre Details'=>array('tRTyreDetails/tyre'),
	
);

$this->menu=array(
	array('label'=>'Create TRTyreDetails', 'url'=>array('create')),
	array('label'=>'Manage TRTyreDetails', 'url'=>array('admin')),
);
?>

<h1>Trtyre Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>