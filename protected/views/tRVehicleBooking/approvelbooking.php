<?php
$this->breadcrumbs=array(
'Manage'=>array('admin'),
'Approve Vehicle Booking',
);

/*$this->menu=array(
//array('label'=>'View Approve Booking', 'url'=>array('index')),
array('label'=>'View Approve Booking', 'url'=>array('admin')),
);*/
?>


<?php $this->widget('application.extensions.email.debug'); ?>
<?php
$currentUsrLoc = (Yii::app()->getModule('user')->user()->Location_ID);



$id = Yii::app()->request->getQuery('id');
$from = Yii::app()->request->getQuery('from');
$to = Yii::app()->request->getQuery('to');
$cv = Yii::app()->request->getQuery('cv');
$placeFrom = Yii::app()->request->getQuery('placeFrom');
$category = Yii::app()->request->getQuery('category');
?>




	<div  class="group" style="width:600px; margin-left:360px" >
		
        <h1>Approve Vehicle Booking</h1>
        <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$request,
        'attributes'=>array(
        //'Booking_Request_ID',
        //'User_ID',
        array('label'=>'Requested By', 'value'=>$request->user->username),
        //array('label'=>'Designation_ID', 'value'=>$request->user->Designation_ID),
        array('label'=>'Requested Vehicle Category', 'value'=>$request->vehicleCategory->Category_Name),
        'From',
        'To',
        'Place_from',
        'Place_to',
      //  'Average_km',
		array('label'=>'Average Distance (km)', 'type'=>'raw','value'=>(!empty($model->Average_km)) ? CHtml::encode($model->Average_km) : '-'),
        //'No_of_Passengers',
		array('label'=>'Number of Passengers', 'type'=>'raw','value'=>(!empty($model->No_of_Passengers)) ? CHtml::encode($model->No_of_Passengers) : '-'),
        //array('label'=>'Allocation Type', 'value'=>$request->allocationType->Allocation_Type),
       // 'Description',
		array('label'=>'Description', 'type'=>'raw','value'=>(!empty($model->Description)) ? CHtml::encode($model->Description) : '-'),
        'Requested_Date',
        ),
        )); ?>
        
        
        <div class="row buttons" style="margin-left:350px; margin-top:10px">
            <?php #echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Approve'); ?>
            <?php echo CHtml::button('Approve', array('id'=>'Approve_btn')); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            
            <?php echo CHtml::button('Disapprove', array('id'=>'DisApprove_btn')); ?>
        </div>
	</div>
<script>

$(document).ready(function()
{
	$('#Approve_btn').click(function()
	{
		window.location = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=tRVehicleBooking/SupervisorApproval&id=<?php echo Yii::app()->request->getQuery('id'); ?>";
	});
	
	 $('#DisApprove_btn').click(function()
	 {
		 window.location = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=tRVehicleBooking/DisApprove&id=<?php echo Yii::app()->request->getQuery('id'); ?>";
     });	
});

</script>


    


