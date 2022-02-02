<?php

/**
 * This is the model class for table "vehicle_transfer".
 *
 * The followings are the available columns in table 'vehicle_transfer':
 * @property integer $VehicleTransfer_ID
 * @property string $Vehicle_No
 * @property integer $From_Location_ID
 * @property integer $To_Location_ID
 * @property string $From_Date
 * @property string $To_Date
 *
 * The followings are the available model relations:
 * @property MaLocation $toLocation
 * @property VehicleLocation $vehicleNo
 * @property MaLocation $fromLocation
 */
class VehicleTransfer extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return VehicleTransfer the static model class
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
        return 'vehicle_transfer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Vehicle_No, From_Location_ID, To_Location_ID, From_Date', 'required'),
            array('From_Location_ID, To_Location_ID', 'numerical', 'integerOnly'=>true),
            array('Vehicle_No', 'length', 'max'=>20),
            array('To_Date, add_date, edit_date, add_by, edit_by', 'safe'),
            
            array('To_Location_ID','checkLocation'),
            array('From_Date', 'checkFromDate'),
            array('To_Date', 'checkToDate'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('VehicleTransfer_ID, Vehicle_No, From_Location_ID, To_Location_ID, From_Date, To_Date, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
        );
    }
    
    public function checkLocation() 
    {
        $curLoc = $this->From_Location_ID;
        $toLoc = $this->To_Location_ID;
        
        if($curLoc === $toLoc)
        {
            $this->addError('To_Location_ID',"'To Location' is same as From Location");
            return false;
        }
    }
    
    public function checkFromDate() 
    {
        $curDate = MaVehicleRegistry::model()->getServerDate('Date');
        $vNo = $this->Vehicle_No;
        $upID = $this->VehicleTransfer_ID;
        $frmDate = $this->From_Date;
        $previousMaxFromDate ='';
        $cri = new CDbCriteria();
        //$lastFromDateData = Yii::app()->db->createCommand('SELECT From_Date FROM `vehicle_transfer` where Vehicle_No = "'.$vNo.'" and VehicleTransfer_ID = (select max(VehicleTransfer_ID) FROM `vehicle_transfer`)')->queryAll();
        $cri->select="max(From_Date) as From_Date";
        $condition="Vehicle_No='$vNo' ";
        $scenario = $this->getScenario();
        
        if($scenario == 'update')
        {   
            $condition .= " and VehicleTransfer_ID <> $upID";                  
        }
        $cri->condition = $condition;
        
        $arr = $this->find($cri);
        $previousMaxFromDate = $arr->From_Date; 
        if($previousMaxFromDate !== '' && $frmDate < $previousMaxFromDate)
        {
            $this->addError('From_Date',"'From Date' is invalid. ");
            return false;
        }
        
    }
    
    public function checkToDate() 
    {
        $toDate = $this->To_Date;
        $frmDate = $this->From_Date;
        
        if($toDate !== '' && $toDate !== '0000-00-00' && $toDate < $frmDate)
        {
            $this->addError('To_Date',"'To Date' should be greater than 'From Date'");
            return false;
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
            'toLocation' => array(self::BELONGS_TO, 'MaLocation', 'To_Location_ID'),
            //'vehicleNo' => array(self::BELONGS_TO, 'VehicleLocation', 'Vehicle_No'),
            'fromLocation' => array(self::BELONGS_TO, 'MaLocation', 'From_Location_ID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'VehicleTransfer_ID' => 'Vehicle Transfer',
            'Vehicle_No' => 'Vehicle No',
            'From_Location_ID' => 'From Location',
            'To_Location_ID' => 'To Location',
            'From_Date' => 'From Date',
            'To_Date' => 'To Date',
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

        $criteria->compare('VehicleTransfer_ID',$this->VehicleTransfer_ID);
        $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
        $criteria->compare('From_Location_ID',$this->From_Location_ID);
        $criteria->compare('To_Location_ID',$this->To_Location_ID);
        $criteria->compare('From_Date',$this->From_Date,true);
        $criteria->compare('To_Date',$this->To_Date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
	
    public function getTransferDetails()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $vID = Yii::app()->request->getQuery('id');
		
	
        if ($vID != '')
        {
            //$cmd = 'Select Vehicle_No from vehicle_location where Vehicle_Location_ID ='.$vID;
            $cmd = 'Select Vehicle_No from vehicle_transfer where VehicleTransfer_ID ='.$vID;
            $rowData = Yii::app()->db->createCommand($cmd)->queryAll();
            $count = count($rowData);
            $vNo ='';
            if($count >0)
            {
                $vNo = $rowData[$count-1]['Vehicle_No'];
            }
        }

        $criteria=new CDbCriteria;

        //$criteria->compare('VehicleTransfer_ID',$this->VehicleTransfer_ID);
        $criteria->compare('Vehicle_No',$vNo,true);
        //$criteria->compare('From_Location_ID',$this->From_Location_ID);
        //$criteria->compare('To_Location_ID',$this->To_Location_ID);
       // $criteria->compare('From_Date',$this->From_Date,true);
       // $criteria->compare('To_Date',$this->To_Date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
	
	
    public function getLocationHistory()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $vID = Yii::app()->request->getQuery('id');

        $criteria=new CDbCriteria;

        $criteria->compare('VehicleTransfer_ID',$this->VehicleTransfer_ID);
        $criteria->compare('Vehicle_No',$vID,true);
        $criteria->compare('From_Location_ID',$this->From_Location_ID);
        $criteria->compare('To_Location_ID',$this->To_Location_ID);
        $criteria->compare('From_Date',$this->From_Date,true);
        $criteria->compare('To_Date',$this->To_Date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
	
	
}