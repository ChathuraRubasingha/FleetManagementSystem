<?php
$this->breadcrumbs=array(
	'Profiles Fields'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProfilesFields', 'url'=>array('index')),
	array('label'=>'Create ProfilesFields', 'url'=>array('create')),
	array('label'=>'View ProfilesFields', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProfilesFields', 'url'=>array('admin')),
);
?>

<h1>Update ProfilesFields <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>