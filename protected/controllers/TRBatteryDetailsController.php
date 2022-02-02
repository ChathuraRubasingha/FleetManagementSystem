<?php

class TRBatteryDetailsController extends Controller
{
	/*
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','view2','battery','approveBattery','approve','disapprove','replace','ReplaceBattery','replaced','ReplaceBatteryDetails','rejectRequest','canceled','reject','PendingBatteryRequests','ApprovedBatteryRequests','DisapprovedBatteryRequests','RejectedBatteryRequests','ReplacedBatteryRequests','completedBatteryRequests'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','update2'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} */
	
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
			'actions'=>array('approve','disapprove','canceled','reject','DashboardPendingBatteryRequests','DashboardApprovedBatteryRequests','view','delete','batteryRequestReport'),
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
		$model = $this->loadModel($id);
		
		$this->render('view',array(
			'model'=>$model,'request'=>$this->loadRequest($id),
		));
	}
	
		public function actionView2($id)
	{
		$model = $this->loadModel($id);
		
		$this->render('view2',array(
			'model'=>$model,'request'=>$this->loadRequest($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		date_default_timezone_set("Asia/Colombo");
		if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
		{
			unset(Yii::app()->session['btnClick']);
		}
		
		$model = new TRBatteryDetails;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TRBatteryDetails']))
		{
			$model->attributes=$_POST['TRBatteryDetails'];
			$model->Cost = str_replace(',', '', $model->Cost);
			$appDate = date("Y-m-d");
			$isExists_array = Yii::app()->db->createCommand('SELECT * FROM `battery_details` where Vehicle_No="'.$model->Vehicle_No.'" and
			Request_Date="'.$model->Request_Date.'"')->queryAll();
			
			$isPending_array = Yii::app()->db->createCommand('SELECT * FROM battery_details where Vehicle_No="'.$model->Vehicle_No.'" and 
			(Approved_Status="Pending" or Replace_Status="Pending")')->queryAll();
			
			$btArr = Yii::app()->db->createCommand('select Battery_Type_ID from ma_battery_type where Battery_Type ="'.$model->Battery_Type_ID.'"')->queryAll();
			
			if(!empty($btArr))
			{
				$model->Battery_Type_ID= $btArr[0]['Battery_Type_ID'];
			}
			else
			{
				$model->Battery_Type_ID= 0;
			}
			
			$valid = $model->validate();
			if($valid)
			{
				$pendingMsg ="Previous Battery Request is existed..!";
				$msgDate="'Request Date' should be a previous date..!";
				$msg="Successfully Added..!";
				$userRole = Yii::app()->getModule('user')->user()->Role_ID;
				if($userRole ==='3')
				{
					$pendingMsg ="පෙර අයදුම් කරන ලද බැටරි අයදුමක් පවතී..!";
					$msgDate ="'අයදුම් කරන දිනය', අද දිනය හෝ ඊට පෙර දිනයක් විය යුතුය..!";
					$msg ="සාර්ථක ලෙස ගබඩා කරන ලදී..!  ";
					
				}
				if(count($isExists_array)>0)
				{
					
					
					Yii::app()->user->setFlash('success', $pendingMsg);					
					Yii::app()->session['btnClick'] = "1";
				}
				elseif(count($isPending_array)>0)
				{
					
					Yii::app()->user->setFlash('success', $pendingMsg);
					Yii::app()->session['btnClick'] = "1";
				}
				elseif(($model->Request_Date)> $appDate)
				{
					Yii::app()->user->setFlash('success',$msgDate);
					Yii::app()->session['btnClick'] = "1";
				}
				else
				{
					if($model->save())
					{
						Yii::app()->user->setFlash('success', $msg);
						#$this->redirect(array('admin','id'=>$model->Battery_Details_ID));
						$id = $model->Battery_Details_ID;
						$this->redirect(array('view','id'=>$model->Battery_Details_ID));
					}
				}
			}
			else
			{
				Yii::app()->session['btnClick'] = "1";
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
		date_default_timezone_set("Asia/Colombo");
            if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
            {
                unset(Yii::app()->session['btnClick']);
            }

            $model=$this->loadModel($id);
            $type = Yii::app()->request->getQuery('type');

            if(isset($_POST['TRBatteryDetails']) && $type == 'replace')
            {
                $model->attributes=$_POST['TRBatteryDetails'];
                $appDate = date("Y-m-d");
                $replaceDate = $model-> Replace_Date;
                $requestDate = $model->Request_Date;
                $apprvDate = $model->Approved_Date;
                $model->Cost = str_replace(',', '', $model->Cost);

                $isExists_array = Yii::app()->db->createCommand('SELECT * FROM `battery_details` where Vehicle_No="'.$model->Vehicle_No.'" and
                Request_Date="'.$model->Request_Date.'"')->queryAll();

                $isPending_array = Yii::app()->db->createCommand('SELECT * FROM battery_details where Vehicle_No="'.$model->Vehicle_No.'" and 
                (Approved_Status="Pending" or Replace_Status="Pending")')->queryAll();


                $valid = $model->validate();
                if($valid)
                {
                    $pendingMsg ="Previous Battery Request is existed..!";
                    $msgDate="'Request Date' should be a previous date..!";
                    $msg="Successfully Added..!";
                    $userRole = Yii::app()->getModule('user')->user()->Role_ID;
                    if($userRole ==='3')
                    {
                        $pendingMsg ="පෙර අයදුම් කරන ලද බැටරි අයදුමක් පවතී..!";
                        $msgDate ="'අයදුම් කරන දිනය', අද දිනය හෝ ඊට පෙර දිනයක් විය යුතුය..!";
                        $msg ="සාර්ථක ලෙස ගබඩා කරන ලදී..!  ";
                    }
			
                    if($requestDate > $appDate)
                    {
                        Yii::app()->user->setFlash('success', $msgDate);
                        Yii::app()->session['btnClick'] = "1";
                    }
                    else
                    {
					
                        $btArr = Yii::app()->db->createCommand('select Battery_Type_ID from ma_battery_type where Battery_Type ="'.$model->Battery_Type_ID.'"')->queryAll();
                        $model->Battery_Type_ID= 0;
                        if(!empty($btArr))
                        {
                            $model->Battery_Type_ID= $btArr[0]['Battery_Type_ID'];
                        }

                        if($model->save())
                        {
                            /////////////////////////////////////
                            $vid = Yii::app()->session['maintenVehicleId'];
                            $Previous_Replace_Date_Array = Yii::app()->db->createCommand("SELECT Replace_Date,Life_Time FROM battery_details WHERE (Vehicle_No= '".$vid."' AND Replace_Status='Replaced') ORDER BY Battery_Details_ID DESC LIMIT 1 , 1")->queryAll();
                                    //$Previous_Max_ID = $Previous_Max[0]['Fuel_Request_ID'];
                            $Previous_Replace_Date='';
                            $fullDays=0;
                            if (count($Previous_Replace_Date_Array)> 0)
                            {
                                $Previous_Replace_Date = $Previous_Replace_Date_Array[0]['Replace_Date'];
				$lifeTime = $Previous_Replace_Date_Array[0]['Life_Time'];
                                $lifeTime = floatval($lifeTime) * 30;
                                $date1 = strtotime(date("Y-m-d", time()));
                                $date2 = strtotime($Previous_Replace_Date);

                                $dateDiff = $date1 - $date2;
                                $fullDays = floor($dateDiff/(60*60*24));

                                $Allocated_Rate=0;

                                if($fullDays > $lifeTime)
                                {
                                    $Allocated_Rate=1;
                                }
                                else
                                {
                                    $Allocated_Rate='-1';
                                }
                                $data = "INSERT INTO driver_rating(Driver_ID, Battery_Details_ID, Rate_By_Battery, Date_Rated)
                                                VALUES(".$model->Driver_ID.",".$id.",".$Allocated_Rate.",'".date("Y-m-d", time())."')";
                                $rawData = Yii::app()->db->createCommand($data)->execute();
							//}
                            }
                            Yii::app()->user->setFlash('success', $msgDate);
                            $this->redirect(array('view','id'=>$model->Battery_Details_ID));
                        }
                    }
                }
                else
                {
                    Yii::app()->session['btnClick'] = "1";
                }
			//}
            }
            else if(isset($_POST['TRBatteryDetails']))
            {
                $model->attributes=$_POST['TRBatteryDetails'];
                $appDate = date("Y-m-d");
                $replaceDate = $model-> Replace_Date;
                $requestDate = $model->Request_Date;
                $apprvDate = $model->Approved_Date;
                $model->Cost = str_replace(',', '', $model->Cost);

                $pendingMsg ="Previous Battery Request is existed..!";
                $msgDate="'Request Date' should be a previous date..!";
                $msg="Successfully Updated..!";
                $userRole = Yii::app()->getModule('user')->user()->Role_ID;
               
                if($userRole ==='3')
                {
                    $pendingMsg ="පෙර අයදුම් කරන ලද බැටරි අයදුමක් පවතී..!";
                    $msgDate ="'අයදුම් කරන දිනය', අද දිනය හෝ ඊට පෙර දිනයක් විය යුතුය..!";
                    $msg ="සාර්ථක ලෙස යාවත්කාලින කරන ලදී..!  ";
                }
				
                $isExists_array = Yii::app()->db->createCommand('SELECT * FROM `battery_details` where Vehicle_No="'.$model->Vehicle_No.'" and
                Request_Date="'.$model->Request_Date.'"  and Battery_Details_ID <>'.$model->Battery_Details_ID)->queryAll();

                $isPending_array = Yii::app()->db->createCommand('SELECT * FROM battery_details where Vehicle_No="'.$model->Vehicle_No.'" and 
                (Approved_Status="Pending" or Replace_Status="Pending")  and Battery_Details_ID <>'.$model->Battery_Details_ID)->queryAll();
			
                if($requestDate > $appDate)
                {
                    Yii::app()->user->setFlash('success', $msgDate);
                    Yii::app()->session['btnClick'] = "1";
                }
                elseif(count($isExists_array)>0)
                {
                    Yii::app()->user->setFlash('success',$pendingMsg);
                    Yii::app()->session['btnClick'] = "1";
                }			
                else
                {
                    $btArr = Yii::app()->db->createCommand('select Battery_Type_ID from ma_battery_type where Battery_Type ="'.$model->Battery_Type_ID.'"')->queryAll();
                    $model->Battery_Type_ID= 0;
                    if(!empty($btArr))
                    {
                        $model->Battery_Type_ID= $btArr[0]['Battery_Type_ID'];
                    }

                    if($model->save())
                    {
                        /////////////////////////////////////
                        $vid = Yii::app()->session['maintenVehicleId'];
                        $Previous_Replace_Date_Array = Yii::app()->db->createCommand("SELECT Replace_Date FROM battery_details WHERE (Vehicle_No= '".$vid."' AND Replace_Status='Replaced') ORDER BY Battery_Details_ID DESC LIMIT 1 , 1")->queryAll();
                                //$Previous_Max_ID = $Previous_Max[0]['Fuel_Request_ID'];
                        $Previous_Replace_Date='';
                        $fullDays=0;
                        if (count($Previous_Replace_Date_Array)> 0)
                        {
                            $Previous_Replace_Date = $Previous_Replace_Date_Array[0]['Replace_Date'];

                            $date1 = strtotime(date("Y-m-d", time()));
                            $date2 = strtotime($Previous_Replace_Date);

                            $dateDiff = $date1 - $date2;
                            $fullDays = floor($dateDiff/(60*60*24));

                            $Allocated_Rate=0;

                            if($fullDays > 365)
                            {
                                $Allocated_Rate=1;
                            }
                            else
                            {
                                $Allocated_Rate='-1';
                            }
                            $data = "INSERT INTO driver_rating(Driver_ID, Battery_Details_ID, Rate_By_Battery, Date_Rated)
                                            VALUES(".$model->Driver_ID.",".$id.",".$Allocated_Rate.",'".date("Y-m-d", time())."')";
                            $rawData = Yii::app()->db->createCommand($data)->execute();
						//}
                        }
                        Yii::app()->user->setFlash('success', $msg);
                        $this->redirect(array('view','id'=>$model->Battery_Details_ID));
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
	
	
	public function actionUpdate2($id)
	{
		date_default_timezone_set("Asia/Colombo");
		if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
		{
			unset(Yii::app()->session['btnClick']);
		}
		$model=$this->loadModel($id);
		$type = Yii::app()->request->getQuery('type');
		
		$pendingMsg ="Previous Battery Request is existed..!";
		$msgDate="'Request Date' should be a previous date..!";
		$replaceDateMsg="'Replaced Date' should be a previous date..!";
		$msg="Successfully Updated..!";
		$fillDate ="Please fill the 'Replaced Date'";
		$fillCost="Please fill the 'Cost'";
		
		$userRole = Yii::app()->getModule('user')->user()->Role_ID;
		if($userRole ==='3')
		{
			$pendingMsg ="පෙර අයදුම් කරන ලද බැටරි අයදුමක් පවතී..!";
			$msgDate ="'අයදුම් කරන දිනය', අද දිනය හෝ ඊට පෙර දිනයක් විය යුතුය..!";
			$replaceDateMsg="'ප්‍රතිස්ථාපිත  දිනය', අද දිනය හෝ ඊට පෙර දිනයක් විය යුතුය..!";
			$msg ="සාර්ථක ලෙස යාවත්කාලින කරන ලදී..!  ";
			$fillDate="කරුණාකර 'ප්‍රතිස්ථාපිත දිනය' ඇතුලත් කරන්න";
			$fillCost ="කරුණාකර වටිනාකම ඇතුලත් කරන්න ";
			
		}
		
		if(isset($_POST['TRBatteryDetails']) && $type == 'replace')
		{
			$model->attributes=$_POST['TRBatteryDetails'];
			$appDate = date("Y-m-d : H:i:s", time());
			$replaceDate = $model-> Replace_Date;
			$model->Cost = str_replace(',', '', $model->Cost);
			$cost = $model->Cost;
			$apprvDate = $model->Approved_Date;
			
			$valid = $model->validate();
			if($valid)
			{
				if(($replaceDate =='' ) || ($cost ==''))
				{
					if($replaceDate == '')
					{
						Yii::app()->user->setFlash('success',$fillDate);
						Yii::app()->session['btnClick'] = "1";
					}
					if($cost =='')
					{
						Yii::app()->user->setFlash('success',$fillCost);
						Yii::app()->session['btnClick'] = "1";
					}
				}
				elseif($replaceDate > $appDate)
				{
					Yii::app()->user->setFlash('success', "'Replaced Date' should be a previous date..!");
					Yii::app()->session['btnClick'] = "1";
				}
				elseif($replaceDate < $apprvDate)
				{
					Yii::app()->user->setFlash('success', "'Replaced Date' should not be greater than 'Approved Date'");
					Yii::app()->session['btnClick'] = "1";
				}
				else
				{
					if($model->save())
					{
						/////////////////////////////////////
						$vid = Yii::app()->session['maintenVehicleId'];
						/*$Previous_Replace_Date_Array = Yii::app()->db->createCommand("SELECT Replace_Date FROM battery_details WHERE (Vehicle_No= '".$vid."' AND Replace_Status='Replaced') ORDER BY Battery_Details_ID DESC LIMIT 1 , 1")->queryAll();*/
						
						$Previous_Replace_Date_Array = Yii::app()->db->createCommand("SELECT Replace_Date FROM battery_details WHERE (Vehicle_No= '".$vid."' AND Replace_Status='Replaced')")->queryAll();
						
						$count = count($Previous_Replace_Date_Array);
						
						//if($count >1)
							//$Previous_Max_ID = $Previous_Max[0]['Fuel_Request_ID'];
						$Previous_Replace_Date='';
						$fullDays=0;
						//if (count($Previous_Replace_Date_Array)> 0)
						if($count >1)
						{
							$Previous_Replace_Date = $Previous_Replace_Date_Array[$count-2]['Replace_Date'];
							
							$date1 = strtotime(date("Y-m-d", time()));
							$date2 = strtotime($Previous_Replace_Date);
							
							$dateDiff = $date1 - $date2;
							$fullDays = floor($dateDiff/(60*60*24));
							
							$Allocated_Rate=0;
							
							if($fullDays > 365)
							{
								
								$Allocated_Rate=1;
							}
							else
							{
								$Allocated_Rate='-1';
							}
	
							$data = "INSERT INTO driver_rating(Driver_ID, Battery_Details_ID, Rate_By_Battery, Date_Rated)
									VALUES(".$model->Driver_ID.",".$id.",".$Allocated_Rate.",'".date("Y-m-d", time())."')";
							$rawData = Yii::app()->db->createCommand($data)->execute();
							//}
						}
						Yii::app()->user->setFlash('success', $msg);
						$this->redirect(array('view2','id'=>$model->Battery_Details_ID));
					}
				}
			}
			else
			{
				Yii::app()->session['btnClick'] = "1";
			}
			
		}
		else if(isset($_POST['TRBatteryDetails']))
		{
			$model->attributes=$_POST['TRBatteryDetails'];
			$model->Cost = str_replace(',', '', $model->Cost);
			$cost = $model->Cost;
			$appDate = date("Y-m-d : H:i:s", time());
			$replaceDate = $model-> Replace_Date;
			$apprvDate = $model->Approved_Date;
			//echo $replaceDate;exit;
			$valid = $model->validate();
			
			if($valid)
			{
				if((empty($replaceDate)) || (empty($cost)))
				{
					if(empty($replaceDate))
					{
						Yii::app()->user->setFlash('success',"Please fill the 'Replaced Date'");
						Yii::app()->session['btnClick'] = "1";
					}
					if(empty($cost))
					{
						Yii::app()->user->setFlash('success',"Please fill the 'Cost'");
						Yii::app()->session['btnClick'] = "1";
					}
				}
				elseif($replaceDate > $appDate)
				{
					Yii::app()->user->setFlash('success', "'Replaced Date' should be a previous date..!");
					Yii::app()->session['btnClick'] = "1";
				}
				elseif($replaceDate < $apprvDate)
				{
					Yii::app()->user->setFlash('success', "'Replaced Date' should not be greater than 'Approved Date'");
					Yii::app()->session['btnClick'] = "1";
				}
				else
				{
					if($model->save())
					{
						Yii::app()->user->setFlash('success', "Successfully Updated..!");
						$this->redirect(array('view2','id'=>$model->Battery_Details_ID));
					}
				}
			}
			else
			{
				Yii::app()->session['btnClick'] = "1";
			}
		}
		
			

		$this->render('update2',array(
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
		$dataProvider=new CActiveDataProvider('TRBatteryDetails');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TRBatteryDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRBatteryDetails']))
			$model->attributes=$_GET['TRBatteryDetails'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	
	
	public function actionBattery()
	{
		$model = new TRBatteryDetails();

		$this->render('battery',array('model'=>$model));
	}
	
	public function actionReplace()
	{
		
		$model = new TRBatteryDetails();
		
		$this->render('replace',array('model'=>$model));
	}
	
	public function actionReplaceBatteryy()
	{
		
		$model = new TRBatteryDetails();
		
		$this->render('replaceBattery',array('model'=>$model));
	}
	
	public function actionReplaceBattery($batterydetailsid)
		{
			//echo $batterydetailsid;exit;
			Yii::app()->session['batteryDetailsId'] = $batterydetailsid;
			
			$model = $this->loadModel($batterydetailsid);
			
			if(isset($_POST['TRBatteryDetails']))
				{
					$model->attributes=$_POST['TRBatteryDetails'];
					$Replace_Date=$model->Replace_Date;
					
					#echo $Replace_Date;exit;
					$query = "UPDATE battery_details SET Replace_Date = '".$Replace_Date."' WHERE Battery_Details_ID = '".$batterydetailsid."'";
				
					$rawData = Yii::app()->db->createCommand($query)->execute();
					
				}	
				 $this->render('replaceBattery',array(
					'model'=>$model,'request'=>$this->loadRequest($batterydetailsid),
					
				));
			
		}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=TRBatteryDetails::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='trbattery-details-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionbatteryRequestReport($id)
	{
		if($type="pdf")
		{
			$cri = new CDbCriteria();
			$cri->condition="Battery_Details_ID = " . $id;
			$arr = TRBatteryDetails::model()->find($cri);			

			$htmlHead = "VEHICLE BATTERY REQUEST";
			$html = "<table style='padding-left: 20px; padding-top: 10px'>
			<tr><td>Request No </td><td>:</td><td>$arr->Battery_Details_ID</td></tr>
			<tr><td>Requested Date </td><td>:</td><td>$arr->Request_Date</td></tr>
			<tr><td>Driver Contact</td><td>:</td><td>{$arr->driver->Full_Name} {$arr->driver->Mobile}</td></tr>
			<tr><td>Current Meter Reading </td><td>:</td><td>$arr->Meter_Reading</td></tr>
			<tr><td>Replaced Date </td><td>:</td><td>$arr->Replace_Date</td></tr>
			<tr><td>Remarks </td><td>:</td><td>$arr->Remarks</td></tr>";
			
			$q = "SELECT
				ma_location.Location_Name
				FROM
				vehicle_transfer
				INNER JOIN ma_location ON vehicle_transfer.To_Location_ID = ma_location.Location_ID
				where vehicle_transfer.Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date DESC
				limit 1";	

			$q_date = "SELECT
				vehicle_transfer.From_Date
				FROM
				vehicle_transfer
				INNER JOIN ma_location ON vehicle_transfer.To_Location_ID = ma_location.Location_ID
				where vehicle_transfer.Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date DESC
				limit 1";
				
			$LastLocation = Yii::app()->db->createCommand($q)->queryScalar();			
			
			if ($LastLocation == "") 
			{
			$q = "SELECT
				ma_location.Location_Name
				FROM
				vehicle_transfer
				INNER JOIN ma_location ON vehicle_transfer.From_Location_ID = ma_location.Location_ID
				where vehicle_transfer.Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date DESC
				limit 1";
				
			$q_date = "SELECT
				vehicle_transfer.From_Date
				FROM
				vehicle_transfer
				INNER JOIN ma_location ON vehicle_transfer.To_Location_ID = ma_location.Location_ID
				where vehicle_transfer.Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date DESC
				limit 1";											
			}
			
			$LastLocation = Yii::app()->db->createCommand($q)->queryScalar(). " " .  Yii::app()->db->createCommand($q_date)->queryScalar();	
			
			if ($LastLocation == " ")
			{
				$q = "SELECT
				CONCAT(ma_location.Location_Name, ' ' , IFNULL(From_Date, ''))
				FROM
				vehicle_location
				INNER JOIN ma_location ON vehicle_location.Current_Location_ID = ma_location.Location_ID
				where Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date desc";
				
				$LastLocation = Yii::app()->db->createCommand($q)->queryScalar();
			}
			
			$html .= "<tr><td>Current Location </td><td>:</td><td>$LastLocation</td></tr></table>";

			
			$html .= "
			<br/>
			<table class='tbl'>"
                        . "<thead><tr>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Vehicle No</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Battery Type</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Quantity</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Last Battery Replaced Meter Reading</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px; text-align: center'>Last Battery Replaced Quantity</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px; text-align: center'>Last Battery - Life Time (Months)</th>"						
                        . "<th style='border-bottom:2px solid black;padding:5px; text-align: center'>Last Battery Replaced Date</th>"
						. "</thead>
			
			";
			
			$cmd1 = "SELECT
					ma_battery_type.Battery_Type,
					battery_details.Quantity
					FROM
					battery_details
					INNER JOIN ma_battery_type ON ma_battery_type.Battery_Type_ID = battery_details.Battery_Type_ID WHERE battery_details.Battery_Details_ID = '" . $id . "' LIMIT 1";
			
			$rows =  Yii::app()->db->createCommand($cmd1)->queryAll();

			foreach ($rows as $value) 
			{   
				$html .= "<tr><td style = 'text-align: center' >" . $arr->Vehicle_No . "</td><td style = 'text-align: center'>" . $value['Battery_Type'] .  "</td><td style = 'text-align: center'>" . $value['Quantity'] .  "</td>";				
			}
			
			$cmd2 = "SELECT
					GROUP_CONCAT(IFNULL(battery_details.Quantity, '_') SEPARATOR '<br/>') as Quantity,
					GROUP_CONCAT(IFNULL(battery_details.Meter_Reading, '_') SEPARATOR '<br/>') as Meter_Reading,
					GROUP_CONCAT(IFNULL(battery_details.Life_Time, '_') SEPARATOR '<br/>') as Life_Time,
					GROUP_CONCAT(IFNULL(battery_details.Replace_Date, '_') SEPARATOR '<br/>') as Replace_Date
					FROM
					battery_details
					WHERE battery_details.Battery_Details_ID > " . $arr->Battery_Details_ID . " and battery_details.Vehicle_No = '" . $arr->Vehicle_No . "' ORDER BY battery_details.Replace_Date ASC LIMIT 0,4 ";

			$rows2 =  Yii::app()->db->createCommand($cmd2)->queryAll();

			foreach ($rows2 as $value2) 
			{   
				$html .= "<td>" . $value2['Meter_Reading'] .  "</td><td style = 'text-align: center'>" . $value2['Quantity'] .  "<td style = 'text-align: center'>" . $value2['Life_Time'] .  "</td></td><td style = 'text-align: center'>" . $value2['Replace_Date'] .  "</td></tr>";
			}	
			if (count($rows2)==0) $html .= "<td></td><td style = 'text-align: center'><td style = 'text-align: center'></td></td><td style = 'text-align: center'></td></tr>";

			
			$html .= "</table><br/>";
			
			$html .= "&nbsp;&nbsp;" . $arr->Remarks;

			$PreparedBy = $arr->add_by;
			$PreparedDate = $arr->add_date;			
			$RoleID = Yii::app()->db->createCommand("Select Role_ID from tbl_users where username = '$PreparedBy'" )->queryScalar();	
			$RoleName = ($RoleID != null ? Yii::app()->db->createCommand("Select Role from ma_role where Role_ID = $RoleID" )->queryScalar() : '');

			$AprBy = $arr->Approved_By;
			$AppDate = $arr->Approved_Date;
			$RoleIDApr = Yii::app()->db->createCommand("Select Role_ID from tbl_users where username = '$PreparedBy'" )->queryScalar();	
			$RoleNameApr = ($RoleID != null ? Yii::app()->db->createCommand("Select Role from ma_role where Role_ID = $RoleID" )->queryScalar() : '');

			$htmlFoot =  "<hr/>
	
					<table width='100%' >
					<tr>
					<td>							
    						<p><b>Prepared By<b></p>
							<p>Signature : ................................................</p>
                            <p>Name : $PreparedBy </p>
                            <p>Designation : $RoleName</p>
							<p>Date/Time : $PreparedDate</p>
					</td>
					<td>
    						<p><b>Approved By<b></p>
							<p>Signature : ...............................................</p>
                            <p>Name : $AprBy</p>
                            <p>Designation : $RoleNameApr</p>
							<p>Date/Time : $AppDate</p>
					</td>
					</tr>

					</table>";
					
			$css = '.tbl{
                        width:100%;
                        padding: 10px;
                        border: 1px solid black;
                        border-collapse: collapse;
                            }

                    .tbl th,.tbl td{
                        padding: 10px;
                        border: 1px solid black;
                        border-collapse: collapse;
                    }
                    ';
					
			$dompdf = new makePdf;
			$dompdf->setSize('A4', 'Potrait');
			$dompdf->renderPartial('/layouts/A4ReportTemplate', array('page_content' => $html, 'page_header' => $htmlHead, 'page_footer' => $htmlFoot, 'report_name' => 'VEHICLE BATTERY REQUEST REPORT', 'tel' => '', 'address' => '', 'fax' => '', 'vat_no' => '', 'doc_no' => ' ', 'issue_no' => ' ', 'issue_date' => ' ',  'css_styles' => $css));
			$dompdf->stream($id . ' - VEHICLE BATTERY REQUEST REPORT.pdf');
		}
	}	
	
	
	public function loadRequest($id)
	{
		$request=TRBatteryDetails::model()->findByPk($id);
		if($request===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $request;
	}
	
	public function actionApproveBattery($batterydetailsid)
	{
		Yii::app()->session['batteryDetailsId'] = $batterydetailsid;
		$vid = Yii::app()->request->getQuery('vid');
		
		if ($vid != "")
		{
			Yii::app()->session['maintenVehicleId'] = $vid;
		}
		
		$model = $this->loadModel($batterydetailsid);
		 $this->render('approveBattery',array(
			'model'=>$model,'request'=>$this->loadRequest($batterydetailsid),
			
		));
	}	
	public function actionRejectRequest($batterydetailsid)
	{
		$vid = Yii::app()->request->getQuery('vid');
		
		if ($vid != "")
		{
			Yii::app()->session['maintenVehicleId'] = $vid;
		}
		
		Yii::app()->session['batteryDetailsId'] = $batterydetailsid;
		
		$model = $this->loadModel($batterydetailsid);
		 $this->render('rejectRequest',array(
			'model'=>$model,'request'=>$this->loadRequest($batterydetailsid),
			
		));
	}
	
	
	public function actionApprove()
	{
            if(isset($_POST['reqID']) && $_POST['reqID'] !=='' )
            {
                $model = new TRBatteryDetails;
		
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
                    $model = new TRBatteryDetails;

                    if($model->disapprove($_POST['reqID'], $_POST['reason']))
                    {
                        echo "OK";
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
                    $model = new TRBatteryDetails;

                    if($model->reject($_POST['ReqID'], $_POST['reason']))
                    {
                        echo "OK";
                    }
                }
            }
	}
	public function actionCanceled()
	{
		
		//$url = Yii::app()->request->baseUrl."/index.php?r=tRBatteryDetails/battery";
		$url = Yii::app()->request->baseUrl."/index.php?r=dashboard/";
		header('location:'.$url);
		
	}
	
	public function actionReplaced()
	{
		$model = new TRBatteryDetails;
		
		if($model->replaced($_GET['batterydetailsid']))
		{
			$url = Yii::app()->request->baseUrl."/index.php?r=tRBatteryDetails/battery";
			header('location:'.$url);
		}
	}
	
	public function actionReplaceBatteryDetails()
	{
		$model = new TRBatteryDetails();

		$this->render('replaceBatteryDetails',array('model'=>$model));
	}
	
	public function actionPendingBatteryRequests()
	{
		$model=new TRBatteryDetails();
		$this->render('pendingBatteryRequests',array(
			'model'=>$model,
		));
	}
	
	public function actionApprovedBatteryRequests()
	{
		$model=new TRBatteryDetails();
		$this->render('approvedBatteryRequests',array(
			'model'=>$model,
		));
	}
	
	public function actionDisapprovedBatteryRequests()
	{
		$model=new TRBatteryDetails();
		$this->render('disapprovedBatteryRequests',array(
			'model'=>$model,
		));
	}
	
	public function actionRejectedBatteryRequests()
	{
		$model=new TRBatteryDetails();
		$this->render('rejectedBatteryRequests',array(
			'model'=>$model,
		));
	}
	
	public function actionCompletedBatteryRequests()
	{
		$model=new TRBatteryDetails();
		$this->render('completedBatteryRequests',array(
			'model'=>$model,
		));
	}
	
	public function actionReplacedBatteryRequests()
	{
		$model=new TRBatteryDetails();
		$this->render('replacedBatteryRequests',array(
			'model'=>$model,
		));
	}
        
        public function actionDashboardPendingBatteryRequests() 
        {
            $model = new TRBatteryDetails('getPendingBatteryRequestsDashBoard');

            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['TRBatteryDetails']))
            {
                $model->attributes = $_GET['TRBatteryDetails'];
            }


            $this->render('dashboardPendingBatteryRequests', array('model' => $model,)
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
        
        public function actionDashboardApprovedBatteryRequests() 
        {
            $model = new TRBatteryDetails('getPendingBatteryReplacementsDashBoard');

            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['TRBatteryDetails']))
            {
                $model->attributes = $_GET['TRBatteryDetails'];
            }


            $this->render('dashboardApprovedBatteryRequests', array('model' => $model,)
            );
        }
}
