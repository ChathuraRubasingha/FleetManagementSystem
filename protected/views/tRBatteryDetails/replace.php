

<?php
$id = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$title = "Select Battery Request to add Replacement Details";

?>
<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$type = Yii::app()->request->getQuery('type');
Yii::app()->session['type']= $type;
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
                            'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                            'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$id),
                            'Battery'=>array('tRBatteryDetails/battery'),
                            'Battery Replacement',
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


                        <?php
                        if ($type == 'replace')
                        {
                            //echo  CHtml::link('<img src="images/add.png" style="height:60px; width:60px"  />',array('tRBatteryDetails/replace&type=replace'), array('title'=>'Add'));

                        }
                        else
                        {
                            echo '<div class="panel-body">';
                            echo  CHtml::link('<img src="images/add.png" style="height:60px; width:60px"  />',array('tRBatteryDetails/create'), array('title'=>'Add'));
                            echo ' </div>';
                        }?>





                </div>

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $vehicleId; ?></h1></center>
                    </div>

                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'trbattery-details-grid',
                            'dataProvider'=>$model->getPendingBatteryReplacements(),
                            //'filter'=>$model,
                            'columns'=>array(
                                'Battery_Details_ID',
                                array('name'=>'Full_Name', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
                                array('name'=>'Battery_Type', 'header'=>'Battery Type', 'value'=>'$data->batteryType->Battery_Type'),
                                array('name'=>'Request_Date', 'header'=>'Requested Date', 'value'=>'$data->Request_Date'),
                                'Approved_By',
                                'Approved_Date',

                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Request',
                                        'imageUrl'=>Yii::app()->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/tRBatteryDetails/update2", array("id" =>
					$data["Battery_Details_ID"], "batteryType" =>$data["Battery_Type_ID"],"type" => "replace"))',

                                    )),
                                    
                                   
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

                            <?php if($userRole !=='3')
                            {
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceBattery');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceBatteryForDriver');
                            }?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>


