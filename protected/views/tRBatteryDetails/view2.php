<?php
  	$vehicleId = Yii::app()->session['maintenVehicleId'];
	$id = Yii::app()->request->getQuery('id');
	$batteryType = Yii::app()->request->getQuery('batteryType');
	$type = Yii::app()->request->getQuery('type');
?>


<?php
	$userRole = Yii::app()->getModule('user')->user()->Role_ID;
if($userRole !=='3')
{
$title = "Battery Replacement Details";
}
else
{

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
                            'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                            'Battery'=>array('tRBatteryDetails/battery'),
                            'Battery Replacement Details',
                        );
                    }

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
                        <div style="float: right; margin-top: -30px">
                            <?php


                        if ($type == 'completed' || $type == 'approved' || $type == 'disapproved')
                        {

                        }
                        elseif($type == 'update')
                        {
                            echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRBatteryDetails/admin&id='.$id.'&batteryType='.$batteryType.'&type=replace'),array('title'=>'Manage'));
                            echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRBatteryDetails/update2&id='.$id.'&type=update'),array('title'=>'Update'));
                            
                        }
                        elseif($type == 'rejected')
                        {
                            echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRBatteryDetails/rejectedBatteryRequests'),array('title'=>'Manage'));
                            
                        }
                        else
                        {
                            echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRBatteryDetails/update2&id='.$id.'&type=update'),array('title'=>'Update'));
                            
                        }




                        ?>
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
                                'Battery_Details_ID',
                                array('label'=>'Driver', 'value'=>$request->driver->Full_Name),
                                array('label'=>'Battery Type', 'value'=>$request->batteryType->Battery_Type),
                                array('label'=>'Requested Date', 'value'=>$request->Request_Date),
                                array('label'=>'Approved By', 'type'=>'raw', 'value'=>(!empty($model->Approved_By) ? CHtml::encode($model->Approved_By) : '-')),
                                array('label'=>'Approved Date', 'type'=>'raw', 'value'=>(($model->Approved_Date != '0000-00-00') ? CHtml::encode($model->Approved_Date) : '-')),
                                array('label'=>'Life Time (Months)', 'type'=>'raw', 'value'=>(!empty($model->Life_Time) ? CHtml::encode($model->Life_Time) : '-')),
                                array('label'=>'Cost (Rs.)', 'type'=>'raw', 'value'=>(!empty($model->Cost) ? CHtml::encode(number_format($model->Cost,2)) : '-')),
                                array('label'=>'Replaced Date', 'type'=>'raw', 'value'=>(!empty($model->Replace_Date) ? CHtml::encode($model->Replace_Date) : '-')),

                                'add_by',
                                'add_date',$model->edit_by == 'Not Edited' ? array('label'=>'Edit By', 'type'=>'raw', 'value'=>$model->edit_by, 'visible'=>false): array('label'=>'Edit By', 'type'=>'raw', 'value'=>$model->edit_by, 'visible'=>true),
                                $model->edit_date == 'Not Edited' ? array('label'=>'Edt Date', 'type'=>'raw', 'value'=>$model->edit_date, 'visible'=>false): array('label'=>'Edit Date', 'type'=>'raw', 'value'=>$model->edit_date, 'visible'=>true),
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
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceBattery');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceBatteryForDriver');
                            }?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>


