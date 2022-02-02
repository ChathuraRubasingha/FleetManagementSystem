

<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trclaime-details-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$vehicleId = Yii::app()->session['accidentVehicleId'];
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
                        'Claim History',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Claim History of the Vehicle</h1>
                    </div>


                </div>


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $vehicleId; ?></h1></center>
                    </div>

                    <div class="panel-body">

                        <?php
                        $superUser = Yii::app()->getModule('user')->user()->superuser;
                        ?>
                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'trclaime-details-grid',
                            'dataProvider'=>$model->search(),
                            'columns'=>array(
                               'Estimate_ID',
                                array('name'=>'Insurance_Company_Name', 'header'=>'Insurance Company Name', 'value'=>'$data->insuranceCompany->Insurance_Company_Name'),
                               // 'Claime_Date',
                                array('name'=>'Claime_Amount', 'value'=>'number_format($data->Claime_Amount,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right:50px;')),
                                array('name'=>'Driver Name', 'value'=>'$data->estimate->accident->Driver_ID != "" ? $data->estimate->accident->driver->Complete_Name : "-"'),
                                 array('name'=>'Claime Amount from Driver', 'value'=>'$data->Driver_Claim_Amount == "" ? "-" : CHtml::encode(number_format($data->Driver_Claim_Amount,2))'),
                               // array('name'=>'Claim Date', 'value'=>'$data->Driver_Claim_Date == "" ? "-" : CHtml::encode($data->Driver_Claim_Date)'),
                                
                                array('name'=>'Third Party Name', 'type'=>'raw', 'value'=>'$data->Thirdparty_Name == "" ? "-" : CHtml::encode($data->Thirdparty_Name)'),
                                array('name'=>'Claime Amount from Third Party', 'type'=>'raw', 'value'=>'$data->Thirdparty_Claim_Amount == "" ? "-" : CHtml::encode(number_format($data->Thirdparty_Claim_Amount,2))'),
                                //array('name'=>'Claim Date', 'type'=>'raw', 'value'=>'$data->Thirdparty_Claim_Date == "" ? "-" : CHtml::encode($data->Thirdparty_Claim_Date)'),
                                
                                //'Recoverd_From',
                                array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/tRClaimeDetails/update", array("id" =>
                                        $data["Claime_ID"], "menuId"=>"accident"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRClaimeDetails/view", array("id" =>
                                        $data["Claime_ID"], "menuId"=>"accident"))',
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

                            <?php echo MaVehicleRegistry::model()->menuarray('Accident'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>