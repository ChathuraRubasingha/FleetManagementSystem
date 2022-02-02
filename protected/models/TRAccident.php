<?php

/**
 * This is the model class for table "accident".
 *
 * The followings are the available columns in table 'accident':
 * @property integer $Accident_ID
 * @property string $Vehicle_No
 * @property string $Accident_Place
 * @property string $Date_and_Time
 * @property string $Details
 * @property string $Police_Station
 * @property string $Address
 * @property integer $Driver_ID
 * @property string $Police_Report_No
 * @property string $Accident_Type
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaDriver $driver
 * @property MaVehicleRegistry $vehicleNo
 * @property EstimateDetails[] $estimateDetails
 */
 
class TRAccident extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRAccident the static model class
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
		return 'accident';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Vehicle_No, Accident_Place, Date_and_Time, Police_Station, Address, Driver_ID, Police_Report_No', 'required'),
			array('Driver_ID', 'numerical', 'integerOnly'=>true),
			array('Vehicle_No', 'length', 'max'=>20),
			array('Accident_Place, Address', 'length', 'max'=>200),
			array('Details, image', 'length', 'max'=>250),
			array('image', 'safe'),
			array('Police_Station, Accident_Type', 'length', 'max'=>150),
			array('Police_Report_No, add_by, add_date, edit_by, edit_date', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			
                        array('Odometer_Before_Accident, Odometer_After_Accident', 'match', 'pattern'=>'/^([0-9\.])+$/'),
			array('Police_Report_No', 'match', 'pattern'=>'/^([0-9])+$/'),
			//array('Driver_Rating', 'match', 'pattern'=>'/^(1|-[1-9][0-9]*)$/','message' =>'Driver rating must be a (-) value.'),
			array('Accident_Place, Police_Station','match','pattern'=>'/^([A-Za-z -\/])+$/'),
			array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
			array('Details', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20})+$/'),
                        array('Odometer_After_Accident','checkOdometer'),
                        array('Date_and_Time','checkPrevious'),
                        array('Accident_ID, Vehicle_No, Odometer_Before_Accident, Odometer_After_Accident, Accident_Place, Date_and_Time, Details, Police_Station, Address, Driver_ID, Police_Report_No, Accident_Type, Driver_Rating, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
			array('image', 'file','types'=>'jpg, gif, png', 'maxSize'=>10*1024*1024, 'maxFiles' => 14, 'allowEmpty'=>true, 'on'=>'insert, update'), // this will allow empty field when page is update (remember here i create scenario update

		);
	}

    public function checkPrevious()
    {
        $Date_and_Time =$this->Date_and_Time;
        date_default_timezone_set('Asia/Colombo');
        $serverDate = MaVehicleRegistry::model()->getServerDate("dateTime");

        if($Date_and_Time > $serverDate)
        {
            $this->addError('Date_and_Time',"'Date and Time' should be a Previous Date");
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function checkOdometer() 
    {
        if(isset($this->Odometer_After_Accident) && $this->Odometer_After_Accident !='')
        {
            if(isset($this->Accident_ID))
            {
                $odometerArr = $this->findAll('Accident_ID= :AccID', array(':AccID'=>  $this->Accident_ID));
                if(count($odometerArr)>0)
                {
                    $odometer = $odometerArr[0]['Odometer_Before_Accident'];
                }
                if($odometer !='' && $odometer !='' && $odometer > $this->Odometer_After_Accident)
                {
                    $this->addError('Odometer_After_Accident','Current Odometer should be greater than Previous Odometer of the vehicle');
                }
            }
            else
            {           
                $odometerBeforeAccident = MaVehicleRegistry::model()->getOdometer($this->Vehicle_No);
                if($odometerBeforeAccident !='' && $odometerBeforeAccident !='' && $odometerBeforeAccident> $this->Odometer_After_Accident)
                {
                    $this->addError('Odometer_After_Accident','Current Odometer should be greater than Previous Odometer of the vehicle');
                }

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
			'driver' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
			'estimateDetails' => array(self::HAS_MANY, 'EstimateDetails', 'Accident_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Accident_ID' => 'Accident ID',
			'Vehicle_No' => 'Vehicle No',
                        'Odometer_Before_Accident'=>'Odometer Before Accident', 
                        'Odometer_After_Accident' => 'Current Odometer',
			'Accident_Place' => 'Accident Place',
			'Date_and_Time' => 'Date and Time',
			'Details' => 'Details',
			'Police_Station' => 'Police Station',
			'Address' => 'Address of Police Station',
			'Driver_ID' => 'Driver',
			'Police_Report_No' => 'Police Report No',
			'Accident_Type' => 'Accident Type',
			'Driver_Rating' => 'Driver Rating',
			'image'=>'Select Image',
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
		
		$vehicleId = Yii::app()->session['accidentVehicleId'];
		$criteria->compare('Accident_ID',$this->Accident_ID);
		$criteria->compare('Vehicle_No',$vehicleId);
                $criteria->compare('Odometer_Before_Accident',$this->Odometer_Before_Accident,true);
                $criteria->compare('Odometer_After_Accident',$this->Odometer_After_Accident,true);
		$criteria->compare('Accident_Place',$this->Accident_Place,true);
		$criteria->compare('Date_and_Time',$this->Date_and_Time,true);
		$criteria->compare('Details',$this->Details,true);
		$criteria->compare('Police_Station',$this->Police_Station,true);
		$criteria->compare('Address',$this->Address,true);
		$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('Police_Report_No',$this->Police_Report_No,true);
		$criteria->compare('Accident_Type',$this->Accident_Type,true);
		/*$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);*/

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination'=>array('pageSize'=>30,)
		));
	}
	
	public function getAccidentDetails()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		$criteria=new CDbCriteria;
		$vehicleId = Yii::app()->session['accidentVehicleId'];
		$criteria->compare('t.Vehicle_No',$vehicleId, true);

		$criteria->mergeWith(array('join'=>'LEFT JOIN estimate_details ed ON t.Accident_ID = ed.Accident_ID ','condition' => 'ed.Accident_ID IS NULL',));
		$criteria->compare('Accident_ID',$this->Accident_ID);
		$criteria->compare('Accident_Place',$this->Accident_Place,true);
		$criteria->compare('Date_and_Time',$this->Date_and_Time,true);
		$criteria->compare('Details',$this->Details,true);
		$criteria->compare('Police_Station',$this->Police_Station,true);
		$criteria->compare('Address',$this->Address,true);
		$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('Police_Report_No',$this->Police_Report_No,true);
		$criteria->compare('Accident_Type',$this->Accident_Type,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination'=>array('pageSize'=>30,), 'sort'=>array('defaultOrder'=>'t.Date_and_Time DESC')



		));
	}
	public function getAccidentHistory()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
            $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);


            if ($superuserstatus != 1)
            {
                $criteria=new CDbCriteria;
            }
            else
            {
                $criteria=new CDbCriteria(array('order'=>'l.Location_Name ASC, t.Vehicle_No ASC'));		
            }
		//$criteria->alias = 'i';
		
		

            $driverID = Yii::app()->db->createCommand()
                ->select('Driver_ID')
                ->from('ma_driver d')
                ->where('Location_ID=:Location_ID', array(':Location_ID'=>$LocId))
                ->queryRow();
                    $driverID = $driverID['Driver_ID'];

