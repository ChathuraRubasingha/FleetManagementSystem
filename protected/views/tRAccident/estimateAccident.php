
<?php
  	$vehicleId = Yii::app()->session['accidentVehicleId'];
?>


<script>
    $(document).ready(function()
    {
        $(".items tr td").click(function()
        {
            //var a =  $(this).parent("tr").children().eq(7).children('a').attr('href');
            var a =  $(this).parent("tr").children('td').eq(5).children('a').attr('href');
           
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
                        'Add Estimation'
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Select Accident for Estimation</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tREstimateDetails/admin',"menuId"=>"accident"),array('title'=>'Manage'));?>
                        </div>
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
                            'id'=>'traccident-grid',
                            'dataProvider'=>$model->getAccidentDetails(),
                            'columns'=>array(
                                'Accident_ID',
                                array('name'=>'Driver ID', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
                                'Accident_Place',
                                'Accident_Type',
                                'Date_and_Time',
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Accident',
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/tREstimateDetails/create", array("accidentId" =>
                                        $data["Accident_ID"], "menuId"=>"accident"))'))
                                ),
                                
                                /*array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tREstimateDetails/create", array("accidentId" =>
                                        $data["Accident_ID"], "menuId"=>"accident"))',
                                   
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

                            <?php echo MaVehicleRegistry::model()->menuarray('Accident'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>