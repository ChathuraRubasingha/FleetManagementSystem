<?php

	$userRole = Yii::app()->getModule('user')->user()->Role_ID;
    $superUser = Yii::app()->getModule("user")->user()->superuser;

    if($userRole !=='3')
    {
        $title = "Select Vehicle to Manage Fuel Providing";
    }
    else
    {
        $title="ඉන්ධන පිරවීමේ දත්ත ඇතුලත් කිරීම සඳහා අදාල වාහනය තෝරා ගන්න" ;
    }
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
	$.fn.yiiGridView.update('ma-vehicle-registry-grid', {
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
                    if($userRole !=='3')
                    {
                        $this->breadcrumbs=array(
                            'Fuel',
                        );
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-8" style="margin-left: 20%">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
                        <div style="float: right; margin-top: -30px">

                            <?php echo CHtml::link('<img src="images/search.png"  class="searchIcon"/>','#',array('class'=>'search-button','title'=>'Search')); ?>
                        </div>
                        
                        
                    </div>

                  

                        




                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_searchVehicle',array(
                                'model'=>$model,
                            )); ?>
                        </div><!-- search-form -->
                        <div id="statusMsg">
                        </div>

                    
                </div>

                <div class="panel panel-default">


                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'ma-vehicle-registry-grid',
                            'dataProvider'=>$model->getVehicleListLocationWise(),
                            'columns'=>array(
                                'Vehicle_No',
                                array('name'=>'Vehicle_Category_ID', 'value'=>'$data->vehicleCategory->Category_Name'),
                                $superUser == 1 ? array('name'=>'Location_ID', 'header'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')):array('name'=>'Location_ID', 'visible'=>false),
                                array('name'=>'Make_ID', 'value'=>'$data->makeID->Make'),
                                array('name'=>'Fuel_Type_ID', 'value'=>'$data->fuelType->Fuel_Type'),

                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Vehicle',
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/tRFuelProvidingDetails/fuelProvidingHistory", array("id" =>
                                        $data["Vehicle_No"],"aid" =>
                                        $data["Allocation_Type_ID"], "menuId"=>"fuel"))'))
                                ),
                            ),
                        )); ?>

                    </div>
                </div>




            </div>

        </div>

    </div>
</div>
