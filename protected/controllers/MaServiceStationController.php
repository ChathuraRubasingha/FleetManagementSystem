<?php

class MaServiceStationController extends Controller
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
                    'actions'=>array('ServiceStation','UpdateServiceStation'),
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
	
    public function actionAddNew()
    {
        if(isset(Yii::app()->session['maServiceStation']))
        {
            unset(Yii::app()->session['maServiceStation']);
        }
        $model = new MaServiceStation;
        $this->layout = 'fancy_box_layout';

        if (isset($_POST['MaServiceStation'])) {
            $model->attributes = $_POST['MaServiceStation'];
            if ($model->save())
            {
                Yii::app()->session['maServiceStation'] = $model->Service_Station_ID;

                Yii::app()->user->setFlash('success', "Successfully Added..!");
            }

        }

        $this->render('_form', array(
            'model' => $model
        ));

    }


    public function actionUpdateServiceStation()
    {
        $stationID = Yii::app()->session["maServiceStation"];
        $lastInsertedStationArray = MaServiceStation::model()->getLastInsertedStation($stationID);

        if(count($lastInsertedStationArray)>0)
        {
            $serviceStationID = $lastInsertedStationArray[0]["Service_Station_ID"];
            $serviceStation = $lastInsertedStationArray[0]["Srvice_Station_Name"];

            echo CHtml::tag('option',array('value'=>$serviceStationID,
                    'selected'=>'selected'), CHtml::encode($serviceStation ),true);
        }

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

        $model=new MaServiceStation;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['MaServiceStation']))
        {
            $model->attributes=$_POST['MaServiceStation'];
            $valid = $model->validate();
            if($valid)
            {
                if($model->save())
                {
                    Yii::app()->user->setFlash('success', "Successfully Added..!");
                    $this->redirect(array('view','id'=>$model->Service_Station_ID));
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

        if(isset($_POST['MaServiceStation']))
        {
            $model->attributes=$_POST['MaServiceStation'];

            $valid = $model->validate();
            if($valid)
            {
                if($model->save())
                {
                    Yii::app()->user->setFlash('success', "Successfully Updated..!");
                    $this->redirect(array('view','id'=>$model->Service_Station_ID));
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
		$dataProvider=new CActiveDataProvider('MaServiceStation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MaServiceStation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaServiceStation']))
			$model->attributes=$_GET['MaServiceStation'];

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
		$model=MaServiceStation::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ma-service-station-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionServiceStation()
	{
		$string=trim($_GET['term']);
		if($string!='')
		{
			$model=  MaServiceStation::model()->findAll(array("condition"=>"Srvice_Station_Name like '%$string%'"));
			$data=array();
			foreach($model as $get)
			{
				$data[]=$get->Srvice_Station_Name;
			}
			$this->layout='empty';
			echo json_encode($data);
		}
	}
}
