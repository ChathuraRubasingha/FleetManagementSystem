<?php

/*
 * This is the model class for table "ma_driver".
 *
 * The followings are the available columns in table 'ma_driver':
 * @property integer $Driver_ID
 * @property string $Full_Name
 * @property integer $Location_ID
 * @property string $NIC
 * @property string $Status
 * @property string $Mobile
 * @property string $Private_Address
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaLocation $location
 * @property VehicleBooking[] $vehicleBookings
 * @property VehicleLocation[] $vehicleLocations
 */
class MaDriver extends CActiveRecord
{
	/*
	 * Returns the static model of the specified AR class.
	 * @return MaDriver the static model class
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
		return 'ma_driver';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Full_Name, Location_ID, NIC, Mobile, Status', 'required'),
			array('Location_ID', 'numerical', 'integerOnly'=>true),
			array('Full_Name, Complete_Name, Private_Address', 'length', 'max'=>200),
			array('Mobile', 'length', 'max'=>10),
			//array('NIC', 'length', 'max'=>10),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('Complete_Name, add_date, edit_date, location.Location_Name, Driver_Image', 'safe'),
			array('NIC, Mobile, Full_Name, Complete_Name', 'unique'),
			array('NIC', 'filter', 'filter'=>'strtoupper'),
			
			array('Full_Name, Complete_Name', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			array('NIC', 'match', 'pattern'=>'/^([0-9]{9}[vxVX]|[0-9]{12})$/','message' =>'NIC Number is incorrect...'),
			array('Mobile', 'match', 'pattern'=>'/^([0-9]{10})+$/'),
			//array('Private_Address', 'match', 'pattern'=>'/^[-.?!,\/;:() A-Za-z0-9]*$/'),//^[a-z]*x[a-z]*$ 
			array('Private_Address', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Driver_ID, Full_Name, Complete_Name, Location_ID, NIC, Status, Mobile, Private_Address,Driver_Image, add_by, add_date, edit_by,edit_date', 'safe', 'on'=>'search'),
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
			'location' => array(self::BELONGS_TO, 'MaLocation', 'Location_ID'),
			'vehicleBookings' => array(self::HAS_MANY, 'VehicleBooking', 'Driver_ID'),
			'vehicleLocations' => array(self::HAS_MANY, 'VehicleLocation', 'Driver_ID'),
			'vehicleDriver' => array(self::HAS_MANY, 'VehicleDriver', 'Driver_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Driver_ID' => 'Driver',
			'Full_Name' => 'Calling Name',
			'Complete_Name' => 'Full Name',
			'Location_ID' => 'Location',
			'NIC' => 'NIC',
			'Status' => 'Status',
			'Mobile' => 'Mobile',
			'Private_Address' => 'Private Address',
			'Driver_Image'=>'Driver\'s Photo',
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
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        // Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('Full_Name',$this->Full_Name,true);
		$criteria->compare('Complete_Name',$this->Complete_Name,true);
		//$criteria->compare('Location_ID',$this->Location_ID);
        if ($superuserstatus != 1)
        {
            $criteria->mergeWith(array('join'=>'LEFT JOIN ma_location l ON l.Location_ID = t.Location_ID', 'condition'=>'l.Location_ID ='.$LocId,));
            $criteria->compare('l.Location_ID',$this->Location_ID,true);

        }
        else
        {
            $criteria->mergeWith(array('join'=>'LEFT JOIN ma_location  l ON l.Location_ID = t.Location_ID'));
            $criteria->compare('l.Location_Name',$this->Location_ID,true);
        }
		$criteria->compare('NIC',$this->NIC,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('Mobile',$this->Mobile,true);
		$criteria->compare('Private_Address',$this->Private_Address,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination'=>array('pageSize'=>30,),'sort'=>array('defaultOrder'=>'l.Location_Name, Full_Name ASC'),
		));
	}
	
	
	public function searchDrivers()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$superUser = Yii::app()->getModule('user')->user()->superuser;
		$locID = Yii::app()->getModule('user')->user()->Location_ID;
		
		if ($superUser != 1)
		{
            $criteria=new CDbCriteria(array('order'=>'t.Full_Name ASC'));
		}
		else
		{	
			$criteria=new CDbCriteria(array('order'=>'location.Location_Name ASC, t.Full_Name ASC'));
		}
		
		
		
		if ($superUser != 1)
		{
			$criteria->compare('t.Location_ID',$locID);
		}
		else
		{	
			$criteria->compare('location.Location_Name',$this->Location_ID, true);
			$criteria->with = array('location'=>array('select'=>'location.Location_Name', 'together'=>true));
		}
			
		
		$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('Full_Name',$this->Full_Name,true);
		$criteria->compare('Complete_Name',$this->Complete_Name,true);
		$criteria->compare('NIC',$this->NIC,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('Mobile',$this->Mobile,true);
		$criteria->compare('Private_Address',$this->Private_Address,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination'=>array('pageSize'=>30,)/*,'sort'=>array('defaultOrder'=>'t.Location_ID ASC')*/,
		));
	}
	
	public function getDriver($vehicleId)
	{
		//$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$query = "SELECT D.Driver_ID, D.Full_Name FROM ma_driver D INNER JOIN ma_vehicle_registry V 
		ON D.Driver_ID = V.Driver_ID WHERE V.Vehicle_No = '".$vehicleId."'";
	
		$rawData = Yii::app()->db->createCommand($query)->queryAll();
		
		return $rawData;
	}
	
	public function getAccidentDriver($vehicleId)
	{
		//$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$query = "SELECT D.Driver_ID, D.Full_Name FROM ma_driver D LEFT JOIN accident A
		ON D.Driver_ID = A.Driver_ID WHERE A.Vehicle_No = '".$vehicleId."'";
	
		$rawData = Yii::app()->db->createCommand($query)->queryAll();
		
		return $rawData;
	}
	
	public function getLocationDriver($locID)
	{
		//$cmd = 'SELECT Driver_ID, Full_Name FROM ma_driver WHERE Location_ID ='.$locID.' and Status ="Active"';
		$cmd = 'SELECT Driver_ID, Full_Name FROM ma_driver WHERE Location_ID ='.$locID;
		
		
		/*$cmd = 'SELECT d.Driver_ID, d.Full_Name FROM ma_driver d
		INNER JOIN vehicle_driver vl ON vl.Driver_ID = d.Driver_ID WHERE vl.Location_ID ='.$locID;
		$cmd = 'select d.Driver_ID, d.Full_Name from ma_driver d
where not exists (select driver_ID from vehicle_driver vd where vd.Driver_ID = d.Driver_ID) and d.Status = "Active" and  d.Location_ID = '.$locID;*/
		$data = Yii::app()->db->createCommand($cmd)->queryAll();
		return $data;
	}
	
	
	
	public function getDriverNames()
	{
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		$currentUsrLoc = (Yii::app()->getModule('user')->user()->Location_ID);
		
		if ($superuserstatus != 1)
		{
			$cmd = 'select d.Driver_ID, d.Full_Name from ma_driver d inner join vehicle_driver vd on vd.Driver_ID = d.Driver_ID where d.Location_ID ='.$currentUsrLoc;
		}
		else
		{
			$cmd = 'select d.Driver_ID, d.Full_Name, l.Location_Name from ma_driver d inner join ma_location l on d.Location_ID = l.Location_ID';
		}
		$row = Yii::app()->db->createCommand($cmd)->queryAll();
		return $row;
	}
	
	public function findAllDrivers()
	{
		
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		$currentUsrLoc = (Yii::app()->getModule('user')->user()->Location_ID);
		
		if ($superuserstatus != 1)
		{
			$cmd = 'select d.Driver_ID, d.Full_Name from ma_driver d inner join vehicle_driver vd on vd.Driver_ID = d.Driver_ID where d.Location_ID ="'.$currentUsrLoc.'"  ORDER BY Full_Name ASC';
		}
		else
		{
			$cmd = 'select d.Driver_ID, d.Full_Name, l.Location_Name from ma_driver d inner join ma_location l on d.Location_ID = l.Location_ID  ORDER BY Full_Name ASC';
		}
		
		$data = Yii::app()->db->createCommand($cmd)->queryAll();
		return $data;
	}
	
	public function getDrivers($locId)
	{
		//$fdt = new DateTime($from);
		//$from = $fdt->format("Y-m-d");
		
		$qry ='SELECT distinct d.Driver_ID, d.Full_Name FROM `ma_driver` d Left JOIN vehicle_driver vd ON vd.Driver_ID = d.Driver_ID WHERE d.Location_ID = '.$locId.' and not EXISTS (select NULL from vehicle_booking vb where vb.Booking_Status = "approved") ORDER BY Full_Name ASC';
		/*$qry ='SELECT distinct d.Driver_ID, d.Full_Name FROM `ma_driver` d Left JOIN vehicle_driver vd ON vd.Driver_ID = d.Driver_ID WHERE d.Location_ID = '.$locId.' and not EXISTS (select NULL from vehicle_booking vb where  ("'.$from.'" between date(vb.From) and date(vb.To)) and vb.Driver_ID = d.Driver_ID and vb.Booking_Status = "approved") ORDER BY Full_Name ASC';*/
		
		#$qry = 'SELECT Driver_ID, Full_Name FROM ma_driver WHERE Location_ID ="'.$locId.'" ORDER BY Full_Name ASC ';
		$data = Yii::app()->db->createCommand($qry)->queryAll();
		return $data;
	}
	
	public function getDriverNamesInLocation($vNo)
	{
		$data = Yii::app()->db->createCommand('SELECT Current_Location_ID FROM vehicle_location Where Vehicle_No ="'.$vNo.'"')->queryAll();
		if(!empty($data))
		{
			$locId = $data[0]['Current_Location_ID'];
		}
		else
		{
			$locId ='';
		}
		
		$rowData = Yii::app()->db->createCommand('SELECT Driver_ID, Full_Name FROM ma_driver WHERE Location_ID = "'.$locId.'" ORDER BY Full_Name ASC')->queryAll();
		return $rowData;
	}
	
	public function removeImage($dID)
	{
		$this->updateByPk($dID, array('Driver_Image'=>'1111-'));
	}
        
        public function getLastInsertedDriver($driverID)
        {
            $cri = new CDbCriteria();
            $cri->select="Driver_ID, Full_Name";
            $cri->condition="Driver_ID = $driverID";
            $array = $this->findAll($cri);
            return $array;
        }
	
	
}