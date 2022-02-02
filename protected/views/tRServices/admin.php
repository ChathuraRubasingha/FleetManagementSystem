<?php
$id = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('services-grid', {
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
                        'Vehicle Details'=>array('maVehicleRegistry/maintanenceview&id='.$id),
                        'Services',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Service History of the Vehicle</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRServices/create',"menuId"=>"maintenance"), array('title'=>'Add'));?>
                            
                        </div>
                        
                    </div>

                    


                        
                        <?php #echo CHtml::link('<img src="images/search.png"  width="60px" height="60px"/>','#',array('class'=>'search-button','title'=>'Search')); ?>

                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_search',array(
                                'model'=>$model,
                            )); ?>
                        </div><!-- search-form -->
                        <div id="statusMsg">
                        </div>

                    
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $id; ?></h1></center>
                    </div>

                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'services-grid',
                            'dataProvider'=>$model->getServiceTestHistory(),
                            //'filter'=>$model,
                            'columns'=>array(
                                array('name'=>'Srvice_Station_Name', 'header'=>'Service Station Name', 'value'=>'$data->serviceStation->Srvice_Station_Name'),
                                array('name'=>'Service_Type', 'header'=>'Service Type', 'value'=>'$data->serviceType->Service_Type'),
                                'Service_Date',
                                'Meter_Reading',
                                array(
									'template' => '{view}{update}{delete}{pdf}',
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/tRServices/update", array("id" =>
                                        $data["Services_ID"], "menuId"=>"maintenance"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRServices/view", array("id" =>
                                        $data["Services_ID"], "menuId"=>"maintenance"))',
									'buttons' => array ('pdf' => array
										(
											'imageUrl' => Yii::app()->request->baseUrl . '/images/updat1e.png',
											'type' => 'raw',
											'url' => 'Yii::app()->createUrl("/tRServices/ServiceRequestReport", array("id" =>     
											$data["Services_ID"], "viewType" =>"pdf"))',
											'options' => array('target' => '_blank', 'title'=>'Repair Request'),
										),),										
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