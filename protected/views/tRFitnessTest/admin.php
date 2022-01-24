
<?php

$vehicleId = Yii::app()->session['maintenVehicleId'];
$id = Yii::app()->request->getQuery('id');
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trfitness-test-grid', {
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
                        'Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
                        'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$vehicleId),
                        'Fitness Test',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Fitness Test History of the Vehicle</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRFitnessTest/create'), array('title'=>'Add'));?>
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
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'trfitness-test-grid',
                            'dataProvider'=>$model->getFitnessTestHistory(),
                            //'filter'=>$model,
                            'columns'=>array(
                                array('name'=>'Garage_ID', 'header'=>'Garage Name', 'value'=>'$data->garage->Garage_Name'),
                                'Fitness_Test_Date',
                                'Valid_From',
                                'Valid_To',
                                'Fitness_Test_Result',
                                array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/tRFitnessTest/update", array("id" =>
                                        $data["Fitness_Test_ID"], "menuId"=>"maintenance"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRFitnessTest/view", array("id" =>
                                        $data["Fitness_Test_ID"], "menuId"=>"maintenance"))',
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