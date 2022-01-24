<?php

class TREstimateDetailsController extends Controller
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
				'actions'=>array('index','view','estimateClaime'),
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
					'actions'=>array('GetAccidentType'),
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
        $model=new TREstimateDetails;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['TREstimateDetails']))
        {
            $model->attributes=$_POST['TREstimateDetails'];
            $model->Damage_Estimate = str_replace(',','',$model->Damage_Estimate);
            $appDate = MaVehicleRegistry::model()->getServerDate("date");
            $accDateData = Yii::app()->db->createCommand('select date(a.Date_and_Time) as Date, Driver_ID  from accident a  where a.Accident_ID ='.$model->Accident_ID)->queryAll();

            $accDate = '';

            $criteria=new CDbCriteria();

            $criteria->select = 'Value';
            $criteria->condition = 'Row = "5"';
            $valueArr = NotificationConfiguration::model()->find($criteria);
            $count = count($valueArr);
            $MajorValue=50000;
            
            if($count>0)
            {
                $MajorValue = $valueArr['Value'];
            }
			//echo $MajorValue;exit;
            if(!empty($accDateData))
            {
                $accDate = $accDateData[0]['Date'];
                $driverID = $accDateData[0]['Driver_ID'];
            }
            $valid = $model->validate();
            if($valid)
            {
                if($accDate > $model->Estimated_Date)
                {
                    Yii::app()->user->setFlash('success', "'Estimate Date' should be greater than 'Accident Date'(".$accDate.")..!");
                }
                else if($model->Estimated_Date > $appDate)
                {
                    Yii::app()->user->setFlash('success', "'Estimate Date' should be a previous date..!");
                }
                else
                {
                    $model->add_by = $_POST['TREstimateDetails']['add_by'];
                    $model->add_date = $_POST['TREstimateDetails']['add_date'];
                    $model->edit_by = $_POST['TREstimateDetails']['edit_by'];
                    $model->edit_date = $_POST['TREstimateDetails']['edit_date'];
                    if($model->save())
                    {
                        $drvrRate =0;
                        if($model->Damage_Estimate  > $MajorValue)
                        {
                            $drvrRate=-2;
                            TRAccident::model()->updateByPk($model->Accident_ID , array('Accident_Type'=>'Major', 'Driver_Rating'=>$drvrRate));
                        }
                        else
                        {
                            $drvrRate=-1;
                            TRAccident::model()->updateByPk($model->Accident_ID , array('Accident_Type'=>'Minor', 'Driver_Rating'=>$drvrRate));
                        }
                        $command = Yii::app()->db->createCommand();
                        $command->insert('driver_rating', array('Driver_ID' => $driverID,'Accident_ID'=>$model->Accident_ID ,'Rate_By_Accident'=>$drvrRate,'Date_Rated'=>date("Y-m-d", time())));
					
					
					
                        Yii::app()->user->setFlash('success', "Successfully Added..!");
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

        if(isset($_POST['TREstimateDetails']))
        {
            $model->attributes=$_POST['TREstimateDetails'];
            $model->Damage_Estimate = str_replace(',','',$model->Damage_Estimate);
            $appDate = date("Y-m-d");
            $accDateData = Yii::app()->db->createCommand('select date(a.Date_and_Time) as Date from accident a  where a.Accident_ID ='.$model->Accident_ID)->queryAll();

            $criteria=new CDbCriteria();

            $criteria->select = 'Value';
            $criteria->condition = 'Row = "5"';

            $count = count($criteria);
            $MajorValue=0;
            if($count>0)
            {
                $valueArr = NotificationConfiguration::model()->find($criteria);
                $MajorValue = $valueArr['Value'];
            }

            $accDate = '';

            if(!empty($accDateData))
            {
                $accDate = $accDateData[0]['Date'];
            }

            $valid = $model->validate();
            if($valid)
            {
                if($accDate > $model->Estimated_Date)
                {
                    Yii::app()->user->setFlash('success', "'Estimate Date' should be greater than 'Accident Date'(".$accDate.")..!");
                }
                else if($model->Estimated_Date > $appDate)
                {
                    Yii::app()->user->setFlash('success', "'Estimate Date' should be a previous date..!");
                }
                else
                {
                    $model->edit_by = $_POST['TREstimateDetails']['edit_by'];
                    $model->edit_date = $_POST['TREstimateDetails']['edit_date'];
                    if($model->save())
                    {
                        if($model->Damage_Estimate  > $MajorValue)
                        {
                            TRAccident::model()->updateByPk($model->Accident_ID , array('Accident_Type'=>'Major', 'Driver_Rating'=>"-2"));
                        }
                        else
                        {
                            TRAccident::model()->updateByPk($model->Accident_ID , array('Accident_Type'=>'Minor', 'Driver_Rating'=>"-1"));
                        }

                        Yii::app()->user->setFlash('success', "Successfully Updated..!");
                        $this->redirect(array('view','id'=>$model->Estimate_ID));
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
		$dataProvider=new CActiveDataProvider('TREstimateDetails');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TREstimateDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TREstimateDetails']))
			$model->attributes=$_GET['TREstimateDetails'];

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
		$model=TREstimateDetails::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionEstimateClaime()
	{
		$model=new TREstimateDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TREstimateDetails']))
			$model->attributes=$_GET['TREstimateDetails'];

		$this->render('estimateClaime',array(
			'model'=>$model,
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
            if(isset($_POST['ajax']) && $_POST['ajax']==='trestimate-details-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        public function actionGetAccidentType() 
        {
            $result = '';
            if(isset($_POST['estimateCost']) && $_POST['estimateCost'] !='')
            {
                $estimateCost = $_POST['estimateCost'];
                
                $marginValue = NotificationConfiguration::model()->getNotificationValue('5');
                
                if($estimateCost > $marginValue)
                {
                    $result = 'Major';
                }
                else
                {
                    $result = 'Minor';
                }
            }
            
            echo $result;
        }
}
