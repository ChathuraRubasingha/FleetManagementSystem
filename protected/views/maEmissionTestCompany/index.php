<?php
$this->breadcrumbs=array(
	'Ma Emission Test Companys',
);

$this->menu=array(
	array('label'=>'Create Emission Test Company', 'url'=>array('create')),
	array('label'=>'Manage Emission Test Company', 'url'=>array('admin')),
);
?>

<h1>Emission Test Companies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
