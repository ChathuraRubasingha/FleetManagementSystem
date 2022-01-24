

<?php 


$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'insurance-view-grid',
'dataProvider'=>$insuarance,
'columns'=>array(
'Vehicle_No', 
//array('name'=>'Location','value'=>'$data->vehicle_location->Location_ID'),
//array('name'=>'Model', 'type'=>'raw', 'value'=>array($this,'gridModel'), //call this controller method for each row
array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
//'Location_ID', 
'Valid_To',
'Remaining_Days',

//array('class'=>'CButtonColumn',
                        //'template'=>'{view}'
						//),
						
						
						
						
						
						
						
),
));

 ?>


		
		
		
		
      
<?php
/* 
Yii::app()->clientScript->registerScript('meter',"
$(document).ready(function(){
   s1 = [322];
 
   plot3 = $.jqplot('meter',[s1],{
       seriesDefaults: {
           renderer: $.jqplot.MeterGaugeRenderer,
           rendererOptions: {
               min: 100,
               max: 500,
               intervals:[200, 300, 400, 500],
               intervalColors:['#66cc66', '#93b75f', '#E7E658', '#cc6666']
           }
       }
   });
});
");*/

?>

