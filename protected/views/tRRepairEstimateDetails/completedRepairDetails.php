<?php

$vehicleId = Yii::app()->session['maintenVehicleId'];
$id = Yii::app()->request->getQuery('id');
$userRole = Yii::app()->getModule('user')->user()->Role_ID;


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('Completed-repair-grid', {
		data: $(this).serialize()
	});
	return false;
});
");


if($userRole !=='3')
{
    $title="Completed Repair Requests Registry";
}
else
{
    $title='සම්පූර්ණ කරන ලද අලුත්වැඩියා අයදුම් විස්තර';
}

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
                            'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$id),
                            'Repair'=>array('tRRepairRequest/repair'),
                            'Completed Repair Requests'
                        );
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
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
                            'id'=>'rejected-repair-grid',
                            'dataProvider'=>$model->getCompletedRepairRequests(),
                            #'filter'=>$model,
                            'columns'=>array(
                                'Request_ID',
                                array('name'=>'Garage_ID', 'header'=>'Garage', 'value'=>'$data->garage->Garage_Name'),
                                array('name'=>'Total_Estimate', 'value'=>'number_format($data->Total_Estimate,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right: 50px;')),
                                'Estimate_Date',
                                'Approved_By',
                                'Approved_Date',
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRRepairEstimateDetails/view", array("id"=>$data["Estimate_ID"], "type"=>"completed", "menuId"=>"maintenance"))'
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