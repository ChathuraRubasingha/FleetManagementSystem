<?php

class TRTyreDetailsController extends Controller
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'view2','tyre','approveTyre','approve','disApprove','replace','Canceled','reject','rejectRequest','PendingTyreRequests','ApprovedTyreRequests','DisapprovedTyreRequests','RejectedTyreRequests','completedTyreRequests'),
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
	}*/
	
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
			'actions'=>array('approve','disApprove','Canceled','reject','DashboardPendingTyreRequests','DashboardApprovedTyreRequests','TyreRequestReport'),
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
		/*$this->render('view',array(
			'model'=>$this->loadModel($id),
		));*/
		
		$model = $this->loadModel($id);
		
		$this->render('view',array(
			'model'=>$model,'request'=>$this->loadRequest($id),
		));
	}
	
	public function actionView2($id)
	{
		/*$this->render('view',array(
			'model'=>$this->loadModel($id),
		));*/
		
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
		
		$model=new TRTyreDetails;
		$pendingMsg="Previous request is existed";
		$reqDateMsg="'Request Date' should be a previous date";
		$msg="Successfully Added..!";
		$userRole = Yii::app()->getModule('user')->user()->Role_ID;
		if($userRole =='3')
		{
			$pendingMsg="පෙර කරන ලද ටයර අයදුමක් පවතී..! ";
			$reqDateMsg="'අයදුම් කරන දිනය' අද දිනය හෝ ඊට පෙර දිනයක් විය යුතුය";
			$msg="සාර්ථක ලෙස ගබඩා කරන ලදී..!";
		}
			
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TRTyreDetails']))
		{
			$model->attributes=$_POST['TRTyreDetails'];
			
			### get Tyre_Type_ID
			$tyreType = $model->Tyre_Type_ID;
			$appDate = date("Y-m-d");
			$requestDate = $model->Request_Date;
			$arrTrId = Yii::app()->db->createCommand('select Tyre_Type_ID  from ma_tyre_type where Tyre_Type ="'.$tyreType.'"')->queryAll();
			if (count($arrTrId)>0)
			{
				$model->Tyre_Type_ID = $arrTrId[0]['Tyre_Type_ID'];
			}
			
			### get Tyre_Size_ID
			
			$tyreSize = $model->Tyre_Size_ID;
			$arrTsID = Yii::app()->db->createCommand('select Tyre_Size_ID from  ma_tyre_size where Tyre_Size ="'.$tyreSize.'"')->queryAll();
			if(count($arrTsID)>0)
			{
				$model->Tyre_Size_ID = $arrTsID[0]['Tyre_Size_ID'];
			}
			
			$model->Cost = str_replace(',','', $model->Cost);
			
			
			$isExists_array = Yii::app()->db->createCommand('SELECT * FROM `tyre_details` where Vehicle_No="'.$model->Vehicle_No.'" and
			Request_Date="'.$model->Request_Date.'" and (Approved_Status <> "Disapproved" and Approved_Status <> "Rejected")')->queryAll();
			
			$isPending_array = Yii::app()->db->createCommand('SELECT * FROM tyre_details where Vehicle_No="'.$model->Vehicle_No.'" and (Approved_Status="Pending" or Replace_Status="Pending")')->queryAll();
			
			$valid = $model->validate();	
			if($valid)
			{
				if(count($isExists_array)>0)
				{
					Yii::app()->user->setFlash('success',$pendingMsg);
					Yii::app()->session['btnClick'] = "1";
				}
				elseif(count($isPending_array)>0)
				{
					Yii::app()->user->setFlash('success', $pendingMsg);
					Yii::app()->session['btnClick'] = "1";
				}
				elseif($requestDate > $appDate)
				{
					Yii::app()->user->setFlash('success', $reqDateMsg);
					Yii::app()->session['btnClick'] = "1";
				}
				else
				{
					if($model->save())
					{
						Yii::app()->user->setFlash('success', $msg);
						$this->redirect(array('view','id'=>$model->Tyre_Details_ID));
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
		
		$reqDateMsg="'Request Date' should be a previous date";
		$msg="Successfully Updated..!";
		$userRole = Yii::app()->getModule('user')->user()->Role_ID;
		if($userRole =='3')
		{
			$reqDateMsg="'අයදුම් කරන දිනය' අද දිනය හෝ ඊට පෙර දිනයක් විය යුතුය";
			$msg="සාර්ථක ලෙස යාවත්කාලින කරන ලදී..!";
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		 if(isset($_POST['TRTyreDetails']))
		{
			$model->attributes=$_POST['TRTyreDetails'];
			### get Tyre_Type_ID
			$tyreType = $model->Tyre_Type_ID;
			$appDate = date("Y-m-d");
			$requestDate = $model->Request_Date;
			
			$arrTrId = Yii::app()->db->createCommand('select Tyre_Type_ID  from ma_tyre_type where Tyre_Type ="'.$tyreType.'"')->queryAll();
			if (count($arrTrId)>0)
			{
				$model->Tyre_Type_ID = $arrTrId[0]['Tyre_Type_ID'];
			}
			
			### get Tyre_Size_ID
			
			$tyreSize = $model->Tyre_Size_ID;
			$arrTsID = Yii::app()->db->createCommand('select Tyre_Size_ID from  ma_tyre_size where Tyre_Size ="'.$tyreSize.'"')->queryAll();
			if(count($arrTsID)>0)
			{
				$model->Tyre_Size_ID = $arrTsID[0]['Tyre_Size_ID'];
			}
			
			
			$model->Cost = str_replace(',','', $model->Cost);
			$valid = $model->validate();	
			if($valid)
			{
				//echo $requestDate. '  '. $appDate;exit;
				if($requestDate > $appDate)
				{
					Yii::app()->user->setFlash('success',$reqDateMsg);
					Yii::app()->session['btnClick'] = "1";
				}
				else
				{
					if($model->save())
					{
						Yii::app()->user->setFlash('success', $msg);
						$this->redirect(array('view','id'=>$model->Tyre_Details_ID));
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


	public function actionUpdate2($id)
	{
		date_default_timezone_set("Asia/Colombo");
		if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
		{
			unset(Yii::app()->session['btnClick']);
		}
		$model=$this->loadModel($id);
		$type = Yii::app()->request->getQuery('type');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TRTyreDetails']))
		{
			$model->attributes=$_POST['TRTyreDetails'];
			$model->Cost = str_replace(',','', $model->Cost);
			$appDate = date("Y-m-d : H:i:s", time());
			$replaceDate = $model-> Replace_Date;
		    $apprvDate = $model->Approved_Date;
			
			$curMeterReading = $model->Meter_Reading;
			$cost = $model->Cost;
			$valid = $model->validate();
				
			if($valid)
			{
				if(($curMeterReading=='')  ||  ($cost=='') ||($replaceDate ==''))
				{
					if($curMeterReading=='')
					{
						Yii::app()->user->setFlash('success',"Please Fill 'Current Meter Reading'");
						Yii::app()->session['btnClick'] = "1";
					}
					else if($cost=='')
					{
						Yii::app()->user->setFlash('success',"Please Fill 'Cost'");
						Yii::app()->session['btnClick'] = "1";
					}
					elseif ($replaceDate =='')
					{
						Yii::app()->user->setFlash('success',"Please Fill 'Replace Date'");
						Yii::app()->session['btnClick'] = "1";
					}
				}
				else
				{
					//@ if($replaceDate > $appDate)
					//@ {
						//@ Yii::app()->user->setFlash('success', "'Replaced Date' should be a previous date..!");
						//@ Yii::app()->session['btnClick'] = "1";
					//@ }
					//@ else if($apprvDate > $replaceDate)
					//@ {
						//@ Yii::app()->user->setFlash('success', $apprvDate . ' & ' . $replaceDate . "'Replaced Date' should be greater than 'Approved Date'");
						//@ Yii::app()->session['btnClick'] = "1";				
					//@ }
					//@ else
					{
						/////////////////////////////////////
						$vid = Yii::app()->session['maintenVehicleId'];
						$Max_ID_Array = Yii::app()->db->createCommand("SELECT Max(Tyre_Details_ID) as ID FROM tyre_details WHERE (Vehicle_No= '".$vid."' AND Replace_Status='Replaced')")->queryAll();
						if (count($Max_ID_Array) >0)
						{
							$Max_ID = $Max_ID_Array[0]['ID'];
							$Previous_Meter_Reading_Array = Yii::app()->db->createCommand("SELECT Meter_Reading, Life_Time FROM tyre_details WHERE (Tyre_Details_ID= '".$Max_ID."')")->queryAll();
							//$Previous_Max_ID = $Previous_Max[0]['Fuel_Request_ID'];
							$Previous_Meter_Reading='';
							$distance;
							if (count($Previous_Meter_Reading_Array)> 0)
							{
								$Previous_Meter_Reading = $Previous_Meter_Reading_Array[0]['Meter_Reading'];
                                                                $lifeTime = $Previous_Meter_Reading_Array[0]['Life_Time'];
                                                                
								$Current_Reading = $model-> Meter_Reading;
								
								$distance_Difference = $Current_Reading - $Previous_Meter_Reading;
								//echo $distance_Difference ." - ".$Current_Reading. " - ".$Previous_Meter_Reading; exit;
								
								$Allocated_Rate=0;
								// life time
								if($distance_Difference > $lifeTime)
								{
									
									$Allocated_Rate=1;
								}
								else
								{
									
									$Allocated_Rate='-1';
								}
							
								$data = "INSERT INTO driver_rating(Driver_ID, Tyre_Details_ID, Rate_By_Tire, Date_Rated)
										VALUES(".$model->Driver_ID.",".$id.",".$Allocated_Rate.",'".date("Y-m-d", time())."')";
								$rawData = Yii::app()->db->createCommand($data)->execute();
							}	
								
							if($model->save())
							{
								Yii::app()->user->setFlash('success', "Successfully Updated..!");
								$this->redirect(array('view2','id'=>$model->Tyre_Details_ID));
							}
							else
							{
								
								print_r($model->getErrors());
								exit;
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
		$dataProvider=new CActiveDataProvider('TRTyreDetails');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TRTyreDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRTyreDetails']))
			$model->attributes=$_GET['TRTyreDetails'];

		$this->render('admin',array(
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
		$model=TRTyreDetails::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='trtyre-details-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function loadRequest($id)
	{
		$request=TRTyreDetails::model()->findByPk($id);
		if($request===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $request;
	}
	
	public function actionTyre()
	{
		$model = new TRTyreDetails();

		$this->render('tyre',array('model'=>$model));
	}
	
	public function actionApproveTyre($tyreDetailsId)
	{
		$vid = Yii::app()->request->getQuery('Vid');
		
		if ($vid != "")
		{
			Yii::app()->session['maintenVehicleId'] = $vid;
		}
		
		//Yii::app()->session['maintenVehicleId']= $Vid; 
		$model = $this->loadModel($tyreDetailsId);
		 $this->render('approveTyre',array(
			'model'=>$model,'request'=>$this->loadRequest($tyreDetailsId),
			
		));
	}
	
	public function actionRejectRequest($tyreDetailsId)
	{
		
		$vid = Yii::app()->request->getQuery('vid');
		
		if ($vid != "")
		{
			Yii::app()->session['maintenVehicleId'] = $vid;
		}
		
		//Yii::app()->session['maintenVehicleId']= $Vid; 
		$model = $this->loadModel($tyreDetailsId);
		 $this->render('rejectRequest',array(
			'model'=>$model,'request'=>$this->loadRequest($tyreDetailsId),
			
		));
	}
	
	
	
	public function actionApprove()
	{
            if(isset($_POST['reqID']) && $_POST['reqID'] !== '')
            {
		$model = new TRTyreDetails;
		
		if($model->approve($_POST['reqID']))
		{
                    echo "OK";
		}
            }
	}
	
	public function actionDisapprove()
	{
            if(isset($_POST['reqID']) && $_POST['reqID'] !== '')
            {
                if(isset($_POST['reason']) && $_POST['reason'] !== '')
                {
                    $model = new TRTyreDetails;

                    if($model->disapprove($_POST['reqID'], $_POST['reason']))
                    {
                        echo "OK";
                    }
                }
            }
	}
	
	public function actionReject()
	{
            if(isset($_POST['ReqID']) && $_POST['ReqID'] !== '')
            {
                if(isset($_POST['reason']) && $_POST['reason'] !== '')
                {
                    $model = new TRTyreDetails;

                    if($model->reject($_POST['ReqID'], $_POST['reason']))
                    {
                        echo "OK";
                    }
                }
            }            
            
	}
	
	public function actionCanceled()
	{
		$url = Yii::app()->request->baseUrl."/index.php?r=dashboard/";
		header('location:'.$url);
		
	}
	
	public function actionReplace()
	{
		
		$model = new TRTyreDetails();
		
		$this->render('replace',array('model'=>$model));
	}
	
	public function actionPendingTyreRequests()
	{
		$model=new TRTyreDetails();
		$this->render('pendingTyreRequests',array(
			'model'=>$model,
		));
	}   
	
	public function actionApprovedTyreRequests()
	{
		$model=new TRTyreDetails();
		$this->render('approvedTyreRequests',array(
			'model'=>$model,
		));
	}
	
	public function actionDisapprovedTyreRequests()
	{
		$model=new TRTyreDetails();
		$this->render('disapprovedTyreRequests',array(
			'model'=>$model,
		));
	}
	
	public function actionRejectedTyreRequests()
	{
		$model=new TRTyreDetails();
		$this->render('rejectedTyreRequests',array(
			'model'=>$model,
		));
	}
	
	public function actionCompletedTyreRequests()
	{
		$model=new TRTyreDetails();
		$this->render('completedTyreRequests',array(
			'model'=>$model,
		));
	}
        
        public function actionDashboardPendingTyreRequests() 
        {
            $model = new TRTyreDetails('getPendingTyreRequestsDashBoard');

            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['TRTyreDetails']))
            {
                $model->attributes = $_GET['TRTyreDetails'];
            }

            $this->render('dashboardPendingTyreRequests', array('model' => $model,)
            );
        }
        
        public function actionDashboardApprovedTyreRequests() 
        {
            $model = new TRTyreDetails('getPendingTyreReplacementsDashBoard');

            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['TRTyreDetails']))
            {
                $model->attributes = $_GET['TRTyreDetails'];
            }

            $this->render('dashboardApprovedTyreRequests', array('model' => $model,)
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
 	public function actionTyreRequestReport($id)
	{
		if($type="pdf")
		{
			//$cri = new CDbCriteria();
			//$cri->condition="Tyre_Details_ID = " . $id;
			$arr = TRTyreDetails::model()->findByPk($id);

			$htmlHead = "VEHICLE TYRE REQUEST";
			$html = "<table style='padding-left: 20px; padding-top: 10px'>
			<tr><td>Request No</td><td>:</td><td>$arr->Tyre_Details_ID</td></tr>
			<tr><td>Requested Date</td><td>:</td><td>{$arr->Request_Date}</td></tr>
			<tr><td>Driver Contact </td><td>:</td><td>{$arr->driver->Full_Name}, {$arr->driver->Mobile}</td></tr>";

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
				CONCAT(ma_location.Location_Name, ' (From : ' , IFNULL(From_Date, ''), ')')
				FROM
				vehicle_location
				INNER JOIN ma_location ON vehicle_location.Current_Location_ID = ma_location.Location_ID
				where Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date desc";
				
				$LastLocation = Yii::app()->db->createCommand($q)->queryScalar();
			}			
			
			
			$Q_last = "SELECT
						tyre_details.Tyre_Type_ID,
						tyre_details.Tyre_Size_ID,
						tyre_details.Tyre_Size_ID_2,
						tyre_details.Replace_Date,
						tyre_details.Meter_Reading,
						tyre_details.Tyre_quantity,
						tyre_details.Tyre_quantityType2,
						tyre_details.Cost
						FROM
						tyre_details
		where tyre_details.Replace_Date is not null and tyre_details.Vehicle_No = '{$arr->Vehicle_No}' and tyre_details.Tyre_Details_ID != $id 
						ORDER BY tyre_details.Replace_Date DESC LIMIT 1";
			$Lastrec = Yii::app()->db->createCommand($Q_last)->queryRow();
			
			$Lastrec = Yii::app()->db->createCommand($Q_last)->queryRow();

			$html .= "<tr><td>Current Location </td><td>:</td><td>$LastLocation</td></tr>";
						
			$RepCost = "";

			
			//if (isset($arr1->Repair_Cost) && $arr1->Repair_Cost != '' && $arr1->Repair_Cost != null) $RepCost = number_format($arr1->Repair_Cost, 2);

			
			$html .= "<tr><td>Toatal Costs</td><td>:</td><td>". number_format($arr->Cost,2) . "</td></tr>
			<tr><td>Current Meter Reading</td><td>:</td><td>" . $arr->Meter_Reading . "</td></tr>
			<tr><td>Replaced Date</td><td>:</td><td>" . $arr->Replace_Date . "</td></tr>
			<tr><td>Remarks</td><td>:</td><td>" . $arr->Status_Reason . "</td></tr>
			</table>

			<br/>
			<table class='tbl'>"
                        . "<thead><tr>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Vehicle No</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Type (front/rear)</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Tyre Size</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Quantity</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Last Tyre Replaced Meter Reading</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Last Tyre Replaced Quantity</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Last Tyre Replaced Cost</th>"						
                        . "<th style='border-bottom:2px solid black;padding:5px'>Last Tyre Replaced Date</th>"						
						. "</thead>
						<tr><td style='padding:5px; text-align:center'>{$arr->Vehicle_No}</td><td style='padding:5px; text-align:left'>Front</td><td style='padding:5px; text-align:left'>{$arr->tyreType->Tyre_Type} {$arr->tyreSize->Tyre_Size}</td><td style='padding:5px; text-align:center'>{$arr->Tyre_quantity}</td><td style='padding:5px; text-align:center'>" . $Lastrec['Meter_Reading'] . "</td><td style='padding:5px; text-align:center'>" . $Lastrec['Tyre_quantity'] . "</td><td style='padding:5px; text-align:center'>" . $Lastrec['Cost'] . "</td><td style='padding:5px; text-align:center'>" . $Lastrec['Replace_Date'] . "</td></tr>" . 
						($arr->Tyre_quantityType2>0 ? "<tr><td style='padding:5px; text-align:center'>{$arr->Vehicle_No}</td><td style='padding:5px; text-align:left'>Rear</td><td style='padding:5px; text-align:left'>{$arr->tyreType->Tyre_Type} {$arr->tyreSize2->Tyre_Size}</td><td style='padding:5px; text-align:center'>{$arr->Tyre_quantityType2}</td><td style='padding:5px; text-align:center'></td><td style='padding:5px; text-align:center'></td><td style='padding:5px; text-align:center'></td><td style='padding:5px; text-align:center'></td></tr>":"") . 
			"</table>
			
			"; 
			$PreparedBy = $arr->add_by;
			$PreparedDate = $arr->add_date;
			$RoleID = Yii::app()->db->createCommand("Select Role_ID from tbl_users where username = '$PreparedBy'" )->queryScalar();	
			$RoleName = ($RoleID != null ? Yii::app()->db->createCommand("Select Role from ma_role where Role_ID = $RoleID" )->queryScalar() : '');				

			$ApprovedStatus =  (isset($arr->Approved_Status)? $arr->Approved_Status: 'Approved');			
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
    						<p><b>$ApprovedStatus By<b></p>
							<p>Signature:  ...............................................</p>
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
			$dompdf->renderPartial('/layouts/A4ReportTemplate', array('page_content' => $html, 'page_header' => $htmlHead, 'page_footer' => $htmlFoot, 'report_name' => 'VEHICLE REPAIR ESTIMATE REPORT', 'tel' => '', 'address' => '', 'fax' => '', 'vat_no' => '', 'doc_no' => ' ', 'issue_no' => ' ', 'issue_date' => ' ',  'css_styles' => $css));
			$dompdf->stream($id . ' - VEHICLE REPAIR ESTIMATE REPORT.pdf');
		}
	}
       
}
