<?php

/**
 * This is the model class for table "ma_garages".
 *
 * The followings are the available columns in table 'ma_garages':
 * @property integer $Garage_ID
 * @property integer $Garage_Type_ID
 * @property string $Garage_Name
 * @property string $Land_Phone_No
 * @property string $Mobile_No
 * @property string $Fax
 * @property string $Email
 * @property string $Contact_No
 * @property string $Registration_No
 * @property string $Owner_Name
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaGarageType $garageType
 */
class MaGarages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaGarages the static model class
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
		return 'ma_garages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Garage_Type_ID, Garage_Name,Registration_No, Owner_Name', 'required'),
			array('Garage_Type_ID', 'numerical', 'integerOnly'=>true),
			array('Garage_Name', 'length', 'max'=>255),
			array('Land_Phone_No, Mobile_No, Contact_No', 'length', 'max'=>20),
			array('Fax, Email', 'length', 'max'=>100),
			array('Registration_No', 'length', 'max'=>50),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date, garageType.Garage_Type', 'safe'),
			array('Owner_Name', 'length', 'max'=>200),
			//array('Garage_Name,Fax,Email,Contact_No,Registration_No', 'unique'),
			array('Fax,Email,Contact_No,Registration_No', 'unique'),
			
			array('Garage_Name', 'match', 'pattern'=>'/^[a-zA-Z0-9][a-zA-Z0-9\.\-#&\(\s\)]*$/'),
			array('Owner_Name', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			array('Land_Phone_No,Fax,Contact_No, Mobile_No', 'match', 'pattern'=>'/^([0-9]{10})+$/'),
			array('Email', 'match', 'pattern'=>'/^[-a-zA-Z0-9][-.a-zA-Z0-9]*@[-.a-zA-Z0-9]+(\.[-.a-zA-Z0-9]+)*\./'),
			array('Registration_No', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Garage_ID, Garage_Type_ID, garageType.Garage_Type, Garage_Name, Land_Phone_No, Mobile_No, Fax, Email, Contact_No, Registration_No, Owner_Name, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'garageType' => array(self::BELONGS_TO, 'MaGarageType', 'Garage_Type_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Garage_ID' => 'Garage',
			'Garage_Type_ID' => 'Garage Type',
			'Garage_Name' => 'Garage Name',
			'Land_Phone_No' => 'Land Phone No',
			'Mobile_No' => 'Mobile No',
			'Fax' => 'Fax',
			'Email' => 'Email',
			'Contact_No' => 'Contact No',
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

		$criteria->compare('Garage_ID',$this->Garage_ID);
		#$criteria->compare('Garage_Type_ID',$this->Garage_Type_ID);
		
		$criteria->compare('garageType.Garage_Type',$this->Garage_Type_ID, true);
		$criteria->with = array('garageType'=>array('select'=>'garageType.Garage_Type','together'=>true));


		$criteria->compare('Garage_Name',$this->Garage_Name,true);
		$criteria->compare('Land_Phone_No',$this->Land_Phone_No,true);
		$criteria->compare('Mobile_No',$this->Mobile_No,true);
		$criteria->compare('Fax',$this->Fax,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('Contact_No',$this->Contact_No,true);
		$criteria->compare('Registration_No',$this->Registration_No,true);
		$criteria->compare('Owner_Name',$this->Owner_Name,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>array('defaultOrder'=>'Garage_Name ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
        
        public function getLastInsertedGarage($Garage_ID)
        {
            $cri = new CDbCriteria();
            $cri->select="Garage_ID, Garage_Name";
            $cri->condition="Garage_ID = $Garage_ID";
            $array = $this->findAll($cri);
            return $array;
        }
}