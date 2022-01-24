
<?php

$vehicleId = Yii::app()->session['maintenVehicleId'];
$id = Yii::app()->request->getQuery('id');
$type = Yii::app()->request->getQuery('type');
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

if($userRole !=='3')
{
    $title="Tyre Request Details";
    $approved='Approved By';
    $disapproved="Disapproved By";
    $reject="Rejected";
    $appDate ="Approved Date";
    $disAppDate ="Disapproved Date";
    $rejDate ="Rejected Date";
}
else
{
	$title="ටයර අයදුමෙහි විස්තර";
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
                            'Tyre'=>array('tRBatteryDetails/tyre'),
                            'Tyre Request Details',
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
<?php

                        if ($type !== 'rejected' && $type !== 'disapproved' && $type !== 'approved')
                        {
                            
                            #echo CHtml::link('<img src="images/add.png" style="height:50px; width:50px; margin-right:4px !important"  />',array('tRTyreDetails/create'),array('title'=>'Add'));
                            echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRTyreDetails/admin'),array('title'=>'Manage'));
                            echo '&nbsp;';
                            echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRTyreDetails/update&id='.$id),array('title'=>'Update'));
                            
                        }

                        ?>
                        </div>
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
                                'Tyre_Details_ID',
                                array('name'=>'Driver_ID', 'value'=>$model->driver->Full_Name),
                                array('name'=>'Tyre_Type_ID', 'value'=>$model->tyreType->Tyre_Type),
                                array('name'=>'Tyre_Size_ID', 'value'=>$model->tyreSize->Tyre_Size),
                                'Tyre_quantity',
                                'Request_Date',
                                $type == 'approved' ? array('label'=>$approved, 'value'=>$model->Approved_By):array('label'=>$approved, 'value'=>$model->Approved_By, 'visible'=>false),
                                $type == 'approved' ? array('label'=>$appDate, 'value'=>$model->Approved_Date):array('label'=>$appDate, 'value'=>$model->Approved_Date, 'visible'=>false),
                                $type == 'disapproved' ? array('label'=>$disapproved, 'value'=>$model->Approved_By):array('label'=>$disapproved, 'value'=>$model->Approved_By, 'visible'=>false),
                                $type == 'disapproved' ? array('label'=>$disAppDate, 'value'=>$model->Approved_Date):array('label'=>$disAppDate, 'value'=>$model->Approved_Date, 'visible'=>false),
                                $type == 'rejected' ? array('label'=>$reject, 'value'=>$model->Approved_By):array('label'=>$reject, 'value'=>$model->Approved_By, 'visible'=>false),
                                $type == 'rejected' ? array('label'=>$rejDate, 'value'=>$model->Approved_Date):array('label'=>$rejDate, 'value'=>$model->Approved_Date, 'visible'=>false),
                                'add_by',
                                'add_date',
                                $model->edit_by == 'Not Edited' ? array('visible'=>false):array('name'=>'edit_by', 'value'=>$model->edit_by),
                                $model->edit_date == 'Not Edited' ? array('visible'=>false):array('name'=>'edit_date', 'value'=>$model->edit_date),
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