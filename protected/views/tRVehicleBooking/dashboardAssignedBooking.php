
<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12" >
                <div class="panel panel-default" >
                    <div class="panel-heading large" style="color:#fff; background: #c21118">
                        <h1  class="panel-title" itemprop="name">Assigned Vehicle Bookings</h1>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12" >


                <div class="panel panel-default" >
                    

                    <div class="panel-body">


                       
<?php 

    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'trvehicle-booking-grid',
    'dataProvider'=>$model->getAssignedBookingRequestsDashBoard(),
    'columns'=>array(
    
        array('header'=>'Requested By', 'value'=>
        function($model) 
        {
            $userArray = array();
            $criteria = new CDbCriteria;
            $criteria->select=array('pro.firstname as User_ID');
            $criteria->join="inner join tbl_users user on user.id = t.User_ID inner join tbl_profiles pro on pro.user_id = user.id";
            $criteria->condition="t.Booking_Approval_ID =$model->Booking_Approval_ID and Booking_Status='Assigned'";
            $arr = TRVehicleBooking::model()->findAll($criteria);
            foreach ($arr as $users) 
            {
                $userArray[] = $users["User_ID"];
            }

            return implode(", ", $userArray);
        }
     ),
        array('name'=>'Vehicle_No', 'header'=>'Assigned Vehicle', 'value'=> '$data->approval->Vehicle_No != "" ? $data->approval->Vehicle_No : "-"' ),
        array('name'=>'Driver_ID', 'header'=>'Assigned Driver', 'value'=> '$data->approval->Driver_ID != "" ? $data->approval->drivers->Full_Name : "-"' ),
        
        array('header'=>'From', 'value'=> function($model) 
        {
            $placesArray = array();
            $plsFrom ='';
            $criteria = new CDbCriteria;
            $criteria->select=array('Place_from');
            $criteria->condition="Booking_Approval_ID='$model->Booking_Approval_ID' and Booking_Status='Assigned'";
            $arr = TRVehicleBooking::model()->findAll($criteria);
            // $arr = Yii::app()->db->createCommand('select * from vehicle_booking where Booking_Approval_ID 	='.$data->Booking_Approval_ID)->queryAll();
            foreach ($arr as $place) 
            {
                $placesArray[] = $place["Place_from"];
            }
            if(count($arr)>0)
            {
                $plsFrom =$arr[0]["Place_from"];
            }
            return  $plsFrom;
        }
        ),
        array('header'=>'Place To (Nearest City)', 'value'=> function($model) 
        {
            $placesArray = array();
            $criteria = new CDbCriteria;
            $criteria->select=array('Place_to');
            $criteria->condition="Booking_Approval_ID 	='$model->Booking_Approval_ID' and Booking_Status='Assigned'";
            $arr = TRVehicleBooking::model()->findAll($criteria);
           
            foreach ($arr as $place) 
            {
                $placesArray[] = $place["Place_to"];
            }
            return implode(", ", $placesArray);
        }
       ),

        'Approved_Date',
						
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}',
            'viewButtonUrl'=>'Yii::app()->createUrl("/tRVehicleBooking/editApprovedBookings", array("ApproveID" =>     
            $data["Booking_Approval_ID"], "VNo"=>$data["approval"]["Vehicle_No"], "drvr"=>$data["approval"]["Driver_ID"]))',
        ),
		
	
        ),/**/
    )
); ?>
                </div>




            </div>
            
        </div>

    </div>
</div>
</div>



