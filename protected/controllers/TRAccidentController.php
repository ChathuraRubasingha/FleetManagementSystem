<?php

class TRAccidentController extends Controller
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
                            'actions'=>array('GetAtype', 'AccidentPlace','DriverRating','gridLocation','SaveImageTemporary','DestroyImageSession','RemoveImage','DeleteImages'),
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
            //$accidentVNo = Yii::app()->request->getQuery('accidentVNo');
            //Yii::app()->session['accidentVNo'] = $accidentVNo;

            $this->render('view',array(
                    'model'=>$this->loadModel($id),
            ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
    public function actionCreate($vNo)
    {
        if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
        {
            unset(Yii::app()->session['btnClick']);
        }

        Yii::app()->session['accidentVehicleId'] = $vNo;
        $model=new TRAccident;
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['TRAccident']))
        {
            $rnd = rand(0,99999);  // 
            $model->attributes=$_POST['TRAccident'];
           
            
            $uploadedFile = CUploadedFile::getInstancesByName('files');
            
            ///$fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
            //$model->image = $fileName;

            $vehicleNo = $model->Vehicle_No;
            $appDate = MaVehicleRegistry::model()->getServerDate("dateTime");
            $AccPlace = $model->Accident_Place;
            $AccDate = $model->Date_and_Time;
           
            $dt = new DateTime($AccDate);

            $date = $dt->format('Y-m-d');
            $time = $dt->format('H:i:s');

            $preAccData = Yii::app()->db->createCommand("SELECT Accident_Place, Date_and_Time FROM `accident` where Vehicle_No ='".$vehicleNo."' and Date_and_Time Like '".$date."%'")->queryAll();

            $count = count($preAccData);
            $preAccPlace = '';
            $preAccDate = '';
            if($count>0)
            {
                $preAccPlace = $preAccData[0]['Accident_Place'];
                $preAccDate = $preAccData[0]['Date_and_Time'];

                $dt = new DateTime($preAccDate);
                $preAccDate = $dt->format('Y-m-d');
            }
            $odometerBeforeAccident = MaVehicleRegistry::model()->getOdometer($model->Vehicle_No);
            $model->Odometer_Before_Accident=$odometerBeforeAccident;
            if(($preAccPlace == $AccPlace ) && ($preAccDate == $date))
            {
                Yii::app()->session['btnClick'] = "1";
                Yii::app()->user->setFlash('success',"Accident Details are existed");
            }            
            else
            {
                $valid = $model->validate();
                if($valid)
                {
                    if($model->save())
                    {
                        $accID = $model->Accident_ID;
                        
                        if(count($uploadedFile) > 0)
                        {
                            foreach ($uploadedFile as $imageValue)
                            {
                                $fileName = $imageValue;
                                $fileName = str_replace(array(" ", "-", ":"), "_", $fileName);

                                $directory_path = "accidentImages/$vNo";
                                $directory_path2 = "accidentImages/$vNo/$accID";
                                if (!file_exists($directory_path)) 
                                {
                                    mkdir($directory_path);
                                }

                                if (!file_exists($directory_path2)) 
                                {
                                    mkdir($directory_path2);
                                }
                                if (file_exists($directory_path2)) 
                                {
                                    if (is_object($imageValue) && get_class($imageValue) === 'CUploadedFile') 
                                    {
                                        $basePath = Yii::app()->basePath. "/../$directory_path2/" . $fileName;
                                        $imageValue->saveAs($basePath);               
                                    } 
                                }                               

                            }
                        }
                        
                        Yii::app()->user->setFlash('success', "Successfully Added..!");
                        $this->redirect(array('view','id'=>$model->Accident_ID));

                    }
                }
                else
                {
                    Yii::app()->session['btnClick'] = "1";
                }
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
		
            Yii::app()->session['aid'] = $id;
            $model=$this->loadModel($id);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['TRAccident']))
            {
                $_POST['TRAccident']['image'] = $model->image;

                $model->attributes=$_POST['TRAccident'];
                $uploadedFile = CUploadedFile::getInstancesByName('files');
                $valid = $model->validate();
//echo count($uploadedFile);exit;
                $appDate = date("Y-m-d : H:i:s", time());
                $AccDate = $model->Date_and_Time;
                $dt = new DateTime($AccDate);

                $date = $dt->format('Y-m-d');
                $time = $dt->format('H:i:s');


                if($AccDate> $appDate)
                {
                    Yii::app()->session['btnClick'] = "1";
                    Yii::app()->user->setFlash('success',"'Date and Time' should be a previous date");
                }
                else
                {
                    if($valid)
                    {
                            
                        if($model->save())
                        {
                            $vNo = $model->Vehicle_No;
                            $accID = $model->Accident_ID;
                            if(count($uploadedFile) > 0)
                            { 
                                foreach ($uploadedFile as $imageValue)
                                {
                                    $fileName = $imageValue;
                                    $fileName = str_replace(array(" ", "-", ":"), "_", $fileName);

                                    $directory_path = "accidentImages/$vNo";
                                    $directory_path2 = "accidentImages/$vNo/$accID";
                                    if (!file_exists($directory_path)) 
                                    {
                                        mkdir($directory_path);
                                    }

                                    if (!file_exists($directory_path2)) 
                                    {
                                        mkdir($directory_path2);
                                    }
                                    
                                    if (file_exists($directory_path2)) 
                                    {
                                        if (is_object($imageValue) && get_class($imageValue) === 'CUploadedFile') 
                                        {
                                            $basePath = Yii::app()->basePath. "/../$directory_path2/" . $fileName;
                                            $imageValue->saveAs($basePath);               
                                        } 
                                    }                               

                                }
                            }

                           
                            $lstArrayRatingUpdate = TRAccident::model()->get_Rating_In_Accident(Yii::app()->session['aid']);
                            $GetRatingUpdate = $lstArrayRatingUpdate[0]['Driver_Rating'];

                            //$lstArrayRatingUpdate = TRAccident::model()->get_Rating_In_Accident(Yii::app()->session['aid']);
                            //$GetRatingUpdate = $lstArrayRatingUpdate[0]['Damage_Rating'];

                            $lstArray = TRAccident::model()->get_Current_Driver_Rating($model->Driver_ID);
                            $GetCurrentRating = $lstArray[0]['Rating'];

                            $EnteredRating = $model->Driver_Rating;
                            //echo $EnteredRating . " - " . $GetRatingUpdate , exit;

                            //if($EnteredRating != $GetRatingUpdate)
                            //{
                            //$CalculateRating = $GetCurrentRating - ($GetRatingUpdate - $EnteredRating);
                                    $data = "UPDATE driver_rating SET Rating =".$EnteredRating." WHERE Accident_ID = ".$id."";
                                    $rawData = Yii::app()->db->createCommand($data)->execute();
                            //}			
                            //$Acc_type =$model->Accident_Type;
//				
//				
//				$data = "UPDATE ma_driver SET Rating = 1 WHERE Driver_ID = ".$requestId." ";
//					$rawData = Yii::app()->db->createCommand($data)->execute();

                            Yii::app()->user->setFlash('success', "Successfully Updated..!");
                            $this->redirect(array('view','id'=>$model->Accident_ID));
                        }
                    }
                    else
                    {
                        Yii::app()->session['btnClick'] = "1";
                    }
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
            $dataProvider=new CActiveDataProvider('TRAccident');
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
            ));
		
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
        {
            $model=new TRAccident('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['TRAccident']))
            {
                $model->attributes=$_GET['TRAccident'];
            }

            $this->render('admin',array(
                    'model'=>$model,
            ));
	}
	
	public function actionAccidentHistory()
	{
            if(Yii::app()->user->isGuest)
            {
                $this->redirect(array('/user/login'));
            }
            else
            {
		$model=new TRAccident('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRAccident']))
                {
                    $model->attributes=$_GET['TRAccident'];
                }

		$this->render('accidentHistory',array(
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
            $model=TRAccident::model()->findByPk($id);
            if($model===null)
            {
                throw new CHttpException(404,'The requested page does not exist.');
            }
            return $model;
	}
	
	public function actionEstimateAccident()
	{
            $model=new TRAccident('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['TRAccident']))
            {
                $model->attributes=$_GET['TRAccident'];
            }

            $this->render('estimateAccident',array(
                    'model'=>$model,
            ));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
            if(isset($_POST['ajax']) && $_POST['ajax']==='traccident-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
	
	public function actionDriverRating()
        {
            if(isset($_POST['TRAccident']['Accident_Type']))
            {
                   $ID =$_POST['TRAccident']['Accident_Type'];
                   echo $ID; exit;
            }
            //$Arr=GnDivisions::model()->searchGNNumber($ID);
            //	echo CHtml::tag('input', array('value' => $Arr[0]['GN_Division_Number'],'readonly'=>true));
            echo CHtml::tag('input', array('value' => 'test','readonly'=>true));

	}
	
	
	public function actionGetAtype()
        {

            $typeAc= $_POST['typeA'];

		//print_r($_POST); exit;
		//$query = "SELECT Material_Name FROM material WHERE Material_Id = '".$materialId."'";
		//$dataArray = Yii::app()->db->createCommand($query)->query();
		//$Rate = $dataArray->readAll();

		//print_r($Rate); exit;

            if ($typeAc=='Major')
            {
                $rate = '-2';
                echo $rate;			
            }
            else
            {
                $rate = '-1';
                echo $rate;
            }

	}
	
	protected function gridLocation($data, $row)
	{
            $array = Yii::app()->db->createCommand('select l.Location_Name from vehicle_location vl inner join ma_location l ON l.Location_ID = vl.Current_Location_ID where vl.Vehicle_No ="'.$data->Vehicle_No.'"')->queryAll();

            $result ='';
            if(!empty ($array))
            {
                foreach ($array as $row)
                {
                    $result = $row['Location_Name'];
                }
            }
            return $result;
	}
	
	public function actionAccidentPlace()
	{
            $string=trim($_GET['term']);
            if($string!='')
            {
                $model=  TRAccident::model()->findAll(array("condition"=>"Accident_Place like '%$string%'"));
                $data=array();
                foreach($model as $get)
                {
                        $data[]=$get->Accident_Place;
                }
                $this->layout='empty';
                echo json_encode($data);
            }
	}
	
	public function actionSaveImageTemporary() 
        {
            
            if(isset(Yii::app()->session['removeAccedentImage']))
            {
                unset(Yii::app()->session['removeAccedentImage']);
            }
            
            $image = $_FILES['file'];
            $image_path = Yii::app()->basePath;
        
            if (isset($_SESSION['selected_image'])) 
            {
                $old_image = $_SESSION['selected_image'];
                unlink($image_path . '/../tmp_images/' . $old_image);
            }

            $_SESSION['selected_image'] = $image['name'];

            move_uploaded_file($image['tmp_name'], $image_path . '/../tmp_images/' . $image['name']);
        }
	
	public function actionDestroyImageSession() 
        {
            $image_path = Yii::app()->basePath;

            if ($handle = opendir($image_path . '/../tmp_images/')) 
            {
                while (false !== ($entry = readdir($handle))) 
                {
                    $extension = pathinfo($entry, PATHINFO_EXTENSION);
                    if ($extension == "jpg" || $extension == "png" || $extension == "gif" || $extension == "jpeg" || $extension == "bmp") 
                    {
                        unlink($image_path . "/../tmp_images/" . $entry);
                    }
                }
                closedir($handle);
            }
            unset($_SESSION['selected_image']);
        }
	
	public function actionRemoveImage()
	{
            $model = new TRAccident();
            if(isset($_POST['accID']))
            {
                $accID = $_POST['accID'];
              
                if($accID ==='0')
                {
                    echo 'no';
                }
                else
                {
                    Yii::app()->session['removeAccedentImage']='ok';
                    echo 'deleted';
//                  if($model->removeImage($accID))
//                  {
//			echo 'deleted';
//                  }
                }
            }
	}
        
        public function actionDeleteImages() 
        {
            $image_path = $_POST['image_path'];
            unlink($image_path);
        }
	
}
