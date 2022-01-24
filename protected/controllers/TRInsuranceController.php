<?php

class TRInsuranceController extends Controller
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
                    'actions'=>array('DashboardInsuranceDetails'),
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

            $model=new TRInsurance;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['TRInsurance']))
            {
                $model->attributes=$_POST['TRInsurance'];

                $newInsuranceDate = $model-> Date_of_Insurance;
                $newInsuranceValidFrom = $model->Valid_From;
                $newInsuranceValidTo = $model->Valid_To;
                $appDate = date("Y-m-d");
                $model->Amount = str_replace(',', '', $model->Amount);
                $model->Sum_Insured = str_replace(',', '', $model->Sum_Insured);			
			
                $valid = $model->validate();	
                
                if($valid)
                {
                    /* if(($newInsuranceDate > $appDate))
                    {
                        Yii::app()->user->setFlash('success', "'Date of Insurance' should be a previous date..!");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    else if($newInsuranceDate > $newInsuranceValidFrom)
                    {
                        Yii::app()->user->setFlash('success', "'Valid From' Date should be greater than 'Date of Insurance'..!");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    else if($newInsuranceValidFrom >= $newInsuranceValidTo)
                    {
                        Yii::app()->user->setFlash('success', "'Valid To' Date should not be a previous date..!");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    else 
                    {*/
                        $vehicleId = Yii::app()->session['maintenVehicleId'];

                        $query = "SELECT Valid_From, Valid_To FROM insurance WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1";

                        $rawData = Yii::app()->db->createCommand($query)->queryAll();

                        $count = count($rawData);

                        if($count == 0)
                        {
                            $model=new TRInsurance;
                            $model->attributes=$_POST['TRInsurance'];
                            $model->Amount = str_replace(',', '', $model->Amount);
                            $model->Sum_Insured = str_replace(',', '', $model->Sum_Insured);
                            
                            if($model->save())
                            {
                                Yii::app()->user->setFlash('success', "Successfully Added..!");
                                $this->redirect(array('view','id'=>$model->Insurance_ID));
                            }
                        }
                        else
                        {
                            $lastInsuranceValidFrom = $rawData[0]['Valid_From'];
                            $lastInsuranceValidTo = $rawData[0]['Valid_To'];

                            if($lastInsuranceValidTo >= $newInsuranceValidFrom)
                            {
                                Yii::app()->user->setFlash('success', "Previous Insurance is existed..!");
                                Yii::app()->session['btnClick'] = "1";
                            }
                            else
                            {
                                if($model->save())
                                {
                                        Yii::app()->user->setFlash('success', "Successfully Added..!");
                                        $this->redirect(array('view','id'=>$model->Insurance_ID));
                                }
                            }
                        }
                    //}
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

		if(isset($_POST['TRInsurance']))
		{
			$model->attributes=$_POST['TRInsurance'];
			$newInsuranceDate = $model-> Date_of_Insurance;
			$newInsuranceValidFrom = $model-> Valid_From;
			$newInsuranceValidTo = $model-> Valid_To;
			$appDate = date("Y-m-d");
			$model->Amount = str_replace(',', '', $model->Amount);
			$model->Sum_Insured = str_replace(',', '', $model->Sum_Insured);
			
			$valid = $model->validate();	
			if($valid)
			{
				/* if($newInsuranceDate > $appDate)
				{
					Yii::app()->user->setFlash('success', "'Date of Insurance' should be a previous date..!");
					Yii::app()->session['btnClick'] = "1";
				}
				else if($newInsuranceDate > $newInsuranceValidFrom)
				{
					Yii::app()->user->setFlash('success', "'Valid From' Date should be greater than 'Date of Insurance'..!");
					Yii::app()->session['btnClick'] = "1";
				}
				else if($newInsuranceValidFrom >= $newInsuranceValidTo  )
				{
					Yii::app()->user->setFlash('success', "'Valid To' Date should not be a previous date..!");
					Yii::app()->session['btnClick'] = "1";
				}
				else 
				{	*/				
					if($model->save())
					{
						Yii::app()->user->setFlash('success', "Successfully Updated..!");
						$this->redirect(array('view','id'=>$model->Insurance_ID));
					}
				// }
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
		$dataProvider=new CActiveDataProvider('TRInsurance');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TRInsurance('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRInsurance']))
			$model->attributes=$_GET['TRInsurance'];

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
		$model=TRInsurance::model()->findByPk($id);
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
            if(isset($_POST['ajax']) && $_POST['ajax']==='trinsurance-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        public function actionDashboardInsuranceDetails() 
        {
            $model = new TRInsurance('insurance');

            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['TRInsurance']))
            {
                $model->attributes = $_GET['TRInsurance'];
            }


            $this->render('dashboardInsuranceDetails', array('model' => $model,)
            );
        }
        
        protected function gridLocation($data, $row)
	{
		$arr = Yii::app()->db->createCommand('select l.Location_Name from vehicle_location vl inner join ma_location l ON l.Location_ID = vl.Current_Location_ID where vl.Vehicle_No ="'.$data->Vehicle_No.'"')->queryAll();
		
		$result ='';
		if(!empty($arr))
		foreach ($arr as $row)
		{
			$result = $row['Location_Name'];
		}
		return $result;
	}
	
	
}
