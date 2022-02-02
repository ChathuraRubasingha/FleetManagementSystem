<?php
/* @var $this MaUserController */
/* @var $model MaUser */

$this->breadcrumbs=array(
	'User'=>array('maUser/admin'),
	
);

$this->menu=array(
	//array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Create User</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>