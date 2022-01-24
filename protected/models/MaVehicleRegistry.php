<?php

/**
 * This is the model class for table "ma_vehicle_registry".
 *
 * The followings are the available columns in table 'ma_vehicle_registry':
 * @property string $Vehicle_No
 * @property integer $Vehicle_Category_ID
 * @property string $Purchase_Value
 * @property string $Purchase_Date
 * @property string $Engine_No
 * @property string $Chassis_No
 * @property integer $Fuel_Type_ID
 * @property integer $Tyre_Size_ID
 * @property integer $Tyre_Type_ID
 * @property string $No_of_Tyres
 * @property string $Model_ID
 * @property string $Make_ID
 * @property integer $Battery_Type_ID
 * @property integer $Vehicle_Status_ID
 * @property string $Service_Mileage
 * @property string $Servicing_Period
 * @property string $Fuel_Consumption
 * @property string $Fitness_test
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property EmissionTest[] $emissionTests
 * @property FitnessTest[] $fitnessTests
 * @property Insurance[] $insurances
 * @property License[] $licenses
 * @property MaBatteryType $batteryType
 * @property MaVehicleCategory $vehicleCategory
 * @property MaFuelType $fuelType
 * @property MaVehicleStatus $vehicleStatus
 * @property MaTyreSize $tyreSize
 * @property MaTyreType $tyreType
 * @property Services[] $services
 */
class MaVehicleRegistry extends CActiveRecord
{
    public $FirstBlock;
    public $SechondBlock;
    
    /*
     * Returns the static model of the specified AR class.
     * @return MaVehicleRegistry the static model class
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
        return 'ma_vehicle_registry';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Vehicle_No, Allocation_Type_ID, Vehicle_Category_ID, Fuel_Type_ID, Fuel_Tank_Capacity, Tyre_Size_ID, Tyre_Type_ID, Battery_Type_ID, Make_ID, Model_ID, Vehicle_Status_ID','required'),
            array('Vehicle_Category_ID, Driver_ID, Fuel_Type_ID, Tyre_Size_ID, Tyre_Size_ID_2, Tyre_Type_ID, Battery_Type_ID, Vehicle_Status_ID, Location_ID, Make_ID, Model_ID', 'numerical', 'integerOnly'=>true),
            
            array('Vehicle_No', 'length', 'max'=>20),
            array('Purchase_Value, Registration_Fee, Engine_No, Chassis_No, No_of_Tyres, add_by, edit_by', 'length', 'max'=>50),
            array('Service_Mileage, Servicing_Period, Fuel_Consumption, Fitness_test', 'length', 'max'=>100),
            array('Vehicle_No,Engine_No,Chassis_No', 'unique'),
            array('odometer,Vehicle_image, vehicleCategory.Category_Name, makeID.Make, model.Model', 'safe'),
            array('add_date, edit_date,Ac_Statues,Number_of_Passenger', 'safe'),
            //array('Vehicle_No', 'match', 'pattern'=>'/^([0-9A-Za-z\- ])+$/'),
           // array('Vehicle_No', 'match', 'pattern'=>'/^[0-9 \-]{1,6}|[a-zA-Z \-]{1,4}[0-9]{4,5}+$/'),
            array('Purchase_Value, Registration_Fee', 'match', 'pattern'=>'/^([0-9\,]{1,}(.[0-9]{2}))$/'),
            array('Engine_No', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
            array('Chassis_No', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),

            array('Make_Year, Engine_No, Chassis_No','safe'),

            array('No_of_Tyres, Number_of_Passenger', 'match', 'pattern'=>'/^([0-9])+$/'),

            array('Make_Year', 'match', 'pattern'=>'/^([0-9]{4})+$/'),
            array('Service_Mileage,Servicing_Period,Fuel_Consumption,odometer, Fuel_Tank_Capacity', 'match', 'pattern'=>'/^([0-9\.])+$/'),
            //array('image_name', 'file', 'allowEmpty' => FALSE, 'types' => 'jpg, jpeg, gif, png'),

            array('Purchase_Date', 'checkPrevious'),
            array('Make_Year', 'checkPreviousYear'),
            
            array('FirstBlock', 'match', 'pattern'=>'/^([0-9]{2,3})$|^([A-Z]{2,3})$/', 'message' => ("Vehicle Number is invalid - [0-9]{2,3})$ or ^([A-Z]{2,3} - Middle Part")),
            array('SechondBlock', 'match', 'pattern'=>'/^([0-9]{4})$/', 'message' => ("Vehicle Number is invalid - only four numbers are accepted in the last part")),
            

            //array('FirstBlock', 'checkFirstBlock'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Vehicle_No, FirstBlock, SechondBlock, Registration_Fee, Vehicle_Category_ID, vehicleCategory.Category_Name, Driver_ID, Purchase_Value, Purchase_Date, Engine_No, Chassis_No, Fuel_Type_ID,Tyre_Size_ID, Tyre_Size_ID_2, Tyre_Type_ID, No_of_Tyres, Model_ID, Make_ID, makeID.Make, model.Model, Make_Year,Battery_Type_ID, Vehicle_Status_ID, Service_Mileage,Servicing_Period, Fuel_Consumption, Fitness_test, add_by, add_date, edit_by, edit_date,Number_of_Passenger,Ac_Statues, Location_ID', 'safe', 'on'=>'search'),
            array('Vehicle_image',  'file','types'=>'jpg, jpeg, gif, png', 'maxSize'=>10*1024*1024, 'maxFiles' => 14, 'allowEmpty'=>true, 'on'=>'insert, update'),
        );
    }

    public function checkPrevious()
    {

        date_default_timezone_set('Asia/Colombo');
        $serverDate = MaVehicleRegistry::model()->getServerDate("date");

        if(isset($this->Purchase_Date))
        {

            $Purchase_Date = $this->Purchase_Date;

            if($Purchase_Date !=='0000-00-00' && $Purchase_Date !=='')
            {
                if($Purchase_Date > $serverDate)
                {
                    $this->addError('Purchase_Date',"'Purchase Date' should be a Previous Date");
                    return false;
                }

                if( isset($this->Make_Year))
                {
                    $Make_Year = $this->Make_Year;

                    if($Make_Year >  $Purchase_Date)
                    {
                        $this->addError('Purchase_Date',"'Purchase Date' should be greater than Make Year");
                        return false;
                    }
                }
            }


        }
        else
        {
            return true;
        }



    }
    
    public function checkPreviousYear()
    {
        $Make_Year =$this->Make_Year;
        date_default_timezone_set('Asia/Colombo');
        $year = date("Y");

        if($Make_Year > $year)
        {
            $this->addError('Make_Year',"'Make Year' should be a Previous Year");
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
            'emissionTests' => array(self::HAS_MANY, 'EmissionTest', 'Vehicle_No'),
            'fitnessTests' => array(self::HAS_MANY, 'FitnessTest', 'Vehicle_No'),
            'insurances' => array(self::HAS_MANY, 'Insurance', 'Vehicle_No'),
            'licenses' => array(self::HAS_MANY, 'License', 'Vehicle_No'),
            'batteryType' => array(self::BELONGS_TO, 'MaBatteryType', 'Battery_Type_ID'),
            'vehicleCategory' => array(self::BELONGS_TO, 'VehicleCategory', 'Vehicle_Category_ID'),
            'fuelType' => array(self::BELONGS_TO, 'FuelType', 'Fuel_Type_ID'),
            'allocationType' => array(self::BELONGS_TO, 'MaAllocationType', 'Allocation_Type_ID'),
            'vehicleStatus' => array(self::BELONGS_TO, 'VehicleStatus', 'Vehicle_Status_ID'),
            'tyreSize' => array(self::BELONGS_TO, 'MaTyreSize', 'Tyre_Size_ID'),
            'tyreSize2' => array(self::BELONGS_TO, 'MaTyreSize', 'Tyre_Size_ID_2'),
            'tyreType' => array(self::BELONGS_TO, 'MaTyreType', 'Tyre_Type_ID'),
            'services' => array(self::HAS_MANY, 'Services', 'Vehicle_No'),
            'driverID' => array(self::BELONGS_TO, 'MaDriver', 'Driver_ID'),
            'modelID' => array(self::BELONGS_TO, 'MaModel', 'Model_ID'),
            'location' => array(self::BELONGS_TO, 'MaLocation', 'Location_ID'),
            'makeID' => array(self::BELONGS_TO, 'MaMake', 'Make_ID'),
            'odoUpdate'=>array(self::HAS_MANY, 'OdometerUpdate', 'Vehicle_No'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        $userRole = Yii::app()->getModule('user')->user()->Role_ID;
        if (($userRole !== '3') && ($userRole !== '4')) 
        {
            return array(
                'Vehicle_No' => 'Vehicle Number',
                'Registration_Fee'=>'Registration Fee (Rs.)',
                'Allocation_Type_ID'=>'Allocation Type',
                'Vehicle_Category_ID' => 'Vehicle Category',
                'Make_Year' => 'Make Year',
                'Make_ID' => 'Make',
                'Model_ID' => 'Model',
                'Purchase_Value' => 'Purchase Value (Rs.)',
                'Purchase_Date' => 'Purchase Date',
                'Engine_No' => 'Engine Number',
                'Chassis_No' => 'Chassis Number',
                'Number_of_Passenger' => 'Number of Passengers',
                'Ac_Statues' => 'Air Condition',
                'Fuel_Type_ID' => 'Fuel Type',
                'Fuel_Tank_Capacity' => 'Fuel Tank Capacity',

                'Tyre_Size_ID' => 'Tyre Size',
                'Tyre_Size_ID_2' => 'Tyre Size 2',
                'Tyre_Type_ID' => 'Tyre Type',
                'No_of_Tyres' => 'Number of Tyres',
                'Battery_Type_ID' => 'Battery Type',

                'Vehicle_Status_ID' => 'Vehicle Status',
                'Service_Mileage' => 'Service Mileage(km:)',
                'Servicing_Period' => 'Servicing Period',
                'Fuel_Consumption' => 'Fuel Consumption (Per Liter)',
                'odometer'=>'Current Odometer',
                'Fitness_test' => 'Fitness Test Eligibility',
                'Vehicle_image'=>'Vehicle Image',
                'add_by' => 'Add By',
                'add_date' => 'Add Date',
                'edit_by' => 'Edit By',
                'edit_date' => 'Edit Date',

                'Location_ID'=>'Location',
                //'Driver_ID' => 'Driver Allocation',
                //'Full_Name' => 'Full Name',
            );
        }
        else
        {
            return array(
                'Vehicle_No' => 'වාහන අංකය',
                'Registration_Fee'=>'ලියාපදිංචි කිරීමේ ගාස්තුව (රු.)',
                'Allocation_Type_ID'=>'වෙන් කළ තත්ත්වය',
                'Vehicle_Category_ID' => 'වාහන වර්ගය',
                'Make_Year' => 'නිෂ්පාදිත වර්ෂය',
                'Make_ID' => 'වාහන ප්‍රභේධය ',
                'Model_ID' => 'වාහන මාදිලිය',
                'Purchase_Value' => 'වටිනාකම (රු.)',
                'Purchase_Date' => 'මිල දී ගත් දිනය',
                'Engine_No' => 'එන්ජින් අංකය',
                'Chassis_No' => 'චැසි අංකය ',
                'Number_of_Passenger' => 'ගමන් කළ හැකි මඟින් ගණන',
                'Ac_Statues' => 'වායුසමන තත්ත්වය',
                'Fuel_Type_ID' => 'ඉන්ධන වර්ගය',
                'Fuel_Tank_Capacity' => 'ඉන්ධන ටැංකියේ පරිමාව',

                'Tyre_Size_ID' => 'ටයර වල ප්‍රමාණය ',
                'Tyre_Size_ID_2' => 'ටයර වල ප්‍රමාණය 2',
                'Tyre_Type_ID' => 'ටයර වර්ගය',
                'No_of_Tyres' => 'ටයර ගණන',
                'Battery_Type_ID' => 'බැටරි වර්ගය ',

                'Vehicle_Status_ID' => 'වාහනයේ වර්තමාන තත්ත්වය ',
                'Service_Mileage' => 'නඩත්තු කළ යුතු දුර (කි.මී) ',
                'Servicing_Period' => 'නඩත්තු කළ යුතු කාලය',
                'Fuel_Consumption' => 'ඉන්ධන දහනය (ලීටරයට කි.මී) ',
                'odometer'=>'වර්තමාන ඔඩෝමීටරය',
                'Fitness_test' => 'යෝග්‍යතා පරීක්‍ෂණයට සුදුසු බව',
                'Vehicle_image'=>'ඡායාරූපය',
                'add_by' => 'ඇතුලත් කළේ ',
                'add_date' => 'ඇතුලත් කළ දිනය',
                'edit_by' => 'යාවත්කාලීන කළේ ',
                'edit_date' => 'යාවත්කාලීන කළ දිනය ',
                'Location_ID'=>'ස්ථානය',
               
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
        //$criteria->compare('t.Make_ID',$this->Make_ID, true);
        $criteria->compare('t.Vehicle_No',$this->Vehicle_No,true);

        $criteria->compare('vehicleCategory.Category_Name',$this->Vehicle_Category_ID, true);
        $criteria->compare('makeID.Make',$this->Make_ID, true);

        $criteria->with = array('vehicleCategory'=>array('select'=>'vehicleCategory.Category_Name', 'together'=>true), 'makeID'=>array('select'=>'makeID.Make','together'=>true));
		
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        if ($superuserstatus != 1)
        {
            $criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No', 'condition'=>'vl.Current_Location_ID ='.$LocId,));
            $criteria->compare('vl.Location_ID',$this->Location_ID,true);

        }
        else
        {
            $criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No left join ma_location l on l.Location_ID = vl.Current_Location_ID', 'condition'=>'vl.Vehicle_No IS NOT NULL'));
            $criteria->compare('l.Location_Name',$this->Location_ID,true);
        }

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>30),
        ));
    }

    public function searchAccident()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->compare('t.Make_ID',$this->Make_ID, true);
       

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>30),
        ));
    }


     public function getAccidentDetails()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
//$criteria=new CDbCriteria(array('order'=>'t.Vehicle_No ASC'));

        if($superuserstatus == 1)
        {
            $criteria=new CDbCriteria(array('order'=>'l.Location_Name ASC, t.Vehicle_No ASC'));
        }
        else
        {
            $criteria=new CDbCriteria(array('order'=>'t.Vehicle_No ASC'));
        }

        if ($superuserstatus != 1)
        {
            $criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No', 'condition'=>'vl.Current_Location_ID ='.$LocId,));
            $criteria->compare('vl.Current_Location_ID',$this->Location_ID,true);
        }
        else
        {
            $criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No left join ma_location l on l.Location_ID = vl.Current_Location_ID', 'condition'=>'vl.Vehicle_No IS NOT NULL'));
          // $criteria->compare('l.Location_Name',$this->Location_ID,true);
        }
        
        
       /*  if ($superuserstatus != 1)
        {
            $criteria->mergeWith(array('join'=>'INNER JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No', 'condition'=>'vl.Current_Location_ID ='.$LocId,));
        }
        else
        {
            #$criteria->mergeWith(array('join'=>'INNER JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No'));
        }*/

