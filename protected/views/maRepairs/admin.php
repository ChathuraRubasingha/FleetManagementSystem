<?php
$this->breadcrumbs=array(
	'Maintenance'=>array('site/maintenance'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'Repairs', 'url'=>array('index')),
	array('label'=>'Create Repairs', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ma-repairs-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="group">
<h1>Manage Repairs</h1>



<?php echo CHtml::link('<img src="images/Search.gif"  width="0px" height="0px"/>','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ma-repairs-grid',
	'dataProvider'=>$model->getRepairHistory(),
	//'filter'=>$model,
	'columns'=>array(
		//'Repairs_ID',
		'Vehicle_No',
		'Total_Cost',
		'Repairs_Date',
		//'Garage_ID',
		array('name'=>'Garage_Name', 'header'=>'Garage Name', 'value'=>'$data->garage->Garage_Name'),
		//'Repairs_Type_ID',
		array('name'=>'Repairs_Type', 'header'=>'Repairs Type', 'value'=>'$data->repairsType->Repairs_Type'),
		/*
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>
