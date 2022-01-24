<?php

class TRLicenseController extends Controller
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
			'actions'=>array('DashboardLicenseDetails','gridLocation'),
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
            
            $date = MaVehicleRegistry::model()->getServerDate("date");
            $appDate =  MaVehicleRegistry::model()->getServerDate("dateTime");
            
            $vehicleId = Yii::app()->session['maintenVehicleId'];
            
            $model=new TRLicense;
           
            // check emission test details
            $EmResult = TREmissionTest::model()->getEmissionTestResult();
            $count = count($EmResult);
            $emissonTest = '';
            $fitnessTest = "";
            
            if($count == '0')
            {                
                Yii::app()->user->setFlash('success', "Emission Test Details are not available");
            }
            else
            {
                $emissionTestValid_From = $EmResult[$count-1]['Valid_From'];
                $emissionTestValid_To = $EmResult[$count-1]['Valid_To'];
                $emissionTestResult = $EmResult[$count-1]['Emission_Test_Result'];

                if($date >= $emissionTestValid_From &&  $date <= $emissionTestValid_To)
                {
                    if($emissionTestResult != 'Pass')
                    {
                       $emissonTest = 'Fail';
                    }    
                    else
                    {
                        $emisionArr = Yii::app()->db->createCommand("SELECT Emission_test_ID FROM emission_test WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1")->queryAll();
                        if(!empty($emisionArr))
                        {
                            $emission = $emisionArr[0]['Emission_test_ID'];
                            $model->Emission_test_ID = $emission;
                        }
                        else
                        {
                            $model->Emission_test_ID = '0';
                        }
                    }
                }
                else
                {
                    $emissonTest = 'Out_Of_Date';
                }
            }
            
            
            $status=Yii::app()->session['fitnessStatus'];
            
            if($status =='Yes')
            {
                $FtResult = TRFitnessTest::model()->getFitnessTestResult();
                $FtCount = count($FtResult);
               
                if($FtCount == "0")
                {
                    Yii::app()->user->setFlash('success', "Fitness Test Details are not available");
                }
                else
                {
                    $FitnessValid_From = $FtResult[$FtCount-1]['Valid_From'];
                    $FitnessValid_To = $FtResult[$FtCount-1]['Valid_To'];
                    $FitnessResult = $FtResult[$FtCount-1]['Fitness_Test_Result'];

                    if($date >= $FitnessValid_From &&  $date <= $FitnessValid_To)
                    {
                        if($FitnessResult != 'Pass')
                        {
                           $fitnessTest = 'Fail';
                        }    
                        else
                        {
                            $fitnessArr = Yii::app()->db->createCommand("SELECT Fitness_Test_ID FROM fitness_test WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1")->queryAll();
                            if(!empty($fitnessArr))
                            {
                                $fitness = $fitnessArr[0]['Fitness_Test_ID'];
                                $model->Fitness_ID = $fitness;
                            }
                            else
                            {
                                $model->Fitness_ID = NULL;
                            }
                        }
                    }
                    else
                    {
                        $fitnessTest = 'Out_Of_Date';
                    }
                }
               
            }
            else 
            {
                $model->Fitness_ID = NULL;
            }
            
            if(isset($_POST['TRLicense']))
            {
                $model->attributes=$_POST['TRLicense'];

                if($emissonTest == 'Fail')
                {
                    Yii::app()->user->setFlash('success', "Emission Test was failed");
                    Yii::app()->session['btnClick'] = "1";
                    $this->redirect(array('create'));
                }
                elseif ($emissonTest == 'Out_Of_Date') 
                {
                    Yii::app()->user->setFlash('success', "Emission Test is out of date");
                    Yii::app()->session['btnClick'] = "1";
                    $this->redirect(array('create'));
                }
                
                if($fitnessTest == 'Fail')
                {
                    Yii::app()->user->setFlash('success', "Fitness Test was failed");
                    Yii::app()->session['btnClick'] = "1";
                    $this->redirect(array('create'));
                }
                elseif ($fitnessTest == 'Out_Of_Date') 
                {
                    Yii::app()->user->setFlash('success', "Fitness Test is out of date");
                    Yii::app()->session['btnClick'] = "1";
                    $this->redirect(array('create'));
                }
                else
                {
                    $newLicenseDate = $model-> Date_of_License;
                    $newLicenseValidFrom = $model-> Valid_From;
                    $newLicenseValidTo = $model-> Valid_To;
                    $newLicenseFitnessID = $model-> Fitness_ID;

                    $model->Amount = str_replace(',', '', $model->Amount);
                    
                    $valid = $model->validate();
                    
                    if($valid)
                    {
                        $query = "SELECT Valid_From, Valid_To FROM license WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1";
                        $rawData = Yii::app()->db->createCommand($query)->queryAll();

                        $countRow = count($rawData);
                        
                        if($countRow == 0)
                        {
                            if($model->save())
                            {
                                Yii::app()->user->setFlash('success', "Successfully Added..!");
                                $this->redirect(array('view','id'=>$model->License_ID));
                            }
                        }
                        else
                        {
                            $lastLicenseValidFrom = $rawData[$countRow-1]['Valid_From'];
                            $lastLicenseValidTo = $rawData[$countRow-1]['Valid_To'];

                            if($lastLicenseValidTo >= $newLicenseValidTo )
                            {
                                Yii::app()->user->setFlash('success', "Previous License details are existed..!");
                                Yii::app()->session['btnClick'] = "1";
                            }
                            else
                            {
                                if($model->save())
                                {
                                    Yii::app()->user->setFlash('success', "Successfully Added..!");
                                    $this->redirect(array('view','id'=>$model->License_ID));
                                }
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
        
        
        public function actionUpdate($id)
	{
            if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
            {
                unset(Yii::app()->session['btnClick']);
            }
            
            $date = MaVehicleRegistry::model()->getServerDate("date");
            $appDate =  MaVehicleRegistry::model()->getServerDate("dateTime");
            
            $vehicleId = Yii::app()->session['maintenVehicleId'];
            
            $model=$this->loadModel($id);
           
            // check emission test details
            $EmResult = TREmissionTest::model()->getEmissionTestResult();
            $count = count($EmResult);
            $emissonTest = '';
            $fitnessTest = "";
            if($count == 0)
            {                
                Yii::app()->user->setFlash('success', "Emission Test Details are not available");
            }
            else
            {
                $emissionTestValid_From = $EmResult[$count-1]['Valid_From'];
                $emissionTestValid_To = $EmResult[$count-1]['Valid_To'];
                $emissionTestResult = $EmResult[$count-1]['Emission_Test_Result'];

                if($date >= $emissionTestValid_From &&  $date <= $emissionTestValid_To)
                {
                    if($emissionTestResult != 'Pass')
                    {
                       $emissonTest = 'Fail';
                    }    
                    else
                    {
                        $emisionArr = Yii::app()->db->createCommand("SELECT Emission_test_ID FROM emission_test WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1")->queryAll();
                        if(!empty($emisionArr))
                        {
                            $emission = $emisionArr[0]['Emission_test_ID'];
                            $model->Emission_test_ID = $emission;
                        }
                        else
                        {
                            $model->Emission_test_ID = '0';
                        }
                    }
                }
                else
                {
                    $emissonTest = 'Out_Of_Date';
                }
            }
            
            
            $status=Yii::app()->session['fitnessStatus'];
            //echo $status;exit;
            if(Yii::app()->session['fitnessStatus'] == 'Yes')
            {
                
                $FtResult = TRFitnessTest::model()->getFitnessTestResult();
                $FtCount = count($FtResult);
                
                if($FtCount == "0")
                {
                    Yii::app()->user->setFlash('success', "Fitness Test Details are not available");
                }
                else
                {
                    $FitnessValid_From = $FtResult[$FtCount-1]['Valid_From'];
                    $FitnessValid_To = $FtResult[$FtCount-1]['Valid_To'];
                    $FitnessResult = $FtResult[$FtCount-1]['Fitness_Test_Result'];

                    if($date >= $FitnessValid_From &&  $date <= $FitnessValid_To)
                    {
                        if($FitnessResult != 'Pass')
                        {
                           $fitnessTest = 'Fail';
                        }    
                        else
                        {
                            $fitnessArr = Yii::app()->db->createCommand("SELECT Fitness_Test_ID FROM fitness_test WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1")->queryAll();
                            if(!empty($fitnessArr))
                            {
                                $fitness = $fitnessArr[0]['Fitness_Test_ID'];
                                $model->Fitness_ID = $fitness;
                            }
                            else
                            {
                                $model->Fitness_ID = NULL;
                            }
                        }
                    }
                    else
                    {
                        $fitnessTest = 'Out_Of_Date';
                    }
                }
               
            }
            else 
            {
                $model->Fitness_ID = NULL;
            }
            
            if(isset($_POST['TRLicense']))
            {
                $model->attributes=$_POST['TRLicense'];

                if($emissonTest == 'Fail')
                {
                    Yii::app()->user->setFlash('success', "Emission Test was failed");
                    Yii::app()->session['btnClick'] = "1";
                    $this->redirect(array('update','id'=>$model->License_ID));
                }
                elseif ($emissonTest == 'Out_Of_Date') 
                {
                    Yii::app()->user->setFlash('success', "Emission Test is out of date");
                    Yii::app()->session['btnClick'] = "1";
                    $this->redirect(array('update','id'=>$model->License_ID));
                }
                if($fitnessTest == 'Fail')
                {
                    Yii::app()->user->setFlash('success', "Fitness Test was failed");
                    Yii::app()->session['btnClick'] = "1";
                    $this->redirect(array('update','id'=>$model->License_ID));
                }
                elseif ($fitnessTest == 'Out_Of_Date') 
                {
                    Yii::app()->user->setFlash('success', "Fitness Test is out of date");
                    Yii::app()->session['btnClick'] = "1";
                    $this->redirect(array('update','id'=>$model->License_ID));
                }
                else
                {
                    $newLicenseDate = $model-> Date_of_License;
                    $newLicenseValidFrom = $model-> Valid_From;
                    $newLicenseValidTo = $model-> Valid_To;
                    $newLicenseFitnessID = $model-> Fitness_ID;

                    $model->Amount = str_replace(',', '', $model->Amount);
                    
                    $valid = $model->validate();	
                    if($valid)
                    {
                       
                            if($model->save())
                            {
                                Yii::app()->user->setFlash('success', "Successfully Updated..!");
                                $this->redirect(array('view','id'=>$model->License_ID));
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate123($id)
	{
		date_default_timezone_set("Asia/Colombo");
            if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
            {
                    unset(Yii::app()->session['btnClick']);
            }
            $model=$this->loadModel($id);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['TRLicense']))
            {
                $model->attributes=$_POST['TRLicense'];
                if($model->Emission_test_ID == '')
                {
                    $model->Emission_test_ID =0;
                }
                $vehicleId = Yii::app()->session['maintenVehicleId'];

                $emisionArr = Yii::app()->db->createCommand("SELECT Emission_test_ID FROM emission_test WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1")->queryAll();
                if(!empty($emisionArr))
                {
                    $emission = $emisionArr[0]['Emission_test_ID'];
                    $model->Emission_test_ID = $emission;
                }
                else
                {
                    $model->Emission_test_ID = '0';
                }

                $fitnessArr = Yii::app()->db->createCommand("SELECT Fitness_Test_ID FROM fitness_test WHERE Vehicle_No = '".$vehicleId."' ORDER BY Valid_To DESC LIMIT 1")->queryAll();
                if(!empty($fitnessArr))
                {
                    $fitness = $fitnessArr[0]['Fitness_Test_ID'];
                    $model->Fitness_ID = $fitness;
                }
                else
                {
                    $model->Fitness_ID = NULL;
                }		 
			
                $newLicenseDate = $model-> Date_of_License;
                $newLicenseValidFrom = $model-> Valid_From;
                $newLicenseValidTo = $model-> Valid_To;
                $newLicenseFitnessID = $model-> Fitness_ID;
                $appDate = date("Y-m-d : H:i:s", time());
                $model->Amount = str_replace(',', '', $model->Amount);

                $status=Yii::app()->session['fitnessStatus'];
			//echo $model->Emission_test_ID ;exit;
                $valid = $model->validate();	
                if($valid)
                {
                    if($newLicenseDate > $appDate)
                    {
                        Yii::app()->user->setFlash('success', "'Date of License' should be a previous date..!");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    elseif($newLicenseValidFrom >= $newLicenseValidTo )
                    {
                            Yii::app()->user->setFlash('success', "'Valid To' date should be greater than 'Valid From' date..!");
                            Yii::app()->session['btnClick'] = "1";
                    }
                    elseif($newLicenseDate > $newLicenseValidFrom)
                    {
                        Yii::app()->user->setFlash('success', "'Valid From' date should be greater than 'Date of License'..!");
                        Yii::app()->session['btnClick'] = "1";
                    }				
                    else
                    {
                        $status=Yii::app()->session['fitnessStatus'];
                        
                        if($status=='Yes')
                        {
                            if($newLicenseFitnessID == "" )
                            {
                                Yii::app()->user->setFlash('success', "Cannot Add this record, Fitness Test was Fail ..!");
                                Yii::app()->session['btnClick'] = "1";
                            }
                            else
                            {
                                if($model->save())
                                {
                                    Yii::app()->user->setFlash('success', "Successfully Updated..!");
                                    $this->redirect(array('view','id'=>$model->License_ID));
                                }
                            }					
                        }
                        else
                        {
                            if($model->save())
                            {
                                Yii::app()->user->setFlash('success', "Successfully Updated..!");
                                $this->redirect(array('view','id'=>$model->License_ID));
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
		$dataProvider=new CActiveDataProvider('TRLicense');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TRLicense('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRLicense']))
			$model->attributes=$_GET['TRLicense'];

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
		$model=TRLicense::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='trlicense-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	protected function getEmissionResult($data)
	{
		$sql = Yii::app()->db->createCommand('SELECT Emission_Test_Result FROM emission_test 
		WHERE Vehicle_No = "'.$data->Vehicle_No.'" ORDER BY Valid_To DESC LIMIT 1')->queryAll();
		
		$EmissionTst = Yii::app()->db->createCommand('select Emission_test ')->queryAll();
		$result ='';
		if(!empty($sql))
		foreach ($sql as $row)
		{
			$result = $row['Emission_Test_Result'];
		}
		return $result;
	}
        
        public function actionDashboardLicenseDetails()
        {
            $model = new TRLicense('License');

            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['TRLicense']))
            {
                $model->attributes = $_GET['TRLicense'];
            }
            $this->render('dashboardLicenseDetails', array('model' => $model,)
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
