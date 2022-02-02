<?php

/**
 * This is the model class for table "ma_repairs".
 *
 * The followings are the available columns in table 'ma_repairs':
 * @property integer $Repairs_ID
 * @property string $Vehicle_No
 * @property string $Total_Cost
 * @property string $Repairs_Date
 * @property integer $Garage_ID
 * @property integer $Repairs_Type_ID
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaVehicleRegistry $vehicleNo
 * @property MaGarages $garage
 * @property MaRepairs $repairsType
 * @property MaRepairs[] $maRepairs
 * @property RepairDetails[] $repairDetails
 */
class MaRepairs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaRepairs the static model class
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
		return 'ma_repairs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Vehicle_No, Total_Cost, Repairs_Date, Garage_ID, Repairs_Type_ID', 'required'),
			array('Garage_ID, Repairs_Type_ID', 'numerical', 'integerOnly'=>true),
			array('Vehicle_No', 'length', 'max'=>20),
			array('Total_Cost', 'length', 'max'=>50),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			
			array('Total_Cost', 'match', 'pattern'=>'/^([0-9\.])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Repairs_ID, Vehicle_No, Total_Cost, Repairs_Date, Garage_ID, Repairs_Type_ID, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
			'garage' => array(self::BELONGS_TO, 'MaGarages', 'Garage_ID'),
			'repairsType' => array(self::BELONGS_TO, 'MaRepairType', 'Repairs_Type_ID'),
			
			'repairDetails' => array(self::HAS_MANY, 'RepairDetails', 'Repairs_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Repairs_ID' => 'Repairs',
			'Vehicle_No' => 'Vehicle No',
			'Total_Cost' => 'Total Cost',
			'Repairs_Date' => 'Repairs Date',
			'Garage_ID' => 'Garage',
			'Repairs_Type_ID' => 'Repairs Type',
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

		$criteria = new CDbCriteria;

		$criteria->compare('Repairs_ID',$this->Repairs_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('Total_Cost',$this->Total_Cost,true);
		$criteria->compare('Repairs_Date',$this->Repairs_Date,true);
		$criteria->compare('Garage_ID',$this->Garage_ID);
		$criteria->compare('Repairs_Type_ID',$this->Repairs_Type_ID);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getRepairHistory()
	{
		$criteria=new CDbCriteria;
		
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria->compare('Vehicle_No',$vehicleId);
		
		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
            'defaultOrder'=>'Repairs_Date DESC',
            ),	
		));
	}
}