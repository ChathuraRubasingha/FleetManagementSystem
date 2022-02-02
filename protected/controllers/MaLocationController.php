<?php

class MaLocationController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
					'actions'=>array('view','delete','Dynamiccities','Dynamic','DynamicChange','CurrentLocation','Location','UpdateLocation'),
					'users'=>array('*'),
				),				
				array('deny',  // deny all users
					'users'=>array('*'),
				),		

			);

		}		
		
	}
	
	
        
        
    public function actionAddNew()
    {
        if(isset(Yii::app()->session['maLocation']))
        {
            unset(Yii::app()->session['maLocation']);
        }
        
        if(isset($_POST['district']) && $_POST['district']!='')
        {
            Yii::app()->session['selectedDist']=$_POST['district'];
            
        }
        
        $model = new MaLocation;
        $this->layout = 'fancy_box_layout';

        if (isset($_POST['MaLocation'])) {
            $model->attributes = $_POST['MaLocation'];
            if ($model->save())
            {
                Yii::app()->session['maLocation'] = $model->Location_ID;

                Yii::app()->user->setFlash('success', "Successfully Added..!");
            }

        }

        $this->render('_form', array(
            'model' => $model
        ));

    }


    public function actionUpdateLocation()
    {
         if(isset(Yii::app()->session['selectedDist']))
        {
            unset(Yii::app()->session['selectedDist']);            
        }
        
        $batteryTypeID = Yii::app()->session["maLocation"];
        $lastInsertedLocationArray = MaLocation::model()->getLastInsertedLocation($batteryTypeID);

        if(count($lastInsertedLocationArray)>0)
        {
            $locationID = $lastInsertedLocationArray[0]["Location_ID"];
            $location = $lastInsertedLocationArray[0]["Location_Name"];

            echo CHtml::tag('option',array('value'=>$locationID,
                    'selected'=>'selected'),
                CHtml::encode($location ),true);
        }

    }
	

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
		if(isset(Yii::app()->session['LocationID'])  && Yii::app()->session['LocationID'] !='')
		{
			unset(Yii::app()->session['LocationID']);
		}

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
		if(isset(Yii::app()->session['district']) && Yii::app()->session['district'] !='')
		{
			unset(Yii::app()->session['district']);
			unset(Yii::app()->session['district']);
		}
		if(isset(Yii::app()->session['dsDivision']) && Yii::app()->session['dsDivision'] !='')
		{
			unset(Yii::app()->session['dsDivision']);
			unset(Yii::app()->session['dsDivision']);
		}
		if(isset(Yii::app()->session['gnDivision']) && Yii::app()->session['gnDivision'] !='')
		{
			unset(Yii::app()->session['gnDivision']);
			unset(Yii::app()->session['gnDivision']);
		}
		if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
		{
			unset(Yii::app()->session['btnClick']);
		}
		
		$model=new MaLocation;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaLocation']))
		{
			$model->attributes=$_POST['MaLocation'];
			
			$district = $model->District_ID;
			$dsDivision = $model->DS_Division_ID;
			$gnDivision = $model->GN_Division_ID;
			
			$valid = $model->validate();
			if($valid)
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Successfully Added..!");
					
					$vr = Yii::app()->session['LocationID']; 
					if ($vr == 'fromVehicleRegistry' && $vr != '')
					{			
						if(isset(Yii::app()->session['LocationID'])  && Yii::app()->session['LocationID'] !='')
						{
							unset(Yii::app()->session['LocationID']);
							$this->redirect(array('/maVehicleRegistry/create','id'=>$model->Location_ID));
						}
						
					}
					else
					{
						if(isset(Yii::app()->session['LocationID'])  && Yii::app()->session['LocationID'] !='')
						{
							unset(Yii::app()->session['LocationID']);	
						}
						
						$this->redirect(array('view','id'=>$model->Location_ID));
					}				
				}
			}
			else
			{
				
				Yii::app()->session['district'] = $district;
				Yii::app()->session['dsDivision'] = $dsDivision;
				Yii::app()->session['gnDivision'] = $gnDivision;
				
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
		if(isset(Yii::app()->session['district']) && Yii::app()->session['district'] !='')
		{
			unset(Yii::app()->session['district']);
			unset(Yii::app()->session['district']);
		}
		if(isset(Yii::app()->session['dsDivision']) && Yii::app()->session['dsDivision'] !='')
		{
			unset(Yii::app()->session['dsDivision']);
			unset(Yii::app()->session['dsDivision']);
		}
		if(isset(Yii::app()->session['gnDivision']) && Yii::app()->session['gnDivision'] !='')
		{
			unset(Yii::app()->session['gnDivision']);
			unset(Yii::app()->session['gnDivision']);
		}
		
		if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
		{
			unset(Yii::app()->session['btnClick']);
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['MaLocation']))
		{
			$model->attributes=$_POST['MaLocation'];
			
			$valid = $model->validate();
			if($valid)
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Successfully Updated..!");
					$this->redirect(array('view','id'=>$model->Location_ID));
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
		$dataProvider=new CActiveDataProvider('MaLocation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MaLocation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaLocation']))
			$model->attributes=$_GET['MaLocation'];

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
		$model=MaLocation::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ma-location-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionDynamiccities()
	{
    	$data=Location::model()->findAll('parent_id=:parent_id', 
                  array(':parent_id'=>(int) $_POST['country_id']));
 
    	$data=CHtml::listData($data,'id','name');
    	foreach($data as $value=>$name)
    	{
        	echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
    	}
	}
	
	
	
	public function actionDynamic()
	{
	
        if(isset($_POST['MaVehicleRegistry']['Location_ID'])) //use the controler name of current page and valeu that pass from combo box
		{
			$ID =$_POST['MaVehicleRegistry']['Location_ID'];
		}	          
	
        $data=MaDriver::model()->findAll('Location_ID=:Location_ID', array(':Location_ID'=>$ID));
  
		$data=CHtml::listData($data,'Full_Name','Full_Name');
		
		echo CHtml::tag('option', array('value'=>''),CHtml::encode('--- Please Select ---'),true);
					   
		
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		} 
	}
	
	
	public function actionDynamicChange()
	{		
		echo CHtml::tag('option',array('value'=>''),CHtml::encode(' Please Select '),true);
	}
	
	
	public function actionCurrentLocation()
	{
		$string=trim($_GET['term']);
		if($string!='')
		{
			$model=  MaLocation::model()->findAll(array("condition"=>"Location_Name like '%$string%'"));
			$data=array();
			foreach($model as $get)
			{
				$data[]=$get->Location_Name;
			}
			$this->layout='empty';
			echo json_encode($data);
		}
	}
	
	
	
	
	public function actionLocation()
	{
		$string=trim($_GET['term']);
		if($string!='')
		{
			$model=  MaLocation::model()->findAll(array("condition"=>"Location_Name like '%$string%'"));
			$data=array();
			foreach($model as $get)
			{
				$data[]=$get->Location_Name;
			}
			$this->layout='empty';
			echo json_encode($data);
		}
	}
        
            public function actionBranch()
            {
               $string = trim($_GET['term']);
               if($string!='')
		{
			$model= MaBranch::model()->findAll(array("condition"=>"Branch like '%$string%'"));
			$data=array();
			foreach($model as $get)
			{
				$data[]=$get->Branch;
			}
			$this->layout='empty';
			echo json_encode($data);
		}
            }

}
