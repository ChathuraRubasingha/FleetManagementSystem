
<?php

Yii::app()->session['useCurrentLoc'] = 'fromTransfer';

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

$modelVl =new TRVehicleLocation;

?>
<style type="text/css">


    .back a
    {
        background-color:#31E9FF !important;
    }
</style>

<script>
    $(document).ready(function()
    {
        $(".items tr td").click(function()
        {
            //var a =  $(this).parent("tr").children().eq(7).children('a').attr('href');
            var a =  $(this).parent("tr").children('td').eq(5).children('a').attr('href');
           
            window.location = a;
            
        });
    });
   
</script>
<?php



$superUser = Yii::app()->getModule('user')->user()->superuser;

?>

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                        $this->breadcrumbs=array(
                            'Vehicle Registry'=>array('maVehicleRegistry/edit'),
                            'Transfer Vehicle'
                        );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Select Vehicle to Transfer</h1>
                        <div style="float: right; margin-top: -30px">
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
                            'id'=>'ma-vehicle-location-grid',
                            'dataProvider'=>$model->transferVehicle(),
                            //'filter'=>$model,
                            'columns'=>array(
                                array('name'=>'Current_Location_ID', 'header'=>'Location', 'value'=>'$data->locations->Location_Name'),
                                'Vehicle_No',
                                array('name'=>'Category', 'type'=>'raw', 'value'=>array($this, 'gridCategoryName')),
                                'From_Date',
                                'To_Date',


                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons' => array
                                    (
                                        'view' => array
                                        (
                                            'label' => 'Select Vehicle',
                                            'imageUrl' => Yii::app()->request->baseUrl . '/images/go_arrow.png',
                                            'url' => 'Yii::app()->createUrl("/vehicleTransfer/create", array("id" =>     
			$data["Vehicle_Location_ID"], "vNo"=>$data["Vehicle_No"], "fromLoc" => $data["Current_Location_ID"],"type" => "transfer", "menuId"=>"vreg"))',
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



