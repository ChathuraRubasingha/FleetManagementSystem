
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
	$.fn.yiiGridView.update('traccident-grid', {
		data: $(this).serialize()
	});
	return false;
});
");


$superUser = Yii::app()->getModule('user')->user()->superuser;

?>
</div>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12" >
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(

                        'Accident'
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8" style="margin-left: 20%">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Accidents History of All Vehicles</h1>
                            <div style="float: right; margin-top: -30px">
                                <?php  echo  CHtml::link('<img src="images/add.png" style="height:37px; width:37px"  />',array('maVehicleRegistry/accident',"menuId"=>"accident"), array('title'=>'Add'));?>
                                <?php echo CHtml::link('<img src="images/search.png"  width="37px" height="37px"/>','#',array('class'=>'search-button','title'=>'Search')); ?>
                                
                            </div>
                    </div>

                    

                       
                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_search',array(
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
                            'id'=>'traccident-grid',
                            'dataProvider'=>$model->getAccidentHistory(),
                            'columns'=>array(
                                'Vehicle_No',
                                $superUser == 1 ? array('name'=>'Location_ID', 'header'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')) : array('name'=>'Location_ID','visible'=>false),
                                array('name'=>'Driver_ID', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
                                'Accident_Place',
                                'Date_and_Time',

                            ),
                        )); ?>
                    </div>
                </div>




            </div>

        </div>

    </div>
</div>