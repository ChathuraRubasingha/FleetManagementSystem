<?php

/**
 * This is the model class for table "ma_vehicle_status".
 *
 * The followings are the available columns in table 'ma_vehicle_status':
 * @property integer $Vehicle_Status_ID
 * @property string $Vehicle_Status
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaVehicleRegistry[] $maVehicleRegistries
 */
class VehicleStatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VehicleStatus the static model class
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
		return 'ma_vehicle_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Vehicle_Status', 'required'),
			array('Vehicle_Status', 'length', 'max'=>200),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Vehicle_Status', 'unique'),
			
			array('Vehicle_Status', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Vehicle_Status_ID, Vehicle_Status, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'maVehicleRegistries' => array(self::HAS_MANY, 'MaVehicleRegistry', 'Vehicle_Status_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Vehicle_Status_ID' => 'Vehicle Status',
			'Vehicle_Status' => 'Vehicle Status',
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

		$criteria->compare('Vehicle_Status_ID',$this->Vehicle_Status_ID);
		$criteria->compare('Vehicle_Status',$this->Vehicle_Status,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>array('defaultOrder'=>'Vehicle_Status ASC'), 'pagination'=>array('pageSize'=>20,)
			
			
		));
	}
	public function findAllVehicleStatus()
	{
		$data = Yii::app()->db->createCommand('SELECT Vehicle_Status_ID,Vehicle_Status FROM ma_vehicle_status ORDER BY Vehicle_Status ASC')->queryAll();
		return $data;
	}
}