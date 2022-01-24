<?php

/**
 * This is the model class for table "ma_battery_type".
 *
 * The followings are the available columns in table 'ma_battery_type':
 * @property integer $Battery_Type_ID
 * @property string $Battery_Type
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 */
class MaBatteryType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaBatteryType the static model class
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
		return 'ma_battery_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Battery_Type', 'required'),
			array('Battery_Type', 'length', 'max'=>150),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Battery_Type', 'unique'),
			
			array('Battery_Type', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Battery_Type_ID, Battery_Type, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'Battery_Type_ID' => 'Battery Type',
			'Battery_Type' => 'Battery Type',
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

		$criteria->compare('Battery_Type_ID',$this->Battery_Type_ID);
		$criteria->compare('Battery_Type',$this->Battery_Type,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>array('defaultOrder'=>'Battery_Type ASC'), 'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function findAllBatteryType()
	{
		$data = Yii::app()->db->createCommand('SELECT Battery_Type_ID,Battery_Type FROM ma_battery_type ORDER BY Battery_Type ASC')->queryAll();
		return $data;
	}

    public function getLastInsertedBatteryType($batteryTypeID)
    {
        $cri = new CDbCriteria();
        $cri->select="Battery_Type_ID, Battery_Type";
        $cri->condition="Battery_Type_ID = $batteryTypeID";
        $array = $this->findAll($cri);
        return $array;
    }
}