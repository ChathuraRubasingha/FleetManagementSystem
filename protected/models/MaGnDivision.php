<?php

/*
 * This is the model class for table "ma_gn_division".
 *
 * The followings are the available columns in table 'ma_gn_division':
 * @property integer $GN_Division_ID
 * @property string $GN_Division
 * @property integer $DS_Division_ID
 * @property string $add_by
 * @property string $add_date
 * @property string $edit_by
 * @property string $edit_date
 *
 * The followings are the available model relations:
 * @property MaDsDivision $dSDivision
 * @property MaLocation[] $maLocations
 */
class MaGnDivision extends CActiveRecord
{
	/*
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaGnDivision the static model class
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
		return 'ma_gn_division';
	}

	/*
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('GN_Division, DS_Division_ID,', 'required'),
			array('DS_Division_ID', 'numerical', 'integerOnly'=>true),
			array('GN_Division', 'length', 'max'=>200),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date, dSDivision.DS_Division, DS_Division_ID', 'safe'),
			
			array('GN_Division', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('GN_Division_ID, GN_Division, DS_Division_ID, dSDivision.DS_Division, add_by, add_date, edit_by, edit_date', 'safe', 'on'=>'search'),
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
			'dSDivision' => array(self::BELONGS_TO, 'MaDsDivision', 'DS_Division_ID'),
			'maLocations' => array(self::HAS_MANY, 'MaLocation', 'GN_Division_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'GN_Division_ID' => 'GN Division',
			'GN_Division' => 'GN Division',
			'DS_Division_ID' => 'DS Division',
			'add_by' => 'Add By',
			'add_date' => 'Add Date',
			'edit_by' => 'Edit By',
			'edit_date' => 'Edit Date',
		);
	}
	public function combodata($var,$ID)
	{
	
		$data=array();
		if($var == 'DI')
		{
			if(isset(Yii::app()->session['District_ID']) && !is_null(Yii::app()->session['District_ID']) )	
			{ 
				$data=MaDistrict::model()->findAll('District_ID=:District_ID', 
				array(':District_ID'=>(int)Yii::app()->session['District_ID']));
			}
			else
			{
				$data=MaDistrict::model()->findAll('Provincial_Councils_ID=:Provincial_Councils_ID', 
				array(':Provincial_Councils_ID'=>(int)$ID));
			}

			$data=CHtml::listData($data,'District_ID','District_Name');

			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option',
				array('value'=>$value),CHtml::encode($name),true);
			}
		//
//			 $data=MaDistrict::model()->findAll('District_ID=:District_ID', 
//							  array(':District_ID'=>(int)$ID));
//			 
//				$data=CHtml::listData($data,'District_ID','District_Name');
//				
//				
//				foreach($data as $value=>$name)
//				{
//					
//				}
//			   
   			
		}
		
		else if($var == 'DS')
		{
			//echo $ID;exit;
			if(isset(Yii::app()->session['DS_Division_ID']) && !is_null(Yii::app()->session['DS_Division_ID']) )	
			{ 
				$data=MaDsDivision::model()->findAll('DS_Division_ID=:DS_Division_ID', 
				array(':DS_Division_ID'=>(int)Yii::app()->session['DS_Division_ID']));		
			}
			else
			{
				$data=MaDsDivision::model()->findAll('District_ID=:District_ID', 
				array(':District_ID'=>(int)$ID));
			}
			$data=CHtml::listData($data,'DS_Division_ID','DS_Division');

			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option',
				array('value'=>$value),CHtml::encode($name),true);
			}
	
		}
		
		else if($var == 'GN')
		{
			if(isset(Yii::app()->session['GN_Division_ID']) && !is_null(Yii::app()->session['GN_Division_ID']))	
			{
				$data=MaGnDivision::model()->findAll('GN_Division_ID=:GN_Division_ID', 
				array(':GN_Division_ID'=>(int)Yii::app()->session['GN_Division_ID']));
			}
			else
			{
				$data=MaGnDivision::model()->findAll('DS_Division_ID=:DS_Division_ID', 
				array(':DS_Division_ID'=>(int)$ID));
			}
			$data=CHtml::listData($data,'GN_Division_ID','GN_Division');

			echo CHtml::tag('option',
			array('value'=>''),CHtml::encode(' Please Select '),true);
			
			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option',
				array('value'=>$value),CHtml::encode($name),true);
			}
		}
		return($data);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria(array('order'=>'dSDivision.DS_Division ASC, t.GN_Division ASC'));

		$criteria->compare('t.GN_Division_ID',$this->GN_Division_ID, true);
		$criteria->compare('t.GN_Division',$this->GN_Division,true);
		
		//$criteria->compare('t.DS_Division_ID',$this->DS_Division_ID, true);
		
		$criteria->compare('dSDivision.DS_Division',$this->DS_Division_ID, true);
		$criteria->with = array('dSDivision'=>array('select'=>'dSDivision.DS_Division','together'=>false));
			
		/*$criteria->with = array('dSDivision'=>array('select'=>'dSDivision.DS_Division','together'=>true));
		$criteria->compare('dSDivision.DS_Division',$this->DS_Division_ID, true);*/
		//$criteria->with = array('dSDivision');
		
		#$criteria->with = array('dSDivision'=>array('select'=>'dSDivision.DS_Division'));
		#$criteria->compare('dSDivision.DS_Division', $this->DS_Division_ID);
		
		$criteria->compare('t.add_by',$this->add_by,true);
		$criteria->compare('t.add_date',$this->add_date,true);
		$criteria->compare('t.edit_by',$this->edit_by,true);
		$criteria->compare('t.edit_date',$this->edit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,/*'sort'=>array('defaultOrder'=>'dSDivision.DS_Division ASC'),*/'pagination'=>array('pageSize'=>20,)
		));
	}
	
	
	private $_postTitle = null;
public function getPostTitle()
{
    if ($this->_postTitle === null && $this->post !== null)
    {
        $this->_postTitle = $this->post->title;
    }
    return $this->_postTitle;
}
public function setPostTitle($value)
{
    $this->_postTitle = $value;
}

public function getGnDiv($id)
{       
       if(($id !== "--- Please Select ---")&&($id !=='')){
            
           $data = Yii::app()->db->createCommand('select GN_Division_ID, GN_Division from ma_gn_division where DS_Division_ID ='.$id)->QueryAll();
           return $data; 
        }else{
            $data = Yii::app()->db->createCommand('select GN_Division_ID, GN_Division from ma_gn_division')->QueryAll();
           return $data; 
        }
	
}
    public function getLastInsertedGnDiv($gnDivID)
    {
        $cri = new CDbCriteria();
        $cri->select="GN_Division_ID, GN_Division";
        $cri->condition="GN_Division_ID = $gnDivID";
        $array = $this->findAll($cri);
        return $array;
    }

}
