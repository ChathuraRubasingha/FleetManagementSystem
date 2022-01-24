
<?php

$userRole = Yii::app()->getModule('user')->user()->Role_ID;


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
	$.fn.yiiGridView.update('vehicle-location-grid', {
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
                    $this->breadcrumbs=array(
                        'Vehicle Booking');
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Vehicle Booking Requests Registry</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRVehicleBooking/create',"menuId"=>"vehibooking"), array('title'=>'Add'));?>
                        </div>
                    </div>

                   


                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_search',array(
                                'model'=>$model,
                            )); ?>
                        </div><!-- search-form -->
                        <div id="statusMsg">
                        </div>

                 
                </div>

                <div class="panel panel-default">


                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'trvehicle-booking-grid',
                            #'dataProvider'=>$model->getPendingBookingRequests(),
                            'dataProvider'=>$model->searchBookings(),
                            //'filter'=>$model,
                            'columns'=>array(
                                'Requested_Date',
                                array('name'=>'username', 'header'=>'Requested By', 'value'=>'$data->user->profile->firstname'),
                                //array('name'=>'Category_Name', 'header'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
                                'Booking_Status',
                                'Place_from',
                                'Place_to',
                                'From',
                                'To',

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

            </div>
        </div>

    </div>
</div>









