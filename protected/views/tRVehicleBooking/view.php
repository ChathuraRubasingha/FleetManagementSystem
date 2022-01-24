
<script>

$(document).ready(function()
{
	$('#Cancel_btn').click(function()
	{		
            var height = $("body").height() ;//- $("#header").height() + $("#footer").height()
            $(".ontop").height(height);
            $("#errorConfirm").fadeIn(500);
            $('#errorConfirm p').html('Successfully Cancelled..!');
            $("#popDiv").fadeIn(500);
             window.location = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=tRVehicleBooking/Cancel&id="+<?php echo $model->Booking_Request_ID?>;
	});
});


</script>	
<style type="text/css">

.update{
	margin-left:94.4%;
	margin-top:-8.6px;}
</style>

<?php

$id = Yii::app()->request->getQuery('id');
$status = Yii::app()->request->getQuery('status');
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$display = 'block';
$approveBy = "";
$approveDate = "";

$assignedBy = array("label"=>  ucfirst($status)." By", "value"=>$model->Assigned_By, "visible"=>false);
$assignedDate = array("label"=>  ucfirst($status)." Date", "value"=>$model->Assigned_Date, "visible"=>false);
    
$reason= array("label"=>  ucfirst($status)." Reason", "value"=>$model->Booking_Status_Reason, "visible"=>false);
if($status=='assigned' || $status =='approved' || $status=='disapproved' || $status=='rejected')
{
    $display = 'none';
}
if($status=='disapproved' || $status=='rejected')
{
    $reason = array("label"=>  ucfirst($status)." Reason", "value"=>$model->Booking_Status_Reason);
    $approveBy = ucfirst($status)." By";
    $approveDate = ucfirst($status)." Date";
}
if($status=='assigned')
{
    $assignedBy = array("label"=>  ucfirst($status)." By", "value"=>$model->Assigned_By);
    $assignedDate = array("label"=>  ucfirst($status)." Date", "value"=>$model->Assigned_Date);
}
?>

    <div class="container body">
        <div id="main" role="main">
            <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <?php
                        $this->breadcrumbs=array(
                            'Vehicle Booking'=>array('tRVehicleBooking/booking'),
                            'View Booking Request'

                        );
                        ?>
                    </ul>
                </div>
                <div class="col-xs-8">

                    <div class="panel panel-default">
                        <div class="panel-heading large">
                            <h1 id="rest-title" class="panel-title" itemprop="name">Booking Request Details</h1>
                             <?php
                            if($status=='assigned' || $status =='approved' || $status=='disapproved' || $status=='rejected')
                            {

                            }
                            else
                            {
                                echo '<div style="float: right; margin-top: -30px">';
                                echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRVehicleBooking/update&id='.$id),array('title'=>'Update'));
                                echo "</div>";
                            }

                            ?>
                        </div>



                           


                    </div>


                    <div class="panel panel-default">


                        <div class="panel-body">

                            <?php $this->widget('zii.widgets.CDetailView', array(
                                'data'=>$model,
                                'attributes'=>array(
                                    'Booking_Request_ID',
                                    array('label'=>'Vehicle Category', 'value'=>$model->vehicleCategory->Category_Name),
                                    array('label'=>'Vehicle Number', 'type'=>'raw','value'=>(($model->Booking_Status ==='Pending'|| $model->Booking_Status === 'Approved'|| $model->Booking_Status ==='Disapproved') ? (!empty($model->Vehicle_No) ? CHtml::encode($model->Vehicle_No) : "-" ): (!empty($model->approval->Vehicle_No) ? CHtml::encode($model->approval->Vehicle_No) : "-"))),
                                    array('label'=>'Driver', 'type'=>'raw','value'=>(($model->Booking_Status ==='Pending'|| $model->Booking_Status ==='Approved'|| $model->Booking_Status ==='Disapproved') ? (!empty($model->Driver_ID) ? CHtml::encode($model->driver->Full_Name): "-") : (!empty($model->approval->drivers->Full_Name) ? CHtml::encode($model->approval->drivers->Full_Name) : "-"))),
                                    'From',
                                    'To',
                                    'Place_from',
                                    'Place_to',
                                    array('label'=>'Average Distance (km)', 'type'=>'raw','value'=>(!empty($model->Average_km)) ? CHtml::encode($model->Average_km) : '-'),
                                    array('label'=>'Number of Passengers', 'type'=>'raw','value'=>(!empty($model->No_of_Passengers)) ? CHtml::encode($model->No_of_Passengers) : '-'),
                                    'Requested_Date',
                                    array('label'=>'Booking Reason', 'type'=>'raw','value'=>(!empty($model->Description)) ? CHtml::encode($model->Description) : '-'),
                                    
                                    'Booking_Status',
                                    $reason,
                                    (empty($model->Approved_By)) ? array('label'=>$approveBy, 'value'=>$model->Approved_By, 'visible'=>false) : array('label'=>$approveBy, 'value'=>$model->Approved_By, 'visible'=>true),
                                    (empty($model->Approved_Date)) ? array('label'=>$approveDate, 'value'=>$model->Approved_Date, 'visible'=>false) : array('label'=>$approveDate, 'value'=>$model->Approved_Date, 'visible'=>true),
                                   
                                    $assignedBy,
                                    $assignedDate,
                                    'add_by',
                                    'add_date',$model->edit_by=='Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                    $model->edit_date=='Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false) : array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),
                                ),
                            )); ?>

                            <div class="btns" style="width:50%; margin-top:50px; margin-bottom:20px; float:right; display:<?php echo $display?>">

                                <?php echo CHtml::button('Cancel Request', array('id'=>'Cancel_btn', 'class'=>'otherBtns', 'style'=>'width:120px; margin-right:-20px')); ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="<?php echo Yii::app()->baseUrl;?>/index.php?r=tRVehicleBooking/pendingBooking"><?php echo CHtml::button('Exit', array('id'=>'Approve_btn','class'=>'otherBtns')); ?></a>
                            </div>

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
                            <ul class="list-unstyled">

                                <?php
                                if(($userRole ==='2')||($userRole ==='6'))
                                {
                                    echo MaVehicleRegistry::model()->menuarray('VehicleBookingLow');
                                }
                                elseif($userRole ==='3' || $userRole ==='4')
                                {
                                    echo MaVehicleRegistry::model()->menuarray('OdometerSinhala');
                                }
                                else
                                {
                                    echo MaVehicleRegistry::model()->menuarray('VehicleBooking');
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="panel-footer text-center"> </div>
                    </div>

                </div>
            </div>

        </div>
    </div>




