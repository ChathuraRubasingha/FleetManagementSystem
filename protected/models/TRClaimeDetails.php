<?php

/**
 * This is the model class for table "claime_details".
 *
 * The followings are the available columns in table 'claime_details':
 * @property integer $Claime_ID
 * @property integer $Insurance_Company_ID
 * @property string $Claime_Amount
 * @property string $Claime_Date
 * @property string $Recovered_from_Driver
 * @property integer $Estimate_ID
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaInsuranceCompany $insuranceCompany
 * @property EstimateDetails $estimate
 */
class TRClaimeDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TRClaimeDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}

	/*
	 * @return string the associated database table name
	 */
	public function tableName()
	{
            return 'claime_details';
	}

	/*
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('Insurance_Company_ID, Claime_Amount, Claime_Date, Estimate_ID', 'required'),
                array('Insurance_Company_ID, Estimate_ID', 'numerical', 'integerOnly'=>true),
                array('Claime_Amount,Recovered_Amount,Sum_Insured', 'numerical'),
                array('add_by, add_date, edit_by, edit_date,', 'length', 'max'=>50),
                array('Sum_Insured, Recoverd_From', 'safe'),
                array('Thirdparty_Name', 'match', 'pattern'=>'/^([A-Za-z ])+$/'),
                array('Claime_Amount, Driver_Claim_Amount,Thirdparty_Claim_Amount', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9]) || ?$/'),
                array('Recovered_Amount', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),
                array('Sum_Insured', 'match', 'pattern'=>'/^[1-9]{1}[0-9]+(\.[0-9][0-9])?$/'),
                
                array('Claime_Date,Driver_Claim_Date, Thirdparty_Claim_Date', 'checkDate'),
                //array('Thirdparty_Name', 'checkEmpty'),
                array('Driver_Claim_Amount, Thirdparty_Claim_Amount', 'checkIsSetAmount'),
                
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('Claime_ID, Insurance_Company_ID, Claime_Amount, Driver_Claim_Amount,Thirdparty_Claim_Amount,Thirdparty_Name, Driver_ID, Claime_Date,Driver_Claim_Date, Thirdparty_Claim_Date, Recovered_Amount, Estimate_ID, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
            );
	}
        
        public function checkDate() 
        {
            $appDate = MaVehicleRegistry::model()->getServerDate('date');
            $insClaimDate = $this->Claime_Date;
            $thirdClaimDate = $this->Thirdparty_Claim_Date;
            $drvClaimDate = $this->Driver_Claim_Date;
            
            if(isset($insClaimDate) && $insClaimDate !== '0000-00-00' && $insClaimDate > $appDate )
            {
                $this->clearErrors();
                $this->addError($this->Claime_Date, "'Claim Date from Insurance' should be a previous date");
                return FALSE;
            }
            if(isset($drvClaimDate) && $drvClaimDate !== '0000-00-00' && $drvClaimDate > $appDate)
            {
                $this->clearErrors();
                $this->addError($this->Driver_Claim_Date, "'Claim Date from Driver' should be a previous date");
                return FALSE;
            }
            
            if($this->Thirdparty_Claim_Date == '' || $this->Thirdparty_Claim_Date === '0000-00-00')
            {
                 
                if($this->Thirdparty_Claim_Amount !== '' && $this->Thirdparty_Claim_Amount !== '0.00')
                {
                   $this->clearErrors();
                    $this->addError($this->Thirdparty_Claim_Date, "'Claim Date from Third Party' cannot be blank");
                    return FALSE;
                }
            }
            if($this->Driver_Claim_Date === '' || $this->Driver_Claim_Date === '0000-00-00')
            {
                if($this->Driver_Claim_Amount !== '' && $this->Driver_Claim_Amount !== '0.00')
                {
                
                    $this->clearErrors();
                    $this->addError($this->Driver_Claim_Amount, "'Claim Date from Driver' cannot be blank");
                    return FALSE;
                }
            }
                     
            
            if(isset($thirdClaimDate) && $thirdClaimDate !== '0000-00-00')
            {
                if($thirdClaimDate > $appDate)
                {
                    $this->clearErrors();
                    $this->addError($this->Thirdparty_Claim_Date, "'Claim Date from Third Party' should be a previous date");
                }                
                return FALSE;
            }
            
            
            
        }
        
        public function checkEmpty() 
        {
            if(isset($this->Thirdparty_Claim_Date) &&  $this->Thirdparty_Claim_Date !== '' && $this->Thirdparty_Claim_Date !== '0000-00-00')
            {
                if($this->Thirdparty_Name == '')
                {
                    $this->clearErrors();
                    $this->addError($this->Thirdparty_Name, "Third Party Name cannot be blank");
                    
                    if($this->Thirdparty_Claim_Amount == '' || $this->Thirdparty_Claim_Amount == '0.00')
                    {
                        $this->clearErrors();
                        $this->addError($this->Thirdparty_Claim_Amount, "Claim Amount from Third Party cannot be blank");
                    }
                    return FALSE;
                }
            }
            if(isset($this->Thirdparty_Name) && $this->Thirdparty_Name != '')
            {
                /*if($this->Thirdparty_Claim_Date == '' ||  $this->Thirdparty_Claim_Date == '0000-00-00')
                {
                    $this->clearErrors();
                    $this->addError($this->Thirdparty_Claim_Date, "Claim Date from Third Party cannot be blank");
                }*/
                if($this->Thirdparty_Claim_Amount == '' || $this->Thirdparty_Claim_Amount == '0.00')
                {
                    $this->clearErrors();
                    $this->addError($this->Thirdparty_Claim_Amount, "Claim Amount from Third Party cannot be blank");
                }
                 return FALSE;
                
            }
           
            
        }
        
        public function checkIsSetAmount() 
        {
            if($this->Thirdparty_Claim_Amount == '' || $this->Thirdparty_Claim_Amount == '0.00')
            {
                if(isset($this->Thirdparty_Claim_Date) && $this->Thirdparty_Claim_Date !== '' && $this->Thirdparty_Claim_Date !== '0000-00-00')
                {
                    $this->clearErrors();
                    $this->addError($this->Thirdparty_Claim_Amount, "Claim Amount from Third Party cannot be blank");
                    return FALSE;
                }
            }
            if($this->Driver_Claim_Amount == '' || $this->Driver_Claim_Amount == '0.00')
            {
                if(isset($this->Driver_Claim_Date) && $this->Driver_Claim_Date !== '' && $this->Driver_Claim_Date !== '0000-00-00')
                {
                    $this->clearErrors();
                    $this->addError($this->Driver_Claim_Amount, "Claim Amount from Driver cannot be blank");
                    return FALSE;
                }
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
                'insuranceCompany' => array(self::BELONGS_TO, 'MaInsuranceCompany', 'Insurance_Company_ID'),
                'estimate' => array(self::BELONGS_TO, 'TREstimateDetails', 'Estimate_ID'),
            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'Claime_ID' => 'Claim',
                'Insurance_Company_ID' => 'Insurance Company',
                'Claime_Amount' => 'Insurance Claim Amount (Rs.)',
                'Driver_Claim_Amount' => 'Driver Claim Amount (Rs.)',
                'Thirdparty_Claim_Amount' => 'Third party Claim Amount (Rs.)',
                'Claime_Date' => 'Claim Date',
                'Driver_Claim_Date' => 'Driver Claim Date',
                'Thirdparty_Claim_Date' => 'Third Party Claim Date',
                'Sum_Insured' => 'Sum Insured (Rs.)',
                'Recoverd_From' => 'Recoverd From',
                'Recovered_Amount' => 'Recovered Amount (Rs.)',
                'Estimate_ID' => 'Estimate ID',
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

            $criteria->compare('Claime_ID',$this->Claime_ID);
            $criteria->compare('Insurance_Company_ID',$this->Insurance_Company_ID);
            $criteria->compare('Claime_Amount',$this->Claime_Amount,true);
            $criteria->compare('Claime_Date',$this->Claime_Date,true);
            $criteria->compare('Recoverd_From',$this->Recoverd_From,true);
            $criteria->compare('Estimate_ID',$this->Estimate_ID);
            $criteria->compare('add_by',$this->add_by,true);
            $criteria->compare('add_date',$this->add_date,true);
            $criteria->compare('edit_by',$this->edit_by,true);
            $criteria->compare('edit_date',$this->edit_date,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
	
	public function getInsuranceCompany($vehicleId)
	{
            $data = "SELECT i.Insurance_ID,i.Insurance_Company_ID,c.Insurance_Company_Name FROM insurance i,ma_insurance_company c WHERE i.Insurance_Company_ID=c.Insurance_Company_ID AND Vehicle_No='".$vehicleId."' ";
            $rawData = Yii::app()->db->createCommand($data)->queryAll();
            $count=count($rawData);	

            if($count>0)
            {
                $InsComID=$rawData[0]['Insurance_Company_Name'];
            }
            else
            {

            }
            return $rawData;
	}
}