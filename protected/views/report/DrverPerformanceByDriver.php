<?php



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function()
{
	
	if ($('.search-form').is(':hidden')) 
	{
		$('.search-form').toggle();
		return false;
	}
	else 
	{
		location.reload();
		return false;
	}
	
	
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ma-driver-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
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
                        'Reports'=>array('notificationConfiguration/report'),
                        'Driver Performance Report - by driver'
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-4">
                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">
                            Vehicle Movement
                        </h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">

                            <?php echo MaVehicleRegistry::model()->menuarray('ReportMovement'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>

            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Driver Performance Report - by Driver</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/search.png"  class="searchIcon"/>','#',array('class'=>'search-button','title'=>'Search')); ?>
                        </div>
                    </div>

                    

                       
                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('//maDriver/_search',array(
                                'model'=>$model,
                            )); ?>
                        </div><!-- search-form -->
                    
                </div>


                <div class="panel panel-default">


                    <div class="panel-body">Select Vehicle from the below list.

                        <?php
                        $superUser = Yii::app()->getModule('user')->user()->superuser;
                        ?>
                        <div id="statusMsg">
                        </div>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'ma-driver-grid',
                            'dataProvider'=>$model->search(),
                            //'filter'=>$model,
                            'columns'=>array(
                                //'Driver_ID',
                                'Full_Name',
                                array('name'=>'Location', 'value'=>'$data->location->Location_Name'),
                                'NIC',
                                'Status',
                                'Mobile',
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Driver',
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/report/DriverPerformanceByDriverDate",  array("ID" =>$data["Driver_ID"]))',))
                                ),
                                                               
                            ),
                        )); ?>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
