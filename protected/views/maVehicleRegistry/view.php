
<?php
$vehicleId = Yii::app()->request->getQuery('Vehicle_No');
$vNo = Yii::app()->request->getQuery('id');
?>
<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs = array(
                        'Vehicle Registry' => array('edit'),
                        'View Vehicle Details'
                    );

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Vehicle Details</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('maVehicleRegistry/create',"menuId"=>"vreg"), array('title'=>'Add'));?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('maVehicleRegistry/update&id='.$model->Vehicle_No,"menuId"=>"vreg"),array('title'=>'Update')); ?>
                       
                        </div>
                    </div>

                    
                </div>


                <div class="panel panel-default">


                    <div class="panel-body">
                        <h2 style="margin:0 0 -10px 100px; color:#039;"> GENERAL DETAILS</h2>
                        <?php
                        $superUser = Yii::app()->getModule('user')->user()->superuser;
                        ?>
                        <?php
                        $filename = $model->Vehicle_image;
                        ?>


                        <?php
                        $dotPos = strpos($filename, '.');
                        $wdth = substr($filename, 5, 1);

                        if ($dotPos != '')
                        {
                            ?>
                            <div style="margin:12% 0% 2% 35%;"><img src="<?php echo 'VechicleReg/' . $filename; ?>" width="200px" height="200px"/></div>

                        <?php
                        }
                        else
                        {
                            ?>
                            <!--<div><img src="<?php /*echo 'VechicleReg/Default.png'; */?>" width="200px" height="200px"/></div>-->
                        <?php
                        }
                        ?>
                        <?php
                            $this->widget('zii.widgets.CDetailView', array(
                            'data' => $model,
                            'attributes' => array(
                            'Vehicle_No',
                            array('label' => 'Registration Fee (Rs.)', 'value' => $model->Registration_Fee != '' ? number_format($model->Registration_Fee, 2) : "-"),
                            array('label' => 'Allocation Type', 'value' => $model->allocationType->Allocation_Type),
                            array('label' => 'Vehicle Category', 'value' => $model->vehicleCategory->Category_Name),
                            array('label' => 'Make', 'type' => 'raw', 'value' => (!empty($model->makeID->Make)) ? CHtml::encode($model->makeID->Make) : '-'),
                            array('label' => 'Model', 'type' => 'raw', 'value' => (!empty($model->modelID->Model)) ? CHtml::encode($model->modelID->Model) : '-'),
                            array('label' => 'Make Year', 'type' => 'raw', 'value' => (!empty($model->Make_Year) ? CHtml::encode($model->Make_Year) : "-")),
                            array('label' => 'Purchase Value (Rs.)', 'value' => $model->Purchase_Value != '' ? number_format($model->Purchase_Value, 2) : "-"),
                            array('label' => 'Purchased Date', 'type' => 'raw', 'value' => (!empty($model->Purchase_Date) ? CHtml::encode($model->Purchase_Date) : "-")),
                            array('label' => 'Engine Number', 'type' => 'raw', 'value' => (!empty($model->Engine_No) ? CHtml::encode($model->Engine_No) : "-")),
                            array('label' => 'Chassis Number', 'type' => 'raw', 'value' => (!empty($model->Chassis_No) ? CHtml::encode($model->Chassis_No) : "-")),
                            array('label' => 'Number of Passengers', 'type' => 'raw', 'value' => (!empty($model->Number_of_Passenger)) ? CHtml::encode($model->Number_of_Passenger) : '-'),
                            array('label' => 'Air Condition Status', 'type' => 'raw', 'value' => (!empty($model->Ac_Statues)) ? CHtml::encode($model->Ac_Statues) : '-'),
                            array('label' => 'Fuel Type', 'value' => $model->fuelType->Fuel_Type),
                            'Fuel_Tank_Capacity',
                            array('name'=>'odometer', 'label'=>'Current Odometer', 'value'=>(!empty($model->odometer) ? CHtml::encode($model->odometer) : "-" )),

                            ),
                            ));
                        ?>

                    </div>


                    <div class="panel-body">

                        <h2 style="margin:0 0 -10px 100px; color:#039;">  SPARE PARTS </h2>
                        <?php

                        $this->widget('zii.widgets.CDetailView', array(
                            'data' => $model,
                            'attributes' => array(
                                array('label' => 'Tyre Size', 'value' => $model->tyreSize->Tyre_Size),
                                array('label' => 'Tyre Size 2', 'value' => (!empty($model->tyreSize2->Tyre_Size)) ? $model->tyreSize2->Tyre_Size : '-'),
                                array('label' => 'Tyre Type', 'value' => $model->tyreType->Tyre_Type),
                                array('label' => 'Number of Tyres', 'type' => 'raw', 'value' => (!empty($model->No_of_Tyres)) ? CHtml::encode($model->No_of_Tyres) : '-'),
                                array('label' => 'Battery Type', 'value' => $model->batteryType->Battery_Type),
                            ),
                        ));
                        ?>
                    </div>

                    <div class="panel-body">

                        <h2 style="margin:0 0 -10px 100px; color:#039;">  MAINTENANCE </h2>
                        <?php
                        $this->widget('zii.widgets.CDetailView', array(
                            'data' => $model,
                            'attributes' => array(
                                array('label'=>'Vehicle Status', 'type' => 'raw','value'=>$model->vehicleStatus->Vehicle_Status),
                                array('label' => 'Service Mileage (km)', 'type' => 'raw', 'value' => (!empty($model->Service_Mileage)) ? CHtml::encode($model->Service_Mileage) : '-'),
                                array('label' => 'Servicing Period (months)', 'type' => 'raw', 'value' => (!empty($model->Servicing_Period)) ? CHtml::encode($model->Servicing_Period) : '-'),
                                array('label' => 'Fuel Consumption (km per liter)', 'type' => 'raw', 'value' => (!empty($model->Fuel_Consumption)) ? CHtml::encode($model->Fuel_Consumption) : '-'),
                                array('label'=>'Current Odometer', 'value'=>(!empty($model->odometer)) ? ($model->odometer) : '-'),
                                array('label' => 'Fitness Test Eligibility', 'type' => 'raw', 'value' => (!empty($model->Fitness_test)) ? CHtml::encode($model->Fitness_test) : '-'),
                                array('label'=>'Add By', 'type'=>'raw', 'value'=> (!empty($model->add_by) ? CHtml::encode($model->add_by) : "-")),
                                array('label'=>'Add Date', 'type'=>'raw', 'value'=>(!empty($model->add_date) ? CHtml::encode($model->add_date) : "-")),
                                ($model->edit_by == "Not Edited" || $model->edit_by == "") ? array('label' => 'Edit By', 'value' => $model->edit_by, 'visible' => false) : array('label' => 'Edit By', 'value' => $model->edit_by, 'visible' => true),
                                ($model->edit_date == 'Not Edited' || $model->edit_date == "") ? array('label' => 'Edit Date', 'value' => $model->edit_date, 'visible' => false) : array('label' => 'Edit Date', 'value' => $model->edit_date, 'visible' => true),
                            ),
                        ));
                        ?>
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

                            <?php echo MaVehicleRegistry::model()->menuarray('VehicleRegistry'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>














