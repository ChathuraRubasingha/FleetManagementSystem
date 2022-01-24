
<?php


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


$vehicleId = Yii::app()->session['accidentVehicleId'];
?>

<script>
    $(document).ready(function()
    {
        $(".items tr td").click(function()
        {
            //var a =  $(this).parent("tr").children().eq(7).children('a').attr('href');
            var a =  $(this).parent("tr").children('td').eq(4).children('a').attr('href');
           
            window.location = a;
            
        });
    });
   
</script>


<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Accident'=>array('/tRAccident/accidentHistory'),
                        'Select Vehicle for Accident Details'=>array('/maVehicleRegistry/accident'),
                        'Add Claims'
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Select Accident Estimations for Claiming</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRClaimeDetails/admin',"menuId"=>"accident"),array('title'=>'Manage'));?>

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
                            'id'=>'trestimate-details-grid',
                            'dataProvider'=>$model->getEstimateDetails(),
                            'columns'=>array(
                                'Estimate_ID',
                                'Accident_ID',
                                array('name'=>'Damage_Estimate', 'value'=>'number_format($data->Damage_Estimate,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right:50px')),
                                'Estimated_Date',
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Accident',
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/tRClaimeDetails/create", array("estimateId" =>
                                        $data["Estimate_ID"], "menuId"=>"accident"))'))
                                ),
                                
                                /*array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRClaimeDetails/create", array("estimateId" =>
                    $data["Estimate_ID"]))',
                                ),*/
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

                            <?php
                                echo MaVehicleRegistry::model()->menuarray('Accident');
                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>