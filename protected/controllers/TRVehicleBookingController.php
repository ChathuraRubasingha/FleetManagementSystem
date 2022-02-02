<?php
class TRVehicleBookingController extends Controller 
{
    /*
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() 
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    


    public function accessRules() 
    {
        /*
         * Added by Sasanka on 15/May/2013
         * Performs to get the permission according to user.
         * This can be apply to all controlers.
         * add whole, public function accessRules(). */


        $curr_controlername = $this->getUniqueId();
        $curr_action = Yii::app()->controller->action->id;
        $access = Yii::app()->user->GetPermission($curr_controlername, $curr_action);

        if ($access == 'true') 
        {
            return array(
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions' => array($curr_action),
                    'users' => array(Yii::app()->user->name),
                ),
                array('deny', // deny all users
                    'users' => array('*'),
                ),
            );
        } else {
            return array(
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions' => array('Approvel', 'ApproveBookingRequest', 'DisapproveBookingRequest','Canceled', 'RejectAssignedBooking', 'RequestsForApproval','approveAndSaveRequest','GetAvailableVehiclesForApproval', 'GetAvailableDriversForApproval','GetServices', 'SetFlagOne','cancel','Set_alert_status', 'AlertClosed', 'EditApprovedBookings', 'ApprovedRequestsForApproval','SupervisorApproval','RequestsForAssign','AssignDriverAndVehicle', 'AssignAndSaveRequest', 'RemoveRequestFromAssignedList','RejectApprovedRequests','DashboardPendingBooking','DashboardApprovedBooking','dashboardAssignedBooking','getOtherBookingDetails','GetVehiclesForBooking','GetDrivers', 'GetRequestsForAssigning','RejectBookingRequest','GetDefaultDriver'),
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
    public function actionView($id) 
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() 
    {
		date_default_timezone_set("Asia/Colombo");
        if (isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] != '') 
        {
            unset(Yii::app()->session['btnClick']);
        }
        $model = new TRVehicleBooking;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
		
        if (isset($_POST['TRVehicleBooking'])) 
        {
            $model->attributes = $_POST['TRVehicleBooking'];
            Yii::app()->session['driverName'] = $_POST['driver_name'];
            
            if ($model->validate()) 
            {
                $user = $model->User_ID;
                $roleID = Yii::app()->getModule('user')->user()->Role_ID;

                if($roleID ==6)
                {
                    $model->Booking_Status="Approved";
                }				
				
                $newBookingValidFrom = $model->From;
                $newBookingValidTo = $model->To;
                
                date_default_timezone_set("Asia/Colombo");
                $nowTime = date("Y-m-d H:i");              
                //var_dump($nowTime);exit;
                //var_dump($newBookingValidFrom);exit;
                if ($newBookingValidFrom >= $newBookingValidTo || $nowTime>=$newBookingValidFrom ) 
                {
                    Yii::app()->user->setFlash('success', "'To date/time' should not be a previous value..!");
                } 
                else
                {                    
                    if ($model->save()) 
                    {
                         if(isset(Yii::app()->session['driverName']) && Yii::app()->session['driverName'] !='')
                         {
                             unset(Yii::app()->session['driverName']);
                         }
                         Yii::app()->user->setFlash('success', "Successfully Requested..!");
                         $this->redirect(array('view', 'id' => $model->Booking_Request_ID));
                    }
                }
            } 
            else 
            {
                Yii::app()->session['btnClick'] = "1";
            }
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
    public function actionUpdate($id) 
    {
		date_default_timezone_set("Asia/Colombo");
        if (isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] != '') 
        {
            unset(Yii::app()->session['btnClick']);
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TRVehicleBooking'])) 
        {
            $model->attributes = $_POST['TRVehicleBooking'];
            $status = $model->Booking_Status;

            if ($model->validate()) 
            {
                $newBookingValidFrom = $model->From;
                $newBookingValidTo = $model->To;
               // var_dump($newBookingValidTo);exit;
	date_default_timezone_set("Asia/Colombo");
                $nowTime = date("Y-m-d H:i:s");  			
                $roleID=0;
                $user = $model->User_ID;

                $criteria = new CDbCriteria;
                $criteria->select = 'Role_ID';
                $criteria->condition = "id='$user'";
                $roleArr = Yii::app()->getModule('user')->user()->findAll($criteria);
                if(count($roleArr)>0)
                {
                    $roleID = $roleArr[0]['Role_ID'];
                }
				
				
				
                if ($newBookingValidFrom >= $newBookingValidTo || $nowTime>=$newBookingValidFrom) 
                {
                    Yii::app()->user->setFlash('success', "'To date/time' should not be a previous value..!");
                } 
                else
                {
                    if ($status == "Pending") 
                    {
                        if ($model->save()) 
                        {
                            Yii::app()->user->setFlash('success', "Successfully Updated..!");
                            $this->redirect(array('view', 'id' => $model->Booking_Request_ID));
                        }
                    } 
					
                    elseif ($status == "Assigned")
                    {
                        Yii::app()->user->setFlash('success', "This Booking Request is Already Assigned. You Can not Update..!");
                    } 
                    elseif ($status == "Disapproved") 
                    {
                        Yii::app()->user->setFlash('success', "This Booking Request is Already Disapproved. You Can not Update..!");
                    } 
                    elseif ($status == "Rejected") 
                    {
                        Yii::app()->user->setFlash('success', "This Booking Request is Already Rejected. You Can not Update..!");
                    } 
                    elseif ($status == "Completed") 
                    {
                        Yii::app()->user->setFlash('success', "This Booking Request is Already Completed. You Can not Update..!");
                    }
                    elseif($status == "Approved")
                    {
                        if($roleID !=6)
                        {
                            Yii::app()->user->setFlash('success', "This Booking Request is Already Approved. You Can not Update..!");
                        }
                        else
                        {
                            if ($model->save()) 
                            {
                                Yii::app()->user->setFlash('success', "Successfully Updated..!");
                                $this->redirect(array('view', 'id' => $model->Booking_Request_ID));
                            }
                        }

                    } 
                }
            } 
            else 
            {
                Yii::app()->session['btnClick'] = "1";
            }			
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
    public function actionDelete($id) 
            {
            try
            {
                $this->loadModel($id)->delete();
                if(!isset($_GET['ajax']))
                {
                    echo '<script>

                        var bodyHeight = $("body").height() /*- $("#header").height() + $("#footer").height()*/;
                        var headHeight =  $("header").height();
                        var footerHeight =  $("footer").height();

                        var height = bodyHeight + headHeight + footerHeight;

                         $("#popDiv").height(height);
                        $("#btnErrorOk").focus();
                        $("#errorConfirm").fadeIn(500);
                        $("#errorConfirm p").html("Successfully Deleted...");
                        $("#popDiv").fadeIn(500);
                    </script>';
                }
                else
                {
                    echo '<script>

                        var bodyHeight = $("body").height() /*- $("#header").height() + $("#footer").height()*/;
                        var headHeight =  $("header").height();
                        var footerHeight =  $("footer").height();

                        var height = bodyHeight + headHeight + footerHeight;

                        $("#popDiv").height(height);
                        $("#btnErrorOk").focus();
                        $("#errorConfirm").fadeIn(500);
                        $("#errorConfirm p").html("Successfully Deleted...");
                        $("#popDiv").fadeIn(500);
                        
                    </script>';
                }

            }
            catch(CDbException $e)
            {
                if(!isset($_GET['ajax']))
                {
                    echo '<script>
                        var bodyHeight = $("body").height() /*- $("#header").height() + $("#footer").height()*/;
                        var headHeight =  $("header").height();
                        var footerHeight =  $("footer").height();

                        var height = bodyHeight + headHeight + footerHeight;

                        $("#popDiv").height(height);
                        $("#btnErrorOk").focus();
                        $("#errorConfirm").fadeIn(500);
                        $("#popDiv").fadeIn(500);

                    </script>';
                }
                else
                {
                    echo '<script>
                        var bodyHeight = $("body").height() /*- $("#header").height() + $("#footer").height()*/;
                        var headHeight =  $("header").height();
                        var footerHeight =  $("footer").height();

                        var height = bodyHeight + headHeight + footerHeight;

                        $("#popDiv").height(height);
                        $("#btnConfirmOk").focus();
                        $("#errorConfirm").fadeIn(500);
                        $("#popDiv").fadeIn(500);

                    </script>';
                }
            }
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		
	
	}

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('TRVehicleBooking');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() 
    {
        $model = new TRVehicleBooking('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TRVehicleBooking']))
            $model->attributes = $_GET['TRVehicleBooking'];


        $this->render('admin', array('model' => $model,)
        );
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = TRVehicleBooking::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'trvehicle-booking-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function loadRequest($id) {
        $request = TRVehicleBooking::model()->findByPk($id);
        if ($request === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $request;
    }
	
public function actionApprovelbooking($id,$from,$to,$cv)
{
		$model = $this->loadModel($id);
		
		$apprivedBooking=TRVehicleBooking::model()->getAllocatedVehicles($from,$to,$cv);
		$request = $this->loadRequest($id);	
		//
		/*if(isset($_GET['DisApprove_btn']))
		{
			echo "asasa";exit;
		}*/
		
	if(isset($_POST['TRVehicleBooking']))
		{
			$this->widget('application.extensions.email.debug'); 
			$model->attributes=$_POST['TRVehicleBooking'];
			$vehicleNo=$model->Vehicle_No;
			$driver=$model->Driver_ID;
			
			
			if($vehicleNo == "" )
			{
				Yii::app()->user->setFlash('success', "Vehicle No is Required..!");
			}
			elseif($driver =="")
			{
				Yii::app()->user->setFlash('success', "Driver Name is Required..!");
			}
			else
			{
				$model->Booking_Status="Approved";
				$model->attributes=$model->Booking_Status;
				$model->attributes=$vehicleNo;
				//print_r($vehicleNo);exit;
				$model->attributes=$driver;
			
				if($model->save());
				
				Yii::app()->user->setFlash('success', "Approved..!");
			
//---------------------------------email function----------------------------//

		/*	$this->widget('application.extensions.email.debug'); 
			$email = Yii::app()->email;
			$email->to = 'shashika.wijayasekera@hotmail.com';
			$email->subject = 'Hello';
			$email->message = 'Hello brother';
			$email->send();*/
//---------------------------------------------------------------------------//			
			}
			
		}
		
		  $this->render('approvelbooking',array(
			'model'=>$model,'request'=>$this->loadRequest($id),'apprivedBooking'=>$apprivedBooking
			
		));
	}


    public function actionApprovel() {

        $model = $this->loadModel();

        $this->render('approvel', array(
            'model' => $model,
        ));
    }

    public function actionVehiclelist() {

        $model = new TRVehicleBooking();
        $modelApprovedBooking = new BookingApproval();
        //$modelper = new TRVehicleBooking();


        $this->render('vehiclelist', array(
            'model' => $model, 'modelApprovedBooking'=>$modelApprovedBooking

        ));
    }

    public function actionOdometer() {
		date_default_timezone_set("Asia/Colombo");
        if (isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] != '') {
            unset(Yii::app()->session['btnClick']);
        }

        $model = new TRVehicleBooking;
        $id = Yii::app()->request->getQuery('Booking_Request_ID');
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
        }
    }
	
	public function actionSupervisorApproval()
	{
            $model = new TRVehicleBooking;

            if ($model->ApproveBySupervisor($_GET['ids'])) 
            {
                $url = Yii::app()->request->baseUrl . "/index.php?r=dashboard/index";            
                Yii::app()->user->setFlash('success',"Successfully Approved..!");
                header('location:' . $url);
            }
	}
	
/*
 * used in dashboardPendingBooking.php
 * 
 *  */
    public function actionDisapproveBookingRequest() 
    {
        if(isset($_POST['reqID']) && $_POST['reqID'] != '')
        {
            if(isset($_POST['reason']) && $_POST['reason'] !=='' )
            {
                $model = new TRVehicleBooking();
                $user = Yii::app()->getModule('user')->user()->username;
                if($model->disapprove($_POST['reqID'], $_POST['reason'], $user))
                {
                    echo "OK";
                }
            }
        }
    }
	
/*
 * used in DashboardPendingBooking.php
 * 
 *  */
    public function actionRejectBookingRequest() 
    {        
        if(isset($_POST['reqID']) && $_POST['reqID'] != '')
        {
            $reqID = $_POST['reqID'];
            $appDate = MaVehicleRegistry::model()->getServerDate('DateTime');
            $user = Yii::app()->getModule('user')->user()->username;
            if(isset($_POST['reason']) && $_POST['reason'] != '')
            {
                $reason = $_POST['reason'];
                
                $rslt = TRVehicleBooking::model()->updateByPk($reqID, array('Booking_Status'=>'Rejected', 'Booking_Status_Reason'=>$reason, 'Approved_By'=>$user, 'Approved_Date'=>$appDate));
                echo 'ok';
            }
        }
    }
	
	
	
	
	public function actionCancel()
	{
		$model = new TRVehicleBooking;
		if(isset($_GET['id']))
		{
			date_default_timezone_set('Asia/Colombo'); 
			$date = date('Y-m-d H:i:s'); 
			$usr = Yii::app()->getModule('user')->user()->username;
			$bookingID = $_GET['id'];
			TRVehicleBooking::model()->updateByPk($bookingID, array('Booking_Status'=>'Cancelled', 'Approved_By'=>$usr, 'Approved_Date'=>$date));
			//echo '';
           // $url = Yii::app()->request->baseUrl . "/index.php?r=dashboard/";
           // header('location:' . $url);
		   $this->redirect(array('tRVehicleBooking/booking'));
		}
	}

        
    public function actionRejectAssignedBooking() 
    {
        if(isset($_POST['requestId']) && $_POST['requestId'] !== '')
        {
            $reqID = $_POST['requestId'];
            $model = new TRVehicleBooking;
            
            if ($model->Reject($reqID))
            {
		echo 'OK';
            }
        }
        
    }
    
    /*
     * used in tRVehicleBooking/editApprovedBookings.php
     * 
     */
	
	public function actionRemoveRequestFromAssignedList() 
	{
            if(isset($_POST['reqID']) && $_POST['reqID'] !=='')
            {
                $reqID = $_POST['reqID'];
                $model = new TRVehicleBooking;
                if ($model->Remove($reqID)) 
                {
                    echo 'OK';
                }
            }
           

           
    }

    public function actionPendingBooking() {
        $model = new TRVehicleBooking;
        #$model = $this->loadModel();

        $this->render('pendingBooking', array(
            'model' => $model,
        ));
    }

    public function actionApprovedBooking() {
        $model = new TRVehicleBooking;
        #$model = $this->loadModel();

        $this->render('approvedBooking', array(
            'model' => $model,
        ));
    }
    
    public function actionAssignedVehicle() {
        $model = new TRVehicleBooking;
        $this->render('assignedVehicle', array(
            'model' => $model,
        ));
    }
	
	public function actionEditApprovedBookings() {
        $model = new TRVehicleBooking;
        #$model = $this->loadModel();

        $this->render('editApprovedBookings', array(
            'model' => $model,
        ));
    }

    public function actionRejectedBooking() {
        $model = new TRVehicleBooking;
        #$model = $this->loadModel();

        $this->render('rejectedBooking', array(
            'model' => $model,
        ));
    }

    public function actionDisapprovedBooking() {
        $model = new TRVehicleBooking;
        #$model = $this->loadModel();

        $this->render('disapprovedBooking', array(
            'model' => $model,
        ));
    }

    public function actionRejectRequest() {
        $model = new TRVehicleBooking;
        #$model = $this->loadModel();

        $this->render('rejectRequest', array(
            'model' => $model,
        ));
    }

    public function actionCompletedBooking() {
        $model = new TRVehicleBooking;
        #$model = $this->loadModel();

        $this->render('completedBooking', array(
            'model' => $model,
        ));
    }

    public function actionCanceled() {
        $url = Yii::app()->request->baseUrl . "/index.php?r=dashboard/";
        header('location:' . $url);
		
    }

    public function actionRejectVehicleBooking($requestId) {
        $vid = Yii::app()->request->getQuery('vid');

        if ($vid != "") {
            Yii::app()->session['VehicleIdBooking'] = $vid;
        }

        Yii::app()->session['requestIdBooking'] = Yii::app()->request->getQuery('requestId');

        $model = new TRVehicleBooking;
        $model = $this->loadModel($requestId);

        $this->render('rejectVehicleBooking', array(
            'model' => $model,
        ));
    }

    public function actionViewOdometer($id) {
        $model = new TRVehicleBooking;
        #$model = $this->loadModel();

        $this->render('viewOdometer', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionSelectDriver($id) {
        $model = new TRVehicleBooking;

        if (isset($_POST['vNo'])) {
            $vNo = $_POST['vNo'];

            $array = Yii::app()->db->createCommand('select Driver_ID from vehicle_location where Vehicle_No ="' . $vNo . '"')->queryAll();
            $count = count($array);
            $driverID = '';
            if ($count > 0) {
                $driverID = $array[0]['Driver_ID'];
                echo '<script>
				
				$("#TRVehicleBooking_Driver_ID option[value=' . $driverID . ']").attr("selected", "selected");
				
				</script>';
            }
        }
        #$model = $this->loadModel();
        #$this->render('viewOdometer',array(
        #'model'=>$this->loadModel($id),));
    }
	
	
	
	
	
	public function actionApprovedRequestsForApproval()
	{
            $id = $_POST['id'];
            $approvedDriver ='';
            $approvedVehicle = '';
                    
            if(isset($_POST['approvedDriver']) && $_POST['approvedDriver'] !=='')
            {
                $approvedDriver = $_POST['approvedDriver'];
            }
            
            if(isset($_POST['appVehicle']) && $_POST['appVehicle'] !=='')
            {
                $approvedVehicle = $_POST['appVehicle'];
            }
            
            $m=1;
            $arr = array();
            $fromTime = $toTime = MaVehicleRegistry::model()->getServerDate('dateTime');
            
            $data = Yii::app()->db->createCommand('select distinct vb.Booking_Request_ID, u.Location_ID, pro.firstname, vb.No_of_Passengers, vb.Place_to, vb.From, vb.To, ba.Vehicle_No, d.Full_Name  from vehicle_booking vb
                inner join tbl_users u on u.id = vb.User_ID
                inner join  tbl_profiles pro on pro.user_id = u.id                
                inner join booking_approval ba on ba.Booking_Approval_ID = vb.Booking_Approval_ID
                left join ma_driver d on d.Driver_ID = ba.Driver_ID
                where vb.Booking_Status ="Assigned" and vb.Booking_Approval_ID ='.$id)->queryAll();
             $dataCount = count($data);		 
		 
            // $class='even';
            if($dataCount>0)
            {
                $rows ='';
                for($i=0; $i<$dataCount; $i++)
                {
                    $class = 'odd';
                    if($m % 2 ==0)
                    {
                        $class = 'even';
                    }
                    
                    
                    $bookingID = $data[$i]['Booking_Request_ID'];
                    $usr = $data[$i]['firstname'];
                    $Place_to = $data[$i]['Place_to'];
                    $From = $data[$i]['From'];
                    $To = $data[$i]['To'];
                    $id=$data[$i]['Booking_Request_ID'];
                    $vID=$data[$i]['Vehicle_No'];
                    $driver=$data[$i]['Full_Name'];
                    $passengers=$data[$i]['No_of_Passengers'];

                    $fromTime = $From;
                    $toTime = $To;
                    $locID = $data[$i]['Location_ID'];
                    
                    $rows .= "<tr class='rows' id='row_$id'>
                    <td class='dta $class'>$bookingID</td>
                    <td class='dta $class'>$usr</td>
                    <td class='dta $class'>$Place_to</td>
                    <td class='frmTime dta $class'>$From</td>
                    <td class='toTime dta $class'>$To</td>
                    <td class='dta $class'>$vID</td>
                    <td class='dta $class'>$driver</td>
                    <td class='dta $class'>$passengers</td>
                    <td class='dta $class'>".CHtml::dropDownlist('','', array('Assigned'=>'Assigned','Remove'=>'Remove', 'Reject'=>'Reject'), array('class'=>'statusDrop', 'onchange'=>'showRejectPop(this)'))."</td>
                    </tr>";
                    $m +=1;
                }                
                
                $arrVehicle = TRVehicleBooking::model()->getVehiclesForAssigning($locID, $fromTime, $toTime);
                $vehicleOptions ="<option value=''>--- Please Select ---</option>";
                $vCategory = '';
                $countVehicleArr = count($arrVehicle);
                
                if($countVehicleArr > 0)
                {
                    for($k = 0; $k < $countVehicleArr; $k++)
                    {
                        $vNo = $arrVehicle[$k]['Vehicle_No'];
                        $vCat = $arrVehicle[$k]['Category_Name'];
                        if($vCategory !== $vCat)
                        {
                            $vCategory= $vCat;
                            $vehicleOptions .= "<option disabled style='font-weight:bold'>$vCat</option>";
                        }
                        if($vCategory === $vCat)
                        {
                            if($vNo == $approvedVehicle)
                            {
                                $vehicleOptions .= "<option selected value='$vNo'>$vNo</option>";
                            }
                            else
                            {
                                $vehicleOptions .= "<option value='$vNo'>$vNo</option>";
                            }

                        }

                    }
                }
                
                
                
                $arrDriver = TRVehicleBooking::model()->getAvailableDriversForAssign($locID, $fromTime, $toTime);
                $countDriverArr = count($arrDriver);        
                $driverOption ="<option value=''>--- Please Select ---</option>";
                if($countDriverArr > 0)
                {
                    for($m = 0; $m < $countDriverArr; $m++)
                    {
                        $driverName = $arrDriver[$m]['Full_Name'];
                        $driverID = $arrDriver[$m]['Driver_ID'];

                        if($driverID == $approvedDriver)
                        {
                            $driverOption .= "<option selected value='$driverID'>$driverName</option>";
                        }
                        else
                        {
                            $driverOption .= "<option value='$driverID'>$driverName</option>";
                        }
                    }
                }
                
                $arr['rows'] = $rows;
                $arr['vehicles'] = $vehicleOptions;
                $arr['drivers'] = $driverOption;
                echo CJSON::encode($arr);
             }
	}
        
        public function actionRequestsForApproval()
	{
            $fromTime = $toTime = MaVehicleRegistry::model()->getServerDate('dateTime');
            $locID = Yii::app()->getModule('user')->user()->Location_ID;
            $k=0;
            $vehicleOptions = $driverOption ='';
            $arr = array();
            $rows =''; 
            $approvedVehicle ='';
            $approvedDriver ='';
            
            if(isset($_POST['approvedDriver']) && $_POST['approvedDriver'] !=='')
            {
                $approvedDriver = $_POST['approvedDriver'];
            }
            
            if(isset($_POST['appVehicle']) && $_POST['appVehicle'] !=='')
            {
                $approvedVehicle = $_POST['appVehicle'];
            }
            
            if(isset($_POST['approveID']) && $_POST['approveID'] !=='' )
            {
                $reqID = $_POST['approveID'];                               
                
                $data = Yii::app()->db->createCommand("select distinct vb.Booking_Request_ID, u.Location_ID, pro.firstname, vb.No_of_Passengers, vb.Place_to, vb.From, vb.To, vb.Vehicle_No, d.Full_Name  from vehicle_booking vb
                inner join tbl_users u on u.id = vb.User_ID
                inner join  tbl_profiles pro on pro.user_id = u.id
                left join ma_driver d on d.Driver_ID = vb.Driver_ID
                where vb.Booking_Status ='Assigned' and vb.Booking_Approval_ID =$reqID")->queryAll();
             
                $dataCount = count($data);
                
                if($dataCount>0)
                {                    
                    for($i=0; $i<$dataCount; $i++)
                    {
                        $k = $i+1;
                        $class='odd';
                        if($k % 2 == 0)
                        {
                            $class = 'even';
                        }
                        $bookingID = $data[$i]['Booking_Request_ID'];
                        $usr = $data[$i]['firstname'];
                        $Place_to = $data[$i]['Place_to'];
                        $From = $data[$i]['From'];
                        $To = $data[$i]['To'];
                        $id=$data[$i]['Booking_Request_ID'];
                        $vID=$data[$i]['Vehicle_No'];
                        $driver=$data[$i]['Full_Name'];
                        $passengers=$data[$i]['No_of_Passengers'];

                        if($i == 0)
                        {
                            $fromTime = $From;
                            $toTime = $To;
                        }
                        $locID = $data[$i]['Location_ID'];

                        $rows .= "<tr class='rows' id='row_$id'>
                        <td class='dta $class'>$bookingID</td>
                        <td class='dta $class'>$usr</td>
                        <td class='dta $class'>$Place_to</td>
                        <td class='frmTime dta $class'>$From</td>
                        <td class='toTime dta $class'>$To</td>
                        <td class='dta $class'>$vID</td>
                        <td class='dta $class'>$driver</td>
                        <td class='dta $class'>$passengers</td>
                        <td class='dta $class'>".CHtml::dropDownlist('','', array('Assigned'=>'Assigned','Remove'=>'Remove', 'Reject'=>'Reject'), array('class'=>'statusDrop', 'onchange'=>'showRejectPop(this)'))."</td>
                    
                        </tr>";
                        $k++;
                    }
                    
                    
                
                }
            }
            
            if(isset($_POST['ids']) && $_POST['ids'] !=='')
            {
                $ids = $_POST['ids'];
                $idsCount = count($ids);

                if($idsCount > 0)
                {   
                    for($i = 0; $i < $idsCount; $i++)
                    {                         
                        $class='odd';
                        if($k % 2 == 0)
                        {
                            $class = 'even';
                        }
                        $reqID = $ids[$i];
                        $data = Yii::app()->db->createCommand("select distinct vb.Booking_Request_ID, pro.firstname, vb.No_of_Passengers, vb.Place_to, vb.From, vb.To, vb.Vehicle_No, d.Full_Name  from vehicle_booking vb
                        inner join tbl_users u on u.id = vb.User_ID
                        inner join   tbl_profiles pro on pro.user_id = u.id
                        left join ma_driver d on d.Driver_ID = vb.Driver_ID
                        where vb.Booking_Request_ID =$reqID")->queryAll();

                        $dataCount = count($data);

                        if($dataCount > 0)
                        {
                            $bookingID = $data[0]['Booking_Request_ID'];
                            $usr = $data[0]['firstname'];
                            $Place_to = $data[0]['Place_to'];
                            $From = $data[0]['From'];
                            $To = $data[0]['To'];
                            $id=$data[0]['Booking_Request_ID'];
                            $vID=$data[0]['Vehicle_No'];
                            $driver=$data[0]['Full_Name'];
                            $passengers=$data[0]['No_of_Passengers'];



                            if($fromTime > $From)
                            {
                                $fromTime = $From;
                            }
                            if($toTime > $To)
                            {
                                $fromTime = $To;
                            }

                            $rows .= "<tr  id='row_$id' class='rows'>
                            <td class='$class dta'>$bookingID</td>
                            <td class='$class dta'>$usr</td>
                            <td class='$class dta'>$Place_to</td>
                            <td class='$class frmTime dta'>$From</td>
                            <td class='$class toTime dta'>$To</td>
                            <td class='$class dta'>$vID</td>
                            <td class='$class dta'>$driver</td>
                            <td class='$class dta'>$passengers</td>
                            <td class='$class dta'>".CHtml::dropDownlist('','', array('Approved'=>'Approved'), array('class'=>'statusDrop', 'onchange'=>'showRejectPop(this)'))."</td>
                            </tr>";
                             $k++;
                        }

                    }
                    
                    $vehicles = "select distinct vr.Vehicle_No, vr.Vehicle_Category_ID, vc.Category_Name
                    from ma_vehicle_registry vr
                    inner join vehicle_location  vl on vl.Vehicle_No = vr.Vehicle_No
                    inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
                    where vr.Vehicle_Status_ID =1 and vl.Location_ID = '$locID'  and vr.Vehicle_No not in (
                    select distinct ba.Vehicle_No from booking_approval ba
                    inner join vehicle_booking vb on vb.Booking_Approval_ID  = ba.Booking_Approval_ID
                    where ('$fromTime' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date or '$toTime' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date) and vb.Booking_Status = 'Approved')";

                    $arrVehicle = Yii::app()->db->createCommand($vehicles)->queryAll();

                    $vehicleOptions ="<option value=''>--- Please Select ---</option>";
                    $vCategory = '';
                    $countVehicleArr = count($arrVehicle);
                    if($countVehicleArr > 0)
                    {
                        for($k = 0; $k < $countVehicleArr; $k++)
                        {
                            $vNo = $arrVehicle[$k]['Vehicle_No'];
                            $vCat = $arrVehicle[$k]['Category_Name'];
                            if($vCategory != $vCat)
                            {
                                $vCategory= $vCat;
                                $vehicleOptions .= "<option disabled style='font-weight:bold'>$vCat</option>";
                            }
                            if($vCategory == $vCat)
                            {
                                if($vNo == $approvedVehicle)
                                {
                                    $vehicleOptions .= "<option selected value='$vNo'>$vNo</option>";
                                }
                                else
                                {
                                    $vehicleOptions .= "<option value='$vNo'>$vNo</option>";
                                }

                            }

                        }
                    }


                    $queryDriver = "select distinct d.Driver_ID, d.Full_Name from ma_driver d
                    where d.Location_ID = '$locID' and d.Driver_ID not in (
                    select distinct ba.Driver_ID from booking_approval ba 
                    inner join vehicle_booking vb on vb.Booking_Approval_ID  = ba. 	Booking_Approval_ID  
                    where ('$fromTime' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date or '$toTime' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date) and vb.Booking_Status = 'Approved')
                    order by d.Full_Name ASC";

                    $arrDriver = Yii::app()->db->createCommand($queryDriver)->queryAll();
                    $countDriverArr = count($arrDriver);        
                    $driverOption ="<option value=''>--- Please Select ---</option>";
                    if($countDriverArr > 0)
                    {
                        for($m = 0; $m < $countDriverArr; $m++)
                        {
                            $driverName = $arrDriver[$m]['Full_Name'];
                            $driverID = $arrDriver[$m]['Driver_ID'];

                            if($driverID == $approvedDriver)
                            {
                                $driverOption .= "<option selected value='$driverID'>$driverName</option>";
                            }
                            else
                            {
                                $driverOption .= "<option value='$driverID'>$driverName</option>";
                            }
                        }
                    }

                    
                    
                }                    


            }
            $arr['rows'] = $rows;
            $arr['vehicles']=$vehicleOptions;
            $arr['drivers']=$driverOption;
            echo CJSON::encode($arr);
            
            
	}
	
	
	public function actionApproveAndSaveRequest()
	{
		date_default_timezone_set("Asia/Colombo");
		if(isset($_POST['NewBookingDate']) && isset($_POST['vNo']) && isset($_POST['driver']) && isset($_POST['ids']))
		{
			
			$usr = Yii::app()->getModule('user')->user()->username;
			
			$newBookingDate = $_POST['NewBookingDate'];
			$maxToDate = $_POST['maxToDate'];
			$vNo = $_POST['vNo'];
			$driver = $_POST['driver'];
			$ids = $_POST['ids'];
			$countIDs = count($ids);
			
			date_default_timezone_set('Asia/Colombo'); 
			$date = date('Y-m-d H:i:s'); 
			$drID =0;
			$drArr = Yii::app()->db->createCommand('select Driver_ID from ma_driver where Full_Name ="'.$driver.'"')->queryAll();
			if(count($drArr)>0)
			{
				$drID = $drArr[0]['Driver_ID'];
			}
						
			/*$approval = new BookingApproval();
			$approval->Booking_Approval_ID=0;
			$approval->Approved_Date=$date;
			$approval->New_Booking_Request_Date=$newBookingDate;
			$approval->New_Booking_To_Date=$maxToDate;
			$approval->Vehicle_No=$vNo;
			$approval->Driver_ID=$drID;
			$approval->In_Time=null;
			$approval->Out_Time=null;
			$approval->Mileage=null;
			$approval->No_of_Pessengers=null;
			
			$approval->save();*/
			
			
			$AppID=Yii::app()->db->getLastInsertId('booking_approval');
			
			if($countIDs>0)
			{
				for($i=0; $i<$countIDs; $i++)
				{
					$reqID = $ids[$i];
					
					TRVehicleBooking::model()->updateByPk($reqID, array('Booking_Status'=>'Approved','Booking_Approval_ID'=>$AppID, 'Approved_By'=>$usr, 'Approved_Date'=>$date));

				}
			}
			
			if(isset($_POST['approveID']) && $_POST['approveID'] !='0')
			{
				$sql = 'DELETE FROM booking_approval WHERE Booking_Approval_ID ='.$_POST['approveID'];
				$qry = Yii::app()->db->createCommand($sql)->execute();
			}/**/
			
			echo $countIDs;
		}
		
	}
	
	public function actionApproveBookingRequest()
	{
            if(isset($_POST['reqID']) && $_POST['reqID'] != '')
            {
                $reqID = $_POST['reqID'];
                $appDate = MaVehicleRegistry::model()->getServerDate("DateTime");                
                $usr = Yii::app()->getModule('user')->user()->username;
                $rslt = TRVehicleBooking::model()->updateByPk($reqID, array('Booking_Status'=>'Approved', 'Approved_By'=>$usr, 'Approved_Date'=>$appDate));
                echo 'ok';                
            }
            $usr = Yii::app()->getModule('user')->user()->username;  	
		
	}
	
	
	public function actionAssignAndSaveRequest()
	{
            if(isset($_POST['NewBookingDate']) && isset($_POST['vNo']) && isset($_POST['driver']) && isset($_POST['ids']))
            {
			
                $usr = Yii::app()->getModule('user')->user()->username;

                $newBookingDate = $_POST['NewBookingDate'];
                $maxToDate = $_POST['maxToDate'];
                $vNo = $_POST['vNo'];
                $driver = $_POST['driver'];
                $ids = $_POST['ids'];
                $countIDs = count($ids);

                date_default_timezone_set('Asia/Colombo'); 
                $date = date('Y-m-d H:i:s'); 
                $drID =0;
                $drArr = Yii::app()->db->createCommand('select Driver_ID from ma_driver where Full_Name ="'.$driver.'"')->queryAll();
                if(count($drArr)>0)
                {
                        $drID = $drArr[0]['Driver_ID'];
                }
						
                /*$approval = new BookingApproval();
                $approval->Booking_Approval_ID=0;
                $approval->Approved_Date=$date;
                $approval->New_Booking_Request_Date=$newBookingDate;
                $approval->New_Booking_To_Date=$maxToDate;
                $approval->Vehicle_No=$vNo;
                $approval->Driver_ID=$drID;
                $approval->In_Time=null;
                $approval->Out_Time=null;
                $approval->Mileage=null;
                $approval->No_of_Pessengers=null;

                $approval->save();*/
			
			
                $AppID=Yii::app()->db->getLastInsertId('booking_approval');

                if($countIDs>0)
                {
                    for($i=0; $i<$countIDs; $i++)
                    {
                        $reqID = $ids[$i];
                        TRVehicleBooking::model()->updateByPk($reqID, array('Booking_Status'=>'Approved','Booking_Approval_ID'=>$AppID, 'Approved_By'=>$usr, 'Approved_Date'=>$date));
                    }
                }
			
                if(isset($_POST['approveID']) && $_POST['approveID'] !='0')
                {
                        $sql = 'DELETE FROM booking_approval WHERE Booking_Approval_ID ='.$_POST['approveID'];
                        $qry = Yii::app()->db->createCommand($sql)->execute();
                }
                echo $countIDs;
            }		
	}
	
	public function actionAssignDriverAndVehicle()
	{
            if(isset($_POST['ids']))
            {			
                $usr = Yii::app()->getModule('user')->user()->username;

                $newBookingDate = $_POST['NewBookingDate'];
                $maxToDate = $_POST['maxToDate'];
                $vNo = $_POST['vNo'];
                $drID = $_POST['driver'];
                $ids = $_POST['ids'];
                $countIDs = count($ids);
                //echo $vNo;
                date_default_timezone_set('Asia/Colombo'); 
                $date = MaVehicleRegistry::model()->getServerDate('dateTime'); 
               
                $approval = new BookingApproval();
                $approval->Booking_Approval_ID=0;
                $approval->Approved_Date=$date;
                $approval->New_Booking_Request_Date=$newBookingDate;
                $approval->New_Booking_To_Date=$maxToDate;
                $approval->Vehicle_No=$vNo;
                $approval->Driver_ID=$drID;
                $approval->In_Time=null;
                $approval->Out_Time=null;
                $approval->Mileage=null;
                $approval->No_of_Pessengers=null;
			
                $approval->save();			
			
                $AppID=Yii::app()->db->getLastInsertId('booking_approval');
			
                if($countIDs>0)
                {
                    for($i=0; $i<$countIDs; $i++)
                    {
                        $reqID = $ids[$i];
                        TRVehicleBooking::model()->updateByPk($reqID, array('Booking_Status'=>'Assigned','Booking_Approval_ID'=>$AppID, 'Assigned_By'=>$usr, 'Assigned_Date'=>$date));
                    }
                }
			
                if(isset($_POST['approveID']) && $_POST['approveID'] !='0')
                {
                    $sql = 'DELETE FROM booking_approval WHERE Booking_Approval_ID ='.$_POST['approveID'];
                    $qry = Yii::app()->db->createCommand($sql)->execute();
                }			
			
            }
	}
	
	public function actionGetAvailableVehiclesForApproval()
	{
            if(isset($_POST['minDate']) && (isset($_POST['LocID'])))
            {
                $from = $_POST['minDate'];
                $loc = $_POST['LocID'];
                $maxDate = $_POST['maxDate'];
			
			/*$query = "select distinct vr.Vehicle_No, vc.Category_Name from ma_vehicle_registry vr
inner join vehicle_location  vl on vl.Vehicle_No = vr.Vehicle_No 
inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
where vr.Vehicle_No not in (
select distinct ba.Vehicle_No from booking_approval ba 
inner join vehicle_booking vb on vb.Booking_Approval_ID  = ba. 	Booking_Approval_ID  
where ('".$from."' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date or '".$maxDate."' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date) and vb.Booking_Status = 'Approved')";*/

			$query = "select distinct vr.Vehicle_No, vr.Vehicle_Category_ID, vc.Category_Name
			from ma_vehicle_registry vr
            inner join vehicle_location  vl on vl.Vehicle_No = vr.Vehicle_No
            inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
            where vr.Vehicle_Status_ID =1 and vl.Location_ID = '".$loc."'  and vr.Vehicle_No not in (
                select distinct ba.Vehicle_No from booking_approval ba
                inner join vehicle_booking vb on vb.Booking_Approval_ID  = ba. 	Booking_Approval_ID
                where ('".$from."' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date or '".$maxDate."' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date) and vb.Booking_Status = 'Approved')";

			$arr = Yii::app()->db->createCommand($query)->queryAll();
			echo CJSON::encode($arr);
		}
		
		
	}
	
	public function actionGetAvailableDriversForApproval()
	{
            if(isset($_POST['minDate']) && (isset($_POST['LocID'])))
            {
                $from = $_POST['minDate'];
                $loc = $_POST['LocID'];
                $maxDate = $_POST['maxDate'];

                /*$query = 'SELECT distinct d.Driver_ID, d.Full_Name FROM `ma_driver` d Left JOIN vehicle_driver vd ON vd.Driver_ID = d.Driver_ID WHERE d.Location_ID = '.$loc.' and not EXISTS (select NULL from vehicle_booking vb where  ("'.$from.'" between date(vb.From) and date(vb.To)) and vb.Driver_ID = d.Driver_ID and vb.Booking_Status = "approved") ORDER BY Full_Name ASC';*/

                $query = "select distinct d.Driver_ID, d.Full_Name from ma_driver d
                where d.Location_ID = '".$loc."' and d.Driver_ID not in (
                select distinct ba.Driver_ID from booking_approval ba 
                inner join vehicle_booking vb on vb.Booking_Approval_ID  = ba. 	Booking_Approval_ID  
                where ('".$from."' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date or '".$maxDate."' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date) and vb.Booking_Status = 'Approved')
                order by d.Full_Name ASC";

                $arr = Yii::app()->db->createCommand($query)->queryAll();
                echo CJSON::encode($arr);
            }
		
	}
	
    
	
	
        public function actionSetFlagOne() 
        {
            if (isset($_POST['setViewedFlag'])) 
            {
//                $ntoificationModel = NotificationConfiguration::model('4');
//                $ntoificationModel ->Value = "0" ;
//                $ntoificationModel ->save();
                $sql = "update notification_configuration set Value = '0' where Row = '4'";
                $result = Yii::app()->db->createCommand($sql)->execute();
               
                if (($result > "0")) 
                {
                   Yii::app()->user->setFlash('success', "Alerts disabled..!");
                    echo CJSON::encode("sucess");
                } else 
                {
                    Yii::app()->user->setFlash('success', "Alerts already disabled..!");
                    echo CJSON::encode("error");
                }            
            }
        }
    
    
    public function actionAlertClosed(){
        
        if(isset($_POST['alertClosed'])){
            
            Yii::app()->session['alertClosed'] = 1;
            echo CJSON::encode('done');
        }
    }


    
    
    public function actionGetServices() 
    {        
        $notifications = new Notifications();
        
        $getPermission = $notifications->checkDashboardPermission();
        $Repair_for_Approvel = $Pending_License_Details = $Pending_Fitness_Test_Details = $Pending_Emmission_Test = $Pending_Insuarance_Details = "0";
        //checks weather role exists in the dashboard permission if so allowed
        
        if (isset($getPermission) && (count($getPermission) > "0")) 
        {
            $Pending_Insuarance_Details = $getPermission[0]['Pending_Insuarance_Details'];
            $Pending_Emmission_Test = $getPermission[0]['Pending_Emmission_Test'];
            $Pending_Fitness_Test_Details = $getPermission[0]['Pending_Fitness_Test_Details'];
            $Pending_License_Details = $getPermission[0]['Pending_License_Details'];
            $Repair_for_Approvel = $getPermission[0]['Repair_for_Approvel'];                
        
            $criticalPeriod = $dateInterval = $appendString = $nonCriticalPeriod = "";
            $nonCriticalPeriod = "5";
            $criticalPeriod = "3";
            $dateInterval ='7';
        
            $criticalPeriodDb = $notifications->getCriticalValue();
                
            if(isset($criticalPeriodDb) && !empty($criticalPeriodDb))
            {
                $criticalPeriod = ($criticalPeriodDb);
            }                
            $veryDelayDb = $notifications->getNonCriticalValue();
            if(isset($veryDelayDb) && !empty($veryDelayDb))
            {
                $nonCriticalPeriod = ($veryDelayDb); 
                $dateInterval = (int)$nonCriticalPeriod + 2;
            }
        
            $alertStatus = $css = $License3 = $Fitness3 = $Emmission3 = $Insurance3 = $services = "";
        
            if (isset($_POST['get_serviceNotes'])) 
            {

                $alertStatus = $notifications->chkAlertOnorOff();
                if(isset($alertStatus) && ($alertStatus !== "0"))
                {

                    $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
                    $locID = Yii::app()->getModule('user')->user()->Location_ID;


                    if (($superuserstatus !== "1")&&(!empty($locID))) 
                    {
                        $sql = "select distinct vr.Vehicle_No, datediff(se.Next_Service_Date,now()) as dateCount, se.*, md.Full_Name, ss.*, st.*
                           from services as se, ma_vehicle_registry as vr, ma_driver as md, ma_service_station as ss, ma_service_type as st, ma_location as ml, vehicle_location as vl
                           where se.Vehicle_No = vr.Vehicle_No and se.Driver_ID = md.Driver_ID and se.Service_Station_ID = ss.Service_Station_ID and se.Service_Type_ID = st.Service_Type_ID and vl.Current_Location_ID = ml.Location_ID 
                           and (datediff(se.Next_Service_Date,now())) <='$dateInterval' and vl.Current_Location_ID = '$locID' 
                           and se.alert_status = '0' order by se.add_date asc";
                    } 
                    else 
                    {

                        $sql = "select  distinct vr.Vehicle_No, datediff(se.Next_Service_Date,now()) as dateCount, se.*,  md.Full_Name, ss.*, st.*
                           from services as se, ma_vehicle_registry as vr, ma_driver as md, ma_service_station as ss, ma_service_type as st, ma_location as ml
                           where se.Vehicle_No = vr.Vehicle_No and se.Driver_ID = md.Driver_ID and se.Service_Station_ID = ss.Service_Station_ID and se.Service_Type_ID = st.Service_Type_ID 
                           and (datediff(se.Next_Service_Date,now())) <='$dateInterval'  
                           and se.alert_status = '0' order by se.add_date asc";
                    }

                    $services = Yii::app()->db->createCommand($sql)->queryAll();

                    if(($Repair_for_Approvel !== "0") && (count($services)!== 0))
                    {
                        $appendString.='<tr><th colspan="2">Service Alerts !</th></tr>' ;

                        for ($i = 0; $i < count($services); $i++) 
                        {    
                            if (($criticalPeriod >= $services[$i]['dateCount'])) {
                            $css = 'id="error"';
                            } elseif (($nonCriticalPeriod > $services[$i]['dateCount']) && (($services[$i]['dateCount']) > $criticalPeriod )) {
                                $css = 'id="warning"';
                            } else {
                                $css = 'id="notice"';
                            }
                            
                            
                            $appendString.= '<tr ><td '.$css.'>'.$services[$i]['Vehicle_No']." : Vehicle next service on : ".$services[$i]['Next_Service_Date']." </td>";
                            $appendString.= '<td '.$css.'><img title="Ok" style="hegiht:16px; width:16px;" src="./images/ok.png" onclick="set_alert_status(\''."TRServices".'\',\''.$services[$i]['Services_ID'].'\')"  /></td></tr>';
                        }
                        $appendString.='<tr><td colspan="2" style="border:none !important">   </td></tr>' ;
                    }

                    if (($superuserstatus !== "1")&&(!empty($locID)))
                    {
                        $Insurance3 = Yii::app()->db->createCommand("select distinct vr.Vehicle_No, ins.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                            from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                            where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Current_Location_ID = l.Location_ID 
                            and vl.Current_Location_ID ='$locID' 
                            and ((datediff(ins.Valid_To,now())) <= '$dateInterval') 
                            and ins.alert_status = '0' order by ins.add_date asc")->queryAll();

                    } 
                    else 
                    {
                        $Insurance3 = Yii::app()->db->createCommand("select  distinct vr.Vehicle_No,  ins.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                            from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                            where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Current_Location_ID = l.Location_ID                     
                            and ((datediff(ins.Valid_To,now())) <= '$dateInterval') 
                            and ins.alert_status = '0' order by ins.add_date asc")->queryAll();
                        
                        /*
                        select ins.*, vr.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                    from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                        where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                    and now() between date_sub(ins.Valid_To, interval 30 day) and  ins.Valid_To
                    and (('$criticalPeriod' >(datediff(ins.Valid_To,now())))) order by ins.add_date asc
                                                */

                    }        


                    if(($Pending_Insuarance_Details !== "0") && (count($Insurance3) !== 0))
                    {
                        $appendString.='<tr><th colspan="2">Insurance Alerts !</th></tr>' ;

                        for ($i = 0; $i < count($Insurance3); $i++)
                        {
                            if (($criticalPeriod >= $Insurance3[$i]['dateCount'])) {
                            $css = 'id="error"';
                            } elseif (($nonCriticalPeriod > $Insurance3[$i]['dateCount']) && (($Insurance3[$i]['dateCount']) > $criticalPeriod )) {
                                $css = 'id="warning"';
                            } else {
                                $css = 'id="notice"';
                            }
                            
                            
                            $appendString.= '<tr ><td '.$css.'>'.$Insurance3[$i]['Vehicle_No']." : Vehicle insurance expires on : ".$Insurance3[$i]['Valid_To']." </td>";
                            $appendString.= '<td '.$css.'><img title="Ok" style="hegiht:16px; width:16px;" src="./images/ok.png" onclick="set_alert_status(\''."TRInsurance".'\',\''.$Insurance3[$i]['Insurance_ID'].'\')"  /></td></tr>';

                        }
                        $appendString.='<tr><td colspan="2" style="border:none !important">   </td></tr>' ;
                    }

                    if (($superuserstatus !== "1")&&(!empty($locID))) 
                    {            
                        $Emmission3 = Yii::app()->db->createCommand("select distinct vr.Vehicle_No,  et.*,  l.*, vl.*, datediff(et.Valid_To,now()) as remainingDays, datediff(et.Valid_To,now()) as dateCount 
                            from emission_test as et, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                            where et.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Current_Location_ID = l.Location_ID 
                            and vl.Current_Location_ID ='$locID' and (((datediff(et.Valid_To,now())<= '$dateInterval'))) 
                            and et.alert_status = '0' order by et.add_date asc")->queryAll();

                    } 
                    else 
                    {
                        $Emmission3 = Yii::app()->db->createCommand("select  distinct vr.Vehicle_No, et.*, l.*, vl.*, datediff(et.Valid_To,now()) as remainingDays, datediff(et.Valid_To,now()) as dateCount
                            from emission_test as et, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                            where et.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Current_Location_ID = l.Location_ID 
                            and (((datediff(et.Valid_To,now())<= '$dateInterval'))) 
                            and et.alert_status = '0' order by et.add_date asc")->queryAll();

                    }
                    if(($Pending_Emmission_Test !== "0") && (count($Emmission3) !== 0))
                    {

                        $appendString.='<tr><th colspan="2">Emission Test Alerts !</th></tr>' ;

                        for ($i = 0; $i < count($Emmission3); $i++) 
                        {
                            if (($criticalPeriod >= $Emmission3[$i]['dateCount'])) {
                            $css = 'id="error"';
                            } elseif (($nonCriticalPeriod > $Emmission3[$i]['dateCount']) && (($Emmission3[$i]['dateCount']) > $criticalPeriod )) {
                                $css = 'id="warning"';
                            } else {
                                $css = 'id="notice"';
                            }
                            
                          
                           $appendString.= '<tr ><td '.$css.'>'.$Emmission3[$i]['Vehicle_No']." : Vehicle emission expires on : ".$Emmission3[$i]['Valid_To']." </td>";
                           $appendString.= '<td '.$css.'><img title="Ok" style="hegiht:16px; width:16px;" src="./images/ok.png" onclick="set_alert_status(\''."TREmissionTest".'\',\''.$Emmission3[$i]['Emission_test_ID'].'\')"  /></td></tr>';
                        }
                        $appendString.='<tr><td colspan="2" style="border:none !important">   </td></tr>' ;
                    }

                    if (($superuserstatus !== "1")&&(!empty($locID))) 
                    {
                        $Fitness3 = Yii::app()->db->createCommand("select  distinct vr.Vehicle_No, ft.*,  l.*, vl.*, datediff(ft.Valid_To,now()) as remainingDays, datediff(ft.Valid_To,now()) as dateCount
                            from fitness_test as ft, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                            where ft.Vehicle_No = vr.Vehicle_No and ft.Vehicle_No = vl.Vehicle_No and vl.Current_Location_ID = l.Location_ID 
                            and vl.Current_Location_ID ='$locID' and (('$dateInterval' >=(datediff(ft.Valid_To,now())))) 
                            and ft.alert_status = '0' order by ft.add_date asc ")->queryAll();

                    } 
                    else 
                    {
                        $Fitness3 = Yii::app()->db->createCommand("select  distinct vr.Vehicle_No, ft.*, l.*, vl.*, datediff(ft.Valid_To,now()) as remainingDays, datediff(ft.Valid_To,now()) as dateCount
                            from fitness_test as ft, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                            where ft.Vehicle_No = vr.Vehicle_No and ft.Vehicle_No = vl.Vehicle_No and vl.Current_Location_ID = l.Location_ID 
                            and (('$dateInterval' >=(datediff(ft.Valid_To,now())))) 
                            and ft.alert_status = '0' order by ft.add_date asc ")->queryAll();

                    }

                    if(($Pending_Fitness_Test_Details !== "0")&&(count($Fitness3) !== 0))
                    {
                        $appendString.='<tr><th colspan="2">Fitness Test Alerts !</th></tr>' ;

                        for ($i = 0; $i < count($Fitness3); $i++) 
                        {
                            if (($criticalPeriod >= $Fitness3[$i]['dateCount'])) {
                            $css = 'id="error"';
                            } elseif (($nonCriticalPeriod > $Fitness3[$i]['dateCount']) && (($Fitness3[$i]['dateCount']) > $criticalPeriod )) {
                                $css = 'id="warning"';
                            } else {
                                $css = 'id="notice"';
                            }
                            
                            $appendString.= '<tr ><td '.$css.'>'.$Fitness3[$i]['Vehicle_No']." : Vehicle fitness expires on : ".$Fitness3[$i]['Valid_To']." </td>";
                            $appendString.= '<td '.$css.'><img title="Ok" style="hegiht:16px; width:16px;" src="./images/ok.png" onclick="set_alert_status(\''."TRFitnessTest".'\',\''.$Fitness3[$i]['Fitness_Test_ID'].'\')"  /></td></tr>';

                        }
                        $appendString.='<tr><td colspan="2" style="border:none !important">   </td></tr>' ;
                    }



                    if (($superuserstatus !== "1")&&(!empty($locID))) 
                    {                   
                        $License3 = Yii::app()->db->createCommand( "select  distinct vr.Vehicle_No, lic.*,  l.*, vl.*, datediff(lic.Valid_To,now()) as remainingDays, datediff(lic.Valid_To,now()) as dateCount
                        from license as lic, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where lic.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Current_Location_ID = l.Location_ID 
                        and lic.Valid_To and vl.Current_Location_ID ='$locID' and (('$dateInterval' >=(datediff(lic.Valid_To,now())))) 
                        and lic.alert_status = '0' order by lic.add_date asc")->queryAll();

                    } 
                    else 
                    {
                        $License3 = Yii::app()->db->createCommand("select  distinct vr.Vehicle_No, lic.*,  l.*, vl.*, datediff(lic.Valid_To,now()) as remainingDays, datediff(lic.Valid_To,now()) as dateCount
                        from license as lic, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where lic.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Current_Location_ID = l.Location_ID 
                        and lic.Valid_To and (('$dateInterval' >=(datediff(lic.Valid_To,now())))) 
                        and lic.alert_status = '0' order by lic.add_date asc")->queryAll();

                    }

                    if(($Pending_License_Details !== "0") && (count($License3) !== 0))
                    {            
                        $appendString.='<tr><th colspan="2">License Alerts !</th></tr>' ;

                        for ($i = 0; $i < count($License3); $i++) 
                        {
                            if (($criticalPeriod >= $License3[$i]['dateCount'])) {
                            $css = 'id="error"';
                            } elseif (($nonCriticalPeriod > $License3[$i]['dateCount']) && (($License3[$i]['dateCount']) > $criticalPeriod )) {
                                $css = 'id="warning"';
                            } else {
                                $css = 'id="notice"';
                            }
                            
                           $appendString.= '<tr ><td '.$css.'>'.$License3[$i]['Vehicle_No']." : Vehicle license expires on : ".$License3[$i]['Valid_To']." </td>";
                           $appendString.= '<td '.$css.'><img title="Ok" style="hegiht:16px; width:16px;" src="./images/ok.png" onclick="set_alert_status(\''."TRLicense".'\',\''.$License3[$i]['License_ID'].'\')"  /></td></tr>';

                        }
                        $appendString.='<tr><td colspan="2" style="border:none !important">   </td></tr>' ;
                    }

                    $alertClosed = Yii::app()->session['alertClosed'];
                    $sessionArrayLength = Yii::app()->session['appendStringlength'];
                    $appendArraylength = strlen($appendString);


                    if($sessionArrayLength === null)
                    {
                        Yii::app()->session['appendStringlength'] = $appendArraylength;            
                    }

                    if(($sessionArrayLength === null)||($alertClosed !== 1)||($appendArraylength > $sessionArrayLength))
                    {            
                        echo CJSON::encode($appendString);
                        Yii::app()->session['appendStringlength'] = $appendArraylength;
                        Yii::app()->session['alertClosed'] = null;
                    }
        //          echo CJSON::encode($appendString);
                }
            }
        }
    }
    
    public function actionSet_alert_status()
    {        
        if(isset($_POST['set_alert_status']))
        {
            if(isset($_POST['model']))
            {
                $model = $_POST['model'];
            }
            
            if(isset($_POST['id']))
            {
                $id = $_POST['id'];
            }
        
            if(!empty($model) && !empty($id))
            {
                $record = $model::model()->updateByPk($id,array('alert_status'=>'1'));
                echo CJSON::encode($record);
            }
        }      
    }
	
    public function actionRequestsForAssign()
    {
        if(isset($_POST['reqID']))
        {
            $arr = array();
            $reqID = $_POST['reqID'];
            $k=1;


            $data = Yii::app()->db->createCommand('select distinct vb.Booking_Request_ID, pro.firstname, vb.No_of_Passengers, vb.Place_to, vb.From, vb.To, vb.Vehicle_No, d.Full_Name  from vehicle_booking vb
                inner join tbl_users u on u.id = vb.User_ID
                inner join  tbl_profiles pro on pro.user_id = u.id
                left join ma_driver d on d.Driver_ID = vb.Driver_ID
                where vb.Booking_Request_ID ='.$reqID)->queryAll();
            $dataCount = count($data);


            //$class='even';
            if($dataCount>0)
            {
                $bookingID = $data[0]['Booking_Request_ID'];
                $usr = $data[0]['firstname'];
                $Place_to = $data[0]['Place_to'];
                $From = $data[0]['From'];
                $To = $data[0]['To'];
                $id=$data[0]['Booking_Request_ID'];
                $vID=$data[0]['Vehicle_No'];
                $driver=$data[0]['Full_Name'];
                $passengers=$data[0]['No_of_Passengers'];

                $row =  '<tr class="rows" id="row_'.$id.'">
                <td class="dta">'.$bookingID.'</td>
                <td class="dta">'.$usr.'</td>
                <td class="dta">'.$Place_to.'</td>
                <td class="frmTime dta">'.$From.'</td>
                <td class="toTime dta">'.$To.'</td>
                <td class="dta vNo">'.$vID.'</td>
                <td class="dta dName">'.$driver.'</td>
                <td class="dta">'.$passengers.'</td>
                </tr>';
                
                $arr['row']=$row;
                $arr['vNo']=$vID;
                $arr['driver']=$driver;
                echo CJSON::encode($arr);
            }
        }
    }
   //removed from site controller an added     
    public function actionBooking() 
    {
        if (Yii::app()->user->isGuest) 
        {
            $this->redirect(array('/user/login'));
        } 
        else 
        {
            $model = new TRVehicleBooking;
            $this->render('booking', array('model' => $model));
        }
    }
    

    
		
    public function actionRejectApprovedRequests()
    {
        $reason = '';
        if(isset($_POST['ids']))
        {
            $reason = $_POST['reason'];
        }
        if(isset($_POST['ids']))
        {
            $usr = Yii::app()->getModule('user')->user()->username;
            
            //$ids = $_POST['ids'];
            $countIDs = count($_POST['ids']);
            date_default_timezone_set('Asia/Colombo'); 			
            $date = date('Y-m-d H:i:s'); 


            if($countIDs>0)
            {
                for($i=0; $i<$countIDs; $i++)
                {
                    $reqID = (int)$_POST['ids'][$i];
                   
                   TRVehicleBooking::model()->updateByPk("$reqID", array('Booking_Status'=>'Rejected','Booking_Status_Reason'=>$reason, 'Booking_Approval_ID'=>'', 'Approved_By'=>$usr, 'Approved_Date'=>$date));
                }
            }
            
        }
        
    }
        
    public function actionDashboardPendingBooking() 
    {
        $model = new TRVehicleBooking('getPendingBookingRequests');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TRVehicleBooking']))
        {
            $model->attributes = $_GET['TRVehicleBooking'];
        }
        $this->render('dashboardPendingBooking', array('model' => $model,)
        );
    }
        
    public function actionDashboardApprovedBooking() 
    {
        $model = new TRVehicleBooking('getApprovedBookingRequestsDashBoard');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TRVehicleBooking']))
        {
            $model->attributes = $_GET['TRVehicleBooking'];
        }
        $this->render('dashboardApprovedBooking', array('model' => $model), FALSE, TRUE);
    }

    public function actionDashboardAssignedBooking() 
    {
        $model = new TRVehicleBooking('getAssignedBookingRequestsDashBoard');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TRVehicleBooking']))
        {
            $model->attributes = $_GET['TRVehicleBooking'];
        }
        $this->render('dashboardAssignedBooking', array('model' => $model,));
    }
        
        
    public function actionGetOtherBookingDetails() 
    {
        $table ='';
        if(isset($_POST['reqID']) && $_POST['reqID'] !='')
        {
            $reqID = $_POST['reqID'];
            $status='';
            if(isset($_POST['status']) && $_POST['status'] !='')
            {
                $status = $_POST['status'];
            }

            if($status == 'Pending')
            {
                $cri = new CDbCriteria();
                $cri->select = "t.Booking_Request_ID, t.Booking_Status, pro.firstname as User_ID, vc.Category_Name as Vehicle_Category_ID, Vehicle_No, d.Full_Name as Driver_ID, t.From, t.To, t.No_of_Passengers, t.Description, t.Place_from, t.Place_to, t.Average_km, t.Requested_Date, l.Location_Name as add_by, b.Branch as edit_by, Approved_By, Approved_Date";
                $cri->join = "inner join  tbl_users u on u.id = t.User_ID
                              inner join ma_location l on l.Location_ID = u.Location_ID
                              left join ma_branch b on b.Branch_ID = u.Branch_ID
                              inner join tbl_profiles pro on pro.User_ID = u.id
                              inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = t.Vehicle_Category_ID
                              left join ma_driver d on d.Driver_ID = t.Driver_ID";
                $cri->condition="t.Booking_Request_ID = $reqID";

                $arr = TRVehicleBooking::model()->findAll($cri);
                $count = count($arr);
                    
                if($count > 0)
                {                   
                    $reqID = $arr[0]['Booking_Request_ID'];
                    $bookingStatus = $arr[0]['Booking_Status'];
                    $reqBy = $arr[0]['User_ID'];
                    $vehicleCategory = $arr[0]['Vehicle_Category_ID'];
                    $arr[0]['Vehicle_No'] != '' ? $vehicleNo = $arr[0]['Vehicle_No'] : $vehicleNo = '-';
                    $arr[0]['Driver_ID']  != '' ? $driver = $arr[0]['Driver_ID'] : $driver = '-';
                    $fromTime = $arr[0]['From'];
                    $toTime = $arr[0]['To'];
                    $arr[0]['No_of_Passengers']  != '' ? $passengers = $arr[0]['No_of_Passengers'] : $passengers = '-';
                    $arr[0]['Description'] != '' ? $reason = $arr[0]['Description'] : $reason = '-';
                    $placeFrom = $arr[0]['Place_from'];
                    $placeTo = $arr[0]['Place_to'];
                    $arr[0]['Average_km'] != '' ? $averageKm = $arr[0]['Average_km'] : $averageKm = '-';
                    $requestedDate = $arr[0]['Requested_Date'];
                    $location = $arr[0]['add_by'];
                    $arr[0]['edit_by'] != '' ? $branch =$arr[0]['edit_by'] : $branch = '-';
                    
                    
                        
                    $row1 = "<h3 class='viewMoreHeader'>Request Details of Request ID : $reqID</h3> 
                    <table class='moreData'>";
                      
                        $row2 = "<tr>
                            <td class='moreDataTD'><b>Requested By</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$reqBy</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>Location</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$location</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>Branch</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$branch</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>Reason</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$reason</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>Vehicle Category</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$vehicleCategory</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>Requested Vehicle</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$vehicleNo</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>Requested Driver</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$driver</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>From Date/Time</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$fromTime</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>To Date/Time</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$toTime</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>Number of Passengers</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$passengers</td>
                        </tr>
                        
                        <tr>
                            <td class='moreDataTD'><b>From Place</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$placeFrom</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>To Place</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$placeTo</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>Average km</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$averageKm</td>
                        </tr>
                        <tr>
                            <td class='moreDataTD'><b>Requested Date</b></td>
                            <td class='moreDataTD midColon'>:</td>
                            <td class='moreDataTD'>$requestedDate</td>
                        </tr>";
                        
                        if($bookingStatus == 'Approved')
                        {
                             $approvedBy = $arr[0]['Approved_By'];
                              $approvedDate = $arr[0]['Approved_Date'];
                            $row2 .= "
                                <tr>
                                    <td class='moreDataTD'><b>Approved By</b></td>
                                    <td class='moreDataTD midColon'>:</td>
                                    <td class='moreDataTD'>$approvedBy</td>
                                </tr>
                                <tr>
                                    <td class='moreDataTD'><b>Approved Date</b></td>
                                    <td class='moreDataTD midColon'>:</td>
                                    <td class='moreDataTD'>$approvedDate</td>
                                </tr>";
                            
                           
                        }
                        $row3 = "</table>" ;
                        $table = $row1.$row2.$row3;  
                        
                    }
                }               
            }
            
            echo $table;
        }
        
        
public function actionGetVehiclesForBooking() 
{
    date_default_timezone_set("Asia/Colombo");
    $arr = array();
    //$arr['error']="no";
//    $dt = new DateTime();
//echo $dt->format('Y-m-d H:i:s');exit;
//    $today = date('Y-m-d');
  //  echo $today;exit;
    if(isset($_POST['vCat']))
    {
        $vCat = $_POST['vCat'];

        if(isset($_POST['from']) && isset($_POST['to']))
        {
            $from = $_POST['from'];
            $to = $_POST['to'];
            $selectedVehicle = '';
            
            if(isset($_POST['selectedVehicle']) && $_POST['selectedVehicle'] != '')
            {
                $selectedVehicle = $_POST['selectedVehicle'];
            }

            if($from != '' && $to != '')
            {
                $fromTime = substr($from, 11);
                $toTime = substr($to, 11);
                $fromDate = substr($from,0,10);
                $toDate = substr($to,0,10);
                $nowDate = date("Y-m-d");
                $nowTime = date("H:i"); 
                
                if($fromTime == '00:00')
                {
                    $arr['error']="Time is required in 'From Date/Time'";                
                }
                else if($toTime == '00:00')
                {
                    $arr['error']="Time is required in 'To Date/Time'";                
                }
                else if($fromTime<$nowTime && $fromDate==$nowDate)
                {
                     $arr['error']="Past Time is set to 'From Date/Time'";
                }
                else 
                {   
                    if($from > $to)
                    {
                        $arr['error']="Selected date period is invalid"; 
                    }
                    else
                    {
                        $location = Yii::app()->getModule('user')->user()->Location_ID;
                        $branch = Yii::app()->getModule('user')->user()->Branch_Id;
                       // var_dump($branch);
                        /*$sql = "select  vr.Vehicle_No, vc.Category_Name , vr.Vehicle_Category_ID, vr.Vehicle_image  from ma_vehicle_registry vr
                        inner join vehicle_location  vl on vl.Vehicle_No = vr.Vehicle_No 
                        inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
                        where vr.Vehicle_Status_ID =1 and vr.Vehicle_Category_ID=".$vCat." and vr.Allocation_Type_ID = 2 and vl.Current_Location_ID=$location  and  vr.Vehicle_No not in (
                        select distinct ba.Vehicle_No from booking_approval ba 
                        inner join vehicle_booking vb on vb.Booking_Approval_ID  = ba.Booking_Approval_ID  
                        where ('".$from."' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date or '".$to."' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date) and vb.Booking_Status = 'Assigned' and vr.Vehicle_Status_ID =1 and  vr.Allocation_Type_ID = 2)";
                        */
                        if($branch!=null && $branch!="")
                        {
                            $sql = "select  vr.Vehicle_No, vc.Category_Name , vr.Vehicle_Category_ID, vr.Vehicle_image  from ma_vehicle_registry vr
                            inner join vehicle_location  vl on vl.Vehicle_No = vr.Vehicle_No 
                            inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
                            where vr.Vehicle_Status_ID =1 and vr.Vehicle_Category_ID=".$vCat." and vr.Allocation_Type_ID = 2 and vl.Current_Location_ID=$location and vl.Branch_Id=$branch ";
                        }
                        else 
                        {
                             $sql = "select  vr.Vehicle_No, vc.Category_Name , vr.Vehicle_Category_ID, vr.Vehicle_image  from ma_vehicle_registry vr
                            inner join vehicle_location  vl on vl.Vehicle_No = vr.Vehicle_No 
                            inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
                            where vr.Vehicle_Status_ID =1 and vr.Vehicle_Category_ID=".$vCat." and vr.Allocation_Type_ID = 2 and vl.Current_Location_ID=$location  ";
                        }
                       
                        

                        $availableVehicles = Yii::app()->db->createCommand($sql)->queryAll();
                       // var_dump($availableVehicles);exit;
                        $countVehicles = count($availableVehicles);
                        $vehicles ='';
                        if($countVehicles >0)
                        {
                            for($i = 0; $i<$countVehicles; $i++)
                            {
                                $vNo = $availableVehicles[$i]['Vehicle_No'];
                                $vImg = $availableVehicles[$i]['Vehicle_image'];

                                $dotPos = strpos((string)$vImg, '.');
                                if(!$dotPos  > 0)
                                {
                                    $vImg = 'noImage.jpg';
                                }

                                    // check whether the vehicle is booked...........
                                $qry1="select distinct ba.Vehicle_No from  booking_approval ba inner join vehicle_booking vb on ba.Booking_Approval_ID =vb.Booking_Approval_ID where 
            ba.Vehicle_No='".$vNo."' and vb.Booking_Status ='Assigned' and ('".$from."' between New_Booking_Request_Date and New_Booking_To_Date
            or '".$to."' between New_Booking_Request_Date and New_Booking_To_Date)";

                                $isBookedVehicle = Yii::app()->db->createCommand($qry1)->queryAll();
                                $vehicleClass = 'clsVehicle';
                                $bookedCount = count($isBookedVehicle);
                                if(count($isBookedVehicle)>0)
                                {
                                    $vehicleClass .= ' booked'; // add class if booked vehicle
                                }

                                if($selectedVehicle != '')
                                {
                                    if($vNo == $selectedVehicle)
                                    {
                                        $vehicleClass .= ' default';
                                    }
                                }
                                $id = str_replace(' ', "", $vNo);

                                $vehicles .= "<div class='$vehicleClass' id='$id'  onclick='getDrivers(\"$vNo\", \"$vImg\")'><img src='VechicleReg/$vImg' width='80px' height='80px'/><div class='displayNames'>$vNo</div></div>";
                                $arr['vehicles'] = $vehicles;
                            }
                        }
                    }
                }
            }
            else
            {
                $arr['error']="Date period is required";  
            }
        }
    }
    echo CJSON::encode($arr);
}

    public function actionGetDrivers() 
    {
        $location = Yii::app()->getModule('user')->user()->Location_ID;
        $arr = array();
        if(isset($_POST['from']) && isset($_POST['to']))
        {
            $vID ='';
            if(isset($_POST['vID']))
            {
                $vID = $_POST['vID'];
            }
            $drivers ='';
            $from = $_POST['from'];
            $to = $_POST['to'];
            
            $selectedDriver= '';
            if(isset($_POST['selectedDriver']) && $_POST['selectedDriver'] !=='')
            {
                $selectedDriver = $_POST['selectedDriver'];
            }
            
           // get drivers
            $sql = "select distinct d.Driver_ID, d.Full_Name, d.Driver_Image, vl.Vehicle_No from ma_driver d
            left join vehicle_location vl on vl.Driver_ID = d.Driver_ID
            where d.Status='1' and  d.Location_ID=$location group by  d.Driver_ID order by d.Full_Name";

            $availableDriverArray = Yii::app()->db->createCommand($sql)->queryAll();
            $countDrivers = count($availableDriverArray);
        
            if($countDrivers > 0)
            {
                for($i = 0; $i<$countDrivers; $i++)
                {
                    $dID = $availableDriverArray[$i]['Driver_ID'];
                    $dName = $availableDriverArray[$i]['Full_Name'];
                    $dImg = $availableDriverArray[$i]['Driver_Image'];

                    $dotPos = strpos((string)$dImg, '.');
                    if(!$dotPos  > 0)
                    {
                        $dImg = 'DefaultDriver.jpg';
                    }
                    $space = stripos($dName, ' ');
                    if($space !=='' && $space > 0)
                    {
                        $dName = substr($dName, (int)$space);
                    }

                    // check whether the vehicle is booked...........
                    $qry1="select distinct ba.Driver_ID from  booking_approval ba inner join vehicle_booking vb on ba.Booking_Approval_ID =vb.Booking_Approval_ID where 
                    ba.Driver_ID='".$dID."' and vb.Booking_Status ='Assigned' and ('".$from."' between New_Booking_Request_Date and New_Booking_To_Date
                    or '".$to."'  between New_Booking_Request_Date and New_Booking_To_Date)";

                    $arrStatus = Yii::app()->db->createCommand($qry1)->queryAll();
                    
                    $driverClass = 'clsDriver';
                    $bookedCount = count($arrStatus);
                    if($bookedCount>0)
                    {
                        $driverClass .= ' booked'; // add class if booked vehicle
                    }
                    
                    $arrayDefault = Yii::app()->db->createCommand('select vl.Driver_ID, d.Full_Name from vehicle_location vl
		inner join ma_driver d on d.Driver_ID = vl.Driver_ID where vl.Vehicle_No ="'.$vID.'"')->queryAll();
                    $countDefault = count($arrayDefault);
                    if($countDefault > 0)
                    {
                        if($arrayDefault[0]['Driver_ID'] == $dID) 
                        {
                            $driverClass .= " default";
                        }
                        
                    }
                    
                    if($selectedDriver == $dID)
                    {
                        $driverClass = str_replace(" default", '', $driverClass);
                        $driverClass .= " default";
                    }

                    $drivers .= "<div class='$driverClass' id='d_$dID'  onclick='setDriver(\"$dID\", \"$dImg\")'><img src='DriverImages/$dImg' width='80px' height='80px'/><div class='displayNames'>$dName</div></div>";
                    $arr['drivers'] = $drivers;
                }
            }
        
            
                
                //default driver
                //$vNo = $_POST['vNo'];
		
            
        }
        
        echo CJSON::encode($arr);
    }
    
    public function actionGetRequestsForAssigning() 
    {
        if(isset($_POST['ids']))
        {
            $arr = array();
            $ids = $_POST['ids'];
            $LocID = Yii::app()->getModule("user")->user()->Location_ID;
            $minDate = MaVehicleRegistry::model()->getServerDate('dateTime');
            $maxDate = $minDate;
            $row = '';
            $mainClass = 'dta';
            $countIDs = count($ids);
            $requestedVehicle ='';
            $requestedDriver ='';
            $driverOption ='';
            
            if($countIDs > 0)
            {
                for($i = 0; $i < $countIDs; $i++)
                {
                    $reqID = $ids[$i];
                    $data = Yii::app()->db->createCommand('select distinct vb.Booking_Request_ID, pro.firstname, vb.No_of_Passengers, vb.Place_from, vb.Place_to, vb.From, vb.To, vb.Vehicle_No, vb.Driver_ID,  d.Full_Name  from vehicle_booking vb
                    inner join tbl_users u on u.id = vb.User_ID
                    inner join  tbl_profiles pro on pro.user_id = u.id
                    left join ma_driver d on d.Driver_ID = vb.Driver_ID
                    where vb.Booking_Request_ID ='.$reqID)->queryAll();
                    
                    $dataCount = count($data);

                    if($dataCount>0)
                    { 
                        if($i==0)
                        {
                            $minDate = $data[0]['From'];
                            $maxDate = $data[0]['To'];
                            if($countIDs == '1')// check whether only one request is selected 
                            {
                                $requestedVehicle = $data[0]['Vehicle_No'];
                                $requestedDriver = $data[0]['Driver_ID'];
                            }
                        }
                        else
                        {
                            if($minDate > $data[0]['From'])
                            {
                                $minDate = $data[0]['From'];
                            }
                            if($maxDate < $data[0]['To'])
                            {
                                $maxDate = $data[0]['To'];
                            }
                        }
                        
                        $j = $i + 1;
                        //$rowClass .= ' odd';
                        if($j % 2 == 0)
                        {
                            $rowClass = $mainClass.' even';
                        } 
                        else
                        {
                            $rowClass = $mainClass.' odd';
                        }
                        
                        $bookingID = $data[0]['Booking_Request_ID'];
                        $usr = $data[0]['firstname'];
                        $Place_frm = $data[0]['Place_from'];
                        $Place_to = $data[0]['Place_to'];
                        $From = $data[0]['From'];
                        $To = $data[0]['To'];
                        $id=$data[0]['Booking_Request_ID'];
                        $vID=$data[0]['Vehicle_No'];
                        $driver=$data[0]['Full_Name'];
                        $passengers=$data[0]['No_of_Passengers'];

                        $row .= "<tr class='rows' id='row_$id'>
                                    <td class='$rowClass'>$bookingID</td>
                                    <td class='$rowClass'>$usr</td>
                                    <td class='$rowClass'>$Place_frm</td>
                                    <td class='$rowClass'>$Place_to</td>
                                    <td class='$rowClass'>$From</td>
                                    <td class='$rowClass'>$To</td>
                                    <td class='$rowClass'>$vID</td>
                                    <td class='$rowClass'>$driver</td>
                                    <td class='$rowClass'>$passengers</td>
                                </tr>";                  
                                              
                    }
                }
                
                // set vehicle options 
                $queryVehicle = "select distinct vr.Vehicle_No, vr.Vehicle_Category_ID, vc.Category_Name
                    from ma_vehicle_registry vr
                    inner join vehicle_location  vl on vl.Vehicle_No = vr.Vehicle_No 
                    inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
                    where vr.Vehicle_Status_ID =1 and vl.Current_Location_ID=$LocID  and  vr.Vehicle_No not in (
                    select distinct ba.Vehicle_No from booking_approval ba 
                    inner join vehicle_booking vb on vb.Booking_Approval_ID  = ba.Booking_Approval_ID  
                    where ('$minDate' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date or '$maxDate' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date) and vb.Booking_Status = 'Assigned' and vr.Vehicle_Status_ID =1)";
                        

                $arrVehicle = Yii::app()->db->createCommand($queryVehicle)->queryAll();

                $vehicleOptions ="<option value=''>--- Please Select ---</option>";
                $vCategory = '';
                $countVehicleArr = count($arrVehicle);
                if($countVehicleArr > 0)
                {
                    for($k = 0; $k < $countVehicleArr; $k++)
                    {
                        $vNo = $arrVehicle[$k]['Vehicle_No'];
                        $vCat = $arrVehicle[$k]['Category_Name'];
                        if($vCategory != $vCat)
                        {
                            $vCategory= $vCat;
                            $vehicleOptions .= "<option disabled style='font-weight:bold'>$vCat</option>";
                        }
                        if($vCategory == $vCat)
                        {
                            if($vNo == $requestedVehicle)
                            {
                                $vehicleOptions .= "<option selected value='$vNo'>$vNo</option>";
                            }
                            else
                            {
                                $vehicleOptions .= "<option value='$vNo'>$vNo</option>";
                            }

                        }

                    }
                }
                        
                // set driver options
                
                $queryDriver = "select distinct d.Driver_ID, d.Full_Name from ma_driver d
                where d.Location_ID = '$LocID' and d.Driver_ID not in (
                select distinct ba.Driver_ID from booking_approval ba 
                inner join vehicle_booking vb on vb.Booking_Approval_ID  = ba. 	Booking_Approval_ID  
                where ('$minDate' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date or '$maxDate' between ba.New_Booking_Request_Date and ba.New_Booking_To_Date) and vb.Booking_Status = 'Approved')
                order by d.Full_Name ASC";

                $arrDriver = Yii::app()->db->createCommand($queryDriver)->queryAll();
                $countDriverArr = count($arrDriver);        
                $driverOption ="<option value=''>--- Please Select ---</option>";
                if($countDriverArr > 0)
                {
                    for($m = 0; $m < $countDriverArr; $m++)
                    {
                        $driverName = $arrDriver[$m]['Full_Name'];
                        $driverID = $arrDriver[$m]['Driver_ID'];

                        if($driverID == $requestedDriver)
                        {
                            $driverOption .= "<option selected value='$driverID'>$driverName</option>";
                        }
                        else
                        {
                            $driverOption .= "<option value='$driverID'>$driverName</option>";
                        }
                    }
                }
                
            }
            else 
            {
                
            }
            
            $arr['row']=$row;
            $arr['vehicle']=$vehicleOptions;
            $arr['driver']=$driverOption;
            $arr['minDate'] = $minDate;
            $arr['maxDate'] = $maxDate;
            echo CJSON::encode($arr);
            
        }
        else 
        {
            //echo CJSON::encode('dfd');
        }
        
        
    }
    

    
    public function actionGetDefaultDriver() 
    {
        if(isset($_POST['vNo']) && $_POST['vNo'] !== '')
        {
            $vNo = $_POST['vNo'];
            $arr = array();
            $slctDriver = VehicleDriver::model()->getDefaultDriver($vNo);
            $passengers = MaVehicleRegistry::model()->getNumberOfPassengers($vNo);
            $arr['driver'] = $slctDriver;
            $arr['passengers'] = $passengers;
            echo CJSON::encode($arr);
            
        }
    }

}
