<?php

/**
 * This is the model class for table "license".
 *
 * The followings are the available columns in table 'license':
 * @property integer $License_ID
 * @property string $Vehicle_No
 * @property string $Amount
 * @property string $Date_of_License
 * @property string $Valid_From
 * @property string $Valid_To
 * @property integer $Emission_test_ID
 * @property integer $Fitness_ID
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaVehicleRegistry $vehicleNo
 * @property EmissionTest $emissionTest
 * @property FitnessTest $fitness
 */
class TRLicense extends CActiveRecord
{
	public $Remaining_Days;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRLicense the static model class
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
		return 'license';
	}

	/*
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Vehicle_No, Date_of_License, Valid_From, Valid_To', 'required'),
			array('Emission_test_ID, Fitness_ID', 'numerical', 'integerOnly'=>true),
			array('Vehicle_No', 'length', 'max'=>20),
			array('Amount', 'length', 'max'=>50),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			
            array('Date_of_License','checkDate_of_License'),
            //        array('Valid_From', 'checkValid_From'),
            //        array('Valid_To', 'checkValid_To'),
			array('Amount', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('License_ID, Vehicle_No, Amount, Date_of_License, Valid_From, Valid_To, Emission_test_ID, Fitness_ID, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
		);
	}
        
        public function checkDate_of_License() 
        {
            $date = MaVehicleRegistry::model()->getServerDate("date");
            
            if($date < $this->Date_of_License)
            {
                $this->addError('Date_of_License', "'Date of License' should be a previous date");
            }
        }
        
        public function checkValid_From() 
        {
            $date = MaVehicleRegistry::model()->getServerDate("date");
            
            if($date < $this->Valid_From)
            {
                $this->addError('Valid_From', "'Valid From' should be a previous date");
            }
            if(isset($this->Date_of_License) && $this->Date_of_License !='')
            {
                if($this->Valid_From < $this->Date_of_License)
                {
                    $this->addError('Valid_From', "'Valid From' should be greater than 'Date of License'");
                }
            }
        }
        
        public function checkValid_To() 
        {
            $date = MaVehicleRegistry::model()->getServerDate("date");
            
            
            if(isset($this->Date_of_License) && $this->Date_of_License !='')
            {
                if(isset($this->Valid_From) && $this->Valid_From !='')
                {
                    if($this->Valid_From > $this->Valid_To)
                    {
                        $this->addError('Valid_To', "'Valid To' should be greater than 'Valid From'");
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
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
			'emissionTest' => array(self::BELONGS_TO, 'EmissionTest', 'Emission_test_ID'),
			'fitness' => array(self::BELONGS_TO, 'FitnessTest', 'Fitness_test_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'License_ID' => 'License ID',
			'Vehicle_No' => 'Vehicle No',
			'Amount' => 'Amount(Rs.)',
			'Date_of_License' => 'Date of License',
			'Valid_From' => 'Valid From',
			'Valid_To' => 'Valid To',
			'Emission_test_ID' => 'Emission Test',
			'Fitness_ID' => 'Fitness',
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

		$criteria->compare('License_ID',$this->License_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('Amount',$this->Amount,true);
		$criteria->compare('Date_of_License',$this->Date_of_License,true);
		$criteria->compare('Valid_From',$this->Valid_From,true);
		$criteria->compare('Valid_To',$this->Valid_To,true);
		$criteria->compare('Emission_test_ID',$this->Emission_test_ID);
		$criteria->compare('Fitness_ID',$this->Fitness_ID);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function License()
        {   
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            $criteria=new CDbCriteria();
             //$criteria->alias='days';
            if ($superUser != 1)
            {
                $criteria->select = 't.License_ID, t.Vehicle_No, t.Valid_To,DATEDIFF(Valid_To,now()) AS Remaining_Days';
                $criteria->join = 'inner join vehicle_location vl On vl.Vehicle_No = t.Vehicle_No';
                //$criteria->select ='DATEDIFF(now(),Valid_To) AS days');
                $criteria->condition = 'now() between DATE_SUB(t.Valid_To,INTERVAL 30 DAY) and  t.Valid_To and vl.Current_Location_ID ='.$locID;
            }
            else
            {
                $criteria->select = 't.License_ID, t.Vehicle_No, t.Valid_To,DATEDIFF(Valid_To,now()) AS Remaining_Days';
                //$criteria->select ='DATEDIFF(now(),Valid_To) AS days');
                $criteria->condition = 'now() between DATE_SUB(t.Valid_To,INTERVAL 30 DAY) and  t.Valid_To '; 
            }

             $criteria->order = 'Valid_To asc';
             
             return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,'pagination'=>array('pageSize'=>30),
            ));	
        }	
	
	/*public function getEmissionTestResult($Vehicle_No)
	{
		
		$query = " SELECT Fitness_test FROM ma_vehicle_registry WHERE Vehicle_No = '".$Vehicle_No."'  ";

		$rawData = Yii::app()->db->createCommand($query)->queryAll();
		return $rawData;
	}*/
	
	public function getLicenseHistory()
	{
		$criteria=new CDbCriteria;
		
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria->compare('Vehicle_No',$vehicleId);
		
		return new CActiveDataProvider($this, array(
            	'criteria' => $criteria,
            	'sort'=>array(
                'defaultOrder'=>'Valid_To DESC',
            	),	
		));
	}
	
	public function getEmissionResult($data)
	{
		$sql = Yii::app()->db->createCommand('SELECT Emission_Test_Result FROM emission_test 
		WHERE Vehicle_No = "'.$data.'" ORDER BY Valid_To DESC LIMIT 1')->queryAll();
		
		//$EmissionTst = Yii::app()->db->createCommand('select Emission_test ')->queryAll();
		$result ='';
		if(!empty($sql))
		foreach ($sql as $row)
		{
			$result = $row['Emission_Test_Result'];
		}
		return $result;
	}
	
	public function getFitnessResult($data)
	{
		$sql = Yii::app()->db->createCommand('SELECT Fitness_Test_Result FROM fitness_test 
		WHERE Vehicle_No = "'.$data.'" ORDER BY Valid_To DESC LIMIT 1')->queryAll();
		
		//$EmissionTst = Yii::app()->db->createCommand('select Emission_test ')->queryAll();
		$result ='';
		if(!empty($sql))
		foreach ($sql as $row)
		{
			$result = $row['Fitness_Test_Result'];
		}
		return $result;
	}
        
        public function DashboardLicenseDetails($superuserstatus,$locID) 
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and vl.Current_Location_ID =$locID";
            }
            $cri14 = new CDbCriteria();
            $cri14->select="count(License_ID) as License_ID";
            $cri14->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
            $cri14->condition="now() between DATE_SUB(t.Valid_To,INTERVAL 30 DAY) and  t.Valid_To".$condition;
            $array14 = $this->findAll($cri14);

            $countPendingLicence = 0;
            if (count($array14) > 0)
            {
                $countPendingLicence = $array14[0]['License_ID'];
            }
            
            return $countPendingLicence;
        }
	
}