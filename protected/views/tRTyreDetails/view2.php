<?php
  	$vehicleId = Yii::app()->session['maintenVehicleId'];
	$id = Yii::app()->request->getQuery('id');
	$tyreType = Yii::app()->request->getQuery('tyreType');
	$type = Yii::app()->request->getQuery('type');

	$userRole = Yii::app()->getModule('user')->user()->Role_ID;

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
                            'Tyre'=>array('tRBatteryDetails/tyre'),
                            'Tyre Request Details',
                        );
                    }

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Tyre Replacement Details</h1>
                    </div>




                        <?php

                    if ($type == 'Completed' || $type == 'approved' || $type == 'disapproved')
                    {

                    }
                    elseif($type == 'update')
                    {
                        echo '<div class="panel-body">';
                        echo CHtml::link('<img src="images/manage.png" style="height:40px; width:30px; margin-right:15px !important"  />',array('tRTyreDetails/admin&id='.$id.'&batteryType='.$tyreType.'&type=replace'),array('title'=>'Manage'));
                        echo CHtml::link('<img src="images/update.png" style="height:37px; width:30px" />',array('tRTyreDetails/update2&id='.$id.'&type=update'),array('title'=>'Update'));
                        echo '</div>';
                    }
                    else if($type == 'rejected')
                    {
                        echo '<div class="panel-body">';
                        echo CHtml::link('<img src="images/manage.png" style="height:40px; width:30px; margin-right:15px !important"  />',array('tRTyreDetails/rejectedBatteryRequests'),array('title'=>'Manage'));
                        echo '</div>';
                    }
                    else
                    {
                        echo '<div class="panel-body">';
                        echo CHtml::link('<img src="images/update.png" style="height:37px; width:30px" />',array('tRTyreDetails/update2&id='.$id),array('title'=>'Update'));
echo '</div>';

                    }?>


                </div>


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h2><center><?php echo $vehicleId; ?></center></h2>
                    </div>

                    <div class="panel-body">

                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                'Tyre_Details_ID',
                                array('label'=>'Driver Name', 'value'=>$model->driver->Full_Name),
                                array('label'=>'Tyre Type', 'value'=>$model->tyreType->Tyre_Type),
                                array('label'=>'Tyre Size', 'value'=>$model->tyreSize->Tyre_Size),
                                'Tyre_quantity',
                                'Life_Time',
                                array('name'=>'Cost', 'value'=>number_format($model->Cost,2)),
                                'Meter_Reading',
                                'Approved_By',
                                'Approved_Date',
                                'Replace_Status',
                                'Replace_Date',
                                'add_by',
                                'add_date',
                                $model->edit_by == 'Not Edited' ? array('visible'=>false):array('label'=>'Edit By', 'value'=>$model->edit_by),
                                $model->edit_date == 'Not Edited' ? array('visible'=>false):array('label'=>'Edit Date', 'value'=>$model->edit_date),
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
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceTyre');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceTyreForDriver');
                            }?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>