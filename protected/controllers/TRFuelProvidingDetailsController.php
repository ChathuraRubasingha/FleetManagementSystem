<?php

class TRFuelProvidingDetailsController extends Controller
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
		/*
	 	 * Added by Sasanka on 15/May/2013
	     * Performs to get the permission according to user.
	     * This can be apply to all controlers.
	     * add whole, public function accessRules().*/
		
		
            $curr_controlername= $this->getUniqueId();
            $curr_action=Yii::app()->controller->action->id;		
            $access=Yii::app()->user->GetPermission($curr_controlername,$curr_action);

            if($access=='true')
            {
                return array(		

                    array('allow', // allow admin user to perform 'admin' and 'delete' actions
                            'actions'=>array($curr_action, 'delete'),
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
                            'actions'=>array('view','delete'),
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
	public function actionCreate($requestId)
	{
		date_default_timezone_set("Asia/Colombo");
            if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
            {
                    unset(Yii::app()->session['btnClick']);
            }
            Yii::app()->session['requestId'] = $requestId;
            //echo $requestId; exit;

            $model=new TRFuelProvidingDetails;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['TRFuelProvidingDetails']))
            {
                $model->attributes=$_POST['TRFuelProvidingDetails'];
                $fuelId = 0;
                $fuelIdData = Yii::app()->db->createCommand('select Fuel_Type_ID from ma_fuel_type where Fuel_Type ="'.$model->Fuel_Type_ID.'"')->queryAll();
                if(!empty($fuelIdData))
                {
                        $fuelId = $fuelIdData[0]['Fuel_Type_ID'];
                }

                $model->Fuel_Type_ID = $fuelId;
                $model->Payable_Amount = str_replace(',','', $model->Payable_Amount);

                $fuelRequestId = $model->Fuel_Request_ID;
                $fuelPumpedDate = $model->Fuel_Pumped_Date;
                $appDate = date("Y-m-d : H:i:s", time());

                $fuelTankCapacity_array = Yii::app()->db->createCommand("select Fuel_Tank_Capacity from ma_vehicle_registry where Vehicle_No ='".$model->Vehicle_No."'")->queryAll();
                $fuelTankCapacity = 0;
                if(count($fuelTankCapacity_array)>0)
                {
                    $fuelTankCapacity = $fuelTankCapacity_array[0]['Fuel_Tank_Capacity'];
                }
                //echo $fuelTankCapacity;exit;
                $preRequestData = Yii::app()->db->createCommand('select Approved_Date from fuel_request_details where Fuel_Request_ID ='.$fuelRequestId)->queryAll();

                $approvedDate ='';
                if(count($preRequestData)>0)
                {
                    $approvedDate = $preRequestData[0]['Approved_Date'];
                }

                $valid = $model->validate();

                if(($model->Fuel_Amount)> $fuelTankCapacity)
                {
                    Yii::app()->user->setFlash('success',"'Fuel Capacity' should not be greater than the Fuel Tank Capacity of the vehicle");
                    Yii::app()->session['btnClick'] = "1";
                }
                elseif($fuelPumpedDate < $approvedDate)
                {
                    Yii::app()->user->setFlash('success',"'Fuel Pumped Date' should be greater than 'Approved Date'");
                    Yii::app()->session['btnClick'] = "1";
                }
                else if($appDate < $fuelPumpedDate)
                {
                    Yii::app()->user->setFlash('success', "'Fuel Pumped Date' should be a previous date");
                    Yii::app()->session['btnClick'] = "1";
                }
                else
                {
                    if($valid)
                    {
                        if($model->save())
                        {
                            $data = "UPDATE fuel_request_details SET Approve_Status = 'Completed' WHERE Fuel_Request_ID = ".$requestId;
                            $rawData = Yii::app()->db->createCommand($data)->execute();

                            $vid = Yii::app()->session['VehicleIdFuel'];

                            $Previous_Max = Yii::app()->db->createCommand('SELECT Fuel_Request_ID, Previous_Distance_Driven FROM fuel_request_details WHERE Vehicle_No= "'.$vid.'" ORDER BY Fuel_Request_ID DESC LIMIT 1 , 1')->queryAll();

                            if (count($Previous_Max)>0)
                            {
                                $Previous_Max_ID = $Previous_Max[0]['Fuel_Request_ID'];
                                $Distance_Driven = $Previous_Max[0]['Previous_Distance_Driven'];
                                $data = "UPDATE fuel_providing_details SET Distance_Driven ='".$Distance_Driven."' WHERE Fuel_Request_ID = ".$Previous_Max_ID;
                                $rawData = Yii::app()->db->createCommand($data)->execute();
                            }				

                            Yii::app()->user->setFlash('success', "Successfully Added..!");		
                            $this->redirect(array('view','id'=>$model->Fuel_Providing_ID));

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

		if(isset($_POST['TRFuelProvidingDetails']))
		{
			$model->attributes=$_POST['TRFuelProvidingDetails'];
			$model->Payable_Amount = str_replace(',','', $model->Payable_Amount);
			
			$fuelId = 0;
			$fuelIdData = Yii::app()->db->createCommand('select Fuel_Type_ID from ma_fuel_type where Fuel_Type ="'.$model->Fuel_Type_ID.'"')->queryAll();
			if(!empty($fuelIdData))
			{
				$fuelId = $fuelIdData[0]['Fuel_Type_ID'];
			}
			$model->Fuel_Type_ID = $fuelId;
			
			$fuelRequestId = $model->Fuel_Request_ID;
			$fuelPumpedDate = $model->Fuel_Pumped_Date;
			$appDate = date("Y-m-d : H:i:s", time());
			
			$fuelTankCapacity_array = Yii::app()->db->createCommand("select Fuel_Tank_Capacity from ma_vehicle_registry where Vehicle_No ='".$model->Vehicle_No."'")->queryAll();
			$fuelTankCapacity = 0;
			if(count($fuelTankCapacity_array)>0)
			{
				$fuelTankCapacity = $fuelTankCapacity_array[0]['Fuel_Tank_Capacity'];
			}
			
			$preRequestData = Yii::app()->db->createCommand('select Approved_Date from fuel_request_details where Fuel_Request_ID ='.$fuelRequestId)->queryAll();
			
			$approvedDate ='';
			if(count($preRequestData)>0)
			{
				$approvedDate = $preRequestData[0]['Approved_Date'];
			}
			
			$valid = $model->validate();
			//echo $approvedDate;exit;
			if(($model->Fuel_Amount)> $fuelTankCapacity)
			{
				Yii::app()->user->setFlash('success',"'Fuel Capacity' should not be greater than the Fuel Tank Capacity of the vehicle");
				Yii::app()->session['btnClick'] = "1";
			}
			elseif($fuelPumpedDate < $approvedDate)
			{
				Yii::app()->user->setFlash('success',"'Fuel Pumped Date' should be greater than 'Approved Date'");
				Yii::app()->session['btnClick'] = "1";
			}
			else if($appDate < $fuelPumpedDate)
			{
				Yii::app()->user->setFlash('success', "'Fuel Pumped Date' should be a previous date");
				Yii::app()->session['btnClick'] = "1";
			}
			else
			{
				if($valid)
				{
					if($model->save())
					{
						Yii::app()->user->setFlash('success', "Successfully Updated...!");
						$this->redirect(array('view','id'=>$model->Fuel_Providing_ID));
					}
				}
				else
				{
					Yii::app()->session['btnClick'] = "1";
				}
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
		$dataProvider=new CActiveDataProvider('TRFuelProvidingDetails');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		$model=new TRFuelProvidingDetails('search');
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRFuelProvidingDetails']))
			$model->attributes=$_GET['TRFuelProvidingDetails'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionFuelProvidingHistory($id, $aid)
	{
		Yii::app()->session['VehicleIdFuel'] = $id;
		Yii::app()->session['VehicleIdAllocationID'] = $aid;
		
		$model=new TRFuelProvidingDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRFuelProvidingDetails']))
			$model->attributes=$_GET['TRFuelProvidingDetails'];

		$this->render('fuelProvidingHistory',array(
			'model'=>$model,
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=TRFuelProvidingDetails::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='trfuel-providing-details-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
