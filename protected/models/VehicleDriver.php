<?php

/**
 * This is the model class for table "vehicle_driver".
 *
 * The followings are the available columns in table 'vehicle_driver':
 * @property integer $Driver_Allocation_ID
 * @property string $Vehicle_No
 * @property integer $Location_ID
 * @property integer $Driver_ID
 * @property string $From_Date
 * @property string $To_Date
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property integer $edit_date
 *
 * The followings are the available model relations:
 * @property MaDriver $driver
 * @property VehicleLocation $vehicleNo
 * @property VehicleLocation $location
 */
class VehicleDriver extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VehicleDriver the static model class
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
		return 'vehicle_driver';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Vehicle_No, Location_ID, Driver_ID, From_Date, add_by, add_date, edit_by, edit_date', 'required'),
			array('Location_ID, Driver_ID', 'numerical', 'integerOnly'=>true),
			array('Vehicle_No', 'length', 'max'=>20),
			array('add_by, edit_by, edit_date', 'length', 'max'=>50),
			array('To_Date, driver.Full_Name, location.Location_Name', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Driver_Allocation_ID, Vehicle_No, Location_ID, location.Location_Name, Driver_ID, driver.Full_Name, From_Date, To_Date, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'driver' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
			//'vehicleNo' => array(self::BELONGS_TO, 'MaLocation', 'Vehicle_No'),
			'location' => array(self::BELONGS_TO, 'MaLocation', 'Location_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Driver_Allocation_ID' => 'Vehicle Location',
			'Vehicle_No' => 'Vehicle No',
			'Location_ID' => 'Location',
			'Driver_ID' => 'Driver',
			'From_Date' => 'From Date',
			'To_Date' => 'To Date',
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
		$LocId = (Yii::app()->getModule('user')->user()->Location_ID);
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

		if ($superuserstatus != 1)$criteria->compare('Location_ID',$LocId);
		$criteria->compare('Driver_Allocation_ID',$this->Driver_Allocation_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		
		$criteria->compare('driver.Full_Name',$this->Driver_ID, true);
		//$criteria->with = array('driver'=>array('select'=>'driver.Full_Name','together'=>true));

		$criteria->compare('location.Location_Name',$this->Location_ID, true);
		$criteria->with = array('location'=>array('select'=>'location.Location_Name','together'=>true), 'driver'=>array('select'=>'driver.Full_Name','together'=>true));


		#$criteria->compare('Location_ID',$this->Location_ID);
		//$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('From_Date',$this->From_Date,true);
		$criteria->compare('To_Date',$this->To_Date,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.Location_ID ASC'),
		));
	}
	
	public function driverAssignedVehicles()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$LocId = (Yii::app()->getModule('user')->user()->Location_ID);
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

		if ($superuserstatus != 1)$criteria->compare('location.Location_ID',$LocId);
		$criteria->compare('Driver_Allocation_ID',$this->Driver_Allocation_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		
		$criteria->compare('driver.Full_Name',$this->Driver_ID, true);
		//$criteria->with = array('driver'=>array('select'=>'driver.Full_Name','together'=>true));

		$criteria->compare('location.Location_Name',$this->Location_ID, true);
		$criteria->with = array('location'=>array('select'=>'location.Location_Name','together'=>true), 'driver'=>array('select'=>'driver.Full_Name','together'=>true));


		#$criteria->compare('Location_ID',$this->Location_ID);
		//$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('From_Date',$this->From_Date,true);
		$criteria->compare('To_Date',$this->To_Date,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'driver.Full_Name ASC'),
			'pagination'=>array('pageSize'=>20),
		));
	}
	
	
	public function AssignedDriverHistory($vNo)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$LocId = (Yii::app()->getModule('user')->user()->Location_ID);
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		//$vNo = Yii::app()->request->getQuery('vNo');
		/*if ($superuserstatus != 1)$criteria->compare('location.Location_ID',$LocId);
		$criteria->compare('Driver_Allocation_ID',$this->Driver_Allocation_ID);*/
		$criteria->compare('Vehicle_No',$vNo,true);
		
		//$criteria->compare('driver.Full_Name',$this->Driver_ID, true);
		//$criteria->with = array('driver'=>array('select'=>'driver.Full_Name','together'=>true));

	/*	$criteria->compare('location.Location_Name',$this->Location_ID, true);
		$criteria->with = array('location'=>array('select'=>'location.Location_Name','together'=>true), 'driver'=>array('select'=>'driver.Full_Name','together'=>true));
*/

		#$criteria->compare('Location_ID',$this->Location_ID);
		//$criteria->compare('Driver_ID',$this->Driver_ID);
		/*$criteria->compare('From_Date',$this->From_Date,true);
		$criteria->compare('To_Date',$this->To_Date,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date);
*/
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.Vehicle_No ASC'),
		));
	}
	
	
	public function getDriverNames($vNo)
	{
            $currentUsrLoc = (Yii::app()->getModule('user')->user()->Location_ID);
            #$vNo = $model-> Vehicle_No;

            $cmd = 'select d.Full_Name from ma_driver d inner join vehicle_driver vd on vd.Driver_ID = d.Driver_ID where d.Location_ID ='.$currentUsrLoc.' and vd.Vehicle_No="'.$vNo.'"';
            $row = Yii::app()->db->createCommand($cmd)->queryAll();
            return $row;
	}
        
        public function getDefaultDriver($vNo) 
        {
            $data = Yii::app()->db->createCommand("SELECT vd.Driver_ID, d.Full_Name
            FROM vehicle_driver vd
            INNER JOIN ma_driver d ON d.Driver_ID = vd.Driver_ID
            INNER JOIN vehicle_location vl ON vl.Current_Location_ID = vd.Location_ID
            WHERE vd.Vehicle_No = '$vNo'
            AND (
            vd.Driver_Allocation_ID =(
            SELECT max( vd.Driver_Allocation_ID ) from vehicle_driver vd where vd.Vehicle_No = '$vNo')
            )")->queryAll();
            
            $slctDriver ='';
            if(!empty($data))
            {
                $slctDriver = $data[0]['Driver_ID'];
            }
            
            return $slctDriver;
            
        }
}