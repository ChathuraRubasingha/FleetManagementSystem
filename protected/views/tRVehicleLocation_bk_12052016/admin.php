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
	$.fn.yiiGridView.update('vehicle-location-grid', {
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
                        'Location Assigned Vehicles');
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Assigned Vehicles for Location</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php //echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('maVehicleRegistry/vehicleAsign&assign=true'), array('title'=>'Assign'));?>
                            <?php echo CHtml::link('<img src="images/search.png"  class="searchIcon" />','#',array('class'=>'search-button','title'=>'Search')); ?>
                           
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
                            'id'=>'vehicle-location-grid',
                            'dataProvider'=>$model->searchVehicles(),
                            //'filter'=>$model,
                            'columns'=>array(
                                //array('name'=>'Location_ID', 'header'=>'Currrent Location', 'value'=>'$data->locations->Location_Name'),
                                array('name'=>'Location_ID', 'header'=>'Assigned Location', 'value'=>'$data->location->Location_Name'),
                                'Vehicle_No',
                                array('name'=>'Vehicle_Category_ID', 'header'=>'Category', 'type'=>'raw', 'value'=>array($this,'gridCategoryName')),
                                'From_Date',
                                'To_Date',

                                array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/tRVehicleLocation/update", array("id" =>
                                        $data["Vehicle_Location_ID"], "menuId"=>"vreg"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRVehicleLocation/view", array("id" =>
                                        $data["Vehicle_Location_ID"], "menuId"=>"vreg"))',
                                    'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
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


