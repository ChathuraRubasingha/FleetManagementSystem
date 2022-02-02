
<?php
$vehicleId = Yii::app()->session['accidentVehicleId'];

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trestimate-details-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
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
                        'Estimate History'
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Estimation History of the vehicle</h1>
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
                            'id'=>'trestimate-details-grid',
                            'dataProvider'=>$model->search(),
                            'columns'=>array(
                                'Accident_ID',
                                array('name'=>'Damage_Estimate', 'value'=>'number_format($data->Damage_Estimate,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right:50px;')),
                                'Estimated_Date',
                                'Description',
                                array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/tREstimateDetails/update", array("id" =>
                                        $data["Estimate_ID"], "menuId"=>"accident"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tREstimateDetails/view", array("id" =>
                                        $data["Estimate_ID"], "menuId"=>"accident"))',
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