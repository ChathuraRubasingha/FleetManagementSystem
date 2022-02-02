

<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$id = Yii::app()->request->getQuery('id');
$status=Yii::app()->session['fitnessStatus'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
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
                        'Insurance' =>array('tRInsurance/admin'),
                        'Insurance Details',
                    );

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Insurance Details</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRInsurance/create',"menuId"=>"maintenance"), array('title'=>'Add'));?>
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRInsurance/admin',"menuId"=>"maintenance"),array('title'=>'Manage')); ?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRInsurance/update&id='.$id,"menuId"=>"maintenance"),array('title'=>'Update')); ?>
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
                                array('label'=>'Insurance Company', 'value'=>$model->insuranceCompany->Insurance_Company_Name),
                                array('label'=>'Insurance Type', 'value'=>$model->insuranceType->Insurance_Type),
                                array('label'=>'Amount', 'value'=>number_format($model->Amount,2)),
                                array('label'=>'Sum Insured', 'value'=>number_format($model->Sum_Insured,2)),
                                'Date_of_Insurance',
                                'Valid_From',
                                'Valid_To',
                                'add_by',
                                'add_date',
                                $model->edit_by == 'Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                $model->edit_date == 'Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false) : array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),

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
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceView');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('MaintenanceViewForDriver');
                            }?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>
