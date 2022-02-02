<?php 

$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'fitness-view-grid',
        'dataProvider'=>$fitness,
        'columns'=>array(
                'Vehicle_No',
				array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
'Valid_To','Remaining_Days'
                )
		)
	); 
?>