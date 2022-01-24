<?php

class MaAllocationTypeController extends Controller
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
				'actions'=>array('index','view','dynamic','AllocationType'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','AddNew'),
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
	}
 */
 
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
					'actions'=>array('view','delete','AllocationType','dynamic'),
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
		
		if(isset(Yii::app()->session['AllocationTypeID'])  && Yii::app()->session['AllocationTypeID'] !='')
	{
		unset(Yii::app()->session['AllocationTypeID']);
	}
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	 
	 public function actionAddNew()
	{
	
		$model=new MaAllocationType;                            
		$this->performAjaxValidation($model);    
		
		
		$flag=true;
		                    
		if(isset($_POST['MaAllocationType']))                
		{   
			$flag=false;
			                     
			$model->attributes=$_POST['MaAllocationType'];
	                        
			$valid=$model->validate();                                   
			 if($valid)
			 {                                                                     
				 //do anything here                             
				 echo CJSON::encode(array('status'=>'success'));  
				 if($model->save())
				 {
					//Return an <option> and select it
					echo CHtml::tag('option',array('value'=>$model->Allocation_Type_ID,  
					'selected'=>'selected'),
					CHtml::encode($model->Allocation_Type),true);
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
	
	
	



	public function actionCreate()
	{
		if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
		{
			unset(Yii::app()->session['btnClick']);
		}
		
		$model=new MaAllocationType;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaAllocationType']))
		{
			$model->attributes=$_POST['MaAllocationType'];
			$valid = $model->validate();
			if($valid)
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Successfully Added..!");
					$this->redirect(array('view','id'=>$model->Allocation_Type_ID));
					
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

		if(isset($_POST['MaAllocationType']))
		{
			$model->attributes=$_POST['MaAllocationType'];
			
			$valid = $model->validate();
			if($valid)
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Successfully Updated..!");
					$this->redirect(array('view','id'=>$model->Allocation_Type_ID));
					
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
		$dataProvider=new CActiveDataProvider('MaAllocationType');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MaAllocationType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaAllocationType']))
			$model->attributes=$_GET['MaAllocationType'];

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
		$model=MaAllocationType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	
	public function actionDynamic()
	{
		/*if(isset($_POST['MaAllocationType']['Allocation_Type_ID']))
		{
			$ID =$_POST['MaAllocationType']['Allocation_Type_ID'];
		}
		else if(isset($_POST['MaVehicleRegistry']['Allocation_Type_ID']))
	   	{
			$ID =$_POST['MaVehicleRegistry']['Allocation_Type_ID'];
		}	*/
		
		
		
		/*$data=MaAllocationType::model()->findAll('Allocation_Type_ID=:Allocation_Type_ID', array(':Allocation_Type_ID'=>(int)$ID));*/
		
		$data = Yii::app()->db->createCommand('SELECT Allocation_Type_ID , Allocation_Type FROM ma_allocation_type')->queryAll();
		$data=CHtml::listData($data,'Allocation_Type_ID','Allocation_Type');

	
		echo CHtml::tag('option',
		array('value'=>''),CHtml::encode('--- Please Select ---'),true);
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			array('value'=>$value),CHtml::encode($name),true);
		}
	}
	
	public function dynamicaaa()
	{
		$type = $_POST['alType'];
		$data = Yii::app()->db->createCommand("select Allocation_Type_ID  from ma_allocation_type where Allocation_Type =".$type)->queryAll();
		
		
		echo $row['Allocation_Type_ID'];
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ma-allocation-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAllocationType()
	{
		$string=trim($_GET['term']);
		if($string!='')
		{
			$model=  MaAllocationType::model()->findAll(array("condition"=>"Allocation_Type like '%$string%'"));
			$data=array();
			foreach($model as $get)
			{
				$data[]=$get->Allocation_Type;
			}
			$this->layout='empty';
			echo json_encode($data);
		}
	}
	
}
