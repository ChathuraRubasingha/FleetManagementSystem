<?php

class OdometerUpdateController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions

                'actions' => array('index', 'view', 'OdoMeterUpdate','CompletedOdo', 'vehicleListForOdometer'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }*/
	
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
					'actions'=>array('view','delete'),
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
		$vehicleId = Yii::app()->request->getQuery('id');

Yii::app()->session['OdoUpdateVehicle'] = $vehicleId;

        $userRole = Yii::app()->getModule('user')->user()->Role_ID;
        $sinhala = true;
        if (($userRole !== '3') && ($userRole !== '4')) {
            $sinhala = false;
        }
        if ($sinhala === true) {
//            $emptyOutOdo = "කරුණාකර 'පිටත් වන විට ඔඩොමීටර කියවීම (කි.මී)'  සම්පුර්ණ කරන්න ..!";
//            $outOdoLessThanCurrentOdo = "'පිටත් වන විට ඔඩෝමීටර කියවීම' නිවැරදි නැත ..!";
//
//            $emptyInOdo = "කරුණාකර 'ආපසු පැමිණි ඔඩෝමීටර කියවීම'  සම්පුර්ණ කරන්න (කි.මී)..!";
//            $inOdoLessThanOutOdo = "'පිටත් වන විට ඔඩෝමීටර කියවීම (කි.මී)'ට වඩා 'ආපසු පැමිණි ඔඩෝමීටර කියවීම (කි.මී)' වැඩි විය යුතුය.";
            $emptyOutOdo = "Please fill the out odo reading (km)..!";
            $outOdoLessThanCurrentOdo = "Out odo reading should be greater than current odo..!";

            $emptyInOdo = "Please fill the in odo reading..!";
            $inOdoLessThanOutOdo = "In odo reading should be greater than out odo reading..!";
        } else {
            $emptyOutOdo = "Please fill the out odo reading (km)..!";
            $outOdoLessThanCurrentOdo = "Out odo reading should be greater than current odo..!";

            $emptyInOdo = "Please fill the in odo reading..!";
            $inOdoLessThanOutOdo = "In odo reading should be greater than out odo reading..!";
        }
        $model = new OdometerUpdate;
        $vehicleId = Yii::app()->request->getQuery('id');
        $id = '';

        $ct = new CDbCriteria();
        $ct->condition = "out_time !='' AND out_odo_reading !='' AND in_time = '0000-00-00 00:00:00' AND in_odo_reading = '0' AND  Vehicle_No ='$vehicleId'";
        $ct->select = "max(update_id) as update_id";

        $odoUpdateId = OdometerUpdate::model()->find($ct);

//        var_dump($odoUpdateId['update_id']);
//        var_dump($vehicleId);

        if ((count($odoUpdateId) > 0)) {
            $id = $odoUpdateId['update_id'];
        }
        //  var_dump($id);
        if ($id !== null) {
            $model = $this->loadModel($id);
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OdometerUpdate'])) {
            $model->attributes = $_POST['OdometerUpdate'];
            $vArray = MaVehicleRegistry::model()->find("Vehicle_No ='$model->Vehicle_No'");
            $currentOdo = (int) $vArray['odometer'];
			
//            var_dump($currentOdo);
            //  if (empty($model->Vehicle_No) || (empty($model->Driver_ID) || (empty($model->remark_id)) || ((!empty($model->out_time)) && (empty($model->out_odo_reading))))) {
            if ($id !== null) {
                if ($model->in_odo_reading === '') {
                    Yii::app()->user->setFlash('success', $emptyInOdo);
                } else if (($model->in_odo_reading) <= ($model->out_odo_reading)) {

                    Yii::app()->user->setFlash('success', $inOdoLessThanOutOdo);
                } else {
                    if ($model->save())
                        $odoMeterDifference = ((int) $model->in_odo_reading - (int) $model->out_odo_reading);

                    $newOdo = (($currentOdo) + ($odoMeterDifference));
                    $result = MaVehicleRegistry::model()->updateByPk($model->Vehicle_No, array('odometer' => $newOdo));
                    Yii::app()->user->setFlash('success',"Successfully Added..!");
//					if (($userRole !== '3') && ($userRole !== '4'))
//					{
//						Yii::app()->user->setFlash('success',"Successfully Added..!");
//					} 
//					else 
//					{
//						Yii::app()->user->setFlash('success',"සාර්ථක ලෙස ගබඩා කරන ලදී..!");
//					}
                    $this->redirect(array('view', 'id' => $model->update_id,'vid'=>$model->Vehicle_No));
                }
            }
            else {
                if (empty($model->out_odo_reading)) {
                    Yii::app()->user->setFlash('success', $emptyOutOdo);
                } else if (((int) $model->out_odo_reading) < $currentOdo) {

                    Yii::app()->user->setFlash('success', $outOdoLessThanCurrentOdo);
                } else {
//                    die("c");
                    if ($model->save())
					{
                        Yii::app()->user->setFlash('success',"Successfully Added..!");
//					if (($userRole !== '3') && ($userRole !== '4'))
//					{
//						Yii::app()->user->setFlash('success',"Successfully Added..!");
//					} 
//					else 
//					{
//						Yii::app()->user->setFlash('success',"සාර්ථක ලෙස ගබඩා කරන ලදී..!");
//					}
					//echo $model->update_id;exit;
					$this->redirect(array('view', 'id' => $model->update_id, 'vid'=>$model->Vehicle_No));
					}
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OdometerUpdate'])) {
            $model->attributes = $_POST['OdometerUpdate'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->update_id));
        }

        $this->render('update', array(
            'model' => $model,
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
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('OdometerUpdate');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new OdometerUpdate('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OdometerUpdate']))
            $model->attributes = $_GET['OdometerUpdate'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = OdometerUpdate::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'odometer-update-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionOdoMeterUpdate() {

        $model = MaVehicleRegistry::model();
        $this->render('odoMeterUpdate', array('model' => $model));
        
    }

    public function actionCompletedOdo() {

        $model = new OdometerUpdate('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OdometerUpdate']))
            $model->attributes = $_GET['OdometerUpdate'];

        $this->render('completedOdo', array(
            'model' => $model,
        ));
    }
	
	public function actionVehicleListForOdometer()
	{
		
		
	$model = new MaVehicleRegistry('search');
	$modelVehicle = new OdometerUpdate();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MaVehicleRegistry']))
            $model->attributes = $_GET['MaVehicleRegistry'];

        $this->render('vehicleListForOdometer', array(
            'model' => $model,'modelVehicle'=>$modelVehicle
        ));
	}

}
