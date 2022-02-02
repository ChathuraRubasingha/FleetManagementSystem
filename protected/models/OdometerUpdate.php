<?php

/**
 * This is the model class for table "odometer_update".
 *
 * The followings are the available columns in table 'odometer_update':
 * @property integer $update_id
 * @property string $Vehicle_No
 * @property integer $Driver_ID
 * @property integer $remark_id
 * @property string $in_time
 * @property string $out_time
 * @property integer $out_odo_reading
 * @property integer $in_odo_reading
 * @property string $added_by
 * @property string $description
 *
 * The followings are the available model relations:
 * @property OdometerUpdateRemark $remark
 * @property MaDriver $driver
 * @property MaVehicleRegistry $vehicleNo
 */
class OdometerUpdate extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return OdometerUpdate the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'odometer_update';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Vehicle_No, Driver_ID, remark_id, out_time, out_odo_reading, added_by', 'required'),
            array('description , in_time, in_odo_reading', 'safe'),
            array('Driver_ID, remark_id, out_odo_reading, in_odo_reading', 'numerical', 'integerOnly' => true),
            array('Vehicle_No, added_by, edit_by', 'length', 'max' => 20),
            array('description', 'length', 'max' => 150),
			//array('description', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
            array('description', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20})+$/'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('update_id, Vehicle_No, Driver_ID, remark_id, in_time, out_time, out_odo_reading, in_odo_reading, added_by, description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'remark' => array(self::BELONGS_TO, 'OdometerUpdateRemark', 'remark_id'),
            'driverid' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
            'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $userRole = Yii::app()->getModule('user')->user()->Role_ID;
        return array(
                'update_id' => 'Update',
                'Vehicle_No' => 'Vehicle No',
                'Driver_ID' => 'Driver',
                'remark_id' => 'Remark',
                'in_time' => 'In Time',
                'out_time' => 'Out Time',
                'out_odo_reading' => 'Out Odo Reading (km)',
                'in_odo_reading' => 'In Odo Reading (km)',
                'added_by' => 'Out Time Added By',
                'edit_by'=>'In Time Added By',
                'description' => 'Description',
            );
        
