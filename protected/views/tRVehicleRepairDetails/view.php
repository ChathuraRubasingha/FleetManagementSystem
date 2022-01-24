
<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$id = Yii::app()->request->getQuery('id');
$status=Yii::app()->session['fitnessStatus'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$id = Yii::app()->request->getQuery('id');

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
                        'Repair Details',
                    );

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Vehicle Repair Details</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRVehicleRepairDetails/admin'),array('title'=>'Manage')); ?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRVehicleRepairDetails/update&id='.$id),array('title'=>'Update')); ?>
                        </div>
                    </div>

                    


                        <?php

                       # echo CHtml::link('<img src="images/add.png" style="height:50px; width:50px; margin-right:4px !important"  />',array('tRRepairEstimateDetails/approvedEstimates'),array('title'=>'Add'));
                     //   echo CHtml::link('<img src="images/manage.png" style="height:40px; width:30px; margin-right:15px !important"  />',array('tRVehicleRepairDetails/admin'),array('title'=>'Manage'));
                      //  echo CHtml::link('<img src="images/update.png" style="height:37px; width:30px" />',array('tRVehicleRepairDetails/update&id='.$id),array('title'=>'Update'));


                        ?>

                    
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h2><center><?php echo $vehicleId; ?></center></h2>
                    </div>

                    <div class="panel-body">

                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                'Estimate_ID',
                                array('label'=>'Garage Name', 'value'=> $model->garage->Garage_Name),
                                array('label'=>'Repair Cost', 'value'=> number_format($model->Repair_Cost,2)),

                                array('label'=>'Description', 'type'=>'raw', 'value'=>(!empty($model->Description_Of_Repair) ? CHtml::encode($model->Description_Of_Repair) : '-')),
                                'Repaired_Date',
                                'add_by',
                                'add_date',
                                $model->edit_by == 'Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                $model->edit_date == 'Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false) : array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),

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
