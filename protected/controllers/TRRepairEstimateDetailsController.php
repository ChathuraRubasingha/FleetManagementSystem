<?php

class TRRepairEstimateDetailsController extends Controller
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
			'actions'=>array('view','delete','approve','disApprove','Canceled','Reject','DashboardPendingRepair','DashboardApprovedRequests', 'RepairRequestReport'),
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
		date_default_timezone_set("Asia/Colombo");
		if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
		{
			unset(Yii::app()->session['btnClick']);
		}
		$repairRequestId = Yii::app()->request->getQuery('repairRequestId');
		
		$model=new TRRepairEstimateDetails;
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TRRepairEstimateDetails']))
		{
                    $model->attributes=$_POST['TRRepairEstimateDetails'];
                    $model->Total_Estimate = str_replace(',', '', $model->Total_Estimate);
                    $estimateDate = $model-> Estimate_Date;
                    $appDate = date("Y-m-d");

                    $requestData = Yii::app()->db->createCommand('select Request_Date from repair_request where Request_ID ='.$model->Request_ID)->queryAll();
                    $count = count($requestData);

                    $requestDate ='';
                    if($count>0)
                    {
                        $requestDate = $requestData[0]['Request_Date'];
                    }
                    $valid = $model->validate();	


                    if($valid)
                    {
                        if($requestDate > $model->Estimate_Date)
                        {
                            Yii::app()->user->setFlash('success', "'Estimate Date' should be less than 'Request Date'");
                            Yii::app()->session['btnClick'] = "1";
                        }
                        elseif($estimateDate > $appDate)
                        {
                            Yii::app()->user->setFlash('success', "'Estimate Date' should be a previous date..!");
                            Yii::app()->session['btnClick'] = "1";
                        }
                        else
                        {
                            if($model->save())
                            {
                                $estimageId = $model->Estimate_ID;
                                Yii::app()->user->setFlash('success', "Successfully Added..!");
                                TRRepairRequest::model()->updateByPk($model->Request_ID, array('Request_Status'=>'Estimated'));

                                #$this->redirect(array('create','repairRequestId'=>$repairRequestId));tRRepairEstimateDetails/estimate
                                $this->redirect(array('view','id'=>$model->Estimate_ID));
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

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['TRRepairEstimateDetails']))
            {
                $model->attributes=$_POST['TRRepairEstimateDetails'];
                $model->Total_Estimate = str_replace(',', '', $model->Total_Estimate);
                $status = $model->Estimate_Status;
                $estimateDate = $model-> Estimate_Date;
                $appDate = date("Y-m-d");

                $requestData = Yii::app()->db->createCommand('select Request_Date from repair_request where Request_ID ='.$model->Request_ID)->queryAll();
                $count = count($requestData);

                $requestDate ='';
                if($count>0)
                {
                    $requestDate = $requestData[0]['Request_Date'];
                }
			
			//$requestDate = $model->Request_Date;
			/*$requestData = Yii::app()->db->createCommand('select Request_Date from repair_request where Request_ID ='.$model->Request_ID)->queryAll();
			$count = count($requestData);
			
			$requestDate ='';
			if($count>0)
			{
				$requestDate = $requestData[0]['Request_Date'];
			}*/
			
			$valid = $model->validate();	
			
			if($valid)
			{
				if ($status == 'Completed')
				{
					Yii::app()->user->setFlash('success',"This request is already Completed. You cannot update this record");
					$this->redirect(array('view','id'=>$model->Estimate_ID));
				}
				elseif($status == 'Approved')
				{
					Yii::app()->user->setFlash('success',"This request is already Approved. You cannot update this record");
					$this->redirect(array('view','id'=>$model->Estimate_ID));
	
				}
				elseif($status == 'Disapproved')
				{
					Yii::app()->user->setFlash('success',"This request is already Disapproved. You cannot update this record");
					$this->redirect(array('view','id'=>$model->Estimate_ID));
	
				}
				elseif($status == 'Rejected')
				{
					Yii::app()->user->setFlash('success',"This request is already Rejected. You cannot update this record");
					$this->redirect(array('view','id'=>$model->Estimate_ID));
	
				}
				elseif($status == 'Pending')
				{
					if($requestDate > $model->Estimate_Date)
					{
						Yii::app()->user->setFlash('success', "'Estimate Date' should be less than 'Request Date'");
						Yii::app()->session['btnClick'] = "1";
					}
					elseif($estimateDate > $appDate)
					{
						Yii::app()->user->setFlash('success', "'Estimate Date' should be a previous date..!");
						Yii::app()->session['btnClick'] = "1";
					}
					else
					{
						if($model->save())
						{
							Yii::app()->user->setFlash('success',"Successfully Updated");
							$this->redirect(array('view','id'=>$model->Estimate_ID));
						}
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
		$dataProvider=new CActiveDataProvider('TRRepairEstimateDetails');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TRRepairEstimateDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRRepairEstimateDetails']))
			$model->attributes=$_GET['TRRepairEstimateDetails'];

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
		$model=TRRepairEstimateDetails::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadRequest($id)
	{
		$request=TRRepairEstimateDetails::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='trrepair-estimate-details-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionEstimate()
	{
		$model=new TRRepairEstimateDetails();
		$this->render('estimate',array(
			'model'=>$model,
		));
	}
	
	public function actionApproveEstimate($estimateId)
	{
            $repairRequestId = Yii::app()->request->getQuery('requestId');
            Yii::app()->session['repairRequestId'] = $repairRequestId;

            $model = $this->loadModel($estimateId);
             $this->render('approveEstimate',array(
                    'model'=>$model,'request'=>$this->loadRequest($estimateId),

            ));
	}
	
	public function actionRejectRepairEstimate($estimateId)
	{
            $repairRequestId = Yii::app()->request->getQuery('requestId');
            Yii::app()->session['repairRequestId'] = $repairRequestId;

            $model = $this->loadModel($estimateId);
             $this->render('rejectRepairEstimate',array(
                    'model'=>$model,'request'=>$this->loadRequest($estimateId),

            ));
	}
	
	public function actionApprove()
	{
            if(isset($_POST['estID']) && $_POST['estID'] !== '')
            {
                $estID = $_POST['estID'];
                
                $model = new TRRepairEstimateDetails;
                if($model->approve($estID))
                {
                    echo 'OK';
                }
		
            }
	}
	
	public function actionDisapprove()
	{
            $model = new TRRepairEstimateDetails;
            if(isset($_POST['estID']) && $_POST['estID'] !== '')
            {
                $estID = $_POST['estID'];
                if(isset($_POST['reason']) && $_POST['reason'] !== '')
                {
                    $reason = $_POST['reason'];
                    if($model->disapprove($estID, $reason))
                    {
			echo 'OK';
                    }
                }
            }
	}
	
	public function actionReject()
	{
            if(isset($_POST['EstimateID']) && $_POST['EstimateID'] !== '' )
            {
                if(isset($_POST['reason']) && $_POST['reason'] !== '' )
                {
                    $estID = $_POST['EstimateID'];
                    $reason = $_POST['reason'];
                    $model = new TRRepairEstimateDetails;

                    if($model->reject($estID, $reason))
                    {
                        echo 'OK';
                    }
                    //echo $model->reject($estID);
                }
            }
	}
	
	public function actionCanceled($estimateId)
	{
		$url = Yii::app()->request->baseUrl."/index.php?r=dashboard/";
		header('location:'.$url);
		
	}
	
	public function actionApprovedEstimates()
	{
		//echo "xZXZxZ";exit;
		$model=new TRRepairEstimateDetails();
		$this->render('approvedEstimates',array(
			'model'=>$model,
		));
	}
	
	public function actionPendingRepairDetails()
	{
		//echo "xZXZxZ";exit;
		$model=new TRRepairEstimateDetails();
		$this->render('pendingRepairDetails',array(
			'model'=>$model,
		));
	}
	
	public function actionApprovedRepairDetails()
	{
		//echo "xZXZxZ";exit;
		$model=new TRRepairEstimateDetails();
		$this->render('approvedRepairDetails',array(
			'model'=>$model,
		));
	}
	
	public function actionDisapprovedRepairDetails()
	{
		//echo "xZXZxZ";exit;
		$model=new TRRepairEstimateDetails();
		$this->render('disapprovedRepairDetails',array(
			'model'=>$model,
		));
	}
	
	public function actionRejectedRepairDetails()
	{
		//echo "xZXZxZ";exit;
		$model=new TRRepairEstimateDetails();
		$this->render('rejectedRepairDetails',array(
			'model'=>$model,
		));
	}
	public function actionCompletedRepairDetails()
	{
            $model=new TRRepairEstimateDetails();
            $this->render('completedRepairDetails',array(
                    'model'=>$model,
            ));
	}	
	
	public function actionDashboardPendingRepair() 
        {
            $model = new TRRepairEstimateDetails('insurance');

            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['TRRepairEstimateDetails']))
            {
                $model->attributes = $_GET['TRRepairEstimateDetails'];
            }

            $this->render('dashboardPendingRepair', array('model' => $model,)
            );
        }
        
        public function actionDashboardApprovedRequests() 
        {
            $model = new TRRepairEstimateDetails('getApprovedEstimatesDashBoard');

            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['TRRepairEstimateDetails']))
            {
                $model->attributes = $_GET['TRRepairEstimateDetails'];
            }

            $this->render('dashboardApprovedRequests', array('model' => $model,)
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
                $result = $row['Location_Name'];
            }      			
            return $result; 	
	}
	public function actionRepairRequestReport($id)
	{
		if($type="pdf")
		{
			$cri = new CDbCriteria();
			$cri->condition="Estimate_ID = " . $id;
			$arr = TRRepairEstimateDetails::model()->find($cri);			
			$ReqID = $arr->Request_ID;
			$NowMeterReading = Yii::app()->db->createCommand("select Meter_Reading from repair_request where Request_ID = $ReqID")->queryScalar();  
			
			$htmlHead = "VEHICLE REPAIR REQUEST ESTIMATE REPORT";
			$html = "<table style='padding-left: 20px; padding-top: 10px'>
			<tr><td>Request Id </td><td>:</td><td>$ReqID</td></tr>
			<tr><td>Estimate Id </td><td>:</td><td>$arr->Estimate_ID</td></tr>
			<tr><td>Current Meter Reading </td><td>:</td><td>" . number_format($NowMeterReading,0) . "</td></tr>
			<tr><td>Garage Name </td><td>:</td><td>{$arr->garage->Garage_Name}</td></tr>
			<tr><td>Garage Contact </td><td>:</td><td>{$arr->garage->Owner_Name} {$arr->garage->Contact_No} {$arr->garage->Land_Phone_No} {$arr->garage->Mobile_No}</td></tr>";

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
			$html .= "<tr><td>Current Location </td><td>:</td><td>$LastLocation</td></tr>";
			
			$cri1 = new CDbCriteria();
			$cri1->condition = "Estimate_ID = " . $arr->Estimate_ID;
			$arr1 = TRVehicleRepairDetails::model()->find($cri1);
			
			$RepCost = "";
			$RepDesc = "";
			$RepDate = "";
			
			if (isset($arr1->Repair_Cost) && $arr1->Repair_Cost != '' && $arr1->Repair_Cost != null) $RepCost = number_format($arr1->Repair_Cost, 2);
			if (isset($arr1->Description_Of_Repair) && $arr1->Description_Of_Repair != '' && $arr1->Description_Of_Repair != null) $RepDesc = $arr1->Description_Of_Repair;
			if (isset($arr1->Repaired_Date) && $arr1->Repaired_Date != '' && $arr1->Repaired_Date != null) $RepDate = $arr1->Repaired_Date;
			
			if ($RepDesc != "") $RepDesc = str_replace(array("\n\r", "\n", "\r"), "<br/>", $RepDesc);
			
			$html .= "<tr><td>Estimated Date</td><td>:</td><td>{$arr->Estimate_Date}</td></tr>
			<tr><td>Repaired Date</td><td>:</td><td>$RepDate</td></tr>
			</table>

			<br/>
			<table class='tbl'>"
                        . "<thead><tr>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Vehicle No</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Description of Estimate / Failure</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Estimated Cost</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Description of Repair</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Actual Repair Cost (Rs.)</th>"
						. "</thead>
						<tr><td style='padding:5px; text-align:center'>{$arr->Vehicle_No}</td><td style='padding:5px; text-align:left'>" . str_replace(array("\n\r", "\n", "\r"), "<br/>", $arr->request->Description_Of_Failure) . "</td><td style='padding:5px; text-align:right'>" .  number_format($arr->Total_Estimate,2) . "</td><td style='padding:5px; text-align:left'>$RepDesc</td><td style='padding:5px; text-align:right'>$RepCost</td></tr>
			</table>
			";
			
			// start from here..
			
			 $Qrep = "SELECT
				repair_replacement_details.Replacement_ID,IFNULL(repair_request.Meter_Reading,0) as 'NowMeterReading', ma_replacement_of_service.Service_Replacement, IFNULL(repair_replacement_details.Next_Millage, 0) as Next_Millage, repair_request.Vehicle_No 
				FROM
				repair_replacement_details
				INNER JOIN ma_replacement_of_service on repair_replacement_details.Replacement_ID = ma_replacement_of_service.Replacement_of_Service_ID
				INNER JOIN repair_request ON repair_request.Request_ID = repair_replacement_details.Request_ID where repair_request.Request_ID = $ReqID";

			
			$QrepAll = Yii::app()->db->createCommand($Qrep)->queryAll();
			$TblBodySpareParts = "";	

			foreach($QrepAll as $val)
			{
				$RepId = $val['Replacement_ID'];
				$Vehicle_No = $val['Vehicle_No'];
				
				$lastMRed = '0.0';
				$lastPlannedMillage = '0.0';
				
				if(isset($RepId) && $RepId != '' && isset($Vehicle_No) && $Vehicle_No != '')
				{
					$s = "SELECT IFNULL(repair_request.Meter_Reading,0) as 'LastMeterReading', IFNULL(repair_replacement_details.Next_Millage, 0) as Last_Planned_Millage FROM repair_replacement_details INNER JOIN ma_replacement_of_service on repair_replacement_details.Replacement_ID = ma_replacement_of_service.Replacement_of_Service_ID INNER JOIN repair_request ON repair_request.Request_ID = repair_replacement_details.Request_ID where repair_request.Vehicle_No = '$Vehicle_No' and repair_replacement_details.Replacement_ID = $RepId and repair_request.Request_ID < $ReqID ORDER BY repair_request.Request_ID DESC limit 1";
					$s1 = Yii::app()->db->createCommand($s)->queryRow();
					$lastMRed  = $s1['LastMeterReading'];				
					$PlannedKMForReplace = $s1['Last_Planned_Millage'];
					
				}
				
				$CurrentMRed = $val['NowMeterReading'];
				$NextMillage = $val['Next_Millage'];
				
				$NextMRed = '0.0';
				$Deff = '0.0';
				if($CurrentMRed >  0 && $NextMillage > 0)
				{
					$NextMRed = (float)$CurrentMRed  + (float)$NextMillage;
					$Deff = (float)$PlannedKMForReplace - (float)$NextMillage;
					
				}
				$TblBodySpareParts .= "<tr style='text-align:center'><td>" . $RepId . "</td><td>" . $val['Service_Replacement'] . "</td><td>" . number_format($lastMRed,0) . "</td><td>" . number_format($CurrentMRed,0) . "</td><td>" . number_format($NextMRed,0) . "</td><td>" . number_format($PlannedKMForReplace, 0) . "</td><td>" . number_format($NextMillage, 0) . "</td><td>" . number_format($Deff, 0) . "</td></tr>";
			}
			
			if ($TblBodySpareParts != '')
			{
			$html .= "<table class='tbl'>"  
						. "<thead><tr>" 
                        . "<th style='border-bottom:2px solid black;padding:5px;text-align:center'>Item No</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px;text-align:center'>Replaced Part Name</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px;text-align:center'>Last Meter Reading</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px;text-align:center'>Current Meter Reading</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px;text-align:center'>Next Meter Reading</th>"
						. "<th style='border-bottom:2px solid black;padding:5px;text-align:center'>Recommended Millage (a)</th>"		
                        . "<th style='border-bottom:2px solid black;padding:5px;text-align:center'>Actual Millage (Km) (b)</th>"						
						. "<th style='border-bottom:2px solid black;padding:5px;text-align:center'>Difference/ Excess (Km)(a-b)</th></tr>"		
						. "$TblBodySpareParts</thead>			
			</table>
			";
			}
			
			$PreparedBy = $arr->add_by;
			$PreparedDate = $arr->add_date;
			
			$RoleID = Yii::app()->db->createCommand("Select Role_ID from tbl_users where username = '$PreparedBy'" )->queryScalar();	
			$RoleName = ($RoleID != null ? Yii::app()->db->createCommand("Select Role from ma_role where Role_ID = $RoleID" )->queryScalar() : '');
			
			$ApprStatus =  $arr->Estimate_Status;
			
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
							<p>Signature : " . ($ApprStatus == 'Disapproved'? 'Disapproved' : '...............................................') . "</p>
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
