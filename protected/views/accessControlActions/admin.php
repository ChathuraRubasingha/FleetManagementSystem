<?php
$this->breadcrumbs=array(
	'Access'=>array('accessPermission/accesscontrol'),
	'Update Actions',
);

$this->menu=array(
	//array('label'=>'List AccessControlActions', 'url'=>array('index')),
	//array('label'=>'Create AccessControlActions', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function()
{
	
	if ($('.search-form').is(':hidden')) 
	{
		$('.search-form').toggle();
		return false;
	}
	else 
	{
		location.reload();
		return false;
	}
	
	
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('access-control-actions-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="group" style="height:175px; width:20%; float:left; margin-left:3%; margin-top:2.4%">
        <div id="menu" style="padding-left:2%; padding-top:2%;">
<ul>
<li><?php echo CHtml::link('Manage Role',array('/role/admin')); ?></li>
<li><?php echo CHtml::link('Manage User',array('user/admin')); ?></li>
<li><?php echo CHtml::link('Update Controllers',array('/accessControllers/create')); ?></li>
<li><?php echo CHtml::link('Manage Controllers',array('/accessControllers/admin')); ?></li>
<li><?php echo CHtml::link('Update Actions',array('/accessControlActions/admin')); ?></li>
<li><?php echo CHtml::link('Access Permission',array('/accessControllers/assignpermission')); ?></li>
<!--<li><?php //echo CHtml::link('Create User',array('/maUser/create')); ?></li>-->
</ul>
        
        </div>
</div>
 
    <div  style="width:900px; float:left; ">
        <div class="group" style="width:89%; margin-left:32.6%; float:left; margin-top:-24.3%">

<h1 style="margin-bottom:5%;">Access Control Action Registry</h1>
<!--
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

<div style="margin-left:93%; margin-top:-7.1%; margin-bottom:-2%">
	<?php echo CHtml::link('<img src="images/search_btn2.png"  width="36px" height="36px"/>','#',array('class'=>'search-button')); ?>
</div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'access-control-actions-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		//'action_id',
		array('name'=>'Display_Name', 'header'=>'Controller Name', 'value'=>'$data->controller->Display_Name'),
		'action_name',
		'Action_Display_Name',	
		//'controller_Id',
		array(
			'class'=>'CButtonColumn',
			//'name'=>'Update',
			'template'=>'{update}',
		),
	),
)); ?>
</div></div>