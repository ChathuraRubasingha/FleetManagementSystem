
<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$type = Yii::app()->request->getQuery('type');
$id = Yii::app()->request->getQuery('id');
$batteryType = Yii::app()->request->getQuery('batteryType');
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

if($userRole !=='3')
{
    $add="Add Battery Replacement Details";
    $update="Update Battery Request Details";
}
else
{
	$add="බැටරි ප්‍රතිස්ථාපන දත්ත ඇතුලත් කිරීම";
	$update="බැටරි ප්‍රතිස්ථාපන දත්ත යාවත්කලීන කිරීම";
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
                                    'Battery'=>array('tRBatteryDetails/battery'),
                                    'Update Battery Replacement Details',
                                );

                            }
                            else
                            {
                                $this->breadcrumbs=array(
                                    'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                                    'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$id),
                                    'Battery'=>array('tRBatteryDetails/battery'),
                                    'Add Battery Replacement Details',
                                );
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-xs-8">
                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><?php  if ($type == 'update')
                                {
                                    echo  $update ;
                                }
                                else
                                {
                                    echo $add;
                                }
                                ?></h1>
                            <div style="float: right; margin-top: -30px">
                            <?php
                                if ($type == 'replace')
                                {

                                    echo CHtml::link('<img src="images/manage.png" style="height:34px; width:30px; margin-right:15px !important"  />',array('tRBatteryDetails/admin&id='.$id.'&batteryType='.$batteryType.'&type='.$type),array('title'=>'Manage'));
                               }
                                else
                                {
                                    #   echo CHtml::link('<img src="images/add.png" style="height:50px; width:50px; margin-right:4px !important"  />',array('tRBatteryDetails/replace'),array('title'=>'Manage'));
                                }

                            ?>
                            </div>
                        </div>
                        
                       


                        


                            

                            <?php

                            #echo CHtml::link('<img src="images/add.png" style="height:50px; width:50px; margin-right:4px !important"  />',array('tRServices/create'),array('title'=>'Manage'));
                            #echo CHtml::link('<img src="images/manage.png" style="height:40px; width:30px; margin-right:15px !important"  />',array('tRBatteryDetails/admin'),array('title'=>'Manage'));
                            # echo CHtml::link('<img src="images/update.png" style="height:37px; width:30px" />',array('tRServices/update&id='.$id),array('title'=>'Update'));


                            ?>

                       
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><center><?php echo $vehicleId?></center></h1>
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