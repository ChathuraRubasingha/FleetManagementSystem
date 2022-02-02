<?php
$this->breadcrumbs=array(
	'Profiles Fields'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProfilesFields', 'url'=>array('index')),
	array('label'=>'Manage ProfilesFields', 'url'=>array('admin')),
);
?>

<h1>Create ProfilesFields</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>