<?php

class BookingApprovalController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    
    public function accessRules() {
        /*
         * Added by Sasanka on 15/May/2013
         * Performs to get the permission according to user.
         * This can be apply to all controlers.
         * add whole, public function accessRules(). */


        $curr_controlername = $this->getUniqueId();
        $curr_action = Yii::app()->controller->action->id;
        $access = Yii::app()->user->GetPermission($curr_controlername, $curr_action);

        if ($access == 'true') {
            return array(
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions' => array($curr_action, 'delete'),
                    'users' => array(Yii::app()->user->name),
                ),
                array('deny', // deny all users
                    'users' => array('*'),
                ),
            );
        } else {
            return array(
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array('view', 'delete'),
                    'users' => array('*'),
                ),
                array('deny', // deny all users
                    'users' => array('*'),
                ),
            );
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new BookingApproval;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['BookingApproval'])) {
            $model->attributes = $_POST['BookingApproval'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->Booking_Approval_ID));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['BookingApproval'])) {
            $model->attributes = $_POST['BookingApproval'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->Booking_Approval_ID));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('BookingApproval');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new BookingApproval('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BookingApproval']))
            $model->attributes = $_GET['BookingApproval'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = BookingApproval::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'booking-approval-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionOdometer() {

        date_default_timezone_set('Asia/Colombo');
        $currentDateTime = date("Y-m-d H:i");
        $userRole = Yii::app()->getModule('user')->user()->Role_ID;

        if (isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] != '') {
            unset(Yii::app()->session['btnClick']);
        }

        $id = Yii::app()->request->getQuery('Booking_Approval_ID');

        $model = $this->loadModel($id);
        //echo $model->Vehicle_No ; exit;
        $criteria = new CDbCriteria;
        $criteria->select = array('odometer'); //from ma vehichle registry 
        $criteria->condition = "Vehicle_No='$model->Vehicle_No'";
        $arr = MaVehicleRegistry::model()->findAll($criteria);
        
        if(isset($arr[0]['odometer'])){
           $value = $arr[0]['odometer']; 
        }else{
            $value = 0;
        }
