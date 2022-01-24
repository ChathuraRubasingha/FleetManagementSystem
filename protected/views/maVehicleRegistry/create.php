

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
	$.fn.yiiGridView.update('ma-vehicle-registry-grid', {
		data: $(this).serialize()
	});
	return false;
});
"
);
?>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">
            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Vehicle Registry'=>array('edit'),
                        'Vehicle Registry
                    ');?>
                </ul>

            </div>
            <div class="col-xs-8">
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
            
            <div class="col-xs-4">
                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">Menu</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <?php echo MaVehicleRegistry::model()->menuarray('VehicleRegistry'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"></div>
                </div>     
            </div>
            
        </div>
    </div>
</div>


