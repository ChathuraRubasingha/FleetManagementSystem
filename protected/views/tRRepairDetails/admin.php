
<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$type = Yii::app()->request->getQuery('type');
Yii::app()->session['type'] = $type;



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('repair-details-grid', {
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
                        'Repair'=>array('tRRepairRequest/repair'),
                        'Repair Estimate History',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Manage Repair Details</h1>
                    </div>

                    <div class="panel-body">


                        <?php  echo  CHtml::link('<img src="images/add.png" style="height:60px; width:60px"  />',array('tRRepairEstimateDetails/approvedEstimates',"menuId"=>"maintenance"), array('title'=>'Add'));?>
                        <?php #echo CHtml::link('<img src="images/search.png"  width="60px" height="60px"/>','#',array('class'=>'search-button','title'=>'Search')); ?>

                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_search',array(
                                'model'=>$model,
                            )); ?>
                        </div><!-- search-form -->
                        <div id="statusMsg">
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
	'id'=>'repair-details-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		
		array('name'=>'Replacement', 'header'=>'Replacement', 'value'=>'$data->replacement->Replacement'),
		'Approved_By',
		
		array(
			'class'=>'CButtonColumn',
                        'updateButtonUrl'=>'Yii::app()->createUrl("/tRRepairDetails/update", array("id" =>
                            $data["Repair_Details_ID"], "menuId"=>"maintenance"))',
                        'viewButtonUrl'=>'Yii::app()->createUrl("/tRRepairDetails/view", array("id" =>
                            $data["Repair_Details_ID"], "menuId"=>"maintenance"))',
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