<?php

/**
 * This is the model class for table "vehicle_repair_details".
 *
 * The followings are the available columns in table 'vehicle_repair_details':
 * @property integer $Repair_ID
 * @property integer $Estimate_ID
 * @property string $Vehicle_No
 * @property integer $Garage_ID
 * @property string $Repair_Cost
 * @property string $Description_Of_Repair
 * @property string $Repaired_Date
 
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property RepairEstimateDetails $estimate
 * @property MaVehicleRegistry $vehicleNo
 * @property MaGarages $garage
 */
class TRVehicleRepairDetails extends CActiveRecord
{
	/*
	 * Returns the static model of the specified AR class.
	 * @return TRVehicleRepairDetails the static model class
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
		return 'vehicle_repair_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Estimate_ID, Repair_Cost, Repaired_Date', 'required'),
			array('Estimate_ID, Garage_ID', 'numerical', 'integerOnly'=>true),
			array('Vehicle_No', 'length', 'max'=>20),
			array('Repair_Cost', 'length', 'max'=>150),
			array('add_by, edit_by, edit_date', 'length', 'max'=>50),
			array('Description_Of_Repair, add_date', 'safe'),
			
			//array('Description_Of_Repair', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
			//array('Description_Of_Repair', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
            //@ array('Description_Of_Repair', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20})+$/'),

            array('Repair_Cost', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),

            array('Repaired_Date','checkPrevious'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Repair_ID, Estimate_ID, Vehicle_No, Garage_ID, Repair_Cost, Description_Of_Repair, Repaired_Date, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
		);
	}

    public function checkPrevious()
    {
        $Repaired_Date =$this->Repaired_Date;
        date_default_timezone_set('Asia/Colombo');
        $serverDate = MaVehicleRegistry::model()->getServerDate("date");

        if($Repaired_Date > $serverDate)
        {
            $this->addError('Repaired_Date',"'Repaired Date' should be a Previous Date");
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
			'estimate' => array(self::BELONGS_TO, 'RepairEstimateDetails', 'Estimate_ID'),
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
			'garage' => array(self::BELONGS_TO, 'MaGarages', 'Garage_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Repair_ID' => 'Repair Id',
			'Estimate_ID' => 'Estimate Id',
			'Vehicle_No' => 'Vehicle No',
			'Garage_ID' => 'Garage',
			'Repair_Cost' => 'Repair Cost(Rs.)',
			'Description_Of_Repair' => 'Description of Repair',
			'Repaired_Date' => 'Repaired Date',
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
        $vehicleId = Yii::app()->session['maintenVehicleId'];
		$criteria=new CDbCriteria;
        $criteria->compare('Repair_ID',$this->Repair_ID);
		$criteria->compare('Estimate_ID',$this->Estimate_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('Garage_ID',$this->Garage_ID);
		$criteria->compare('Repair_Cost',$this->Repair_Cost,true);
		$criteria->compare('Description_Of_Repair',$this->Description_Of_Repair,true);
		$criteria->compare('Repaired_Date',$this->Repaired_Date,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                'defaultOrder'=>'Repaired_Date DESC',
            	),
			
		));
	}
	
	public function getVehicleRepairDetails()
	{
		 $vehicleId = Yii::app()->session['maintenVehicleId'];
		$criteria=new CDbCriteria;
       /* $criteria->compare('Repair_ID',$this->Repair_ID);
		$criteria->compare('Estimate_ID',$this->Estimate_ID);*/
		$criteria->compare('Vehicle_No',$vehicleId,true);
		#$criteria->compare('Garage_ID',$this->Garage_ID);
		//$criteria->compare('Repair_Cost',$this->Repair_Cost,true);
		//$criteria->compare('Description_Of_Repair',$this->Description_Of_Repair,true);
//		$criteria->compare('Repaired_Date',$this->Repaired_Date,true);
//		$criteria->compare('add_by',$this->add_by,true);
//		$criteria->compare('add_date',$this->add_date,true);
//		$criteria->compare('edit_by',$this->edit_by,true);
//		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/*'sort'=>array(
                'defaultOrder'=>'Repaired_Date DESC',
            	),*/
			
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
	
	public function getGarage($garageId)
	{
		$data = "SELECT Garage_ID,Garage_Name FROM ma_garages WHERE Garage_ID = '".$garageId."'";
		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		return $rawData;
	}
}