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
	$.fn.yiiGridView.update('Search-details-grid', {
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
           
          //  window.location = a;
            
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
                        'Vehicle Details Report - Vehicle wise',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-4" style="width:32%;height:100%;float:left">
                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">VEHICLE REGISTRY</h4>
                    </div>
                    <div class="panel-body" style="">
                        <ul class="list-unstyled">
                            <?php echo MaVehicleRegistry::model()->menuarray('ReportVehicleReg'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"></div>
                </div>     
            </div>

            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Vehicle Details Report - Vehicle wise</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/search.png"  class="searchIcon"/>','#',array('class'=>'search-button','title'=>'Search')); ?>
                        </div>
                    </div>

                    

                        
                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('//maVehicleRegistry/_search',array(
                                'model'=>$modelper,
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
                            'id'=>'Search-details-grid',
                            'dataProvider'=>$modelper->search(),
                            'columns'=>array(
                                'Vehicle_No',
                                array('name'=>'Category_Name', 'header'=>'Vehicle Category Name', 'value'=>'$data->vehicleCategory->Category_Name'),
                                array('name'=>'Make_ID', 'header'=>'Make', 'value'=>'$data->makeID->Make'),
                                array('name'=>'Model', 'type'=>'raw', //because of using html-code
                                    'value'=>array($this,'gridModel'), //call this controller method for each row
                                ),
                                array('name'=>'Fuel_Type', 'header'=>'Fuel Type', 'value'=>'$data->fuelType->Fuel_Type'),
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Vehicle',
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/report/VehicleDetails",  array("ReportGridMemberID" =>$data["Vehicle_No"]))',))
                                ),
                                
                            ),
                        )); ?>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
