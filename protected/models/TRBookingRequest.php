<?php

/**
 * This is the model class for table "booking_request".
 *
 * The followings are the available columns in table 'booking_request':
 * @property integer $Booking_Request_ID
 * @property integer $User_ID
 * @property integer $Vehicle_Category_ID
 * @property string $From
 * @property string $To
 * @property integer $No_of_Passengers
 * @property string $Booking_Status
 * @property integer $Allocation_Type_ID
 * @property string $Description
 * @property string $Requested_Date
 * @property integer $add_by
 * @property integer $add_date
 * @property integer $edit_by
 * @property integer $edit_date
 *
 * The followings are the available model relations:
 * @property MaUser $user
 * @property MaVehicleCategory $vehicleCategory
 * @property MaAllocationType $allocationType
 * @property VehicleBooking[] $vehicleBookings
 */
class TRBookingRequest extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRBookingRequest the static model class
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
		return 'booking_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('User_ID, Vehicle_Category_ID,No_of_Passengers,From, To','required'),
			array('User_ID, Vehicle_Category_ID, No_of_Passengers, Allocation_Type_ID', 'numerical', 'integerOnly'=>true),
			array('Booking_Status', 'length', 'max'=>100),
			array('Description,Requested_Date', 'safe'),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			
			array('No_of_Passengers', 'match', 'pattern'=>'/^([0-9])+$/'),
			#array('Description', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			//array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
            array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20})+$/'),

            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Booking_Request_ID, User_ID, Vehicle_Category_ID, From, To, No_of_Passengers, Booking_Status, Allocation_Type_ID, Description, Requested_Date, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'MaUser', 'User_ID'),
			'vehicleCategory' => array(self::BELONGS_TO, 'VehicleCategory', 'Vehicle_Category_ID'),
			'allocationType' => array(self::BELONGS_TO, 'MaAllocationType', 'Allocation_Type_ID'),
			'vehicleBookings' => array(self::HAS_MANY, 'VehicleBooking', 'Booking_Request_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Booking_Request_ID' => 'Booking Request',
			'User_ID' => 'User',
			'Vehicle_Category_ID' => 'Vehicle Category',
			'From' => 'From',
			'To' => 'To',
			'No_of_Passengers' => 'No of Passengers',
			'Booking_Status' => 'Booking Status',
			'Allocation_Type_ID' => 'Allocation Type',
			'Description' => 'Description',
			'Requested_Date' => 'Requested Date',
			'add_by' => 'Add By',
			'add_date' => 'Add Date',
			'edit_by' => 'Edit By',
			'edit_date' => 'Edit Date',
		);
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
		$criteria->compare('User_ID',$this->User_ID);
		$criteria->compare('Vehicle_Category_ID',$this->Vehicle_Category_ID);
		$criteria->compare('From',$this->From,true);
		$criteria->compare('To',$this->To,true);
		$criteria->compare('No_of_Passengers',$this->No_of_Passengers);
		$criteria->compare('Booking_Status',$this->Booking_Status,true);
		$criteria->compare('Allocation_Type_ID',$this->Allocation_Type_ID);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('Requested_Date',$this->Requested_Date,true);
		$criteria->compare('add_by',$this->add_by);
		$criteria->compare('add_date',$this->add_date);
		$criteria->compare('edit_by',$this->edit_by);
		$criteria->compare('edit_date',$this->edit_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	

	public function getBookingRequests()
	{
     	$criteria=new CDbCriteria;
		
		$userID = Yii::app()->getModule('user')->user()->id;
		
		//echo $userID; exit;
		
		$criteria->compare('User_ID',$userID);
				
		return new CActiveDataProvider($this, array(
            	'criteria' => $criteria,
            	
            	
		));
	}
	
	public function getPendingBookingRequests()
	{
		$criteria=new CDbCriteria;
		
		$criteria->compare('Booking_Status','Pending');
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}