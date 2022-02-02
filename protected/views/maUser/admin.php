<?php
/* @var $this MaUserController */
/* @var $model MaUser */

$this->breadcrumbs=array(
	'User'=>array('site/accesscontrol'),
	
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create')),
	//array('label'=>'Manage User', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ma-user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="group">
<h1>Manage Users</h1>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

<?php echo CHtml::link('<img src="images/Search.gif"  width="0px" height="0px"/>','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ma-user-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		//'User_ID',
		'Full_Name',
		'Location_ID',
		/*'Mobile',
		'Address',
		'NIC',
		'Email',
		'Designation_ID',
		'UserName',
		'Password',*/
		'Role_ID',
/*		'add_by',
		'add_date',
		'edit_by',
		'edit_date',*/

		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>
