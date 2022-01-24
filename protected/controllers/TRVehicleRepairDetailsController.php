<?php

class TRVehicleRepairDetailsController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
	public function actionCreate()
	{
		date_default_timezone_set("Asia/Colombo");
		if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
		{
			unset(Yii::app()->session['btnClick']);
		}
		
		$model = new TRVehicleRepairDetails;
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TRVehicleRepairDetails']))
		{
			$estimateId = Yii::app()->request->getQuery('estimateId');
			$rdata = Yii::app()->db->createCommand('select Estimate_Date, Approved_Date from repair_estimate_details where Estimate_ID ='.$estimateId)->queryAll();
			
			$estimateDate = '';
			$approvedDate ='';
			$count = count($rdata);
			if ($count != 0)
			{
				$estimateDate = $rdata[$count-1]['Estimate_Date'];
				$approvedDate = $rdata[$count-1]['Approved_Date'];
			}
			$model->attributes=$_POST['TRVehicleRepairDetails'];
			
			$grIdData = Yii::app()->db->createCommand('select Garage_ID from ma_garages where Garage_Name ="'.$model->Garage_ID.'"')->queryAll();
			$grId = 0;
			
			if(!empty($grIdData))
			{
				$grId = $grIdData[0]['Garage_ID'];
			}
			$model->Garage_ID = $grId;
			$repairedDate = $model-> Repaired_Date;
			$appDate = date("Y-m-d : H:i:s", time());
			$model->Repair_Cost = str_replace(',', '', $model->Repair_Cost);
			
			$valid = $model->validate();	
			if($valid)
			{
				/* @ if($repairedDate > $appDate)
				{
					Yii::app()->user->setFlash('success', "'Repaired Date' should be a previous date..!");
					Yii::app()->session['btnClick'] = "1";
				}
				elseif($repairedDate < $approvedDate)
				{
					Yii::app()->user->setFlash('success',"'Repaired Date' should be greater than 'Approved Date'");
					Yii::app()->session['btnClick'] = "1";
				}
				else */
				{
					if($model->save())
					{
						$RequestID = Yii::app()->db->createCommand("select Request_ID from repair_estimate_details where Estimate_ID = " . $model->Estimate_ID)->queryScalar();
						$s = "delete from repair_replacement_details where Request_ID = $RequestID";
						$Arr = Yii::app()->db->createCommand($s )->execute();
						$x = 0;
						foreach ($_POST['prices'] as $value) {
						  if ($value>0)
						  {
							$ItemID = $_POST['ItemID'][$x];
							$NextMillage = (isset($_POST['Next_Service_Milage'][$x]) && $_POST['Next_Service_Milage'][$x] > 0) ? $_POST['Next_Service_Milage'][$x] : '';
							$ModelDetail = new TRRepairDetails;
							$ModelDetail->Request_ID = $RequestID;
							$ModelDetail->Replacement_ID = $ItemID;
							$ModelDetail->Next_Millage =  str_replace(",","", $NextMillage);
							$ModelDetail->Price = str_replace(",","", $value);
							if (!$ModelDetail->save())
							{
								print_r ($ModelDetail->getErrors());
								exit;
							}
							$x += 1;
						  }
						  
						}
						Yii::app()->user->setFlash('success', "Successfully Added..!");
						$data = "UPDATE repair_estimate_details SET Estimate_Status = 'Completed' WHERE Estimate_ID = ".$estimateId." ";
						$rawData = Yii::app()->db->createCommand($data)->execute();
						$this->redirect(array('view','id'=>$model->Repair_ID));
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

		if(isset($_POST['TRVehicleRepairDetails']))
		{
			$estimateId = Yii::app()->request->getQuery('estimateId');
			if($estimateId == '')
			{
				$estimateId = $model->Estimate_ID;
			}
			$rdata = Yii::app()->db->createCommand('select Estimate_Date,Approved_Date from repair_estimate_details where Estimate_ID ='.$estimateId)->queryAll();
			$count = count($rdata);
			$estimateDate ='';
			$approvedDate = '';
			if ($count != 0)
			{
				$estimateDate = $rdata[$count-1]['Estimate_Date'];
				$approvedDate = $rdata[$count-1]['Approved_Date'];
			}
			$model->attributes=$_POST['TRVehicleRepairDetails'];
			
			$grIdData = Yii::app()->db->createCommand('select Garage_ID from ma_garages where Garage_Name ="'.$model->Garage_ID.'"')->queryAll();
			$grId = 0;
			
			if(!empty($grIdData))
			{
				$grId = $grIdData[0]['Garage_ID'];
			}
			$model->Garage_ID = $grId;
			
			$repairedDate = $model-> Repaired_Date;
			$appDate = date("Y-m-d : H:i:s", time());
			$model->Repair_Cost = str_replace(',', '', $model->Repair_Cost);
			
			$valid = $model->validate();	
			if($valid)
			{
				/*@ if($repairedDate > $appDate)
				{
					Yii::app()->user->setFlash('success', "'Repaired Date' should be a previous date..!");
					Yii::app()->session['btnClick'] = "1";
				}
				elseif($repairedDate < $approvedDate)
				{
					Yii::app()->user->setFlash('success',"'Repaired Date' should be greater than 'Approved Date'");
					Yii::app()->session['btnClick'] = "1";
				}
				else @*/
				{
					if($model->save())
					{
						$RequestID = Yii::app()->db->createCommand("select Request_ID from repair_estimate_details where Estimate_ID = " . $model->Estimate_ID)->queryScalar();
						$s = "delete from repair_replacement_details where Request_ID = $RequestID";
						$Arr = Yii::app()->db->createCommand($s )->execute();
						$x = 0;
						foreach ($_POST['prices'] as $value) {
						  if ($value>0)
						  {
							$ItemID = $_POST['ItemID'][$x];
							$NextMillage = (isset($_POST['Next_Service_Milage'][$x]) && $_POST['Next_Service_Milage'][$x] > 0) ? $_POST['Next_Service_Milage'][$x] : '';
							$ModelDetail = new TRRepairDetails;
							$ModelDetail->Request_ID = $RequestID;
							$ModelDetail->Replacement_ID = $ItemID;
							$ModelDetail->Next_Millage = $NextMillage;
							$ModelDetail->Price = str_replace(",","", $value);
							if (!$ModelDetail->save())
							{
								print_r ($ModelDetail->getErrors());
								exit;
							}
							$x += 1;
						  }
						  
						}
						Yii::app()->user->setFlash('success', "Successfully Added..!");
						$data = "UPDATE repair_estimate_details SET Estimate_Status = 'Completed' WHERE Estimate_ID = ".$estimateId." ";
						$rawData = Yii::app()->db->createCommand($data)->execute();
						$this->redirect(array('view','id'=>$model->Repair_ID));
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
		$dataProvider=new CActiveDataProvider('TRVehicleRepairDetails');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TRVehicleRepairDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRVehicleRepairDetails']))
			$model->attributes=$_GET['TRVehicleRepairDetails'];

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
		$model=TRVehicleRepairDetails::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='trvehicle-repair-details-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
