<?php

class LoginController extends Controller {

    public $defaultAction = 'login';

    /**
     * Displays the login page
     */
    public function actionLogin() 
    {
        if (Yii::app()->user->isGuest) 
        {
            $model = new UserLogin;
            // collect user input data
            if (isset($_POST['UserLogin']))
            {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) 
                {
                    $result = NotificationConfiguration::model()->updateByPk(4, array('Value' => '1'));
                    $this->lastViset();
                    if (strpos(Yii::app()->user->returnUrl, '/admin.php') !== false) 
                    {
                        $this->redirect(Yii::app()->controller->module->returnUrl);
                    } 
                    else 
                    {

                        if (!Yii::app()->user->isGuest) 
                        {
                            $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                            
                            if((($userRole === "3"))||($userRole === "4"))
                            {
                                //security or driver
                                $this->redirect(Yii::app()->createAbsoluteUrl('tRVehicleBooking/vehiclelist'));
                            }
                            else if ($userRole === "2")
                            {
                                //user
                                $this->redirect(Yii::app()->createAbsoluteUrl('tRVehicleBooking/booking'));
                            }
                            else if($userRole === "6")
                            {
                                //supervisor
                                $this->redirect(Yii::app()->createAbsoluteUrl('TRVehicleBooking/dashboardPendingBooking'));
                            } 
                            else 
                            {
                                $this->redirect(Yii::app()->user->returnUrl);
                            }
                            
                        }
                    }
                }
            }
            // display the login form
            $this->render('/user/login', array('model' => $model));
        }
        else
        {
            $this->redirect(Yii::app()->controller->module->returnUrl);
        }
    }

    private function lastViset() {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        
        $lastVisit->lastvisit = time();
        //var_dump($lastVisit);
        //echo "<br/>$lastVisit->lastvisit<br/>ccccccccccccccccccccccccc<br/>".date("d.m.Y H:i:s",$lastVisit->lastvisit);exit;
        $lastVisit->save();
    }

}