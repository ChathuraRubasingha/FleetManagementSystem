<?php
$this->breadcrumbs=array(
	'Odometer Updates'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OdometerUpdate', 'url'=>array('index')),
	array('label'=>'Create OdometerUpdate', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('odometer-update-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Odometer Updates</h1>

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
	'id'=>'odometer-update-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'update_id',
		'Vehicle_No',
		'Driver_ID',
		'remark_id',
		'in_time',
		'out_time',
		/*
		'out_odo_reading',
		'in_odo_reading',
		'added_by',
		'description',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
