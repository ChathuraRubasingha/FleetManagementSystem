




<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">
            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Vehicle Registry'=>array('edit'),
                        'Update Vehicle Details');
                    ?>
                </ul>

            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Update Vehicle Details</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('maVehicleRegistry/create',"menuId"=>"vreg"), array('title'=>'Add'));?>
                            <?php echo CHtml::link('<img src="images/view.png" class="viewIcon" />',array('maVehicleRegistry/view&id='.$model->Vehicle_No,"menuId"=>"vreg"),array('title'=>'View')); ?>
                       
                        </div>
                    </div>

                    
                </div>
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
            <div class="col-xs-4">

                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">Menu</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <?php echo MaVehicleRegistry::model()->menuarray('VehicleRegistry'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>