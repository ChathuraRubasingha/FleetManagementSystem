<?php

/**
 * This is the model class for table "ma_user".
 *
 * The followings are the available columns in table 'ma_user':
 * @property integer $User_ID
 * @property string $Full_Name
 * @property string $Address
 * @property string $NIC
 * @property integer $Location_ID
 * @property string $Mobile
 * @property string $Email
 * @property integer $Designation_ID
 * @property string $UserName
 * @property string $Password
 * @property integer $Role_ID
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property BookingRequest[] $bookingRequests
 * @property MaLocation $location
 * @property MaDesignation $designation
 * @property MaRole $role
 */
class MaUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaUser the static model class
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
		return 'ma_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Full_Name, Address, NIC, Location_ID, Designation_ID, UserName, Password, Role_ID', 'required'),
			array('Location_ID, Designation_ID, Role_ID', 'numerical', 'integerOnly'=>true),
			array('Full_Name, Address', 'length', 'max'=>255),
			array('NIC, Mobile', 'length', 'max'=>10),
			array('Email', 'length', 'max'=>100),
			array('UserName, Password', 'length', 'max'=>50),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('NIC,Fax,Mobile, Email,UserName', 'unique'),
			
			array('Full_Name', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			array('UserName', 'match', 'pattern'=>'/^([0-9A-Za-z ])+$/'),
			array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			array('NIC', 'match', 'pattern'=>'/^[0-9]{9}[VX]$/','message' =>'NIC Number incorrect.'),
			array('Password', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/])+$/'),
			
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('User_ID, Full_Name, Address, NIC, Location_ID, Mobile, Email, Designation_ID, UserName, Password, Role_ID, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'bookingRequests' => array(self::HAS_MANY, 'BookingRequest', 'User_ID'),
			'location' => array(self::BELONGS_TO, 'MaLocation', 'Location_ID'),
			'designation' => array(self::BELONGS_TO, 'MaDesignation', 'Designation_ID'),
			'role' => array(self::BELONGS_TO, 'Role', 'Role_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'User_ID' => 'User',
			'Full_Name' => 'Full Name',
			'Address' => 'Address',
			'NIC' => 'NIC',
			'Location_ID' => 'Location',
			'Mobile' => 'Mobile',
			'Email' => 'Email',
			'Designation_ID' => 'Designation',
			'UserName' => 'User Name',
			'Password' => 'Password',
			'Role_ID' => 'Role',
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

		$criteria->compare('User_ID',$this->User_ID);
		$criteria->compare('Full_Name',$this->Full_Name,true);
		$criteria->compare('Address',$this->Address,true);
		$criteria->compare('NIC',$this->NIC,true);
		$criteria->compare('Location_ID',$this->Location_ID);
		$criteria->compare('Mobile',$this->Mobile,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('Designation_ID',$this->Designation_ID);
		$criteria->compare('UserName',$this->UserName,true);
		$criteria->compare('Password',$this->Password,true);
		$criteria->compare('Role_ID',$this->Role_ID);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}