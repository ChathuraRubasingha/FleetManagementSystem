
<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$type = Yii::app()->request->getQuery('type');
$id = Yii::app()->request->getQuery('id');
$userRole = Yii::app()->getModule('user')->user()->Role_ID;





?>
 <?php
 if ($type == 'replace')
 {
    $title ="Add Tyre Replacement Details";
 }
 else
 {
    $title = "Update Tyre Replacement Details";
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
                            if($type == 'update')
                            {
                                $this->breadcrumbs=array(
                                    'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                                    'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                                    'Tyre'=>array('tRTyreDetails/tyre'),
                                    'Update Tyre Replacement Details',
                                );

                            }
                            else
                            {
                                $this->breadcrumbs=array(
                                    'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                                    'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                                    'Tyre'=>array('tRTyreDetails/tyre'),
                                    'Add Tyre Replacement Details',
                                );
                            }
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

                                if ($type == 'update')
                                {
                                    echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRTyreDetails/admin&id='.$id.'&type=replace'),array('title'=>'Manage'));
                                }
                                else
                                {
                                    echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRTyreDetails/replace'),array('title'=>'Manage'));
                                }
                            ?>
                            </div>
                        </div>


                        
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><center><?php echo $vehicleId; ?></center></h1>
                        </div>



                        <div class="panel-body">
                            <?php echo $this->renderPartial('_form2', array('model'=>$model)); ?>
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