<?php

/**
 * This is the model class for table "ma_branch".
 *
 * The followings are the available columns in table 'ma_branch':
 * @property integer $Branch_Id
 * @property string $Branch
 */
class MaBranch extends CActiveRecord
{
	/*
	 * Returns the static model of the specified AR class.
	 * @return MaBranch the static model class
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
		return 'ma_branch';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Branch, Location_ID', 'required'),
            array('Branch', 'checkUnique','on'=>'insert'),
            array('Location_ID', 'numerical'),
			array('Branch', 'length', 'max'=>150),
			array('add_by, edit_by', 'length', 'max'=>50),
			array('add_date, edit_date', 'safe'),
			//array('Branch', 'unique'),
			
			array('Branch', 'match', 'pattern'=>'/^([0-9A-Za-z\-\.\,\/ ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Branch_Id, Location_ID, Branch', 'safe', 'on'=>'search'),
		);
	}
    public function checkUnique()
    {
        $locID =$this->Location_ID;
        $branch = $this->Branch;

        $cri = new CDbCriteria();
        $cri->condition="Branch='$branch' and Location_ID=$locID";

        $arr = $this->findAll($cri);
        $count = count($arr);
        $countArr = $count;
        //var_dump($count);die;
        if($countArr>1)
        {
            $this->addError('Branch',"This Branch already exists");
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
            'location' => array(self::BELONGS_TO, 'MaLocation', 'Location_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Branch_Id' => 'Branch',
			'Branch' => 'Branch',
            'Location_ID' => 'Location',
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

		//$criteria=new CDbCriteria;
        $criteria=new CDbCriteria(array('order'=>'location.Location_Name ASC, t.Branch ASC'));

		$criteria->compare('Branch_Id',$this->Branch_Id);
        //$criteria->compare('Location_ID',$this->Location_ID);
        $criteria->compare('location.Location_Name',$this->Location_ID, true);
        $criteria->with = array('location'=>array('select'=>'location.Location_Name', 'together'=>true));
		$criteria->compare('Branch',$this->Branch,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>20),
           // 'sort'=>array('defaultOrder'=>'Location_ID ASC')
		));
	}
	
	public function findBranch()
	{
		$criteria = new CDbCriteria;
		
		$criteria->select ="Branch_Id, Branch";
		$criteria->order="Branch ASC";
		
		$arr = $this->findAll($criteria);
		return $arr;
	}

    public function findBranches($loc)
    {
        $cri = new CDbCriteria();
        $cri->select="Branch_Id, Branch";
        $cri->condition="Location_ID =$loc";
        $cri->order="Branch ASC";

        $data = $this->findAll($cri);
        return $data;
    }
    
    public function getLastInsertedBranch($branchID)
    {
        $cri = new CDbCriteria();
        $cri->select="Branch_Id, Branch";
        $cri->condition="Branch_Id = $branchID";
        $array = $this->findAll($cri);
        return $array;
    }
}
