
<?php
$vehicleId = Yii::app()->session['accidentVehicleId'];



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('traccident-grid', {
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
                        'Accident'=>array('maVehicleRegistry/accidentView&id='.Yii::app()->session["accidentVehicleId"].''),
                        'Select Vehicle for Accident Details'=>array('/maVehicleRegistry/accident'),
                        'Accident History'

                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">


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
                            'id'=>'traccident-grid',
                            'dataProvider'=>$model->getAccidentDetails(),
                            'columns'=>array(
                                array('name'=>'Driver ID', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
                                'Accident_Place',
                                'Date_and_Time',
                                'Police_Station',
                                'Accident_Type',
                                array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/tRAccident/update", array("id" =>
                                        $data["Accident_ID"], "menuId"=>"accident"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRAccident/view", array("id" =>
                                        $data["Accident_ID"], "menuId"=>"accident"))',
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