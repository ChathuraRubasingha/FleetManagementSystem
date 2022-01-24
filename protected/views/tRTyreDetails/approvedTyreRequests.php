<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('approved-Tyre-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

if($userRole !=='3')
{
    $title="Approved Tyre Requests Registry";
}
else
{
	$title="අනුමත කළ ටයර අයදුම්";
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
                            'Tyre'=>array('tRTyreDetails/tyre'),
                            'Approved Tyre Requests'
                        );
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title ?></h1>
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
                            'id'=>'approved-Tyre-grid',
                            'dataProvider'=>$model->getApprovedTyreRequests(),
                            'columns'=>array(
                                'Tyre_Details_ID',
                                array('name'=>'Driver_ID', 'value'=>'$data->driver->Full_Name'),
								array('name'=>'Tyre_quantity', 'value'=>'$data->Tyre_quantity', 'htmlOptions'=>array('style'=>'text-align:center')),
								array('name'=>'Tyre_quantityType2', 'value'=>'$data->Tyre_quantityType2', 'htmlOptions'=>array('style'=>'text-align:center')),
                                'Approved_By',
                                'Approved_Date',

								array(
									'template' => '{pdf}',
									'class'=>'CButtonColumn',
									'viewButtonUrl'=>'Yii::app()->createUrl("/tRTyreDetails/view", array("id" =>
										$data["Tyre_Details_ID"], "menuId"=>"maintenance"))',									
									'updateButtonUrl'=>'Yii::app()->createUrl("/tRTyreDetails/update", array("id" =>
										$data["Tyre_Details_ID"], "menuId"=>"maintenance"))',									
									'buttons' => array ('pdf' => array
										(
											'imageUrl' => Yii::app()->request->baseUrl . '/images/updat1e.png',
											'imageUrl' => Yii::app()->request->baseUrl . '/images/updat1e.png',
											'type' => 'raw',
											'url' => 'Yii::app()->createUrl("/tRTyreDetails/TyreRequestReport", array("id" =>     
											$data["Tyre_Details_ID"], "viewType" =>"pdf"))',
											'options' => array('target' => '_blank', 'title'=>'Tyre Request'),
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