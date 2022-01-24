<?php

/**
 * This is the model class for table "booking_approval".
 *
 * The followings are the available columns in table 'booking_approval':
 * @property integer $Booking_Approval_ID
 * @property string $Approved_Date
 * @property string $New_Booking_Request_Date
 * @property string $In_Time
 * @property string $Out_Time
 * @property double $Mileage
 * @property integer $No_of_Pessengers
 *
 * The followings are the available model relations:
 * @property VehicleBooking[] $vehicleBookings
 */
class BookingApproval extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BookingApproval the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'booking_approval';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Approved_Date, New_Booking_Request_Date', 'required'),
			array('No_of_Pessengers', 'numerical', 'integerOnly'=>true),
			array('Mileage', 'numerical'),
			array('In_Time,Driver_ID, Out_Time, Vehicle_No', 'safe'),
			
			//array('In_Time', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd : H:i:s'),
			//array('Out_Time', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
			array('In_Time','compare','compareAttribute'=>'Out_Time','operator'=>'>', 'allowEmpty'=>true , 'message'=>'{attribute} must be greater than "{compareValue}".', 'on'=>'create, update'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Booking_Approval_ID, Approved_Date, New_Booking_Request_Date, In_Time, Out_Time, Vehicle_No, Driver_ID, Mileage, No_of_Pessengers', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'vehicleBookings' => array(self::HAS_MANY, 'TRVehicleBooking', 'Booking_Approval_ID'),
			'drivers' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{       $userRole = Yii::app()->getModule('user')->user()->Role_ID;
        
         return array(
			
                        'Booking_Approval_ID' => 'Booking Approval',
			'Approved_Date' => 'Approved Date',
			'New_Booking_Request_Date' => 'New Booking Request Date',
			'In_Time' => 'In Time',
			'Out_Time' => 'Out Time',
			'Mileage' => 'Mileage (km)',
			'No_of_Pessengers' => 'Number of Passengers',
		);
//       var_dump($userRole);
//       
//       die;
//                if(($userRole !== "3")&&($userRole !== "4")){
//                            
//                    return array(
//			
//                        'Booking_Approval_ID' => 'Booking Approval',
//			'Approved_Date' => 'Approved Date',
//			'New_Booking_Request_Date' => 'New Booking Request Date',
//			'In_Time' => 'In Time',
//			'Out_Time' => 'Out Time',
//			'Mileage' => 'Mileage (km)',
//			'No_of_Pessengers' => 'Number of Passengers',
//		);
//                    
//                        }  else {
//                            return array(
//			//translating to sinhala
//                        'Booking_Approval_ID' => 'වෙන්කර ගැනීම', 
//			'Approved_Date' => 'අනුමත කල දිනය',
//			'New_Booking_Request_Date' => 'නව වෙන්කල දිනය/වෙලාව',
//			'In_Time' => 'පැමිණී වෙලාව',
//			'Out_Time' => 'පිටත් වූ වේලාව',
//			'Mileage' => 'කිලෝමීටර ගණන (km)',
//			'No_of_Pessengers' => 'මඟින් ගණන',
//                        'Vehicle_No' => 'වාහන අංකය',
//                        
//		);
//                        }
        
                
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

		$criteria->compare('Booking_Approval_ID',$this->Booking_Approval_ID);
		$criteria->compare('Approved_Date',$this->Approved_Date,true);
		$criteria->compare('New_Booking_Request_Date',$this->New_Booking_Request_Date,true);
		$criteria->compare('In_Time',$this->In_Time,true);
		$criteria->compare('Out_Time',$this->Out_Time,true);
		$criteria->compare('Mileage',$this->Mileage);
		$criteria->compare('No_of_Pessengers',$this->No_of_Pessengers);
                   
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function newModel()
	{
		$model=new BookingApproval();
	}
//this function used by tRVehicleBooking/vehiclelist view similar function exists in TRVehicleBooking	
	public function getApprovedBookingRequests()
	{
		
            $criteria = new CDbCriteria(array('distinct'=>true));
            $userID = Yii::app()->getModule('user')->user()->id;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		
            $criteria->compare('Booking_Approval_ID',$this->Booking_Approval_ID);
            $criteria->compare('Vehicle_No',$this->Vehicle_No);
            $criteria->compare('Driver_ID',$this->Driver_ID);

            $criteria->compare('Approved_Date',$this->Approved_Date,true);
            $criteria->compare('New_Booking_Request_Date',$this->New_Booking_Request_Date,true);
		
            if($superuserstatus !== 1)
            {
                $criteria->mergeWith(array('join'=>'INNER JOIN vehicle_booking vb ON vb.Booking_Approval_ID = t.Booking_Approval_ID
                INNER JOIN tbl_users u on u.id = vb.User_ID',
                    'condition'=>"vb.Booking_Status ='Assigned' and u.Location_ID=$locID"));
            }
            else
            {
                $criteria->mergeWith(array('join'=>'INNER JOIN vehicle_booking vb ON vb.Booking_Approval_ID = t.Booking_Approval_ID',
                    'condition'=>'vb.Booking_Status ="Assigned"'));
            }

            $criteria->compare('vb.Approved_By', '');
		// driver = 3, security = 4, user= 2
            if(Yii::app()->getModule('user')->user()->Role_ID =="2")
            {
                $criteria->compare('vb.User_ID',$userID);
            }
		
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	public function setCompleteBooking($booking)
	{
		$update = Yii::app()->db->createCommand('UPDATE vehicle_booking SET Booking_Status = "Completed" WHERE Booking_Approval_ID ="'.$booking.'" ;')->execute();
		
		 //TRVehicleBooking::model()->updateByPk($booking, array('Booking_Status'=>'Completed'));
	}
	
    public function getApprovedBookingRequestsDashBoard()
	{
		$current_user=Yii::app()->user->name;
		$criteria = new CDbCriteria(array('distinct'=>true));
		$superUser = Yii::app()->getModule('user')->user()->superuser;
		$locID = Yii::app()->getModule('user')->user()->Location_ID;
		
		$criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_booking vb ON vb.Booking_Approval_ID = t.Booking_Approval_ID'));
		$criteria->compare('Booking_Status','Approved');

		if ($superUser != 1)
		{
			//$criteria->compare('Approved_By',$current_user);		
			//$criteria->compare('Booking_Status','Approved');
		}
		else
		{
			//$criteria->compare('Booking_Status','Approved');
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination'=>false,
		));
	}
	
	
	public function getAssignedBookingRequestsDashBoard()
	{
		$current_user=Yii::app()->user->name;
		$criteria = new CDbCriteria(array('distinct'=>true));
		$superUser = Yii::app()->getModule('user')->user()->superuser;
		$locID = Yii::app()->getModule('user')->user()->Location_ID;
		


		if ($superUser != 1)
		{
            $criteria->mergeWith(array('join'=>'INNER JOIN  vehicle_booking vb ON vb.Booking_Approval_ID  = t.Booking_Approval_ID inner join  tbl_users u on u.id = vb.User_ID '));
            $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
			$criteria->compare('Booking_Status','Assigned');
            $criteria->compare('u.Location_ID',$locID);
		}
		else
		{
            $criteria->mergeWith(array('join'=>'INNER JOIN  vehicle_booking vb ON vb.Booking_Approval_ID  = t.Booking_Approval_ID'));
            $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
			$criteria->compare('vb.Booking_Status','Assigned');
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination'=>false,
		));
	}
	
	public function getAssignedRequests($ApproveID)
	{
		$criteria=new CDbCriteria;
		
		$criteria->compare('t.Booking_Approval_ID',$ApproveID);
		$criteria->mergeWith(array('join'=>'INNER JOIN vehicle_booking vb ON vb.Booking_Approval_ID  = t.Booking_Approval_ID'));
		//$criteria->compare('ba.Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('vb.Booking_Status',"Assigned");		
		return new CActiveDataProvider($this, array(
            	'criteria' => $criteria,
            	'sort'=>array(
            	),	
		));
	}
	
}