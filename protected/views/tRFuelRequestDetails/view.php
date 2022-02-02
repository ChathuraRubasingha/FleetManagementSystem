
<?php
    $vehicleId=Yii::app()->session['VehicleIdFuel'];
    $id = Yii::app()->request->getQuery('id');
    $type = Yii::app()->request->getQuery('type');
    $aid =Yii::app()->session['VehicleIdAllocationID'];

    $userRole = Yii::app()->getModule('user')->user()->Role_ID;

    if($userRole !=='3')
    {
        $title="Fuel Request Details";
    }
    else
    {
	    $title ="ඉන්ධන අයදුම් විස්තර";

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
                                    'Fuel'=>array('/maVehicleRegistry/fuelRequest'),
                                    'Fuel Requests'=>array('/tRFuelProvidingDetails/fuelProvidingHistory&id='.$vehicleId.'&aid='.$aid),
                                    'Fuel Request Details',
                                );
                            }

                            ?>
                        </ul>
                    </div>
                    <div class="col-xs-8">

                        <div class="panel panel-default">
                            <div class="panel-heading large">
                                <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
                                <div style="float: right; margin-top: -45px; margin-right: -10px;">
  <?php
                                if (($type == 'approved') || ($type == 'disapproved') || ($type == 'rejected'))
                                {
                                }
                                else
                                {
                                    echo '<div class="panel-body">';
                                    echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRFuelRequestDetails/admin&id='.$vehicleId,"menuId"=>"fuel"),array('title'=>'Manage'));
                                    echo '&nbsp;';
                                    echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRFuelRequestDetails/update&id='.$id,"menuId"=>"fuel"),array('title'=>'Update'));
                                    echo '</div>';
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
                                        'Required_Fuel_Capacity',
                                        array('name'=>'Driver_ID','value'=>$model->driver->Full_Name),
                                        'Request_Date',
                                        array('name'=>'Request', 'value'=>$model->Reason !='' ? $model->Reason : "-"),
                                        'Fuel_Balance',
                                        'Meter_Reading',
                                        'Approve_Status',
                                        'add_by',
                                        'add_date',
                                        $model->edit_by == 'Not Edited'? array('name'=>'edit_by', 'visible'=>false) : array('name'=>'edit_by', 'value'=>$model->edit_by),
                                        $model->edit_date == 'Not Edited'? array('name'=>'edit_date', 'visible'=>false) : array('name'=>'edit_date', 'value'=>$model->edit_date),

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
                                    if($userRole !=='3')
                                    {
                                        echo MaVehicleRegistry::model()->menuarray('Fuel');
                                    }
                                    else
                                    {
                                        echo MaVehicleRegistry::model()->menuarray('FuelForDriver');
                                    }?>
                                </ul>
                                </ul>
                            </div>
                            <div class="panel-footer text-center"> </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>