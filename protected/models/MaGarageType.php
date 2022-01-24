<?php

/**
 * This is the model class for table "ma_garage_type".
 *
 * The followings are the available columns in table 'ma_garage_type':
 * @property integer $Garage_Type_ID
 * @property string $Garage_Type
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaGarages[] $maGarages
 */
class MaGarageType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaGarageType the static model class
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
		return 'ma_garage_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.		
		return array(
			array('Garage_Type', 'required'),
			array('Garage_Type', 'length', 'max'=>200),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Garage_Type', 'unique'),
			
			array('Garage_Type', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Garage_Type_ID, Garage_Type, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'maGarages' => array(self::HAS_MANY, 'MaGarages', 'Garage_Type_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Garage_Type_ID' => 'Garage Type ID',
			'Garage_Type' => 'Garage Type',
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

		$criteria->compare('Garage_Type_ID',$this->Garage_Type_ID);
		$criteria->compare('Garage_Type',$this->Garage_Type,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>array('defaultOrder'=>'Garage_Type ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
        
         public function getLastInsertedGarageType($Garage_Type_ID)
    {
        $cri = new CDbCriteria();
        $cri->select="Garage_Type_ID, Garage_Type";
        $cri->condition="Garage_Type_ID = $Garage_Type_ID";
        $array = $this->findAll($cri);
        return $array;
    }
}