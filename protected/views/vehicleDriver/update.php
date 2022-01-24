<style>
.back a
{
	background-color:#31E9FF !important;
}
</style>




<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                        $this->breadcrumbs=array(
                        'Vehicle Registry'=>array('maVehicleRegistry/edit'),
                        'Driver Assigned Vehicles'=>array('/vehicleDriver/admin'),
                        'Update Driver Assigned Vehicle Details'
                        );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Update Driver Assigned Vehicle Details</h1>
                    </div>
<!--                    <div class="panel-body">
                        <?php #echo CHtml::link('<img src="images/add.png" style="height:60px; width:60px"  />',array('tRVehicleLocation/admin'),array('title'=>'Manage'));?>

                    </div>-->

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
                            <?php echo MaVehicleRegistry::model()->menuarray('VehicleRegistry'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>