//        
//        if ($value == '') {
//            $value = 0;
//        }

        $preMileage = $model->Mileage; //from booking approval

        if ($preMileage == '') {
            $preMileage = 0;
        }
        //echo $value;exit;
        if (isset($_POST['BookingApproval'])) {
            $model->attributes = $_POST['BookingApproval'];

            //echo $preMileage;exit;
            //echo $model->Out_Time;exit;
//            var_dump(substr($model->Out_Time, 0,-9));
//            
//            var_dump("br");
//            
//            var_dump("form Time ".  substr_compare($model->Out_Time, $currentDateTime,0,10));
//            
//            var_dump("br");
//            
//            var_dump("current Time ".$currentDateTime);
//                die;
//            var_dump($model->In_Time);
//            die;

            if (($model->Out_Time === '')) {

                Yii::app()->user->setFlash('success', "Please Fill the 'Out Time'");
            } else if ((($model->Out_Time !== '') && ($model->In_Time === '')) && (substr_compare($model->Out_Time, $currentDateTime, 0, 10) !== 0)) {

                Yii::app()->user->setFlash('success', "Please Fill the 'Out Time'");
            }
//            elseif ((($model->Out_Time !== '') && ($model->In_Time === ''))){
//
//                Yii::app()->user->setFlash('success', "Please Fill the 'In Time'");
//                
//            }
            else if ((($model->Out_Time !== '') && ($model->In_Time !== null)) && (substr_compare($model->In_Time, $currentDateTime, 0, 10) !== 0)) {

                Yii::app()->user->setFlash('success', "Please Fill the 'In Time'");
            } elseif ((($model->Out_Time !== '') && ($model->In_Time !== '')) && ($model->Mileage === '')) {
                Yii::app()->user->setFlash('success', "Please Fill the Mileage");
//                if (($userRole !== "3")&&($userRole !== "4")) {
//
//                    Yii::app()->user->setFlash('success', "Please Fill the Mileage");
//                } else {
//                    Yii::app()->user->setFlash('success', "කරුණාකර කිලෝමීටර කියවීම සම්පූර්ණ කරන්න");
//                }
            } else {

                if ($model->save()) {

//                    var_dump($model->Mileage);
//                    die;
                    $mileage = ($value - $preMileage) + $model->Mileage;

                    if (($model->Out_Time !== '') && (($model->In_Time !== '') && ($model->In_Time !== null) ) && ($model->Mileage !== '')) {

                        MaVehicleRegistry::model()->updateByPk($model->Vehicle_No, array('odometer' => $mileage));
                        TRVehicleBooking::model()->updateByPk($model->Booking_Approval_ID, array('Booking_Status' => "Completed"));
                        $model->setCompleteBooking($id);
                        Yii::app()->user->setFlash('success', "Successfully Saved..!");
//                        if (($userRole !== "3")&&($userRole !== "4")) {
//
//                            Yii::app()->user->setFlash('success', "Successfully Saved..!");
//                        } else {
//                            Yii::app()->user->setFlash('success', "සාර්ථක ලෙස ගබඩා කරන ලදී");
//                        }
                        $this->redirect(array('view', 'id' => $model->Booking_Approval_ID));
                    } else {
                         Yii::app()->user->setFlash('success', "Successfully Saved..!");
//                        if (($userRole !== "3")&&($userRole !== "4")) {
//
//                            Yii::app()->user->setFlash('success', "Successfully Saved..!");
//                        } else {
//                            Yii::app()->user->setFlash('success', "සාර්ථක ලෙස ගබඩා කරන ලදී");
//                        }
                        
                        $this->redirect(array('view', 'id' => $model->Booking_Approval_ID));
                        // $this->redirect(array('tRVehicleBooking/vehiclelist'));
                    }
                }
            }
        }

        $this->render('odometer', array(
            'model' => $model,));




        /*
          //$status = Yii::app()->session['status'];
          $status = Yii::app()->request->getQuery('status');
          //echo $status;exit;
          $appDate = date("Y-m-d");
          //$preMileage = 'select ';

          if ($status != '') {
          $model = $this->loadModel($id);
          Yii::app()->session['updateStatus'] = 'upStatus';

          if (isset($_POST['TRVehicleBooking'])) {
          $updateStatus = Yii::app()->session['updateStatus'];

          $model->attributes = $_POST['TRVehicleBooking'];
          $In_Time = $model->In_Time;
          $Out_Time = $model->Out_Time;
          $Mileage = $model->Mileage;
          //$appDate = date("Y-m-d : H:i:s", time());
          $Vehicle_No = Yii::app()->request->getQuery('vehicleId');
          $Booking_Request_ID = Yii::app()->request->getQuery('Booking_Request_ID');

          $outTime = new DateTime($Out_Time);
          $actualDate = $outTime->format('Y-m-d');

          $fromDate_array = Yii::app()->db->createCommand('select vehicle_booking.From as FromTime, vehicle_booking.To as ToTime from vehicle_booking where Booking_Request_ID =' . $Booking_Request_ID)->queryAll();

          $count = count($fromDate_array);

          $FromTime = '';
          $frmDate = '';
          $ToTime = '';
          if ($count > 0) {
          $FromTime = $fromDate_array[0]['FromTime'];
          $FromTime = new DateTime($FromTime);
          $requestDate = $FromTime->format('Y-m-d');

          $ToTime = $fromDate_array[0]['ToTime'];
          }

          if (($Out_Time == '0000-00-00 00:00:00') || ($Out_Time == '') || ($In_Time == '0000-00-00 00:00:00') || ($In_Time == '') || ($Mileage == '')) {
          if (($Out_Time == '0000-00-00 00:00:00') || ($Out_Time == '')) {
          Yii::app()->user->setFlash('success', "Please fill the Out Time");
          } elseif (($In_Time == '0000-00-00 00:00:00') || ($In_Time == '')) {
          Yii::app()->user->setFlash('success', "Please fill the In Time");
          } elseif ($Mileage == '') {
          Yii::app()->user->setFlash('success', "Please fill the Mileage");
          }
          Yii::app()->session['btnClick'] = "1";
          } else {
          if (($requestDate <> $actualDate)) {
          Yii::app()->user->setFlash('success', "'Out Time' should be same as Booked Date");
          Yii::app()->session['btnClick'] = "1";
          } elseif ($In_Time < $Out_Time) {
          Yii::app()->user->setFlash('success', "'In Time' should be greater than 'Out Time'");
          Yii::app()->session['btnClick'] = "1";
          } else if ($In_Time > $appDate) {
          Yii::app()->user->setFlash('success', "'In Time' should be a previous date");
          Yii::app()->session['btnClick'] = "1";
          } else {
          $valid = $model->validate();
          if ($valid) {
          $up = "UPDATE vehicle_booking SET In_Time='" . $In_Time . "', Out_Time='" . $Out_Time . "', Mileage='" . $Mileage . "',Booking_Status='Completed' WHERE Booking_Request_ID='" . $Booking_Request_ID . "' ";
          $raw = Yii::app()->db->createCommand($up)->execute();

          $cmd = "SELECT odometer FROM ma_vehicle_registry where Vehicle_No='" . $Vehicle_No . "' ";
          $rawup = Yii::app()->db->createCommand($cmd)->queryAll();

          if (!empty($rawup)) {
          $milage = $rawup[0]['odometer'];
          }

          if ($milage === null) {
          $milage = 0;
          }
          //
          if ($milage != "") {
          if ($updateStatus != '') {
          $earlyMileage = 0;
          if (isset(Yii::app()->session['earlyMileage']) && Yii::app()->session['earlyMileage'] != '') {
          $earlyMileage = Yii::app()->session['earlyMileage'];
          //unset(Yii::app()->session['earlyMileage']);
          }
          $currentMilage = $milage + $Mileage - $earlyMileage;
          } else {
          $currentMilage = $milage + $Mileage;
          }
          $cmd = "UPDATE ma_vehicle_registry SET odometer = '" . $currentMilage . "' where Vehicle_No='" . $Vehicle_No . "' ";
          $rawup = Yii::app()->db->createCommand($cmd)->execute();
          //$this->render('vehiclelist',array('model'=>$model));
          Yii::app()->user->setFlash('success', "Successfully Updated..!");
          $this->redirect(array('viewOdometer', 'id' => $Booking_Request_ID));
          } else {
          $currentMilage = $Mileage;
          $cmd = "UPDATE ma_vehicle_registry SET odometer = '" . $currentMilage . "' where Vehicle_No='" . $Vehicle_No . "' ";
          $rawup = Yii::app()->db->createCommand($cmd)->execute();
          //$this->render('viewOdometer',array('model'=>$model));
          Yii::app()->user->setFlash('success', "Successfully Updated..!");
          $this->redirect(array('viewOdometer', 'id' => $Booking_Request_ID));
          }

          if ($model->save()) {
          Yii::app()->user->setFlash('success', "Successfully Updated..!");
          $this->redirect(array('viewOdometer', 'id' => $model->Booking_Request_ID));
          }
          } else {
          Yii::app()->session['btnClick'] = "1";
          }
          }
          }
          }

          $this->render('Odometer', array(
          'model' => $model,
          ));
          } else {
          $model = $this->loadModel($id);
          if (isset($_POST['TRVehicleBooking'])) {
          $updateStatus = Yii::app()->session['updateStatus'];
          //echo $updateStatus;exit;
          $model->attributes = $_POST['TRVehicleBooking'];

          $In_Time = $model->In_Time;
          $Out_Time = $model->Out_Time;
          $Mileage = $model->Mileage;
          $Vehicle_No = Yii::app()->request->getQuery('vehicleId');
          $Booking_Request_ID = Yii::app()->request->getQuery('Booking_Request_ID');


          $outTime = new DateTime($Out_Time);
          $actualDate = $outTime->format('Y-m-d');

          $fromDate_array = Yii::app()->db->createCommand('select vehicle_booking.From as FromTime, vehicle_booking.To as ToTime from vehicle_booking where Booking_Request_ID =' . $Booking_Request_ID)->queryAll();

          $count = count($fromDate_array);

          $FromTime = '';
          $frmDate = '';
          $ToTime = '';
          if ($count > 0) {
          $FromTime = $fromDate_array[0]['FromTime'];
          $FromTime = new DateTime($FromTime);
          $requestDate = $FromTime->format('Y-m-d');

          $ToTime = $fromDate_array[0]['ToTime'];
          }


          if (($Out_Time == '0000-00-00 00:00:00') || ($Out_Time == '') || ($In_Time == '0000-00-00 00:00:00') || ($In_Time == '') || ($Mileage == '')) {
          if (($Out_Time == '0000-00-00 00:00:00') || ($Out_Time == '')) {
          Yii::app()->user->setFlash('success', "Please fill the Out Time");
          } elseif (($In_Time == '0000-00-00 00:00:00') || ($In_Time == '')) {
          Yii::app()->user->setFlash('success', "Please fill the In Time");
          } elseif ($Mileage == '') {
          Yii::app()->user->setFlash('success', "Please fill the Mileage");
          }
          Yii::app()->session['btnClick'] = "1";
          } else {
          if (($requestDate <> $actualDate)) {
          Yii::app()->user->setFlash('success', "'Out Time' should be same as 'Booked Date'");
          Yii::app()->session['btnClick'] = "1";
          } elseif ($In_Time < $Out_Time) {
          Yii::app()->user->setFlash('success', "'In Time' should be greater than 'Out Time'");
          Yii::app()->session['btnClick'] = "1";
          } else if ($In_Time > $appDate) {
          Yii::app()->user->setFlash('success', "'In Time' should be a previous date");
          Yii::app()->session['btnClick'] = "1";
          } else {
          $valid = $model->validate();
          if ($valid) {
          $up = "UPDATE vehicle_booking SET In_Time='" . $In_Time . "', Out_Time='" . $Out_Time . "', Mileage='" . $Mileage .
          "',Booking_Status='Completed' WHERE Booking_Request_ID='" . $Booking_Request_ID . "'";
          $raw = Yii::app()->db->createCommand($up)->execute();

          $cmd = "SELECT odometer FROM ma_vehicle_registry where Vehicle_No='" . $Vehicle_No . "' ";
          $rawup = Yii::app()->db->createCommand($cmd)->queryAll();

          $milage = $rawup[0]['odometer'];
          if ($milage != "") {
          if ($updateStatus != '') {
          $earlyMileage = 0;
          if (isset(Yii::app()->session['earlyMileage']) && Yii::app()->session['earlyMileage'] != '') {
          $earlyMileage = Yii::app()->session['earlyMileage'];
          }

          $currentMilage = $milage + $Mileage - $earlyMileage;
          } else {
          $currentMilage = $milage + $Mileage;
          }

          $cmd = "UPDATE ma_vehicle_registry SET odometer = '" . $currentMilage . "' where Vehicle_No='" . $Vehicle_No . "' ";
          $rawup = Yii::app()->db->createCommand($cmd)->execute();
          Yii::app()->user->setFlash('success', "Successfully Updated..!");
          $this->redirect(array('viewOdometer', 'id' => $Booking_Request_ID));
          } else {
          $currentMilage = $Mileage;
          $cmd = "UPDATE ma_vehicle_registry SET odometer = '" . $currentMilage . "' where Vehicle_No='" . $Vehicle_No . "' ";
          $rawup = Yii::app()->db->createCommand($cmd)->execute();
          Yii::app()->user->setFlash('success', "Successfully Updated..!");
          $this->redirect(array('viewOdometer', 'id' => $Booking_Request_ID));
          }



          if ($model->save()) {
          Yii::app()->user->setFlash('success', "Successfully Updated..!");
          $this->redirect(array('viewOdometer', 'id' => $model->Booking_Request_ID));
          }
          if (isset(Yii::app()->session['updateStatus']) && Yii::app()->session['updateStatus'] != '') {
          unset(Yii::app()->session['updateStatus']);
          }
          } else {
          Yii::app()->session['btnClick'] = "1";
          }
          }
          }
          }
          }
          if ($status != 'update') {
          $this->render('odometer', array(
          'model' => $model,));
          } */
    }

}