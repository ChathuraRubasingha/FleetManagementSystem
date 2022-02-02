<script>
    $(document).ready(function()
    {
        $(".items tr td").click(function()
        {
            //var a =  $(this).parent("tr").children().eq(7).children('a').attr('href');
            var a =  $(this).parent("tr").children('td').eq(3).children('a').attr('href');
           
            window.location = a;
            
        });
    });
   
</script>
<?php
$vehicleId = Yii::app()->session['VehicleIdFuel'];
$aid=Yii::app()->session['VehicleIdAllocationID'];


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trfuel-request-details-grid', {
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
                        'Fuel'=>array('/maVehicleRegistry/fuelRequest'),
                        'Add Fuel Providing Details',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Select Request to Add Fuel Providing Details</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRFuelProvidingDetails/admin'),array('title'=>'Manage')); ?>
                        </div>
                    </div>
                   
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $vehicleId; ?></h1></center>
                    </div>

                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'trfuel-request-details-grid',
                            'dataProvider'=>$model->getFuelApprovedList(),
                            'columns'=>array(
                                'Request_Date',
                                array('name'=>'Driver', 'header'=>'Driver Name', 'value'=>'$data->driver->Full_Name'),
                                'Required_Fuel_Capacity',
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Request',
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("tRFuelProvidingDetails/create", array("requestId" =>$data["Fuel_Request_ID"],"menuId"=>"fuel"))',
                                        //'options'=>'array("id"=>"array(\'id\'=>$data[\'Vehicle_No\']'
                                    ))
                                ),
                                
//                                array(
//                                    'class'=>'CButtonColumn',
//                                    'template'=>'{view}',
//                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRFuelProvidingDetails/create", array("requestId" =>
//			$data["Fuel_Request_ID"], "menuId"=>"fuel"))',
//                                ),

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
                            <?php

                                echo MaVehicleRegistry::model()->menuarray('Fuel');
                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>