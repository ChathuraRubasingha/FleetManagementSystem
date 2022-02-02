<?php

/**
 * This is the model class for table "ma_emission_test_company".
 *
 * The followings are the available columns in table 'ma_emission_test_company':
 * @property integer $Emission_Test_Company_ID
 * @property string $Company_Name
 * @property string $Address
 * @property string $Land_phone_No
 * @property string $Mobile
 * @property string $Fax
 * @property string $Email
 * @property string $Contact_Person
 * @property string $Registration_No
 * @property string $Owner_Name
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 */
class MaEmissionTestCompany extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaEmissionTestCompany the static model class
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
		return 'ma_emission_test_company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Company_Name, Address, Registration_No, Owner_Name','required'),
			array('Company_Name, Address', 'length', 'max'=>255),
			array('Land_phone_No, Mobile, Fax', 'length', 'max'=>10),
			array('Email, Contact_Person', 'length', 'max'=>100),
			array('Registration_No, Owner_Name', 'length', 'max'=>50),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Land_phone_No,Mobile,Fax,Email,Registration_No', 'unique'),
			
			array('Company_Name', 'match', 'pattern'=>'/^[a-zA-Z0-9][a-zA-Z0-9\.\-#&\(\s\)]*$/'),
			array('Contact_Person,Owner_Name', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			//array('Address', 'match', 'pattern'=>'/^[-.?!,\/;:() A-Za-z0-9]*$/'),
			array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
			array('Land_phone_No,Mobile,Fax', 'match', 'pattern'=>'/^([0-9]{10})+$/'),
			array('Email', 'match', 'pattern'=>'/^[-a-zA-Z0-9][-.a-zA-Z0-9]*@[-.a-zA-Z0-9]+(\.[-.a-zA-Z0-9]+)*\./'),
			array('Registration_No', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Emission_Test_Company_ID, Company_Name, Address, Land_phone_No, Mobile, Fax, Email, Contact_Person,          	Registration_No, Owner_Name, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'Emission_Test_Company_ID' => 'Emission Test Company ID',
			'Company_Name' => 'Company Name',
			'Address' => 'Address',
			'Land_phone_No' => 'Land Phone No',
			'Mobile' => 'Mobile',
			'Fax' => 'Fax',
			'Email' => 'Email',
			'Contact_Person' => 'Contact Person',
			'Registration_No' => 'Registration No',
			'Owner_Name' => 'Owner Name',
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

		$criteria->compare('Emission_Test_Company_ID',$this->Emission_Test_Company_ID);
		$criteria->compare('Company_Name',$this->Company_Name,true);
		$criteria->compare('Address',$this->Address,true);
		$criteria->compare('Land_phone_No',$this->Land_phone_No,true);
		$criteria->compare('Mobile',$this->Mobile,true);
		$criteria->compare('Fax',$this->Fax,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('Contact_Person',$this->Contact_Person,true);
		$criteria->compare('Registration_No',$this->Registration_No,true);
		$criteria->compare('Owner_Name',$this->Owner_Name,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>array('defaultOrder'=>'Company_Name ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function findEmission()
	{
		$data = Yii::app()->db->createCommand('select Emission_Test_Company_ID, Company_Name from ma_emission_test_company order by Company_Name asc')->queryAll();
		return $data;
	}
        
        public function getLastInsertedEmissionCom($Emission_Test_Company_ID)
        {
            $cri = new CDbCriteria();
            $cri->select="Emission_Test_Company_ID, Battery_Type";
            $cri->condition="Emission_Test_Company_ID = $Emission_Test_Company_ID";
            $array = $this->findAll($cri);
            return $array;
        }
}