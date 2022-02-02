<?php

class VehicleTransferController extends Controller
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
                    'actions'=>array(''),
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
		
        $model=new VehicleTransfer;

        if(isset($_POST['VehicleTransfer']))
        {
            //$appDate = date("Y-m-d", time());
            $appDate = MaVehicleRegistry::model()->getServerDate('DateTime');
            $model->attributes=$_POST['VehicleTransfer'];

            $fromLoc = $model->From_Location_ID;                
            $vNo = $model->Vehicle_No;
            $location = $model->To_Location_ID;
            $frmDate = $model->From_Date;
            $toDate = $model->To_Date;				

            $valid = $model->validate();
            
            if($valid)
            {      					
                if($model->save())
                {
                    // get vehicle location id from vehicle_location table to update the current location of this vehicle
                    $vLocID = TRVehicleLocation::model()->findByAttributes(array('Vehicle_No'=>$model->Vehicle_No));
                    $updateVehicleLoc = TRVehicleLocation::model()->updateByPk($vLocID->Vehicle_Location_ID, array("Current_Location_ID"=>$location, "Driver_ID"=>NULL, 'Vehicle_No'=>"$vNo"));
                    $data=MaVehicleRegistry::model()->updateByPk($vNo, array('Location_ID'=>$location));
                        
//$cmd = "UPDATE vehicle_location SET Current_Location_ID = '".$location."', Driver_ID = NULL WHERE Vehicle_No='".$vNo."'";
                    //$raw = Yii::app()->db->createCommand($cmd)->execute();

                    $hasRec = "select vehicle_No from vehicle_transfer WHERE Vehicle_No='".$vNo."'";

                    $hasRecords = Yii::app()->db->createCommand($hasRec)->queryAll();
                    $countRec = count($hasRecords);
                    if($countRec > 1)
                    {
                        $frmDate = Yii::app()->db->createCommand("select From_Date from vehicle_transfer where Vehicle_No='".$vNo."' and VehicleTransfer_ID = (select max(VehicleTransfer_ID) FROM `vehicle_transfer`)")->queryAll();
                        $FrmDate = '';
                        if(count($frmDate) > 0)
                        {
                            $FrmDate = $frmDate[0]['From_Date'];
                            //echo $FrmDate; exit;
                        }
                        
                        $max = Yii::app()->db->createCommand('SELECT VehicleTransfer_ID FROM `vehicle_transfer` where Vehicle_No ="'.$vNo.'"')->queryAll();
                        $maxID = '';
                        $count =count($max);
                        if(!empty($max))
                        {
                            if($count>1)
                            {
                                $maxID = $max[$count-2]['VehicleTransfer_ID'];
                            }
                            $cmd = "UPDATE vehicle_transfer SET To_Date = '".$FrmDate."' WHERE Vehicle_No='".$vNo."'  and  VehicleTransfer_ID =".$maxID;
                            $raw = Yii::app()->db->createCommand($cmd)->execute();
                        }
                    }

                    Yii::app()->user->setFlash('success', "Successfully Transfered..!");
                    $this->redirect(array('view','id'=>$model->VehicleTransfer_ID));
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

        if(isset($_POST['VehicleTransfer']))
        {			
            $appDate = MaVehicleRegistry::model()->getServerDate('DateTime');
            $model->attributes=$_POST['VehicleTransfer'];
            		
            $valid = $model->validate();
            if($valid)
            {
                $vNo = $model->Vehicle_No;
                $location = $model->To_Location_ID;
                $frmDate = $model->From_Date;
                $toDate = $model->To_Date;
		
                if($model->save())
                {
                    $cmd = "UPDATE vehicle_location SET Current_Location_ID = '".$location."' WHERE Vehicle_No='".$vNo."'";
                    $raw = Yii::app()->db->createCommand($cmd)->execute();
                    $data=MaVehicleRegistry::model()->updateByPk($vNo, array('Location_ID'=>$location));
                    $hasRec = "select vehicle_No from vehicle_transfer WHERE Vehicle_No='".$vNo."'";

                    $hasRecords = Yii::app()->db->createCommand($hasRec)->queryAll();
                    $countRec = count($hasRecords);
                    if($countRec >1)
                    {
                        $frmDate = Yii::app()->db->createCommand("select From_Date from vehicle_transfer where Vehicle_No='".$vNo."' and VehicleTransfer_ID = (select max(VehicleTransfer_ID) FROM `vehicle_transfer`)")->queryAll();
                        $FrmDate = '';
                        if(count($frmDate)>0)
                        {
                            $FrmDate = $frmDate[0]['From_Date'];
                                //echo $FrmDate; exit;
                        }
                        //echo $vNo; exit;
                        $max = Yii::app()->db->createCommand('SELECT VehicleTransfer_ID FROM `vehicle_transfer` where Vehicle_No ="'.$vNo.'"')->queryAll();
                        $maxID = '';
                        $count =count($max);
                        if(!empty($max))
                        {
                            if($count>1)
                            {
                                $maxID = $max[$count-2]['VehicleTransfer_ID'];
                            }
                            $cmd = "UPDATE vehicle_transfer SET To_Date = '".$FrmDate."' WHERE Vehicle_No='".$vNo."'  and  VehicleTransfer_ID =".$maxID;
                            $raw = Yii::app()->db->createCommand($cmd)->execute();
                        }
                    }			
                    Yii::app()->user->setFlash('success', "Successfully Transfered..!");
                    $this->redirect(array('view','id'=>$model->VehicleTransfer_ID));
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
		$dataProvider=new CActiveDataProvider('VehicleTransfer');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VehicleTransfer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VehicleTransfer']))
			$model->attributes=$_GET['VehicleTransfer'];

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
		$model=VehicleTransfer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionLocationHistory()
	{
		$model=new VehicleTransfer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VehicleTransfer']))
			$model->attributes=$_GET['VehicleTransfer'];

		$this->render('locationHistory',array(
			'model'=>$model,
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vehicle-transfer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
