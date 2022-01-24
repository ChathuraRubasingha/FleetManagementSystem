<?php
$this->breadcrumbs=array(
	'Vehicle Transfers'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List VehicleTransfer', 'url'=>array('index')),
	array('label'=>'Create VehicleTransfer', 'url'=>array('create')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('vehicle-transfer-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="group" style="height:115px; width:20%; float:left; margin-left:3%; margin-top:2.4%">
        <div id="menu" style="padding-left:2%; padding-top:2%;">
        
        <ul>
        
        <li><?php echo CHtml::link('Vehicle Registry',array('/maVehicleRegistry/edit')); ?></li>
        <li><?php echo CHtml::link('Assign Location',array('/tRVehicleLocation/admin')); ?></li>
        <li><?php echo CHtml::link('Assign Driver',array('/tRVehicleLocation/notAssignedVehicles')); ?></li>    
        <li><?php echo CHtml::link('Transfer Vehicle',array('/tRVehicleLocation/transferVehicle')); ?></li>     
        </ul>
        
        </div>
</div>
    <div  style="width:900px; float:left; ">
<div class="group" style="width:90%; margin-left:33%; float:left; margin-top:-17.4%">
<h1>Manage Transfered Vehicles</h1>


<?php echo CHtml::link('<img src="images/search.gif"  width="0px" height="0px" />','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vehicle-transfer-grid',
	'dataProvider'=>$model->search(),
	#'filter'=>$model,
	'columns'=>array(
		'VehicleTransfer_ID',
		'Vehicle_No',
		'From_Location_ID',
		'To_Location_ID',
		'From_Date',
		'To_Date',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?></div></div>
