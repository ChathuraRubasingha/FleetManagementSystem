<?php

/**
 * This is the model class for table "ma_make".
 *
 * The followings are the available columns in table 'ma_make':
 * @property integer $Make_ID
 * @property string $Make
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaModel[] $maModels
 */
class MaMake extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaMake the static model class
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
		return 'ma_make';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Make, add_by, add_date', 'required'),
			array('Make, add_by, edit_by, edit_date', 'length', 'max'=>50),
			array('Make', 'unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			
			array('Make', 'match', 'pattern'=>'/^([A-Za-z\- ])+$/'),
			
			array('Make_ID, Make, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'maModels' => array(self::HAS_MANY, 'MaModel', 'Make_ID'),
			'maVehicleRegistries' => array(self::HAS_MANY, 'MaVehicleRegistry', 'Make_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Make_ID' => 'Make',
			'Make' => 'Make',
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

		$criteria->compare('Make_ID',$this->Make_ID);
		$criteria->compare('Make',$this->Make,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>array('defaultOrder'=>'Make ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function findAllMakes()
	{
		$data = Yii::app()->db->createCommand('SELECT Make_ID, Make FROM  ma_make ORDER BY Make ASC')->queryAll();
		return $data;
	}


    public function getLastInsertedMake($makeID)
    {
        $cri = new CDbCriteria();
        $cri->select="Make_ID, Make";
        $cri->condition="Make_ID = $makeID";
        $array = $this->findAll($cri);
        return $array;
    }
}