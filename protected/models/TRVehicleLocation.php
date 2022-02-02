<?php

/**
 * This is the model class for table "vehicle_location".
 *
 * The followings are the available columns in table 'vehicle_location':
 * @property integer $Vehicle_Location_ID
 * @property integer $Location_ID
 * @property string $Vehicle_No
 * @property string $From_Date
 * @property string $To_Date
 * @property integer $Driver_ID
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaLocation $location
 * @property MaDriver $driver
 */
class TRVehicleLocation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRVehicleLocation the static model class
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
		return 'vehicle_location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            return array(
                array('Location_ID, Vehicle_No, From_Date', 'required'),
                array('Location_ID, Driver_ID, Current_Location_ID', 'numerical', 'integerOnly'=>true),
                array('Vehicle_No', 'length', 'max'=>20),
                array('add_by, edit_by', 'length', 'max'=>50),
                array('add_date, edit_date,Location_Name, Location_ID,Branch_Id, Current_Location_ID, To_Date,Vehicle_No', 'safe'),
               
                array('To_Date','checkToDate'),
                array('Vehicle_Location_ID, Location_ID, location.Location_Name, locations.Location_Name, Current_Location_ID,Branch_Id, Vehicle_No, From_Date, To_Date, Driver_ID, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
            );
	}
        
        public function checkToDate() 
        {
            $frmDate = $this->From_Date;
            $toDate = $this->To_Date;
            
            if($toDate !== '' && $toDate !== '0000-00-00' && $toDate < $frmDate)
            {
                $this->addError('To_Date', "'To Date' should be greater than 'From Date'");
                return false;
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
                'location' => array(self::BELONGS_TO, 'MaLocation', 'Location_ID'),
                'locations' => array(self::BELONGS_TO, 'MaLocation', 'Current_Location_ID'),
                //'driver' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
                'vehicleRegistry' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
                 'branch' => array(self::BELONGS_TO, 'MaBranch', 'Branch_Id')
            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'Vehicle_Location_ID' => 'Vehicle Location',
                'Location_ID' => 'Location',
                'Current_Location_ID' => 'Current Location', 
                'Vehicle_No' => 'Vehicle No',
                'From_Date' => 'From Date',
                'To_Date' => 'To Date',
                'Driver_ID' => 'Driver',
                'add_by' => 'Add By',
                'add_date' => 'Add Date',
                'edit_by' => 'Edit By',
                'edit_date' => 'Edit Date',
                'Branch_Id'=> 'Branch',
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
            #$loc = $model->Location_ID;

            $criteria=new CDbCriteria;
            $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
            $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
            #if ($superuserstatus != 1)$criteria->compare('Location_ID',$LocId);

            $criteria->compare('location.Location_Name',$this->Location_ID, true);
            $criteria->with = array('location'=>array('select'=>'location.Location_Name','together'=>true));

            /*$criteria->compare('locations.Location_Name',$this->Current_Location_ID, true);
            $criteria->with = array('locations'=>array('select'=>'locations.Location_Name','together'=>true));
*/
            $criteria->compare('Vehicle_Location_ID',$this->Vehicle_Location_ID);
            $criteria->compare('Branch_Id',$this->Branch_Id);
            #$criteria->compare('Location_ID',$this->Location_ID);

            $criteria->compare('From_Date',$this->From_Date,true);
            $criteria->compare('To_Date',$this->To_Date,true);
            $criteria->compare('Driver_ID',$this->Driver_ID);
            $criteria->compare('add_by',$this->add_by,true);
            $criteria->compare('add_date',$this->add_date,true);
            $criteria->compare('edit_by',$this->edit_by,true);
            $criteria->compare('edit_date',$this->edit_date,true);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>array('pageSize'=>20),
                #'sort'=>array('defaultOrder'=>'location.Location_ID ASC'),
            ));
	}
	
	


        public function transferVehicle()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

            if ($superuserstatus != 1)$criteria->compare('Current_Location_ID',$LocId, true);

            $criteria->compare('locations.Location_Name',$this->Current_Location_ID, true);
            $criteria->with = array('locations'=>array('select'=>'locations.Location_Name','together'=>true));


            #$criteria->compare('Vehicle_Location_ID',$this->Vehicle_Location_ID);
            #$criteria->compare('Location_ID',$this->Location_ID);
            #$criteria->compare('Current_Location_ID',$this->Current_Location_ID,true);
            $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
            $criteria->compare('From_Date',$this->From_Date,true);
            $criteria->compare('To_Date',$this->To_Date,true);
            $criteria->compare('Driver_ID',$this->Driver_ID);
            $criteria->compare('add_by',$this->add_by,true);
            $criteria->compare('add_date',$this->add_date,true);
            $criteria->compare('edit_by',$this->edit_by,true);
            $criteria->compare('edit_date',$this->edit_date,true);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>array('pageSize'=>20),
                'sort'=>array('defaultOrder'=>'locations.Location_Name ASC'),
            ));
	}
	

	
	public function search1()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		
            if ($superuserstatus != 1)$criteria->compare('Location_ID',$LocId);
		
            #$criteria->compare('vehicleRegistry.Vehicle_Category_ID');
            #$criteria->with = array('vehicleRegistry'=>array('select'=>'vehicleRegistry.Vehicle_Category_ID','together'=>true));

            $criteria->compare('locations.Location_Name',$this->Current_Location_ID, true);
            $criteria->with = array('locations'=>array('select'=>'locations.Location_Name','together'=>true));

            $criteria->compare('Vehicle_Location_ID',$this->Vehicle_Location_ID);
            #$criteria->compare('Location_ID',$this->Location_ID);
            $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
            $criteria->compare('From_Date',$this->From_Date,true);
            $criteria->compare('To_Date',$this->To_Date,true);
            $criteria->compare('Driver_ID',$this->Driver_ID);
            $criteria->compare('add_by',$this->add_by,true);
            $criteria->compare('add_date',$this->add_date,true);
            $criteria->compare('edit_by',$this->edit_by,true);
            $criteria->compare('edit_date',$this->edit_date,true);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>array('pageSize'=>20),
                'sort'=>array('defaultOrder'=>'locations.Location_Name ASC'),

            ));
	}
	
	public function getAssignedVehiclesLocationwise()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$LocId = (Yii::app()->getModule('user')->user()->Location_ID);
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		
		if ($superuserstatus != 1)$criteria->compare('Current_Location_ID',$LocId, true);
		
		$criteria->compare('locations.Location_Name',$this->Current_Location_ID, true);
		$criteria->with = array('locations'=>array('select'=>'locations.Location_Name','together'=>true));
		
		
		/*$this->getDbCriteria()->mergeWith( array(
    'alias' => 'vehicle_location',
    'join' => 'LEFT JOIN vehicle_driver ON  vehicle_location.Vehicle_No=vehicle_driver.Vehicle_No LEFT JOIN vehicle_transfer
	ON vehicle_location.Vehicle_No=vehicle_transfer.Vehicle_No',
    'condition' => 'vehicle_driver.Vehicle_No IS NULL',
) );*/

		/*$this->getDbCriteria()->mergeWith( array(
			'alias' => 'vehicle_location',
			'join' => 'LEFT JOIN vehicle_driver ON vehicle_location.Vehicle_No=vehicle_driver.Vehicle_No',
			//'condition' => 'vehicle_driver.Driver_ID IS NULL', and vehicle_location.Location_ID <> vehicle_location.Current_Location_ID
		) );
*/




		#$criteria->compare('Vehicle_Location_ID',$this->Vehicle_Location_ID);
		#$criteria->compare('vehicle_location.Location_ID',$this->Location_ID,true);
		
		#$criteria->compare('location.Location_Name',$this->Location_ID, true);
		#$criteria->with = array('location'=>array('select'=>'location.Location_Name','together'=>true));
		
		
		$criteria->compare('t.Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('From_Date',$this->From_Date,true);
		$criteria->compare('To_Date',$this->To_Date,true);
		$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>20),
			'sort'=>array('defaultOrder'=>'t.Current_Location_ID ASC'),
			
		));
	}
	
	public function getDriverAssignedVehiclesLocationwise()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$LocId = (Yii::app()->getModule('user')->user()->Location_ID);
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		
		if ($superuserstatus != 1)$criteria->compare('Current_Location_ID',$LocId, true);
		
		$criteria->compare('locations.Location_Name',$this->Current_Location_ID, true);
		$criteria->with = array('locations'=>array('select'=>'locations.Location_Name','together'=>true));
		
		$criteria->compare('vehicle_location.Vehicle_No',$this->Vehicle_No,true);
		$this->getDbCriteria()->mergeWith( array(
    'alias' => 'vehicle_location',
    'join' => 'LEFT JOIN vehicle_driver ON  vehicle_location.Vehicle_No=vehicle_driver.Vehicle_No',
    'condition' => 'vehicle_driver.Vehicle_No IS NOT NULL',
) );/**/

		/*$this->getDbCriteria()->mergeWith( array(
			'alias' => 'vehicle_location',
			'join' => 'LEFT JOIN vehicle_driver ON vehicle_location.Vehicle_No=vehicle_driver.Vehicle_No',
			//'condition' => 'vehicle_driver.Driver_ID IS NULL', and vehicle_location.Location_ID <> vehicle_location.Current_Location_ID
		) );
*/




		#$criteria->compare('Vehicle_Location_ID',$this->Vehicle_Location_ID);
		#$criteria->compare('vehicle_location.Location_ID',$this->Location_ID,true);
		
		#$criteria->compare('location.Location_Name',$this->Location_ID, true);
		#$criteria->with = array('location'=>array('select'=>'location.Location_Name','together'=>true));
		
		
		//$criteria->compare('vehicle_location.Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('From_Date',$this->From_Date,true);
		$criteria->compare('To_Date',$this->To_Date,true);
		$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>20),
			'sort'=>array('defaultOrder'=>'locations.Location_Name ASC'),
			
		));
	}
	
	
	public function searchVehicles()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$LocId = (Yii::app()->getModule('user')->user()->Location_ID);
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		
		if ($superuserstatus != 1)$criteria->compare('t.Current_Location_ID',$LocId);
		
		$criteria->compare('location.Location_Name',$this->Location_ID, true);
		$criteria->with = array('location'=>array('select'=>'location.Location_Name','together'=>true));
		
		
		//$criteria->compare('Current_Location_ID',$this->Vehicle_Location_ID);
	//	$criteria->compare('t.Location_ID',$this->Location_ID, true);
		//$criteria->compare('t.Current_Location_ID',$this->Current_Location_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No, true);
                                 $criteria->compare('Branch_Id',$this->Branch_Id, true);
                                


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>20),
			'sort'=>array('defaultOrder'=>'location.Location_Name ASC'),
			
		));
	}


	
	public function getNotAssignedVehiclesLocationwise()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$LocId = (Yii::app()->getModule('user')->user()->Location_ID);
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		
		if ($superuserstatus != 1)$criteria->compare('Current_Location_ID',$LocId, true);
		
		$criteria->compare('locations.Location_Name',$this->Current_Location_ID, true);
		$criteria->with = array('locations'=>array('select'=>'locations.Location_Name','together'=>true));
		
		
		/*$this->getDbCriteria()->mergeWith( array(
    'alias' => 'vehicle_location',
    'join' => 'LEFT JOIN vehicle_driver ON  vehicle_location.Vehicle_No=vehicle_driver.Vehicle_No LEFT JOIN vehicle_transfer
	ON vehicle_location.Vehicle_No=vehicle_transfer.Vehicle_No',
   # 'condition' => 'vehicle_driver.Vehicle_No IS NULL and vehicle_location.Driver_ID != NULL',
	'condition' => 'vehicle_location.Driver_ID = NULL',
) );*/

		/*$this->getDbCriteria()->mergeWith( array(
			'alias' => 'vehicle_location',
			'join' => 'LEFT JOIN vehicle_driver ON vehicle_location.Vehicle_No=vehicle_driver.Vehicle_No',
			//'condition' => 'vehicle_driver.Driver_ID IS NULL', and vehicle_location.Location_ID <> vehicle_location.Current_Location_ID
		) );
*/


