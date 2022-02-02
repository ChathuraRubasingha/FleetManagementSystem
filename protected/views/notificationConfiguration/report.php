



<?php $this->pageTitle=Yii::app()->name; ?>

<div class="container body">
 




<div class="col-xs-4" style="width:30%;float:left;margin-left:5%">
    <div class="panel panel-default rating-widget">
        <div class="panel-heading large">
            <h4 class="panel-title">VEHICLE MAINTENANCE</h4>
        </div>
        <div class="panel-body" style="height:350px">
            <ul class="list-unstyled">
                <?php echo MaVehicleRegistry::model()->menuarray('ReportMaintenance'); ?>
            </ul>
        </div>
        <div class="panel-footer text-center"></div>
    </div>     
</div>

<div class="col-xs-4" style="width:30%;float:left">
    <div class="panel panel-default rating-widget">
        <div class="panel-heading large">
            <h4 class="panel-title">VEHICLE MOVEMENT</h4>
        </div>
        <div class="panel-body" style="height:350px" >
            <ul class="list-unstyled">
                <?php echo MaVehicleRegistry::model()->menuarray('ReportMovement'); ?>
            </ul>
        </div>
        <div class="panel-footer text-center"></div>
    </div>     
</div>

<div class="col-xs-4" style="width:30%;float:left">
    <div class="panel panel-default rating-widget">
        <div class="panel-heading large">
            <h4 class="panel-title">VEHICLE REGISTRY</h4>
        </div>
        <div class="panel-body" style="height:350px">
            <ul class="list-unstyled">
                <?php echo MaVehicleRegistry::model()->menuarray('ReportVehicleReg'); ?>
            </ul>
        </div>
        <div class="panel-footer text-center"></div>
    </div>     
</div>

            
</div>


