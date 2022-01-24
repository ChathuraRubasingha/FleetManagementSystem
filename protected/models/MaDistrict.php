<?php

/**
 * This is the model class for table "ma_district".
 *
 * The followings are the available columns in table 'ma_district':
 * @property integer $District_ID
 * @property string $District_Name
 * @property integer $Provincial_Councils_ID
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaProvincialCouncils $provincialCouncils
 * @property MaDsDivision[] $maDsDivisions
 * @property MaLocation[] $maLocations
 */
class MaDistrict extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaDistrict the static model class
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
		return 'ma_district';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('District_Name, Provincial_Councils_ID', 'required'),
			array('Provincial_Councils_ID', 'numerical', 'integerOnly'=>true),
			array('District_Name', 'length', 'max'=>200),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date, provincialCouncils.Provincial_Councils_Name', 'safe'),
			array('District_Name','unique','message' =>'District Name is already added.'),
			
			array('District_Name', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('District_ID, District_Name, Provincial_Councils_ID, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>    		'search'),
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
			'provincialCouncils' => array(self::BELONGS_TO, 'MaProvincialCouncils', 'Provincial_Councils_ID'),
			'maDsDivisions' => array(self::HAS_MANY, 'MaDsDivision', 'District_ID'),
			'maLocations' => array(self::HAS_MANY, 'MaLocation', 'District_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'District_ID' => 'District',
			'District_Name' => 'District Name',
			'Provincial_Councils_ID' => 'Provincial Council',
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

		$criteria=new CDbCriteria(array('order'=>'provincialCouncils.Provincial_Councils_Name ASC, t.District_Name ASC'));

		$criteria->compare('District_ID',$this->District_ID);
		$criteria->compare('t.District_Name',$this->District_Name,true);
		//$criteria->compare('Provincial_Councils_ID',$this->Provincial_Councils_ID);
		$criteria->with = array('provincialCouncils');
		$criteria->compare('provincialCouncils.Provincial_Councils_Name', $this->Provincial_Councils_ID);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, /*'sort'=>array('defaultOrder'=>'provincialCouncils.Provincial_Councils_Name ASC'),*/ 'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function findAllDistricts()
	{
        $district = Yii::app()->getModule('user')->user()->District_ID;
        $superuser = Yii::app()->getModule('user')->user()->superuser;
        //$role = Yii::app()->getModule('user')->user()->Role_ID;

        if($superuser =='0')
        {
            $data = Yii::app()->db->createCommand("SELECT District_ID, District_Name FROM ma_district where District_ID =$district")->queryAll();
        }
        else
        {
            $data = Yii::app()->db->createCommand('SELECT District_ID, District_Name FROM ma_district ORDER BY District_Name ASC')->queryAll();
        }
        return $data;
	}
        
        public function getLastInsertedDistrict($distID)
        {
            $cri = new CDbCriteria();
            $cri->select="District_ID, District_Name";
            $cri->condition="District_ID = $distID";
            $array = $this->findAll($cri);
            return $array;
        }
}