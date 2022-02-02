<?php
$vehicleId = Yii::app()->session['OdoUpdateVehicle'];
$aid = Yii::app()->session['VehicleIdAllocationID'];

$userRole = Yii::app()->getModule('user')->user()->Role_ID;
if (($userRole !== '3') && ($userRole !== '4'))
{
    $driverHeader = 'Driver';
    $remark = 'Remark';
    $headTitle = "Odometer Update Details";
}
else
{
    $driverHeader = 'රියැදුරු';
    $remark = 'සටහන';
    $headTitle = "සම්පූර්ණ කල ඔඩෝමීටර යාවත්කාලීන කිරිම්";
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function()
{
	
	if ($('.search-form').is(':hidden')) 
	{
		$('.search-form').toggle();
		return false;
	}
	else 
	{
		location.reload();
		return false;
	}
	
	
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('odometer-update-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>






<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    if (($userRole !== '3') && ($userRole !== '4')) {

                    $this->breadcrumbs = array(
                        'Fuel' => array('maVehicleRegistry/fuelRequest'),
                        'Odometer Update Manage',
                    );
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-8" style="margin-left: 20%">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $headTitle?></h1>
                    </div>


                </div>

                <div class="panel panel-default">


                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'odometer-update-grid',
                            'dataProvider' => $model->completedOdo($vehicleId),
                            'columns' => array(
                                $userRole ==='3' || $userRole ==='4' ? array(
                                    'name' => 'Vehicle_No',
                                    'header' => 'වාහන අංකය',
                                    'value' => '$data->Vehicle_No'
                                ):array(
                                    'name' => 'Vehicle_No',
                                    'header' => 'Vehicle No',
                                    'value' => '$data->Vehicle_No',
                                    'visible'=>false
                                ) ,
                                array(
                                    'name' => 'Driver_ID',
                                    'header' => $driverHeader,
                                    'value' => '$data->driverid->Full_Name'
                                ),
                                array(
                                    'name' => 'remark_id',
                                    'header' => $remark,
                                    'value' => '$data->remark->description'
                                ),
                                'out_time',
                                'in_time',
                                array(
                                    'class' => 'CButtonColumn',
                                    'template' => '{view}',
                                    'viewButtonUrl' => 'Yii::app()->createUrl("/odometerUpdate/view", array("id" =>
					$data["update_id"],"vid" =>
			$data["Vehicle_No"]))',
                                )),

                        ));
                        ?>
                    </div>
                </div>




            </div>
<!--            <div class="col-xs-4">




                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">
                            Menu
                        </h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">

                            <?php
                            if(($userRole ==='2')||($userRole ==='6'))
                            {
                                echo MaVehicleRegistry::model()->menuarray('VehicleBookingLow');
                            }
                            elseif($userRole ==='3' || $userRole ==='4')
                            {
                                echo MaVehicleRegistry::model()->menuarray('OdometerSinhala');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('VehicleBooking');
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>-->
        </div>

    </div>
</div>