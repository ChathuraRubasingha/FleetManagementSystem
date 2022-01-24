<?php

/**
 * This is the model class for table "tyre_details".
 *
 * The followings are the available columns in table 'tyre_details':
 * @property integer $Tyre_Details_ID
 * @property string $Vehicle_No
 * @property integer $Driver_ID
 * @property integer $Tyre_Type_ID
 * @property integer $Tyre_Size_ID
 * @property string $Approved_By
 * @property string $Approved_Date
 * @property string $Replace_Status
 * @property string $Replace_Date
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaTyreSize $tyreSize
 * @property MaVehicleRegistry $vehicleNo
 * @property MaDriver $driver
 * @property MaTyreType $tyreType, $Tyre_Size_ID_2
 */
class TRTyreDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRTyreDetails the static model class
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
		return 'tyre_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Vehicle_No, Driver_ID, Tyre_Type_ID, Tyre_Size_ID, Tyre_quantity', 'required'),
			array('Driver_ID, Tyre_Type_ID, Tyre_Size_ID, Tyre_Size_ID_2', 'numerical', 'integerOnly'=>true),
			array('Cost', 'numerical'),
			array('Vehicle_No', 'length', 'max'=>20),
			array('Approved_By', 'length', 'max'=>100),
			array('Cost', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),
			array('Meter_Reading, Life_Time', 'match', 'pattern'=>'/^([0-9\.])+$/'),
			array('Replace_Status', 'length', 'max'=>10),
			array('Request_Date, add_by, add_date, edit_by, edit_date', 'length', 'max'=>50),
			array('Life_Time, Status_Reason,Cost, Meter_Reading, Replace_Date, Tyre_quantityType2, Tyre_Size_ID_2', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Tyre_Details_ID, Vehicle_No, Driver_ID, Tyre_Type_ID, Tyre_Size_ID, Tyre_Size_ID_2, Tyre_quantityType2, Approved_By, Approved_Date, Request_Date, Replace_Status, Status_Reason, Replace_Date, add_by, add_date, edit_by, edit_date, Approved_Status', 'safe', 'on'=>'search'),
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
			'tyreSize' => array(self::BELONGS_TO, 'MaTyreSize', 'Tyre_Size_ID'),
			'tyreSize2' => array(self::BELONGS_TO, 'MaTyreSize', 'Tyre_Size_ID_2'),
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
			'driver' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
			'tyreType' => array(self::BELONGS_TO, 'MaTyreType', 'Tyre_Type_ID'),
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
			'Tyre_Details_ID' => 'Request ID',
			'Vehicle_No' => 'Vehicle No',
			'Driver_ID' => 'Driver Name',
			'Tyre_Type_ID' => 'Tyre Type',
			'Tyre_Size_ID' => 'Tyre Size (front)',
			'Tyre_Size_ID_2'=> 'Tyre Size (back/rear)',
			'Tyre_quantity' => 'Quantity Tyre Type 1',
			'Tyre_quantityType2' => 'Quantity Tyre Type 2',			
			'Request_Date' => 'Requested Date',
			'Approved_Status' => 'Approved Status',
			'Approved_By' => 'Approved By',
			'Approved_Date' => 'Approved Date',
			'Replace_Status' => 'Replace Status',
			'Replace_Date' => 'Replaced Date',
			'Life_Time' => 'Life Time (km)',
			'Cost' => 'Cost (Rs.)',
			'Meter_Reading' => 'Current Meter Reading',
			'add_by' => 'Add By',
			'add_date' => 'Add Date',
			'edit_by' => 'Edit By',
			'edit_date' => 'Edit Date',
		);
}
else
{
	return array(
			'Tyre_Details_ID' => 'අයදුම් අංකය ',
			'Vehicle_No' => 'වාහන අංකය ',
			'Driver_ID' => 'රියැදුරු',
			'Tyre_Type_ID' => 'ටයර වර්ගය ',
			'Tyre_Size_ID' => 'ටයරයේ ප්‍රමාණය ',
			'Tyre_Size_ID_2'=> 'Tyre Size(Back/rear)',			
			'Tyre_quantity' => 'අවශ්‍ය ටයර ප්‍රමාණය ',
			'Tyre_quantityType2' => 'Tyre quantity Type 2',
			'Request_Date' => 'අයදුම් කළ දිනය ',
			'Approved_Status' => 'අනුමත තත්ත්වය ',
			'Approved_By' => 'අනුමත කරන ලද්දේ ',
			'Approved_Date' => 'අනුමත කළ දිනය ',
			'Replace_Status' => 'ප්‍රතිස්ථාපන තත්ත්වය ',
			'Replace_Date' => 'ප්‍රතිස්ථාපිත දිනය ',
			'Life_Time' => 'ආයු කාලය (කි.මි)',
			'Cost' => 'වටිනාකම (රු.)',
			'Meter_Reading' => 'වර්තමාන මීටර කියවීම',
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

		$criteria->compare('Tyre_Details_ID',$this->Tyre_Details_ID);
		$criteria->compare('Vehicle_No',$this->Vehicle_No,true);
		$criteria->compare('Driver_ID',$this->Driver_ID);
		$criteria->compare('Tyre_Type_ID',$this->Tyre_Type_ID);
		$criteria->compare('Tyre_Size_ID',$this->Tyre_Size_ID);
		$criteria->compare('Tyre_Size_ID_2',$this->Tyre_Size_ID_2);
		$criteria->compare('Tyre_quantity',$this->Tyre_quantity,true);
		$criteria->compare('Tyre_quantityType2',$this->Tyre_quantityType2,true);
		$criteria->compare('Request_Date', $this->Request_Date, ture);
		$criteria->compare('Approved_Status',$this->Approved_Status,true);
		$criteria->compare('Approved_By',$this->Approved_By,true);
		$criteria->compare('Approved_Date',$this->Approved_Date,true);
		$criteria->compare('Replace_Status',$this->Replace_Status,true);
		$criteria->compare('Replace_Date',$this->Replace_Date,true);
		$criteria->compare('Life_Time',$this->Life_Time,true);
		$criteria->compare('Cost',$this->Cost,true);
		$criteria->compare('Meter_Reading',$this->Meter_Reading,true);
		$criteria->compare('add_by',$this->add_by,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('edit_by',$this->edit_by,true);
		$criteria->compare('edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getPendingTyreRequests()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria=new CDbCriteria;
		
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Approved_Status','Pending');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getReplacedTyreRequests()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		
		$criteria=new CDbCriteria;
		
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Replace_Status','Replaced');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getPendingTyreRequestsDashBoard()
	{
		$superUser = Yii::app()->getModule('user')->user()->superuser;
		$locID = Yii::app()->getModule('user')->user()->Location_ID;
		
		$criteria=new CDbCriteria;
		
		if ($superUser != 1)
		{
			$criteria->select = 't.Tyre_Details_ID, t.Vehicle_No, t.Driver_ID, t.Tyre_Type_ID, t.Tyre_Size_ID, t.Tyre_quantity';
			$criteria->join = 'inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No ';
            $criteria->condition = 't.Approved_Status = "Pending" and vl.Location_ID = '.$locID;
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
	
	public function approve($tyreDetailsId)
	{
            $user = Yii::app()->getModule('user')->user()->username;
            $approveDate = MaVehicleRegistry::model()->getServerDate("DateTime");
            
            $data = TRTyreDetails::model()->updateByPk($tyreDetailsId, array("Approved_Status"=>"Approved", "Approved_By"=>"$user", "Approved_Date"=>"$approveDate"));

            return true;
	}
	
	public function disapprove($tyreDetailsId, $reason)
	{
            $user = Yii::app()->getModule('user')->user()->username;
            $approveDate = MaVehicleRegistry::model()->getServerDate("DateTime");

            $data = TRTyreDetails::model()->updateByPk($tyreDetailsId, array("Approved_Status"=>"Disapproved", "Status_Reason"=>"$reason", "Approved_By"=>"$user", "Approved_Date"=>"$approveDate"));

            return true;
	}
	
	public function reject($tyreDetailsId, $reason)
	{
            $user = Yii::app()->getModule('user')->user()->username;		
            $approveDate =  MaVehicleRegistry::model()->getServerDate("DateTime");
            $data = TRTyreDetails::model()->updateByPk($tyreDetailsId, array("Approved_Status"=>"Rejected", "Status_Reason"=>"$reason", "Replace_Status"=>"-", "Approved_By"=>"$user", "Approved_Date"=>"$approveDate"));
            if($data)
            {
                return TRUE;
            }
            else 
            {
                 return FALSE;
            }
	}
	
	public function canceled($tyreDetailsId)
	{
            return true;
	}
	
	
	
	
	public function getPendingTyreReplacementsDashBoard()
	{
		$superUser = Yii::app()->getModule('user')->user()->superuser;
		$locID = Yii::app()->getModule('user')->user()->Location_ID;
		$current_user=Yii::app()->user->name;

		$criteria=new CDbCriteria;

        if ($superUser != 1)
        {
            //$criteria->select = 't.Tyre_Details_ID, t.Vehicle_No, t.Driver_ID, t.Tyre_Type_ID, t.Tyre_Size_ID, t.Tyre_quantity';
            $criteria->join = 'inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No ';
            $criteria->condition = 't.Approved_Status = "Approved" and Replace_Status="Pending" and vl.Current_Location_ID = '.$locID;
        }
        else
        {
            $criteria->compare('Approved_Status','Approved');
            $criteria->compare('Replace_Status','Pending');
        }


		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>30),
                ));
	}
	
	public function getTyreReplacementHistory()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		$criteria=new CDbCriteria;
		$criteria->compare('Vehicle_No',$vehicleId);
		/*$criteria->compare('Approved_Status','Approved');
		$criteria->compare('Replace_Status','Replaced');*/

		return new CActiveDataProvider($this, array(
            	'criteria' => $criteria,
            	'sort'=>array(
                'defaultOrder'=>'Tyre_Details_ID DESC',
            	),	
		));
	}
	
	public function getPendingTyreReplacements()
	{
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $userName = Yii::app()->getModule('user')->user()->username;

		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		$criteria=new CDbCriteria;
                
                if($superUser !==1)
                {
                     //$criteria->compare('add_by',$userName);
                }
               
                
		
				
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Approved_Status','Approved');
		$criteria->compare('Replace_Status','Pending');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getPendingTyreRequestDetails()
	{
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $userName = Yii::app()->getModule('user')->user()->username;
            
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$vehicleId = Yii::app()->session['maintenVehicleId'];

		$criteria=new CDbCriteria;
                
		if($superUser !==1)
		{
			//$criteria->compare('add_by',$userName);	
		}
                
		$userName = Yii::app()->getModule('user')->user()->username;
		
		$criteria->compare('Vehicle_No',$vehicleId);
		#$criteria->compare('Approved_Status','Approved');
		$criteria->compare('Approved_Status','Pending');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function getApprovedTyreRequests()
	{
            $superUser = Yii::app()->getModule('user')->user()->superuser;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $userName = Yii::app()->getModule('user')->user()->username;
            
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		$criteria=new CDbCriteria;
                  if($superUser !==1)
                    {
                       // $criteria->compare('add_by',$userName);	
                    }

		
		
		$criteria->compare('Vehicle_No',$vehicleId);
		#$criteria->compare('Approved_Status','Approved');
		$criteria->compare('Approved_Status','Approved');
		$criteria->compare('Replace_Status','Pending');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getDisapprovedTyreRequests()
	{
             $superUser = Yii::app()->getModule('user')->user()->superuser;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $userName = Yii::app()->getModule('user')->user()->username;
            
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		$criteria=new CDbCriteria;
		
                if($superUser !==1)
                {
                    //$criteria->compare('add_by',$userName);	
                }
		$criteria->compare('Vehicle_No',$vehicleId);
		#$criteria->compare('Approved_Status','Approved');
		$criteria->compare('Approved_Status','Disapproved');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getRejectedTyreRequests()
	{
             $superUser = Yii::app()->getModule('user')->user()->superuser;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $userName = Yii::app()->getModule('user')->user()->username;
            
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		$criteria=new CDbCriteria;
		if($superUser !==1)
                {
                    //$criteria->compare('add_by',$userName);	
                }
		$criteria->compare('Vehicle_No',$vehicleId);
		#$criteria->compare('Approved_Status','Approved');
		$criteria->compare('Approved_Status','Rejected');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getCompletedTyreRequests()
	{
             $superUser = Yii::app()->getModule('user')->user()->superuser;
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $userName = Yii::app()->getModule('user')->user()->username;
            
		$vehicleId = Yii::app()->session['maintenVehicleId'];
		$criteria=new CDbCriteria;
		if($superUser !==1)
                {
                    //$criteria->compare('add_by',$userName);	
                }
		$criteria->compare('Vehicle_No',$vehicleId);
                
		$criteria->compare('Replace_Status','Replaced');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

	}
        
        public function DashboardPendingTyreRequests($superuserstatus,$locID)
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and vl.Current_Location_ID =$locID";
            }
            
            $cri3 = new CDbCriteria();
            $cri3->select="count(Tyre_Details_ID) as Tyre_Details_ID";
            $cri3->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
            $cri3->condition="Approved_Status = 'Pending'".$condition;
            $Array3 = $this->findAll($cri3);

            $countPendingTyreReplacementRequests = 0;
            if (count($Array3) > 0)
            {
                $countPendingTyreReplacementRequests = $Array3[0]['Tyre_Details_ID'];
            }
            
            return $countPendingTyreReplacementRequests;
        }
        
        public function DashboardApprovedTyreRequests($superuserstatus,$locID)
        {
            $condition = "";
            if ($superuserstatus != 1)
            {
                $condition = " and vl.Current_Location_ID =$locID";
            }
            
            $cri4 = new CDbCriteria();
            $cri4->select="count(Tyre_Details_ID) as Tyre_Details_ID";
            $cri4->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
            $cri4->condition="Approved_Status = 'Approved' AND Replace_Status = 'Pending'".$condition;
            $Array4 = $this->findAll($cri4);

           $countApprovedTyreReplacements = 0;
            if (count($Array4) > 0)
            {
                $countApprovedTyreReplacements = $Array4[0]['Tyre_Details_ID'];
            }
            
            return $countApprovedTyreReplacements;
        }
	
}