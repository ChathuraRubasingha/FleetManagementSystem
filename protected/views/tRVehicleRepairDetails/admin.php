

<?php



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trvehicle-repair-details-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
	$id = Yii::app()->request->getQuery('id');
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
?>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Vehicle Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                        'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                        'Repair'=>array('tRRepairRequest/repair'),
                        'Repair Details History',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Repair Details History of the Vehicle</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRRepairEstimateDetails/approvedEstimates',"menuId"=>"maintenance"), array('title'=>'Add'));?>
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
                            'id'=>'trvehicle-repair-details-grid',
                            'dataProvider'=>$model->getVehicleRepairDetails(),
                            //'filter'=>$model,
                            'columns'=>array(
                                'Estimate_ID',
                                array('name'=>'Garage_ID', 'value'=>'$data->garage->Garage_Name'),
                                array('name'=>'Repair_Cost', 'value'=>'number_format($data->Repair_Cost,2)'),

                                'Description_Of_Repair',

                                'Repaired_Date',
                                 array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/tRVehicleRepairDetails/update", array("id" =>
                                        $data["Repair_ID"], "menuId"=>"vreg"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRVehicleRepairDetails/view", array("id" =>
                                        $data["Repair_ID"], "menuId"=>"vreg"))',
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