
<?php
    $vehicleId = Yii::app()->session['VehicleIdFuel'];
    $aid=Yii::app()->session['VehicleIdAllocationID'];

    $id = Yii::app()->request->getQuery('id');
    $type = Yii::app()->request->getQuery('type');

?>

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Fuel'=>array('/maVehicleRegistry/fuelRequest'),
                        'Fuel Providing Details'=>array('/tRFuelProvidingDetails/fuelProvidingHistory&id='.$vehicleId.'&aid='.$aid),
                        'Fuel Providing Details',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Fuel Providing Details</h1>
                        <div style="float: right; margin-top: -30px">
<?php


                        if ($type == 'completed')
                        {
                        }
                        else
                        {
                            
                            echo CHtml::link('<img src="images/manage.png" class="manageIcon" />' ,array('tRFuelProvidingDetails/admin&id='.$vehicleId),array('title'=>'Manage'));
                            echo '&nbsp;';
                            echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRFuelProvidingDetails/update&id='.$id),array('title'=>'Update'));
                            
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
                                array('label'=>'Driver', "value"=>$model->fuelRequest->driver->Full_Name),
                                array('label'=>'Requested Fuel Capacity(l)', "value"=>$model->fuelRequest->Required_Fuel_Capacity),
                                array('label'=>'Requested Date', "value"=>$model->fuelRequest->Request_Date),
                                array('name'=>'Fuel_Order_No', 'value'=>(!empty($model->Fuel_Order_No))? $model->Fuel_Order_No : '-'),
                                array('name'=>'Fuel_Station', 'value'=>(!empty($model->Fuel_Station))? $model->Fuel_Station : '-'),
                                array('name'=>'Fuel Type', 'value'=>$model->fuelType->Fuel_Type),
                                'Fuel_Pumped_Date',
                                'Fuel_Amount',
                                array('name'=>'Payable Amount (Rs)', 'value'=>number_format($model->Payable_Amount,2)),
                                'add_by',
                                'add_date',
                                $model->edit_by == 'Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                $model->edit_date == 'Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false):array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),

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
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>