<?php

/**
 * This is the model class for table "odometer_update_remark".
 *
 * The followings are the available columns in table 'odometer_update_remark':
 * @property integer $remark_id
 * @property string $description
 * @property string $added_by
 * @property string $added_date
 *
 * The followings are the available model relations:
 * @property OdometerUpdate[] $odometerUpdates
 */
class OdometerUpdateRemark extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OdometerUpdateRemark the static model class
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
		return 'odometer_update_remark';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, add_by, add_date', 'required'),
			array('description, add_by, edit_by, edit_date', 'length', 'max'=>50),
			array('description', 'unique'),
			//array('description', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
            array('description', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20})+$/'),

            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('remark_id, description, add_by, add_date', 'safe', 'on'=>'search'),
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
			'odometerUpdates' => array(self::HAS_MANY, 'OdometerUpdate', 'remark_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'remark_id' => 'Remark',
			'description' => 'Description',
			'add_by' => 'Add By',
			'add_date' => 'Add Date',
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

		$criteria->compare('remark_id',$this->remark_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getLastInsertedRemark($remarkID)
        {
            $cri = new CDbCriteria();
            $cri->select="remark_id, description";
            $cri->condition="remark_id = $remarkID";
            $array = $this->findAll($cri);
            return $array;
        }
}