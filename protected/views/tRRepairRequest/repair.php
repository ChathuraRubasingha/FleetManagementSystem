

<?php

$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$vehicleId = Yii::app()->session['maintenVehicleId'];

if($userRole !=='3')
{
    $title ="Repair Request History of the Vehicle";
    $garage ="Garage";
    $approved ="Approved By";
    $appDate ="Approved Date";
    $estimated ="Estimated Status";
?>

<?php }
else
{
$title="වාහනයේ පෙර කරන ලද අලුත්වැඩියා පිළිබඳ දත්ත ";
$garage =" ගරාජය";
$approved ="අනුමත කළේ";
$appDate =" අනුමත කළ දිනය";
$estimated = "තක්සේරු තත්ත්වය";
}
?>


    <div class="container body">
        <div id="main" role="main">
            <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <?php
                        $this->breadcrumbs=array(
                            'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                            'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                            'Repair Requests',
                        );
                        ?>
                    </ul>
                </div>
                <div class="col-xs-8">
                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title; ?></h1>
                            <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRRepairRequest/create',"menuId"=>"maintenance"), array('title'=>'Add'));?>
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
                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'trvehicle-repair-details-grid',
                                'dataProvider'=>$model->getAllRepairDetailsHistory(),
                                'columns'=>array(
                                    'Request_ID',
                                    $model->Driver_ID != null ? array('name'=>'Driver_ID', 'value'=>array($this, 'gridDriver')) : 'InspectedBy',
                                    'Request_Date',
                                    'Request_Status',
                                    array('name'=>$garage, 'header'=>$garage, 'value'=>array($this, 'gridGarage')),

                                    array('name'=>$approved, 'header'=>$approved, 'value'=>array($this, 'gridApprove')),
                                    array('name'=>$appDate,  'header'=>$appDate,'value'=>array($this, 'gridAppDate')),
                                    array('name'=>$estimated,  'header'=>$estimated,'value'=>array($this, 'gridEstStatus')),

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