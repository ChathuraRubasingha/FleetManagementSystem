
<style type="text/css">
.table, th, td {vertical-align:top;}
</style>
<?php
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
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
                        <h1 id="rest-title" class="panel-title" itemprop="name">Booking Request</h1>
                    </div>
                </div>

                <div class="panel panel-default">
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