<?php

/**
 * This is the model class for table "ma_location".
 *
 * The followings are the available columns in table 'ma_location':
 * @property integer $Location_ID
 * @property integer $Provincial_Councils_ID
 * @property integer $District_ID
 * @property integer $DS_Division_ID
 * @property integer $GN_Division_ID
 * @property string $Location_Name
 * @property string $Address
 * @property string $Telephone
 * @property string $Fax
 * @property string $Email
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaDriver[] $maDrivers
 * @property MaProvincialCouncils $provincialCouncils
 * @property MaDistrict $district
 * @property MaDsDivision $dSDivision
 * @property MaGnDivision $gNDivision
 * @property MaUser[] $maUsers
 * @property VehicleLocation[] $vehicleLocations
 */
class MaLocation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaLocation the static model class
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
            return 'ma_location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
            return array(
                array('Location_Name, District_ID', 'required'),
                array('Provincial_Councils_ID, District_ID, DS_Division_ID, GN_Division_ID', 'numerical', 'integerOnly'=>true),
                array('Location_Name, Address', 'length', 'max'=>200),
                array('Telephone, Fax', 'length', 'max'=>10),
                array('Email', 'length', 'max'=>100),
                array('add_by, edit_by', 'length', 'max'=>50),
                array('Location_Name', 'unique'),
                array('add_date, edit_date, district.District_Name', 'safe'),

                array('Telephone, Fax', 'match', 'pattern'=>'/^([0-9]{10})+$/'),
                //array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
                array('Address', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
                array('Email', 'match', 'pattern'=>'/^[-a-zA-Z0-9][-.a-zA-Z0-9]*@[-.a-zA-Z]+(\.[-.a-zA-Z]+)*\./'),


                array('Location_Name', 'match', 'pattern'=>'/^([0-9A-Za-z \-&\/])+$/'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('Location_ID, Provincial_Councils_ID, District_ID, DS_Division_ID, GN_Division_ID, Location_Name, Address, Telephone, Fax, Email, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
                'maDrivers' => array(self::HAS_MANY, 'MaDriver', 'Location_ID'),
                'provincialCouncils' => array(self::BELONGS_TO, 'MaProvincialCouncils', 'Provincial_Councils_ID'),
                'district' => array(self::BELONGS_TO, 'MaDistrict', 'District_ID'),
                'dSDivision' => array(self::BELONGS_TO, 'MaDsDivision', 'DS_Division_ID'),
                'gNDivision' => array(self::BELONGS_TO, 'MaGnDivision', 'GN_Division_ID'),
                'maUsers' => array(self::HAS_MANY, 'MaUser', 'Location_ID'),
                'vehicleLocations' => array(self::HAS_MANY, 'VehicleLocation', 'Location_ID'),
            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'Location_ID' => 'Location',
                'Provincial_Councils_ID' => 'Provincial Councils',
                'District_ID' => 'District',
                'DS_Division_ID' => 'DS Division',
                'GN_Division_ID' => 'GN Division',
                'Location_Name' => 'Location Name',
                'Address' => 'Address',
                'Telephone' => 'Telephone',
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

            $criteria->compare('Location_ID',$this->Location_ID);
            $criteria->compare('Provincial_Councils_ID',$this->Provincial_Councils_ID);
            //$criteria->compare('District_ID',$this->District_ID);
            $criteria->with = array('district');
            $criteria->compare('district.District_Name', $this->District_ID);
            $criteria->compare('DS_Division_ID',$this->DS_Division_ID);
            $criteria->compare('GN_Division_ID',$this->GN_Division_ID);
            $criteria->compare('Location_Name',$this->Location_Name,true);
            $criteria->compare('Address',$this->Address,true);
            $criteria->compare('Telephone',$this->Telephone,true);
            $criteria->compare('Fax',$this->Fax,true);
            $criteria->compare('Email',$this->Email,true);
            $criteria->compare('add_by',$this->add_by,true);
            $criteria->compare('add_date',$this->add_date,true);
            $criteria->compare('edit_by',$this->edit_by,true);
            $criteria->compare('edit_date',$this->edit_date,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,'sort'=>array('defaultOrder'=>'Location_Name ASC'),'pagination'=>array('pageSize'=>20,)
            ));
	}
	
	public function getLocation()
	{
            $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

            if ($superuserstatus == 1) 
            {
                $cmd = '
                    select Location_ID, Location_Name
                    FROM ma_location ';	
            } 
            else
            {
                $cmd = '
                    select Location_ID, Location_Name
                    FROM ma_location 
                    WHERE Location_ID ='.$LocId;	
            }

            $rowData = Yii::app()->db->createCommand($cmd)->queryAll();
            return $rowData;
	}
	
	public function getLoc($locID)
	{
		$query = 'SELECT Location_ID, Location_Name FROM ma_location WHERE Location_ID='.$locID;
		$data = Yii::app()->db->createCommand($query)->queryAll();
		return $data;
	}
	public function getFromLocation($loc)
	{
		$cmd = 'select Location_Name from ma_location where Location_ID = '.$loc;
		$rowData = Yii::app()->db->createCommand($cmd)->queryAll();
		return $rowData;
	}
	
	public function findAllLocations()
	{
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            $loc = Yii::app()->getModule('user')->user()->Location_ID;
            
            $cri = new CDbCriteria();
            $cri->select = "t.Location_ID, t.Location_Name";
            
            if($superUser !='1')
            {
                $cri->condition = "t.Location_ID = $loc";
            }
		//$data = Yii::app()->db->createCommand('SELECT Location_ID, Location_Name FROM ma_location ORDER BY Location_Name ASC')->queryAll();
            $data = MaLocation::model()->findAll($cri);
            return $data;
	}

    public function findLocations($dist)
    {
        $loc = Yii::app()->getModule('user')->user()->Location_ID;
        $superuser = Yii::app()->getModule('user')->user()->superuser;
        //$role = Yii::app()->getModule('user')->user()->Role_ID;
        $cri = new CDbCriteria();
        if($superuser =='0')
        {
            $cri->select="Location_ID, Location_Name";
            $cri->condition="Location_ID=$loc";
        }
        else
        {
            $cri->select="Location_ID, Location_Name";
            $cri->condition="District_ID=$dist";
            $cri->order="Location_Name ASC";

        }

        $data = $this->findAll($cri);
        return $data;
    }
    
    public function getLastInsertedLocation($locationID)
    {
        $cri = new CDbCriteria();
        $cri->select="Location_ID, Location_Name";
        $cri->condition="Location_ID = $locationID";
        $array = $this->findAll($cri);
        return $array;
    }
}