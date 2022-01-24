<?php

/**
 * This is the model class for table "fuel_request_details".
 *
 * The followings are the available columns in table 'fuel_request_details':
 * @property integer $Fuel_Request_ID
 * @property string $Vehicle_No
 * @property string $Required_Fuel_Capacity
 * @property integer $Driver_ID
 * @property string $Request_Date
 * @property string $Fuel_Balance
 * @property integer $Meter_Reading
 * @property string $Approve_Status
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaDriver $driver
 * @property MaVehicleRegistry $vehicleNo
 */
class TRFuelRequestDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRFuelRequestDetails the static model class
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
		return 'fuel_request_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('Vehicle_No, Required_Fuel_Capacity, Driver_ID, Request_Date, Fuel_Balance,Fuel_Balance_Range, Meter_Reading, Approve_Status', 'required'),
                array('Driver_ID', 'numerical', 'integerOnly'=>true),
                array('Vehicle_No', 'length', 'max'=>20),
                array('Required_Fuel_Capacity', 'length', 'max'=>4),
                array('Fuel_Balance', 'length', 'max'=>10),
                array('Approve_Status', 'length', 'max'=>10),
                array('Fuel_Balance, Meter_Reading, Required_Fuel_Capacity','match','pattern'=>'/^(?!0\d|$)\d+(\.\d+)?$/'),
                array('Reason, Status_Reason', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20})+$/'),
                array('Approved_By', 'length', 'max'=>100),
                array('add_by, edit_by, edit_date', 'length', 'max'=>50),
                array('Status_Reason', 'safe'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('Fuel_Request_ID, Vehicle_No, Required_Fuel_Capacity, Driver_ID, Request_Date, Reason, Fuel_Balance, Fuel_Balance_Range, Meter_Reading,Previous_Distance_Driven, Approve_Status, Status_Reason,Approved_By, Approved_date, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'driver' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
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
                    'Fuel_Request_ID' => 'Fuel Request',
                    'Vehicle_No' => 'Vehicle No',
                    'Required_Fuel_Capacity' => 'Required Fuel Capacity (l)',
                    'Driver_ID' => 'Driver',
                    'Request_Date' => 'Request Date',
                    'Reason' => 'Reason',
                    'Fuel_Balance' => 'Fuel Balance (l)',
                    'Fuel_Balance_Range' =>'Fuel Balance (Tank based)',
                    'Meter_Reading' => 'Meter Reading',
                    'Approve_Status' => 'Approve Status',
                    'Approved_By' => 'Approve By',
                    'Approved_Date' => 'Approved Date',
                    'add_by' => 'Add By',
                    'add_date' => 'Add Date',
                    'edit_by' => 'Edit By',
                    'edit_date' => 'Edit Date',
                );
            }
            else
            {
                return array(
                    'Fuel_Request_ID' => 'Fuel Request',
                    'Vehicle_No' => 'වාහන අංකය',
                    'Required_Fuel_Capacity' => 'අවශ්‍ය ඉන්දන පරිමාව(ලීටර්) ',
                    'Driver_ID' => 'රියැදුරු',
                    'Request_Date' => 'අයදුම් කරන දිනය',
                    'Reason' => 'ඉල්ලුම් කරන කාරණය',
                    'Fuel_Balance' => 'දැනට ඉතිරි ඉන්ධන ප්‍රමාණය (ලීටර)',
                    'Fuel_Balance_Range' =>'දැනට ඉතිරි ඉන්ධන ප්‍රමාණය (ටැංකියේ පරිමාවෙන්)',
                    'Meter_Reading' => 'මීටර කියවීම',
                    'Approve_Status' => 'අනුමත තත්ත්වය',
                    'Approved_By' => 'අනුමත කළේ ',
                    'Approved_Date' => 'අනුමත කළ දිනය',
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

		$criteria->compare('Fuel_Request_ID',$this->Fuel_Request_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('Required_Fuel_Capacity',$this->Required_Fuel_Capacity,true);
		$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('Request_Date',$this->Request_Date,true);
		$criteria->compare('Fuel_Balance',$this->Fuel_Balance,true);
		$criteria->compare('Meter_Reading',$this->Meter_Reading);
		$criteria->compare('Approve_Status',$this->Approve_Status,true);
		$criteria->compare('Approved_By',$this->Approved_By,true);
		$criteria->compare('Approved_Date',$this->Approved_Date,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getFuelRequestDetails()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		
		
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		$vehicleId = Yii::app()->session['VehicleIdFuel'];
		$criteria=new CDbCriteria;
		
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Approve_Status','Pending');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getFuelRequestDetailsDashBoard()
	{
		$superUser = Yii::app()->getModule('user')->user()->superuser;
		$locID = Yii::app()->getModule('user')->user()->Location_ID;

		$criteria=new CDbCriteria;
		
		if ($superUser !=1 )
		{
			$criteria->select = 't.Fuel_Request_ID, t.Request_Date,t.Vehicle_No, t.Driver_ID, t.Required_Fuel_Capacity, t.Fuel_Balance, t.Meter_Reading';
			$criteria->join = 'inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No ';
            $criteria->condition = 't.Approve_Status = "Pending" and vl.Current_Location_ID = '.$locID;
		}
		else
		{
			$criteria->compare('Approve_Status','Pending');
		}
		

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>30),
                ));
	}
	
	public function getFuelApprovedList()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		
		
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		$vehicleId = Yii::app()->session['VehicleIdFuel'];
		$criteria=new CDbCriteria;
		
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Approve_Status','Approved');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getFuelApprovedListDashBoard()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		$superUser = Yii::app()->getModule('user')->user()->superuser;
        $locID = Yii::app()->getModule('user')->user()->Location_ID;

        $criteria=new CDbCriteria;

        if ($superUser !=1 )
        {
            $criteria->select = 't.Fuel_Request_ID, t.Request_Date,t.Vehicle_No, t.Driver_ID, t.Required_Fuel_Capacity, t.Fuel_Balance, t.Meter_Reading';
            $criteria->join = 'inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No ';
            $criteria->condition = 't.Approve_Status = "Approved" and vl.Current_Location_ID = '.$locID;
        }
        else
        {
            $criteria->compare('Approve_Status','Approved');
        }

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>30),
                ));
	}
	
	public function canceled($tyreDetailsId)
	{
		return true;
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
			#$data = "SELECT Driver_ID, Full_Name FROM ma_driver";
			$data = "select d.Driver_ID, d.Full_Name, l.Location_Name from ma_driver d inner join ma_location l on d.Location_ID = l.Location_ID";
		}
		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		return $rawData;
	}
	
	public function approve($requestid)
	{
            $user = Yii::app()->getModule('user')->user()->username;		
            $appDate = MaVehicleRegistry::model()->getServerDate("DateTime");
            $data = TRFuelRequestDetails::model()->updateByPk($requestid, array("Approve_Status"=>"Approved", "Approved_By"=>"$user", "Approved_Date"=>"$appDate"));

            return true;
	}
	
	public function disapprove($requestid, $reason)
	{
            $appDate = MaVehicleRegistry::model()->getServerDate("DateTime");
            $user = Yii::app()->getModule('user')->user()->username;
            $data = TRFuelRequestDetails::model()->updateByPk($requestid, array("Approve_Status"=>"Disapproved", "Status_Reason"=>"$reason", "Approved_By"=>"$user", "Approved_Date"=>"$appDate"));

            return true;
	}
	
	public function reject($requestid, $reason)
	{
            $appDate = MaVehicleRegistry::model()->getServerDate("DateTime");
            $user = Yii::app()->getModule('user')->user()->username;
            $data = TRFuelRequestDetails::model()->updateByPk($requestid, array("Approve_Status"=>"Rejected", "Status_Reason"=>"$reason", "Approved_By"=>"$user", "Approved_Date"=>"$appDate"));

            return true;
	}
	
	public function getLastFuelReading($opt)
	{	
		$vid = Yii::app()->session['VehicleIdFuel'];
		//echo $vid;exit;
		if ($opt==1)
		{
                    $data = "SELECT Meter_Reading, Required_Fuel_Capacity, Fuel_Balance FROM fuel_request_details WHERE(Fuel_Request_ID =(SELECT MAX(Fuel_Request_ID) AS maxv
			FROM fuel_request_details 
			WHERE (Vehicle_No ='".$vid."' and Approve_Status = 'Approved')))";
		}
		else
		{
                    $data = "SELECT Meter_Reading, Required_Fuel_Capacity, Fuel_Balance FROM fuel_request_details WHERE (Fuel_Request_ID =(SELECT Fuel_Request_ID FROM fuel_request_details WHERE Vehicle_No= '".$vid."' and Approve_Status='Approved' ORDER BY Fuel_Request_ID DESC LIMIT 1 , 1))";
                    
		}
		//echo $data; exit;		
		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		//echo $rawData; exit;
		//print_r($rawData); exit;
		return $rawData;
		
	}
	
	
	public function getPendingFuelRequests()
	{
		$vehicleId = Yii::app()->session['VehicleIdFuel'];
		$criteria=new CDbCriteria;
                /*if(Yii::app()->getModule('user')->user()->superuser != '1')
                {
                    $userName = Yii::app()->getModule('user')->user()->username;
                    $criteria->compare('add_by',$userName);	
                }*/
		
		$criteria->compare('Vehicle_No',$vehicleId);
		#$criteria->compare('User_ID',$userID);
		$criteria->compare('Approve_Status','Pending',true);		
		return new CActiveDataProvider($this, array(
            	'criteria' => $criteria,
				'pagination' => array('pageSize'=>30),
            	'sort'=>array(
                'defaultOrder'=>'Request_Date DESC',
            	),	
		));
	}
	
	public function getApprovedFuelRequests($vehicleId)
	{
		$vehicleId = Yii::app()->session['VehicleIdFuel'];
		$criteria=new CDbCriteria;
		$userName = Yii::app()->getModule('user')->user()->username;
		//$criteria->compare('add_by',$userName);	
		$criteria->compare('Vehicle_No',$vehicleId);
		#$criteria->compare('User_ID',$userID);
		$criteria->compare('Approve_Status','Approved');		
		return new CActiveDataProvider($this, array(
            	'criteria' => $criteria,
				'pagination' => array('pageSize'=>30),
            	'sort'=>array(
                'defaultOrder'=>'Request_Date DESC',
            	),	
		));
	}
	
	public function getDisapprovedFuelRequests()
	{
		$vehicleId = Yii::app()->session['VehicleIdFuel'];
		$criteria=new CDbCriteria;
		$userName = Yii::app()->getModule('user')->user()->username;
		//$criteria->compare('add_by',$userName);	
		$criteria->compare('Vehicle_No',$vehicleId);
		#$criteria->compare('User_ID',$userID);
		$criteria->compare('Approve_Status','Disapproved',true);		
		return new CActiveDataProvider($this, array(
            	'criteria' => $criteria,
				'pagination' => array('pageSize'=>30),
            	'sort'=>array(
                'defaultOrder'=>'Request_Date DESC',
            	),	
		));
	}
	
	public function getCompletedFuelRequests()
	{
		$vehicleId = Yii::app()->session['VehicleIdFuel'];
		$criteria=new CDbCriteria;
		$userName = Yii::app()->getModule('user')->user()->username;
		//$criteria->compare('add_by',$userName, true);	
		$criteria->compare('Vehicle_No',$vehicleId, true);
		#$criteria->compare('User_ID',$userID);
		$criteria->compare('Approve_Status','Completed',true);		
		return new CActiveDataProvider($this, array(
            	'criteria' => $criteria,
				'pagination' => array('pageSize'=>30),
            	'sort'=>array(
                'defaultOrder'=>'Request_Date DESC',
            	),	
		));
	}
	
	public function getRejectedFuelRequests()
	{
		$vehicleId = Yii::app()->session['VehicleIdFuel'];
		$criteria=new CDbCriteria;
		$userName = Yii::app()->getModule('user')->user()->username;
		//$criteria->compare('add_by',$userName, true);	
		$criteria->compare('Vehicle_No',$vehicleId, true);
		#$criteria->compare('User_ID',$userID);
		$criteria->compare('Approve_Status','Rejected',true);		
		return new CActiveDataProvider($this, array(
            	'criteria' => $criteria,
				'pagination' => array('pageSize'=>30),
            	'sort'=>array(
                'defaultOrder'=>'Request_Date DESC',
            	),	
		));
	}
        
        public function DashboardPendingFuelRequests($superuserstatus,$locID) 
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and vl.Current_Location_ID =$locID";
            }
            $cri5 = new CDbCriteria();
            $cri5->select="count(Fuel_Request_ID) as Fuel_Request_ID";
            $cri5->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
            $cri5->condition="Approve_Status = 'Pending'".$condition;
            $Array5 = $this->findAll($cri5);

            $countPendingFuelRequests = 0;
            if (count($Array5) > 0)
            {
                $countPendingFuelRequests = $Array5[0]['Fuel_Request_ID'];
            }
            
            return $countPendingFuelRequests;
        }
        
        public function DashboardApprovedFuelRequests($superuserstatus,$locID) 
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and vl.Current_Location_ID =$locID";
            }
            
            $cri6 = new CDbCriteria();
            $cri6->select="count(Fuel_Request_ID) as Fuel_Request_ID";
            $cri6->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
            $cri6->condition="Approve_Status = 'Approved'".$condition;
            $Array6 = $this->findAll($cri6);

            $countApprovedFuelRequests = 0;
            if (count($Array6) > 0)
            {
                $countApprovedFuelRequests = $Array6[0]['Fuel_Request_ID'];
            }
            
            return $countApprovedFuelRequests;
        }
	
	
	
}