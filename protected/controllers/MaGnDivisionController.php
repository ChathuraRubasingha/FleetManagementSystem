<?php

class MaGnDivisionController extends Controller
{
	/*
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/*
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
                        'actions'=>array('view','delete','DynamicProvincialCouncils','DynamicGnDivisions','gnDivisions','UpdateGnDivision'),
                        'users'=>array('*'),
                ),				
                array('deny',  // deny all users
                        'users'=>array('*'),
                ),		

            );

        }		

    }

	/*
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
        if(isset(Yii::app()->session['maGnDivision']))
        {
            unset(Yii::app()->session['maGnDivision']);
        }       
        
        if(isset($_POST['dsDiv']) && $_POST['dsDiv']!='')
        {
            Yii::app()->session['selectedDs']=$_POST['dsDiv'];
        }
       // var_dump($_POST[]);exit;
        $model = new MaGnDivision;
        $this->layout = 'fancy_box_layout';
       

        if (isset($_POST['MaGnDivision'])) 
        {
            $model->attributes = $_POST['MaGnDivision'];
            if ($model->save())
            {
                Yii::app()->session['maGnDivision'] = $model->GN_Division_ID;

                Yii::app()->user->setFlash('success', "Successfully Added..!");
            }
        }

        $this->render('_form', array(
            'model' => $model
        ));

    }


    public function actionUpdateGnDivision()
    {
        if(isset(Yii::app()->session["RemoveBtnSession"]))
        {
            unset(Yii::app()->session["RemoveBtnSession"]);
        }
        
        $gnDivID=0;
        if(isset(Yii::app()->session["maGnDivision"])&& Yii::app()->session["maGnDivision"] !='')
        {
            $gnDivID = Yii::app()->session["maGnDivision"];
            $lastInsertedGnDivArray = MaGnDivision::model()->getLastInsertedGnDiv($gnDivID);

            if(count($lastInsertedGnDivArray)>0)
            {
                $gnDivID = $lastInsertedGnDivArray[0]["GN_Division_ID"];
                $gnDiv = $lastInsertedGnDivArray[0]["GN_Division"];

                echo CHtml::tag('option',array('value'=>$gnDivID,
                        'selected'=>'selected'),
                    CHtml::encode($gnDiv ),true);
            }
        }

    }

	/*
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
		{
			unset(Yii::app()->session['btnClick']);
		}
		
		$model=new MaGnDivision;
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaGnDivision']))
		{
                    $model->attributes=$_POST['MaGnDivision'];

                    $valid = $model->validate();
                    if($valid)
                    {
                        if($model->save())
                        {
                                Yii::app()->user->setFlash('success', "Successfully Added..!");
                                $this->redirect(array('view','id'=>$model->GN_Division_ID));
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

	/*
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

		if(isset($_POST['MaGnDivision']))
		{
			$model->attributes=$_POST['MaGnDivision'];
			
			$valid = $model->validate();
			if($valid)
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Successfully Updated..!");
					$this->redirect(array('view','id'=>$model->GN_Division_ID));
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

	/*
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

	/*
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MaGnDivision');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/*
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MaGnDivision('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaGnDivision']))
			$model->attributes=$_GET['MaGnDivision'];

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
		$model=MaGnDivision::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ma-gn-division-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionDynamicProvincialCouncils()
    {   		
           
        if(isset($_POST['MaGnDivision']['District_ID'])){
			$ID =$_POST['MaGnDivision']['District_ID'];
			}
		
		else if(isset($_POST['Districts']['District_ID'])){
			$ID =$_POST['Districts']['District_ID'];
		}
				//  if(isset(Yii::app()->session['District_ID']) && !is_null(Yii::app()->session['District_ID']) )	
//				  {
//					
//					  $data=MaDistrict::model()->findAll('District_ID=:District_ID', 
//								  array(':District_ID'=>(int)Yii::app()->session['District_ID']));
//				  }
//				  else
//				  {
//						  
//							$data=MaProvincialCouncils::model()->findAll('Provincial_Councils_ID=:Provincial_Councils_ID', 
//								  array(':Provincial_Councils_ID'=>(int)$ID));
//				  }
//     
//  
//
//  
//		$data=CHtml::listData($data,'District_ID','District_Name');
//		//print_r($data);exit;
//		
//		//CHtml::listData('','GN_Division_ID','GN_Division_Name');
//		
//		echo CHtml::tag('option',
//					   array('values'=>''),CHtml::encode('-Please Select-'),true);
//					   
//		
//		foreach($data as $value=>$name)
//			{
//				echo CHtml::tag('option',
//						   array('value'=>$value),CHtml::encode($name),true);
//			} 



		 else
		  {
				  
					$data=MaGnDivision::model()->findAll('District_ID=:District_ID', 
						  array(':District_ID'=>(int)$ID));
		  }
     
 

  
		$data=CHtml::listData($data,'DS_Division_ID','DS_Division_Name');
		
		//CHtml::listData('','GN_Division_ID','GN_Division_Name');
		
		echo CHtml::tag('option',
					   array('value'=>''),CHtml::encode('--- Please Select ---'),true);
					   
		
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
					   array('value'=>$value),CHtml::encode($name),true);
		} 

   }
   
   
   
   public function actionDynamicGnDivisions()
	{
		if(isset($_POST['MaLocation']['DS_Division_ID'])){
			$ID =$_POST['MaLocation']['DS_Division_ID'];
		}
		else if(isset($_POST['MaDsDivision']['DS_Division_ID']))
	   	{
			$ID =$_POST['MaDsDivision']['DS_Division_ID'];
		}
		/*else if(isset($_POST['MaGnDivision']['GN_Division_ID']))	
		{
			$ID = $_POST['MaGnDivision']['GN_Division_ID'];
		}*/
		//$data=MaGnDivision::model()->findAll('DS_Division_ID=:DS_Division_ID', array(':DS_Division_ID'=>(int)$ID));
		$data = Yii::app()->db->createCommand('SELECT GN_Division_ID, GN_Division FROM ma_gn_division WHERE DS_Division_ID ="'.$ID.'" ORDER BY GN_Division ASC')->queryAll();
		$data=CHtml::listData($data,'GN_Division_ID','GN_Division');

	
		echo CHtml::tag('option',
		array('value'=>''),CHtml::encode('--- Please Select ---'),true);
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			array('value'=>$value),CHtml::encode($name),true);
		}
	}
   
   
   
   

   /*	public function actionDynamicGnDivisions()
    {
		  if(isset($_POST['MaDsDivision']['DS_Division_ID'])){
			$ID =$_POST['MaDsDivision']['DS_Division_ID'];
		}
		else if(isset($_POST['MaLocation']['DS_Division_ID']))
	   	{
			$ID =$_POST['MaLocation']['DS_Division_ID'];
		}
	 
		//$data=CHtml::listData($data,'GN_Division_ID','GN_Division_Name');
		
		$data=MaGnDivision::model()->findAll('DS_Division_ID=:DS_Division_ID', array(':DS_Division_ID'=>(int)$ID));
		$data=CHtml::listData($data,'GN_Division_ID','GN_Division');


		echo CHtml::tag('option',
					   array('values'=>''),CHtml::encode(' Please Select '),true);
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
					   array('value'=>$value),CHtml::encode($name),true);
		}*/
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
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
     //  }
	   
	   
	   
	   
	  public function actionGnDivisions()
	   {
		   $string=trim($_GET['term']);
			if($string!='')
			{
				$model=  MaGnDivision::model()->findAll(array("condition"=>"GN_Division like '%$string%'"));
				$data=array();
				foreach($model as $get)
				{
					$data[]=$get->GN_Division;
				}
				$this->layout='empty';
				echo json_encode($data);
			}
	   }
           
           
	   
	   
	   
}
