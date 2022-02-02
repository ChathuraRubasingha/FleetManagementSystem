
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
	$.fn.yiiGridView.update('ma-vehicle-registry-grid', {
		data: $(this).serialize()
	});
	return false;
});
"
);
?>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                        $this->breadcrumbs=array(
                        'Vehicle Registry');
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Vehicle Registry</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('maVehicleRegistry/create',"menuId"=>"vreg"), array('title'=>'Add'));?>
                            <?php echo CHtml::link('<img src="images/search.png"  class="searchIcon"/>','#',array('class'=>'search-button','title'=>'Search')); ?>
                            <?php echo CHtml::link('<img src="images/download.png" alt="Download"  width="37px" height="37px"/>','Vehicle_Data_Collection_Format.pdf',array('title'=>'Download Form','target'=>'blank')); ?>

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
                            'id'=>'ma-vehicle-registry-grid',
                            'dataProvider'=>$model->getVehicleList(),
                            //'filter'=>$model,
                            'columns'=>array(
                                'Vehicle_No',
                                array('name'=>'Category_Name', 'header'=>'Category', 'value'=>'$data->vehicleCategory->Category_Name'),
                                //'Model_ID',
                                //array('name'=>'Model_ID', 'header'=>'Model', 'value'=>'$data->maModels->Model_ID'),
                                array('name'=>'Make_ID', 'header'=>'Make', 'value'=>'$data->makeID->Make'),

                                //array('name'=>'Model_ID', 'header'=>'Model', 'value'=>'$data->modelID->Model'),
                                /*array('name'=>'Model', 'type'=>'raw', //because of using html-code
                                    'value'=>array($this,'gridModel'), //call this controller method for each row
                                ),*/

                                //array('name'=>'Fuel_Type', 'header'=>'Fuel Type', 'value'=>'$data->fuelType->Fuel_Type'),
                                array('name'=>'Allocation_Type_ID','header'=>'Allocaton Type', 'value'=>'$data->allocationType->Allocation_Type'),
                                array('name'=>'Vehicle_Status', 'header'=>'Vehicle Status', 'value'=>'$data->vehicleStatus->Vehicle_Status'),
                                array('name'=>'Vehicle_Location', 'header'=>'Vehicle Location', 'value'=>'$data->Location_ID !="" ? $data->location->Location_Name : ""'),
                                

                                array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/maVehicleRegistry/update", array("id" =>
                                        $data["Vehicle_No"], "menuId"=>"vreg"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/maVehicleRegistry/view", array("id" =>
                                        $data["Vehicle_No"], "menuId"=>"vreg"))',
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


