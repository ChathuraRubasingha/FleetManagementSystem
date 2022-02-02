<?php

/**
 * This is the model class for table "ma_designation".
 *
 * The followings are the available columns in table 'ma_designation':
 * @property integer $Designation_ID
 * @property string $Designation
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaUser[] $maUsers
 */
class MaDesignation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaDesignation the static model class
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
		return 'ma_designation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return array(
			array('Designation', 'required'),
			array('Designation', 'length', 'max'=>200),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Designation', 'unique'),
			
			array('Designation', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Designation_ID, Designation, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'maUsers' => array(self::HAS_MANY, 'MaUser', 'Designation_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Designation_ID' => 'Designation',
			'Designation' => 'Designation',
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

		$criteria->compare('Designation_ID',$this->Designation_ID);
		$criteria->compare('Designation',$this->Designation,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>array('defaultOrder'=>'Designation ASC'),'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function findDesignation()
	{
		$criteria = new CDbCriteria;
		
		$criteria->select = array('Designation_ID','Designation');
		$criteria->order='Designation ASC';
		
		return $this->findAll($criteria);
	}
        
        public function getLastInsertedDesignation($desigID)
        {
            $cri = new CDbCriteria();
            $cri->select="Designation_ID, Designation";
            $cri->condition="Designation_ID = $desigID";
            $array = $this->findAll($cri);
            return $array;
        }
}