//        if (($userRole !== '3') && ($userRole !== '4')) {
//
//            return array(
//                'update_id' => 'Update',
//                'Vehicle_No' => 'Vehicle No',
//                'Driver_ID' => 'Driver',
//                'remark_id' => 'Remark',
//                'in_time' => 'In Time',
//                'out_time' => 'Out Time',
//                'out_odo_reading' => 'Out Odo Reading (km)',
//                'in_odo_reading' => 'In Odo Reading (km)',
//                'added_by' => 'Out Time Added By',
//                'edit_by'=>'In Time Added By',
//                'description' => 'Description',
//            );
//        } else {
//
//            return array(
//                'update_id' => 'Update',
//                'Vehicle_No' => 'වාහන අංකය',
//                'Driver_ID' => 'රියැදුරු',
//                'remark_id' => 'සටහන',
//                'in_time' => 'දිනය/වෙලාව දක්වා',
//                'out_time' => 'දිනය/වෙලාව සිට',
//                'out_odo_reading' => 'පිටත් වන විට ඔඩොමීටර කියවීම (කි.මී)',
//                'in_odo_reading' => 'ආපසු පැමිණි විට ඔඩෝමීටර් කියවීම (කි.මී)',
//                'added_by' => 'පිටත්වීම සටහන් කළේ',
//				'edit_by'=>'පැමිණීම සටහන් කළේ ',
//                'description' => 'විස්තරය',
//            );
//        }
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('update_id', $this->update_id);
        $criteria->compare('Vehicle_No', $this->Vehicle_No, true);
        $criteria->compare('Driver_ID', $this->Driver_ID);
        $criteria->compare('remark_id', $this->remark_id);
        $criteria->compare('in_time', $this->in_time, true);
        $criteria->compare('out_time', $this->out_time, true);
        $criteria->compare('out_odo_reading', $this->out_odo_reading);
        $criteria->compare('in_odo_reading', $this->in_odo_reading);
        $criteria->compare('added_by', $this->added_by, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function completedOdo($vehicleId) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
//        var_dump($vehicleId);
        $userRole = Yii::app()->getModule('user')->user()->Role_ID;
        if (($userRole !== '3') && ($userRole !== '4')) {

            $criteria = new CDbCriteria;

            $criteria->compare('update_id', $this->update_id);
           // $criteria->compare('Vehicle_No', $vehicleId, false);
           // $criteria->compare('Driver_ID', $this->Driver_ID);
			$criteria->compare('driverid.Full_Name',$this->Driver_ID, true);
            $criteria->compare('remark_id', $this->remark_id);
           // $criteria->compare('in_time', $this->in_time, true);
            $criteria->compare('out_time', $this->out_time, true);
            $criteria->compare('out_odo_reading', $this->out_odo_reading);
            $criteria->compare('in_odo_reading', $this->in_odo_reading);
            $criteria->compare('added_by', $this->added_by, true);
            $criteria->compare('description', $this->description, true);
			$criteria->condition ="in_time != '0000-00-00 00:00:00' and Vehicle_No='$vehicleId'";
			$criteria->with = array('driverid'=>array('select'=>'driverid.Full_Name', 'together'=>true));
			
			
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria, 'pagination'=>array('pageSize'=>30)
            ));
        } else {
            
                        $criteria = new CDbCriteria;

            $criteria->compare('update_id', $this->update_id);
            $criteria->compare('Vehicle_No', $this->Vehicle_No, true);
           // $criteria->compare('Driver_ID', $this->Driver_ID);
            $criteria->compare('driverid.Full_Name',$this->Driver_ID, true);
            $criteria->compare('remark_id', $this->remark_id);
            $criteria->compare('in_time', $this->in_time, true);
            $criteria->compare('out_time', $this->out_time, true);
            $criteria->compare('out_odo_reading', $this->out_odo_reading);
            $criteria->compare('in_odo_reading', $this->in_odo_reading);
            $criteria->compare('added_by', $this->added_by, true);
            $criteria->compare('description', $this->description, true);
			$criteria->with = array('driverid'=>array('select'=>'driverid.Full_Name', 'together'=>true));
			
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria, 'pagination'=>array('pageSize'=>30)
            ));
        }
    }
	
	 public function getVehicleListLocationWiseForOdo()
	{
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		$loc = Yii::app()->getModule('user')->user()->Location_ID;
		/*$criteria=new CDbCriteria();
		$criteria->select =array("vr.vehicle_No as Vehicle_No, vc.Category_Name as Driver_ID, ma.Make as description, mo.Model as remark_id,t.out_odo_reading as out_odo_reading, t.in_odo_reading as in_odo_reading");
		//$criteria->from = array('( select * from `odometer_update` t order by t.update_id DESC) as t'); 
		$criteria->mergeWith(array('join'=>'right JOIN  ma_vehicle_registry vr ON vr.Vehicle_No = t.Vehicle_No
		inner join ma_vehicle_category vc on vc.Vehicle_Category_ID= vr.Vehicle_Category_ID
		inner join ma_model mo on  mo.Model_ID = vr.Model_ID
		inner join ma_Make ma on ma.Make_ID = vr.Make_ID'));
		$criteria->condition="( select * from `odometer_update` t order by t.update_id DESC) as t";
		$criteria->order="t.update_id DESC";*/
                
                $slctAll = "SELECT t.update_id, vr.vehicle_No as Vehicle_No, vc.Category_Name, ma.Make as Make, mo.Model as Model, t.out_odo_reading, t.in_odo_reading ";
		$slctCount = "SELECT count(vr.vehicle_No) ";
                $frm = " FROM ( select * from `odometer_update` t order by t.update_id DESC) as t ";
                $join = " right JOIN ma_vehicle_registry vr ON vr.Vehicle_No = t.Vehicle_No
                    inner join ma_vehicle_category vc on vc.Vehicle_Category_ID=vr.Vehicle_Category_ID
                    
                    inner join ma_model mo on  mo.Model_ID = vr.Model_ID
                    inner join ma_make ma on ma.Make_ID = vr.Make_ID ";
                $where = "";
                $group = " group by  vr.vehicle_No";
                
                if($superuserstatus !=='1')
                {
                    $join .= " inner join vehicle_location vl on vl.Vehicle_No = vr.Vehicle_No ";   
                    $where .= " where vl.Current_Location_ID = $loc ";
                }
                $countCmd = $slctCount.$frm.$join.$where.$group;
                $cmd = $slctAll.$frm.$join.$where.$group;
                
		$count=Yii::app()->db->createCommand($countCmd)->queryScalar();
		//$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM ma_vehicle_registry')->queryScalar();
                $sql='SELECT Vehicle_No FROM ma_vehicle_registry';
                return new CSqlDataProvider($cmd, array(
                'totalItemCount'=>$count,
                'keyField' => 'Vehicle_No',
                'sort'=>array(	
                    'attributes'=>array(
                         'vehicle_No','Category_Name','Make','Model','out_odo_reading','in_odo_reading'
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>1000,
                ),
));
		
	//return $dataProvider;	
		
	/*	$criteria->mergeWith(array('join'=>'right JOIN  ma_vehicle_registry vr ON vr.Vehicle_No = t.Vehicle_No
		inner join ma_vehicle_category vc on vc.Vehicle_Category_ID= vr.Vehicle_Category_ID
		inner join ma_model mo on  mo.Model_ID = vr.Model_ID
		inner join ma_Make ma on ma.Make_ID = vr.Make_ID','together'=>true));*/
		
//$criteria->group="vr.vehicle_No";
		// $criteria->compare('ou.in_time','0000-00-00 00:00:00',true);  
	

		//return new CActiveDataProvider($this, array(
		//	'criteria'=>$arr, 'pagination'=>array('pageSize'=>30), /*'sort'=>array('defaultOrder'=>'t.Vehicle_No ASC')*/
		//));
	}
}