<?php

/**
 * This is the model class for table "ma_supplier".
 *
 * The followings are the available columns in table 'ma_supplier':
 * @property integer $Supplier_ID
 * @property string $Supplier_Name
 * @property string $Address * @property string $Contact_Person
 * @property string $Land_phone_No
 * @property string $Mobile
 * @property string $Fax
 * @property string $Email
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property RepairDetails[] $repairDetails
 */
class MaSupplier extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaSupplier the static model class
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
		return 'ma_supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Supplier_Name, Address', 'required'),
			array('Supplier_Name', 'length', 'max'=>200),
			array('Address, Mobile', 'length', 'max'=>250),
			array('Contact_Person, Land_phone_No', 'length', 'max'=>20),
			array('Fax, Email', 'length', 'max'=>100),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Supplier_Name,Land_phone_No,Mobile,Fax,Email', 'unique'),
			
			array('Supplier_Name', 'match', 'pattern'=>'/^[a-zA-Z0-9][a-zA-Z0-9\.\-#&\(\s\)]*$/'),
			array('Contact_Person', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			//array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
			array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
			array('Land_phone_No,Mobile,Fax', 'match', 'pattern'=>'/^([0-9]{10})+$/'),
			//array('Email', 'match', 'pattern'=>'/^[-a-zA-Z0-9][-.a-zA-Z0-9]*@[-.a-zA-Z0-9]+(\.[-.a-zA-Z]+)*\./'),'
			
			array('Email', 'match', 'pattern'=>'/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-]+.[a-zA-Z]{2,4}+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Supplier_ID, Supplier_Name, Address, Contact_Person, Land_phone_No, Mobile, Fax, Email, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'repairDetails' => array(self::HAS_MANY, 'RepairDetails', 'Supplier_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Supplier_ID' => 'Supplier',
			'Supplier_Name' => 'Supplier Name',
			'Address' => 'Address',
			'Contact_Person' => 'Contact Person',
			'Land_phone_No' => 'Land Phone',
			'Mobile' => 'Mobile',
			'Fax' => 'Fax',
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

		$criteria->compare('Supplier_ID',$this->Supplier_ID);
		$criteria->compare('Supplier_Name',$this->Supplier_Name,true);
		$criteria->compare('Address',$this->Address,true);
		$criteria->compare('Contact_Person',$this->Contact_Person,true);
		$criteria->compare('Land_phone_No',$this->Land_phone_No,true);
		$criteria->compare('Mobile',$this->Mobile,true);
		$criteria->compare('Fax',$this->Fax,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>array('defaultOrder'=>'Supplier_Name ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
        
        public function getLastInsertedSupplier($supID)
        {
            $cri = new CDbCriteria();
            $cri->select="Supplier_ID, Supplier_Name";
            $cri->condition="Supplier_ID = $supID";
            $array = $this->findAll($cri);
            return $array;
        }
}