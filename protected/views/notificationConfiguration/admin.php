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
	$.fn.yiiGridView.update('notification-configuration-grid', {
		data: $(this).serialize()
	});
	return false;
});
");


?>

<!--<h1>Notification Configurations</h1>-->



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs = array(
                        'Configurations'=>array('notificationConfiguration/management'),
                        'System Configurations',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">System Configurations</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('notificationConfiguration/create',"menuId"=>"configuration"), array('title'=>'Add'));?>
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
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'notification-configuration-grid',
                            'dataProvider' => $model->search(),
//	'filter'=>$model,
                            'columns' => array(
//            'Row',
//            'Configuration_Name',
                                'Description',
///            'value'=>'(Log::model()->find("content_id=$data->id")->status_id) == 1 ? CHtml::image("/images/vert.png") : CHtml::image("/images/rouge.png")',
//            'value' => '($data->is_read !== "1")?$data->bold($data->name):$data->name',

                                array('name'=>'Value', 'value'=>'($data->Row == 4)? ($data->Value ==1 ? "On":"Off") : "$data->Value"'),

                                array(
                                    'class' => 'CButtonColumn',
                                    'template' => '{update}',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/notificationConfiguration/update", array("id" =>
                                        $data["Row"], "menuId"=>"configuration"))',
                                ),
                            ),
                        ));
                        ?>
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
                </div><!---->

            </div>
        </div>

    </div>
</div>