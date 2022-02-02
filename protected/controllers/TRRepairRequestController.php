<?php

class TRRepairRequestController extends Controller
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
				'actions'=>array('index','view','repair'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'adminRepair'),
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
			'actions'=>array('view','delete','FuelGuaging'),
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
		
		$model=new TRRepairRequest;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TRRepairRequest']))
		{
			$model->attributes=$_POST['TRRepairRequest'];
			
			//echo $model->Request_Date;exit;
			/*$isExists_array = Yii::app()->db->createCommand('SELECT * FROM `repair_request` where Vehicle_No="'.$model->Vehicle_No.'" and
			Request_Date="'.$model->Request_Date.'"')->queryAll();*/
			
			$isPending_array = Yii::app()->db->createCommand('SELECT * FROM `repair_request` rr Left join repair_estimate_details re on 
			re.Request_ID = rr.Request_ID where rr.Vehicle_No="'.$model->Vehicle_No.'" and (rr.Request_Status="Pending" or 
			re.Estimate_Status="Pending")')->queryAll();

			$valid = $model->validate();
			$appDate = date("Y-m-d");
			//echo $appDate;exit;
			if($valid)
			{
				/*if(count($isExists_array)>0)
				{
					$dateMsg ="Previous request is existed...!";
					$userRole = Yii::app()->getModule('user')->user()->Role_ID;
					if($userRole ==='3')
					{
						$dateMsg ="පෙර අයදුම් කරන ලද අලුත්වැඩියා අයදුමක් පවතී..!";
					}
					
					Yii::app()->user->setFlash('success', $dateMsg);
					Yii::app()->session['btnClick'] = "1";
				}
				elseif(count($isPending_array)>0)
				{
					$dateMsg ="Previous request is existed...!";
					$userRole = Yii::app()->getModule('user')->user()->Role_ID;
					if($userRole ==='3')
					{
						$dateMsg ="පෙර අයදුම් කරන ලද අලුත්වැඩියා අයදුමක් පවතී..!";
					}
					
					Yii::app()->user->setFlash('success', $dateMsg);
					Yii::app()->session['btnClick'] = "1";
				}
				else*/if(($model->Request_Date)> $appDate)
				{
					$userRole = Yii::app()->getModule('user')->user()->Role_ID;
						$msgDate="'Request Date' should be a previous date";
						if($userRole =='3')
						{
							$msgDate ="'අයදුම් කරන දිනය', අද දිනය හෝ ඊට පෙර දිනයක් විය යුතුය";
						}
						Yii::app()->user->setFlash('success',$msgDate);
					Yii::app()->session['btnClick'] = "1";
				}
				else
				{
					if($model->save())
					{
						$userRole = Yii::app()->getModule('user')->user()->Role_ID;
						$msg="Successfully Added..!";
						if($userRole =='3')
						{
							$msg ="සාර්ථක ලෙස ගබඩා කරන ලදී..!  ";
						}
						Yii::app()->user->setFlash('success',$msg);
						#$this->redirect(array('admin','id'=>$model->Request_ID));
						$id= $model->Request_ID;
						$this->redirect(array('view','id'=>$model->Request_ID));
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
		$appDate = date("Y-m-d");
			//echo $appDate;exit;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TRRepairRequest']))
		{
			$model->attributes=$_POST['TRRepairRequest'];
			
			$valid = $model->validate();	
			if($valid)
			{
				if(($model->Request_Date)> $appDate)
				{
					$userRole = Yii::app()->getModule('user')->user()->Role_ID;
						$msgDate="'Request Date' should be a previous date";
						if($userRole =='3')
						{
							$msgDate ="'අයදුම් කරන දිනය', අද දිනය හෝ ඊට පෙර දිනයක් විය යුතුය";
						}
						Yii::app()->user->setFlash('success',$msgDate);
					Yii::app()->session['btnClick'] = "1";
				}
				else
				{
					if($model->save())
					{
						$userRole = Yii::app()->getModule('user')->user()->Role_ID;
						$msg="Successfully Updated...!";
						if($userRole =='3')
						{
							$msg ="සාර්ථක ලෙස යාවත්කාලින කරන ලදී ";
						}
						Yii::app()->user->setFlash('success',$msg);
						$this->redirect(array('view','id'=>$model->Request_ID));
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
		$dataProvider=new CActiveDataProvider('TRRepairRequest');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TRRepairRequest('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRRepairRequest']))
			$model->attributes=$_GET['TRRepairRequest'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionAdminRepair()
	{
		$model=new TRRepairRequest('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRRepairRequest']))
			$model->attributes=$_GET['TRRepairRequest'];

		$this->render('adminRepair',array(
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
		$model=TRRepairRequest::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='trrepair-request-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionRepair()
	{
		$model = new TRRepairRequest();
		$modelRepair = new TRVehicleRepairDetails();
        $this->render('repair',array('model'=>$model,'modelRepair'=>$modelRepair));
	}
	
	protected function gridDriver($data, $row)
	{
		$result = '';

		if ($data->Driver_ID != null)
		{
		$rowData = Yii::app()->db->createCommand('select full_Name from ma_driver where driver_id='.$data->Driver_ID)->queryAll();		
			foreach ($rowData as $raw)
			{
				$result = $raw['full_Name'];
			}
		}
		else $result = $data->InspectedBy;
		return $result;
	}
	
	protected function gridGarage($data, $row)
	{
		$rowData = Yii::app()->db->createCommand('select g.Garage_Name from repair_estimate_details re inner join ma_garages g on g.Garage_ID = re.Garage_ID where Request_ID='.$data->Request_ID)->queryAll();
		$result = '';
		
		foreach ($rowData as $raw)
		{
			$result = $raw['Garage_Name'];
		}
		return $result;
	}
	
	protected function gridApprove($data, $row)
	{
		$result = '';
		$rowData = Yii::app()->db->createCommand('select Approved_By from repair_estimate_details where Request_ID ='.$data->Request_ID)->queryAll();
		
		foreach($rowData as $raw)
		{
			$result = $raw['Approved_By'];
		}
		return $result;
	}
	
	protected function gridAppDate($data, $row)
	{
		$result = '';
		$rowData = Yii::app()->db->createCommand('select Approved_Date from repair_estimate_details where Request_ID ='.$data->Request_ID)->queryAll();
		
		foreach($rowData as $raw)
		{
			$result = $raw['Approved_Date'];
		}
		return $result;
	}
	
	protected function gridEstStatus($data, $row)
	{
		$result = '';
		$rowData = Yii::app()->db->createCommand('select Estimate_Status from repair_estimate_details where Request_ID ='.$data->Request_ID)->queryAll();
		
		foreach($rowData as $raw)
		{
			$result = $raw['Estimate_Status'];
		}
		return $result;
	}
        
        public function actionFuelGuaging() 
        {
            
        }
	
}
