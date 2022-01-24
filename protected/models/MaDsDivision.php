<?php

/**
 * This is the model class for table "ma_ds_division".
 *
 * The followings are the available columns in table 'ma_ds_division':
 * @property integer $DS_Division_ID
 * @property string $DS_Division
 * @property integer $District_ID
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaDistrict $district
 * @property MaGnDivision[] $maGnDivisions
 * @property MaLocation[] $maLocations
 */
class MaDsDivision extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaDsDivision the static model class
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
		return 'ma_ds_division';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DS_Division, District_ID', 'required'),
			array('District_ID', 'numerical', 'integerOnly'=>true),
			array('DS_Division', 'length', 'max'=>200),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date, district.District_Name', 'safe'),
			array('DS_Division', 'unique'),
			
			array('DS_Division','match','pattern'=>'/^([A-Za-z -\/])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('DS_Division_ID, DS_Division, District_ID, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
                'district' => array(self::BELONGS_TO, 'MaDistrict', 'District_ID'),
                'maGnDivisions' => array(self::HAS_MANY, 'MaGnDivision', 'DS_Division_ID'),
                'maLocations' => array(self::HAS_MANY, 'MaLocation', 'DS_Division_ID'),
            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'DS_Division_ID' => 'DS Division',
                'DS_Division' => 'DS Division',
                'District_ID' => 'District',
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

            $criteria=new CDbCriteria(array('order'=>'district.District_Name ASC, t.DS_Division ASC'));

            $criteria->compare('t.DS_Division_ID',$this->DS_Division_ID);
            $criteria->compare('t.DS_Division',$this->DS_Division,true);
            //$criteria->compare('t.District_ID',$this->District_ID);
            $criteria->with = array('district');
            $criteria->compare('district.District_Name ',$this->District_ID,true); // user (the filter will set user_id)

            $criteria->compare('t.add_by',$this->add_by,true);
            $criteria->compare('t.add_date',$this->add_date,true);
            $criteria->compare('t.edit_by',$this->edit_by,true);
            $criteria->compare('t.edit_date',$this->edit_date,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria/*, 'sort'=>array('defaultOrder'=>'district.District_Name ASC')*/,'pagination'=>array('pageSize'=>20,)
            ));
	}
	
        // use -> MaLocation-_form.php and .....ukn
	public function getDsDiv($id)
	{
		$data = Yii::app()->db->createCommand('select DS_Division_ID, DS_Division from ma_ds_division where District_ID ="'.$id.'" ORDER BY DS_Division ASC')->queryAll();
		return $data;
	}
	
	public function findAllDsDivisions()
	{
		$data = Yii::app()->db->createCommand('SELECT DS_Division_ID, DS_Division FROM ma_ds_division ORDER BY DS_Division ASC')->queryAll();
		return $data;
	}
        
        public function getLastInsertedDsDiv($dsDivID)
        {
            $cri = new CDbCriteria();
            $cri->select="DS_Division_ID, DS_Division";
            $cri->condition="DS_Division_ID = $dsDivID";
            $array = $this->findAll($cri);
            return $array;
        }
	
	
}