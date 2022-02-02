
<?php

$id = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$vehicleId = Yii::app()->session['maintenVehicleId'];

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trrepair-request-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

if($userRole !=='3')
{
    $title="Repair Request History of the Vehicle";
}
else
{
	$title="වාහනයට අදාළ අලුත්වැඩියා අයදුම් තොරතුරු ";

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
                            $this->breadcrumbs=array(
                                'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                                'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$id),
                                'Repair'=>array('tRRepairRequest/repair'),
                                'Repair Request History',
                            );
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-xs-8">
                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
                            <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRRepairRequest/create'), array('title'=>'Add'));?>
                            </div>
                            
                        </div>

                        
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $id; ?></h1></center>
                        </div>

                        <div class="panel-body">


                            <div id="statusMsg">
                            </div>
                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'trrepair-request-grid',
                                'dataProvider'=>$model->getRepairRequest(),
                                'columns'=>array(
                                    'Request_ID',
                                    'Request_Date',
                                    array('name'=>'Driver_ID', 'value'=> (isset($data->driver->Full_Name)?'$data->driver->Full_Name':'') ),
                                    'Description_Of_Failure',
                                    array(
                                        'class'=>'CButtonColumn',
                                        'updateButtonUrl'=>'Yii::app()->createUrl("/tRRepairRequest/update", array("id" =>
                                            $data["Request_ID"], "menuId"=>"maintenance"))',
                                        'viewButtonUrl'=>'Yii::app()->createUrl("/tRRepairRequest/view", array("id" =>
                                            $data["Request_ID"], "menuId"=>"maintenance"))',
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

                                <?php if($userRole !=='3')
                                {
                                    echo MaVehicleRegistry::model()->menuarray('MaintenanceRepair');
                                }
                                else
                                {
                                    echo MaVehicleRegistry::model()->menuarray('MaintenanceRepairForDriver');
                                }?>
                            </ul>
                        </div>
                        <div class="panel-footer text-center"> </div>
                    </div>

                </div>
            </div>

        </div>
    </div>