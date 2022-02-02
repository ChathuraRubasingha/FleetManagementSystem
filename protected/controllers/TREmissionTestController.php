<?php

class TREmissionTestController extends Controller
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
			'actions'=>array('DashboardEmissionTest','gridLocation'),
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
		$model=new TREmissionTest;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TREmissionTest']))
		{
			$model->attributes=$_POST['TREmissionTest'];
			
			$newEmissionTestDate = $model-> Emission_Test_Date;
			$newEmissionTestValidFrom = $model-> Valid_From;
			$newEmissionTestValidTo = $model-> Valid_To;
			$appDate = date("Y-m-d : H:i:s", time());
			$model->Amount = str_replace(',', '', $model->Amount);
			/*if($newEmissionTestValidFrom >= $newEmissionTestValidTo || $newEmissionTestDate > $newEmissionTestValidFrom || $newEmissionTestDate > $appDate)*/
			
			$valid = $model->validate();
			if ($valid)
			{
				if($newEmissionTestDate > $appDate)
				{
					Yii::app()->user->setFlash('success', "'Emission Test Date' should be a previous date..!");
					Yii::app()->session['btnClick'] = "1";
				}
				elseif ($newEmissionTestDate > $newEmissionTestValidFrom)
				{
					Yii::app()->user->setFlash('success', "'Valid From' date should be greater than 'Emission Test Date'..!");
					Yii::app()->session['btnClick'] = "1";
				}
				elseif($newEmissionTestValidFrom >= $newEmissionTestValidTo)
				{
					Yii::app()->user->setFlash('success', "'Valid To' date should be greater than 'Valid From' date..!");
					Yii::app()->session['btnClick'] = "1";
				}
				else
				{
					$vehicleId = Yii::app()->session['maintenVehicleId'];
				
					$query = "SELECT Valid_From, Valid_To FROM emission_test WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1";
		
					$rawData = Yii::app()->db->createCommand($query)->queryAll();
				
					$count = count($rawData);
								
					if($count == 0)
					{
						if($model->save()){
						Yii::app()->user->setFlash('success', "Successfully Added..!");
						$this->redirect(array('view','id'=>$model->Emission_test_ID));
						}
					}
					else
					{
						$lastEmissionTestValidFrom = $rawData[0]['Valid_From'];
						$lastEmissionTestValidTo = $rawData[0]['Valid_To'];
						
						if($lastEmissionTestValidTo >= $newEmissionTestValidTo)
						{
							Yii::app()->user->setFlash('success', "Pervious Emision Test is existed..!");
							Yii::app()->session['btnClick'] = "1";
						}
						else
						{
							if($model->save()){
							Yii::app()->user->setFlash('success', "Successfully Added..!");
							$this->redirect(array('view','id'=>$model->Emission_test_ID));
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
		if(isset($_POST['TREmissionTest']))
		{
			$model->attributes=$_POST['TREmissionTest'];
			
			$newEmissionTestDate = $model-> Emission_Test_Date;
			$newEmissionTestValidFrom = $model-> Valid_From;
			$newEmissionTestValidTo = $model-> Valid_To;
			$appDate = date("Y-m-d : H:i:s", time());
			$model->Amount = str_replace(',', '', $model->Amount);
			/*if($newEmissionTestValidFrom >= $newEmissionTestValidTo || $newEmissionTestDate > $newEmissionTestValidFrom || $newEmissionTestDate > $appDate)*/
			$valid = $model->validate();
			if($valid)
			{
				if($newEmissionTestDate > $appDate)
				{
					Yii::app()->user->setFlash('success', "'Emission Test Date' should be a previous date..!");
					Yii::app()->session['btnClick'] = "1";
				}
				elseif ($newEmissionTestDate > $newEmissionTestValidFrom)
				{
					Yii::app()->user->setFlash('success', "'Valid From' date should be greater than 'Emission Test Date'..!");
					Yii::app()->session['btnClick'] = "1";
				}
				elseif($newEmissionTestValidFrom >= $newEmissionTestValidTo)
				{
					Yii::app()->user->setFlash('success', "'Valid To' date should be greater than 'Valid From' date..!");
					Yii::app()->session['btnClick'] = "1";
				}
				else
				{
					if($model->save())
					{
						Yii::app()->user->setFlash('success', "Successfully Updated..!");
						$this->redirect(array('view','id'=>$model->Emission_test_ID));
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
		$dataProvider=new CActiveDataProvider('TREmissionTest');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TREmissionTest('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TREmissionTest']))
			$model->attributes=$_GET['TREmissionTest'];

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
		$model=TREmissionTest::model()->findByPk($id);
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
            if(isset($_POST['ajax']) && $_POST['ajax']==='tremission-test-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        public function actionDashboardEmissionTest() 
        {
            $model = new TREmissionTest('emmissionTest');

            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['TREmissionTest']))
            {
                $model->attributes = $_GET['TREmissionTest'];
            }

            $this->render('dashboardEmissionTest', array('model' => $model,)
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
