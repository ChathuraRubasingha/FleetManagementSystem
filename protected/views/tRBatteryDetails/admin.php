
<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$type = Yii::app()->request->getQuery('type');

$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$upid = Yii::app()->request->getQuery('id');

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trbattery-details-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

if($userRole !=='3')
{

    if($type == 'replace')
    {
        $replaceHistory="Battery Replacement History of the Vehicle";
    }
    else
    {
        $RequestHistory="Battery Request History of the Vehicle";
        
    }
}
else
{
	$RequestHistory="වාහනයේ පෙර කරන ලද බැටරි අයදුම් විස්තර";
	$replaceHistory="වාහනයේ පෙර කරන ලද බැටරි ප්‍රතිස්ථාපන විස්තර";
}
 

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
                                'Battery'=>array('tRBatteryDetails/battery'),
                                'Battery Replacement History',
                            );

                        }
                        else
                        {
                            $this->breadcrumbs=array(
                                'Vehicle Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                                'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                                'Battery'=>array('tRBatteryDetails/battery'),
                                'Battery Request History',
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
                                echo $replaceHistory;
                            }
                            else
                            {
                                echo  $RequestHistory;
                            }?></h1>
                        <div style="float: right; margin-top: -30px">
                            <?php
                                $url = 'tRBatteryDetails/create';
                                if ($type == 'replace')
                                {
                                    $url = 'tRBatteryDetails/replace&type=replace';                               
                                    
                                 
                                    
                                }
                               
                                     echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array($url), array('title'=>'Add'));
                                   
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
                                'id'=>'trbattery-details-grid',
                                'dataProvider'=>$model->getReplacedBatteryRequests(),
                                //'filter'=>$model,
                                'columns'=>array(
                                    'Battery_Details_ID',
                                    array('name'=>'Driver_ID', 'value'=>'$data->driver->Full_Name'),
                                    array('name'=>'Battery_Type_ID', 'value'=>'$data->batteryType->Battery_Type'),
                                    array('name'=>'Life_Time', 'value'=>'$data->Life_Time'),
                                    array('name'=>'Cost', 'value'=>'number_format($data->Cost,2)', 'htmlOptions'=>array('style'=>'text-align:right;padding-right:50px;')),
                                    array('name'=>'Replace_Date', 'value'=>'$data->Replace_Date'),
                                    array(
                                        'class'=>'CButtonColumn',
                                        'template'=>'{view}{update}{delete}',
                                        'viewButtonUrl'=>'Yii::app()->createUrl("/tRBatteryDetails/view2", array("id" =>
					$data["Battery_Details_ID"], "batteryType"=>$data["Battery_Type_ID"], "type"=>"update", "menuId"=>"maintenance"))',
                                        'updateButtonUrl'=>'Yii::app()->createUrl("/tRBatteryDetails/update2", array("id"=>$data["Battery_Details_ID"], "type"=>"update", "menuId"=>"maintenance"))'
                                    ),
                                ),
                            ));
                        }
                        else
                        {
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'trbattery-details-grid',
                                'dataProvider'=>$model->getPendingBatteryRequests(),
                                //'filter'=>$model,
                                'columns'=>array(
                                    'Battery_Details_ID',
                                    array('name'=>'Driver_ID', 'value'=>'$data->driver->Full_Name'),
                                    array('name'=>'Battery_Type_ID', 'value'=>'$data->batteryType->Battery_Type'),
                                    array(
                                        'class'=>'CButtonColumn',
                                        'updateButtonUrl'=>'Yii::app()->createUrl("/tRBatteryDetails/update", array("id" =>
                                            $data["Battery_Details_ID"], "menuId"=>"maintenance"))',
                                        'viewButtonUrl'=>'Yii::app()->createUrl("/tRBatteryDetails/view", array("id" =>
                                            $data["Battery_Details_ID"], "menuId"=>"maintenance"))',
                                        'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',

                                    ),
                                ),
                            ));
                        }

                        if((isset(Yii::app()->session['type']) && Yii::app()->session['type'] != ''))
                        {
                            unset(Yii::app()->session['type']);
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