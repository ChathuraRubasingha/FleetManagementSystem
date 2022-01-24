<?php

class MaGaragesController extends Controller
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
                                'actions'=>array('GarageName','UpdateGarage','Session4RemoveBtn'),
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
        if(isset(Yii::app()->session['maGarages']))
        {
            unset(Yii::app()->session['maGarages']);
        }       
        
        $model = new MaGarages;
        $this->layout = 'fancy_box_layout';

        if (isset($_POST['MaGarages'])) {
            $model->attributes = $_POST['MaGarages'];
            if ($model->save())
            {
                Yii::app()->session['maGarages'] = $model->Garage_ID;

                Yii::app()->user->setFlash('success', "Successfully Added..!");
            }

        }

        $this->render('_form', array(
            'model' => $model
        ));

    }


    public function actionUpdateGarage()
    {
        if(isset(Yii::app()->session["RemoveBtnSession"]))
        {
            unset(Yii::app()->session["RemoveBtnSession"]);
        }
        
        $garageID=0;
        if(isset(Yii::app()->session["maGarages"])&& Yii::app()->session["maGarages"] !='')
        {
            $garageID = Yii::app()->session["maGarages"];
            $lastInsertedGarageArray = MaGarages::model()->getLastInsertedGarage($garageID);

            if(count($lastInsertedGarageArray)>0)
            {
                $garageID = $lastInsertedGarageArray[0]["Garage_ID"];
                $garage = $lastInsertedGarageArray[0]["Garage_Name"];

                echo CHtml::tag('option',array('value'=>$garageID,
                        'selected'=>'selected'),
                    CHtml::encode($garage ),true);
            }
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
		
		$model=new MaGarages;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaGarages']))
		{
			$model->attributes=$_POST['MaGarages'];
			
			$valid = $model->validate();
			if($valid)
			{
				if($model->save())
				{                                    
					Yii::app()->user->setFlash('success', "Successfully Added..!");
					$this->redirect(array('view','id'=>$model->Garage_ID));
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

		if(isset($_POST['MaGarages']))
		{
			$model->attributes=$_POST['MaGarages'];
			
			$valid = $model->validate();
			if($valid)
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Successfully Updated..!");
					$this->redirect(array('view','id'=>$model->Garage_ID));
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
		$dataProvider=new CActiveDataProvider('MaGarages');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MaGarages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaGarages']))
			$model->attributes=$_GET['MaGarages'];

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
		$model=MaGarages::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ma-garages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionGarageName()
	{
		$string=trim($_GET['term']);
		if($string!='')
		{
			$model=  MaGarages::model()->findAll(array("condition"=>"Garage_Name like '%$string%'"));
			$data=array();
			foreach($model as $get)
			{
				$data[]=$get->Garage_Name;
			}
			$this->layout='empty';
			echo json_encode($data);
		}
	}
        
        public function actionSession4RemoveBtn()
        {
            Yii::app()->session['RemoveBtnSession']="1";
        }
}
