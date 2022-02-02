<?php
$this->breadcrumbs=array(
	'Access'=>array('accessPermission/accesscontrol'),
	'Update Access Controller Details',
);

$this->menu=array(
	//array('label'=>'List AccessControllers', 'url'=>array('index')),
	//array('label'=>'Create AccessControllers', 'url'=>array('create')),
	//array('label'=>'View AccessControllers', 'url'=>array('view', 'id'=>$model->Contoller_ID)),
	//array('label'=>'Manage AccessControllers', 'url'=>array('admin')),
);
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

    <h1 style="margin-bottom:5%;">Update Access Controller Details</h1>
<!--<h1>Update AccessControllers <?php /*?><?php echo $model->Contoller_ID; ?><?php */?></h1>-->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div></div>