//if ($superuserstatus != 1)$criteria->compare('Location_ID',$LocId);
//if ($superuserstatus != 1)$criteria->compare('Driver_ID',$driverID);
if ($superuserstatus != 1)
{
	#$criteria->mergeWith(array('join'=>'LEFT JOIN ma_driver d ON d.Driver_ID = t.Driver_ID', 'condition'=>'d.Location_ID ='.$LocId,));
	$criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No', 'condition'=>'vl.Current_Location_ID ='.$LocId,));
	$criteria->compare('vl.Location_ID',$LocId,true);
}
else
{
	$criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No left join ma_location l on l.Location_ID = vl.Current_Location_ID', 'condition'=>'vl.Vehicle_No IS NOT NULL'));
			//$criteria->compare('l.Location_Name',$this->Location_ID,true);
}
		
		//$vehicleId = Yii::app()->session['accidentVehicleId'];
		$criteria->compare('Accident_ID',$this->Accident_ID);
		$criteria->compare('t.Vehicle_No',$this-> Vehicle_No,true);
		$criteria->compare('t.Accident_Place',$this->Accident_Place,true);
		$criteria->compare('Date_and_Time',$this->Date_and_Time,true);
		$criteria->compare('Details',$this->Details,true);
		$criteria->compare('Police_Station',$this->Police_Station,true);
		$criteria->compare('Address',$this->Address,true);
		$criteria->compare('Driver_ID',$this->Driver_ID);
		//
		
		$criteria->compare('Police_Report_No',$this->Police_Report_No,true);
		$criteria->compare('Accident_Type',$this->Accident_Type,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);
		
		
		//$criteria->join= 'JOIN employee d ON (i.reg_no=d.reg_no)';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination'=>array('pageSize'=>30,)
		));
	}
	
	public function getDrivers()
	{		
		$data = "SELECT Driver_ID, Full_Name FROM ma_driver";
		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		return $rawData;
	}
	
	public function get_Current_Driver_Rating($did)
	{	
            $data = "SELECT Rating FROM ma_driver WHERE (Driver_ID ='".$did."')";
            $rawData =Yii::app()->db->createCommand($data)->queryAll();

            return $rawData;
		
	}
	
	public function get_Rating_In_Accident($aid)
	{	
		$data = "SELECT Driver_Rating FROM accident WHERE (Accident_ID ='".$aid."')";
		$rawData =Yii::app()->db->createCommand($data)->queryAll();

		return $rawData;
		
	}
	
	public function getDriverDetails()
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
			
			$data = "select d.Driver_ID, d.Full_Name, l.Location_Name from ma_driver d inner join ma_location l on d.Location_ID = l.Location_ID";
		}
		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		return $rawData;
	}
	
	public function removeImage($accID)
	{
             if(isset(Yii::app()->session['removeAccedentImage']))
            {   
                 unset(Yii::app()->session['removeAccedentImage']);
            }
		$this->updateByPk($accID, array('image'=>'1111-'));
	}
}