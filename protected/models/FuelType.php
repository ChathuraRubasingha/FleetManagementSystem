<?php

/**
 * This is the model class for table "ma_fuel_type".
 *
 * The followings are the available columns in table 'ma_fuel_type':
 * @property integer $Fuel_Type_ID
 * @property string $Fuel_Type
 * @property string $add_by
 * @property integer $add_date
 * @property string $edit_by
 * @property integer $edit_date
 *
 * The followings are the available model relations:
 * @property MaVehicleRegistry[] $maVehicleRegistries
 */
class FuelType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FuelType the static model class
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
		return 'ma_fuel_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	 
	 public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fuel_Type, add_by, add_date', 'required'),
			array('Fuel_Type, add_by, edit_by, edit_date', 'length', 'max'=>50),
			array('Fuel_Type', 'unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			
			array('Fuel_Type', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			
			array('Fuel_Type_ID, Fuel_Type, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'maVehicleRegistries' => array(self::HAS_MANY, 'MaVehicleRegistry', 'Fuel_Type_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Fuel_Type_ID' => 'Fuel Type',
			'Fuel_Type' => 'Fuel Type',
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

		$criteria->compare('Fuel_Type_ID',$this->Fuel_Type_ID);
		$criteria->compare('Fuel_Type',$this->Fuel_Type,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>array('defaultOrder'=>'Fuel_Type ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function findAllFuelType()
	{
		$data = Yii::app()->db->createCommand('select Fuel_Type_ID, Fuel_Type from ma_fuel_type order by Fuel_Type ASC')->queryAll();
		return $data;
	}

    public function getLastInsertedFuelType($fuelTypeID)
    {
        $cri = new CDbCriteria();
        $cri->select="Fuel_Type_ID, Fuel_Type";
        $cri->condition="Fuel_Type_ID = $fuelTypeID";
        $array = $this->findAll($cri);
        return $array;
    }
}