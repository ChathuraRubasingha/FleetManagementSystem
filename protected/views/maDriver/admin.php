
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

<div class="container body">
  <div id="main" role="main">
    <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant"> 
      
      <div class="col-xs-12">
        <ul class="breadcrumb">
            <?php
            $this->breadcrumbs=array(
                'Driver'
            );
            ?>
        </ul>
      </div>
      <div class="col-xs-8" style="margin-left:20%">
        <div class="panel panel-default">
          <div class="panel-heading large">
            <h1 id="rest-title" class="panel-title" itemprop="name">Driver Details</h1>
            <div style="float: right; margin-top: -30px">
                <?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('maDriver/create',"menuId"=>"driver"), array('title'=>'Add'));?>
                <?php echo CHtml::link('<img src="images/search.png"  class="searchIcon"/>','#',array('class'=>'search-button','title'=>'Search')); ?>
                <?php echo CHtml::link('<img src="images/download.png" alt="Download"  width="37px" height="37px"/>','Drivers_Data Collection_Format.pdf',array('title'=>'Download Form','target'=>'blank')); ?>
 
            </div>
           </div>
          
          

     <div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

</div>


    <div class="panel panel-default">
        

        <div class="panel-body">

            <?php
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            ?>
            <div id="statusMsg">
            </div>
            <?php 
//            $this->widget('zii.widgets.grid.CGridView', array(
//  'dataProvider' => $model->searchDrivers(),
//  'columns' => array(
//    'NIC',
//            'Mobile',
//    array(
//      'class'=>Yii::app()->baseUrl.'/btnColumn/deleteJiuDialog',
//    
//      'deleteJiuDialog'=>array(
//        'id'=>'confirm',
//      ),
//   
//    ),
//   
//  ))
//);
//            
            ?>
            
            
            
            
            
            
            
            
            
            <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'ma-driver-grid',
            'dataProvider'=>$model->searchDrivers(),
            'columns'=>array(
            'Full_Name',
            $superUser != 1 ? array('name'=>'Location_ID', 'visible'=>false) :array('name'=>'Location_ID', 'header'=>'Location', 'value'=>'$data->location->Location_Name'),
            'NIC',
            'Mobile',

            array(
            'class'=>'CButtonColumn',
            'updateButtonUrl'=>'Yii::app()->createUrl("/maDriver/update", array("id" =>
                $data["Driver_ID"], "menuId"=>"driver"))',
            'viewButtonUrl'=>'Yii::app()->createUrl("/maDriver/view", array("id" =>
                $data["Driver_ID"], "menuId"=>"driver"))',
            'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
            ),
            ),
            )); ?>

        </div>
    </div>
</div>	
 <div class="col-xs-4">
       
        
       
        
        
     
      </div>
    </div>

  </div>
</div>