        $criteria->compare('t.Vehicle_No',$this->Vehicle_No,true);
        $criteria->compare('vehicleCategory.Category_Name',$this->Vehicle_Category_ID, true);
        $criteria->compare('makeID.Make',$this->Make_ID, true);

        $criteria->with = array('vehicleCategory'=>array('select'=>'vehicleCategory.Category_Name', 'together'=>true), 'makeID'=>array('select'=>'makeID.Make','together'=>true));



        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>30),
        ));
    }

    public function getVehicleForAllocate($cv)
    {
        $query = "SELECT Vehicle_No,Vehicle_Category_ID FROM ma_vehicle_registry WHERE Vehicle_Category_ID = '".$cv."'";
        $rawData = Yii::app()->db->createCommand($query)->queryAll();

        return $rawData;
    }

    public function getFreeVehicles()
    {
        $criteria=new CDbCriteria();

        $criteria->select = 'Vehicle_No';
        $criteria->condition = 'Vehicle_No NOT IN';
        $criteria->select = 'Vehicle_No';
        $criteria->condition = 'vehicle_booking v WHERE ( NOW( ) BETWEEN v.from AND v.to)';
        //$criteria->order = 'Valid_To asc';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getvehicle()
    {
        $criteria=new CDbCriteria;

        $vehicleId = Yii::app()->session['maintenVehicleId'];

        $criteria->compare('Vehicle_No',$vehicleId);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getVehicleAndCatagory()
    {
        $query = "SELECT m.Vehicle_No,c.Category_Name FROM ma_vehicle_registry m,ma_vehicle_category c WHERE m.Vehicle_Category_ID = c.Vehicle_Category_ID";
        $rawData = Yii::app()->db->createCommand($query)->queryAll();

        return $rawData;
    }

    public function getVehicleAndCatagories($loc)
    {
        $appDate = date("Y-m-d : H:i:s", time());
        $query = 'SELECT vr.Vehicle_No, vc.Category_Name FROM `ma_vehicle_registry` vr
	INNER JOIN ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
	INNER JOIN vehicle_location vl ON vl.Vehicle_No = vr.Vehicle_No 
	WHERE vr.Vehicle_Category_ID = vc.Vehicle_Category_ID and vl.Current_Location_ID = '.$loc.' and
not EXISTS (select NULL from vehicle_booking vb where vb.Vehicle_No = vr.Vehicle_No and vb.Booking_Status = "approved")';

        /*$query = 'SELECT vr.Vehicle_No, vc.Category_Name FROM `ma_vehicle_registry` vr
            INNER JOIN ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
            INNER JOIN vehicle_location vl ON vl.Vehicle_No = vr.Vehicle_No
            WHERE vr.Vehicle_Category_ID = vc.Vehicle_Category_ID and vl.Current_Location_ID = '.$loc.' and
        not EXISTS (select NULL from vehicle_booking vb where  ("'.$from.'" between date(vb.From) and date(vb.To)) and vb.Vehicle_No = vr.Vehicle_No and vb.Booking_Status = "approved")';

            $query = 'SELECT vr.Vehicle_No, vc.Category_Name FROM `ma_vehicle_registry` vr
            INNER JOIN ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
            INNER JOIN vehicle_location vl ON vl.Vehicle_No = vr.Vehicle_No
            WHERE vr.Vehicle_Category_ID = vc.Vehicle_Category_ID and vl.Current_Location_ID = '.$loc.' and
        not EXISTS (select NULL from vehicle_booking vb where  vb.To>"'.$from.'" and vb.Vehicle_No = vr.Vehicle_No and vb.Booking_Status = "approved")';



                $query = "select vd.Vehicle_No, vc.Category_Name from ma_vehicle_registry vr
        inner join vehicle_driver vd on vd.Vehicle_No = vr.vehicle_No
        inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
        where vd.Location_id =".$loc." and vr.Vehicle_Category_ID =".$category ."";



        $query = "select vd.Vehicle_No, vc.Category_Name from ma_vehicle_registry vr
        inner join vehicle_driver vd on vd.Vehicle_No = vr.vehicle_No
        inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
        where vr.Vehicle_Category_ID =".$category;*/
        $rawData = Yii::app()->db->createCommand($query)->queryAll();

        return $rawData;
    }




    public function getBatteryType($vehicleId)
    {
        //$vehicleId = Yii::app()->session['maintenVehicleId'];

        $query = "SELECT B.Battery_Type_ID, B.Battery_Type FROM ma_battery_type B INNER JOIN ma_vehicle_registry V
		ON B.Battery_Type_ID = V.Battery_Type_ID WHERE V.Vehicle_No = '".$vehicleId."'";

        $rawData = Yii::app()->db->createCommand($query)->queryAll();

        return $rawData;
    }

    public function getTyreType($vehicleId)
    {
        //$vehicleId = Yii::app()->session['maintenVehicleId'];

        $query = "SELECT T.Tyre_Type_ID, T.Tyre_Type FROM ma_tyre_type T INNER JOIN ma_vehicle_registry V
		ON T.Tyre_Type_ID = V.Tyre_Type_ID WHERE V.Vehicle_No = '".$vehicleId."'";

        $rawData = Yii::app()->db->createCommand($query)->queryAll();

        return $rawData;
    }

    public function getTyreSize($vehicleId)
    {
        //$vehicleId = Yii::app()->session['maintenVehicleId'];

        $query = "SELECT T.Tyre_Size_ID, T.Tyre_Size FROM ma_tyre_size T INNER JOIN ma_vehicle_registry V
		ON T.Tyre_Size_ID = V.Tyre_Size_ID WHERE V.Vehicle_No = '".$vehicleId."'";

        $rawData = Yii::app()->db->createCommand($query)->queryAll();

        return $rawData;
    }

    public function getTyreSize2($vehicleId)
    {
        //$vehicleId = Yii::app()->session['maintenVehicleId'];

        $query = "SELECT T.Tyre_Size_ID, T.Tyre_Size FROM ma_tyre_size T INNER JOIN ma_vehicle_registry V
        ON T.Tyre_Size_ID = V.Tyre_Size_ID_2 WHERE V.Vehicle_No = '".$vehicleId."'";

        $rawData = Yii::app()->db->createCommand($query)->queryAll();

        return $rawData;
    }


    public function getRequestservice($Vehicle_No)
    {
        $query = "Select ma_vehicle_registry.Vehicle_No As Vehicle_No,
   			services.Service_Station_ID As Service_Station_ID,
  			ma_service_station.Srvice_Station_Name,
  			Max(services.Service_Date),
  			services.Meter_Reading,
  			ma_vehicle_registry.odometer,
  			(ma_vehicle_registry.odometer - services.Meter_Reading)
			From ma_service_station Inner Join
  			services On services.Service_Station_ID =
    		ma_service_station.Service_Station_ID Inner Join
  			ma_vehicle_registry On ma_vehicle_registry.Vehicle_No = services.Vehicle_No
			Where ma_vehicle_registry.Vehicle_No = '".$Vehicle_No."'  ";
        $rawData = Yii::app()->db->createCommand($query)->queryAll();
        //print_r($rawData);
        //exit;
        return $rawData;
    }
    public function getnewTyreTube($Vehicle)
    {
        $query = "Select ma_vehicle_registry.Vehicle_No,
  				ma_driver.Full_Name,
  				ma_vehicle_registry.odometer,
  				Max(tyre_details.Replace_Date),
  				Max(tyre_details.Meter_Reading),
  				tyre_details.Tyre_quantity,
  				(ma_vehicle_registry.odometer - Max(tyre_details.Meter_Reading))
				From ma_vehicle_registry Inner Join
  				tyre_details On ma_vehicle_registry.Vehicle_No = tyre_details.Vehicle_No
  				Inner Join
  				ma_driver On tyre_details.Driver_ID = ma_driver.Driver_ID
				Where ma_vehicle_registry.Vehicle_No = '".$Vehicle."'";
        $rawData = Yii::app()->db->createCommand($query)->queryAll();
        //print_r($rawData);
        //exit;
        return $rawData;
    }

    public function getNotAllocatedVehicels()
    {
        $cmd = "
			SELECT 
			 Vehicle_No 
			FROM ma_vehicle_registry vr 
			WHERE NOT EXISTS (SELECT Vehicle_No FROM vehicle_location vl WHERE vl.Vehicle_No = vr.Vehicle_No)
			ORDER BY `vr`.`Vehicle_No` ASC
			";

        $rowData = Yii::app()->db->createCommand($cmd)->queryAll();
        return $rowData;
    }

    public function getVehicles($vNo)
    {
        $cmd = "
                SELECT 
                 Vehicle_No 
                FROM ma_vehicle_registry  
                WHERE Vehicle_No = '$vNo'
                ";

        $rowData = Yii::app()->db->createCommand($cmd)->queryAll();
        return $rowData;
    }


    public function getVehicleList()
    {
        //echo (Yii::app()->getModule('user')->user()->Location_ID); exit;
        $criteria=new CDbCriteria;
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
        //echo $superuserstatus; exit;
        $criteria->compare('t.Vehicle_No',$this->Vehicle_No,true);
        //$criteria->compare('t.Vehicle_Category_ID',$this->Vehicle_Category_ID);


        $criteria->compare('vehicleCategory.Category_Name',$this->Vehicle_Category_ID, true);
        $criteria->compare('makeID.Make',$this->Make_ID, true);

        $criteria->with = array('vehicleCategory'=>array('select'=>'vehicleCategory.Category_Name', 'together'=>true), 'makeID'=>array('select'=>'makeID.Make','together'=>true));
        $criteria->compare('Registration_Fee',$this->Registration_Fee,true);
        $criteria->compare('Purchase_Value',$this->Purchase_Value,true);
        $criteria->compare('Purchase_Date',$this->Purchase_Date,true);
        $criteria->compare('Engine_No',$this->Engine_No,true);
        $criteria->compare('Chassis_No',$this->Chassis_No,true);

        #if ($superuserstatus != 1)$criteria->compare('Location_ID',$LocId);
        if ($superuserstatus != 1)
        {
            $criteria->mergeWith(array('join'=>'INNER JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No', 'condition'=>'vl.Current_Location_ID ='.$LocId,));
        }
        else
        {
            #$criteria->mergeWith(array('join'=>'INNER JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No'));
        }

        $criteria->compare('Fuel_Type_ID',$this->Fuel_Type_ID);
        $criteria->compare('Tyre_Size_ID',$this->Tyre_Size_ID);
        $criteria->compare('Tyre_Size_ID_2',$this->Tyre_Size_ID_2);
        $criteria->compare('Tyre_Type_ID',$this->Tyre_Type_ID);
        $criteria->compare('No_of_Tyres',$this->No_of_Tyres,true);
        $criteria->compare('Model_ID',$this->Model_ID,true);
        $criteria->compare('Location_ID',$this->Location_ID,true);
        $criteria->compare('Make_Year',$this->Make_Year,true);
        $criteria->compare('Battery_Type_ID',$this->Battery_Type_ID);
        $criteria->compare('Vehicle_Status_ID',$this->Vehicle_Status_ID);
        $criteria->compare('Service_Mileage',$this->Service_Mileage,true);
        $criteria->compare('Servicing_Period',$this->Servicing_Period,true);
        $criteria->compare('Fuel_Consumption',$this->Fuel_Consumption,true);
        $criteria->compare('Fitness_test',$this->Fitness_test,true);
        /*$criteria->compare('add_by',$this->add_by,true);
        $criteria->compare('add_date',$this->add_date,true);
        $criteria->compare('edit_by',$this->edit_by,true);
        $criteria->compare('edit_date',$this->edit_date,true);*/

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria, 'pagination'=>array('pageSize'=>35), 'sort'=>array('defaultOrder'=>'t.Vehicle_No ASC')
        ));
    }

    public function getVehicleListLocationWise()
    {
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
         if($superuserstatus != 1)
        {
            $criteria=new CDbCriteria;
        }
        else
        {
            $criteria=new CDbCriteria(array( 'order'=>'l.Location_Name ASC, t.Vehicle_No ASC', // this uses two criteria: first start_date, then end_date.
            ));
        }

        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);

        $criteria->compare('t.Vehicle_No',$this->Vehicle_No,true);
        $criteria->compare('vehicleCategory.Category_Name',$this->Vehicle_Category_ID, true);
        $criteria->compare('makeID.Make',$this->Make_ID, true);


        $criteria->with = array('vehicleCategory'=>array('select'=>'vehicleCategory.Category_Name', 'together'=>true), 'makeID'=>array('select'=>'makeID.Make','together'=>true));
        $criteria->compare('Registration_Fee',$this->Registration_Fee,true);
        $criteria->compare('Purchase_Value',$this->Purchase_Value,true);
        $criteria->compare('Purchase_Date',$this->Purchase_Date,true);
        $criteria->compare('Engine_No',$this->Engine_No,true);
        $criteria->compare('Chassis_No',$this->Chassis_No,true);

        if ($superuserstatus != 1)
        {
            $criteria->mergeWith(array('join'=>'INNER JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No', 'condition'=>'vl.Current_Location_ID ='.$LocId,));
            $criteria->compare('l.Location_Name',$this->Location_ID, true);
        }
        else 
        {
            $criteria->mergeWith(array('join'=>'INNER JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No inner join ma_location l ON l.Location_ID = vl.Current_Location_ID'));     
        }

        //$criteria->mergeWith(array('join'=>'INNER JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No inner join ma_location l ON l.Location_ID = vl.Current_Location_ID'));



        $criteria->compare('Fuel_Type_ID',$this->Fuel_Type_ID);
        $criteria->compare('Tyre_Size_ID',$this->Tyre_Size_ID);
        $criteria->compare('Tyre_Size_ID_2',$this->Tyre_Size_ID_2);
        $criteria->compare('Tyre_Type_ID',$this->Tyre_Type_ID);
        $criteria->compare('No_of_Tyres',$this->No_of_Tyres,true);
        $criteria->compare('Model_ID',$this->Model_ID,true);
        //$criteria->compare('Make_ID',$this->Make_ID,true);
        $criteria->compare('Make_Year',$this->Make_Year,true);
        $criteria->compare('Battery_Type_ID',$this->Battery_Type_ID);
        $criteria->compare('Vehicle_Status_ID',$this->Vehicle_Status_ID);
        $criteria->compare('Service_Mileage',$this->Service_Mileage,true);
        $criteria->compare('Servicing_Period',$this->Servicing_Period,true);
        $criteria->compare('Fuel_Consumption',$this->Fuel_Consumption,true);
        $criteria->compare('Fitness_test',$this->Fitness_test,true);
        $criteria->compare('add_by',$this->add_by,true);
        $criteria->compare('add_date',$this->add_date,true);
        $criteria->compare('edit_by',$this->edit_by,true);
        $criteria->compare('edit_date',$this->edit_date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria, 'pagination'=>array('pageSize'=>30), /*'sort'=>array('defaultOrder'=>'t.Vehicle_No ASC')*/
        ));
    }





    public function getVehicleListByLocation()
    {

        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        //echo (Yii::app()->getModule('user')->user()->Location_ID); exit;
        $criteria=new CDbCriteria;
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);

        //echo $superuserstatus; exit;
        $criteria->compare('t.Vehicle_No',$this->Vehicle_No,true);
        //$criteria->compare('t.Vehicle_Category_ID',$this->Vehicle_Category_ID);


        $criteria->compare('vehicleCategory.Category_Name',$this->Vehicle_Category_ID, true);
        $criteria->compare('makeID.Make',$this->Make_ID, true);

        $criteria->with = array('vehicleCategory'=>array('select'=>'vehicleCategory.Category_Name', 'together'=>true), 'makeID'=>array('select'=>'makeID.Make','together'=>true));
        $criteria->compare('Registration_Fee',$this->Registration_Fee,true);
        $criteria->compare('Purchase_Value',$this->Purchase_Value,true);
        $criteria->compare('Purchase_Date',$this->Purchase_Date,true);
        $criteria->compare('Engine_No',$this->Engine_No,true);
        $criteria->compare('Chassis_No',$this->Chassis_No,true);

        #if ($superuserstatus != 1)$criteria->compare('Location_ID',$LocId);
        if ($superuserstatus != 1)
        {
            $criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No', 'condition'=>'vl.Location_ID ='.$LocId,));
        }

        $criteria->compare('Fuel_Type_ID',$this->Fuel_Type_ID);
        $criteria->compare('Tyre_Size_ID',$this->Tyre_Size_ID);
        $criteria->compare('Tyre_Size_ID_2',$this->Tyre_Size_ID_2);
        $criteria->compare('Tyre_Type_ID',$this->Tyre_Type_ID);
        $criteria->compare('No_of_Tyres',$this->No_of_Tyres,true);
        $criteria->compare('Model_ID',$this->Model_ID,true);
        //$criteria->compare('Make_ID',$this->Make_ID,true);
        $criteria->compare('Make_Year',$this->Make_Year,true);
        $criteria->compare('Battery_Type_ID',$this->Battery_Type_ID);
        $criteria->compare('Vehicle_Status_ID',$this->Vehicle_Status_ID);
        $criteria->compare('Service_Mileage',$this->Service_Mileage,true);
        $criteria->compare('Servicing_Period',$this->Servicing_Period,true);
        $criteria->compare('Fuel_Consumption',$this->Fuel_Consumption,true);
        $criteria->compare('Fitness_test',$this->Fitness_test,true);
        $criteria->compare('add_by',$this->add_by,true);
        $criteria->compare('add_date',$this->add_date,true);
        $criteria->compare('edit_by',$this->edit_by,true);
        $criteria->compare('edit_date',$this->edit_date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria, 'pagination'=>array('pageSize'=>30), 'sort'=>array('defaultOrder'=>'Purchase_Date DESC')
        ));
    }

    public function getVehicleListByLocationToMaintenance()
    {
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
        //
        if($superuserstatus != 1)
        {
            $criteria=new CDbCriteria;
        }
        else
        {
            $criteria=new CDbCriteria(array( 'order'=>'l.Location_Name ASC, t.Vehicle_No ASC', // this uses two criteria: first start_date, then end_date.
            ));
        }



        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);

        //echo $superuserstatus; exit;
        $criteria->compare('t.Vehicle_No',$this->Vehicle_No,true);

        #if ($superuserstatus != 1)$criteria->compare('Location_ID',$LocId);
        if ($superuserstatus != 1)
        {
            $criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No', 'condition'=>'vl.Current_Location_ID ='.$LocId,));$criteria->compare('vl.Current_Location_ID',$this->Location_ID);
        }
        else
        {
            $criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No inner join ma_location l ON l.Location_ID = vl.Current_Location_ID', 'condition'=>'vl.Vehicle_No IS NOT NULL'));$criteria->compare('l.Location_Name',$this->Location_ID);
        }

        #$criteria->compare('Make_ID',$this->Make_ID,true);
        #$criteria->compare('t.Vehicle_Category_ID',$this->Vehicle_Category_ID);

        $criteria->compare('vehicleCategory.Category_Name',$this->Vehicle_Category_ID, true);
        $criteria->compare('makeID.Make',$this->Make_ID, true);

        $criteria->with = array('vehicleCategory'=>array('select'=>'vehicleCategory.Category_Name', 'together'=>true), 'makeID'=>array('select'=>'makeID.Make','together'=>true));

        /*	$criteria->compare('t.Purchase_Value',$this->Purchase_Value,true);
            $criteria->compare('Purchase_Date',$this->Purchase_Date,true);
            $criteria->compare('Engine_No',$this->Engine_No,true);
            $criteria->compare('Chassis_No',$this->Chassis_No,true);



            //$this->getDbCriteria()->mergeWith( array(
       // 'alias' => 'vehicle_location',
      //  'join' => 'LEFT JOIN vehicle_driver ON vehicle_location.Vehicle_No=vehicle_driver.Vehicle_No',
      //  'condition' => 'vehicle_driver.Driver_ID IS NULL',
    //) );
    $criteria->mergeWith(array('join'=>'inner join vehicle_driver vd on vd.Vehicle_No  = t.Vehicle_No'));

            $criteria->compare('Fuel_Type_ID',$this->Fuel_Type_ID);
            $criteria->compare('Tyre_Size_ID',$this->Tyre_Size_ID);
            $criteria->compare('Tyre_Type_ID',$this->Tyre_Type_ID);
            $criteria->compare('No_of_Tyres',$this->No_of_Tyres,true);
            $criteria->compare('Model_ID',$this->Model_ID,true);
            //$criteria->compare('Make_ID',$this->Make_ID,true);
            $criteria->compare('Make_Year',$this->Make_Year,true);
            $criteria->compare('Battery_Type_ID',$this->Battery_Type_ID);
            $criteria->compare('Vehicle_Status_ID',$this->Vehicle_Status_ID);
            $criteria->compare('Service_Mileage',$this->Service_Mileage,true);
            $criteria->compare('Servicing_Period',$this->Servicing_Period,true);
            $criteria->compare('Fuel_Consumption',$this->Fuel_Consumption,true);
            $criteria->compare('Fitness_test',$this->Fitness_test,true);
            $criteria->compare('add_by',$this->add_by,true);
            $criteria->compare('add_date',$this->add_date,true);
            $criteria->compare('edit_by',$this->edit_by,true);
            $criteria->compare('edit_date',$this->edit_date,true);*/

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria, 'pagination'=>array('pageSize'=>20),));



    }

    public function getVehiclesLocationwise()
    {
        $criteria=new CDbCriteria;

        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        $criteria->compare('t.Vehicle_No',$this->Vehicle_No,true);

        $criteria->compare('vehicleCategory.Category_Name',$this->Vehicle_Category_ID, true);
        $criteria->compare('makeID.Make',$this->Make_ID, true);

        $criteria->with = array('vehicleCategory'=>array('select'=>'vehicleCategory.Category_Name', 'together'=>true), 'makeID'=>array('select'=>'makeID.Make','together'=>true));
        $criteria->compare('Registration_Fee',$this->Registration_Fee,true);
        $criteria->compare('Purchase_Value',$this->Purchase_Value,true);
        $criteria->compare('Purchase_Date',$this->Purchase_Date,true);
        $criteria->compare('Engine_No',$this->Engine_No,true);
        $criteria->compare('Chassis_No',$this->Chassis_No,true);

        #if ($superuserstatus != 1)$criteria->compare('Location_ID',$LocId);
        #if ($superuserstatus != 1)$criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = ma_vehicle_registry.Vehicle_No', 'condition'=>'vl.Location_ID ='.$LocId,));
#$criteria->mergeWith(array('join'=>'inner join vehicle_driver vd on vd.Vehicle_No  = t.Vehicle_No'));
        $this->getDbCriteria()->mergeWith( array(
            #'alias' => 'ma_vehicle_registry',
            'join' => 'LEFT JOIN vehicle_location ON vehicle_location.Vehicle_No=t.Vehicle_No',
            'condition' => 'vehicle_location.Vehicle_No IS NULL',
        ) );


        $criteria->compare('Fuel_Type_ID',$this->Fuel_Type_ID);
        $criteria->compare('Tyre_Size_ID',$this->Tyre_Size_ID);
        $criteria->compare('Tyre_Size_ID_2',$this->Tyre_Size_ID_2);
        $criteria->compare('Tyre_Type_ID',$this->Tyre_Type_ID);
        $criteria->compare('No_of_Tyres',$this->No_of_Tyres,true);
        $criteria->compare('Model_ID',$this->Model_ID,true);
        //$criteria->compare('Make_ID',$this->Make_ID,true);
        $criteria->compare('Make_Year',$this->Make_Year,true);
        $criteria->compare('Battery_Type_ID',$this->Battery_Type_ID);
        $criteria->compare('Vehicle_Status_ID',$this->Vehicle_Status_ID);
        $criteria->compare('Service_Mileage',$this->Service_Mileage,true);
        $criteria->compare('Servicing_Period',$this->Servicing_Period,true);
        $criteria->compare('Fuel_Consumption',$this->Fuel_Consumption,true);
        $criteria->compare('Fitness_test',$this->Fitness_test,true);
        $criteria->compare('add_by',$this->add_by,true);
        $criteria->compare('add_date',$this->add_date,true);
        $criteria->compare('edit_by',$this->edit_by,true);
        $criteria->compare('edit_date',$this->edit_date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria, 'sort'=>array('defaultOrder'=>'t.Vehicle_No ASC'), 'pagination'=>array('pageSize'=>30),
        ));
    }

    public function findAllVehicles()
    {
        $data = Yii::app()->db->createCommand('SELECT DISTINCT vr.Vehicle_No
FROM ma_vehicle_registry vr
INNER JOIN vehicle_location vl ON vl.Vehicle_No = vr.Vehicle_No
ORDER BY Vehicle_No ASC')->queryAll();

        return $data;
    }



    public function findAllVehiclesRegistry()
    {
        $data = Yii::app()->db->createCommand('SELECT Vehicle_No FROM ma_vehicle_registry ORDER BY Vehicle_No ASC')->queryAll();

        return $data;
    }

    public function findAssignVehicles()
    {
        $rowData = Yii::app()->db->createCommand('SELECT distinct vr.Vehicle_No FROM ma_vehicle_registry vr left join vehicle_location vl on vl.vehicle_no = vr.vehicle_no
where vl.Vehicle_no is null ORDER BY vr.Vehicle_No ASC')->queryAll();

        return $rowData;
    }
    /*public function getDriverName($vNo)
        {
            $cmd ='select Full_Name from ma_driver d
            inner join vehicle_driver vd on vd.Driver_ID = d.Driver_ID
            where vd.Vehicle_No ="'.$vNo.'"';
            $rowData = Yii::app()->db->createCommand($cmd)->queryAll();
            return $rowData;
        }*/

    public function removeImage($vNo)
    {

        MaVehicleRegistry::model()->updateByPk($vNo, array('Vehicle_image'=>'1111-'));
        //$this->updateByPk($vNo, array('Vehicle_image' =>'1111-'));
    }


    /*
     * @param -> $type ("date", "dateTime");
     * @return -> if (@param=="date") return server date; if(@param== "dateTime") return server datetime
     * */
    public function getServerDate($type)
    {
		date_default_timezone_set('Asia/Colombo');
        $arr = Yii::app()->db->createCommand('SELECT NOW() as date;')->queryAll();
        $count = count($arr);
        $curDate="";
        $curDateTime="";

        if($count>0)
        {
            $d = $arr[0]['date'];
            $dt = new DateTime($d);
            $curDate = $dt->format('Y-m-d');
            $curDateTime = $dt->format('Y-m-d H:i:s');
        }
        if($type === "date")
        {
            return $curDate;
        }
        else
        {
            return $curDateTime;
        }
    }

    public function findAllVehiclesLocationWise()
    {
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        $criteria=new CDbCriteria;
        $criteria->select="t.Vehicle_No,t.Vehicle_No";

$criteria->join="INNER JOIN vehicle_location vl ON vl.Vehicle_No=t.Vehicle_No";
        if($superuserstatus !=='1')
        {
            
            $criteria->condition="vl.Current_Location_ID=$LocId";

        }
        $criteria->order="t.Vehicle_No ASC";

        $arr = $this->findAll($criteria);
        return $arr;


    }

    public function menuarray($flg)
    {
        $superUser = Yii::app()->getModule('user')->user()->superuser;
        $men='';
        if($flg=='VehicleRegistry')
        {
            if($superUser == '1')
            {
                $men= '<li id="vregist"><div class="menuImg"><img src="images/vehicle_img1.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Vehicle Registry',array('/maVehicleRegistry/edit',"menuId"=>"vreg", "linkid"=>'vregist')).'</li>'.
                '<li id="vAssign"><div class="menuImg"><img src="images/assigndriver.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Vehicle Assigning for Location',array('/maVehicleRegistry/vehicleAsign&assign=true',"menuId"=>"vreg","linkid"=>'vAssign')).'</li>'.
                '<li id="vAssignDriver"><div class="menuImg"><img src="images/drivertloc.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Assign Driver for Vehicle',array('/tRVehicleLocation/notAssignedVehicles',"menuId"=>"vreg","linkid"=>'vAssignDriver')).'</li>'.
                '<li id="vTransfer"><div class="menuImg"><img src="images/transvehi.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Transfer Vehicle',array('/tRVehicleLocation/transferVehicle',"menuId"=>"vreg","linkid"=>'vTransfer')).'</li>';
            }
            else
            {
                $men= '<li id="vregist"><div class="menuImg"><img src="images/vehicle_img1.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Vehicle Registry',array('/maVehicleRegistry/edit',"menuId"=>"vreg","linkid"=>'vregist')).'</li>'.
                '<li id="vAssignDriver"><div class="menuImg"><img src="images/drivertloc.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Assign Driver for Vehicle',array('/tRVehicleLocation/notAssignedVehicles',"menuId"=>"vreg","linkid"=>'vAssignDriver')).'</li>'.
                '<li id="vTransfer"><div class="menuImg"><img src="images/transvehi.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Transfer Vehicle',array('/tRVehicleLocation/transferVehicle',"menuId"=>"vreg","linkid"=>'vTransfer')).'</li>';

            }

        }

        if($flg=='maDriver')
        {
            $men= '<li ="DriverReg"><div class="menuImg"><img src="images/driverRegistry.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Driver Registry',array('/maDriver/admin',"menuId"=>"driver","linkid"=>'DriverReg')).'</li>';


        }
        if($flg=='AssignDriver')
        {
            $men= CHtml::link('<li id="vregist"><img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/></li>',array('/maVehicleRegistry/edit',"linkid"=>'vregist')) .
                '<li id="vAssignDriver"><div class="menuImg"><img src="images/drivertloc.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Assign Driver',array('/tRVehicleLocation/notAssignedVehicles',"menuId"=>"vreg","linkid"=>'vAssignDriver')).'</li>'.
                '<li id="DriverAssigned"><div class="menuImg"><img src="images/driverAssigned.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Driver Assigned Vehicles',array('/vehicleDriver/admin',"menuId"=>"vreg","linkid"=>'DriverAssigned')).'</li>'.
                '<li id="DriverHistory"><div class="menuImg"><img src="images/DriverHistory.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Assigned Driver History',array('/tRVehicleLocation/assignedVehiclesForDriverHistory',"menuId"=>"vreg","linkid"=>'DriverHistory')).'</li>';
        }
        if($flg =='VehicleBookingLow')
        {
            $men= '<li id="BookingRequests"><div class="menuImg"><img src="images/booking.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Booking Requests',array('/tRVehicleBooking/booking',"menuId"=>"vehibooking","linkid"=>'BookingRequests')).' </li> '.
                '<li id="pendingBooking"><div class="menuImg"><img src="images/pendingbooking.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Pending Booking Requests',array('/tRVehicleBooking/pendingBooking',"menuId"=>"vehibooking","linkid"=>'pendingBooking')).'</li>'.
                '<li id="approvedBooking"><div class="menuImg"><img src="images/approvedbooking.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Approved Booking Requests',array('/tRVehicleBooking/approvedBooking',"menuId"=>"vehibooking","linkid"=>'approvedBooking')).'</li>'.
                '<li id="assignedVehicle"><div class="menuImg"><img src="images/assignedbookReq.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Assigned Booking Requests',array('/tRVehicleBooking/assignedVehicle',"menuId"=>"vehibooking","linkid"=>'assignedVehicle')).'</li>'.
                '<li id="disapprovedBooking"><div class="menuImg"><img src="images/disappbookingreq.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Disapproved Booking Requests',array('/tRVehicleBooking/disapprovedBooking',"menuId"=>"vehibooking","linkid"=>'disapprovedBooking')).'</li>';
        }
        if($flg =='VehicleBooking')
        {
            $men = '<li id="BookingRequests"><div class="menuImg"><img src="images/booking.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Booking Requests',array('/tRVehicleBooking/booking',"menuId"=>"vehibooking","linkid"=>'BookingRequests')).'</li>'.
                '<li id="pendingBooking"><div class="menuImg"><img src="images/pendingbooking.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Pending Booking Requests',array('/tRVehicleBooking/pendingBooking',"menuId"=>"vehibooking","linkid"=>'pendingBooking')).'</li>'.
                '<li id="approvedBooking"><div class="menuImg"><img src="images/approvedbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Approved Booking Requests',array('/tRVehicleBooking/approvedBooking',"menuId"=>"vehibooking","linkid"=>'approvedBooking')).'</li>'.
                '<li id="assignedVehicle"><div class="menuImg"><img src="images/assignedbookReq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Assigned Booking Requests',array('/tRVehicleBooking/assignedVehicle',"menuId"=>"vehibooking","menuId"=>"vehibooking","linkid"=>'assignedVehicle')).'</li>'.
                '<li id="disapprovedBooking"><div class="menuImg"><img src="images/disappbookingreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Disapproved Booking Requests',array('/tRVehicleBooking/disapprovedBooking',"menuId"=>"vehibooking","linkid"=>'disapprovedBooking')).'</li>'.
                '<li id="RejectedBooking"><div class="menuImg"><img src="images/regBookreq.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Cancelled Booking Requests',array('/tRVehicleBooking/RejectedBooking',"menuId"=>"vehibooking","linkid"=>'RejectedBooking')).'</li>'.                
                '<li id="completedBooking"><div class="menuImg"><img src="images/completed.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Completed Booking Requests',array('/tRVehicleBooking/completedBooking',"menuId"=>"vehibooking","linkid"=>'completedBooking')).'</li>'.
				'<li id="vehicleInOut"><div class="menuImg"><img src="images/odometer.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Vehicle IN and OUT',array('/tRVehicleBooking/vehiclelist',"menuId"=>"vehibooking","linkid"=>'vehicleInOut')).'</li>';
        }
        if($flg =='OdometerSinhala')
        {
            $men = '<li id="vehiclelist"><div class="menuImg"><img src="images/odometer.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Vehicle IN and OUT', array('/tRVehicleBooking/vehiclelist',"menuId"=>"vehibooking","linkid"=>'vehiclelist')).'</li>';
          //  $men = '<li id="vehiclelist"><div class="menuImg"><img src="images/odometer.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;ඔඩෝමීටර විස්තරය සම්පූර්ණ කිරිම', array('/tRVehicleBooking/vehiclelist',"menuId"=>"vehibooking","linkid"=>'vehiclelist')).'</li>';
              // '<li id="completedBooking"><div class="menuImg"><img src="images/completed.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;සම්පූර්ණ කළ අයදුම්', array('/tRVehicleBooking/completedBooking',"menuId"=>"vehibooking","linkid"=>'completedBooking')).'</li>'.
               
              //  '<li id="completedOdo"><div class="menuImg"><img src="images/completed.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;සම්පූර්ණ කළ ඔඩෝමීටර යාවත්කාලීන කිරිම්', array('/odometerUpdate/completedOdo',"menuId"=>"vehibooking","linkid"=>'completedOdo')).'</li>';
        }
        if($flg =='MaintenanceView')
        {
            $fitness = Yii::app()->session['fitnessStatus'];
            
            $men1 = '<li id="maintenanceRegistry">'. CHtml::link('<img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/>',array('/maVehicleRegistry/maintenanceRegistry',"menuId"=>"maintenance","linkid"=>'maintenanceRegistry')).'</li>'.
                    '<li id="services"><div class="menuImg"><img src="images/service.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Services',array('/tRServices/admin',"menuId"=>"maintenance","linkid"=>'services')).'</li>'.
                    '<li id="insurance"><div class="menuImg"><img src="images/insurance.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Insurance',array('/tRInsurance/admin',"menuId"=>"maintenance","linkid"=>'insurance')).'</li>'.
                    '<li id="emissiontest"><div class="menuImg"><img src="images/emission.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Emission Test',array('/tREmissionTest/admin',"menuId"=>"maintenance","linkid"=>'emissiontest')).'</li>';
                   
            $men2 =  '<li id="License"><div class="menuImg"><img src="images/licence.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;License',array('/tRLicense/admin',"menuId"=>"maintenance","linkid"=>'License')).'</li>'.
                    '<li id="Repair"><div class="menuImg"><img src="images/repair.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Repair',array('/tRRepairRequest/repair',"menuId"=>"maintenance","linkid"=>'Repair')).'</li>'.
                    '<li id="battery"><div class="menuImg"><img src="images/battary.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Battery',array('/tRBatteryDetails/battery',"menuId"=>"maintenance","linkid"=>'battery')).'</li>'.
                    '<li id="tyre"><div class="menuImg"><img src="images/tyre.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Tyre',array('/tRTyreDetails/tyre',"menuId"=>"maintenance","linkid"=>'tyre')).'</li>';
                   
            if($fitness == "Yes")
            {
                $fit =  '<li id="FitnessTest"><div class="menuImg"><img src="images/fitnessTest.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Fitness Test',array('/tRFitnessTest/admin',"menuId"=>"maintenance","linkid"=>'FitnessTest')) .'</li>';
                
                $men = $men1 . $fit.$men2;
                
            }
            else
            {
                $men = $men1.$men2;
            }

        }
        if($flg =='MaintenanceViewForDriver')
        {
            $men = '<li id="maintenanceRegistry">'.CHtml::link('<img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/>',array('/maVehicleRegistry/maintenanceRegistry',"menuId"=>"maintenance","linkid"=>'maintenanceRegistry')).'</li>'.
                '<li id="Repair"><div class="menuImg"><img src="images/repair.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;අලුත්වැඩියා සඳහා අයදුම් කිරීම',array('/tRRepairRequest/repair',"menuId"=>"maintenance","linkid"=>'Repair')).'</li>'.
                '<li id="battery"><div class="menuImg"><img src="images/battary.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;නව බැටරි සඳහා අයදුම් කිරීම  ',array('/tRBatteryDetails/battery',"menuId"=>"maintenance","linkid"=>'battery')).'</li>'.
                '<li id="tyre"><div class="menuImg"><img src="images/tyre.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;නව ටයර සඳහා අයදුම් කිරීම',array('/tRTyreDetails/tyre',"menuId"=>"maintenance","linkid"=>'tyre')).'</li>';
        }
        if($flg =='MaintenanceRepair')
        {
            $vehicleId = Yii::app()->session['maintenVehicleId'];

            $men = '<li>'. CHtml::link('<img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/>',array('/maVehicleRegistry/maintanenceview&id='.$vehicleId)).'</li>'.
                '<li id="Repair"><div class="menuImg"><img src="images/repair.png" style="height:40px; width="40px"/></div>'. CHtml::link('&nbsp;Repair Requests',array('/tRRepairRequest/repair',"menuId"=>"maintenance","linkid"=>'Repair')).'</li>'.
                '<li id="EstRepairReq"><div class="menuImg"><img src="images/estimage.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Estimate Repair Requests',array('/tRRepairRequest/admin',"menuId"=>"maintenance")).'</li>'.
                '<li id="AddRepairDetails"><div class="menuImg"><img src="images/addDetails.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Add Repair Details',array('/tRRepairEstimateDetails/approvedEstimates',"menuId"=>"maintenance","linkid"=>'AddRepairDetails')).'</li>'.
                '<li id="PenRepairDetails"><div class="menuImg"><img src="images/pendingbooking.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Pending Repair Requests',array('/tRRepairEstimateDetails/pendingRepairDetails',"menuId"=>"maintenance","linkid"=>'PenRepairDetails')).'</li>'.
                '<li id="approvedRepairDetails"><div class="menuImg"><img src="images/approvedbooking.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Approved Repair Requests',array('/tRRepairEstimateDetails/approvedRepairDetails',"menuId"=>"maintenance","linkid"=>'approvedRepairDetails')).'</li>'.
                '<li id="disapprovedRepairDetails"><div class="menuImg"><img src="images/disappbookingreq.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Disapproved Repair Requests',array('/tRRepairEstimateDetails/disapprovedRepairDetails',"menuId"=>"maintenance","linkid"=>'disapprovedRepairDetails')).'</li>'.
                '<li id="rejectedRepairDetails"><div class="menuImg"><img src="images/regBookreq.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Cancelled Repair Requests',array('/tRRepairEstimateDetails/rejectedRepairDetails',"menuId"=>"maintenance","linkid"=>'rejectedRepairDetails')).'</li>'.
                '<li id="completedRepairDetails"><div class="menuImg"><img src="images/completed.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Completed Repair Requests',array('/tRRepairEstimateDetails/completedRepairDetails',"menuId"=>"maintenance","linkid"=>'completedRepairDetails')).'</li>';


        }
        if($flg =='MaintenanceRepairForDriver')
        {
            $vehicleId = Yii::app()->session['maintenVehicleId'];

            $men = '<li>'. CHtml::link('<img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/>',array('/maVehicleRegistry/maintanenceview&id='.$vehicleId,"menuId"=>"maintenance")).'</li>'.
                '<li id="Repair"><div class="menuImg"><img src="images/repair.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;අලුත්වැඩියා සඳහා අයදුම් කිරීම',array('/tRRepairRequest/repair',"menuId"=>"maintenance","linkid"=>'Repair')).'</li>'.
                '<li id="PenRepairDetails"><div class="menuImg"><img src="images/pendingbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;දැනට පවතින අලුත්වැඩියා අයදුම්',array('/tRRepairEstimateDetails/pendingRepairDetails',"menuId"=>"maintenance","linkid"=>'PenRepairDetails')).'</li>'.
                '<li id="approvedRepairDetails"><div class="menuImg"><img src="images/approvedbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;අනුමත කළ අලුත්වැඩියා අයදුම්',array('/tRRepairEstimateDetails/approvedRepairDetails',"menuId"=>"maintenance","linkid"=>'approvedRepairDetails')).'</li>'.
                '<li id="disapprovedRepairDetails"><div class="menuImg"><img src="images/disappbookingreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;අනුමත නොකළ අලුත්වැඩියා අයදුම්',array('/tRRepairEstimateDetails/disapprovedRepairDetails',"menuId"=>"maintenance","linkid"=>'disapprovedRepairDetails')).'</li>'.
                '<li id="rejectedRepairDetails"><div class="menuImg"><img src="images/regBookreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;ප්‍රතික්‍ෂේප කරන ලද අලුත්වැඩියා අයදුම්',array('/tRRepairEstimateDetails/rejectedRepairDetails',"menuId"=>"maintenance","linkid"=>'rejectedRepairDetails')).'</li>';


        }
        if($flg =='MaintenanceBattery')
        {
            $vehicleId = Yii::app()->session['maintenVehicleId'];

            $men = '<li>'. CHtml::link('<img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/>',array('/maVehicleRegistry/maintanenceview&id='.$vehicleId,"menuId"=>"maintenance")).'</li>'.
                '<li id="battery"><div class="menuImg"><img src="images/battary.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Battery Requests',array('/tRBatteryDetails/battery',"menuId"=>"maintenance","linkid"=>'battery')).'</li>'.
                '<li id="batteryreplace"><div class="menuImg"><img src="images/replace.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Battery Replacement',array('/tRBatteryDetails/replace&type=replace',"menuId"=>"maintenance","linkid"=>'batteryreplace')).'</li>'.
                '<li id="pendingBatteryRequests"><div class="menuImg"><img src="images/pendingbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Pending Battery Requests',array('/tRBatteryDetails/pendingBatteryRequests',"menuId"=>"maintenance","linkid"=>'pendingBatteryRequests')).'</li>'.
                '<li id="approvedBatteryRequests"><div class="menuImg"><img src="images/approvedbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Approved Battery Requests',array('/tRBatteryDetails/approvedBatteryRequests',"menuId"=>"maintenance","linkid"=>'approvedBatteryRequests')).'</li>'.
                '<li id="disapprovedBatteryRequests"><div class="menuImg"><img src="images/disappbookingreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Disapproved Battery Requests',array('/tRBatteryDetails/disapprovedBatteryRequests',"menuId"=>"maintenance","linkid"=>'disapprovedBatteryRequests')).'</li>'.
                '<li id="rejectedBatteryRequests"><div class="menuImg"><img src="images/regBookreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Cancelled Battery Requests',array('/tRBatteryDetails/rejectedBatteryRequests',"menuId"=>"maintenance","linkid"=>'rejectedBatteryRequests')).'</li>'.
                '<li id="completedBatteryRequests"><div class="menuImg"><img src="images/completed.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Completed Battery Requests',array('/tRBatteryDetails/completedBatteryRequests',"menuId"=>"maintenance","linkid"=>'completedBatteryRequests')).'</li>';

        }
        if($flg =='MaintenanceBatteryForDriver')
        {
            $vehicleId = Yii::app()->session['maintenVehicleId'];

            $men = '<li>'.CHtml::link('<img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/>',array('/maVehicleRegistry/maintanenceview&id='.$vehicleId,"menuId"=>"maintenance")).'</li>'.
                '<li id="battery"><div class="menuImg"><img src="images/battary.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;බැටරි සඳහා අයදුම් කිරීම',array('/tRBatteryDetails/battery',"menuId"=>"maintenance","linkid"=>'battery')).'</li>'.
                '<li id="pendingBatteryRequests"><div class="menuImg"><img src="images/pendingbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;දැනට පවතින බැටරි අයදුම්',array('/tRBatteryDetails/pendingBatteryRequests',"menuId"=>"maintenance","linkid"=>'pendingBatteryRequests')).'</li>'.
                '<li id="approvedBatteryRequests"><div class="menuImg"><img src="images/approvedbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;අනුමත කළ බැටරි අයදුම්',array('/tRBatteryDetails/approvedBatteryRequests',"menuId"=>"maintenance","linkid"=>'approvedBatteryRequests')).'</li>'.
                '<li id="disapprovedBatteryRequests"><div class="menuImg"><img src="images/disappbookingreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;අනුමත නොකළ බැටරි අයදුම්',array('/tRBatteryDetails/disapprovedBatteryRequests',"menuId"=>"maintenance","linkid"=>'disapprovedBatteryRequests')).'</li>'.
                '<li id="rejectedBatteryRequests"><div class="menuImg"><img src="images/regBookreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;ප්‍රතික්‍ෂේප කරන ලද  බැටරි අයදුම්',array('/tRBatteryDetails/rejectedBatteryRequests',"menuId"=>"maintenance","linkid"=>'rejectedBatteryRequests')).'</li>';

        }
        if($flg =='MaintenanceTyre')
        {
            $vehicleId = Yii::app()->session['maintenVehicleId'];

            $men = '<li>'.CHtml::link('<img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/>',array('/maVehicleRegistry/maintanenceview&id='.$vehicleId,"menuId"=>"maintenance")).'</li>'.
                '<li id="tyre"><div class="menuImg"><img src="images/tyre.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Tyre Requests',array('/tRTyreDetails/tyre',"menuId"=>"maintenance","linkid"=>'tyre')).'</li>'.
                '<li id="tyrereplace"><div class="menuImg"><img src="images/replace.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Tyre Replacement',array('/tRTyreDetails/replace',"menuId"=>"maintenance","linkid"=>'tyrereplace')).'</li>'.
                '<li id="pendingTyreRequests"><div class="menuImg"><img src="images/pendingbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Pending Tyre Requests',array('/tRTyreDetails/pendingTyreRequests',"menuId"=>"maintenance","linkid"=>'pendingTyreRequests')).'</li>'.
                '<li id="approvedTyreRequests"><div class="menuImg"><img src="images/approvedbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Approved Tyre Requests',array('/tRTyreDetails/approvedTyreRequests',"menuId"=>"maintenance","linkid"=>'approvedTyreRequests')).'</li>'.
                '<li id="disapprovedTyreRequests"><div class="menuImg"><img src="images/disappbookingreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Disapproved Tyre Requests',array('/tRTyreDetails/disapprovedTyreRequests',"menuId"=>"maintenance","linkid"=>'disapprovedTyreRequests')).'</li>'.
                '<li id="rejectedTyreRequests"><div class="menuImg"><img src="images/regBookreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Cancelled Tyre Requests',array('/tRTyreDetails/rejectedTyreRequests',"menuId"=>"maintenance","linkid"=>'rejectedTyreRequests')).'</li>'.
                '<li id="completedTyreRequests"><div class="menuImg"><img src="images/completed.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Completed Tyre Requests',array('/tRTyreDetails/completedTyreRequests',"menuId"=>"maintenance","linkid"=>'completedTyreRequests')).'</li>';

        }
        if($flg =='MaintenanceTyreForDriver')
        {
            $vehicleId = Yii::app()->session['maintenVehicleId'];

            $men = '<li>'. CHtml::link('<img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/>',array('/maVehicleRegistry/maintanenceview&id='.$vehicleId,"menuId"=>"maintenance")).'</li>'.
                '<li id="tyre"><div class="menuImg"><img src="images/tyre.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;ටයර සඳහා අයදුම් කිරීම',array('/tRTyreDetails/tyre',"menuId"=>"maintenance","linkid"=>'tyre')).'</li>'.
                '<li id="pendingTyreRequests"><div class="menuImg"><img src="images/pendingbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;දැනට පවතින ටයර අයදුම්',array('/tRTyreDetails/pendingTyreRequests',"menuId"=>"maintenance","linkid"=>'pendingTyreRequests')).'</li>'.
                '<li id="approvedTyreRequests"><div class="menuImg"><img src="images/approvedbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;අනුමත කළ ටයර අයදුම්',array('/tRTyreDetails/approvedTyreRequests',"menuId"=>"maintenance","linkid"=>'approvedTyreRequests')).'</li>'.
                '<li id="disapprovedTyreRequests"><div class="menuImg"><img src="images/disappbookingreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('අනුමත නොකළ ටයර අයදුම්',array('/tRTyreDetails/disapprovedTyreRequests',"menuId"=>"maintenance","linkid"=>'disapprovedTyreRequests')).'</li>'.
                '<li id="rejectedTyreRequests"><div class="menuImg"><img src="images/regBookreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;ප්‍රතික්‍ෂේප කරන ලද ටයර අයදුම්',array('/tRTyreDetails/rejectedTyreRequests',"menuId"=>"maintenance","linkid"=>'rejectedTyreRequests')).'</li>';

        }
        if($flg=='Access')
        {
            if($superUser == '1')
            {
                $men= '<li id="accessrole"><div class="menuImg"><img src="images/manageRole.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Manage Role',array('/role/admin',"menuId"=>"access","linkid"=>'accessrole')).'</li>'.
                '<li id="accessuser"><div class="menuImg"><img src="images/manageUser.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Manage User',array('user/admin',"menuId"=>"access","linkid"=>'accessuser')).'</li>'.
                '<li id="assignpermission"><div class="menuImg"><img src="images/accessPermission.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Access Permission',array('/accessControllers/assignpermission',"menuId"=>"access","linkid"=>'assignpermission')).'</li>'.
                 '<li id="assignpermission"><div class="menuImg"><img src="images/accessPermission.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Dashboard Permission',array('/dashboardPermission/admin',"menuId"=>"access","linkid"=>'dashbrdpermission')).'</li>';
           
                }
            else 
            {
                $men= '<li id="accessuser"><div class="menuImg"><img src="images/manageUser.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Manage User',array('user/admin',"menuId"=>"access","linkid"=>'accessuser')).'</li>';
            }
        }
        if($flg=='AccessInUser')
        {
            if($superUser == '1')
            {
                $men= '<li id="accessrole"><div class="menuImg"><img src="images/manageRole.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Manage Role',array('/role/admin',"menuId"=>"access","linkid"=>'accessrole')).'</li>'.
                '<li id="accessuser"><div class="menuImg"><img src="images/manageUser.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Manage User',array('admin',"linkid"=>'accessuser',"menuId"=>"access")).'</li>'.
                '<li id="assignpermission"><div class="menuImg"><img src="images/accessPermission.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Access Permission',array('/accessControllers/assignpermission',"menuId"=>"access","linkid"=>'assignpermission')).'</li>';
            }
            else 
            {
                $men= '<li id="accessuser"><div class="menuImg"><img src="images/manageUser.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Manage User',array('admin',"menuId"=>"access","linkid"=>'accessuser')).'</li>';
            }
        }
        if($flg=='Accident')
        {
            $men= '<li id="accidentReg"><div class="menuImg"><img src="images/accident.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Add Accident Details',array('maVehicleRegistry/accident',"menuId"=>"accident","linkid"=>'accidentReg')).'</li>'.
                '<li id="estimateAccident"><div class="menuImg"><img src="images/estimage.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Add Estimations Details',array('/tRAccident/estimateAccident',"menuId"=>"accident","linkid"=>'estimateAccident')).'</li>'.
                '<li id="estimateClaime"><div class="menuImg"><img src="images/addClaim.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Add Claims Details',array('/tREstimateDetails/estimateClaime',"menuId"=>"accident","linkid"=>'estimateClaime')).'</li>';

        }

        if($flg=='ReportMaintenance')
        {
            $men= 
			//'<li><div class="menuImg"><img src="images/vehicle_img1.png" style="height:40px; width:40px"/></div>'. CHtml::link(' Vehicle Mileage',array('report/vehicleMileage')).'</li>'.
                '<li id="vehicleRepaireService"><div class="menuImg"><img src="images/repair.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Repair/Service Report',array('report/vehicleRepaireService',"menuId"=>"reports","linkid"=>'vehicleRepaireService')).'</li>'.
                '<li id="vehicleMaintenanceCost"><div class="menuImg"><img src="images/maintain.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Maintenance Cost Reports',array('report/vehicleMaintenanceCost',"menuId"=>"reports","linkid"=>'vehicleMaintenanceCost')).'</li>'.
                '<li id="reportInsurance"><div class="menuImg"><img src="images/due.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Insurance Due Report',array('report/Insurance',"menuId"=>"reports","linkid"=>'reportInsurance')).'</li>'.
                '<li id="RevenueLicense"><div class="menuImg"><img src="images/due.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;License Due Report',array('report/RevenueLicense',"menuId"=>"reports","linkid"=>'RevenueLicense')).'</li>'.
                '<li id="FitnessTest"><div class="menuImg"><img src="images/due.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Fitness Test Due Report',array('report/FitnessTest',"menuId"=>"reports","linkid"=>'FitnessTest')).'</li>'.
                '<li id="reportemissionTest"><div class="menuImg"><img src="images/due.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Emission Test Due Report',array('report/emissionTest',"menuId"=>"reports","linkid"=>'reportemissionTest')).'</li>'.
				
                '<li id="FuelConsumptionByVehicle"><div class="menuImg"><img src="images/fuel.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Fuel Consumption Report - Vehicle wise',array('report/FuelConsumptionByVehecle',"menuId"=>"reports","linkid"=>'FuelConsumptionByVehicle')).'</li>'.
                '<li id="FuelConsumptionVehicleAllDate"><div class="menuImg"><img src="images/fuel.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Fuel Consumption Report - All vehicles',array('report/FuelConsumptionVehicleAllDate',"menuId"=>"reports","linkid"=>'FuelConsumptionVehicleAllDate')).'</li>';
        }
		
        if($flg=='ReportMovement')
        {
            $men= '<li id="reportvehicleBooking"><div class="menuImg"><img src="images/booking.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Vehicle Booking Report - Status wise',array('report/vehicleBooking',"menuId"=>"reports","linkid"=>'reportvehicleBooking')).'</li>'.
                '<li id="reportBookingsForVehicle"><div class="menuImg"><img src="images/booking.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Vehicle Booking Report - Vehicle wise',array('report/BookingsForVehicle',"menuId"=>"reports","linkid"=>'reportBookingsForVehicle')).'</li>'.
                '<li id="UserwiseBooking"><div class="menuImg"><img src="images/booking.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Vehicle Booking Report - Requester wise',array('report/UserwiseBooking',"menuId"=>"reports","linkid"=>'UserwiseBooking')).'</li>'.

                '<li id="DrverPerformanceByDriver"><div class="menuImg"><img src="images/performance.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Driver Performance Report - by Driver',array('report/DrverPerformanceByDriver',"menuId"=>"reports","linkid"=>'DrverPerformanceByDriver')).'</li>'.
                '<li id="DriverPerformance"><div class="menuImg"><img src="images/performance.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Driver Performance Summary Report',array('report/DriverPerformance',"menuId"=>"reports","linkid"=>'DriverPerformance')).'</li>'

            ;

        }

        if($flg=='ReportVehicleReg')
        {
            $men= '<li id="reportVehicleDetails"><div class="menuImg"><img src="images/vehicleReg.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Vehicle Detail',array('report/VehicleDetails',"menuId"=>"reports","linkid"=>'reportVehicleDetails')).'</li>'.
                '<li id="reportvehicleCategory"><div class="menuImg"><img src="images/vehicleReg.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Vehicle Category wise',array('report/vehicleCategory',"menuId"=>"reports","linkid"=>'reportvehicleCategory')).'</li>'.
                '<li id="reportvehicleAllocation"><div class="menuImg"><img src="images/allocate.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Vehicle Allocation Report',array('report/vehicleAllocation',"menuId"=>"reports","linkid"=>'reportvehicleAllocation')).'</li>'.
                '<li id="reportvehicleStatus"><div class="menuImg"><img src="images/vehicleReg.png" style="height:40px; width:40px"/></div>'.CHtml::link('&nbsp;Vehicle Status wise',array('report/vehicleStatus',"menuId"=>"reports","linkid"=>'reportvehicleStatus')).'</li>'.
                '<li id="AccidentReportVehicleWise"><div class="menuImg"><img src="images/performance.png" style="height:40px; width:40px"/></div>'. CHtml::link('&nbsp;Accident Report - Vehicle wise',array('report/AccidentReportVehicleWise',"menuId"=>"reports","linkid"=>'AccidentReportVehicleWise')).'</li>'

            ;

        }

        if($flg=='Fuel')
        {
            $vehicleId = Yii::app()->session['VehicleIdFuel'];
            $aid = Yii::app()->session['VehicleIdAllocationID'];

            $men = '<li id="fuelRequest">'.CHtml::link('<img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/>',array('/maVehicleRegistry/fuelRequest',"menuId"=>"fuel","linkid"=>'fuelRequest')).'</li>'.
                '<li id="fuelProvidingHistory"><div class="menuImg"><img src="images/fuelReq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Fuel Requests',array('/tRFuelProvidingDetails/fuelProvidingHistory&id='.$vehicleId.'&aid='.$aid,"menuId"=>"fuel","linkid"=>'fuelProvidingHistory')).'</li>'.
                '<li id="fuelapprovedRequests"><div class="menuImg"><img src="images/addFuelData.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Add Fuel Providing Details',array('/tRFuelRequestDetails/approvedRequests',"menuId"=>"fuel","linkid"=>'fuelapprovedRequests')).'</li>'.
                '<li id="pendingFuelRequests"><div class="menuImg"><img src="images/pendingbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Pending Fuel Requests',array('/tRFuelRequestDetails/pendingFuelRequests',"menuId"=>"fuel","linkid"=>'pendingFuelRequests')).'</li>'.
                '<li id="approvedFuelRequests"><div class="menuImg"><img src="images/approvedbooking.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Approved Fuel Requests',array('/tRFuelRequestDetails/approvedFuelRequests',"menuId"=>"fuel","linkid"=>'approvedFuelRequests')).'</li>'.
                '<li id="disapprovedFuelRequests"><div class="menuImg"><img src="images/disappbookingreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Disapproved Fuel Requests',array('/tRFuelRequestDetails/disapprovedFuelRequests',"menuId"=>"fuel","linkid"=>'disapprovedFuelRequests')).'</li>'.
                '<li id="rejectedFuelRequests"><div class="menuImg"><img src="images/regBookreq.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Cancelled Fuel Requests',array('/tRFuelRequestDetails/rejectedFuelRequests',"menuId"=>"fuel","linkid"=>'rejectedFuelRequests')).'</li>'.
                '<li id="completedFuelRequests"><div class="menuImg"><img src="images/completed.png" style="height:40px; width:40px"/></div>'.  CHtml::link('&nbsp;Completed Fuel Requests',array('/tRFuelRequestDetails/completedFuelRequests',"menuId"=>"fuel","linkid"=>'completedFuelRequests')).'</li>'
            ;

        }

        if($flg=='FuelForDriver')
        {
            $vehicleId = Yii::app()->session['VehicleIdFuel'];
            $aid = Yii::app()->session['VehicleIdAllocationID'];

            $men = '<li id="fuelRequest">'.CHtml::link('<img src="images/back.png" alt="Back" width="25px" style="margin-left:50%;"/>',array('/maVehicleRegistry/fuelRequest',"menuId"=>"fuel","linkid"=>'fuelRequest')).'</li>'.
                '<li id="fuelProvidingHistory">'.  CHtml::link('&nbsp;ඉන්ධන අයදුම් කිරීම',array('/tRFuelProvidingDetails/fuelProvidingHistory&id='.$vehicleId.'&aid='.$aid,"menuId"=>"fuel","linkid"=>'fuelProvidingHistory')).'</li>'.
                '<li id="approvedFuelRequests">'.  CHtml::link('&nbsp;දැනට පවතින ඉන්ධන අයදුම් ',array('/tRFuelRequestDetails/pendingFuelRequests',"menuId"=>"fuel","linkid"=>'fuelProvidingHistory')).'</li>'.
                '<li id="approvedFuelRequests">'.  CHtml::link('&nbsp;අනුමත ඉන්ධන අයදුම්',array('/tRFuelRequestDetails/approvedFuelRequests',"menuId"=>"fuel","linkid"=>'approvedFuelRequests')).'</li>'.
                '<li id="disapprovedFuelRequests">'.  CHtml::link('&nbsp;අනුමත නොකළ ඉන්ධන අයදුම්',array('/tRFuelRequestDetails/disapprovedFuelRequests',"menuId"=>"fuel","linkid"=>'disapprovedFuelRequests')).'</li>'
            ;
        }
