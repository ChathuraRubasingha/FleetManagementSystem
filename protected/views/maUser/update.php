<?php
/* @var $this MaUserController */
/* @var $model MaUser */


$this->breadcrumbs=array(
	'User'=>array('maUser/admin'),
	
);

$this->menu=array(
	//array('label'=>'List User', 'url'=>array('index')),
	//array('label'=>'Create User', 'url'=>array('create')),
	//array('label'=>'View User', 'url'=>array('view', 'id'=>$model->User_ID)),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Update User</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>