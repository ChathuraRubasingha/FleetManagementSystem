<?php

/**
 * This is the model class for table "fitness_test".
 *
 * The followings are the available columns in table 'fitness_test':
 * @property integer $Fitness_Test_ID
 * @property string $Vehicle_No
 * @property integer $Garage_ID
 * @property string $Valid_From
 * @property string $Valid_To
 * @property string $Fitness_Test_Result
 * @property string $Amount
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaGarages $garage
 * @property MaVehicleRegistry $vehicleNo
 * @property License[] $licenses
 */
class TRFitnessTest extends CActiveRecord
{
    public $Remaining_Days;
    /**
     * Returns the static model of the specified AR class.
     * @return TRFitnessTest the static model class
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
        return 'fitness_test';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Vehicle_No, Garage_ID, Valid_From, Valid_To, Fitness_Test_Result, Amount,Fitness_Test_Date', 'required'),
            array('Garage_ID', 'numerical', 'integerOnly'=>true),
            array('Vehicle_No', 'length', 'max'=>20),
            array('Fitness_Test_Result', 'length', 'max'=>100),
            array('Amount', 'length', 'max'=>50),
            array('add_by, edit_by', 'length', 'max'=>50),
            array('add_date, edit_date, Fitness_Test_Date', 'safe'),

            array('Amount', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Fitness_Test_ID, Vehicle_No, Garage_ID, Valid_From, Valid_To, Fitness_Test_Result, Amount, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
            'garage' => array(self::BELONGS_TO, 'MaGarages', 'Garage_ID'),
            'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
            'licenses' => array(self::HAS_MANY, 'License', 'Fitness_ID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'Fitness_Test_ID' => 'Fitness Test',
            'Vehicle_No' => 'Vehicle No',
            'Garage_ID' => 'Garage',
            'Fitness_Test_Date' => 'Fitness Test Date',
            'Valid_From' => 'Valid From',
            'Valid_To' => 'Valid To',
            'Fitness_Test_Result' => 'Fitness Test Result',
            'Amount' => 'Amount (Rs.)',
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

        $criteria = new CDbCriteria;

        $criteria->compare('Fitness_Test_ID',$this->Fitness_Test_ID);
        $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
        $criteria->compare('Garage_ID',$this->Garage_ID);
        $criteria->compare('Fitness_Test_Date',$this->Fitness_Test_Date);
        $criteria->compare('Valid_From',$this->Valid_From,true);
        $criteria->compare('Valid_To',$this->Valid_To,true);
        $criteria->compare('Amount',$this->Amount,true);
        $criteria->compare('add_by',$this->add_by,true);
        $criteria->compare('add_date',$this->add_date,true);
        $criteria->compare('edit_by',$this->edit_by,true);
        $criteria->compare('edit_date',$this->edit_date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function fitnessTest()
    {
        $superUser = Yii::app()->getModule('user')->user()->superuser;
        $locID = Yii::app()->getModule('user')->user()->Location_ID;
        $criteria=new CDbCriteria();
        if($superUser != 1)
        {
            $criteria->select = 't.Fitness_Test_ID, t.Vehicle_No,t.Valid_To,DATEDIFF(t.Valid_To,now()) AS Remaining_Days';
            $criteria->join = 'inner join vehicle_location vl On vl.Vehicle_No = t.Vehicle_No';
            $criteria->condition = 'now() between DATE_SUB(t.Valid_To,INTERVAL 30 DAY) and  t.Valid_To and vl.Current_Location_ID ='.$locID;
            $criteria->order = 't.Valid_To asc';
        }
        else
        {
            $criteria->select = 't.Fitness_Test_ID, t.Vehicle_No,t.Valid_To,DATEDIFF(t.Valid_To,now()) AS Remaining_Days';
            $criteria->condition = 'now() between DATE_SUB(t.Valid_To,INTERVAL 30 DAY) and  t.Valid_To ';
            $criteria->order = 't.Valid_To asc';
        }
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>30),
        ));
    }

    public function getFitnessTestVehicles()
    {
        $vehicleId = Yii::app()->session['maintenVehicleId'];
        #$data = "SELECT Fitness_Test_ID FROM fitness_test WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1";
        $data = "SELECT Fitness_test FROM ma_vehicle_registry WHERE Vehicle_No = '".$vehicleId."'";
        $rawData = Yii::app()->db->createCommand($data)->queryAll();

        return $rawData;
    }

    public function getFitnessTestHistory()
    {
        $criteria=new CDbCriteria;

        $vehicleId = Yii::app()->session['maintenVehicleId'];

        $criteria->compare('Vehicle_No',$vehicleId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'Valid_To DESC',
            ),	
        ));
    }

    public function getFitnessTestResult()
    {
        $vehicleId = Yii::app()->session['maintenVehicleId'];

        $query = "SELECT Fitness_Test_ID,Fitness_Test_Date,Valid_From,Valid_To,Fitness_Test_Result FROM fitness_test   
        WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1";

        $rawData = Yii::app()->db->createCommand($query)->queryAll();

        return $rawData; 	
    }

    public function DashboardFitnessTest($superuserstatus,$locID)
    {
        $condition = "";
        if ($superuserstatus != 1)
        {
            $condition = " and vl.Current_Location_ID =$locID";
        }

        $cri13 = new CDbCriteria();
        $cri13->select="count(Fitness_Test_ID) as Fitness_Test_ID";
        $cri13->join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
        $cri13->condition="now() between DATE_SUB(t.Valid_To,INTERVAL 30 DAY) and  t.Valid_To".$condition;
        $array13 = TRFitnessTest::model()->findAll($cri13);

        $countPendingFitnessTest = 0;
        if (count($array13) > 0)
        {
            $countPendingFitnessTest = $array13[0]['Fitness_Test_ID'];
        }

        return $countPendingFitnessTest;
    }
    
   /* public function getFitnessTestResult()
    {
        $vehicleId = Yii::app()->session['maintenVehicleId'];

        $query = "SELECT Fitness_Test_ID, Valid_From, Valid_To, Fitness_Test_Result FROM fitness_test 
        WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1";

        $rawData = Yii::app()->db->createCommand($query)->queryAll();

        return $rawData;
    }*/

}