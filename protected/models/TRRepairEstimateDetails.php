<?php

/**
 * This is the model class for table "repair_estimate_details".
 *
 * The followings are the available columns in table 'repair_estimate_details':
 * @property integer $Estimate_ID
 * @property integer $Request_ID
 * @property string $Vehicle_No
 * @property integer $Garage_ID
 * @property string $Total_Estimate
 * @property string $Estimate_Date
 * @property string $Approved_By
 * @property string $Approved_Date
 * @property string $Estimate_Status
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property RepairRequest $request
 * @property MaGarages $garage
 * @property VehicleRepairDetails[] $vehicleRepairDetails
 */
class TRRepairEstimateDetails extends CActiveRecord
{
    /*
     * Returns the static model of the specified AR class.
     * @return TRRepairEstimateDetails the static model class
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
        return 'repair_estimate_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Request_ID, Garage_ID, Total_Estimate, Estimate_Date', 'required'),
            array('Request_ID, Garage_ID', 'numerical', 'integerOnly'=>true),
            array('Vehicle_No', 'length', 'max'=>20),
            array('Total_Estimate', 'length', 'max'=>150),
            array('Approved_By', 'length', 'max'=>100),
            array('Estimate_Status', 'length', 'max'=>12),
            array('add_by, edit_by, edit_date', 'length', 'max'=>50),
            array('Approved_Date, add_date', 'safe'),

            array('Total_Estimate', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),

            array('Estimate_Date','checkPrevious'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Estimate_ID, Request_ID, Vehicle_No, Garage_ID, Total_Estimate, Estimate_Date, Approved_By, Approved_Date, Estimate_Status, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
        );
    }
    public function checkPrevious()
    {
        $Estimate_Date =$this->Estimate_Date;
        date_default_timezone_set('Asia/Colombo');
        $serverDate = MaVehicleRegistry::model()->getServerDate("date");

        if($Estimate_Date > $serverDate)
        {
            $this->addError('Estimate_Date',"'Estimate Date' should be a Previous Date");
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'request' => array(self::BELONGS_TO, 'TRRepairRequest', 'Request_ID'),
            'garage' => array(self::BELONGS_TO, 'MaGarages', 'Garage_ID'),
            'vehicleRepairDetails' => array(self::HAS_MANY, 'VehicleRepairDetails', 'Estimate_ID'),
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
                'Estimate_ID' => 'Estimate Number',
                'Request_ID' => 'Request Number',
                'Vehicle_No' => 'Vehicle No',
                'Garage_ID' => 'Garage',
                'Total_Estimate' => 'Total Estimate',
                'Estimate_Date' => 'Estimate Date',
                'Approved_By' => 'Approved By',
                'Approved_Date' => 'Approved Date',
                'Estimate_Status' => 'Estimate Status',
                'add_by' => 'Add By',
                'add_date' => 'Add Date',
                'edit_by' => 'Edit By',
                'edit_date' => 'Edit Date',
            );
        }
        else
        {
            return array(
                'Estimate_ID' => 'ඇස්තමේන්තු අංකය ',
                'Request_ID' => 'අයදුම් අංකය',
                'Vehicle_No' => 'වාහන අංකය',
                'Garage_ID' => 'අලුත්වැඩියා කළ ගරාජය',
                'Total_Estimate' => 'සම්පුර්ණ ඇස්තමේන්තු මුදල (රු.)',
                'Estimate_Date' => 'ඇස්තමේන්තු කළ දිනය',
                'Approved_By' => 'අනුමත කළේ',
                'Approved_Date' => 'අනුමත කළ දිනය',
                'Estimate_Status' => 'තක්සේරු තත්ත්වය',
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

        $criteria->compare('Estimate_ID',$this->Estimate_ID);
        $criteria->compare('Request_ID',$this->Request_ID);
        $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
        $criteria->compare('Garage_ID',$this->Garage_ID);
        $criteria->compare('Total_Estimate',$this->Total_Estimate,true);
        $criteria->compare('Estimate_Date',$this->Estimate_Date,true);
        $criteria->compare('Approved_By',$this->Approved_By,true);
        $criteria->compare('Approved_Date',$this->Approved_Date,true);
        $criteria->compare('Estimate_Status',$this->Estimate_Status,true);
        $criteria->compare('add_by',$this->add_by,true);
        $criteria->compare('add_date',$this->add_date,true);
        $criteria->compare('edit_by',$this->edit_by,true);
        $criteria->compare('edit_date',$this->edit_date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function approve($estimateId)
    {
        $repairRequestId = Yii::app()->session['repairRequestId'];

        $user = Yii::app()->getModule('user')->user()->username;
        $approveDate  = MaVehicleRegistry::model()->getServerDate("dateTime");

        $approve = TRRepairEstimateDetails::model()->updateByPk($estimateId, array("Estimate_Status"=>"Approved", "Approved_By"=>"$user", "Approved_Date"=>"$approveDate"));

        return true;
    }

    public function disapprove($estimateId, $reason)
    {
        $user = Yii::app()->getModule('user')->user()->username;		
        $approveDate  = MaVehicleRegistry::model()->getServerDate("dateTime"); //date("Y-m-d : H:i:s", time());
        $repairRequestId = Yii::app()->session['repairRequestId'];

        $disapprove = TRRepairEstimateDetails::model()->updateByPk($estimateId, array("Estimate_Status"=>"Disapproved","Estimate_Status_Reason"=>"$reason", "Approved_By"=>"$user", "Approved_Date"=>"$approveDate" ));


        $reqDis = TRRepairRequest::model()->updateByPk($repairRequestId, array("Request_Status"=>"Disapproved"));                  

        return true;
    }
	
    public function reject($estimateId, $reason)
    {
        $user = Yii::app()->getModule('user')->user()->username;
        $criteria = new CDbCriteria;
        $criteria->select = array('Request_ID');
        $criteria->condition ="Estimate_ID='$estimateId'";
        $reqst = $this->find($criteria);
        if(count($reqst))
        {
            $Request_ID = $reqst->Request_ID;
            $approveDate = MaVehicleRegistry::model()->getServerDate("DateTime");

            $data2 = TRRepairRequest::model()->updateByPk($Request_ID, array("Request_Status"=>"Rejected"));
            $data  = TRRepairEstimateDetails::model()->updateByPk($estimateId, array("Estimate_Status"=>"Rejected", "Estimate_Status_Reason"=>"$reason", "Approved_Date"=>"$approveDate"));

        }
        return true;
    }

    public function canceled($estimateId)
    {
        return true;
    }

    public function getApprovedEstimates()
    {
        $vehicleId = Yii::app()->session['maintenVehicleId'];

        $criteria=new CDbCriteria;

        $criteria->compare('Vehicle_No',$vehicleId);
        $criteria->compare('Estimate_Status','Approved');

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getPendingEstimates()
    {
        $vehicleId = Yii::app()->session['maintenVehicleId'];

        $criteria=new CDbCriteria;

        $criteria->compare('Vehicle_No',$vehicleId);
        $criteria->compare('Estimate_Status','Pending');

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getPendingEstimatesDashBoard()
    {
        $superUser = Yii::app()->getModule('user')->user()->superuser;
        $locID = Yii::app()->getModule('user')->user()->Location_ID;

        $criteria=new CDbCriteria;

        if($superUser != 1)
        {
            $criteria->select = 't.Estimate_ID, t.Vehicle_No,t.Garage_ID, t.Total_Estimate';
            $criteria->join = 'inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No ';
            $criteria->condition = 't.Estimate_Status = "Pending" and vl.Current_Location_ID = '.$locID;
        }
        else
        {
            $criteria->compare('Estimate_Status','Pending');
        }

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>30),
        ));
    }


    public function getApprovedEstimatesDashBoard()
    {
        $superUser = Yii::app()->getModule('user')->user()->superuser;
        $locID = Yii::app()->getModule('user')->user()->Location_ID;
        $roleID = Yii::app()->getModule('user')->user()->Role_ID;
        $current_user=Yii::app()->user->name;

        $criteria=new CDbCriteria;

        if($superUser != 1)
        {
            $criteria->select = 't.Estimate_ID, t.Vehicle_No,t.Garage_ID, t.Total_Estimate';
            $criteria->join = 'inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No ';
            $criteria->condition = 't.Estimate_Status = "Approved" and vl.Current_Location_ID = '.$locID;
        }
        else
        {
            $criteria->compare('Estimate_Status','Approved');
        }

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>30),
        ));
    }
	
    public function getRepairEstimateDetailsHistory()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $vehicleId = Yii::app()->session['maintenVehicleId'];
        $criteria=new CDbCriteria;
        $criteria->compare('Vehicle_No',$vehicleId);
        //$criteria->compare('Approved_Status','Approved');
        //$criteria->compare('Replace_Status','Replaced');

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getRepairEstimateDetails()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $vehicleId = Yii::app()->session['maintenVehicleId'];
        $type = Yii::app()->session['type'];
        $criteria=new CDbCriteria;
        $criteria->compare('Vehicle_No',$vehicleId);
        $criteria->compare('Estimate_Status',$type);

        if(isset(Yii::app()->session['type']) &&( Yii::app()->session['type']!= ''))
        {
            unset(Yii::app()->session['type']);
        }
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getPendingRepairRequests()
    {
        $vehicleId = Yii::app()->session['maintenVehicleId'];
        $criteria=new CDbCriteria;
        $criteria->compare('Vehicle_No',$vehicleId);

        $userID = Yii::app()->getModule('user')->user()->id;

        #$criteria->compare('User_ID',$userID);
        $criteria->compare('Estimate_Status','Pending',true);		
        return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
        'sort'=>array(
            'defaultOrder'=>'Estimate_Date DESC',
            ),	
        ));
    }
	
    public function getApprovedRepairRequests()
    {
        $vehicleId = Yii::app()->session['maintenVehicleId'];
        $criteria=new CDbCriteria;
        $criteria->compare('Vehicle_No',$vehicleId);
        $userID = Yii::app()->getModule('user')->user()->id;

        #$criteria->compare('User_ID',$userID);
        $criteria->compare('Estimate_Status','Approved');		
        return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
        'pagination' => array('pageSize'=>30),
        'sort'=>array(
            'defaultOrder'=>'Estimate_Date DESC',
            ),	
        ));
    }

    public function getDisapprovedRepairRequests()
    {
        $vehicleId = Yii::app()->session['maintenVehicleId'];
        $criteria=new CDbCriteria;
        $criteria->compare('Vehicle_No',$vehicleId);

        $userID = Yii::app()->getModule('user')->user()->id;

        #$criteria->compare('User_ID',$userID);
        $criteria->compare('Estimate_Status','Disapproved',true);		
        return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
        'pagination' => array('pageSize'=>30),
        'sort'=>array(
            'defaultOrder'=>'Estimate_Date DESC',
            ),	
        ));
    }

    public function getRejectedRepairRequests()
    {
        $vehicleId = Yii::app()->session['maintenVehicleId'];
        $criteria=new CDbCriteria;
        $criteria->compare('Vehicle_No',$vehicleId);

        $userID = Yii::app()->getModule('user')->user()->id;

        #$criteria->compare('User_ID',$userID);
        $criteria->compare('Estimate_Status','Rejected',true);		
        return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
        'pagination' => array('pageSize'=>30),
        'sort'=>array(
            'defaultOrder'=>'Estimate_Date DESC',
            ),	
        ));
    }

    public function getCompletedRepairRequests()
    {
        $vehicleId = Yii::app()->session['maintenVehicleId'];
        $criteria=new CDbCriteria;
        $criteria->compare('Vehicle_No',$vehicleId);

        $userID = Yii::app()->getModule('user')->user()->id;

        #$criteria->compare('User_ID',$userID);
        $criteria->compare('Estimate_Status','Completed',true);		
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize'=>30),
            'sort'=>array(
                'defaultOrder'=>'Estimate_Date DESC',
            ),	
        ));
    }

    public function DashboardPendingRepair($superuserstatus,$locID) 
    {
        $condition = "";
        if ($superuserstatus != 1)
        {
            $condition = " and vl.Current_Location_ID =$locID";
        }

        $cri9 = new CDbCriteria();
        $cri9->select="count(Request_ID) as Request_ID";
        $cri9->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
        $cri9->condition="Estimate_Status = 'Pending'".$condition;
        $Array9 = $this->findAll($cri9);

        $countRepairPending = 0;
        if (count($Array9) > 0)
        {
            $countRepairPending = $Array9[0]['Request_ID'];
        }

        return $countRepairPending;
    }

    public function DashboardApprovedRequests($superuserstatus,$locID)
    {
        $condition = "";
        if ($superuserstatus != 1)
        {
            $condition = " and vl.Current_Location_ID =$locID";
        }

        $cri10 = new CDbCriteria();
        $cri10->select="count(Request_ID) as Request_ID";
        $cri10->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
        $cri10->condition="Estimate_Status = 'Approved'".$condition;
        $Array10 = $this->findAll($cri10);

        $countApprovedRepairRequests = 0;
        if (count($Array10) > 0)
        {
            $countApprovedRepairRequests = $Array10[0]['Request_ID'];
        }

        return $countApprovedRepairRequests;
    }
	
}