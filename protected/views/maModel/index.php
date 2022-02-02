<?php
$this->breadcrumbs=array(
	'Ma Models',
);

$this->menu=array(
	array('label'=>'Create MaModel', 'url'=>array('create')),
	array('label'=>'Manage MaModel', 'url'=>array('admin')),
);
?>

<h1>Ma Models</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
