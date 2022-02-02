
<?php

$vehicleId = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$upid = Yii::app()->request->getQuery('id');

if($userRole !=='3')
{
    $title="New Battery Request";
}
else
{
	$title="නව බැටරියක් ලබා ගැනීම සඳහා අයදුම් කිරීම";
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
                                'New Battery Request',
                            );
                        }?>
                    </ul>
                </div>
                <div class="col-xs-8">
                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
                            <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRBatteryDetails/admin'),array('title'=>'Manage')); ?>
                                </div>
                        </div>


                        


                            <?php

                            #echo CHtml::link('<img src="images/add.png" style="height:50px; width:50px; margin-right:4px !important"  />',array('tRServices/create'),array('title'=>'Manage'));
                          //  echo CHtml::link('<img src="images/manage.png" style="height:40px; width:30px; margin-right:15px !important"  />',array('tRBatteryDetails/admin'),array('title'=>'Manage'));
                            # echo CHtml::link('<img src="images/update.png" style="height:37px; width:30px" />',array('tRServices/update&id='.$id),array('title'=>'Update'));


                            ?>

                        
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><center><?php echo $vehicleId?></center></h1>
                        </div>


                        <div class="panel-body">
                            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
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