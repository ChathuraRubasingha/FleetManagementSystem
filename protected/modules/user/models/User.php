<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANED=-1;
	public $verifyPassword;
        private $_user;
        /*
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
	 */

	/*
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		//(Yii::app()->getModule('user')->isAdmin())?
		return (array(
			//array('username, password, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('Phone_Number', 'match', 'pattern'=>'/^([0-9]{10})+$/'),
			
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			//array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANED)),
			array('superuser', 'in', 'range'=>array(0,1)),
			array('username, password, verifyPassword, Role_ID, District_ID, Location_ID, createtime, lastvisit, superuser, status, Phone_Number', 'required'),
			array('createtime, lastvisit, superuser, status,Designation_ID,Location_ID,Branch_Id, Role_ID, District_ID', 'numerical', 'integerOnly'=>true),

                    
                        array('verifyPassword', 'length', 'max'=>128),
                        array(
                            'verifyPassword', 'compare',
                            'compareAttribute' => 'password',
                            'message' => 'Password missmatch',
                        ), 
            /*,):((Yii::app()->user->id==$this->id)?array(
			array('username,Location_ID,Role_ID', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			//array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('Phone_Number',  'numerical', 'message' => UserModule::t("This user's Phone Number is invalid.")),
			//array('Phone_Number',),
		):array()*/));
	}

        /*public function comparePassword($attribute, $params) 
        {
        
            if(empty($this->password))
            {
                $this->addError($attribute, 'Password cannot be blank');
            }
            else if (UserModule::encrypting($this->password) !== $this->_user->password) 
            {
                $this->addError($attribute, 'Incorrect Current Password');
            }
        }
         public function init() 
        {
            $this->_user = TblUsers::model()->findByAttributes(array('username' => Yii::app()->getModule('user')->user()->username));
//          $this->_user = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
    }*/
    
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
            $relations = array(
                'profile'=>array(self::HAS_ONE, 'Profile', 'user_id'),
                'district' => array(self::BELONGS_TO, 'MaDistrict', 'District_ID'),
                'location' => array(self::BELONGS_TO, 'MaLocation', 'Location_ID'),
                'designation' => array(self::BELONGS_TO, 'MaDesignation', 'Designation_ID'),
                'role' => array(self::BELONGS_TO, 'Role', 'Role_ID'),
                'branch' => array(self::BELONGS_TO, 'MaBranch', 'Branch_Id'),
            );
            if (isset(Yii::app()->getModule('user')->relations)) $relations = array_merge($relations,Yii::app()->getModule('user')->relations);
            return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
                'username'=>UserModule::t("Username"),
                'password'=>UserModule::t("Password"),
                'verifyPassword'=>UserModule::t("Retype Password"),
                'email'=>UserModule::t("E-mail"),
                'Branch_Id'=>UserModule::t("Branch"),
                'verifyCode'=>UserModule::t("Verification Code"),
                'id' => UserModule::t("Id"),
                'activkey' => UserModule::t("Activation Key"),
                'createtime' => UserModule::t("Registration Date"),
                'lastvisit' => UserModule::t("Last Visit"),
                'superuser' => UserModule::t("Superuser"),
                'status' => UserModule::t("Status"),
                'Location_ID' => UserModule::t("Location"),
                'Designation_ID' => UserModule::t("Designation"),
                'Role_ID' => UserModule::t("Role"),
                'Phone_Number' => UserModule::t("Phone Number"),
                'District_ID' => UserModule::t("District"),

            );
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactvie'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, Branch_Id, activkey, createtime, lastvisit, superuser, status, Designation_ID, Role_ID, Phone_Number',
            ),
        );
    }
	
	public function defaultScope()
    {
        return array(
            'select' => 'id, username, password, email, Branch_Id, Location_ID, District_ID, createtime, lastvisit, superuser, status, Designation_ID, Role_ID',
        );
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not Active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
        
        
        public function search() 
        {
            $superUser = Yii::app()->getModule("user")->user()->superuser;
            $locID = Yii::app()->getModule("user")->user()->Location_ID;
            $userID = Yii::app()->getModule("user")->user()->id;
            $role = Yii::app()->getModule("user")->user()->Role_ID;
            $model=new User;
            if($superUser == 0)
            {
			

                if($role == 1)
                {
                    $criteria=new CDbCriteria;

$criteria->compare('username',  $this->username);
                    $criteria->compare('role.Role',$this->Role_ID, true);
                    //$criteria->compare('location.Location_Name',$this->Location_ID, true);
                    $criteria->compare('status',$this->status, true);
                    $criteria->compare('Location_ID',$locID);
                    
                    $criteria->with = array('role'=>array('select'=>'role.Role', 'together'=>true ));

                    $criteria->compare('superuser',0);

                    $dataProvider= new CActiveDataProvider('User', array(
                        'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>Yii::app()->controller->module->user_page_size,

                        ),
                        'sort'=>array('defaultOrder'=>'username ASC')
                    ));

                    /*$dataProvider=new CActiveDataProvider('User', array(
                        'pagination'=>array(
                            'pageSize'=>Yii::app()->controller->module->user_page_size,

                        ),
                        'sort'=>array('defaultOrder'=>'username ASC')
                    ));*/

                }
                else
                {
                    $criteria=new CDbCriteria;

                    $criteria->compare('id',$userID);
                    
                    $dataProvider= new CActiveDataProvider('User', array(
                        'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>Yii::app()->controller->module->user_page_size,
                        ),
                        'sort'=>array('defaultOrder'=>'username ASC')
                    ));
                }

            }
            else
            {
                $criteria=new CDbCriteria;
                $criteria->compare('username',  $this->username);
                $criteria->compare('role.Role',$this->Role_ID, true);
                $criteria->compare('location.Location_Name',$this->Location_ID, true);
                $criteria->compare('status',$this->status, true);
                $criteria->with = array('role'=>array('select'=>'role.Role', 'together'=>true ),'location'=>array('select'=>'location.Location_Name', 'together'=>true, ));
                //$criteria->compare('r.Role',$this->Role_ID,true);
               
                $dataProvider=new CActiveDataProvider('User', array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>Yii::app()->controller->module->user_page_size,
                    ),
                'sort'=>array('defaultOrder'=>'username ASC')
                ));

            }
            
            return $dataProvider;
        }
}