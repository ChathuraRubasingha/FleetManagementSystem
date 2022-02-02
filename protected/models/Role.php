<?php

/**
 * This is the model class for table "ma_role".
 *
 * The followings are the available columns in table 'ma_role':
 * @property integer $Role_ID
 * @property string $Role
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaUser[] $maUsers
 */
class Role extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Role the static model class
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
		return 'ma_role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Role', 'required'),
			array('Role', 'length', 'max'=>200),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			array('Role', 'unique'),
			
			array('Role', 'match', 'pattern'=>'/^([0-9A-Za-z ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Role_ID, Role, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'maUsers' => array(self::HAS_MANY, 'MaUser', 'Role_ID'),
			'users' => array(self::HAS_MANY, 'User', 'Role_ID'),
			//'DashboardPermission' => array(self::HAS_MANY, 'DashboardPermission', 'Role_ID'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Role_ID' => 'Role ID',
			'Role' => 'Role',
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

		$criteria->compare('Role_ID',$this->Role_ID);
		$criteria->compare('Role',$this->Role,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=>array('pageSize'=>20), 'sort'=>array('defaultOrder'=>'t.Role ASC')
		));
	}
	
	public function findRole()
	{
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            
            $criteria=new CDbCriteria;

            $criteria->select = array('Role_ID', 'Role');
            if($superUser != '1')
            {
                $criteria->condition = "Role_ID <> 7";
            }
            $criteria->order = "Role ASC";

            $arr = $this->findAll($criteria);
            return $arr;
            //$criteria->compare('Role',$this->Role,true);
	}
}