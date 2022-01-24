<?php

/**
 * This is the model class for table "ma_replacement".
 *
 * The followings are the available columns in table 'ma_replacement':
 * @property integer $Replacement_ID
 * @property string $Replacement
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property RepairDetails[] $repairDetails
 */
class MaReplacement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaReplacement the static model class
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
		return 'ma_replacement';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Replacement', 'required'),
			array('Replacement', 'length', 'max'=>100),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Replacement', 'unique'),
			array('Replacement', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Replacement_ID, Replacement, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'repairDetails' => array(self::HAS_MANY, 'RepairDetails', 'Replacement_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Replacement_ID' => 'Replacement',
			'Replacement' => 'Replacement',
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

		$criteria->compare('Replacement_ID',$this->Replacement_ID);
		$criteria->compare('Replacement',$this->Replacement,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>array('defaultOrder'=>'Replacement ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
        
        public function getLastInsertedReplacement($repID)
        {
            $cri = new CDbCriteria();
            $cri->select="Replacement_ID, Replacement";
            $cri->condition="Replacement_ID = $repID";
            $array = $this->findAll($cri);
            return $array;
        }
}