$criteria->addCondition('Driver_ID IS NULL');

		#$criteria->compare('Vehicle_Location_ID',$this->Vehicle_Location_ID);
		#$criteria->compare('vehicle_location.Location_ID',$this->Location_ID,true);
		
		#$criteria->compare('location.Location_Name',$this->Location_ID, true);
		#$criteria->with = array('location'=>array('select'=>'location.Location_Name','together'=>true));
		
		
		$criteria->compare('t.Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('From_Date',$this->From_Date,true);
		$criteria->compare('To_Date',$this->To_Date,true);
		$criteria->compare('Driver_ID','');
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>20),
			'sort'=>array('defaultOrder'=>'locations.Location_Name ASC'),
			
		));
	}
	
	
	public function getLocationHistory()
	{
		$vNo = Yii::app()->request->getQuery('id');
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$LocId = (Yii::app()->getModule('user')->user()->Location_ID);
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		
		$criteria->compare('vehicle_transfer.Vehicle_No',$vNo,true);
		
		#if ($superuserstatus != 1)$criteria->compare('Current_Location_ID',$LocId, true);
		
		/*$criteria->compare('vehicle_transfer.From_location_ID', true);
		$criteria->with = array('locations'=>array('select'=>'locations.Location_Name','together'=>true));*/
		
		$criteria->compare('vehicle_location.Current_Location_ID',$this->Current_Location_ID, true);
		$criteria->with = array('locations'=>array('select'=>'locations.Location_Name','together'=>true));
		
		
		$this->getDbCriteria()->mergeWith( array(
    'alias' => 'vehicle_location',
    'join' => 'LEFT JOIN vehicle_transfer
	ON vehicle_location.Vehicle_No=vehicle_transfer.Vehicle_No',
    
) );/**/

		/*$this->getDbCriteria()->mergeWith( array(
			'alias' => 'vehicle_location',
			'join' => 'LEFT JOIN vehicle_driver ON vehicle_location.Vehicle_No=vehicle_driver.Vehicle_No',
			//'condition' => 'vehicle_driver.Driver_ID IS NULL', and vehicle_location.Location_ID <> vehicle_location.Current_Location_ID
		) );
*/




		#$criteria->compare('Vehicle_Location_ID',$this->Vehicle_Location_ID);
		#$criteria->compare('vehicle_location.Location_ID',$this->Location_ID,true);
		
		#$criteria->compare('location.Location_Name',$this->Location_ID, true);
		#$criteria->with = array('location'=>array('select'=>'location.Location_Name','together'=>true));
		
		
		


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>20),
			'sort'=>array('defaultOrder'=>'vehicle_location.Current_Location_ID ASC'),
			
		));
	}
	
	
	public function getLocationAssignedVehicles()
	{
		$cmd = 'SELECT Vehicle_No FROM vehicle_location vl WHERE NOT EXISTS (SELECT Vehicle_No FROM vehicle_driver vd WHERE vd.Vehicle_No = vl.Vehicle_No)';
		$rowData = Yii::app()->db->createCommand($cmd)->queryAll();
		return $rowData;
	}
	
	public function findVehiclesInLocation($loc)
	{
		$data = Yii::app()->db->createCommand('SELECT Vehicle_No FROM vehicle_location where Current_Location_ID ='.$loc)->queryAll();
		return $data;
	}
	
	public function findAllCurLocations()
	{
		$data = Yii::app()->db->createCommand('select vl.Current_Location_ID ,l.Location_Name from vehicle_location vl inner join ma_location l on l.Location_ID = vl.Current_Location_ID')->queryAll();
		return $data;
	}
        
}