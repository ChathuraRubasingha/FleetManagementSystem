<?php 

$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'vehicle-view-grid',
       // 'dataProvider'=>$model->searchEmployees(),
        'dataProvider'=>$booking,
         'columns'=>array(
                'Vehicle_No',
			        array('name'=>'Driver Name', 'value'=>'$data->driver->Full_Name'),
			              array('name'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
				
                ),
)); 

?>





