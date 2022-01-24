<?php

/**
 * This is the model class for table "ma_supplier_category".
 *
 * The followings are the available columns in table 'ma_supplier_category':
 * @property integer $Supplier_Category_ID
 * @property integer $Replacement_ID
 * @property integer $Supplier_ID
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaSupplier $supplier
 * @property MaReplacement $replacement
 */
class MaSupplierCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaSupplierCategory the static model class
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
		return 'ma_supplier_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Replacement_ID, Supplier_ID', 'required'),
			array('Replacement_ID, Supplier_ID', 'numerical', 'integerOnly'=>true),
			array('add_by, edit_by', 'length', 'max'=>20),
			array('add_date, edit_date, replacement.Replacement, supplier.Supplier_Name', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Supplier_Category_ID, Replacement_ID, Supplier_ID, add_by, add_date, edit_by, edit_date, replacement.Replacement, supplier.Supplier_Name', 'safe', 'on'=>'search'),
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
			'replacement' => array(self::BELONGS_TO, 'MaReplacement', 'Replacement_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Supplier_Category_ID' => 'Supplier Category',
			'Replacement_ID' => 'Replacement',
			'Supplier_ID' => 'Supplier',
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

		$criteria->compare('Supplier_Category_ID',$this->Supplier_Category_ID);
		//$criteria->compare('Replacement_ID',$this->Replacement_ID);
		
		$criteria->compare('replacement.Replacement',$this->Replacement_ID, true);		
	$criteria->with = array('replacement'=>array('select'=>'replacement.Replacement', 'together'=>true), 'supplier'=>array('select'=>'supplier.Supplier_Name', 'together'=>true));
		
		
		//$criteria->compare('Supplier_ID',$this->Supplier_ID);

		$criteria->compare('supplier.Supplier_Name',$this->Supplier_ID, true);		
		//$criteria->with = array('supplier'=>array('select'=>'supplier.Supplier_Name', 'together'=>true));

		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination'=>array('pageSize'=>20,)
		));
	}
}