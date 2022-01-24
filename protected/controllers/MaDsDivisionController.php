<?php

class MaDsDivisionController extends Controller
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
					'actions'=>array($curr_action, 'delete','DynamicLocations'),
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
					'actions'=>array('DynamicDsDivisions','dsDivisions','DynamicLocations','UpdateDsDivision','Session4RemoveBtn','GetDsDivs'),
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
        if(isset(Yii::app()->session['maDsDivision']))
        {
            unset(Yii::app()->session['maDsDivision']);
        }  
        
        if(isset($_POST['dist']) && $_POST['dist']!='')
        {
            Yii::app()->session['selectedDistrict']=$_POST['dist'];
            
        }
        
        $model = new MaDsDivision;
        $this->layout = 'fancy_box_layout';

        if (isset($_POST['MaDsDivision'])) {
            $model->attributes = $_POST['MaDsDivision'];
            if ($model->save())
            {
                Yii::app()->session['maDsDivision'] = $model->DS_Division_ID;

                Yii::app()->user->setFlash('success', "Successfully Added..!");
            }

        }

        $this->render('_form', array(
            'model' => $model
        ));

    }


    public function actionUpdateDsDivision()
    {   
        if(isset(Yii::app()->session["RemoveBtnSession"]))
        {
            unset(Yii::app()->session["RemoveBtnSession"]);
        }
        
        if(isset(Yii::app()->session['selectedDistrict']))
        {
            unset(Yii::app()->session['selectedDistrict']);            
        }
        $dsDivID=0;
        if(isset(Yii::app()->session["maDsDivision"])&& Yii::app()->session["maDsDivision"] !='')
        {
            $dsDivID = Yii::app()->session["maDsDivision"];
            $lastInsertedDsDivArray = MaDsDivision::model()->getLastInsertedDsDiv($dsDivID);

            if(count($lastInsertedDsDivArray)>0)
            {
                $dsDivID = $lastInsertedDsDivArray[0]["DS_Division_ID"];
                $dsDiv = $lastInsertedDsDivArray[0]["DS_Division"];

                echo CHtml::tag('option',array('value'=>$dsDivID,
                        'selected'=>'selected'),
                    CHtml::encode($dsDiv ),true);
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
		$model=new MaDsDivision;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaDsDivision']))
		{
			$model->attributes=$_POST['MaDsDivision'];
			
			$valid = $model->validate();
			if($valid)
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Successfully Added..!");
					$this->redirect(array('view','id'=>$model->DS_Division_ID));
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

		if(isset($_POST['MaDsDivision']))
		{
			$model->attributes=$_POST['MaDsDivision'];
			$valid = $model->validate();
			if($valid)
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Successfully Updated..!");
					$this->redirect(array('view','id'=>$model->DS_Division_ID));
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
		$dataProvider=new CActiveDataProvider('MaDsDivision');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MaDsDivision('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaDsDivision']))
			$model->attributes=$_GET['MaDsDivision'];

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
		$model=MaDsDivision::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ma-ds-division-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	public function actionDynamicDsDivisions()
	{
		if(isset($_POST['MaDistrict']['District_ID'])){
			$ID =$_POST['MaDistrict']['District_ID'];
		}
		else if(isset($_POST['MaLocation']['District_ID']))
	   	{
			$ID =$_POST['MaLocation']['District_ID'];
		}	
		#$data=MaDsDivision::model()->findAll('District_ID=:District_ID', array(':District_ID'=>(int)$ID));
		$data = Yii::app()->db->createCommand('SELECT DS_Division_ID, DS_Division FROM ma_ds_division WHERE District_ID ="'.$ID.'" ORDER BY DS_Division ASC')->queryAll();
		$data=CHtml::listData($data,'DS_Division_ID','DS_Division');

	
		echo CHtml::tag('option',
		array('value'=>''),CHtml::encode('--- Please Select ---'),true);
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			array('value'=>$value),CHtml::encode($name),true);
		}
		
      //  if(isset($_POST['MaDistrict']['District_ID']))
//		{
//			$ID =$_POST['MaDistrict']['District_ID'];
//		}
//		
//		
//		
//		//==================================================================
//			  if(isset(Yii::app()->session['DS_Division_ID']) && !is_null(Yii::app()->session['DS_Division_ID']))	
//			  {
//				
//						$data=MaDsDivision::model()->findAll('DS_Division_ID=:DS_Division_ID', 
//							  array(':DS_Division_ID'=>(int)Yii::app()->session['DS_Division_ID']));
//			  }
//			   else
//			  {
//					  
//						$data=MaDsDivision::model()->findAll('District_ID=:District_ID', 
//							  array(':District_ID'=>(int)$ID));
//			  }
//	 
//		$data=CHtml::listData($data,'District_ID','District_Name');
//		
//		
//		echo CHtml::tag('option',
//					   array('value'=>''),CHtml::encode(' Please Select '),true);
//		foreach($data as $value=>$name)
//			{
//				echo CHtml::tag('option',
//						   array('value'=>$value),CHtml::encode($name),true);
//			}	
       }
	   
    public function actionDsDivisions()
    {
        $string=trim($_GET['term']);
        if($string!='')
        {
            $model=  MaDsDivision::model()->findAll(array("condition"=>"DS_Division like '%$string%'"));
            $data=array();
            foreach($model as $get)
            {
                $data[]=$get->DS_Division;
            }
            $this->layout='empty';
            echo json_encode($data);
        }
    }

    public function actionDynamicLocations()
    {
        if(isset($_POST['User']['District_ID'])){
            $ID =$_POST['User']['District_ID'];
        }
        else if(isset($_POST['MaLocation']['District_ID']))
        {
            $ID =$_POST['MaLocation']['District_ID'];
        }
        #$data=MaDsDivision::model()->findAll('District_ID=:District_ID', array(':District_ID'=>(int)$ID));
        $data = Yii::app()->db->createCommand('SELECT Location_ID, Location_Name FROM ma_location WHERE District_ID ="'.$ID.'" ORDER BY Location_Name ASC')->queryAll();
        $data=CHtml::listData($data,'Location_ID','Location_Name');


        echo CHtml::tag('option',
            array('value'=>''),CHtml::encode('--- Please Select ---'),true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
    }
    
     public function actionSession4RemoveBtn()
        {
            Yii::app()->session['RemoveBtnSession']="1";
        }
        
        public function actionGetDsDivs()
        {
            if(isset($_POST['dist']) && $_POST['dist'] !== '')
            {
                $dist = $_POST['dist'];
                $dsDivArr = MaDsDivision::model()->getDsDiv($dist);
                echo CJSON::encode($dsDivArr);
            }
        }

}
