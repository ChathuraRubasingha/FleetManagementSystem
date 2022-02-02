<?php

/*
 * This is the model class for table "vehicle_booking".
 *
 * The followings are the available columns in table 'vehicle_booking':
 * @property integer $Booking_Request_ID
 * @property integer $User_ID
 * @property integer $Vehicle_Category_ID
 * @property string $Vehicle_No
 * @property integer $Driver_ID
 * @property string $From
 * @property string $To
 * @property integer $No_of_Passengers
 * @property string $Booking_Status
 * @property integer $Allocation_Type_ID
 * @property string $Description
 * @property string $In_Time
 * @property string $Out_Time
 * @property double $Mileage
 * @property string $Requested_Date
 * @property string $Approved_By
 * @property string $Approved_Date
 * @property integer $add_by
 * @property integer $add_date
 * @property integer $edit_by
 * @property integer $edit_date
 *
 * The followings are the available model relations:
 * @property MaVehicleCategory $vehicleCategory
 * @property MaAllocationType $allocationType
 * @property TblUsers $user
 * @property MaDriver $driver
 * @property VehicleBooking1[] $vehicleBooking1s
 */
class TRVehicleBooking extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRVehicleBooking the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
     
	/*
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vehicle_booking';
	}

	/*
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
            return array(
                array('Vehicle_Category_ID,From,To,Place_from,Place_to, Description', 'required'),
                array('User_ID, Vehicle_Category_ID, Driver_ID, No_of_Passengers, Allocation_Type_ID, Booking_Approval_ID', 'numerical', 'integerOnly'=>true),
                //array('Mileage', 'numerical'),
                array('add_date, edit_date,Mileage,In_Time, Out_Time, From, To, Requested_Date, add_by, edit_by, Place_from, Place_to, Average_km', 'safe'),
                array('Vehicle_No', 'length', 'max'=>20),
                array('Booking_Status, Assigned_By, Approved_By', 'length', 'max'=>100),
                array('Description, Approved_Date, Assigned_Date, user.username', 'safe'),
                array('Place_from, Place_to', 'match', 'pattern'=>'/^([A-Za-z0-9\-&\\/, ]*)+$/'),
                array('No_of_Passengers', 'match', 'pattern'=>'/^([0-9])+$/'),
                array('Average_km, Mileage', 'match', 'pattern'=>'/^([0-9\.])+$/'),
                
                array('From','checkFromTime'),
                array('To','checkToTime'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('Booking_Request_ID, User_ID, user.username, Vehicle_Category_ID, Vehicle_No, Driver_ID, From, To, No_of_Passengers, Booking_Status, Booking_Status_Reason, Assigned_By, Assigned_Date, Allocation_Type_ID, Description, In_Time, Out_Time, Mileage, Requested_Date, Booking_Approval_ID, Approved_By, Approved_Date, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
            );
	}

        public function checkFromTime() 
        {
            $chkDate = date("Y-m-d H:i:s", time());
            if(isset($this->From))
            {
                $chkDate = $this->From;
            }
            
            $time = substr($chkDate, 11);
            
            if($time == '00:00:00')
            {
                if(isset($this->From))
                {
                    $this->addError('From',"Time is required in 'From Date/time'");
                }                
            }           
            
        }
        
        public function checkToTime() 
        {
            $chkDate = date("Y-m-d H:i:s", time());
                       
            if(isset($this->To))
            {
                $chkDate = $this->To;
            }
            
            $time = substr($chkDate, 11);
            
            if($time == '00:00:00')
            {            
                if(isset($this->To))
                {
                    $this->addError('To',"Time is required in 'To Date/time'");
                }
                
            }            
            
        }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                'vehicleCategory' => array(self::BELONGS_TO, 'VehicleCategory', 'Vehicle_Category_ID'),
                'allocationType' => array(self::BELONGS_TO, 'MaAllocationType', 'Allocation_Type_ID'),
                'user' => array(self::BELONGS_TO, 'User', 'User_ID'),
                'driver' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
                'approval' => array(self::BELONGS_TO, 'BookingApproval', 'Booking_Approval_ID'),
                'vehicleBooking1s' => array(self::HAS_MANY, 'VehicleBooking1', 'Booking_Request_ID'),

            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
public function attributeLabels()
	{   
    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
      return array(
                    'Booking_Request_ID' => 'Request No',
                   'User_ID' => 'User',
                   'Vehicle_Category_ID' => 'Vehicle Category',
                   'Vehicle_No' => 'Vehicle No',
                   'Driver_ID' => 'Driver',
                   'From' => 'From Date/time',
                   'To' => 'To Date/time',
                   'Place_from' => 'Place From',
                   'Place_to'=> 'Place To (Nearest City)',
                   'Average_km'=>'Average Distance (km)',
                   'No_of_Passengers' => 'Number of Passengers',
                   'Booking_Status' => 'Booking Status',
                   'Approval_Status'=>'Approval Status',
                   'Allocation_Type_ID' => 'Allocation Type',
                   'Description' => 'Reason',
                   'In_Time' => 'In Time',
                   'Out_Time' => 'Out Time',
                   'Mileage' => 'Mileage (km)',
                   'Requested_Date' => 'Requested Date',
                   'Approved_By' => 'Approved By',
                   'Approved_Date' => 'Approved Date',
                   'Booking_Approval_ID' =>'Booking Approval ID',
                   'add_by' => 'Add By',
                   'add_date' => 'Add Date',
                   'edit_by' => 'Edit By',
                   'edit_date' => 'Edit Date');
    
		
//        if(($userRole !== "3")&&($userRole !== "4")){
//            
//            return array(
//			'Booking_Request_ID' => 'Request No',
//			'User_ID' => 'User',
//			'Vehicle_Category_ID' => 'Vehicle Category',
//			'Vehicle_No' => 'Vehicle No',
//			'Driver_ID' => 'Driver',
//			'From' => 'From Date/time',
//			'To' => 'To Date/time',
//			'Place_from' => 'Place From',
//			'Place_to'=> 'Place To (Nearest City)',
//			'Average_km'=>'Average Distance (km)',
//			'No_of_Passengers' => 'Number of Passengers',
//			'Booking_Status' => 'Booking Status',
//			'Approval_Status'=>'Approval Status',
//			'Allocation_Type_ID' => 'Allocation Type',
//			'Description' => 'Reason',
//			'In_Time' => 'In Time',
//			'Out_Time' => 'Out Time',
//			'Mileage' => 'Mileage (km)',
//			'Requested_Date' => 'Requested Date',
//			'Approved_By' => 'Approved By',
//			'Approved_Date' => 'Approved Date',
//			'Booking_Approval_ID' =>'Booking Approval ID',
//			'add_by' => 'Add By',
//			'add_date' => 'Add Date',
//			'edit_by' => 'Edit By',
//			'edit_date' => 'Edit Date',
//		);
//        }else{
//            //translating to sinhala
//            return array(
//			'Booking_Request_ID' => 'ඉල්ලුම් අංකය',
//			'User_ID' => 'User',
//			'Vehicle_Category_ID' => 'Vehicle Category',
//			'Vehicle_No' => 'වාහනය අංකය',
//			'Driver_ID' => 'රියැදුරු',
//			'From' => 'From Date/time',
//			'To' => 'To Date/time',
//			'Place_from' => 'Place From',
//			'Place_to'=> 'Place To (Nearest City)',
//			'Average_km'=>'Average Distance (km)',
//			'No_of_Passengers' => 'Number of Passengers',
//			'Booking_Status' => 'Booking Status',
//			'Approval_Status'=>'Approval Status',
//			'Allocation_Type_ID' => 'Allocation Type',
//			'Description' => 'Description',
//			'In_Time' => 'පැමිණී වෙලාව',
//			'Out_Time' => 'බැහැර වූ වෙලාව',
//			'Mileage' => 'සැතැප්ම ගණන (km)',
//			'Requested_Date' => 'වෙන්කල දිනය',
//			'Approved_By' => 'Approved By',
//			'Approved_Date' => 'Approved Date',
//			'Booking_Approval_ID' =>'Booking Approval ID',
//			'add_by' => 'Add By',
//			'add_date' => 'Add Date',
//			'edit_by' => 'Edit By',
//			'edit_date' => 'Edit Date',
//		);
//        }
        
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Booking_Request_ID',$this->Booking_Request_ID);
		//$criteria->compare('User_ID',$this->User_ID);
		
		$criteria->compare('user.username',$this->User_ID, true);
		$criteria->with = array('user'=>array('select'=>'user.username','together'=>true));

		$criteria->compare('Vehicle_Category_ID',$this->Vehicle_Category_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('From',$this->From,true);
		$criteria->compare('To',$this->To,true);
		$criteria->compare('No_of_Passengers',$this->No_of_Passengers);
		$criteria->compare('Booking_Status',$this->Booking_Status,true);
		$criteria->compare('Allocation_Type_ID',$this->Allocation_Type_ID);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('In_Time',$this->In_Time,true);
		$criteria->compare('Out_Time',$this->Out_Time,true);
		$criteria->compare('Mileage',$this->Mileage);
		$criteria->compare('Requested_Date',$this->Requested_Date,true);
		$criteria->compare('Approved_By',$this->Approved_By,true);
		$criteria->compare('Approved_Date',$this->Approved_Date,true);
		/*$criteria->compare('add_by',$this->add_by);
		$criteria->compare('add_date',$this->add_date);
		$criteria->compare('edit_by',$this->edit_by);
		$criteria->compare('edit_date',$this->edit_date);*/

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function searchBookings()
	{
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            $roleID = Yii::app()->getModule('user')->user()->Role_ID;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $user = Yii::app()->getModule('user')->user()->id;

            $criteria=new CDbCriteria;

            if ($superUser != 1 && $roleID!='6' && $roleID != '5')
            {
                $criteria->compare('User_ID',$user);
            }
            else
            {
                if($roleID!='6' || $roleID != '5')
                {
                    $criteria->compare('user.Location_ID',$locID, true);
                    $criteria->with = array('user'=>array('select'=>'user.Location_ID', 'together'=>true));
                }
            }
            $criteria->compare('Booking_Request_ID',$this->Booking_Request_ID);

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria, 'pagination'=>array('pageSize'=>20,),
                'sort'=>array('defaultOrder'=>'Requested_Date DESC'),
            ));
	}
	
	public function getDrivers1($from,$to)
	{		
		/*$data = "SELECT Driver_ID, Full_Name FROM ma_driver WHERE Driver_ID NOT IN (SELECT vb.Driver_ID FROM vehicle_booking vb 		        INNER JOIN booking_request q ON vb.Booking_Request_ID = q.Booking_Request_ID
 		WHERE (q.From BETWEEN  '".$from."' AND  '".$to."') OR (q.To BETWEEN '".$from."' AND '".$to."'))";*/
		
		$data = "SELECT Driver_ID, Full_Name FROM ma_driver WHERE NOT EXISTS (SELECT * FROM vehicle_booking v WHERE (v.From BETWEEN  '".$from."' AND  '".$to."') OR (v.To BETWEEN '".$from."' AND '".$to."'))";
		
		/*$data = "SELECT d.Driver_ID, d.Full_Name FROM ma_driver d WHERE d.Driver_ID NOT IN (SELECT v.Driver_ID FROM vehicle_booking v
        WHERE (v.From BETWEEN  '".$from."' AND  '".$to."') OR (v.To BETWEEN '".$from."' AND '".$to."'))";*/
		
		/*$data = "SELECT Driver_ID, Full_Name FROM ma_driver WHERE Driver_ID NOT IN (SELECT v.Driver_ID FROM vehicle_booking v 
        WHERE ('".$from."' BETWEEN v.From  AND  v.To) OR ('".$to."' BETWEEN v.From  AND  v.To))";*/

		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		
		return $rawData;
	}
	
	public function getVehicle($from,$to,$cv)
	{
		/*$data = "SELECT Vehicle_No FROM ma_vehicle_registry WHERE Vehicle_No NOT IN (SELECT vb.Vehicle_No FROM vehicle_booking vb         INNER         JOIN booking_request q ON vb.Booking_Request_ID = q.Booking_Request_ID
  		WHERE (q.From BETWEEN  '".$from."'AND  '".$to."') OR (q.To BETWEEN '".$from."' AND '".$to."')) AND Vehicle_Category_ID =         '".$cv."'" ;*/
		
		$data = "SELECT Vehicle_No FROM ma_vehicle_registry WHERE NOT EXISTS(SELECT * FROM vehicle_booking v WHERE (v.From BETWEEN '".$from."'AND  '".$to."') OR (v.To BETWEEN '".$from."' AND '".$to."')) AND Vehicle_Category_ID = '".$cv."'";

		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		
		return $rawData;
	}
	
	public function getAllocatedVehicles($from,$to,$cv)
	{        
		$criteria = new CDbCriteria;
 		$criteria->alias='b';
		$criteria->select= 'b.Vehicle_No, b.Driver_ID, r.From, r.To';
		$criteria->join= 'JOIN vehicle_booking b ON (b.Booking_Request_ID = r.Booking_Request_ID)';
		/*$criteria->condition=" b.Booking_Request_ID IN
		(
  			SELECT Booking_Request_ID
  			FROM booking_request
  			WHERE Vehicle_Category_ID = '".$cv."'
		)
		";*/
		//$criteria->group='id';
		//$criteria->order=' relevance DESC';
		
		return new CActiveDataProvider($this, array(
		'criteria'=>$criteria,
		));
    }
	
	public function GridData()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

            $criteria=new CDbCriteria;
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
	}
	
        public function getBookingRequests()
	{
            $criteria=new CDbCriteria;
		
            $userID = Yii::app()->getModule('user')->user()->id;
            $superuserstatus = Yii::app()->getModule('user')->user()->superuser;
		
		//echo $userID; exit;
            if ($superuserstatus != 1)
            {
                $criteria->compare('User_ID',$userID);
            }
            $criteria->compare('Booking_Status','Pending');
            
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'sort'=>array(
                    'defaultOrder'=>'Requested_Date DESC',
                )
            ));
	}
	
	
	public function getApprovedBookingRequests()
	{		
            $criteria = new CDbCriteria;
            $userID = Yii::app()->getModule('user')->user()->id;

            $criteria->compare('User_ID',$userID);		
            $criteria->compare('Booking_Status','Approved');

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
	}
	
	public function getApprovedBookingRequestsDashBoard()
	{
            $current_user=Yii::app()->user->name;
            $criteria = new CDbCriteria;
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;

            if ($superUser != 1)
            {
                $criteria->select = 't.Vehicle_No, d.Full_Name as Driver_ID, t.Booking_Request_ID, t.Vehicle_No, t.Driver_ID, t.Requested_Date,t.User_ID, t.Vehicle_Category_ID, t.Place_from, t.Place_to, t.From, t.To';
                $criteria->join = 'inner join  tbl_users u on u.id = t.User_ID left join ma_driver d on d.Driver_ID = t.Driver_ID';
                $criteria->condition = 't.Booking_Status = "Approved" and u.Location_ID = '.$locID;
            }
            else
            {
                $criteria->select = 't.Vehicle_No, d.Full_Name as Driver_ID, t.Booking_Request_ID,  t.Vehicle_No, t.Driver_ID, t.Requested_Date,t.User_ID, t.Vehicle_Category_ID, t.Place_from, t.Place_to, t.From, t.To';
                $criteria->join = 'left join ma_driver d on d.Driver_ID = t.Driver_ID';
                $criteria->condition = 't.Booking_Status = "Approved"';
            }
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>array('pageSize'=>30),
            ));	
		
	}
	
	public function getAssignedBookingRequestsDashBoard()
	{
            $current_user=Yii::app()->user->name;
            $criteria = new CDbCriteria(array('distinct'=>true));
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            $criteria->group='Booking_Approval_ID';
            $criteria->compare('Booking_Status','Assigned');
            $criteria->order="Approved_Date DESC";
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,'pagination'=>array('pageSize'=>30),
            ));		
	}
	
	
	public function getApprovedBookings()
	{
            $criteria=new CDbCriteria;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            if ($superUser != 1)
            {
                $criteria->select = 't.Vehicle_No, d.Full_Name as Driver_ID t.Booking_Request_ID, t.No_of_Passengers, t.Requested_Date,t.User_ID, t.Vehicle_Category_ID, t.Place_from, t.Place_to, t.From, t.To';
                $criteria->join = 'inner join  tbl_users u on u.id = t.User_ID left join ma_driver d on d.Driver_ID = t.Driver_ID';
                $criteria->condition = 't.Booking_Status = "Approved" and u.Location_ID = '.$locID;
            }
            else
            {
                $criteria->select = 't.Booking_Request_ID, t.No_of_Passengers, t.Requested_Date,t.User_ID, t.Vehicle_Category_ID, t.Place_from, t.Place_to, t.From, t.To';
                $criteria->condition = 't.Booking_Status = "Approved"';
            }
		
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>array('pageSize'=>15),
            ));
	}
	
	public function getPendingBookingRequests()
	{
            $criteria=new CDbCriteria(array('distinct'=>true));
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $superUser = Yii::app()->getModule('user')->user()->superuser;
		
		 
            if ($superUser != 1)
            {
                $criteria->select = 't.Vehicle_No, d.Full_Name as Driver_ID, t.Booking_Request_ID, t.Requested_Date,t.User_ID, t.Vehicle_Category_ID, t.Place_from, t.Place_to, t.From, t.To';
                $criteria->join = 'inner join  tbl_users u on u.id = t.User_ID left join ma_driver d on d.Driver_ID = t.Driver_ID';
                $criteria->condition = 't.Booking_Status = "Pending" and u.Location_ID = '.$locID;
            }
            else
            {
			
                $criteria->select = 't.Vehicle_No, d.Full_Name as Driver_ID, t.Booking_Request_ID, t.Requested_Date,t.User_ID, t.Vehicle_Category_ID, t.Place_from, t.Place_to, t.From, t.To';
                $criteria->join = 'left join ma_driver d on d.Driver_ID = t.Driver_ID';                
                $criteria->condition = 't.Booking_Status = "Pending"';
            }
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>array('pageSize'=>30),
            ));	
	}       
        
	
	public function getApprovedBookingRequestsCount()
	{
            $criteria=new CDbCriteria(array('distinct'=>true));
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            
            if ($superUser !== 1)
            {
                $criteria->select = 't.Booking_Request_ID, t.Requested_Date,t.User_ID, t.Vehicle_Category_ID, t.Place_from, t.Place_to, t.From, t.To';
                $criteria->join = 'inner join  tbl_users u on u.id = t.User_ID ';
                $criteria->condition = 't.Booking_Status = "Approved" and u.Location_ID = '.$locID;
            }
            else
            {			
                $criteria->select = 't.Booking_Request_ID, t.Requested_Date,t.User_ID, t.Vehicle_Category_ID, t.Place_from, t.Place_to, t.From, t.To';
                $criteria->condition = 't.Booking_Status = "Approved"';
            }
		
            $arr = $this->findAll($criteria);		
            return count($arr);
		
	}
        
	
	public function BookedVehicle()
	{
            $data = "SELECT Vehicle_No FROM vehicle_booking WHERE Booking_Status='Approved' ";

            $rawData = Yii::app()->db->createCommand($data)->queryAll();
            return $rawData;
	}
	
	
	public function getcurrentMilage($vehicleId)
	{
            $comand="SELECT odometer FROM ma_vehicle_registry where Vehicle_No='".$vehicleId."' ";
            $rawcurent = Yii::app()->db->createCommand($comand)->queryAll();
            $count = count($rawcurent);
            if ($count != 0)
            {
                $current=$rawcurent[$count-1]['odometer'];
            }
            else 
            {
                $current = '';
            }

            return $current;
	}
        
	public function Approve($arr, $vNo, $driver)
	{
            $requests = $arr;
            $reqArray= array();
            $comma='';
            
            while($requests !='')
            {
                $comma =  strpos($requests,',');
                if($comma!='')
                {
                    $sub = substr($requests,$comma);
                    $newReq = $requests;
                    $rVal = str_replace($sub,'',$newReq);				
                    $reqArray[]=$rVal;
                    $replace = $rVal.',';
                    $requests = str_replace($replace,'',$requests);
                }
                else
                {
                    $reqArray[]=$requests;
                    $requests ='';
                }
            };
            $count = count($reqArray);
		
            if($count>0)
            {
                $curUser = Yii::app()->getModule('user')->user()->username;
                $appDate = date("Y-m-d : H:i:s", time());
                for($i=0; $i<$count; $i++)
                {
                    $id = $reqArray[$i];
                    $data = "UPDATE vehicle_booking SET Booking_Status = 'Approved' , Vehicle_No = '".$vNo."', Driver_ID='".$driver."', Approved_By='".$curUser."', Approved_Date = '".$appDate."' WHERE Booking_Request_ID = '".$id."' ";
                    $rawData = Yii::app()->db->createCommand($data)->execute();
                }
            }
		
            $rawData = Yii::app()->db->createCommand($data)->execute();
            return true;
	}
	
	public function ApproveBySupervisor($id)
	{
            $usr = Yii::app()->getModule('user')->user()->username;
            $date = date("Y-m-d : H:i:s", time());
            TRVehicleBooking::model()->updateByPk($id, array('Booking_Status'=>'Approved', 'Approved_By'=>$usr, 'Approved_Date'=>$date));
	}
	
	public function DisApprove($reqID, $reason, $user)
	{            
            $appDate = MaVehicleRegistry::model()->getServerDate('DateTime');
            
            $data = TRVehicleBooking::model()->updateByPk($reqID, array('Booking_Status'=>'Disapproved', 'Booking_Status_Reason'=>$reason, 'Approved_By'=>$user, 'Approved_Date'=>$appDate));
           
            return true;
	}
	
	public function DisapproveBySupervisor($id)
	{				
            $requests = $id;
            $reqArray= array();
            $comma = '';

            while($requests !='')
            {
                $comma =  strpos($requests,',');

                if($comma!='')
                {
                    $sub = substr($requests,$comma);
                    $newReq = $requests;
                    $rVal = str_replace($sub,'',$newReq);				
                    $reqArray[]=$rVal;
                    $replace = $rVal.',';
                    $requests = str_replace($replace,'',$requests);
                }
                else
                {
                    $reqArray[]=$requests;
                    $requests ='';
                }
		};
		$count = count($reqArray);
		
		if($count>0)
		{
                    $curUser = Yii::app()->getModule('user')->user()->username;
                    $appDate = date("Y-m-d : H:i:s", time());
			
                    for($i=0; $i<$count; $i++)
                    {
                        $id = $reqArray[$i];
                        $data = "UPDATE vehicle_booking SET Booking_Status ='Disapproved', Approved_By='".$curUser."', Approved_Date = '".$appDate."' WHERE Booking_Request_ID ='".$id."' ";
                        $rawData = Yii::app()->db->createCommand($data)->execute();
                    }
		}
		
		$rawData = Yii::app()->db->createCommand($data)->execute();
		
		return true;
	}
	
	
	public function Reject($id)
	{
            $usr = Yii::app()->getModule('user')->user()->username;
            $date = date("Y-m-d : H:i:s", time());

            TRVehicleBooking::model()->updateByPk($id, array('Booking_Status'=>'Rejected', 'Approved_By'=>$usr, 'Approved_Date'=>$date,'Vehicle_No' => "", 'Driver_ID'=>NULL, 'Booking_Approval_ID'=>NULL));
            return true;
	}
	
	public function Remove($id)
	{
            $usr = Yii::app()->getModule('user')->user()->username;
            $date = date("Y-m-d : H:i:s", time());

            TRVehicleBooking::model()->updateByPk($id, array('Booking_Status'=>'Approved', 'Assigned_By'=>NULL, 'Assigned_Date'=>NULL, 'Booking_Approval_ID'=>NULL));
            return true;
	}
	
	
	public function PendingBookingReq()
        {
            $criteria=new CDbCriteria(array('distinct'=>true));

            $criteria->compare('Booking_Request_ID',$this->Booking_Request_ID);
            $criteria->compare('User_ID',$this->User_ID);
            $criteria->compare('Vehicle_Category_ID',$this->Vehicle_Category_ID);
            $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
            $criteria->compare('Driver_ID',$this->Driver_ID);
            $criteria->compare('From',$this->From,true);
            $criteria->compare('To',$this->To,true);
            $criteria->compare('No_of_Passengers',$this->No_of_Passengers);
            $criteria->compare('Booking_Status',$this->Booking_Status,true);
            $criteria->compare('Allocation_Type_ID',$this->Allocation_Type_ID);
            $criteria->compare('Description',$this->Description,true);
            $criteria->compare('In_Time',$this->In_Time,true);
            $criteria->compare('Out_Time',$this->Out_Time,true);
            $criteria->compare('Mileage',$this->Mileage);
            $criteria->compare('Requested_Date',$this->Requested_Date,true);
            $criteria->compare('Approved_By',$this->Approved_By,true);
            $criteria->compare('Approved_Date',$this->Approved_Date,true);
            $criteria->compare('add_by',$this->add_by);
            $criteria->compare('add_date',$this->add_date);
            $criteria->compare('edit_by',$this->edit_by);
            $criteria->compare('edit_date',$this->edit_date);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,

            ));
		
	}
	
	public function getPendingBooking()
	{
            $criteria=new CDbCriteria(array('distinct'=>true));

            $userID = Yii::app()->getModule('user')->user()->id;
            $roleID = Yii::app()->getModule('user')->user()->Role_ID;
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

            if ($superuserstatus != 1)
            {
                if($roleID!='6' && $roleID != '5')
                {
                    $criteria->compare('User_ID',$userID);
                }
            }
            $criteria->compare('Booking_Status','Pending',true);		
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'sort'=>array(
                'defaultOrder'=>'Requested_Date DESC',
                ),	
            ));
	}
	
	public function getApprovedBooking()
	{
            $criteria=new CDbCriteria(array('distinct'=>true));

            $userID = Yii::app()->getModule('user')->user()->id;
            $roleID = Yii::app()->getModule('user')->user()->Role_ID;
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

            if ($superuserstatus != 1)
            {
                if($roleID!='6' && $roleID != '5')
                {
                    $criteria->compare('User_ID',$userID);
                }
            }
            $criteria->compare('Booking_Status','Approved');		
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination'=>array('pageSize'=>60),
                'sort'=>array(
                'defaultOrder'=>'Requested_Date DESC',
                ),	
            ));
	}
        
        
	public function getAssignedVehicle()
	{
            $criteria=new CDbCriteria(array('distinct'=>true));
            $userID = Yii::app()->getModule('user')->user()->id;
            $roleID = Yii::app()->getModule('user')->user()->Role_ID;
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

            if ($superuserstatus != 1)
            {
                if($roleID!='6' && $roleID != '5')
                {
                    $criteria->compare('User_ID',$userID);
                }
            }
            $criteria->compare('Booking_Status','Assigned');		
            
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination'=>array('pageSize'=>60),
                'sort'=>array(
                'defaultOrder'=>'Requested_Date DESC',
                ),));
	}
	
	public function getRejectedBooking()
	{
            $criteria=new CDbCriteria(array('distinct'=>true));
		
            $userID = Yii::app()->getModule('user')->user()->id;
            $roleID = Yii::app()->getModule('user')->user()->Role_ID;
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

            if ($superuserstatus != 1)
            {
                if($roleID !='1' && $roleID !='6' && $roleID != '5')
                {
                    $criteria->compare('User_ID',$userID);
                }
            }
            $criteria->compare('Booking_Status','Rejected');		
            return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>array('pageSize'=>60),
            'sort'=>array(
            'defaultOrder'=>'Requested_Date DESC',
            ),	
            ));
	}
	
	public function getDisapprovedBooking()
	{
            $criteria=new CDbCriteria(array('distinct'=>true));
		
            $userID = Yii::app()->getModule('user')->user()->id;
            $role = Yii::app()->getModule('user')->user()->Role_ID;
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

            if ($superuserstatus != 1 && $role != '1')
            {
                $criteria->compare('User_ID',$userID);
            }
           
            $criteria->compare('Booking_Status','Disapproved');		
           
            return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>array('pageSize'=>60),
            'sort'=>array(
            'defaultOrder'=>'Requested_Date DESC',
            )));
	}
	
	public function getCompletedBooking()
	{   
            $userID = Yii::app()->getModule('user')->user()->id;
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

            $criteria=new CDbCriteria(array('distinct'=>true));

            $criteria->join = "inner join booking_approval as ba on ba.Booking_Approval_ID = t.Booking_Approval_ID ";
            $criteria->select = "t.*, ba.*";
            $criteria->condition = "t.Booking_Status = 'Completed'";                

            if(($superuserstatus !='1')&&(Yii::app()->getModule('user')->user()->Role_ID !=="3")&&(Yii::app()->getModule('user')->user()->Role_ID !=="4"))
            {
                $criteria->compare('User_ID',$userID);
            }

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination'=>array('pageSize'=>60),
                'sort'=>array(
                'defaultOrder'=>'Requested_Date DESC',
                ),	
            ));
	}
        
	public function getAssignedRequests($ApproveID)
	{
            $criteria=new CDbCriteria(array('distinct'=>true));

            $criteria->compare('t.Booking_Approval_ID',$ApproveID);
            $criteria->mergeWith(array('join'=>'INNER JOIN booking_approval ba ON ba.Booking_Approval_ID  = t.Booking_Approval_ID'));
            //$criteria->compare('ba.Vehicle_No',$this->Vehicle_No,true);
            $criteria->compare('t.Booking_Status',"Assigned");		
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'sort'=>array(
                ),	
            ));
	}
        
        public function DashboardPendingBooking($superuserstatus,$locID) 
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and u.Location_ID =$locID";
            }
            $cri7 = new CDbCriteria();
            $cri7->select="count(Booking_Request_ID) as Booking_Request_ID";
            $cri7->join="inner join tbl_users u on u.id = t.User_ID";
            $cri7->condition="t.Booking_Status = 'Pending'".$condition;
            $Array7 = $this->findAll($cri7);

            $countBookingRequests = 0;
            if (count($Array7) > 0)
            {
                $countBookingRequests = $Array7[0]['Booking_Request_ID'];
            }
            return $countBookingRequests;
            
        }
        
        public function DashboardApprovedBooking($superuserstatus,$locID) 
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and u.Location_ID =$locID";
            }
            $cri8 = new CDbCriteria();
            $cri8->select="count(Booking_Request_ID) as Booking_Request_ID";
            $cri8->join="inner join tbl_users u on u.id = t.User_ID";
            $cri8->condition="t.Booking_Status = 'Approved'".$condition;
            $Array8 = $this->findAll($cri8);

            $countApprovedBooking = 0;
            if (count($Array8) > 0)
            {
                $countApprovedBooking = $Array8[0]['Booking_Request_ID'];
            }
            
            return $countApprovedBooking;

        }
        
        public function DashboardAssignedBooking($superuserstatus,$locID) 
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and u.Location_ID =$locID";
            }
            $cri15 = new CDbCriteria();
            $cri15->select="count(Booking_Request_ID) as Booking_Request_ID";
            $cri15->join="inner join tbl_users u on u.id = t.User_ID";
            $cri15->condition="t.Booking_Status = 'Assigned'".$condition;
            $Array15 = $this->findAll($cri15);

            $countAssignedBooking = 0;
            if (count($Array15) > 0)
            {
                $countAssignedBooking = $Array15[0]['Booking_Request_ID'];
            }
            
            return $countAssignedBooking;
        }
	
	public function getVehiclesForAssigning($locID, $fromTime, $toTime) 
        {
            $vehicles = "select distinct vr.Vehicle_No, vr.Vehicle_Category_ID, vc.Category_Name
                    from ma_vehicle_registry vr
                    inner join vehicle_location  vl on vl.Vehicle_No = vr.Vehicle_No
                    inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
                    where vr.Vehicle_Status_ID =1 and vl.Location_ID = '$locID'  and vr.Vehicle_No not in (
                    select distinct ba.Vehicle_No from booking_approval ba
                    inner join vehicle_booking vb on vb.Booking_Approval_ID  = ba.Booking_Approval_ID
                    where ('$fromTime' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date or '$toTime' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date) and vb.Booking_Status = 'Approved')";

                $arrVehicle = Yii::app()->db->createCommand($vehicles)->queryAll();
                
                return $arrVehicle;
        }
        
        public function getAvailableDriversForAssign($locID, $fromTime, $toTime)
        {
            $queryDriver = "select distinct d.Driver_ID, d.Full_Name from ma_driver d
                where d.Location_ID = '$locID' and d.Driver_ID not in (
                select distinct ba.Driver_ID from booking_approval ba 
                inner join vehicle_booking vb on vb.Booking_Approval_ID  = ba. 	Booking_Approval_ID  
                where ('$fromTime' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date or '$toTime' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date) and vb.Booking_Status = 'Approved')
                order by d.Full_Name ASC";

                $arrDriver = Yii::app()->db->createCommand($queryDriver)->queryAll();
                
            return $arrDriver;
        }

}