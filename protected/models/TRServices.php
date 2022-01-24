<?php

/**
 * This is the model class for table "services".
 *
 * The followings are the available columns in table 'services':
 * @property integer $Services_ID
 * @property string $Vehicle_No
 * @property integer $Service_Station_ID
 * @property integer $Service_Type_ID
 * @property string $Service_Date
 * @property string $Meter_Reading
 * @property string $Driving_Distance
 * @property string $Description
 * @property string $Estimate_Cost
 * @property string $Approved_By
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaServiceStation $serviceStation
 * @property MaServiceType $serviceType
 * @property MaVehicleRegistry $vehicleNo
 */
class TRServices extends CActiveRecord
{
    //public $ids = true;
    /*
     * Returns the static model of the specified AR class.
     * @return TRServices the static model class
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
        return 'services';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Vehicle_No,Service_Date,Service_Station_ID,Service_Type_ID,Driver_ID,Estimate_Cost,Meter_Reading', 'required'),
            array('Service_Station_ID, Service_Type_ID', 'numerical', 'integerOnly'=>true),
            array('Vehicle_No', 'length', 'max'=>20),
            array('Meter_Reading, Driving_Distance, Approved_By', 'length', 'max'=>50),
            array('add_by, edit_by', 'length', 'max'=>50),
            array('add_date, edit_date,Next_Service_Milage,Next_Service_Date', 'safe'),
            array('Description', 'length', 'max'=>255),
            array('Estimate_Cost, Other_Costs','length', 'max'=>10),
            array('Service_Date', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            #array('Meter_Reading', 'match', 'pattern'=>'/^([0-9])+$/'),
            #array('Driving_Distance', 'match', 'pattern'=>'/^([0-9])+$/'),
            //array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
            //array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
            array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20})+$/'),

            array('Next_Service_Milage, Meter_Reading, Driving_Distance', 'match', 'pattern'=>'/^([0-9\. ])+$/'),
            //array('Estimate_Cost', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),
            array('Estimate_Cost', 'match', 'pattern'=>'/^[0-9]{1}[0-9]+(\.[0-9]*)?$/'),
             array('Other_Costs', 'match', 'pattern'=>'/^[0-9]+(\.[0-9]*)?$/'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Services_ID, Vehicle_No, Driver_ID, Service_Station_ID, Service_Type_ID, Service_Date, Meter_Reading, Driving_Distance, Description, Estimate_Cost, Other_Costs, Approved_By, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
            'serviceStation' => array(self::BELONGS_TO, 'MaServiceStation', 'Service_Station_ID'),
            'serviceType' => array(self::BELONGS_TO, 'MaServiceType', 'Service_Type_ID'),
            'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'Services_ID' => 'Services',
            'Vehicle_No' => 'Vehicle No',
            'Driver_ID' => 'Driver',
            'Service_Station_ID' => 'Service Station',
            'Service_Type_ID' => 'Service Type',
            'Service_Date' => 'Service Date',
            'Meter_Reading' => 'Meter Reading',
            'Next_Service_Date' => 'Next Service Date',
            'Next_Service_Milage' => 'Next Service Mileage (km)',
            'Driving_Distance' => 'Driven Distance (km)',
            'Description' => 'Description',
            'Estimate_Cost' => 'Service Cost(Rs.)',
            'Other_Costs'=>'Other Costs(Rs.)',
            'Approved_By' => 'Approved By',
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

        $criteria->compare('Services_ID',$this->Services_ID);
        $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
        $criteria->compare('Service_Station_ID',$this->Service_Station_ID);
        $criteria->compare('Service_Type_ID',$this->Service_Type_ID);
        $criteria->compare('Service_Date',$this->Service_Date,true);
        $criteria->compare('Meter_Reading',$this->Meter_Reading,true);
        $criteria->compare('Driving_Distance',$this->Driving_Distance,true);
        $criteria->compare('Description',$this->Description,true);
        $criteria->compare('Estimate_Cost',$this->Estimate_Cost,true);
        $criteria->compare('Other_Costs',$this->Other_Costs,true);
        $criteria->compare('Approved_By',$this->Approved_By,true);
        $criteria->compare('add_by',$this->add_by,true);
        $criteria->compare('add_date',$this->add_date,true);
        $criteria->compare('edit_by',$this->edit_by,true);
        $criteria->compare('edit_date',$this->edit_date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getServiceTestHistory()
    {
        $criteria=new CDbCriteria;

        $vehicleId = Yii::app()->session['maintenVehicleId'];

        $criteria->compare('Vehicle_No',$vehicleId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'Service_Date DESC',
            ),
        ));
    }



    public function savereplacement($ids, $prices, $NextMillages, $id)
    {
        $delete =Yii::app()->db->createCommand('delete  from service_replacement where Services_ID='.$id)->execute();
        $countPrices = count($prices);
        $r=0;
        for($i=0; $i<$countPrices; $i++)
        {
            $price = $prices[$i];
			$NextMilage = $NextMillages[$i];
			
            if($price !='' || $NextMilage != '')
            {

                $replace = $ids[$r];
                $price =  str_replace(',','', $price);
				$NextMilage =  str_replace(',','', $NextMilage);
				
                $sql="insert into service_replacement(Services_ID,Replacement_of_Service_ID) values (" . $id . ",".$replace.")";
                $rawData = Yii::app()->db->createCommand($sql)->execute();


                $sql="UPDATE service_replacement SET Price = '".$price."' , Next_Service_Milage = '" . $NextMilage . "'  WHERE Services_ID = " . $id . " and Replacement_of_Service_ID  =".$replace.";";
                $rawData = Yii::app()->db->createCommand($sql)->execute();

                $r=$r+1;
            }

        }

        /*foreach ($ids as $b)
        {
            $sql="insert into service_replacement(Services_ID,Replacement_of_Service_ID) values (".$id.",".$b.")";
           $rawData = Yii::app()->db->createCommand($sql)->execute();

            foreach ($prices as $p)
            {
                if($p !='')
                {
                    $sql="UPDATE service_replacement SET Price = '".$p."'  WHERE Replacement_of_Service_ID  =".$b.";";
                    $rawData = Yii::app()->db->createCommand($sql)->execute();
                }

                //$this->updateByPk($id, array('Price' => $price));

            }

        }*/
        //var_dump($all.".....".$trr);exit;
        if(isset($price))
        {
        }
        /**/

