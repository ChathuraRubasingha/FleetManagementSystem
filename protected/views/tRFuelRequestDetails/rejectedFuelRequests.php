<?php 

    $vehicleId = Yii::app()->session['VehicleIdFuel'];
    $aid =Yii::app()->session['VehicleIdAllocationID'];

    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
    if($userRole !=='3')
    {
        $title="Rejected Fuel Requests";

        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rejected-fuel-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");

    }
    else
    {
        $title ='ප්‍රතික්‍ෂේප කරන ලද ඉන්ධන අයදුම් ';
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
                                    'Rejected Fuel Requests',
                                );
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-xs-8">
                        <div class="panel panel-default">
                            <div class="panel-heading large">
                                <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading large">
                                <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $vehicleId; ?></h1></center>
                            </div>

                            <div class="panel-body">


                                <div id="statusMsg">
                                </div>
                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id'=>'rejected-fuel-grid',
                                    'dataProvider'=>$model->getRejectedFuelRequests(),
                                    'columns'=>array(
                                        'Request_Date',
                                        array('name'=>'Driver_ID', 'value'=>'$data->driver->Full_Name'),
                                        'Required_Fuel_Capacity',
                                        'Fuel_Balance',

                                        array(
                                            'class'=>'CButtonColumn',
                                            'template'=>'{view}',
                                            'viewButtonUrl'=>'Yii::app()->createUrl("/tRFuelRequestDetails/view", array("id"=>$data["Fuel_Request_ID"],"type"=>"rejected", "menuId"=>"fuel"))',

                                        ),
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
                            </div>
                            <div class="panel-footer text-center"> </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>