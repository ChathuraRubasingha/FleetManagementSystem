

<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$type = Yii::app()->request->getQuery('type');
Yii::app()->session['type'] = $type;



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trrepair-estimate-details-grid', {
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
                        'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                        'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                        'Repair'=>array('tRRepairRequest/repair'),
                        'Repair Estimate History',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Repair Estimate History of the Vehicle</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRRepairRequest/create',"menuId"=>"maintenance"), array('title'=>'Add'));?>
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
                            'id'=>'trrepair-estimate-details-grid',
                            'dataProvider'=>$model->getRepairEstimateDetails(),
                            'columns'=>array(
                                'Estimate_ID',
                                'Request_ID',
                                array('name'=>'Garage_ID', 'value'=>'$data->garage->Garage_Name'),
                                array('name'=>'Total_Estimate', 'value'=>'number_format($data->Total_Estimate,2)', 'htmlOptions'=>array('style'=>'text-align: right; padding-right: 50px;')),
                                'Estimate_Date',
                                'Estimate_Status',
                                array(
									'template' => '{view}{update}{delete}{pdf}',
                                    'class'=>'CButtonColumn',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRRepairEstimateDetails/view", array("id" =>
                                        $data["Estimate_ID"], "menuId"=>"maintenance"))',									
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/tRRepairEstimateDetails/update", array("id" =>
                                        $data["Estimate_ID"], "menuId"=>"maintenance"))',									
									'buttons' => array ('pdf' => array
										(
											'imageUrl' => Yii::app()->request->baseUrl . '/images/updat1e.png',
											'type' => 'raw',
											'url' => 'Yii::app()->createUrl("/tRRepairEstimateDetails/RepairRequestReport", array("id" =>     
											$data["Estimate_ID"], "viewType" =>"pdf"))',
											'options' => array('target' => '_blank', 'title'=>'Repair Request'),
										),),										
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