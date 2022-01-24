<?php

    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
    $vehicleId = Yii::app()->session['maintenVehicleId'];
    $upid = Yii::app()->request->getQuery('id');
    $type = Yii::app()->request->getQuery('type');

if($userRole !=='3')
{
    $title="Repair Estimate Details";
}
else
{
	$title="අලුත්වැඩියා ඇස්තමේන්තු තොරතුරු ";
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
                                'Repair'=>array('tRRepairRequest/repair'),
                                'Repair Estimate Details',
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
                            if (($type == 'approved') || ($type == 'Disapproved') || ($type == 'completed') || ($type == 'rejected') || $userRole ==='3')
                            {

                            }
                            else
                            {
                                
                                #echo CHtml::link('<img src="images/add.png" style="height:50px; width:50px; margin-right:4px !important"  />',array('tRRepairRequest/admin'),array('title'=>'Add'));
                                echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRRepairEstimateDetails/admin&type='.$type,"menuId"=>"maintenance"),array('title'=>'Manage'));
                                echo "&nbsp;";
                                echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRRepairEstimateDetails/update&id='.$upid,"menuId"=>"maintenance"),array('title'=>'Update'));
                                

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

                            <?php
                            if ($type == 'completed')
                            {
                                $this->widget('zii.widgets.CDetailView', array(
                                    'data'=>$model,
                                    'attributes'=>array(
                                        'Estimate_ID',
                                        'Request_ID',
                                        array('name'=>'Driver', 'value'=>$model->request->driver->Full_Name),
                                        array('label'=>'Description', 'type'=>'raw', 'value'=>(!empty($model->Description) ? CHtml::encode($model->Description) : '-')),
                                        array('name'=>'Requested_Date', 'value'=>$model->request->Request_Date),
                                        array('name'=>'Request Status', 'value'=>$model->request->Request_Status),
                                        array('name'=>'Garage_ID', 'value'=>$model->garage->Garage_Name),
                                        array('name'=>'Total_Estimate', 'type'=>'raw', 'value'=>number_format($model->Total_Estimate,2)),
                                        'Estimate_Date',
                                        'Estimate_Status',
                                        $model->Estimate_Status == 'Pending' ? array('name'=>'Approved_By', 'type'=>'raw', 'value'=>($model->Approved_By), 'visible'=>false) : array('name'=>'Approved_By', 'type'=>'raw', 'value'=>($model->Approved_By), 'visible'=>true),
                                        $model->Estimate_Status == 'Pending' ? array('name'=>'Approved_Date', 'type'=>'raw', 'value'=>($model->Approved_Date), 'visible'=>false) : array('name'=>'Approved_Date', 'type'=>'raw', 'value'=>($model->Approved_Date), 'visible'=>true),

                                        'add_by',
                                        'add_date',
                                        $model->edit_by == 'Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                        $model->edit_date == 'Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false) : array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),

                                    ),
                                ));
                            }
                            else
                            {
                                $this->widget('zii.widgets.CDetailView', array(
                                    'data'=>$model,
                                    'attributes'=>array(
                                        'Estimate_ID',
                                        'Request_ID',
                                        array('name'=>'Garage_ID', 'value'=>$model->garage->Garage_Name),
                                        array('name'=>'Total_Estimate', 'type'=>'raw', 'value'=>number_format($model->Total_Estimate,2)),
                                        'Estimate_Date',
                                        $model->Estimate_Status == 'Pending' ? array('name'=>'Approved_By', 'type'=>'raw', 'value'=>($model->Approved_By), 'visible'=>false) : array('name'=>'Approved_By', 'type'=>'raw', 'value'=>($model->Approved_By), 'visible'=>true),
                                        $model->Estimate_Status == 'Pending' ? array('name'=>'Approved_Date', 'type'=>'raw', 'value'=>($model->Approved_Date), 'visible'=>false) : array('name'=>'Approved_Date', 'type'=>'raw', 'value'=>($model->Approved_Date), 'visible'=>true),
                                        'Estimate_Status',
                                        'add_by',
                                        'add_date',
                                        $model->edit_by == 'Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                        $model->edit_date == 'Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false) : array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),

                                    ),
                                ));
                            }
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
