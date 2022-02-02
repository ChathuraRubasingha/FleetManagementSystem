
<?php
  	$vehicleId = Yii::app()->session['maintenVehicleId'];
	$userRole = Yii::app()->getModule('user')->user()->Role_ID;
	$upid = Yii::app()->request->getQuery('id');
	$type = Yii::app()->request->getQuery('type');
if($userRole !=='3')
{

$title="Battery Request Details";
$approved='Approved By';
$disapproved="Disapproved By";
$reject="Rejected";
$appDate ="Approved Date";
$disAppDate ="Disapproved Date";
$rejDate ="Rejected Date";


}
else
{
	$title="බැටරි අයදුම් තොරතුරු";
	$approved='අනුමත කළේ';
	$disapproved="අනුමත නොකළේ";
	$reject="ප්‍රතික්‍ෂේප කළේ";
	$appDate="අනුමත කළ දිනය";
	$disAppDate ="අනුමත නොකළ දිනය";
	$rejDate ="ප්‍රතික්‍ෂේප කළ දිනය";
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
                                'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                                'Battery'=>array('tRBatteryDetails/battery'),
                                'Battery Request Details',
                            );
                        }

                        ?>
                    </ul>
                </div>
                <div class="col-xs-8">

                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
                            <?php
                            if ($type != 'rejected' && $type != 'disapproved' && $type != 'approved')
                            {
                                echo "<div style='float: right; margin-top: -30px'>";
                                echo CHtml::link('<img src="images/add.png" style="height:37px; width:37px"  />',array('tRBatteryDetails/create'), array('title'=>'Add'));
                                echo CHtml::link('<img src="images/manage.png" style="height:37px; width:30px; margin: 0 5px" />',array('tRBatteryDetails/admin'),array('title'=>'Manage'));
                                echo CHtml::link('<img src="images/update.png" style="height:37px; width:30px" />',array('tRBatteryDetails/update&id='.$upid),array('title'=>'Update'));
                                echo "</div>";
                                
                            }



                            ?>
                        </div>

                        


                            

                        
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h2><center><?php echo $vehicleId; ?></center></h2>
                        </div>

                        <div class="panel-body">

                            <?php $this->widget('zii.widgets.CDetailView', array(
                                'data'=>$model,
                                'attributes'=>array(
                                    'Battery_Details_ID',
                                    array('name'=>'Driver_ID', 'value'=>$request->driver->Full_Name),
                                    array('name'=>'Battery_Type_ID', 'value'=>$request->batteryType->Battery_Type),
                                    'Request_Date',
                                    $type == 'approved' ? array('label'=>$approved, 'value'=>$model->Approved_By):array('label'=>$approved, 'value'=>$model->Approved_By, 'visible'=>false),
                                    $type == 'approved' ? array('label'=>$appDate, 'value'=>$model->Approved_Date):array('label'=>$appDate, 'value'=>$model->Approved_Date, 'visible'=>false),
                                    $type == 'disapproved' ? array('label'=>$disapproved, 'value'=>$model->Approved_By):array('label'=>$disapproved, 'value'=>$model->Approved_By, 'visible'=>false),
                                    $type == 'disapproved' ? array('label'=>$disAppDate, 'value'=>$model->Approved_Date):array('label'=>$disAppDate, 'value'=>$model->Approved_Date, 'visible'=>false),
                                    $type == 'rejected' ? array('label'=>$reject, 'value'=>$model->Approved_By):array('label'=>$reject, 'value'=>$model->Approved_By, 'visible'=>false),
                                    $type == 'rejected' ? array('label'=>$rejDate, 'value'=>$model->Approved_Date):array('label'=>$rejDate, 'value'=>$model->Approved_Date, 'visible'=>false),
                                    'add_by',
                                    'add_date',
                                    $model->edit_by == 'Not Edited' ? array('name'=>'edit_by', 'type'=>'raw', 'value'=>$model->edit_by, 'visible'=>false): array('name'=>'edit_by', 'type'=>'raw', 'value'=>$model->edit_by, 'visible'=>true),
                                    $model->edit_date == 'Not Edited' ? array('name'=>'edit_date', 'type'=>'raw', 'value'=>$model->edit_date, 'visible'=>false): array('name'=>'edit_date', 'type'=>'raw', 'value'=>$model->edit_date, 'visible'=>true),
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