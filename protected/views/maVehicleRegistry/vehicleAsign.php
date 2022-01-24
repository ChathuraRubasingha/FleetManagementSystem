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
<script>
    $(document).ready(function()
    {
        $(".items tr td").click(function()
        {
            //var a =  $(this).parent("tr").children().eq(7).children('a').attr('href');
            var a =  $(this).parent("tr").children('td').eq(4).children('a').attr('href');
           
            window.location = a;
            
        });
    });
   
</script>

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">

                    <?php
                        $this->breadcrumbs=array(
                        'Vehicle Registry'=>array('maVehicleRegistry/edit'),
                        'Assign Location');
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Select Vehicle to Assign for Location</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRVehicleLocation/admin',"menuId"=>"vreg"),array('title'=>'Manage')); ?>
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
                            'id'=>'ma-vehicle-location-grid',
                            'dataProvider'=>$model->getVehiclesLocationwise(),
                            //'filter'=>$model,
                            'enableSorting'=>false,
                            'columns'=>array(
                                'Vehicle_No',
                                array('name'=>'Category_ID', 'header'=>'Category', 'value'=>'$data->vehicleCategory->Category_Name'),
                                array('name'=>'Make_ID', 'header'=>'Make', 'value'=>'$data->makeID->Make'),
                                'Purchase_Date',
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    //'viewButtonUrl'=>'Yii::app()->createUrl("/tRVehicleLocation/create", array("vNo" => $data["Vehicle_No"]))',
                                    'buttons' => array
                                    (
                                        'view' => array
                                        (
                                            'label' => 'Select Vehicle',
                                            'imageUrl' => Yii::app()->request->baseUrl . '/images/go_arrow.png',
                                            'url' => 'Yii::app()->createUrl("/tRVehicleLocation/create", array("vNo" =>     
                                                                        $data["Vehicle_No"],"menuId"=>"vreg"))',
                                    )                                
                                ),
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



