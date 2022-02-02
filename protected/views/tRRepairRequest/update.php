
<?php

$id = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$vehicleId = Yii::app()->session['maintenVehicleId'];
	$upid = Yii::app()->request->getQuery('id');
if($userRole !=='3')
{
    $title="Update Repair Request Details";
}
else
{
    $title="අලුත්වැඩියා අයදුම් තොරතුරු යාවත්කාලින කිරීම";
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
                                'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$id),
                                'Repair'=>array('tRRepairRequest/repair'),
                                'Update Repair Request Details',
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
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRRepairRequest/create',"menuId"=>"maintenance"), array('title'=>'Add'));?>
                                <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRRepairRequest/adminRepair',"menuId"=>"maintenance"),array('title'=>'Manage')); ?>
                                
                            </div>
                        </div>


                        
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><center><?php echo $vehicleId; ?></center></h1>
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