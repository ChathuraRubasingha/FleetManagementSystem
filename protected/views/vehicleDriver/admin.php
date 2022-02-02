<style type="text/css">



.back a
{
	background-color:#31E9FF !important;
}
</style>


<?php



$superUser = Yii::app()->getModule('user')->user()->superuser;

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

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                        $this->breadcrumbs=array(
                            'Vehicle Registry'=>array('maVehicleRegistry/edit'),
                            'Driver Assigned Vehicles',
                        );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Driver Assigned Vehicles</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/search.png"  class="searchIcon"/>','#',array('class'=>'search-button','title'=>'Search')); ?>
                           
                        </div>
                    </div>

                    


                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_search',array(
                                'model'=>$model,
                            )); ?>
                        </div><!-- search-form -->
                       
                </div>

                <div class="panel panel-default">
                    

                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'vehicle-driver-grid',
                            'dataProvider'=>$model->driverAssignedVehicles(),
                            #'filter'=>$model,
                            'columns'=>array(
                                array('name'=>'Driver_ID', 'header'=>'Driver', 'value'=>array($this, 'gridDriverName')),
                                'Vehicle_No',
                                array('name'=>'Vehicle Category', 'type'=>'raw', 'value'=>array($this, 'gridCategoryName')),
                                $superUser == 1 ? array('name'=>'Location_ID', 'header'=>'Location', 'value'=>'$data->location->Location_Name'): array('name'=>'Location_ID', 'header'=>'Location', 'visible'=>false),
                                'From_Date',
                                'To_Date',
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}  {update}',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/vehicleDriver/update", array("id" =>
                                        $data["Driver_Allocation_ID"], "menuId"=>"vreg"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/vehicleDriver/view", array("id" =>
                                        $data["Driver_Allocation_ID"], "menuId"=>"vreg"))',
                                    /*array(
                                    'class'=>'CButtonColumn',
                                        'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',*/
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





