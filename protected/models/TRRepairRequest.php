<?php

/**
 * This is the model class for table "repair_request".
 *
 * The followings are the available columns in table 'repair_request':
 * @property integer $Request_ID
 * @property string $Vehicle_No
 * @property integer $Driver_ID
 * @property string $Description_Of_Failure
 * @property string $Request_Date
 * @property string $Request_Status
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property RepairEstimateDetails[] $repairEstimateDetails
 * @property MaVehicleRegistry $vehicleNo
 * @property MaDriver $driver
 * InspectedBy
 * Meter_Reading
 */
class TRRepairRequest extends CActiveRecord
{
	/*
	 * Returns the static model of the specified AR class.
	 * @return TRRepairRequest the static model class
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
		return 'repair_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Description_Of_Failure, Vehicle_No, Meter_Reading, Request_Date, InspectedBy', 'required'),
			array('Driver_ID', 'numerical', 'integerOnly'=>true),
			array('Driver_ID, Meter_Reading', 'numerical'),
			array('Vehicle_No', 'length', 'max'=>20),
			array('Request_Status', 'length', 'max'=>12),
			array('add_by, edit_by, edit_date', 'length', 'max'=>50),
			array('add_date', 'safe'),
			
			//array('Description_Of_Failure', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
			//array('Description_Of_Failure', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
            //array('Description_Of_Failure', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\:\-\.\,\/ \r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20})+$/'),

            array('Request_Date', 'checkPrevious'),

            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Request_ID, Vehicle_No, InspectedBy, Driver_ID, Description_Of_Failure, Request_Date, Request_Status add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
		);
	}

    public function checkPrevious()
    {
        $Request_Date =$this->Request_Date;
        date_default_timezone_set('Asia/Colombo');
        $serverDate = MaVehicleRegistry::model()->getServerDate("date");

        if($Request_Date > $serverDate)
        {
            $this->addError('Request_Date',"'Request Date' should be a Previous Date");
            return false;
        }
        else
        {
            return true;
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
			'repairEstimateDetails' => array(self::HAS_MANY, 'RepairEstimateDetails', 'Request_ID'),
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
			'driver' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$userRole = Yii::app()->getModule('user')->user()->Role_ID;
		if($userRole !=='3')
		{
			return array(
				'Request_ID' => 'Request',
				'Vehicle_No' => 'Vehicle No',
				'InspectedBy' => 'Inpected/Checked By',
				'Driver_ID' => 'Driver of the Vehicle',
				'Description_Of_Failure' => 'Description Of Failure',
				'Request_Date' => 'Request Date',
				'Request_Status' => 'Request Status',
				'add_by' => 'Add By',
				'add_date' => 'Add Date',
				'edit_by' => 'Edit By',
				'edit_date' => 'Edit Date',
			);
		}
		else
		{
			return array(
				'Request_ID' => 'අයදුම් අංකය',
				'Vehicle_No' => 'වාහන අංකය',
				'Driver_ID' => 'රියැදුරු',
				'InspectedBy' => 'Checked By',
				'Description_Of_Failure' => 'අලුත්වැඩියා හේතුව ',
				'Request_Date' => 'අයදුම් කළ දිනය',
				'Request_Status' => 'අයදුමෙහි තත්ත්වය',
				'add_by' => 'ඇතුලත් කළේ ',
				'add_date' => 'ඇතුලත් කළ දිනය',
				'edit_by' => 'යාවත්කාලීන කළේ ',
				'edit_date' => 'යාවත්කාලීන කළ දිනය ',
		
			);
		}
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

		$criteria->compare('Request_ID',$this->Request_ID);
		$criteria->compare('InspectedBy',$this->Request_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('Description_Of_Failure',$this->Description_Of_Failure,true);
		$criteria->compare('Request_Date',$this->Request_Date,true);
		$criteria->compare('Request_Status',$this->Request_Status,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getRepairRequest()
	{
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria=new CDbCriteria;
		
		  /* $criteria->select = 'distinct t.Request_ID, t.Driver_ID, t.Description_Of_Failure, t.Request_Date';
    $criteria->join = "LEFT JOIN repair_estimate_details re ON  re.Request_ID=t.Request_ID";
    $criteria->condition = "re.Request_ID IS NULL"; */


		/*$this->getDbCriteria()->mergeWith( array(
		
    'alias' => 'repair_request',
    'join' => 'LEFT JOIN repair_estimate_details  ON  repair_estimate_details.Vehicle_No=repair_request.Vehicle_No',
    'condition' => 'repair_estimate_details.Request_ID IS not NULL',
) ); */
		$criteria->compare('t.Vehicle_No',$vehicleId);
		$criteria->compare('t.Request_Status','Pending');
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getRepairDetailsHistory()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		$criteria=new CDbCriteria;
		$criteria->compare('Vehicle_No',$vehicleId);
		//$criteria->compare('Approved_Status','Approved');
		//$criteria->compare('Replace_Status','Replaced');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>30),
			
		));
	}
	
	public function getDrivers()
	{	
		$LocId = (Yii::app()->getModule('user')->user()->Location_ID);
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
			
		if ($superuserstatus != 1)
		{
			$data = "SELECT Driver_ID, Full_Name FROM ma_driver WHERE Location_ID=".$LocId;
		}
		else
		{
		#$data = "SELECT Driver_ID, Full_Name FROM ma_driver";
			$data ="select d.Driver_ID, d.Full_Name, l.Location_Name from ma_driver d inner join ma_location l on d.Location_ID = l.Location_ID";
		}
		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		return $rawData;
	}
	
	public function getAllRepairDetailsHistory()
	{
		
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria=new CDbCriteria;

		#$criteria->compare('t.Request_ID',$this->Request_ID);
		$criteria->compare('t.Vehicle_No',$vehicleId,true);
		#$criteria->mergeWith(array('join'=>'left join ma_driver d on d.Driver_id = t.driver_id left outer join repair_estimate_details re on re.request_id = t.request_id left join ma_garages g on g.garage_id = re.garage_id left outer join vehicle_repair_details rd on rd.estimate_id = re.estimate_id'));
		
		#$criteria->mergeWith(array('join'=>'left outer join repair_estimate_details re on re.request_id = t.request_id left outer join vehicle_repair_details rd on rd.estimate_id = re.estimate_id'));
		
		/*$criteria->compare('d.Driver_ID',$this->Driver_ID);
		$criteria->compare('Description_Of_Failure',$this->Description_Of_Failure,true);
		$criteria->compare('Request_Date',$this->Request_Date,true);
		$criteria->compare('Request_Status',$this->Request_Status,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);*/

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		
	}
	
}