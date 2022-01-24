<?php

/**
 * This is the model class for table "dashboard_permission".
 *
 * The followings are the available columns in table 'dashboard_permission':
 * @property integer $ID
 * @property integer $Role_ID
 * @property integer $Dashboard_Item_ID
 */
class DashboardPermission extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DashboardPermission the static model class
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
            return 'dashboard_permission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('Dashboard_Item_ID', 'required'),
                array('Role_ID, Dashboard_Item_ID', 'numerical', 'integerOnly'=>true),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('ID, Role_ID, Dashboard_Item_ID', 'safe', 'on'=>'search'),
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
                    'role' => array(self::BELONGS_TO, 'Role', 'Role_ID'),
            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'ID' => 'ID',
                'Role_ID' => 'Role',
                'Dashboard_Item_ID' => 'Dashboard Item',
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

            $criteria->compare('ID',$this->ID);
            $criteria->compare('Role_ID',$this->Role_ID);
            $criteria->compare('Dashboard_Item_ID',$this->Dashboard_Item_ID);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
        
      
        
        public function removeDashboardPermissions($roleID) 
        {
            $cmd = "delete from dashboard_permission where Role_ID=$roleID";
            $delete =Yii::app()->db->createCommand($cmd)->execute();

            return true;
        }
        
        
        // used by dashbaordPermission/_form.php
        public function getDashboardPermissionArray($roleID,$itemID) 
        {
            $criteria=new CDbCriteria;
            $criteria->select = "Dashboard_Item_ID";
            $criteria->condition = "Role_ID=$roleID and Dashboard_Item_ID =$itemID";
            
            $arr = $this->findAll($criteria);
            
            
            return $arr;
        }
        
        // used in Notifications model
        public function getNotificationPermissionArray($roleID, $item) 
        {
            $criteria=new CDbCriteria;
            $criteria->select = "di.Dashboard_Item_Name as Dashboard_Item_ID";
            $criteria->join = "inner join dashboard_items di on di.Dashboard_Item_ID = t.Dashboard_Item_ID";
            $criteria->condition = "t.Role_ID=$roleID and di.Dashboard_Item_Name='$item'";
            
            $arr = $this->findAll($criteria);

            return $arr;
        }
}