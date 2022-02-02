

<?php

$vehicleId = Yii::app()->session['accidentVehicleId'];
$id = Yii::app()->request->getQuery('id');
?>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Accident'=>array('/tRAccident/accidentHistory'),
                        'Select Vehicle for Accident Details'=>array('/maVehicleRegistry/accident'),
                        'Add Claims'=>array('/tREstimateDetails/estimateClaime'),
                        'Claims Details',
                    );

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Claim Details of the Accident</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRClaimeDetails/admin'),array('title'=>'Manage'));?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRClaimeDetails/update&id='.$id),array('title'=>'Update'));?>
                        </div>
                    </div>

                </div>


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $vehicleId; ?></h1></center>
                    </div>

                    <div class="panel-body">


                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                'Estimate_ID',
                                array('label'=>'Insurance Company Name','value'=>$model->insuranceCompany->Insurance_Company_Name),
                                array('label'=>'Claime Amount from Insurance Company (Rs.)', 'value'=>number_format($model->Claime_Amount,2)),
                                array('label'=>'Claim Date (Insurance)', 'value'=>$model->Claime_Date),
                                
                                array('label'=>'Third Party Name', 'type'=>'raw', 'value'=>$model->Thirdparty_Name == '' ? '-' : CHtml::encode($model->Thirdparty_Name)),
                                array('label'=>'Claime Amount from Third Party (Rs.)', 'type'=>'raw', 'value'=>$model->Thirdparty_Claim_Amount == '' ? '-' : CHtml::encode(number_format($model->Thirdparty_Claim_Amount,2))),
                                array('label'=>'Claim Date (Third Party)', 'type'=>'raw', 'value'=>$model->Thirdparty_Claim_Date == '' ? '-' : CHtml::encode($model->Thirdparty_Claim_Date)),
                                
                                array('label'=>'Driver Name', 'type'=>'raw', 'value'=>$model->estimate->accident->Driver_ID == '' ? '-' : CHtml::encode($model->estimate->accident->driver->Complete_Name)),
                                array('label'=>'Claime Amount from Driver (Rs.)', 'type'=>'raw', 'value'=>$model->Driver_Claim_Amount == '' ? '-' : CHtml::encode(number_format($model->Driver_Claim_Amount,2))),
                                array('label'=>'Claim Date (Driver)', 'type'=>'raw', 'value'=>$model->Driver_Claim_Date == '' ? '-' : CHtml::encode($model->Driver_Claim_Date)),
                                
                                //array('label'=>'Sum Insured (Rs.)', 'type'=>'raw', 'value'=>(!empty($model->Sum_Insured)? CHtml::encode(number_format($model->Sum_Insured,2)) : '-')),
                                //array('label'=>'Recoverd From', 'type'=>'raw', 'value'=>$model->Recoverd_From == '' ? '-' : CHtml::encode($model->Recoverd_From)),
                                array('label'=>'Recovered Amount (Rs.)', 'type'=>'raw', 'value'=>(CHtml::encode(number_format($model->Claime_Amount + $model->Thirdparty_Claim_Amount + $model->Driver_Claim_Amount,2)))),
                                'add_by',
                                'add_date',
                                $model->edit_by == 'Not Edited'? array('visible'=>false):array('label'=>'Edit by', 'type'=>'raw','value'=>$model->edit_by),
                                $model->edit_date == 'Not Edited'? array('visible'=>false):array('label'=>'Edit date', 'type'=>'raw','value'=>$model->edit_date),

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

                            <?php echo MaVehicleRegistry::model()->menuarray('Accident'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
