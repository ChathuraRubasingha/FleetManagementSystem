


<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

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
                        'Add Repair Details',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Select Repair Estimate to Add Repair Details</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRVehicleRepairDetails/admin',"menuId"=>"maintenance"),array('title'=>'Manage')); ?>
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
                            'dataProvider'=>$model->getApprovedEstimates(),
                            'columns'=>array(
                                'Estimate_ID',
                                'Request_ID',
                                array('name'=>'Garage_Name', 'header'=>'Garage', 'value'=>'$data->garage->Garage_Name'),
                                array('name'=>'Total_Estimate', 'value' => 'number_format($data->Total_Estimate,2)', 'htmlOptions'=>array(                                'style'=>'text-align: right; padding-right:50px;'),),
                                'Estimate_Date',

                                'Approved_By',
                                'Approved_Date',
								array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Request',
                                        'imageUrl'=>Yii::app()->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/tRVehicleRepairDetails/create", array("estimateId" =>
					$data["Estimate_ID"], "garageId" => $data["Garage_ID"], "menuId"=>"maintenance"))'
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