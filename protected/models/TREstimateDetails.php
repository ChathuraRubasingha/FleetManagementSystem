<?php

/**
 * This is the model class for table "estimate_details".
 *
 * The followings are the available columns in table 'estimate_details':
 * @property integer $Estimate_ID
 * @property integer $Accident_ID
 * @property string $Damage_Estimate
 * @property string $Estimated_Date
 * @property string $Description
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property ClaimeDetails[] $claimeDetails
 * @property Accident $accident
 */
class TREstimateDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TREstimateDetails the static model class
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
		return 'estimate_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('Accident_ID, Vehicle_No,Damage_Estimate, Estimated_Date', 'required'),
                array('Accident_ID', 'numerical', 'integerOnly'=>true),
                array('Damage_Estimate', 'numerical'),
                //array('add_by, add_date, edit_by, edit_date', 'length', 'max'=>50),

                array('Damage_Estimate', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),
                //array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/\r\n ])+$/'),
                //array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/\r\n ]{0,20})+$/'),
                array('Description', 'match', 'pattern'=>'/^([0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20}[ \n\n][0-9A-Za-z\'\"\-\.\,\/ \r\n ]{0,20})+$/'),

                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('Estimate_ID, Accident_ID, Damage_Estimate, Estimated_Date, Description, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'claimeDetails' => array(self::HAS_MANY, 'ClaimeDetails', 'Estimate_ID'),
			'accident' => array(self::BELONGS_TO, 'TRAccident', 'Accident_ID'),
			'vehicleNo' => array(self::BELONGS_TO, 'MaVehicleRegistry', 'Vehicle_No'),
                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'Estimate_ID' => 'Estimate ID',
                'Accident_ID' => 'Accident ID',
                'Vehicle_No' => 'Vehicle No',
                'Damage_Estimate' => 'Estimate of Damage (Rs)',
                'Estimated_Date' => 'Estimated Date',
                'Description' => 'Description',
                //'Estimate_Status_Reason' => 'Status Reason',
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

            $criteria=new CDbCriteria;

            $vehicleId = Yii::app()->session['accidentVehicleId'];

            $criteria->compare('Estimate_ID',$this->Estimate_ID);
            $criteria->compare('Accident_ID',$this->Accident_ID);
            $criteria->compare('Vehicle_No',$vehicleId);
            $criteria->compare('Damage_Estimate',$this->Damage_Estimate,true);
            $criteria->compare('Estimated_Date',$this->Estimated_Date,true);
            $criteria->compare('Description',$this->Description,true);
            $criteria->compare('add_by',$this->add_by,true);
            $criteria->compare('add_date',$this->add_date,true);
            $criteria->compare('edit_by',$this->edit_by,true);
            $criteria->compare('edit_date',$this->edit_date,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
	
	public function getEstimateDetails()
	{
            $criteria=new CDbCriteria;
            $vehicleId = Yii::app()->session['accidentVehicleId'];

            $criteria->mergeWith(array('join'=>'LEFT JOIN claime_details cd ON t.Estimate_ID = cd.Estimate_ID ','condition' => 'cd.Estimate_ID IS NULL',));


            $criteria->compare('t.Estimate_ID',$this->Estimate_ID);
            $criteria->compare('Accident_ID',$this->Accident_ID);
            $criteria->compare('t.Vehicle_No',$vehicleId, true);
            $criteria->compare('Damage_Estimate',$this->Damage_Estimate,true);
            $criteria->compare('Estimated_Date',$this->Estimated_Date,true);
            $criteria->compare('Description',$this->Description,true);
            $criteria->compare('add_by',$this->add_by,true);
            $criteria->compare('add_date',$this->add_date,true);
            $criteria->compare('edit_by',$this->edit_by,true);
            $criteria->compare('edit_date',$this->edit_date,true);
            #$criteria->mergeWith(array('join'=>'LEFT JOIN claime_details cd ON cd.Estimate_ID = t.Estimate_ID', 'condition'=>'cd.Claime_Amount=""',));
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>30),'sort'=>array('defaultOrder'=>'t.Estimated_Date DESC')
            ));
	}
        
        public function getAccidentDriver($param,$estimateID) 
        {
            $result = Yii::app()->db->createCommand()
                ->select("ma_driver.$param")
                ->from('estimate_details')
                ->join('accident', 'accident.Accident_ID = estimate_details.Accident_ID')
                ->join('ma_driver','ma_driver.Driver_ID = accident.Driver_ID')
                ->where("estimate_details.Estimate_ID=$estimateID")
                ->queryScalar();
            
            return $result;
        }
}