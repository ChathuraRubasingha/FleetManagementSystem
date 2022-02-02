

<?php
$id = Yii::app()->session['maintenVehicleId'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$status=Yii::app()->session['fitnessStatus'];



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('insurance-grid', {
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
                        'Insurance',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Insurance History of the Vehicle</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('tRInsurance/create',"menuId"=>"maintenance"), array('title'=>'Add'));?>
                        </div>
                        
                    </div>

            
                        
                        <?php #echo CHtml::link('<img src="images/search.png"  width="60px" height="60px"/>','#',array('class'=>'search-button','title'=>'Search')); ?>

                      
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $id; ?></h1></center>
                    </div>

                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'insurance-grid',
                            'dataProvider'=>$model->getInsuranceTestHistory(),
                            //'filter'=>$model,
                            'columns'=>array(
                                array('name'=>'Insurance_Company_Name', 'header'=>'Insurance Company Name', 'value'=>'$data->insuranceCompany->Insurance_Company_Name'),
                                array('name'=>'Insurance_Type', 'header'=>'Insurance Type', 'value'=>'$data->insuranceType->Insurance_Type'),
                                array('name'=>'Amount', 'value'=>'number_format($data->Amount,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right:40px;')),
                                array('name'=>'Sum_Insured', 'value'=>'number_format($data->Sum_Insured,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right:40px;')),
                                'Date_of_Insurance',
                                'Valid_To',
                                array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/tRInsurance/update", array("id" =>
                                        $data["Insurance_ID"], "menuId"=>"maintenance"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRInsurance/view", array("id" =>
                                        $data["Insurance_ID"], "menuId"=>"maintenance"))',
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