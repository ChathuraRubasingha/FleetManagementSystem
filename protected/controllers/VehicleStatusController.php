<?php

class VehicleStatusController extends Controller
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
				'actions'=>array('index','view','VehicleStatus'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'AddNew'),
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
			'actions'=>array('view','delete','VehicleStatus'),
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
		if(isset(Yii::app()->session['VehicleStatusID'])  && Yii::app()->session['VehicleStatusID'] !='')
		{
			unset(Yii::app()->session['VehicleStatusID']);
		}

		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionAddNew()
	{
		
		$model=new VehicleStatus;                            
		$this->performAjaxValidation($model);    	
		
		$flag=true;
		           // $scenario=$_POST['data'];                 
		if(isset($_POST['VehicleStatus']))                
		{   
			$flag=false;
			                     
			$model->attributes=$_POST['VehicleStatus'];
	                        
			$valid=$model->validate();                                   
			 if($valid)
			 {                                                                     
				 //do anything here                             
				 echo CJSON::encode(array('status'=>'success'));  
				 if($model->save())
				 {
					//Return an <option> and select it
					echo CHtml::tag('option',array('value'=>$model->Vehicle_Status_ID,  
					'selected'=>'selected'),
					CHtml::encode($model->Vehicle_Status),true);
				 }
			                         
				Yii::app()->end();                            
			 }                            
			 else
			 {    
			 	//$model->validate("Location_Name");                            
			 	$error = CActiveForm::validate($model);                                
				if($error!='[]') 
				//Yii::app()->user->setFlash('success', "sfsfsdsfs");                                   
					echo $error;
			        return false;                       
				Yii::app()->end();                            
			 }               
		}
		if($flag) 
		{
//			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//			Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
			$this->renderPartial('createDialog',array('model'=>$model,),false,true);
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
		
		$model=new VehicleStatus;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VehicleStatus']))
		{
			$model->attributes=$_POST['VehicleStatus'];
			
			$valid = $model->validate();	
			if($valid)
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Successfully Added..!");
					
					$vr = Yii::app()->session['VehicleStatusID']; 
					if ($vr == 'fromVehicleRegistry' && $vr != '')
					{			
						if(isset(Yii::app()->session['VehicleStatusID'])  && Yii::app()->session['VehicleStatusID'] !='')
						{
							unset(Yii::app()->session['VehicleStatusID']);
							$this->redirect(array('/maVehicleRegistry/create','id'=>$model->Vehicle_Status_ID));
						}
						
					}
					else
					{
						if(isset(Yii::app()->session['VehicleStatusID'])  && Yii::app()->session['VehicleStatusID'] !='')
						{
							unset(Yii::app()->session['VehicleStatusID']);	
						}
						$this->redirect(array('view','id'=>$model->Vehicle_Status_ID));
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

		if(isset($_POST['VehicleStatus']))
		{
			$model->attributes=$_POST['VehicleStatus'];
			$valid = $model->validate();	
			if($valid)
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Successfully Updated..!");
					$this->redirect(array('view','id'=>$model->Vehicle_Status_ID));
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
		$dataProvider=new CActiveDataProvider('VehicleStatus');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VehicleStatus('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VehicleStatus']))
			$model->attributes=$_GET['VehicleStatus'];

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
		$model=VehicleStatus::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='vehicle-status-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionVehicleStatus()
	{
		$string=trim($_GET['term']);
		if($string!='')
		{
			$model=  VehicleStatus::model()->findAll(array("condition"=>"Vehicle_Status like '%$string%'"));
			$data=array();
			foreach($model as $get)
			{
				$data[]=$get->Vehicle_Status;
			}
			$this->layout='empty';
			echo json_encode($data);
		}
	}
}
