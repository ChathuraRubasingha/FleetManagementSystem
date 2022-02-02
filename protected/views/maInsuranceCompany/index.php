<?php
$this->breadcrumbs=array(
	'Ma Insurance Companys',
);

$this->menu=array(
	array('label'=>'Create Insurance Company', 'url'=>array('create')),
	array('label'=>'Manage Insurance Company', 'url'=>array('admin')),
);
?>

<h1>Insurance Companies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
