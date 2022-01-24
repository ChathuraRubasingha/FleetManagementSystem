<?php #$vID = $_GET['id'];
$vID = Yii::app()->request->getQuery('id');
$type = Yii::app()->request->getQuery('type');
$vNo = Yii::app()->request->getQuery('vNo');

if ($vID != '')
{
	$cmd = 'Select Vehicle_No from vehicle_location where Vehicle_Location_ID ='.$vID;
	$rowData = Yii::app()->db->createCommand($cmd)->queryAll();
	$count = count($rowData);
	$vNo = $rowData[$count-1]['Vehicle_No'];
	
	
}
?>

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                        $this->breadcrumbs=array(
                        'Vehicle Registry'=>array('/maVehicleRegistry/edit'),
                        'Location Assigned Vehicles'=>array('/tRVehicleLocation/admin'),
                        'Update Assigned Vehicle Details');
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Update Assigned Vehicle Details</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRVehicleLocation/admin',"menuId"=>"vreg"),array('title'=>'Manage'));?>

                        </div>
                    </div>
                    
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $vNo; ?></h1></center>
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
                            <?php echo MaVehicleRegistry::model()->menuarray('VehicleRegistry'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>







