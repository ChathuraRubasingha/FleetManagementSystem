<?php
$this->breadcrumbs=array(
	'Access'=>array('accessPermission/accesscontrol'),
	'Update Controllers',
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

<!--<div class="group" style="height:150px;width:350px;margin-left:500px; margin-top:60px">-->

<h1 style="margin-left:70px">Update Controllers</h1>
<!---->
<?php echo $this->renderPartial('_form1', array('model'=>$model)); ?>
</div></div>

<!--</div>-->