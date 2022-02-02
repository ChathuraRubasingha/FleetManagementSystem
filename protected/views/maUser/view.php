<?php
/* @var $this MaUserController */
/* @var $model MaUser */

$this->breadcrumbs=array(
	'User'=>array('maUser/admin'),
	
);

$this->menu=array(
/*	//array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->User_ID)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->User_ID),'confirm'=>'Are you sure you want to delete this item?')),*/
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>View User #<?php echo $model->User_ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'User_ID',
		'Full_Name',
		'Address',
		'NIC',
		'Location_ID',
		'Mobile',
		'Email',
		'Designation_ID',
		'UserName',
		'Password',
		'Role_ID',
		/*'add_by',
		'add_date',
		'edit_by',
		'edit_date',*/
	),
)); ?>
</div>
