<?php

/**
 * This is the model class for table "ma_vehicle_category".
 *
 * The followings are the available columns in table 'ma_vehicle_category':
 * @property integer $Vehicle_Category_ID
 * @property string $Category_Name
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property BookingRequest[] $bookingRequests
 * @property MaVehicleRegistry[] $maVehicleRegistries
 */
class VehicleCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VehicleCategory the static model class
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
		return 'ma_vehicle_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Category_Name', 'required'),
			array('Category_Name', 'length', 'max'=>200),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),		
			array('Category_Name', 'unique'),
			
			array('Category_Name', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Vehicle_Category_ID, Category_Name, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'bookingRequests' => array(self::HAS_MANY, 'BookingRequest', 'Vehicle_Category_ID'),
			'maVehicleRegistries' => array(self::HAS_MANY, 'MaVehicleRegistry', 'Vehicle_Category_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'Vehicle_Category_ID' => 'Vehicle Category',
            'Category_Name' => 'Category Name',
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

        $criteria->compare('Vehicle_Category_ID',$this->Vehicle_Category_ID);
        $criteria->compare('Category_Name',$this->Category_Name,true);
        $criteria->compare('add_by',$this->add_by,true);
        $criteria->compare('add_date',$this->add_date,true);
        $criteria->compare('edit_by',$this->edit_by,true);
        $criteria->compare('edit_date',$this->edit_date,true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,'sort'=>array('defaultOrder'=>'Category_Name ASC'),'pagination'=>array('pageSize'=>20,)
        ));
    }
	
    public function getVehicleCatForCategoryReport()
    {
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        if ($superuserstatus != 1)
        {
            $data = "SELECT distinct vc.Vehicle_Category_ID, vc.Category_Name FROM ma_vehicle_category vc
                INNER JOIN ma_vehicle_registry vr on vr.Vehicle_Category_ID = vc.Vehicle_Category_ID
                INNER JOIN vehicle_location vl on vl.Vehicle_No = vr.Vehicle_No
                WHERE vl.Current_Location_ID =$LocId";
        }
        else
        {
            $data = "SELECT Vehicle_Category_ID, Category_Name FROM ma_vehicle_category WHERE Category_Name != 'Any Vehicle'";
        }

        $rawData = Yii::app()->db->createCommand($data)->queryAll();

        return $rawData;
    }
        
        
	
    public function findAllCategories()
    {
        $userLoc = Yii::app()->getModule("user")->user()->Location_ID;
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
        $criteria = new CDbCriteria;
        $criteria->select=array("t.Vehicle_Category_ID, t.Category_Name");
        if ($superuserstatus != 1)
        {
            $criteria->join="inner join ma_vehicle_registry vr on vr.Vehicle_Category_ID = t.Vehicle_Category_ID inner join vehicle_location vl on vl.Vehicle_No = vr.Vehicle_No";
            $criteria->condition="vr.Allocation_Type_ID =2 and vl.Current_Location_ID =$userLoc";
        }
        else
        {
           /* $criteria->join="inner join ma_vehicle_registry vr on vr.Vehicle_Category_ID = t.Vehicle_Category_ID inner join vehicle_location vl on vl.Vehicle_No = vr.Vehicle_No";
            $criteria->condition="vr.Allocation_Type_ID =2 and vl.Current_Location_ID =$userLoc";*/
        }

        $data =VehicleCategory::model()->findAll($criteria);
          return $data;


    }
        
        //used in vehicle registry form
    public function findAllVehicleCategories()
    {
        $data = Yii::app()->db->createCommand('SELECT distinct vr.Vehicle_Category_ID, vc.Category_Name FROM ma_vehicle_registry vr
        inner join  ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
        ORDER BY Category_Name ASC')->queryAll();
        return $data;
    }
    
    public function findCategoriesForBooking()
    {
        $userLoc = Yii::app()->getModule("user")->user()->Location_ID;
        $data = Yii::app()->db->createCommand("SELECT distinct vr.Vehicle_Category_ID, vc.Category_Name 
FROM ma_vehicle_registry vr
INNER JOIN  ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
INNER JOIN vehicle_location vl on vl.Vehicle_No = vr.Vehicle_No
WHERE vl.Current_Location_ID = '$userLoc'
ORDER BY Category_Name ASC")->queryAll();
        return $data;
    }

    public function getLastInsertedCategory($vCatID)
    {
        $cri = new CDbCriteria();
        $cri->select="Vehicle_Category_ID, Category_Name";
        $cri->condition="Vehicle_Category_ID = $vCatID";
        $array = $this->findAll($cri);
        return $array;
    }
}