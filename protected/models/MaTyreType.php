<?php

/**
 * This is the model class for table "ma_tyre_type".
 *
 * The followings are the available columns in table 'ma_tyre_type':
 * @property integer $Tyre_Type_ID
 * @property string $Tyre_Type
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaVehicleRegistry[] $maVehicleRegistries
 */
class MaTyreType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaTyreType the static model class
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
		return 'ma_tyre_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Tyre_Type', 'required'),
			array('Tyre_Type', 'length', 'max'=>100),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Tyre_Type', 'unique'),
			
			array('Tyre_Type', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Tyre_Type_ID, Tyre_Type, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'maVehicleRegistries' => array(self::HAS_MANY, 'MaVehicleRegistry', 'Tyre_Type_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Tyre_Type_ID' => 'Tyre Type',
			'Tyre_Type' => 'Tyre Type',
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

		$criteria->compare('Tyre_Type_ID',$this->Tyre_Type_ID);
		$criteria->compare('Tyre_Type',$this->Tyre_Type,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>array('defaultOrder'=>'Tyre_Type ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function findAllTyreType()
	{
		$data = Yii::app()->db->createCommand('SELECT Tyre_Type_ID,Tyre_Type FROM ma_tyre_type ORDER BY Tyre_Type ASC')->queryAll();
		return $data;
	}

    public function getLastInsertedTyreType($tyreTypeID)
    {
        $cri = new CDbCriteria();
        $cri->select="Tyre_Type_ID, Tyre_Type";
        $cri->condition="Tyre_Type_ID = $tyreTypeID";
        $array = $this->findAll($cri);
        return $array;
    }
}