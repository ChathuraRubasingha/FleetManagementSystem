
<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$type = Yii::app()->request->getQuery('type');
$id = Yii::app()->request->getQuery('id');
$batteryType = Yii::app()->request->getQuery('batteryType');
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
	});
	$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trtyre-details-grid', {
	data: $(this).serialize()
	});
	return false;
	});
	");
if($userRole !=='3')
{
	$reqTitle="Tyre Request History of the Vehicle";
	$replaceTitle="Tyre Request History of the Vehicle";
}
else
{
	$reqTitle="වාහනයේ පෙර කරන ලද ටයර අයදුම් පිලිබඳ තොරතුරු";
	$replaceTitle="වාහනයේ පෙර කරන ලද ටයර ප්‍රතිස්ථාපන පිලිබඳ තොරතුරු";
}
date_default_timezone_set("Asia/Colombo");
?>


<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    if($userRole !=='3')
                    {
                        if($type == 'replace')
                        {
                            $this->breadcrumbs=array(
                                'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                                'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                                'Tyre'=>array('tRTyreDetails/tyre'),
                                'Tyre Replacement History'
                            );

                        }
                        else
                        {
                            $this->breadcrumbs=array(
                                'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                                'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                                'Tyre'=>array('tRTyreDetails/tyre'),
                                'Tyre Request History'
                            );
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php if ($type == 'replace')
                            {
                                echo "<h1>".$replaceTitle."</h1>";
                            }
                            else
                            {
                                echo "<h1>".$reqTitle."</h1>";
                            }?></h1>
                        <div style="float: right; margin-top: -30px">
<?php

                           if ($type == 'replace')
                           {
                               echo  CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRTyreDetails/replace&type=replace'), array('title'=>'Add'));
                           }
                           else
                           {
                               echo  CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRTyreDetails/create'), array('title'=>'Add'));
                           }

                       ?>
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
                        <?php
                        if ($type == 'replace')
                        {

                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'trtyre-details-grid',
                                'dataProvider'=>$model->getReplacedTyreRequests(),
                                'columns'=>array(
                                    'Tyre_Details_ID',
                                    array('name'=>'Request_Date', 'value'=>'date($data->Request_Date)'),
                                    array('name'=>'Driver_ID', 'value'=>'$data->driver->Full_Name'),
                                    'Life_Time',
                                    array('name'=>'Cost', 'value'=>'number_format($data->Cost,2)', 'htmlOptions'=>array("style"=>"text-align:right; padding-right:20px;")),
                                    'Replace_Date',
                                    array('name'=>'Meter_Reading', 'header'=>'Mater Reading', 'value'=>'$data->Meter_Reading'),
                                    array(
                                        'class'=>'CButtonColumn',
                                        'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
                                        'template'=>'{view}{update}{delete}',
                                        'viewButtonUrl'=>'Yii::app()->createUrl("/tRTyreDetails/view2", array("id" =>
			$data["Tyre_Details_ID"], "tyreType"=>$data["Tyre_Type_ID"], "type"=>"update", "menuId"=>"maintenance"))',
                                        'updateButtonUrl'=>'Yii::app()->createUrl("/tRTyreDetails/update2", array("id"=>$data["Tyre_Details_ID"], "type"=>"update", "menuId"=>"maintenance"))',
                                    'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',

                                        ),
                                ),
                            ));
                        }
                        else
                        {
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'trtyre-details-grid',
                                'dataProvider'=>$model->getPendingTyreRequests(),
                                'columns'=>array(
                                    'Tyre_Details_ID',
                                    array('name'=>'Request_Date', 'value'=>'date($data->Request_Date)'),
                                    array('name'=>'Driver_ID', 'value'=>'$data->driver->Full_Name'),
                                    array('name'=>'Tyre_Type_ID', 'value'=>'$data->tyreType->Tyre_Type'),
                                    array('name'=>'Tyre_Size_ID', 'value'=>'$data->tyreSize->Tyre_Size'),
                                    'Tyre_quantity',


                                    array(
                                        'class'=>'CButtonColumn',
                                        'updateButtonUrl'=>'Yii::app()->createUrl("/tRTyreDetails/update", array("id" =>
                                            $data["Tyre_Details_ID"], "menuId"=>"maintenance"))',
                                        'viewButtonUrl'=>'Yii::app()->createUrl("/tRTyreDetails/view", array("id" =>
                                            $data["Tyre_Details_ID"], "menuId"=>"maintenance"))',
                                        'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',

                                    ),
                                ),
                            ));
                        }
                        ?>

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
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceTyre');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceTyreForDriver');
                            }?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>