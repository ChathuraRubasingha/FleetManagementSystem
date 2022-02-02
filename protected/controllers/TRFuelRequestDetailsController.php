<?php

class TRFuelRequestDetailsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

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

        $curr_controlername= $this->getUniqueId();
        $curr_action=Yii::app()->controller->action->id;
        $access=Yii::app()->user->GetPermission($curr_controlername,$curr_action);

        if($access=='true')
        {
            return array(

                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions'=>array($curr_action),
                    'users'=>array(Yii::app()->user->name),
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
            );
        }
        else
        {
            return array(
                array('allow',  // allow all users to perform 'index' and 'view' actions
                    'actions'=>array('approve','disapprove','reject', 'Canceled','DashboardPendingFuelRequests','DashboardApprovedFuelRequests'),
                    'users'=>array('*'),
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
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
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
        {
            unset(Yii::app()->session['btnClick']);
        }

        //$aType = Yii::app()->session['VehicleIdAllocationID'];


        $model=new TRFuelRequestDetails;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['TRFuelRequestDetails']))
        {
            $model->add_date = $_POST['TRFuelRequestDetails']['add_date'];
            //echo $model->add_date;exit;
            $model->attributes=$_POST['TRFuelRequestDetails'];

            $vid = Yii::app()->session['VehicleIdFuel'];
            $aid =Yii::app()->session['VehicleIdAllocationID'];
            $appDate = MaVehicleRegistry::model()->getServerDate("date");
            $lst = tRFuelRequestDetails::model()->getLastFuelReading(1);

            $oldMeterReading = 0;
            $oldFuelRequired=0;
            $oldFuelBalance=0;

            $cnt=count($lst);

            if ($cnt > 0)
            {
                $oldMeterReading = $lst[0]['Meter_Reading'];
                $oldFuelRequired = $lst[0]['Required_Fuel_Capacity'];
                $oldFuelBalance = $lst[0]['Fuel_Balance'];
            }

            $newMeterReading = $model-> Meter_Reading;

            $fuelTankCapacity_array = Yii::app()->db->createCommand("select Fuel_Tank_Capacity from ma_vehicle_registry where Vehicle_No ='".$vid."'")->queryAll();

            $fuelTankCapacity = 0;
            if(count($fuelTankCapacity_array)>0)
            {
                $fuelTankCapacity = $fuelTankCapacity_array[0]['Fuel_Tank_Capacity'];
            }

            $Chk_Pending_Exist_Array = Yii::app()->db->createCommand("SELECT * FROM fuel_request_details WHERE Vehicle_No='".$vid."' and (Approve_Status='Pending' or Approve_Status='Approved')")->queryAll();
            //$Previous_Max_ID = $Previous_Max[0]['Fuel_Request_ID'];

            $countExist = count($Chk_Pending_Exist_Array);
            
            $requiredCapacity = $model->Required_Fuel_Capacity;
            //echo $requiredCapacity.' gg  '. $fuelTankCapacity;exit;
            if(($model->Required_Fuel_Capacity) > $fuelTankCapacity)
            {
                $capacityMsg ="'Required Fuel Capacity' should be less than 'Fuel Tank Capacity' of the vehicle...!";
                $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                if($userRole ==='3')
                {
                    $capacityMsg ="අවශ්‍ය ඉන්දන ප්‍රමාණය වාහනයේ ටැංකියේ පරිමාවට සමාන හෝ ඊට වඩා අඩු විය යුතුය.";
                }
                Yii::app()->user->setFlash('success', $capacityMsg);
                Yii::app()->session['btnClick'] = "1";
            }
            elseif ($countExist> 0)
            {
                $preReqDate = $Chk_Pending_Exist_Array[0]['Request_Date'];

                if(($model->Required_Fuel_Capacity) > $fuelTankCapacity)
                {
                    $capacityMsg ="'Required Fuel Capacity' should be less than 'Fuel Tank Capacity' of the vehicle...!";
                    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                    if($userRole ==='3')
                    {
                        
                         $capacityMsg ="අවශ්‍ය ඉන්දන ප්‍රමාණය වාහනයේ ටැංකියේ පරිමාවට සමාන හෝ ඊට වඩා අඩු විය යුතුය.";
                    }
                    Yii::app()->user->setFlash('success', $capacityMsg);
                    Yii::app()->session['btnClick'] = "1";
                }
                elseif($oldMeterReading >= $newMeterReading)
                {
                    $meterMsg ="'Meter Reading' should be greater than previous value...!";
                    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                    if($userRole ==='3')
                    {
                       
                        $meterMsg =" 'මීටර කියවීම ' පෙර පැවති මීටර කියවීමට වඩා වැඩි විය යුතුය .";
                    }
                    Yii::app()->user->setFlash('success', $meterMsg);
                    Yii::app()->session['btnClick'] = "1";
                }
                elseif($appDate < $model->Request_Date)
                {
                    $dateMsg ="'Request Date' should be a previous date...!";
                    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                    if($userRole ==='3')
                    {
                        
                        $dateMsg ="'අයදුම් කරන දිනය ' අද දිනය හෝ පෙර දිනයක් විය යුතුය  .";
                    }
                    Yii::app()->user->setFlash('success', $dateMsg);
                    Yii::app()->session['btnClick'] = "1";
                }

                if($preReqDate == $model->Request_Date)
                {
                    $dateMsg ="Previous fuel request is existed...!";
                    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                    if($userRole ==='3')
                    {
                        $dateMsg ="පෙර අයදුම් කරන ලද ඉන්ධන අයදුමක් පවතී..!";
                    }

                    Yii::app()->user->setFlash('success', $dateMsg);
                    Yii::app()->session['btnClick'] = "1";
                }
                elseif($appDate < $model->Request_Date)
                {
                    $dateMsg ="'Request Date' should be a previous date..!";
                    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                    if($userRole ==='3')
                    {
                        $dateMsg ="'අයදුම් කරන දිනය' අද දිනය හෝ පෙර දිනයක් විය යුතුය..!";
                    }
                    Yii::app()->user->setFlash('success', $dateMsg);
                    Yii::app()->session['btnClick'] = "1";
                }
                else
                {
                    $dateMsg ="Pending fuel request is existed...!";
                    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                    if($userRole ==='3')
                    {
                        $dateMsg ="පෙර අයදුම් කරන ලද ඉන්ධන අයදුමක් පවතී..!";
                    }
                    Yii::app()->user->setFlash('success', $dateMsg);
                    Yii::app()->session['btnClick'] = "1";
                }
            }
            else
            {  
                $Fuel_Balance=0;

                $half= $model->Fuel_Balance_Range;
                if ($half=='0')
                {
                    $Fuel_Balance = 0;
                }                    
                else if($half =='1/8')
                {
                    $Fuel_Balance = ($fuelTankCapacity * 1/8);
                }
                else if($half =='1/4')
                {
                    $Fuel_Balance = ($fuelTankCapacity * 1/4);
                }
                else if($half =='1/2')
                {
                    $Fuel_Balance = ($fuelTankCapacity * 1/2);
                }
                else
                {
                    $Fuel_Balance = ($fuelTankCapacity * 3/4);
                }

                $model->Fuel_Balance = $Fuel_Balance;

                if($model->validate())
                {
                    if($oldMeterReading >= $newMeterReading)
                    {
                        $meterMsg ="'Meter Reading' should be greater than previous value...!";
                        $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                        if($userRole ==='3')
                        {
                            $meterMsg ="'මීටර කියවීම', පෙර පැවති  මීටර කියවීමට වඩා වැඩි  විය යුතුය..! ";
                        }
                        Yii::app()->user->setFlash('success', $meterMsg);
                        Yii::app()->session['btnClick'] = "1";
                    }
                    else
                    {
                        $Distance_Driven_All = $newMeterReading - $oldMeterReading;

                        $FRID_Array = Yii::app()->db->createCommand('SELECT Max(Fuel_Providing_ID) as ID, Fuel_Amount FROM fuel_providing_details WHERE Vehicle_No= "'.$vid.'"')->queryAll();
                        $Privious_Fuel_Id=0;
                        if(count($FRID_Array)>0)
                        {
                            $Privious_Fuel_Id = $FRID_Array[0]['ID'];
                            
                            $Distance_Driven=0;
                            if ((count($FRID_Array) >0) && ($Privious_Fuel_Id !== null))
                            {
                                if($oldFuelRequired =='')
                                {
                                    $oldFuelRequired=1;
                                }
                                if($oldFuelBalance=='')
                                {
                                    $oldFuelBalance=1;
                                }
                                if($Fuel_Balance=='')
                                {
                                    $Fuel_Balance=1;
                                }
                                $Privious_Fuel_Amount = $FRID_Array[0]['Fuel_Amount'];
                                $Distance_Driven = ($Distance_Driven_All/($oldFuelRequired + $oldFuelBalance - $Fuel_Balance))* $Privious_Fuel_Amount;

                            }
                        

                        
                            //echo $Privious_Fuel_Amount;exit;
                            //$model-> Previous_Distance_Driven = $Distance_Driven;
                            //echo $Previous_Max_ID; exit;
                            //echo $Distance_Driven. " - ".$Distance_Driven1." - ".$oldFuelRequired." - ".$oldFuelBalance." - ".$Fuel_Balance." - ".$Privious_Fuel_Amount; exit;
                            //echo $Distance_Driven; exit;
                            //$FRID = $FRID_Array[0]['ID'];
                            //$data = "UPDATE fuel_providing_details SET Distance_Driven =".$Distance_Driven." WHERE Fuel_Providing_ID = ".$FRID."";
                            //$rawData = Yii::app()->db->createCommand($data)->execute();
                        }

                        if($model->save())
                        {
                            $Previous_Max = Yii::app()->db->createCommand('SELECT Fuel_Request_ID FROM fuel_request_details WHERE Vehicle_No= "'.$vid.'" ORDER BY Fuel_Request_ID DESC LIMIT 1 , 1')->queryAll();
                            //$Previous_Max_ID = $Previous_Max[0]['Fuel_Request_ID'];

                            if (count($Previous_Max)> 0)
                            {
                                $Previous_Max_ID = $Previous_Max[0]['Fuel_Request_ID'];
                                $data = "UPDATE fuel_request_details SET Previous_Distance_Driven ='".$Distance_Driven."' WHERE Fuel_Request_ID = '".$Previous_Max_ID."'";
                                $rawData = Yii::app()->db->createCommand($data)->execute();
                            }
                            $successMsg ='Successfully Added..!';
                            $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                            if($userRole ==='3')
                            {
                                $successMsg ='සාර්ථක ලෙස ගබඩා කරන ලදී..!';
                            }
                            Yii::app()->user->setFlash('success', $successMsg);
                            $this->redirect(array('view','id'=>$model->Fuel_Request_ID));
                        }
                    }
                }
                else
                {
                    Yii::app()->session['btnClick'] = "1";
                }
            }

        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
        {
            unset(Yii::app()->session['btnClick']);
        }
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['TRFuelRequestDetails']))
        {
            $model->attributes=$_POST['TRFuelRequestDetails'];
            $appDate = date("Y-m-d");
            $vid = Yii::app()->session['VehicleIdFuel'];

            $fuelTankCapacity_array = Yii::app()->db->createCommand("select Fuel_Tank_Capacity from ma_vehicle_registry where Vehicle_No ='".$vid."'")->queryAll();
            $fuelTankCapacity = 0;
            if(count($fuelTankCapacity_array)>0)
            {
                $fuelTankCapacity = $fuelTankCapacity_array[0]['Fuel_Tank_Capacity'];
            }

            //////////////////////////////////////////////////////

            $aid =Yii::app()->session['VehicleIdAllocationID'];
            $lst = tRFuelRequestDetails::model()->getLastFuelReading(2);

            $oldEntry = 0;
            $oldFuelRequired=0;
            $oldFuelBalance=0;

            $cnt=count($lst);

            if ($cnt > 0)
            {
                $oldEntry = $lst[0]['Meter_Reading'];
                $oldFuelRequired = $lst[0]['Required_Fuel_Capacity'];
                $oldFuelBalance = $lst[0]['Fuel_Balance'];
            }

            $model->attributes=$_POST['TRFuelRequestDetails'];
            $newEntry = $model-> Meter_Reading;

            //echo $oldEntry;exit;
            //////////////////////////////////////////////////////

            $Tank_Capacity_Array = Yii::app()->db->createCommand('SELECT Fuel_Tank_Capacity FROM ma_vehicle_registry WHERE Vehicle_No= "'.$vid.'"')->queryAll();

            $Tank_Capacity = $Tank_Capacity_Array[0]['Fuel_Tank_Capacity'];

            //echo $model-> Fuel_Balance_Range; exit;
            $Fuel_Balance=0;

            $half= $model-> Fuel_Balance_Range;
            if ($half=='0')

                $Fuel_Balance = ($Tank_Capacity * 0);
            else if($half =='1/8')
            {
                $Fuel_Balance = ($Tank_Capacity * 1/8);
            }
            else if($half =='1/4')
            {
                $Fuel_Balance = ($Tank_Capacity * 1/4);
            }
            else if($half =='1/2')
            {
                $Fuel_Balance = ($Tank_Capacity * 1/2);
            }
            else
            {
                $Fuel_Balance = ($Tank_Capacity * 3/4);
            }

            $model-> Fuel_Balance = $Fuel_Balance;

            $valid = $model->validate();
            if($valid)
            {
                if(($model->Required_Fuel_Capacity) > $fuelTankCapacity)
                {
                    $capacityMsg ="'Required Fuel Capacity' should be less than 'Fuel Tank Capacity' of the vehicle...!";
                    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                    if($userRole ==='3')
                    {
                         $capacityMsg ="අවශ්‍ය ඉන්දන ප්‍රමාණය වාහනයේ ටැංකියේ පරිමාවට සමාන හෝ ඊට වඩා අඩු විය යුතුය.";
                    }
                    Yii::app()->user->setFlash('success', $capacityMsg);
                    Yii::app()->session['btnClick'] = "1";
                }
                elseif($oldEntry >= $newEntry)
                {
                    $meterMsg ="'Meter Reading' should be greater than previous value...!";
                    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                    if($userRole ==='3')
                    {
                        $meterMsg ="'මීටර කියවීම් ' පෙර පැවති මීටර කියවීමට වඩා අඩු විය යුතුය.";
                    }
                    Yii::app()->user->setFlash('success', $meterMsg);
                    Yii::app()->session['btnClick'] = "1";
                }
                elseif($appDate < $model->Request_Date)
                {
                    $dateMsg ="'Request Date' should be a previous date...!";
                    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                    if($userRole ==='3')
                    {
                        $dateMsg ="'අයදුම් කරන දිනය' අද දිනය හෝ පෙර දිනයක් විය යුතුය..!";
                    }
                    Yii::app()->user->setFlash('success', $dateMsg);
                    Yii::app()->session['btnClick'] = "1";
                }
                else
                {
                    if($model->save())
                    {
                        $successMsg ="Successfully Updated..!";
                        $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                        if($userRole ==='3')
                        {
                            $successMsg ='සාර්ථක ලෙස යාවත්කාලින  කරන ලදී..!';
                        }
                       Yii::app()->user->setFlash('success', $successMsg);
                        $this->redirect(array('view','id'=>$model->Fuel_Request_ID));
                    }
                }
            }
            else
            {
                Yii::app()->session['btnClick'] = "1";
            }
        }

        $this->render('update',array(
            'model'=>$model,
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
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('TRFuelRequestDetails');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin($id)
    {

        Yii::app()->session['VehicleIdFuel'] = $id;
        $model=new TRFuelRequestDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TRFuelRequestDetails']))
            $model->attributes=$_GET['TRFuelRequestDetails'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */

    public function actionFuelRequestHistory()
    {

        $model=new TRFuelRequestDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TRFuelRequestDetails']))
            $model->attributes=$_GET['TRFuelRequestDetails'];

        $this->render('fuelRequestHistory',array(
            'model'=>$model,
        ));
    }

    public function actionApprovePendingList()
    {


        $model=new TRFuelRequestDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TRFuelRequestDetails']))
            $model->attributes=$_GET['TRFuelRequestDetails'];

        $this->render('ApprovePendingList',array(
            'model'=>$model,
        ));
    }

    public function actionApprovedRequests()
    {
        $model=new TRFuelRequestDetails('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TRFuelRequestDetails']))
            $model->attributes=$_GET['TRFuelRequestDetails'];

        $this->render('approvedRequests',array(
            'model'=>$model,
        ));
    }

    public function actionApproveFuelRequest($requestId)
    {
        $vid = Yii::app()->request->getQuery('Vid');

        if ($vid != "")
        {
            Yii::app()->session['VehicleIdFuel'] = $vid;
        }

        Yii::app()->session['requestId'] = $requestId;
        $model = $this->loadModel($requestId);
        $this->render('approveFuelRequest',array(
            'model'=>$model,'request'=>$this->loadRequest($requestId),

        ));
    }

    public function actionRejectRequest($requestId)
    {
        $vid = Yii::app()->request->getQuery('vid');

        if ($vid != "")
        {
            Yii::app()->session['VehicleIdFuel'] = $vid;
        }

        Yii::app()->session['requestId'] = $requestId;
        $model = $this->loadModel($requestId);
        $this->render('rejectRequest',array(
            'model'=>$model,'request'=>$this->loadRequest($requestId),

        ));
    }

    public function actionApprove()
    {
        if(isset($_POST['reqID']) && $_POST['reqID'] !=='' )
        {
            $model = new TRFuelRequestDetails;

            if($model->approve($_POST['reqID']))
            {
                echo 'OK';
            }
        }
    }



    public function actionDisapprove()
    {
        if(isset($_POST['reqID']) && $_POST['reqID'] !=='' )
        {
            if(isset($_POST['reason']) && $_POST['reason'] !=='' )
            {
                $model = new TRFuelRequestDetails;

                if($model->disapprove($_POST['reqID'], $_POST['reason']))
                {
                    echo 'OK';
                }
            }
        }
        
    }

    public function actionReject()
    {
        if(isset($_POST['ReqID']) && $_POST['ReqID'] !=='' )
        {
            if(isset($_POST['reason']) && $_POST['reason'] !=='' )
            {
                $model = new TRFuelRequestDetails;

                if($model->reject($_POST['ReqID'], $_POST['reason']))
                {
                    echo 'OK';
                }
            }
        }
    }

    public function actionCanceled()
    {
        $url = Yii::app()->request->baseUrl."/index.php?r=dashboard/";
        header('location:'.$url);

    }


    public function loadModel($id)
    {
        $model=TRFuelRequestDetails::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function loadRequest($id)
    {
        $request=TRFuelRequestDetails::model()->findByPk($id);
        if($request===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $request;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='trfuel-request-details-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPendingFuelRequests()
    {
        $model = new TRFuelRequestDetails;
        $this->render('pendingFuelRequests',array(
            'model'=>$model,
        ));
    }

    public function actionApprovedFuelRequests()
    {
        $model = new TRFuelRequestDetails;
        $this->render('approvedFuelRequests',array(
            'model'=>$model,
        ));
    }

    public function actionDisapprovedFuelRequests()
    {
        $model = new TRFuelRequestDetails;
        $this->render('disapprovedFuelRequests',array(
            'model'=>$model,
        ));
    }

    public function actionCompletedFuelRequests()
    {
        $model = new TRFuelRequestDetails;
        $model2 = new TRFuelProvidingDetails;
        $this->render('completedFuelRequests',array(
            'model'=>$model, 'model2' =>$model2
        ));
    }

    public function actionRejectedFuelRequests()
    {
        $model = new TRFuelRequestDetails;
        $this->render('rejectedFuelRequests',array(
            'model'=>$model,
        ));
    }

    protected function gridFuelData($data, $row)
    {
        $arr = Yii::app()->db->createCommand('select * from fuel_providing_details fp where Fuel_Request_ID='.$data->Fuel_Request_ID)->queryAll();

        $result = '';
        if(!empty($arr))
            foreach ($arr as $raw)
            {
                $result = $raw['Fuel_Order_No'];

                $result = $raw['Fuel_Pumped_Date'];
                $result = $raw['Fuel_Station'];
                /*$row .= $raw[][];
                $row .= $raw[][];
                $row .= $raw[][];
                $row .= $raw[][];*/
            }
        return $result;
    }
    
    public function actionDashboardPendingFuelRequests() 
    {
        $model = new TRFuelRequestDetails('getFuelRequestDetailsDashBoard');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TRFuelRequestDetails']))
        {
            $model->attributes = $_GET['TRFuelRequestDetails'];
        }


        $this->render('dashboardPendingFuelRequests', array('model' => $model,)
        );
    }
    
    public function actionDashboardApprovedFuelRequests() 
    {
        $model = new TRFuelRequestDetails('getFuelApprovedListDashBoard');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TRFuelRequestDetails']))
        {
            $model->attributes = $_GET['TRFuelRequestDetails'];
        }


        $this->render('dashboardApprovedFuelRequests', array('model' => $model,)
        );
    }
        
    protected function gridLocation($data, $raw)
    {
        $sql = 'select l.Location_Name from vehicle_location vl inner join ma_location l ON l.Location_ID = vl.Current_Location_ID  where vl.Vehicle_No = "'.$data->Vehicle_No.'"';
        $rows = Yii::app()->db->createCommand($sql)->queryAll();	
		 	
		 	
        $result = '';			
        if(!empty($rows))			
        foreach ($rows as $row) 			
        {			
            /*$url = $this->createUrl('create',array('Model_ID'=>$row['Model']));			
            $result .= CHtml::link($row['Model'],$url) .'<br/>'; 	*/		
            $result = $row['Location_Name'];
        }      			
        return $result; 	
    }


}
