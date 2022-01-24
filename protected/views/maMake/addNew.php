<?php
$this->breadcrumbs=array(
	'Ma Makes'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List MaMake', 'url'=>array('index')),
	array('label'=>'Manage MaMake', 'url'=>array('admin')),
);*/
?>

<h1>Create MaMake</h1>

<?php echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>