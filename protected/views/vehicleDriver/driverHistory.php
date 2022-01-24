<style type="text/css">

.add{
	margin-top:-12px;
	margin-left:95%;
		
}

.back a
{
	background-color:#31E9FF !important;
}
</style>

<?php
$superUser = Yii::app()->getModule('user')->user()->superuser;
?>
<?php



$vNo = Yii::app()->request->getQuery('vNo');
$locId = Yii::app()->request->getQuery('loc');

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
	$.fn.yiiGridView.update('vehicle-driver-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<?php

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
	$.fn.yiiGridView.update('ma-vehicle-location-grid', {
		data: $(this).serialize()
	});
	return false;
});
");


?>

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Vehicle Registry'=>array('maVehicleRegistry/edit'),
                        'Assigned Driver History'=>array('/tRVehicleLocation/assignedVehiclesForDriverHistory'),
                        'Drivers History of the Vehicle'

                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Drivers History of the Vehicle</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php  echo  CHtml::link('<img src="images/add.png" class="addIcon"  />',array('vehicleDriver/create&vNo='.$vNo.'&loc='.$locId), array('title'=>'Add'));?>

                        </div>
                    </div>

                    

                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_search',array(
                                'model'=>$model,
                            )); ?>
                        </div><!-- search-form -->
                        
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h2><?php echo $vNo; ?></h2> </center>
                    </div>

                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'vehicle-driver-grid',
                            'dataProvider'=>$model->AssignedDriverHistory(),
                            #'filter'=>$model,
                            'columns'=>array(
                                //'Vehicle_Location_ID',
                                //'Vehicle_No',
                                array('name'=>'Driver_ID', 'header'=>'Driver', 'value'=>array($this, 'gridDriverName')),
                                #array('name'=>'Vehicle Category', 'type'=>'raw', 'value'=>array($this, 'gridCategoryName')),
                                #'Location_ID',
                                $superUser == 1 ? array('name'=>'Location_ID', 'header'=>'Location', 'value'=>'$data->location->Location_Name'): array('name'=>'Location_ID', 'header'=>'Location', 'visible'=>false),
                                #'Driver_ID',
                                //array('name'=>'Driver_ID', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),

                                'From_Date',
                                'To_Date',

                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/vehicleDriver/view", array("id"=>$data["Driver_Allocation_ID"], "vNo"=>$data["Vehicle_No"], "status"=>"History", "menuId"=>"vreg"))'
                                ),
                            ),
                        )); ?>
                    </div>
                </div>




            </div>
            <div class="col-xs-4">




                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">
                            Menu
                        </h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">

                            <?php echo MaVehicleRegistry::model()->menuarray('VehicleRegistry'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>

