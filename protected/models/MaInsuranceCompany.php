<?php

/*
 * This is the model class for table "ma_insurance_company".
 *
 * The followings are the available columns in table 'ma_insurance_company':
 * @property integer $Insurance_Company_ID
 * @property string $Insurance_Company_Name
 * @property string $Address
 * @property string $Land_phone_No
 * @property string $Mobile
 * @property string $Fax
 * @property string $Email
 * @property string $Contact_Person
 * @property string $Registration_No
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 */
class MaInsuranceCompany extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaInsuranceCompany the static model class
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
		return 'ma_insurance_company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Insurance_Company_Name, Address, Registration_No', 'required'),
			array('Insurance_Company_Name, Address', 'length', 'max'=>255),
			array('Land_phone_No, Mobile, Fax', 'length', 'max'=>20),
			array('Email, Contact_Person', 'length', 'max'=>100),
			array('Registration_No', 'length', 'max'=>50),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Insurance_Company_Name,Registration_No,Land_phone_No,Mobile,Fax,Email', 'unique'),
			
			array('Insurance_Company_Name', 'match', 'pattern'=>'/^[a-zA-Z0-9][a-zA-Z0-9\.\-#&\(\s\)]*$/'),
			array('Contact_Person', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			//array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			//array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
			array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
			array('Land_phone_No,Mobile,Fax', 'match', 'pattern'=>'/^([0-9]{10})+$/'),
			array('Email', 'match', 'pattern'=>'/^[-a-zA-Z0-9][-.a-zA-Z0-9]*@[-.a-zA-Z0-9]+(\.[-.a-zA-Z0-9]+)*\./'),
			array('Registration_No', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Insurance_Company_ID, Insurance_Company_Name, Address, Land_phone_No, Mobile, Fax, Email, Contact_Person, Registration_No, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Insurance_Company_ID' => 'Insurance Company ID',
			'Insurance_Company_Name' => 'Insurance Company Name',
			'Address' => 'Address',
			'Land_phone_No' => 'Land Phone No',
			'Mobile' => 'Mobile',
			'Fax' => 'Fax',
			'Email' => 'Email',
			'Contact_Person' => 'Contact Person',
			'Registration_No' => 'Registration No',
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

		$criteria->compare('Insurance_Company_ID',$this->Insurance_Company_ID);
		$criteria->compare('Insurance_Company_Name',$this->Insurance_Company_Name,true);
		$criteria->compare('Address',$this->Address,true);
		$criteria->compare('Land_phone_No',$this->Land_phone_No,true);
		$criteria->compare('Mobile',$this->Mobile,true);
		$criteria->compare('Fax',$this->Fax,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('Contact_Person',$this->Contact_Person,true);
		$criteria->compare('Registration_No',$this->Registration_No,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>array('defaultOrder'=>'Insurance_Company_Name ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function findInsurance()
	{
		$data = Yii::app()->db->createCommand('SELECT Insurance_Company_ID, Insurance_Company_Name FROM `ma_insurance_company` ORDER BY `ma_insurance_company`.`Insurance_Company_Name` ASC ')->queryAll();
		return $data;
	}
        
         public function getLastInsertedInsuranceCompany($Insurance_Company_ID)
        {
            $cri = new CDbCriteria();
            $cri->select="Insurance_Company_ID, Insurance_Company_Name";
            $cri->condition="Insurance_Company_ID = $Insurance_Company_ID";
            $array = $this->findAll($cri);
            return $array;
        }
	
}