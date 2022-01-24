<?php

/*
 * This is the model class for table "ma_service_station".
 *
 * The followings are the available columns in table 'ma_service_station':
 * @property integer $Service_Station_ID
 * @property string $Srvice_Station_Name
 * @property string $Address
 * @property string $Land_phone_No
 * @property string $Mobile_No
 * @property string $Fax
 * @property string $Contact_Person
 * @property string $Registration_No
 * @property string $Owner_Name
 * @property string $Email
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 */
class MaServiceStation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaServiceStation the static model class
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
		return 'ma_service_station';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Srvice_Station_Name, Address, Registration_No, Owner_Name', 'required'),
			array('Srvice_Station_Name', 'length', 'max'=>200),
			array('Address', 'length', 'max'=>255),
			array('Land_phone_No, Mobile_No, Fax', 'length', 'max'=>20),
			array('Contact_Person, Owner_Name, Email', 'length', 'max'=>100),
			array('Registration_No', 'length', 'max'=>50),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			//array('Srvice_Station_Name,Email,Land_phone_No,Mobile_No,Fax', 'unique'),
			array('Email,Land_phone_No,Mobile_No,Fax', 'unique'),
			
			array('Srvice_Station_Name', 'match', 'pattern'=>'/^[a-zA-Z0-9][a-zA-Z0-9\.\-#&\(\s\)]*$/'),
			array('Contact_Person,Owner_Name', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			//array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
			array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
			array('Land_phone_No,Mobile_No,Fax', 'match', 'pattern'=>'/^([0-9]{10})+$/'),
			array('Registration_No', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			array('Email', 'match', 'pattern'=>'/^[-a-zA-Z0-9][-.a-zA-Z0-9]*@[-.a-zA-Z0-9]+(\.[-.a-zA-Z0-9]+)*\./'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Service_Station_ID, Srvice_Station_Name, Address, Land_phone_No, Mobile_No, Fax, Contact_Person, Registration_No, Owner_Name, Email, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'Service_Station_ID' => 'Service Station ID',
			'Srvice_Station_Name' => 'Service Station Name',
			'Address' => 'Address',
			'Land_phone_No' => 'Land Phone No',
			'Mobile_No' => 'Mobile No',
			'Fax' => 'Fax',
			'Contact_Person' => 'Contact Person',
			'Registration_No' => 'Registration No',
			'Owner_Name' => 'Owner Name',
			'Email' => 'Email',
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

		$criteria->compare('Service_Station_ID',$this->Service_Station_ID);
		$criteria->compare('Srvice_Station_Name',$this->Srvice_Station_Name,true);
		$criteria->compare('Address',$this->Address,true);
		$criteria->compare('Land_phone_No',$this->Land_phone_No,true);
		$criteria->compare('Mobile_No',$this->Mobile_No,true);
		$criteria->compare('Fax',$this->Fax,true);
		$criteria->compare('Contact_Person',$this->Contact_Person,true);
		$criteria->compare('Registration_No',$this->Registration_No,true);
		$criteria->compare('Owner_Name',$this->Owner_Name,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>array('defaultOrder'=>'Srvice_Station_Name ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
        
    public function getLastInsertedStation($stationID)
    {
        $cri = new CDbCriteria();
        $cri->select="Service_Station_ID, Srvice_Station_Name";
        $cri->condition="Service_Station_ID = $stationID";
        $array = $this->findAll($cri);
        return $array;
    }
}