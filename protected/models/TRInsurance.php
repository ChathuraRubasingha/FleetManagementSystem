<?php

/*
 * This is the model class for table "insurance".
 *
 * The followings are the available columns in table 'insurance':
 * @property integer $Insurance_ID
 * @property string $Vehicle_No
 * @property integer $Insurance_Company_ID
 * @property integer $Insurance_Type_ID
 * @property string $Amount
 * @property string $Date_of_Insurance
 * @property string $Valid_From
 * @property string $Valid_To
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaVehicleRegistry $vehicleNo
 * @property MaInsuranceCompany $insuranceCompany
 * @property MaInsuranceType $insuranceType
 */
class TRInsurance extends CActiveRecord
{
	/*
	 * Returns the static model of the specified AR class.
	 * @return TRInsurance the static model class
	 */
	public $Remaining_Days;
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/*
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'insurance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Vehicle_No, Insurance_Company_ID, Insurance_Type_ID, Amount, Date_of_Insurance, Valid_From, Valid_To', 'required'),
			array('Insurance_Company_ID, Insurance_Type_ID', 'numerical', 'integerOnly'=>true),
			array('Vehicle_No', 'length', 'max'=>20),
			array('Amount, Sum_Insured', 'numerical'),
			//array('Amount', 'length', 'max'=>50),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date,Sum_Insured', 'safe'),
			
			array('Amount, Sum_Insured', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Insurance_ID, Vehicle_No, Insurance_Company_ID, Insurance_Type_ID, Amount, Date_of_Insurance, Valid_From, Valid_To, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
			'insuranceCompany' => array(self::BELONGS_TO, 'MaInsuranceCompany', 'Insurance_Company_ID'),
			'insuranceType' => array(self::BELONGS_TO, 'MaInsuranceType', 'Insurance_Type_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Insurance_ID' => 'Insurance ID',
			'Vehicle_No' => 'Vehicle No',
			'Insurance_Company_ID' => 'Insurance Company',
			'Insurance_Type_ID' => 'Insurance Type',
			'Amount' => 'Amount(Rs.)',
			'Sum_Insured'=>'Sum Insured(Rs.)',
			'Date_of_Insurance' => 'Date Of Insurance',
			'Valid_From' => 'Valid From',
			'Valid_To' => 'Valid To',
			'add_by' => 'Add By',
			'add_date' => 'Add Date',
			'edit_by' => 'Edit By',
			'edit_date' => 'Edit Date',
			'Remaining_Days' => 'Remaining Days',
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

		$criteria->compare('Insurance_ID',$this->Insurance_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('Insurance_Company_ID',$this->Insurance_Company_ID);
		$criteria->compare('Insurance_Type_ID',$this->Insurance_Type_ID);
		$criteria->compare('Amount',$this->Amount,true);
		$criteria->compare('Date_of_Insurance',$this->Date_of_Insurance,true);
		$criteria->compare('Valid_From',$this->Valid_From,true);
		$criteria->compare('Valid_To',$this->Valid_To,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function insurance()
     {
		  $superUser = Yii::app()->getModule('user')->user()->superuser;
		 $locID = Yii::app()->getModule('user')->user()->Location_ID;
              
			 $criteria=new CDbCriteria();
			 if($superUser != 1)
			 {
				 $criteria->select = 't.Insurance_ID, t.Vehicle_No, vl.Location_ID, t.Valid_To, DATEDIFF(t.Valid_To,now()) AS Remaining_Days';
				 $criteria->join = 'inner join vehicle_location vl On vl.Vehicle_No = t.Vehicle_No';
				 $appDate = date("Y-m-d : H:i:s", time());
				 $criteria->condition = 'now() between DATE_SUB(Valid_To, INTERVAL 30 DAY) and  Valid_To and vl.Current_Location_ID ='.$locID;
				 $criteria->order = 't.Valid_To asc';
			 }
			 else
			 {
				 $criteria->select = 't.Insurance_ID, t.Vehicle_No, t.Valid_To, DATEDIFF(t.Valid_To,now()) AS Remaining_Days';
				 $criteria->condition = 'now() between DATE_SUB(Valid_To, INTERVAL 30 DAY) and  Valid_To ';
				 $criteria->order = 't.Valid_To asc';
			 }
		    return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,'pagination'=>array('pageSize'=>30),
            ));	
			
	
	}
	
	public function getInsuranceTestHistory()
	{
		$criteria = new CDbCriteria;
		
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria->compare('Vehicle_No',$vehicleId);
		
		return new CActiveDataProvider($this, array(
            	'criteria' => $criteria,
            	'sort'=>array(
                'defaultOrder'=>'Valid_To DESC',
            	),	
		));
	}
        
        public function DashboardInsuranceDetails($superuserstatus,$locID)
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and vl.Current_Location_ID =$locID";
            }
            
            $cri11 = new CDbCriteria();
            $cri11->select="count(Insurance_ID) as Insurance_ID";
            $cri11->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
            $cri11->condition="now() between DATE_SUB(t.Valid_To, INTERVAL 30 DAY) and  t.Valid_To ".$condition;
            $Array11 = $this->findAll($cri11);

            $countInsurance = 0;
            if (count($Array11) > 0)
            {
                $countInsurance = $Array11[0]['Insurance_ID'];
            }
            
            return $countInsurance;
        }
}