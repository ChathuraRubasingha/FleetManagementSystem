<?php

/**
 * This is the model class for table "repair_details".
 *
 * The followings are the available columns in table 'repair_details':
 * @property integer $Repair_Details_ID
 * @property integer $Repair_Details_ID
 * @property string $Description
 * @property integer $Replacement_ID
 * @property integer $Supplier_ID
 * @property string $Approved_By
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaSupplier $supplier
 * @property MaRepairs $repairs
 * @property MaReplacement $replacement
 */
class TRRepairDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRRepairDetails the static model class
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
		return 'repair_replacement_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Replacement_ID', 'required'),
			array('Repair_Details_ID, Next_Millage, Replacement_ID, Supplier_ID', 'numerical', 'integerOnly'=>true),
			array('Price', 'numerical'),
			array('Description', 'length', 'max'=>255),
			array('Approved_By', 'length', 'max'=>100),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('Next_Millage, Price, add_date, edit_date', 'safe'),
			
			//array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
           // array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20})+$/'),

            #array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Repair_Details_ID, Repair_Details_ID, Description, Replacement_ID, Supplier_ID, Approved_By, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'MaSupplier', 'Supplier_ID'),
			'repairs' => array(self::BELONGS_TO, 'MaRepairs', 'Repair_Details_ID'),
			'replacement' => array(self::BELONGS_TO, 'MaReplacement', 'Replacement_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$userRole = Yii::app()->getModule('user')->user()->Role_ID;
		if($userRole !=='3')
		{
			return array(
				'Repair_Details_ID' => 'Repair Details ID',
				'Description' => 'Description',
				'Replacement_ID' => 'Replacement',
				'Supplier_ID' => 'Supplier',
				'Price' => 'Price',
				'Next_Millage' => 'Next_Millage',
				'Approved_By' => 'Approved By',
				'add_by' => 'Add By',
				'add_date' => 'Add Date',
				'edit_by' => 'Edit By',
				'edit_date' => 'Edit Date',
			);
		}
		else
		{
			return array(
				'Repair_Details_ID' => 'Repair Details ID',
				'Repair_Details_ID' => 'Repairs ID',
				'Description' => 'විස්තරය',
				'Replacement_ID' => 'ප්‍රතිස්ථාපනය',
				'Supplier_ID' => 'Supplier',
				'Approved_By' => 'Approved By',
				'add_by' => 'Add By',
				'add_date' => 'Add Date',
				'edit_by' => 'Edit By',
				'edit_date' => 'Edit Date',
			);
		}
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

		$criteria->compare('Repair_Details_ID',$this->Repair_Details_ID);
		$criteria->compare('Repair_Details_ID',$this->Repair_Details_ID);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('Replacement_ID',$this->Replacement_ID);
		$criteria->compare('Supplier_ID',$this->Supplier_ID);
		$criteria->compare('Approved_By',$this->Approved_By,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}