
<?php

$vehicleId = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trrepair-request-admin-grid', {
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
                    if($userRole !=='3')
                    {
                        $this->breadcrumbs=array(
                            'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                            'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                            'Repair'=>array('tRRepairRequest/repair'),
                            'Repair Request History',
                        );
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Select Repair Request for Estimation</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRRepairEstimateDetails/admin',"menuId"=>"maintenance"),array('title'=>'Manage')); ?>
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
                            'id'=>'trrepair-request-admin-grid',
                            'dataProvider'=>$model->getRepairRequest(),
                            'columns'=>array(
                                $model->Driver_ID != null ? array('name'=>'Full_Name', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name') : 'InspectedBy',
                                'Request_Date',
                                'Description_Of_Failure',
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Request',
                                        'imageUrl'=>Yii::app()->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/tRRepairEstimateDetails/create", array("repairRequestId" =>
					$data["Request_ID"], "menuId"=>"maintenance"))'
                                    ))
                                    
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

                            <?php if($userRole !=='3')
                            {
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceRepair');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceRepairForDriver');
                            }?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>