<?php

/**
 * This is the model class for table "pizza".
 *
 * The followings are the available columns in table 'pizza':
 * @property integer $pizza_id
 * @property string $pizza_name
 * @property integer $pizza_type_id
 */
class Pizza extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pizza the static model class
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
		return 'pizza';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pizza_name, pizza_type_id', 'required'),
			array('pizza_type_id', 'numerical', 'integerOnly'=>true),
			array('pizza_name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pizza_id, pizza_name, pizza_type_id', 'safe', 'on'=>'search'),
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
			'pizza_id' => 'Pizza',
			'pizza_name' => 'Pizza Name',
			'pizza_type_id' => 'Pizza Type',
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

		$criteria->compare('pizza_id',$this->pizza_id);
		$criteria->compare('pizza_name',$this->pizza_name,true);
		$criteria->compare('pizza_type_id',$this->pizza_type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}