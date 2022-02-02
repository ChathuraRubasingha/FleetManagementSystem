<?php
$userRole = Yii::app()->getModule('user')->user()->Role_ID;


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pending-booking-grid', {
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
                    
                </ul>
            </div>
            
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Pending Booking Requests Registry</h1>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'pending-booking-grid',
                            'dataProvider'=>$model->getPendingBooking(),
                            'columns'=>array(
                                array('name'=>'Requested vehicle Category', 'header'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
                                'Requested_Date',
                                array('name'=>'username', 'header'=>'Requested By', 'value'=>'$data->user->username'),
                                'Place_from',
                                'Place_to',
                                array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/tRVehicleBooking/update", array("id" =>
                                        $data["Booking_Request_ID"], "menuId"=>"vehibooking"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRVehicleBooking/view", array("id" =>
                                        $data["Booking_Request_ID"], "menuId"=>"vehibooking"))',
                                    'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
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