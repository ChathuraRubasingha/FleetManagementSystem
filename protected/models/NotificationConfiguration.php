<?php

/**
 * This is the model class for table "notification_configuration".
 *
 * The followings are the available columns in table 'notification_configuration':
 * @property integer $Row
 * @property string $Configuration_Name
 * @property integer $Value
 * @property string $Description
 */
class NotificationConfiguration extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return NotificationConfiguration the static model class
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
		return 'notification_configuration';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('Value , Description', 'required'),
			array('Value', 'numerical', 'integerOnly'=>true),
			array('Configuration_Name, Booking_Non_Critical, Booking_Warning, Booking_Critical, Booking_Expiration', 'length', 'max'=>100),
			array('Description', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Row, Configuration_Name, Value, Description, Booking_Non_Critical, Booking_Warning, Booking_Critical, Booking_Expiration', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Row' => 'Row',
			'Configuration_Name' => 'Configuration Name',
			'Value' => 'Value',
			'Description' => 'Description',
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

		$criteria->compare('Row',$this->Row);
                
		$criteria->compare('Configuration_Name',$this->Configuration_Name,true);
		$criteria->compare('Value',$this->Value);
		$criteria->compare('Description',$this->Description,true);
//                $criteria->add($this->Row == "4" ? "On":"Off",$this->Row == "4");
                
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        
		));
	}
        
        /**
         * used by ► TREstimateDetailsController>actionGetAccidentType
         * param ► row number
         */
        public function getNotificationValue($rowNo) 
        {
            $value = Yii::app()->db->createCommand()
                ->select('Value')
                ->from('notification_configuration')
                ->where('Row="'.$rowNo.'"')
                ->queryScalar();
            
           
            return $value;
        }
        
//        public function status_On_or_Off($val){
//            
//             if(isset($val)){
//                 return $val == "1" ? 'On':'Off';
//             }
//            
//        }
}