<?php
$this->breadcrumbs=array(
	'Main Menu'=>array('site/booking'),
	
);

/*$this->menu=array(
	array('label'=>'List Booking Request', 'url'=>array('index')),
	array('label'=>'Manage Booking Request', 'url'=>array('admin')),
);*/


?>
<style type="text/css">
.table, th, td {vertical-align:top;}
</style>
<table>
<tr>
    <td>
        <div class="group" style="margin-left:10px; width:445px">
            <h1>Create New Booking Request</h1>
            
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </td>
    <td>
    <div class="group" style="margin-left:2px; padding-top:20px; margin-top:01px; vertical-align:top; width:675px">
        <h1>Previous Booking Requests</h1>
    
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'trbooking-request-grid',
                'dataProvider'=>$model->getBookingRequests(),
                'columns'=>array(
                array('name'=>'Category_Name', 'header'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
                'From',
                'To',
                'No_of_Passengers',
                'Description',
                'Requested_Date',
                'Booking_Status',
                
                /*array(
                'class'=>'CButtonColumn',
                ),*/
                ),
            )); ?>
    
        </div>
    </td>
  </tr>
</table>

