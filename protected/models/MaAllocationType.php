<?php

/**
 * This is the model class for table "ma_allocation_type".
 *
 * The followings are the available columns in table 'ma_allocation_type':
 * @property integer $Allocation_Type_ID
 * @property string $Allocation_Type
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property BookingRequest[] $bookingRequests
 * @property VehicleBooking[] $vehicleBookings
 */
class MaAllocationType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaAllocationType the static model class
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
		return 'ma_allocation_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Allocation_Type', 'required'),
			array('Allocation_Type', 'length', 'max'=>200),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Allocation_Type', 'unique'),
			array('Allocation_Type', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Allocation_Type_ID, Allocation_Type, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'bookingRequests' => array(self::HAS_MANY, 'BookingRequest', 'Allocation_Type_ID'),
			'vehicleBookings' => array(self::HAS_MANY, 'VehicleBooking', 'Allocation_Type_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Allocation_Type_ID' => 'Allocation Type',
			'Allocation_Type' => 'Allocation Type',
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

		$criteria->compare('t.Allocation_Type_ID',$this->Allocation_Type_ID);
		$criteria->compare('t.Allocation_Type',$this->Allocation_Type,true);
		$criteria->compare('t.add_by',$this->add_by,true);
		$criteria->compare('t.add_date',$this->add_date,true);
		$criteria->compare('t.edit_by',$this->edit_by,true);
		$criteria->compare('t.edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>array('defaultOrder'=>'Allocation_Type ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function getAllocationTypeForReport()
	{
		$data = "SELECT Allocation_Type_ID, Allocation_Type FROM ma_allocation_type";
		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		
		return $rawData;
	}
	
	public function findAllocation()
	{
		$rowData = "select Allocation_Type_ID, Allocation_Type From ma_allocation_type order by Allocation_Type ASC";
		$data = Yii::app()->db->createCommand($rowData)->queryAll();
		return $data;
	}
}