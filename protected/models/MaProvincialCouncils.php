<?php

/**
 * This is the model class for table "ma_provincial_councils".
 *
 * The followings are the available columns in table 'ma_provincial_councils':
 * @property integer $Provincial_Councils_ID
 * @property string $Provincial_Councils_Name
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaDistrict[] $maDistricts
 * @property MaLocation[] $maLocations
 */
class MaProvincialCouncils extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaProvincialCouncils the static model class
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
		return 'ma_provincial_councils';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Provincial_Councils_Name', 'required'),
			array('Provincial_Councils_Name', 'length', 'max'=>200),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Provincial_Councils_Name', 'unique'),
			
			array('Provincial_Councils_Name', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Provincial_Councils_ID, Provincial_Councils_Name, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'maDistricts' => array(self::HAS_MANY, 'MaDistrict', 'Provincial_Councils_ID'),
			'maLocations' => array(self::HAS_MANY, 'MaLocation', 'Provincial_Councils_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Provincial_Councils_ID' => 'Provincial Council',
			'Provincial_Councils_Name' => 'Provincial Council Name',
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

		$criteria->compare('Provincial_Councils_ID',$this->Provincial_Councils_ID);
		$criteria->compare('Provincial_Councils_Name',$this->Provincial_Councils_Name,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>array('defaultOrder'=>'Provincial_Councils_Name ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function findAllProvincial()
	{
		$data = Yii::app()->db->createCommand('SELECT Provincial_Councils_ID, Provincial_Councils_Name FROM ma_provincial_councils 
ORDER BY Provincial_Councils_Name ASC')->queryAll();
		return $data;
	}
        
        public function getLastInsertedProvince($proID)
        {
            $cri = new CDbCriteria();
            $cri->select="Provincial_Councils_ID, Provincial_Councils_Name";
            $cri->condition="Provincial_Councils_ID = $proID";
            $array = $this->findAll($cri);
            return $array;
        }
}
