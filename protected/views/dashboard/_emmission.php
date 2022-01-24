<?php 
$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'emmission-view-grid',
'dataProvider'=>$emmission,
'columns'=>array(
'Vehicle_No',
array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
'Valid_To',
'Remaining_Days',

 //array('class'=>'CButtonColumn',
                        //'template'=>'{view}'),
						
),
));

/*

Yii::app()->clientScript->registerScript('chart1',"
$(document).ready(function(){
  var cosPoints = [];
  for (var i=0; i<2*Math.PI; i+=0.1){
     cosPoints.push([i, Math.cos(i)]);
  }
  var plot1 = $.jqplot('chart1', [cosPoints], { 
      series:[{showMarker:false}],
      axes:{
        xaxis:{
          label:'Angle (radians)'
        },
        yaxis:{
          label:'Cosine'
        }
      }
  });
});
");*/

?>

<?php 






















?>
