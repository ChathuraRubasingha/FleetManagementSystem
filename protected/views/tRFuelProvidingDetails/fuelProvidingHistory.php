
<?php
$vehicleId = Yii::app()->session['VehicleIdFuel'];
$aid = Yii::app()->session['VehicleIdAllocationID'];

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trfuel-providing-details-grid', {
		data: $(this).serialize()
	});
	return false;
});
");


	$userRole = Yii::app()->getModule('user')->user()->Role_ID;
    if($userRole !=='3')
    {
        $title ="Fuel Providing History of the Vehicle";
    }
    else
    {
        $title ="වාහනයේ පෙර කරන ලද ඉන්ධන පිරවුම් පිළිබඳ විස්තර ";
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
                                    'Fuel Requests',
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
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRFuelRequestDetails/create',"menuId"=>"fuel"), array('title'=>'Add'));?>
                                </div>
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
                                    'id'=>'trfuel-providing-details-grid',
                                    'dataProvider'=>$model->search(),
                                    'columns'=>array(
                                        'Fuel_Pumped_Date',
                                        'Fuel_Order_No',
                                        'Fuel_Station',
                                        array ('name'=>'Fuel_Type_ID', 'value'=>'$data->fuelType->Fuel_Type'),
                                        'Fuel_Amount',
                                        'Distance_Driven',
                                        array('name'=>'Payable_Amount', 'value'=>'number_format($data->Payable_Amount,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right:20px;')),

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
