<?php

class MaVehicleRegistryController extends Controller
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
	 */
	/*public function accessRules()
	{

		//echo Yii::app()->user->name;die;
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','maintenanceRegistry','Maintanenceview','accident','accidentView','download','forms','requestService','newTyreTube','form01','edit','accidentHistory','fuelRequest','admin','VehicleAsign', 'VehicleNumber'),
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

	}
*/
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
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
					'actions'=>array('VehicleNumber','gridLocation','SaveImageTemporary','RemoveImage','OdoMeterUpdate','DashboardTotalAvailableVehicles'),
					'users'=>array('*'),
				),				
				array('deny',  // deny all users
					'users'=>array('*'),
				),		

			);

		}		
		
	}
	
	
	
	
	public function actionView($id)
	{
		/*Yii::app()->session['maintenVehicleId'] = $id;
		
		$modelFitness = new TRFitnessTest;
		$result = $modelFitness->getFitnessTestVehicles();
		
		$status = $result[0]['Fitness_test'];
		Yii::app()->session['fitnessStatus'] = $status;*/
		
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
        if(isset(Yii::app()->session['modelID']) && Yii::app()->session['modelID'] !='')
        {
            unset(Yii::app()->session['modelID']);
            unset(Yii::app()->session['makeID']);
        }
        if(isset(Yii::app()->session['makeID']) && Yii::app()->session['makeID'] !='')
        {
            unset(Yii::app()->session['modelID']);
            unset(Yii::app()->session['makeID']);
        }
        if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
        {
            unset(Yii::app()->session['btnClick']);
        }

        $user = Yii::app()->getModule('user')->user()->username;
        $superUserStatus = (Yii::app()->getModule('user')->user()->superuser);
        $loc = Yii::app()->getModule('user')->user()->Location_ID;
        $model=new MaVehicleRegistry;

        $makeYear = '';
        $purchaseDate = '';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
		
        if(isset($_POST['MaVehicleRegistry']))
        { 
            $rnd = rand(0,9999);  // 
            $model->attributes=$_POST['MaVehicleRegistry']; 

            $make = $model->Make_ID;
            $models = $model->Model_ID;
            $model->Registration_Fee = str_replace(',', '', $model->Registration_Fee);
            $model->Purchase_Value = str_replace(',', '', $model->Purchase_Value);
            Yii::app()->session['makeForAjax'] = $model->Make_ID;

            $uploadedFile=CUploadedFile::getInstance($model,'Vehicle_image'); 
            $fileName = "{$rnd}-{$uploadedFile}";   // random number + file name
            $model->Vehicle_image = $fileName;
				
				
            //$valid = $model->validate();
            if($model->validate())
            {
                //echo $uploadedFile; exit;
                $makeYear = $model->Make_Year;
                $date = MaVehicleRegistry::model()->getServerDate("date");
                $appDate =  MaVehicleRegistry::model()->getServerDate("dateTime");

                $purchaseDate = $model->Purchase_Date;
                if($superUserStatus !== '1')
                {
                    $model->Location_ID = $loc;
                }
		
                
                if($model->save())
                {
                    if($superUserStatus !== '1')
                    {
                        $modelVl = new TRVehicleLocation;

                        $modelVl->Location_ID = $loc;
                        $modelVl->Current_Location_ID = $loc;
                        $modelVl->Vehicle_No = $model->Vehicle_No;
                        $modelVl->From_Date = $date;
                        $modelVl->To_Date = '0000-00-00';
                        $modelVl->add_by = $user;
                        $modelVl->add_date = $appDate;

                        $modelVl->save();
                      
                    }

                    if(!empty($uploadedFile))  // check if uploaded file is set or not
                    {
                        $uploadedFile->saveAs(Yii::app()->basePath.'/../VechicleReg/'.$fileName);  // image will uplode to rootDirectory/banner/
                    }
                    
                    Yii::app()->user->setFlash('success', "Successfully Added..!");
                    $this->redirect(array('view','id'=>$model->Vehicle_No));
                }
            }
            else
            {

                Yii::app()->session['modelID'] = $models;
                Yii::app()->session['makeID'] = $make;
               

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
            
            if(isset(Yii::app()->session['modelID']) && Yii::app()->session['modelID'] !='')
            {
                unset(Yii::app()->session['modelID']);
                unset(Yii::app()->session['makeID']);
            }
            if(isset(Yii::app()->session['makeID']) && Yii::app()->session['makeID'] !='')
            {
                unset(Yii::app()->session['modelID']);
                unset(Yii::app()->session['makeID']);
            }
            if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
            {
                unset(Yii::app()->session['btnClick']);
            }
            
            $model=$this->loadModel($id);

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['MaVehicleRegistry']))
            {
                $vNum = $model->Vehicle_No;
                $model->attributes=$_POST['MaVehicleRegistry'];
                
                $model->Registration_Fee = str_replace(',', '', $model->Registration_Fee);
                $model->Purchase_Value = str_replace(',', '', $model->Purchase_Value);
                $makeYear = '';
                $purchaseDate = '';
                $rnd = rand(0,9999);  // 
                $uploadedFile=CUploadedFile::getInstance($model,'Vehicle_image');

                $valid = $model->validate();
                if($valid)
                {				
                    if(!empty($uploadedFile))
                    {
                        $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
                        $model->Vehicle_image = $fileName;
                    }
                    else
                    {
                        $model->Vehicle_image=MaVehicleRegistry::model()->findByPk($vNum)->Vehicle_image;
                    }
                    
                    $_POST['MaVehicleRegistry']['Vehicle_image'] = $model->Vehicle_image;
					
                    if(isset(Yii::app()->session['removeImage']) && Yii::app()->session['removeImage'] !='')
                    {
                        $model->Vehicle_image = '1111-';
                        unset(Yii::app()->session['removeImage']);
                    }
                    

                    $makeYear = $model->Make_Year;	
                    $appDate = date("Y-m-d : H:i:s", time());
                    $purchaseDate = $model->Purchase_Date=$_POST['MaVehicleRegistry']['Purchase_Date'];
				
	
                    if ($makeYear > $appDate)
                    {
                        Yii::app()->user->setFlash('success', "'Make Year' should be a previous year..!");
                    }
                    elseif ($purchaseDate > $appDate)
                    {
                        Yii::app()->user->setFlash('success', "'Purchase Date' should be a previous Date..!");
                    }
                    else
                    {
                        if($model->save())
                        {
                            if(!empty($uploadedFile))  // check if uploaded file is set or not
                            {
                                $uploadedFile->saveAs(Yii::app()->basePath.'/../VechicleReg/'.$fileName);
                            }
                                                
                            if(isset(Yii::app()->session['removeVehicleImage']) && Yii::app()->session['removeVehicleImage'] !=='')
                            {   
                                $model->removeImage($id);
                            }
                            
                            if (($makeYear <= $appDate) && ($purchaseDate <= $appDate))
                            {				
                                Yii::app()->user->setFlash('success', "Successfully Updated..!");
                                $this->redirect(array('view','id'=>$model->Vehicle_No));
                            }
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
		$dataProvider=new CActiveDataProvider('MaVehicleRegistry');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		if(Yii::app()->user->isGuest)
		{
	     	$this->redirect(array('/user/login'));
		}
		else
		{
			$model=new MaVehicleRegistry('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['MaVehicleRegistry']))
				$model->attributes=$_GET['MaVehicleRegistry'];

			$this->render('admin',array(
				'model'=>$model,
			));
		}
	}
        
        
        public function actionDashboardTotalAvailableVehicles()
	{
		if(Yii::app()->user->isGuest)
		{
                    $this->redirect(array('/user/login'));
		}
		else
		{
			$model=new MaVehicleRegistry('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['MaVehicleRegistry']))
				$model->attributes=$_GET['MaVehicleRegistry'];

			$this->render('admin',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=MaVehicleRegistry::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ma-vehicle-registry-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionforms()
	{
		$model=new MaVehicleRegistry();
		$this->render('forms',array(
			'model'=>$model,
		));
	}
	
	public function actionSessionset()
	{
		 
		$mke = $this->input->post('sendMake');
		
		Yii::app()->session['make'];
		  // $_SESSION['make'] = $mke;
		 

	}
		public function actionform01()
	{
		$model=new MaVehicleRegistry();
		$this->render('form01',array(
			'model'=>$model,
		));
	}
	public function actionrequestService()
	{
		$model=new MaVehicleRegistry();
		$this->render('requestService',array(
			'model'=>$model,
		));
	}
	public function actionnewTyreTube()
	{
		$model=new MaVehicleRegistry();
		$this->render('newTyreTube',array(
			'model'=>$model,
		));
	}
	public function actiondownload()
	{
		if(Yii::app()->user->isGuest)
		{
	     $this->redirect(array('/user/login'));
		}
		else
		{
		$model=new MaVehicleRegistry();
		$this->render('download',array(
			'model'=>$model,
		));
		}
	}
	
	public function actionmaintenanceRegistry()
	{
		if(Yii::app()->user->isGuest)
		{
			$this->redirect(array('/user/login'));
		}
		else
		{
		//$model=new MaVehicleRegistry();
		
		
			$model=new MaVehicleRegistry('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['MaVehicleRegistry']))
				$model->attributes=$_GET['MaVehicleRegistry'];

			$this->render('maintenanceRegistry',array(
				'model'=>$model,));
		}
	}
	
	public function actionMaintanenceview($id)
	{
		Yii::app()->session['maintenVehicleId'] = $id;
		
		$modelFitness = new TRFitnessTest;
		$result = $modelFitness->getFitnessTestVehicles();
		$count = count($result);
		if ($count != 0)
		{
			$status = $result[$count-1]['Fitness_test'];
		}
		else
		{
			$status = '';
		}
		
		Yii::app()->session['fitnessStatus'] = $status;
		
		//$model=new MaVehicleRegistry();
		$this->render('maintanenceview',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionAccident()
	{
            $model=new MaVehicleRegistry('searchVehicle');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['MaVehicleRegistry']))
				$model->attributes=$_GET['MaVehicleRegistry'];
			$this->render('accident',array(
			'model'=>$model,
		));
	}
	
	 protected function gridModel($data, $row)			
	 {		
		 $sql = 'select Model from ma_model m where m.Model_ID = "'.$data->Model_ID.'"';	
		 $rows = Yii::app()->db->createCommand($sql)->queryAll();	
		 	
		 	
      $result = '';			
       if(!empty($rows))			
        foreach ($rows as $row) 			
           {			
              /*$url = $this->createUrl('create',array('Model_ID'=>$row['Model']));			
              $result .= CHtml::link($row['Model'],$url) .'<br/>'; 	*/		
			  $result = $row['Model'];
       }      			
       return $result; 			
  		
	 }		


	public function actionedit()
	{
		if(Yii::app()->user->isGuest)
		{
	     $this->redirect(array('/user/login'));
		}
		else
		{
			$model=new MaVehicleRegistry();
			
			$model=new MaVehicleRegistry('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['MaVehicleRegistry']))
				$model->attributes=$_GET['MaVehicleRegistry'];
			
			
			
			$this->render('edit',array(
				'model'=>$model,
			));
		}
	}
	public function actionAccidentView($id)
	{
		//Yii::app()->session['accidentVehicleId'] = $id;
		
		//$model=new MaVehicleRegistry();
		$this->render('accidentView',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionAccidentHistory()
	{
		$model=new TRAccident();
		$this->render('accidentHistory',array(
			'model'=>$model,
		));
	}
	
	public function actionVehicleAsign()
	{
$model=new MaVehicleRegistry('getVehiclesLocationwise');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['MaVehicleRegistry']))
				$model->attributes=$_GET['MaVehicleRegistry'];
		$this->render('vehicleAsign',array(
			'model'=>$model,
		));
	}
	
	
	public function actionFuelRequest()
	{
		if(Yii::app()->user->isGuest)
		{
                $this->redirect(array('/user/login'));
		}
		else
		{
                $model=new MaVehicleRegistry('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['MaVehicleRegistry']))
				$model->attributes=$_GET['MaVehicleRegistry'];
		$this->render('fuelRequest',array(
			'model'=>$model,
		));
		}
	}
        
        public function actionOdoMeterUpdate()
	{
		if(Yii::app()->user->isGuest)
		{
                $this->redirect(array('/user/login'));
		}
		else
		{
                $model=new MaVehicleRegistry('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['MaVehicleRegistry']))
				$model->attributes=$_GET['MaVehicleRegistry'];
		$this->render('odoMeterUpdate',array(
			'model'=>$model,
		));
		}
	}
	
	protected function gridLocation($data, $row)
	{
		$arr = Yii::app()->db->createCommand('select l.Location_Name from vehicle_location vl inner join ma_location l ON l.Location_ID = vl.Current_Location_ID where vl.Vehicle_No ="'.$data->Vehicle_No.'"')->queryAll();
		
		$result ='';
		if(!empty($arr))
		foreach ($arr as $row)
		{
			$result = $row['Location_Name'];
		}
		return $result;
	}
	
	public function actionVehicleNumber()
	{
		$string=trim($_GET['term']);
		if($string!='')
		{
                    $condition = "Vehicle_No like '%$string%'";
                    
                    $superUser = yii::app()->getModule('user')->user()->superuser();
                    $loc = Yii::app()->getModule('user')->user()->Location_ID;
                   
                    if($superUser != '1')
                    {
                        $condition .= " and Location_ID = $loc";
                    }
                    
                    
                    
                    
			$model=  MaVehicleRegistry::model()->findAll(array("condition"=>$condition));
			$data=array();
			foreach($model as $get)
			{
				$data[]=$get->Vehicle_No;
			}
			$this->layout='empty';
			echo json_encode($data);
		}
	}
	
	 public function actionSaveImageTemporary() 
	 {
              if(isset(Yii::app()->session['removeVehicleImage']))
            {
                unset(Yii::app()->session['removeVehicleImage']);
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
		
		$model = new MaVehicleRegistry();
		if(isset($_POST['vNo']))
		{
			$vNo = $_POST['vNo'];
			
			if($vNo ==='0')
			{
				echo 'no';
			}
			else
			{
                            Yii::app()->session['removeVehicleImage']='ok';
                            echo 'deleted';
//				if($model->removeImage($vNo))
//				{
//					echo 'deleted';
//				}
			}
		}
	}
	
}
