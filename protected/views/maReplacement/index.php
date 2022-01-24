<?php
$this->breadcrumbs=array(
	'Ma Replacements',
);

$this->menu=array(
	array('label'=>'Create Replacement', 'url'=>array('create')),
	array('label'=>'Manage Replacement', 'url'=>array('admin')),
);
?>

<h1>Replacements</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
