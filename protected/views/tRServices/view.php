
<?php


    $id = Yii::app()->request->getQuery('id');
    $vehicleId = Yii::app()->session['maintenVehicleId'];
    $userRole = Yii::app()->getModule('user')->user()->Role_ID;

    $status=Yii::app()->session['fitnessStatus'];

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
                        'Services' =>array('tRServices/admin'),
                        'Service Details',
                    );

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Service Details</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRServices/admin',"menuId"=>"maintenance"),array('title'=>'Manage')); ?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRServices/update&id='.$id,"menuId"=>"maintenance"),array('title'=>'Update')); ?>

                        </div>
                    </div>

                   
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h2><center><?php echo $vehicleId; ?></center></h2>
                    </div>

                    <div class="panel-body">

                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                array('label'=>'Service Station', 'value'=>$model->serviceStation->Srvice_Station_Name),
                                array('label'=>'Service Type', 'value'=>$model->serviceType->Service_Type),
                                'Service_Date',
                                array('label'=>'Service Replacement', 'type'=>'raw','value'=>($model->replacementOfService($model->Services_ID)) ? $model->replacementOfService($model->Services_ID) : '-'),
                                array('label'=>'Meter Reading', 'type'=>'raw','value'=>(!empty($model->Meter_Reading)) ? CHtml::encode($model->Meter_Reading) : '-'),
                                array('label'=>'Estimate Cost (Rs)', 'type'=>'raw','value'=>(!empty($model->Estimate_Cost)) ? CHtml::encode(number_format($model->Estimate_Cost,2)) : '-'),
                                array('label'=>'Other Costs (Rs)', 'type'=>'raw','value'=>(!empty($model->Other_Costs)) ? CHtml::encode(number_format($model->Other_Costs,2)) : '-'),
                                //array('label'=>'Driven Distance (km)', 'type'=>'raw','value'=>(!empty($model->Driving_Distance)) ? CHtml::encode($model->Driving_Distance) : '-'),
                                array('label'=>'Next Service Date', 'type'=>'raw','value'=>($model->Next_Service_Date != '0000-00-00') ? CHtml::encode($model->Next_Service_Date) : '-'),
                                array('label'=>'Next Service Mileage (km)', 'type'=>'raw','value'=>(!empty($model->Next_Service_Milage)) ? CHtml::encode($model->Next_Service_Milage) : '-'),
                                array('label'=>'Description', 'type'=>'raw','value'=>(!empty($model->Description)) ? CHtml::encode($model->Description) : '-'),
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
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceView');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceViewForDriver');
                            }?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>
