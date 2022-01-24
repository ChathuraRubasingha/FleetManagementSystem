
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
	$.fn.yiiGridView.update('ma-district-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php $userRole = Yii::app()->getModule('user')->user()->Role_ID;?>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Configurations'=>array('notificationConfiguration/management'),
                        'District',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">District Registry</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('maDistrict/create',"menuId"=>"configuration"), array('title'=>'Add'));?>
                            <?php echo CHtml::link('<img src="images/search.png"  class="searchIcon"/>','#',array('class'=>'search-button','title'=>'Search')); ?>
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
                            'id'=>'ma-district-grid',
                            'dataProvider'=>$model->search(),
                            'columns'=>array(
                                array('name'=>'Provincial_Councils_Name', 'header'=>'Provincial Council', 'value'=>'$data->provincialCouncils->Provincial_Councils_Name'),
                                'District_Name',
                                array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/maDistrict/update", array("id" =>
					$data["District_ID"], "menuId"=>"configuration"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/maDistrict/view", array("id" =>
					$data["District_ID"], "menuId"=>"configuration"))',
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
                        <div class="verticalaccordion">
                            <ul>
                                <?php echo MaVehicleRegistry::model()->menuarray('configurations');      ?>

                            </ul>
                        </div>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>