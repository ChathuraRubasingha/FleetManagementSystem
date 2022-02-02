<?php

/*
 * This is the model class for table "emission_test".
 *
 * The followings are the available columns in table 'emission_test':
 * @property integer $Emission_test_ID
 * @property string $Vehicle_No
 * @property integer $Emission_Test_Company_ID
 * @property string $Emission_Test_Date
 * @property string $Valid_From
 * @property string $Valid_To
 * @property string $Emission_Test_Result
 * @property string $Amount
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaVehicleRegistry $vehicleNo
 * @property MaEmissionTestCompany $emissionTestCompany
 * @property License[] $licenses
 */
class TREmissionTest extends CActiveRecord
{
	public $Remaining_Days;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return TREmissionTest the static model class
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
		return 'emission_test';
	}

	/*
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Vehicle_No, Emission_Test_Company_ID, Emission_Test_Date, Valid_From, Valid_To, Emission_Test_Result, Amount', 'required'),
			array('Emission_Test_Company_ID', 'numerical', 'integerOnly'=>true),
			array('Vehicle_No', 'length', 'max'=>20),
			array('Emission_Test_Result, Amount', 'length', 'max'=>50),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			
			array('Amount', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Emission_test_ID, Vehicle_No, Emission_Test_Company_ID, Emission_Test_Date, Valid_From, Valid_To, Emission_Test_Result, Amount, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
		);
	}

	/*
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
			'emissionTestCompany' => array(self::BELONGS_TO, 'MaEmissionTestCompany', 'Emission_Test_Company_ID'),
			'licenses' => array(self::HAS_MANY, 'License', 'Emission_test_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Emission_test_ID' => 'Emission Test',
			'Vehicle_No' => 'Vehicle No',
			'Emission_Test_Company_ID' => 'Emission Test Company',
			'Emission_Test_Date' => 'Emission Test Date',
			'Valid_From' => 'Valid From',
			'Valid_To' => 'Valid To',
			'Emission_Test_Result' => 'Emission Test Result',
			'Amount' => 'Amount (Rs.)',
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

		$criteria->compare('Emission_test_ID',$this->Emission_test_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('Emission_Test_Company_ID',$this->Emission_Test_Company_ID);
		$criteria->compare('Emission_Test_Date',$this->Emission_Test_Date,true);
		$criteria->compare('Valid_From',$this->Valid_From,true);
		$criteria->compare('Valid_To',$this->Valid_To,true);
		$criteria->compare('Emission_Test_Result',$this->Emission_Test_Result,true);
		$criteria->compare('Amount',$this->Amount,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));



	}

    public function emmissionTest()
    {
        $locID = Yii::app()->getModule('user')->user()->Location_ID;
        $superUser = Yii::app()->getModule('user')->user()->superuser;

        $criteria=new CDbCriteria();
                         //$criteria->alias='days';
        if ($superUser != 1)
        {
            $criteria->select = 't.Emission_test_ID, t.Vehicle_No, t.Valid_To,DATEDIFF(Valid_To,now()) AS Remaining_Days';
            $criteria->join = 'inner join vehicle_location vl On vl.Vehicle_No = t.Vehicle_No';
            //$criteria->select ='DATEDIFF(now(),Valid_To) AS days');
            $criteria->condition = 'now() between DATE_SUB(t.Valid_To,INTERVAL 30 DAY) and  t.Valid_To and vl.Current_Location_ID ='.$locID;
        }
        else
        {
            $criteria->select = 't.Emission_test_ID, t.Vehicle_No, t.Valid_To,DATEDIFF(Valid_To,now()) AS Remaining_Days';
            $criteria->condition = 'now() between DATE_SUB(t.Valid_To,INTERVAL 30 DAY) and  t.Valid_To';
        }
        $criteria->order = 't.Valid_To asc';
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>30),
        ));	
    }
	
	
	
	public function getEmissionTestHistory()
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
	
	public function getEmissionTestResult()
        {
            $vehicleId = Yii::app()->session['maintenVehicleId'];

            $query = "SELECT Emission_test_ID,Valid_From,Valid_To,Emission_Test_Result FROM emission_test 
            WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1";

            $rawData = Yii::app()->db->createCommand($query)->queryAll();

            return $rawData;
	}
        
        public function DashboardEmissionTest($superuserstatus,$locID) 
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and vl.Current_Location_ID =$locID";
            }
            
            $cri12 = new CDbCriteria();
            $cri12->select="count(Emission_test_ID) as Emission_test_ID";
            $cri12->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
            $cri12->condition="now() between DATE_SUB(t.Valid_To,INTERVAL 30 DAY) and  t.Valid_To".$condition;
            $array12 = $this->findAll($cri12);

            $countPendingEmmission = 0;
            if (count($array12) > 0)
            {
                $countPendingEmmission = $array12[0]['Emission_test_ID'];
            }
            
            return $countPendingEmmission;
        }
}


