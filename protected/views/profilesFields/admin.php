<?php
$this->breadcrumbs=array(
	'Profiles Fields'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProfilesFields', 'url'=>array('index')),
	array('label'=>'Create ProfilesFields', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('profiles-fields-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Profiles Fields</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'profiles-fields-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'varname',
		'title',
		'field_type',
		'field_size',
		'field_size_min',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
