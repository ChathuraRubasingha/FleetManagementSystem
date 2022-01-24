<?php

class ChangePasswordForm extends CFormModel {

    public $currentPassword;
    public $newPassword;
    public $newPassword_repeat;
    private $_user;

    public function rules() {
        return array(
            array('currentPassword', 'compareCurrentPassword'),
            array('currentPassword, newPassword, newPassword_repeat', 'required'),
            array(
                'newPassword_repeat', 'compare',
                'compareAttribute' => 'newPassword',
                'message' => 'Password missmatch',
            ),
        );
    }

    public function compareCurrentPassword($attribute, $params) 
    {  
        //var_dump($this->_user);exit;    
        if(empty($this->currentPassword))
        {
            $this->addError($attribute, 'Current Password cannot be blank');
        }
        else if (UserModule::encrypting($this->currentPassword) != $this->_user->password) 
        {
            $this->addError($attribute, "Incorrect Current Password");
        }
       
    }

    public function init() {
        //$this->_user = TblUsers::model()->findByAttributes(array('username' => Yii::app()->getModule('user')->user()->username));
        $this->_user = Yii::app()->getModule('user')->user()->findByAttributes(array('username' => Yii::app()->getModule('user')->user()->username));
//          $this->_user = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
       
    }


    public function attributeLabels() {
        return array(
            'currentPassword' => 'Current Password',
            'newPassword' => 'New Password',
            'newPassword_repeat' => 'Verify New Password',
        );
    }

    public function changePassword() 
    {  
        //$this->_user->password = UserModule::encrypting($this->newPassword);
        $password = UserModule::encrypting($this->newPassword);
        $id = yii::app()->getModule('user')->user()->id;
        $usrModel = new TblUsers;
        
        if ($usrModel->updateByPk($id, array('password'=>$password)))
        {
            return true;
        }       
        /*if ($this->_user->save())
        {
            return true;
        }*/
        return false;
    }

    
    
  
    
    
}
?>
