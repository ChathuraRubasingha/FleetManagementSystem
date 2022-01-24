<?php

class MaDriverController extends Controller
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
		//echo $access;exit;
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
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
					'actions'=>array('DynamicDrivers','driver','NICnumber','SaveImageTemporary','DestroyImageSession','RemoveImage','UpdateDriver'),
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
            if(isset(Yii::app()->session['maDriver']))
            {
                unset(Yii::app()->session['maDriver']);
            }
            $model = new MaDriver;
            $this->layout = 'fancy_box_layout';

            if (isset($_POST['MaDriver'])) {
                $model->attributes = $_POST['MaDriver'];
                if ($model->save())
                {
                    Yii::app()->session['maDriver'] = $model->Driver_ID;

                    Yii::app()->user->setFlash('success', "Successfully Added..!");
                }

            }

            $this->render('_form', array(
                'model' => $model
            ));

        }


    public function actionUpdateDriver()
    {
        $driverID = Yii::app()->session["maDriver"];
        $lastInsertedDriverArray = MaDriver::model()->getLastInsertedDriver($driverID);

        if(count($lastInsertedDriverArray)>0)
        {
            $driverID = $lastInsertedDriverArray[0]["Driver_ID"];
            $driverName = $lastInsertedDriverArray[0]["Full_Name"];

            echo CHtml::tag('option',array('value'=>$driverID,
                    'selected'=>'selected'),
                CHtml::encode($driverName ),true);
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

            $model=new MaDriver;

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['MaDriver']))
            {
                $rnd = rand(0,9999);  // 
                $model->attributes=$_POST['MaDriver'];

                $uploadedFile=CUploadedFile::getInstance($model,'Driver_Image'); 
                $fileName = "{$rnd}-{$uploadedFile}";   // random number + file name
                $model->Driver_Image = $fileName; 

                $valid = $model->validate();
                if($valid)
                {
                    if($model->save())
                    {
                        if(!empty($uploadedFile))  // check if uploaded file is set or not
                        {
                            $uploadedFile->saveAs(Yii::app()->basePath.'/../DriverImages/'.$fileName); 
                        }

                        Yii::app()->user->setFlash('success', "Successfully Added..!");
                        $this->redirect(array('view','id'=>$model->Driver_ID));
                    }
                }
                else
                {
                    Yii::app()->session['btnClick'] = "123";				
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

            $rnd = rand(0,9999);  // 
            $uploadedFile=CUploadedFile::getInstance($model,'Driver_Image');
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['MaDriver']))
            {
                $model->attributes=$_POST['MaDriver'];
                $valid = $model->validate();
                if($valid)
                {
                    if(!empty($uploadedFile))
                    {
                        $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
                        $model->Driver_Image = $fileName;
                    }
                    else
                    {
                        $model->Driver_Image=MaDriver::model()->findByPk($model->Driver_ID)->Driver_Image;
                    }			   
				
                    $_POST['MaDriver']['Driver_Image'] = $model->Driver_Image;
                    if(isset(Yii::app()->session['removeImage']) && Yii::app()->session['removeImage'] !='')
                    {
                        $model->Driver_Image = '1111-';
                        unset(Yii::app()->session['removeImage']);
                    }
                    if($model->save())
                    {
                        if(isset(Yii::app()->session['removeDriverImage']) && Yii::app()->session['removeDriverImage'] !=='')
                        {   
                            $model = new MaDriver();
                            $model->removeImage($id);
                        }
                        if(!empty($uploadedFile))  // check if uploaded file is set or not
                        {
                            $uploadedFile->saveAs(Yii::app()->basePath.'/../DriverImages/'.$fileName);
                        }					
                        Yii::app()->user->setFlash('success', "Successfully Updated..!");
                        $this->redirect(array('view','id'=>$id));
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
	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MaDriver');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MaDriver('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaDriver']))
			$model->attributes=$_GET['MaDriver'];

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
		$model=MaDriver::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ma-driver-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	/*public function actionDynamic()
	{
	
        if(isset($_POST['maVehicleRegistry']['Driver_ID'])) //use the controler name of current page and valeu that pass from combo box
		{
			$ID =$_POST['maVehicleRegistry']['Driver_ID'];
		}	          
	
        $data=ActivityToBoq::model()->findAll('Driver_ID=:Driver_ID', 
					  array(':Driver_ID'=>$ID));
  
		$data=CHtml::listData($data,'Full_Name','Full_Name');
		
		echo CHtml::tag('option',
					   array('values'=>''),CHtml::encode('---Please Select---'),true);
					   
		
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
					   array('value'=>$value),CHtml::encode($name),true);
		} 
	}*/
	public function actionDynamicDrivers()
	{
		if(isset($_POST['MaLocation']['Location_ID']))
		{
			$ID =$_POST['MaLocation']['Location_ID'];
		}
		else if(isset($_POST['MaDriver']['Location_ID']))
	   	{
			$ID =$_POST['MaDriver']['Location_ID'];
		}	
		else if(isset($_POST['TRVehicleLocation']['Location_ID']))
	   	{
			$ID =$_POST['TRVehicleLocation']['Location_ID'];
		}
		
		
		$data=MaDriver::model()->findAll('Location_ID=:Location_ID', array(':Location_ID'=>(int)$ID));
		$data=CHtml::listData($data,'Driver_ID','Full_Name');

	
		echo CHtml::tag('option',
		array('value'=>''),CHtml::encode('--- Please Select ---'),true);
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			array('value'=>$value),CHtml::encode($name),true);
		}
	}
	
	public function actionDriver()
	{
            $string=trim($_GET['term']);
            if($string!='')
            {
                $model=  MaDriver::model()->findAll(array("condition"=>"Full_Name like '%$string%'"));
                $data=array();
                foreach($model as $get)
                {
                    $data[]=$get->Full_Name;
                }
                $this->layout='empty';
                echo json_encode($data);
            }
	}
	

	public function actionNICnumber()
	{
		$string=trim($_GET['term']);
		if($string!='')
		{
			$model=  MaDriver::model()->findAll(array("condition"=>"NIC like '%$string%'"));
			$data=array();
			foreach($model as $get)
			{
				$data[]=$get->NIC;
			}
			$this->layout='empty';
			echo json_encode($data);
		}
	}
	
	public function actionSaveImageTemporary() 
	{
            if(isset(Yii::app()->session['removeDriverImage']))
            {
                unset(Yii::app()->session['removeDriverImage']);
            }
            
        $image = $_FILES['file'];
        $image_path = Yii::app()->basePath;
		
		if(isset(Yii::app()->session['removeImage']) && Yii::app()->session['removeImage'] !='')
		{
			unset(Yii::app()->session['removeImage']);
		}
		
        if (isset($_SESSION['selected_image'])) 
		{
            $old_image = $_SESSION['selected_image'];
            unlink($image_path . '/../tmp_images/' . $old_image);
        }

        $_SESSION['selected_image'] = $image['name'];

        move_uploaded_file($image['tmp_name'], $image_path . '/../tmp_images/' . $image['name']);
    }
	
	public function actionDestroyImageSession() {
        $image_path = Yii::app()->basePath;

        if ($handle = opendir($image_path . '/../tmp_images/')) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {
                $extension = pathinfo($entry, PATHINFO_EXTENSION);
                if ($extension == "jpg" || $extension == "png" || $extension == "gif" || $extension == "jpeg" || $extension == "bmp") {
                    unlink($image_path . "/../tmp_images/" . $entry);
                }
            }

            closedir($handle);
        }

        unset($_SESSION['selected_image']);
    }
	
	public function actionRemoveImage()
	{
		Yii::app()->session['removeImage']='removeImage';
		
		$model = new MaDriver();
		if(isset($_POST['dID']))
		{
			$dID = $_POST['dID'];
			
			if($dID ==='0')
			{
				echo 'no';
			}
			else
			{
                            Yii::app()->session['removeDriverImage']='ok';
                            echo 'deleted';
//				if($model->removeImage($dID))
//				{
//					echo 'deleted';
//				}
			}
		}
	}
	
}
