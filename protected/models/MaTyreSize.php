<?php

/**
 * This is the model class for table "ma_tyre_size".
 *
 * The followings are the available columns in table 'ma_tyre_size':
 * @property integer $Tyre_Size_ID
 * @property string $Tyre_Size
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 */
class MaTyreSize extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaTyreSize the static model class
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
		return 'ma_tyre_size';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Tyre_Size', 'required'),
			array('Tyre_Size', 'length', 'max'=>100),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Tyre_Size', 'unique'),
			
			array('Tyre_Size', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Tyre_Size_ID, Tyre_Size, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'Tyre_Size_ID' => 'Tyre Size',
			'Tyre_Size' => 'Tyre Size',
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

		$criteria->compare('Tyre_Size_ID',$this->Tyre_Size_ID);
		$criteria->compare('Tyre_Size',$this->Tyre_Size,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>array('defaultOrder'=>'Tyre_Size ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function findAllTyreSize()
	{
		$data = Yii::app()->db->createCommand('select Tyre_Size_ID, Tyre_Size from ma_tyre_size order by Tyre_Size ASC')->queryAll();
		return $data;
	}

    public function getLastInsertedTyreSize($tyreSizeID)
    {
        $cri = new CDbCriteria();
        $cri->select="Tyre_Size_ID, Tyre_Size";
        $cri->condition="Tyre_Size_ID = $tyreSizeID";
        $array = $this->findAll($cri);
        return $array;
    }
}