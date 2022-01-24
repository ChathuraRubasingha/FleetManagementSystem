<?php

/**
 * This is the model class for table "ma_model".
 *
 * The followings are the available columns in table 'ma_model':
 * @property integer $Model_ID
 * @property string $Model
 * @property integer $Make_ID
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaMake $make
 */
class MaModel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MaModel the static model class
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
		return 'ma_model';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Model, Make_ID, add_by, add_date', 'required'),
			array('Make_ID', 'numerical', 'integerOnly'=>true),
			array('Model, add_by, edit_by, edit_date', 'length', 'max'=>50),
			array('Model', 'unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			
			array('Model', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			
			array('Model_ID, Model, Make_ID, make.Make, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'make' => array(self::BELONGS_TO, 'MaMake', 'Make_ID'),
			'maVehicleRegistries' => array(self::HAS_MANY, 'MaVehicleRegistry', 'Model_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Model_ID' => 'Model',
			'Model' => 'Model',
			'Make_ID' => 'Make',
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

		$criteria=new CDbCriteria(array('order'=>'make.Make ASC, t.Model ASC'));

		$criteria->compare('Model_ID',$this->Model_ID);
		$criteria->compare('t.Model',$this->Model,true);
		#$criteria->compare('Make_ID',$this->Make_ID);
		
		$criteria->compare('make.Make',$this->Make_ID, true);
		$criteria->with = array('make'=>array('select'=>'make.Make','together'=>true));
		
		
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/*'sort'=>array('defaultOrder'=>'make.Make ASC'),*/'pagination'=>array('pageSize'=>20,)
		));
	}
	
	public function getModels($makeID)
	{
		$qry = 'SELECT Model_ID, Model from ma_model where Make_ID ='.$makeID;
		$data = Yii::app()->db->createCommand($qry)->queryAll();
		return $data;
		
	}

    public function getLastInsertedModel($modelID)
    {
        $cri = new CDbCriteria();
        $cri->select="Model_ID, Model";
        $cri->condition="Model_ID = $modelID";
        $array = $this->findAll($cri);
        return $array;
    }
}