
<?php
    $vehicleId = Yii::app()->session['VehicleIdFuel'];
    $aid =Yii::app()->session['VehicleIdAllocationID'];


    $userRole = Yii::app()->getModule('user')->user()->Role_ID;

    if($userRole !=='3')
    {
        $title="Update Fuel Request Details";
    }
    else
    {
        $title ="ඉන්ධන අයදුම් විස්තර යාවත්කාලීන කිරීම ";

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
                                    'Update Fuel Request Details',
                                );
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-xs-8">
                        <div class="panel panel-default">
                            <div class="panel-heading large">
                                <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title; ?></h1>
                                <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRFuelRequestDetails/admin&id='.$vehicleId,"menuId"=>"fuel"),array('title'=>'Manage')); ?>
                                </div>
                            </div>
                        


                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading large">
                                <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $vehicleId; ?></h1></center>
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
                            </div>
                            <div class="panel-footer text-center"> </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>