<?php

/**
 * This is the model class for table "dashboard_items".
 *
 * The followings are the available columns in table 'dashboard_items':
 * @property integer $Dashboard_Item_ID
 * @property string $Dashboard_Item_Name
 * @property string $Display_Name
 * @property string $Url
 * @property integer $Dashboard_Group_ID
 * @property integer $Display_Order
 */
class DashboardItems extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DashboardItems the static model class
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
		return 'dashboard_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Dashboard_Item_Name, Display_Name, Url, Dashboard_Group_ID, Display_Order', 'required'),
			array('Dashboard_Group_ID, Display_Order', 'numerical', 'integerOnly'=>true),
			array('Dashboard_Item_Name, Display_Name, Url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Dashboard_Item_ID, Colour_Class, Dashboard_Item_Name, Display_Name, Url, Dashboard_Group_ID, Display_Order', 'safe', 'on'=>'search'),
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
			'Dashboard_Item_ID' => 'Dashboard Item',
			'Dashboard_Item_Name' => 'Dashboard Item Name',
                        'Colour_Class'=>'Colour_Class',
			'Display_Name' => 'Display Name',
			'Url' => 'Url',
			'Dashboard_Group_ID' => 'Dashboard Group',
			'Display_Order' => 'Display Order',
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

		$criteria->compare('Dashboard_Item_ID',$this->Dashboard_Item_ID);
		$criteria->compare('Dashboard_Item_Name',$this->Dashboard_Item_Name,true);
		$criteria->compare('Display_Name',$this->Display_Name,true);
		$criteria->compare('Url',$this->Url,true);
		$criteria->compare('Dashboard_Group_ID',$this->Dashboard_Group_ID);
		$criteria->compare('Display_Order',$this->Display_Order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getDashboardGroups() 
        {
            $criteria = new CDbCriteria();
            $criteria->select="t.Dashboard_Group_ID, dg.Group_Name as Display_Order, dg.Colour_Class as Url";
            $criteria->join="inner join dashboard_groups dg on dg.Dashboard_Group_ID = t.Dashboard_Group_ID";
            $criteria->group="t.Dashboard_Group_ID";
            
            $arr = $this->findAll($criteria);
            return $arr;
        }
        
        // used by dashboard/_index_bk.php
        // also used by dashboardPermission/_form.php with params($cri=0) ♣♣ as no need of permissions
        public function getDashboardItems($roleID, $groupID,$cri) 
        {
            $criteria = new CDbCriteria();
            $select="t.Dashboard_Item_ID, t.Display_Name, dg.Group_Name as Dashboard_Group_ID";
            $join='inner join dashboard_groups dg on dg.Dashboard_Group_ID = t.Dashboard_Group_ID';
            $condition="t.Dashboard_Group_ID=$groupID";
            if($cri == '0')
            {   
                $group="t.Dashboard_Item_ID";
                $order='';
            }
            else 
            {
                $select .= ", t.Display_Name, t.Url";
                $join  .= " inner join  dashboard_permission dp on dp.Dashboard_Item_ID = t.Dashboard_Item_ID";                
                $condition .=" and dp.Role_ID = $roleID";
                $group = '';
                $order="t.Display_Order";
            }
            $criteria->select = $select;
            $criteria->join=$join;
            $criteria->condition= $condition;
            $criteria->group = $group;
            $criteria->order = $order;
            
            
            $arr = $this->findAll($criteria);
           
            return $arr;
            
        }
        
        // used by notification model
        public function getAllDashboardItems() 
        {
            $criteria = new CDbCriteria();
            $criteria->select="t.Dashboard_Item_Name";
            //$criteria->join="inner join dashboard_items di on di.Dashboard_Item_ID = t.Dashboard_Item_ID";
            
            $arr = $this->findAll($criteria);
            return $arr;
        }
        
}