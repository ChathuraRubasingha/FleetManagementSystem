<?php

/**
 * This is the model class for table "battery_details".
 *
 * The followings are the available columns in table 'battery_details':
 * @property integer $Battery_Details_ID
 * @property string $Vehicle_No
 * @property integer $Driver_ID
 * @property integer $Battery_Type_ID
 * @property string $Approved_By
 * @property string $Approved_Date
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaBatteryType $batteryType
 * @property MaVehicleRegistry $vehicleNo
 * @property MaDriver $driver
 */
class TRBatteryDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRBatteryDetails the static model class
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
		return 'battery_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Vehicle_No, Driver_ID, Battery_Type_ID, Quantity', 'required'),
			array('Driver_ID, Battery_Type_ID, Quantity', 'numerical', 'integerOnly'=>true),
			array('Cost, Life_Time', 'numerical'),
			array('Vehicle_No', 'length', 'max'=>20),
			array('Approved_By', 'length', 'max'=>100),
			array('add_by, add_date, edit_by, edit_date', 'length', 'max'=>50),
			array('Approved_Status, Status_Reason, Life_Time, Replace_Status, Replace_Date, Request_Date, Remarks, Meter_Reading', 'safe'),
			// The following rule is used by search().
			//array('Cost', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),
			
			// Please remove those attributes that should not be searched.
			array('Meter_Reading, Battery_Details_ID, Vehicle_No, Driver_ID, Cost, Battery_Type_ID, Request_Date, Approved_By, Approved_Date, add_by, add_date, edit_by, edit_date, Replace_Status, Replace_Date, Status_Reason', 'safe', 'on'=>'search'),
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
			'batteryType' => array(self::BELONGS_TO, 'MaBatteryType', 'Battery_Type_ID'),
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
			'driver' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            $userRole = Yii::app()->getModule('user')->user()->Role_ID;
            if($userRole !=='3')
            {
                return array(
                    'Battery_Details_ID' => 'Request ID',
                    'Vehicle_No' => 'Vehicle No',
                    'Driver_ID' => 'Driver Name',
                    'Battery_Type_ID' => 'Battery Type',
                    'Quantity' => 'Quantity',
                    'Remarks' => 'Remarks',
                    'Meter_Reading' => 'Meter Reading',
                    'Request_Date' =>'Request Date',
                    'Approved_By' => 'Approved By',
                    'Approved_Date' => 'Approved Date',
                    'Replace_Status' => 'Replace Status',
                    'Replace_Date' => 'Replaced Date',
                    'Approved_Status' => 'Approved Status',
                    'Life_Time' => 'Life Time (Months)',
                    'Cost' => 'Cost (Rs.)',
                    'add_by' => 'Add By',
                    'add_date' => 'Add Date',
                    'edit_by' => 'Edit By',
                    'edit_date' => 'Edit Date',
                );
            }
            else
            {
                return array(
                    'Battery_Details_ID' => 'අයදුම් අංකය',
                    'Vehicle_No' => 'වාහන අංකය',
                    'Driver_ID' => 'රියැදුරු',
                    'Battery_Type_ID' => 'බැටරි වර්ගය ',
					'Quantity' => 'ප්‍රමාණය',
					'Remarks' => 'සටහන්',
					'Meter_Reading' => 'මීටර කියවීම',
                    'Request_Date' =>'අයදුම් කළ දිනය ',
                    'Approved_By' => 'අනුමත කළේ',
                    'Approved_Date' => 'අනුමත කළ දිනය',
                    'Replace_Status' => 'ප්‍රතිස්ථාපන තත්ත්වය',
                    'Replace_Date' => 'ප්‍රතිස්ථාපිත දිනය',
                    'Approved_Status' => 'අනුමත තත්ත්වය',
                    'Life_Time' => 'බැටරි ආයු කාලය (මාස)',
                    'Cost' => 'වටිනාකම (රු.)',
                    'add_by' => 'ඇතුලත් කළේ ',
                    'add_date' => 'ඇතුලත් කළ දිනය',
                    'edit_by' => 'යාවත්කාලීන කළේ ',
                    'edit_date' => 'යාවත්කාලීන කළ දිනය ',

                );
            }
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

            $criteria->compare('Battery_Details_ID',$this->Battery_Details_ID);
            $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
            $criteria->compare('Driver_ID',$this->Driver_ID);
            $criteria->compare('Battery_Type_ID',$this->Battery_Type_ID);
            $criteria->compare('Approved_By',$this->Approved_By,true);
            $criteria->compare('Approved_Date',$this->Approved_Date,true);
            $criteria->compare('Replace_Status',$this->Replace_Status,true);
            $criteria->compare('Replace_Date',$this->Replace_Date,true);
            $criteria->compare('Approved_Status',$this->Approved_Status,true);
            $criteria->compare('Life_Time',$this->Life_Time,true);
            $criteria->compare('Cost',$this->Cost,true);
            $criteria->compare('add_by',$this->add_by,true);
            $criteria->compare('add_date',$this->add_date,true);
            $criteria->compare('edit_by',$this->edit_by,true);
            $criteria->compare('edit_date',$this->edit_date,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
	
	
	
	public function getPendingBatteryRequestsDashBoard()
	{
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;

            $criteria=new CDbCriteria;

            if($superUser != 1)
            {
                $criteria->select = 't.Battery_Details_ID, t.Vehicle_No,t.Driver_ID, t.Battery_Type_ID';
                $criteria->join = 'inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No ';
                $criteria->condition = 't.Approved_Status = "Pending" and vl.Current_Location_ID = '.$locID;
			
            }
            else
            {
                $criteria->compare('Approved_Status','Pending');
            }

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>array('pageSize'=>30),
            ));
	}
	
	public function getBatteryReplacementHistory()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $userName = Yii::app()->getModule('user')->user()->username;

            $vehicleId = Yii::app()->session['maintenVehicleId'];
            $criteria=new CDbCriteria;
            //$criteria->compare('add_by',$userName);

            $criteria->compare('Vehicle_No',$vehicleId);

            //$criteria->compare('Approved_Status','Approved');
            //$criteria->compare('Replace_Status','Replaced');

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'sort'=>array(
                'defaultOrder'=>'Battery_Details_ID ASC',
                ),	
            ));
	}
	
	public function getPendingBatteryReplacements()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $vehicleId = Yii::app()->session['maintenVehicleId'];
            $criteria=new CDbCriteria;

            $criteria->compare('Vehicle_No',$vehicleId);
            $criteria->compare('Approved_Status','Approved');
            $criteria->compare('Replace_Status','Pending');

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
	}
	
	public function getPendingBatteryReplacementsDashBoard()
	{
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $current_user=Yii::app()->user->name;

            $criteria=new CDbCriteria;
		
            /*if ($superUser != 1)
            {
                    $criteria->compare('Approved_Status','Approved');
                    $criteria->compare('Replace_Status','Pending');
                    //$criteria->compare('Approved_By',$current_user);
            }
            else
            {
                    $criteria->compare('Approved_Status','Approved');
                    $criteria->compare('Replace_Status','Pending');
            }*/

            if($superUser != 1)
            {
                //$criteria->select = 't.Battery_Details_ID, t.Vehicle_No,t.Driver_ID, t.Battery_Type_ID';
                $criteria->join = 'inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No ';
                $criteria->condition = 't.Approved_Status = "Approved" and t.Replace_Status ="Pending" and vl.Current_Location_ID = '.$locID;

            }
            else
            {
                $criteria->compare('Approved_Status','Approved');
                $criteria->compare('Replace_Status','Pending');
            }

            //$criteria->compare('Vehicle_No',$vehicleId);
		

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>array('pageSize'=>30),
            ));
	}
		
	public function approve($batterydetailsid)
	{
            $user = Yii::app()->getModule('user')->user()->username;
            $appDate = MaVehicleRegistry::model()->getServerDate("dateTime");
            $data = TRBatteryDetails::model()->updateByPk($batterydetailsid, array("Approved_Status"=>"Approved", "Approved_By"=>"$user", "Approved_Date"=>"$appDate"));

            return true;
	}
	
	public function disapprove($batterydetailsid, $reason)
	{
            $user = Yii::app()->getModule('user')->user()->username;
            $appDate = MaVehicleRegistry::model()->getServerDate("DateTime");
            $data = TRBatteryDetails::model()->updateByPk($batterydetailsid, array("Approved_Status"=>"Disapproved", "Status_Reason"=>"$reason", "Replace_Status"=>"-", "Approved_By"=>"$user", "Approved_Date"=>"$appDate"));

            return true;
	}
	
	public function reject($batterydetailsid, $reason)
	{
            $user = Yii::app()->getModule('user')->user()->username;
            $appDate = MaVehicleRegistry::model()->getServerDate("DateTime");
            $data = TRBatteryDetails::model()->updateByPk($batterydetailsid, array("Approved_Status"=>"Rejected", "Status_Reason"=>"$reason", "Replace_Status"=>"-", "Approved_By"=>"$user", "Approved_Date"=>"$appDate"));

            return true;
	}
	
	public function canceled($batterydetailsid)
	{
		//$data = "UPDATE battery_details SET Approved_Status = 'Disapproved' WHERE Battery_Details_ID = ".$batterydetailsid." ";

		//$rawData = Yii::app()->db->createCommand($data)->execute();
		
		return true;
	}
	
	
	
	public function replaced($batterydetailsid)
	{
		$data = "UPDATE battery_details SET Replace_Status = 'Replaced' WHERE Battery_Details_ID = ".$batterydetailsid." ";

		$rawData = Yii::app()->db->createCommand($data)->execute();
		
		return true;
	}
	
	public function getBatteryType($batteryType)
	{
		$data = "SELECT Battery_Type FROM ma_battery_type WHERE Battery_Type_ID = '".$batteryType."'";
		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		
		return $rawData;
	}
	
	public function getPendingBatteryRequests()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria=new CDbCriteria;
		$userName = Yii::app()->getModule('user')->user()->username;
		//$criteria->compare('add_by',$userName);		
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Approved_Status','Pending');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getApprovedBatteryRequests()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria=new CDbCriteria;
		$userName = Yii::app()->getModule('user')->user()->username;
		//$criteria->compare('add_by',$userName);
		
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Approved_Status','Approved');
		$criteria->compare('Replace_Status','Pending');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getDisapprovedBatteryRequests()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria=new CDbCriteria;
		$userName = Yii::app()->getModule('user')->user()->username;
		//$criteria->compare('add_by',$userName);
		
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Approved_Status','Disapproved');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getCompletedBatteryRequests()
	{
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria=new CDbCriteria;
		$userName = Yii::app()->getModule('user')->user()->username;
		//$criteria->compare('add_by',$userName);
		
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Approved_Status','Approved');
		$criteria->compare('Replace_Status','Replaced');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getRejectedBatteryRequests()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria=new CDbCriteria;
		//$userName = Yii::app()->getModule('user')->user()->username;
		//$criteria->compare('add_by',$userName);
		
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Approved_Status','Rejected');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getReplacedBatteryRequests()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria=new CDbCriteria;
		$userName = Yii::app()->getModule('user')->user()->username;
		//$criteria->compare('add_by',$userName);
		
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Replace_Status','Replaced');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getDrivers()
	{ 
		$LocId = (Yii::app()->getModule('user')->user()->Location_ID);
		$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		
		if ($superuserstatus != 1)
		{
			$data = "SELECT Driver_ID, Full_Name FROM ma_driver WHERE Location_ID=".$LocId;
		}
		else
		{
			$data = "select d.Driver_ID, d.Full_Name, l.Location_Name from ma_driver d inner join ma_location l on d.Location_ID = l.Location_ID";
		}
		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		return $rawData;
	}
        
        public function DashboardPendingBatteryRequests($superuserstatus,$locID) 
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and vl.Current_Location_ID =$locID";
            }
            $cri1 = new CDbCriteria();
            $cri1->select="count(Battery_Details_ID) as Battery_Details_ID";
            $cri1->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
            $conditon1 = "t.Approved_Status = 'Pending'"."$condition";
            $cri1->condition=$conditon1;
            $Array1 = $this->findAll($cri1);
            $countPendingBatteryReplacementRequests=0;
            if (count($Array1) > 0)
            {
                $countPendingBatteryReplacementRequests = $Array1[0]['Battery_Details_ID'];
            }
            
            return $countPendingBatteryReplacementRequests;
        }
        
        public function DashboardApprovedBatteryRequests($superuserstatus,$locID) 
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and vl.Current_Location_ID =$locID";
            }
            $cri2 = new CDbCriteria();
            $cri2->select="count(Battery_Details_ID) as Battery_Details_ID";
            $cri2->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
            $cri2->condition="Approved_Status = 'Approved' AND Replace_Status = 'Pending'".$condition;
            $Array2 = $this->findAll($cri2);
            $countApprovedBatteryReplacements=0;
            if (count($Array2) > 0)
            {
                $countApprovedBatteryReplacements = $Array2[0]['Battery_Details_ID'];
            }
            
            return $countApprovedBatteryReplacements;
        }
}