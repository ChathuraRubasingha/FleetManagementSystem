<?php
$this->breadcrumbs=array(
	'Profiles Fields'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List ProfilesFields', 'url'=>array('index')),
	array('label'=>'Create ProfilesFields', 'url'=>array('create')),
	array('label'=>'Update ProfilesFields', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProfilesFields', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProfilesFields', 'url'=>array('admin')),
);
?>

<h1>View ProfilesFields #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'varname',
		'title',
		'field_type',
		'field_size',
		'field_size_min',
		'required',
		'match',
		'range',
		'error_message',
		'other_validator',
		'default',
		'widget',
		'widgetparams',
		'position',
		'visible',
		'createtime',
	),
)); ?>