        //$this->updateByPk($b, array('Services_ID' => "$id", 'Replacement_of_Service_ID'=>"$b"));

        return true;
    }

    public function deleteReplacement($id)
    {
        $delete =Yii::app()->db->createCommand('delete  from service_replacement where Services_ID='.$id)->execute();

        return true;
    }


    public function replacementOfService($sID)
    {
        $rows = Yii::app()->db->createCommand('select distinct Replacement_of_Service_ID from service_replacement where Services_ID ='.$sID)->queryAll();
        $result = '';
        if(!empty($rows))
            foreach ($rows as $row)
            {
                /*$url = $this->createUrl('create',array('Model_ID'=>$row['Model']));
                $result .= CHtml::link($row['Model'],$url) .'<br/>'; 	*/
                $rslt = $row['Replacement_of_Service_ID'];
                $arr = Yii::app()->db->createCommand('select Service_Replacement from ma_replacement_of_service where Replacement_of_Service_ID='.$rslt)->queryAll();

                $result .= $arr[0]['Service_Replacement'].", ";
            }
        return $result;



        /* $criteria=new CDbCriteria;
        $criteria->alias = 'services';
        $criteria->compare('Services_ID',$this->Services_ID);
        $criteria->compare('Vehicle_No',$this->Vehicle_No,true);
        $criteria->compare('Service_Station_ID',$this->Service_Station_ID);
        $criteria->compare('Service_Type_ID',$this->Service_Type_ID);
        $criteria->compare('Service_Date',$this->Service_Date,true);
        $criteria->compare('Meter_Reading',$this->Meter_Reading,true);
        $criteria->compare('Driving_Distance',$this->Driving_Distance,true);
        $criteria->compare('Description',$this->Description,true);
        $criteria->compare('Estimate_Cost',$this->Estimate_Cost,true);
        $criteria->compare('Approved_By',$this->Approved_By,true);
        $criteria->compare('add_by',$this->add_by,true);
        $criteria->compare('add_date',$this->add_date,true);
        $criteria->compare('edit_by',$this->edit_by,true);
        $criteria->compare('edit_date',$this->edit_date,true);


$criteria->join= 'JOIN service_replacement sr ON (services.Services_ID=sr.Services_ID)';

return new CActiveDataProvider($this, array(
    'criteria'=>$criteria,
    'sort'=>array(
        'defaultOrder'=>'reg_no ASC',
    ),
));*/

    }


}