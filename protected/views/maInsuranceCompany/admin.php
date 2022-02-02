
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
	$.fn.yiiGridView.update('ma-insurance-company-grid', {
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
                    if($userRole !=='3')
                    {
                        $this->breadcrumbs=array(
                            'Configurations'=>array('notificationConfiguration/management'),
                            'Insurance Company',
                        );
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Insurance Company Registry</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('maInsuranceCompany/create',"menuId"=>"configuration"), array('title'=>'Add'));?>
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
                            'id'=>'ma-insurance-company-grid',
                            'dataProvider'=>$model->search(),
                            //'filter'=>$model,
                            'columns'=>array(
                                 'Insurance_Company_Name',
                                'Address',
                                'Land_phone_No',
                                'Mobile',
                                'Fax',
                                array(
                                    'class'=>'CButtonColumn',
                                    'updateButtonUrl'=>'Yii::app()->createUrl("/maInsuranceCompany/update", array("id" =>
                                        $data["Insurance_Company_ID"], "menuId"=>"configuration"))',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/maInsuranceCompany/view", array("id" =>
                                        $data["Insurance_Company_ID"], "menuId"=>"configuration"))',
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