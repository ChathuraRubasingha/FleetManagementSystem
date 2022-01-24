
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
                        'Add Estimation' =>array('/tRAccident/estimateAccident' ),
                        'Estimation Details'
                    );

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Estimation Details of the Accident</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tREstimateDetails/admin',"menuId"=>"accident"),array('title'=>'Manage'));?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tREstimateDetails/update&id='.$id,"menuId"=>"accident"),array('title'=>'Update'));?>

                        </div>
                    </div>

                    
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $vehicleId; ?></h1></center>
                    </div>

                    <div class="panel-body">

                        <?php 
                       
                        $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                               'Accident_ID',
                                array('label'=>'Damage Estimate (Rs.)', 'value'=>number_format($model->Damage_Estimate,2)),
                                'Estimated_Date',
                                array('label'=>'Description', 'value'=>(!empty($model->Description) ? CHtml::encode($model->Description):'-')),
                                'add_by',
                                'add_date',
                                $model->edit_by == 'Not Edited'? array('visible'=>false):array('label'=>'Edit By', 'type'=>'raw','value'=>$model->edit_by),
                                $model->edit_date == 'Not Edited'? array('visible'=>false):array('label'=>'Edit Date', 'type'=>'raw','value'=>$model->edit_date),

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
