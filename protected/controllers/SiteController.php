<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact pagemaBatteryType
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/user/login'));
        } else {
            $this->render('index');
        }
        //$this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/user/login'));
        } else {
            $model = new ContactForm;
            if (isset($_POST['ContactForm'])) {
                $model->attributes = $_POST['ContactForm'];
                if ($model->validate()) {
                    $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                    mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                    Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                    $this->refresh();
                }
            }
            $this->render('contact', array('model' => $model));
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionAccesscontrol() {
        $this->render('accesscontrol');
    }

    public function actionAccess() {
        $model = new role;
        $this->render('access', array('model' => $model));
    }

    public function actionManagement() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/user/login'));
        } else {
            $this->render('management');
        }
    }

    public function actionMaintenance() {
        $vehicleId = Yii::app()->request->getQuery('vehicleId');
        Yii::app()->session['vehicleId'] = $vehicleId;

        $vehicleRegistry = new MaVehicleRegistry;
        $model = new TRFitnessTest;
        $result = $model->getFitnessTestVehicles();
        $status = $result[0]['Fitness_test'];

        $this->render('maintenance', array('status' => $status, 'vehicleRegistry' => $vehicleRegistry));
    }

    

    public function actionChangePassword() {


        if (isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !== '') 
        {
            unset(Yii::app()->session['btnClick']);
        }

        $model = new changePasswordForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'changePassword-form') 
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
          

        // collect user inputs
        if (isset($_POST['ChangePasswordForm'])) 
        {

            $model->attributes = $_POST['ChangePasswordForm'];
            
            // validating and saving
            
            if ($model->validate()) 
            {
                if($model->changePassword() )
                {
                    Yii::app()->user->setFlash('success', 'Password changed successfully !');
                    echo CJSON::encode(array('status' => 'success'));
                    
                }
                Yii::app()->end();
//               $this->redirect($this->action->id);
            } 
            else 
            {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                {
                    echo $error;
                }
                Yii::app()->end();
            }
        }
        //echo 'dsfds';
//        //redering the form
//        $this->render('changePassword', array('model' => $model));
    }

}
