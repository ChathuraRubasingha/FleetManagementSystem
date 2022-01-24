
 
 
 <?php #echo CHtml::link('<img src="images/Search.gif"  width="0px" height="0px"/>','#',array('class'=>'search-button')); ?>
                

               
               
<?php 

    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'trvehicle-booking-grid',
    'dataProvider'=>$assigned,
    //'filter'=>$model,
    'columns'=>array(
    //array('name'=>'Requested vehicle Category','header'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
    array('header'=>'Requested By', 'value'=> function($data) 
    {
        $userArray = array();
        $criteria = new CDbCriteria;
        $criteria->select=array('user.username as User_ID');
        $criteria->join="inner join tbl_users user on user.id = t.User_ID";
        $criteria->condition="t.Booking_Approval_ID 	='$data->Booking_Approval_ID' and Booking_Status='Assigned'";
        $arr = TRVehicleBooking::model()->findAll($criteria);
       // $arr = Yii::app()->db->createCommand('select * from vehicle_booking where Booking_Approval_ID 	='.$data->Booking_Approval_ID)->queryAll();
        foreach ($arr as $users) 
        {
                $userArray[] = $users["User_ID"];
        }
        return implode(", ", $userArray);
    }
    ),
    //array('name'=>'username', 'header'=>'Requested By', 'value'=>'$data->vehicleBookings->user->username'),
    'Vehicle_No',
    //'Driver_ID',
    array('name'=>'Full_Name', 'header'=>'Assigned Driver', 'value'=>'$data->drivers->Full_Name'),
    //array('name'=>'Place_from', 'header'=>'From', 'value'=>'$data->vehicleBookings->Place_from'),

    array('header'=>'From', 'value'=> function($data) 
        {
            $placesArray = array();
            $plsFrom ='';
            $criteria = new CDbCriteria;
            $criteria->select=array('Place_from');
            $criteria->condition="Booking_Approval_ID='$data->Booking_Approval_ID' and Booking_Status='Assigned'";
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
        array('header'=>'Place To (Nearest City)', 'value'=> function($data) 
        {
            $placesArray = array();
            $criteria = new CDbCriteria;
            $criteria->select=array('Place_to');
            $criteria->condition="Booking_Approval_ID 	='$data->Booking_Approval_ID' and Booking_Status='Assigned'";
            $arr = TRVehicleBooking::model()->findAll($criteria);
           // $arr = Yii::app()->db->createCommand('select * from vehicle_booking where Booking_Approval_ID 	='.$data->Booking_Approval_ID)->queryAll();
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
            $data["Booking_Approval_ID"], "VNo"=>$data["Vehicle_No"], "drvr"=>$data["drivers"]["Full_Name"]))',
        ),
		
	
        ),/**/
    )
); ?>