//                    <p id='ProvincialCouncil'>". CHtml::link('Provincial Council', array('/maProvincialCouncils/admin',"menuId"=>"configuration","linkid"=>'ProvincialCouncil'))."</p>
//                    <p id='District'>". CHtml::link('District', array('/maDistrict/admin',"menuId"=>"configuration","linkid"=>'District'))."</p>
//                    <p id='DSDivision'>". CHtml::link('DS Division', array('/maDsDivision/admin',"menuId"=>"configuration","linkid"=>'DSDivision'))."</p>
//                    <p id='GNDivision'>".  CHtml::link('GN Division', array('/maGnDivision/admin',"menuId"=>"configuration","linkid"=>'GNDivision'))."</p>

        if($flg =="configurations")
        {
            $men ="
            <li>
                <h3>Admin Information</h3>
                <div>
                    <p id='Location'>". CHtml::link('Location', array('/maLocation/admin',"menuId"=>"configuration","linkid"=>'Location'))."</p>
                    <p id='bran'>". CHtml::link('Branch', array('/maBranch/admin',"menuId"=>"configuration","linkid"=>'bran'))."</p>
                    <p id='designation'>". CHtml::link('Designation', array('/maDesignation/admin',"menuId"=>"configuration","linkid"=>'designation'))."</p>                  
                </div>
            </li>

            <li>
                <h3>Vehicle Information</h3>
                <div>

                    <p id='make'>". CHtml::link('Make', array('/maMake/admin',"menuId"=>"configuration","linkid"=>'make'))."</p>
                    <p id='model'>". CHtml::link('Model', array('/maModel/admin',"menuId"=>"configuration","linkid"=>'model'))."</p>
                    <p id='VehicleCate'>". CHtml::link('Vehicle Category', array('/vehicleCategory/admin',"menuId"=>"configuration","linkid"=>'VehicleCate'))."</p>
                    <p id='FuelType'>". CHtml::link('Fuel Type', array('/fuelType/admin',"menuId"=>"configuration","linkid"=>'FuelType'))."</p>
                    <p id='VehiStatus'>". CHtml::link('Vehicle Status', array('/vehicleStatus/admin',"menuId"=>"configuration","linkid"=>'VehiStatus'))."</p>
                    <p id='TyreSize'>". CHtml::link('Tyre Size', array('/maTyreSize/admin',"menuId"=>"configuration","linkid"=>'TyreSize'))."</p>
                    <p id='TyreSize2'>". CHtml::link('Tyre Size 2', array('/maTyreSize/admin',"menuId"=>"configuration","linkid"=>'TyreSize2'))."</p>
                    <p id='TyreType'>". CHtml::link('Tyre Type', array('/maTyreType/admin',"menuId"=>"configuration","linkid"=>'TyreType'))."</p>
                    <p id='BatteryType'>". CHtml::link('Battery Type', array('/maBatteryType/admin',"menuId"=>"configuration","linkid"=>'BatteryType'))."</p>
                    <p id='odoupdateremark'>". CHtml::link('Odometer Update Remarks', array('/odometerUpdateRemark/admin',"menuId"=>"configuration","linkid"=>'odoupdateremark'))."</p>
                    
                </div>
            </li>


            <li>
                <h3>Service and Repair</h3>
                <div>
                    <p id='Supplier'>". CHtml::link('Supplier', array('/maSupplier/admin',"menuId"=>"configuration","linkid"=>'Supplier'))."</p>
                    <p id='Replacementofservice'>". CHtml::link('Replacement of Service', array('/maReplacementOfService/admin',"menuId"=>"configuration","linkid"=>'Replacementofservice'))."</p>
                    <p id='Servicestation'>". CHtml::link('Service Station', array('/maServiceStation/admin',"menuId"=>"configuration","linkid"=>'Servicestation'))."</p>
                    <p id='Servicetype'>". CHtml::link('Service Type', array('/maServiceType/admin',"menuId"=>"configuration","linkid"=>'Servicetype'))."</p>
                    <p id='GarageType'>". CHtml::link('Garage Type', array('/maGarageType/admin',"menuId"=>"configuration","linkid"=>'GarageType'))."</p>
                    <p id='Garage'>". CHtml::link('Garage', array('/maGarages/admin',"menuId"=>"configuration","linkid"=>'Garage'))."</p>
                    <p id='replacement'>". CHtml::link('Replacement', array('/maReplacement/admin',"menuId"=>"configuration","linkid"=>'replacement'))."</p>
                    <p id='Supplierofservicerep'>". CHtml::link('Supplier of Service Replacements', array('/maSupplierCategory/admin',"menuId"=>"configuration","linkid"=>'Supplierofservicerep'))."</p>
                    <p id='repairtype'>". CHtml::link('Repair Type', array('/maRepairType/admin',"menuId"=>"configuration","linkid"=>'repairtype'))."</p>
                    
                </div>
            </li>

            <li>
                <h3>Statutory Requirements</h3>
                <div>
                    <p id='emitestcom'>". CHtml::link('Emission Test Company', array('/maEmissionTestCompany/admin',"menuId"=>"configuration","linkid"=>'emitestcom'))."</p>
                    <p id='insurtype'>". CHtml::link('Insurance Type', array('/maInsuranceType/admin',"menuId"=>"configuration","linkid"=>'insurtype'))."</p>
                    <p id='insurcom'>". CHtml::link('Insurance Company', array('/maInsuranceCompany/admin',"menuId"=>"configuration","linkid"=>'insurcom'))."</p>

                </div>
            </li>";
            
            if($superUser === '1')
            {
              $men .="<li>
                <h3>System Configuration</h3>
                <div>
                    <p id='sysconfig'>". CHtml::link('System Configuration', array('/NotificationConfiguration/admin',"menuId"=>"configuration","linkid"=>'sysconfig'))."</p>
             <!--  <p id='dashbrdpermission'>". CHtml::link('Set Dashboard Permission', array('/dashboardPermission/admin',"menuId"=>"configuration","linkid"=>'dashbrdpermission'))."</p> -->          
                
                </div>
            </li>
           
            ";
            }
        }
        return $men;
    }
    
    public function getOdometer($vNo) 
    {
        $cri = new CDbCriteria();
        $cri->select = "odometer";
        $cri->condition="Vehicle_No='$vNo'";
        
        $arr = $this->findAll($cri);
        $odometer = '';
        if(count($arr)>0)
        {
            $odometer = $arr[0]['odometer'];
        }
        
        return $odometer;
    }
    
    public function getNumberOfPassengers($vNo)
    {
        $cri = new CDbCriteria();
        $cri->select = "Number_of_Passenger";
        $cri->condition="Vehicle_No='$vNo'"; 
        $arr = $this->find($cri);
        return $arr->Number_of_Passenger;
    }
    
    public function DashboardTotalAvailableVehicles($param) 
    {
        
    }
}