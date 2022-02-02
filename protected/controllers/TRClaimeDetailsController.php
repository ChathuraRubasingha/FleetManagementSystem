<?php

class TRClaimeDetailsController extends Controller
{
	/*
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
public $numberFormat=array('decimals'=>2, 'decimalSeparator'=>',', 'thousandSeparator'=>',');
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
                            'actions'=>array(''),
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
            $model=new TRClaimeDetails;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            $appDate = date("Y-m-d");
            if(isset($_POST['TRClaimeDetails']))
            {
                $model->attributes=$_POST['TRClaimeDetails'];
                $model->Claime_Amount = str_replace(',','', $model->Claime_Amount);
                $model->Driver_Claim_Amount = str_replace(',','', $model->Driver_Claim_Amount);
                $model->Thirdparty_Claim_Amount = str_replace(',','', $model->Thirdparty_Claim_Amount);
                $model->Recovered_Amount = str_replace(',','', $model->Recovered_Amount);
                $model->Sum_Insured = str_replace(',','', $model->Sum_Insured);

                $Claime_Date = $model->Claime_Date;

                $estDateData = Yii::app()->db->createCommand('select Estimated_Date from estimate_details where Estimate_ID='.$model->Estimate_ID)->queryAll();
                $estDate = '';

                if(!empty($estDateData))
                {
                    $estDate = $estDateData[0]['Estimated_Date'];
                }
		                
                $valid = $model->validate();
                if($valid)
                {			
                    if ($Claime_Date > $appDate)
                    {
                        Yii::app()->user->setFlash('success',"'Claim Date' should be a previous Date");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    elseif($estDate > $model->Claime_Date)
                    {
                        Yii::app()->user->setFlash('success',"'Claim Date' should be greater than 'Estimated Date'");
                        Yii::app()->session['btnClick'] = "1";
                    }
                     elseif($model->Thirdparty_Claim_Date !=='' && $model->Thirdparty_Claim_Date !=='0000-00-00' && $estDate > $model->Thirdparty_Claim_Date)
                    {
                        Yii::app()->user->setFlash('success',"'Claim Date from Third Party' should be greater than 'Estimated Date'");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    elseif($model->Driver_Claim_Date !=='' && $model->Driver_Claim_Date !=='0000-00-00' && $estDate > $model->Driver_Claim_Date)
                    {
                        Yii::app()->user->setFlash('success',"'Claim Date from Driver' should be greater than 'Estimated Date'");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    else
                    {
                        if($model->save())
                        {
                            Yii::app()->user->setFlash('success', "Successfully Added..!");
                            $this->redirect(array('view','id'=>$model->Claime_ID));
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
            if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
            {
                unset(Yii::app()->session['btnClick']);
            }

            $model=$this->loadModel($id);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            $appDate = MaVehicleRegistry::model()->getServerDate('date');
            
            if(isset($_POST['TRClaimeDetails']))
            {
                $model->attributes=$_POST['TRClaimeDetails'];

                $model->Claime_Amount = str_replace(',','', $model->Claime_Amount);
                $model->Driver_Claim_Amount = str_replace(',','', $model->Driver_Claim_Amount);
                $model->Thirdparty_Claim_Amount = str_replace(',','', $model->Thirdparty_Claim_Amount);
                $model->Recovered_Amount = str_replace(',','', $model->Recovered_Amount);
                $model->Sum_Insured = str_replace(',','', $model->Sum_Insured);
                
                $Claime_Date = $model->Claime_Date;

                $estDateData = Yii::app()->db->createCommand('select Estimated_Date from estimate_details where Estimate_ID='.$model->Estimate_ID)->queryAll();
                $estDate = '';

                $model->Thirdparty_Claim_Date = $_POST['TRClaimeDetails']['Thirdparty_Claim_Date'];
                $model->Driver_Claim_Date = $_POST['TRClaimeDetails']['Driver_Claim_Date'];
                
                if(!empty($estDateData))
                {
                    $estDate = $estDateData[0]['Estimated_Date'];
                }

                $valid = $model->validate();
                if($valid)
                {
                    if ($Claime_Date > $appDate)
                    {
                        Yii::app()->user->setFlash('success',"'Claim Date from Insurance' should be a previous Date");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    elseif($estDate > $model->Claime_Date)
                    {
                        Yii::app()->user->setFlash('success',"'Claim Date from Insurance' should be greater than 'Estimated Date'");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    elseif($model->Thirdparty_Claim_Date !=='' && $model->Thirdparty_Claim_Date !=='0000-00-00' && $estDate > $model->Thirdparty_Claim_Date)
                    {
                        Yii::app()->user->setFlash('success',"'Claim Date from Third Party' should be greater than 'Estimated Date'");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    elseif($model->Driver_Claim_Date !=='' && $model->Driver_Claim_Date !=='0000-00-00' && $estDate > $model->Driver_Claim_Date)
                    {
                        Yii::app()->user->setFlash('success',"'Claim Date from Driver' should be greater than 'Estimated Date'");
                        Yii::app()->session['btnClick'] = "1";
                    }
                    else
                    {					
                        if($model->save())
                        {
                            Yii::app()->user->setFlash('success', "Successfully Updated..!");
                            $this->redirect(array('view','id'=>$model->Claime_ID));
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
		$dataProvider=new CActiveDataProvider('TRClaimeDetails');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TRClaimeDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRClaimeDetails']))
			$model->attributes=$_GET['TRClaimeDetails'];

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
		$model=TRClaimeDetails::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='trclaime-details-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
