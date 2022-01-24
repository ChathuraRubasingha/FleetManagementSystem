<?php

/**
 * This is the model class for table "fuel_providing_details".
 *
 * The followings are the available columns in table 'fuel_providing_details':
 * @property integer $Fuel_Providing_ID
 * @property integer $Fuel_Request_ID
 * @property integer $Fuel_Order_No
 * @property string $Fuel_Station
 * @property string $Vehicle_No
 * @property integer $Fuel_Type_ID
 * @property string $Fuel_Pumped_Date
 * @property integer $Fuel_Amount
 * @property string $Payable_Amount
 *
 * The followings are the available model relations:
 * @property MaFuelType $fuelType
 * @property FuelRequestDetails $fuelRequest
 * @property MaVehicleRegistry $vehicleNo
 */
class TRFuelProvidingDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRFuelProvidingDetails the static model class
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
		return 'fuel_providing_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('Fuel_Request_ID, Vehicle_No, Fuel_Type_ID,Fuel_Station, Fuel_Pumped_Date, Fuel_Amount, Payable_Amount', 'required'),
                array('Fuel_Request_ID, Fuel_Order_No, Fuel_Type_ID', 'numerical', 'integerOnly'=>true),
                array('Fuel_Station', 'length', 'max'=>100),
                array('Vehicle_No', 'length', 'max'=>20),
                array('Payable_Amount', 'length', 'max'=>50),
                array('add_by, edit_by, edit_date', 'length', 'max'=>50),
                array('add_date','safe'),

                array('Fuel_Amount,Payable_Amount','match','pattern'=>'/^(?!0\d|$)\d+(\.\d+)?$/'),

            array('Fuel_Pumped_Date', 'checkPrevious'),
			//array('Fuel_Amount', 'match', 'pattern'=>'/^0$|^[1-9][0-9]*$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Fuel_Providing_ID, Fuel_Request_ID, Fuel_Order_No, Fuel_Station, Vehicle_No, Fuel_Type_ID, Fuel_Pumped_Date, Fuel_Amount, Payable_Amount', 'safe', 'on'=>'search'),
		);
	}
    public function checkPrevious()
    {
        $Fuel_Pumped_Date =$this->Fuel_Pumped_Date;
        date_default_timezone_set('Asia/Colombo');
        $serverDate = MaVehicleRegistry::model()->getServerDate("date");

        if($Fuel_Pumped_Date > $serverDate)
        {
            $this->addError('Fuel_Pumped_Date',"'Fuel Pumped Date' should be a Previous Date");
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
			'fuelType' => array(self::BELONGS_TO, 'FuelType', 'Fuel_Type_ID'),
			'fuelRequest' => array(self::BELONGS_TO, 'TRFuelRequestDetails', 'Fuel_Request_ID'),
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
                    'Fuel_Providing_ID' => 'Fuel Providing',
                    'Fuel_Request_ID' => 'Fuel Request ID',
                    'Fuel_Order_No' => 'Fuel Order Number',
                    'Fuel_Station' => 'Fuel Station',
                    'Vehicle_No' => 'Vehicle No',
                    'Fuel_Type_ID' => 'Fuel Type',
                    'Fuel_Pumped_Date' => 'Fuel Pumped Date',
                    'Fuel_Amount' => 'Fuel Capacity (l)',
                    'Distance_Driven'=> 'Distance Driven (km)',
                    'Payable_Amount' => 'Payable Amount (Rs.)',
                    'add_by' => 'Add By',
                    'add_date' => 'Add Date',
                    'edit_by' => 'Edit By',
                    'edit_date' => 'Edit Date',
                );
            }
            else
            {
                return array(
                    'Fuel_Providing_ID' => 'Fuel Providing',
                    'Fuel_Request_ID' => 'ඉන්ධන අයදුම් අංකය ',
                    'Fuel_Order_No' => 'ඉන්ධන ලබා ගැනීමේ අංකය ',
                    'Fuel_Station' => 'ඉන්ධන පිරවුම් හල',
                    'Vehicle_No' => 'වාහන අංකය',
                    'Fuel_Type_ID' => 'ඉන්ධන වර්ගය',
                    'Fuel_Pumped_Date' => 'ඉන්ධන පිරවූ දිනය ',
                    'Fuel_Amount' => 'ඉන්ධන ප්‍රමාණය (ලීටර)',
                    'Distance_Driven'=> 'මෙතෙක් ගෙවන ලද දුර ප්‍රමාණය (කි.මී )',
                    'Payable_Amount' => 'ගෙවිය හැකි මුදල ',
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
		$vehicleId=Yii::app()->session['VehicleIdFuel'];
		//$criteria->compare('Fuel_Providing_ID',$this->Fuel_Providing_ID);
		//$criteria->compare('Fuel_Request_ID',$this->Fuel_Request_ID);
		$criteria->compare('Fuel_Order_No',$this->Fuel_Order_No);
		//$criteria->compare('Fuel_Station',$this->Fuel_Station,true);
		$criteria->compare('Vehicle_No',$vehicleId);
		$criteria->compare('Fuel_Type_ID',$this->Fuel_Type_ID);
		//$criteria->compare('Fuel_Pumped_Date',$this->Fuel_Pumped_Date,true);
		$criteria->compare('Fuel_Amount',$this->Fuel_Amount);
		$criteria->compare('Payable_Amount',$this->Payable_Amount,true);
		$criteria->order = 'Fuel_Pumped_Date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getFuelType()
	{		
		$data = "SELECT Fuel_Type_ID, Fuel_Type FROM  ma_fuel_type";
		$rawData = Yii::app()->db->createCommand($data)->queryAll();
		return $rawData;
	}
	
	
	
	public function getCompletedFuelRequests()
	{
		$criteria=new CDbCriteria;
		$vehicleId=Yii::app()->session['VehicleIdFuel'];
		//$criteria->compare('Fuel_Providing_ID',$this->Fuel_Providing_ID);
		//$criteria->compare('Fuel_Request_ID',$this->Fuel_Request_ID);
		$criteria->compare('Fuel_Order_No',$this->Fuel_Order_No);
		//$criteria->compare('Fuel_Station',$this->Fuel_Station,true);
		$criteria->compare('Vehicle_No',$vehicleId, true);
		$criteria->compare('Fuel_Type_ID',$this->Fuel_Type_ID);
		//$criteria->compare('Fuel_Pumped_Date',$this->Fuel_Pumped_Date,true);
		$criteria->compare('Fuel_Amount',$this->Fuel_Amount);
		$criteria->compare('Payable_Amount',$this->Payable_Amount,true);
		$criteria->order = 'Fuel_Pumped_Date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}


