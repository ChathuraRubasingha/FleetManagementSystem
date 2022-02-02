<?php

class NotificationConfigurationController extends Controller {

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
     */
    public function accessRules() {
        $curr_controlername = $this->getUniqueId();
        $curr_action = Yii::app()->controller->action->id;
        $access = Yii::app()->user->GetPermission($curr_controlername, $curr_action);
//        var_dump($access);
//        die;
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array($currentUser),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);

        if ($access == 'true') {
            return array(
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions' => array($curr_action),
                    'users' => array(Yii::app()->user->name),
                ),
                array('deny', // deny all users
                    'users' => array('*'),
                ),
            );
        } else {
            return array(
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions' => array('view', 'delete', 'Canceled', 'reject', 'GetAvailableVehicles', 'get_available_drivers', 'GetServices', 'SetFlagOne','GetValue','GetDescription'),
                    'users' => array('*'),
                ),
                array('deny', // deny all users
                    'users' => array('*'),
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
        $model = new NotificationConfiguration;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['NotificationConfiguration'])) {
            $model->attributes = $_POST['NotificationConfiguration'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->Row));
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
        $criteria = new CDbCriteria();
        $criteria->select = "Value";

        $getResult = NotificationConfiguration::model();

		
		
        if (isset($_POST['NotificationConfiguration'])) {
            $model->attributes = $_POST['NotificationConfiguration'];
$valid = $model->validate();
			if($valid)
			{
				if ($model->Row == "1") 
				{
	
					if (($model->Value) >= "2") 
					{
	
						$difference_val = ($model->Value) - "1";
					} 
					else if ((($model->Value) - "2") > "1") 
					{
						$difference_val = ($model->Value) - "2";
					} 
					else 
					{
	
						$difference_val = ($model->Value);
					}
	
					$criteria = "Row = 2";
					$vdelayVal = $getResult->find($criteria);
	
	//                            var_dump($vdelayVal['Value']);
	//                            die;
	
					if (($model->Value) <= "1") 
					{
						Yii::app()->user->setFlash('success', "Short delay should be greater value than 1..!");
					} 
					else if (($model->Value) >= ($vdelayVal['Value'])) 
					{
						Yii::app()->user->setFlash('success', "Short delay should be lesser than current Critical delay " . $vdelayVal['Value'] . "..!");
					} 
					else if ((($vdelayVal['Value']) - ($model->Value)) <= "1") 
					{
						Yii::app()->user->setFlash('success', "Invalid date range suggested value " . $difference_val . "..!");
					} 
					else 
					{
	
						if ($model->save())
							;
						Yii::app()->user->setFlash('success', "Successfully Updated..!");
						$this->redirect(array('admin'));
					}
				}
				else if ($model->Row == "2") 
				{
	
					if (($model->Value) >= "2") 
					{
	
						$difference_val = ($model->Value) + "1";
					} 
					else if ((($model->Value) - "2") > "1") 
					{
						$difference_val = ($model->Value) + "2";
					} 
					else 
					{
	
						$difference_val = ($model->Value);
					}
	
					$criteria = "Row = 1";
					$sdelayVal = $getResult->find($criteria);
	
	//                            var_dump($vdelayVal['Value']);
	//                            die;
					if (($model->Value) <= "1") 
					{
						Yii::app()->user->setFlash('success', "Critical delay should be greater value than 1..!");
					} 
					else if (($model->Value) <= ($sdelayVal['Value'])) 
					{
						Yii::app()->user->setFlash('success', "Critical delay should be higher than current Short delay " . $sdelayVal['Value'] . "..!");
					} else if ((($model->Value) - ($sdelayVal['Value'])) <= "1") 
					{
						Yii::app()->user->setFlash('success', "Invalid date range suggested value " . $difference_val . "..!");
					} else 
					{
	
						if ($model->save())
							;
						Yii::app()->user->setFlash('success', "Successfully Updated..!");
						$this->redirect(array('admin'));
					}
				}
				else if ($model->Row == "3") 
				{
	
					if ($model->Value < "10") {
						
						Yii::app()->user->setFlash('success', "Alert execution time minimum value 10 seconds..!");
					} 
					else if ($model->Value > "60") 
					{
						Yii::app()->user->setFlash('success', "Alert execution time should be less than 1 minute ..!");
					} 
					else 
					{
	
						if ($model->save())
							;
						Yii::app()->user->setFlash('success', "Successfully Updated..!");
						$this->redirect(array('admin'));
					}
				}
				else if ($model->Row == "4") 
				{
					if ($model->save())
						;
					Yii::app()->user->setFlash('success', "Successfully Updated..!");
					$this->redirect(array('admin'));
				}
				else if ($model->Row == "5") 
				{
					if ($model->save())
						;
					Yii::app()->user->setFlash('success', "Successfully Updated..!");
					$this->redirect(array('admin'));
				}
				
			}
//                        var_dump($model->attributes);
//                        echo 'out';
//                        die;
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
        $dataProvider = new CActiveDataProvider('NotificationConfiguration');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new NotificationConfiguration('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['NotificationConfiguration']))
            $model->attributes = $_GET['NotificationConfiguration'];

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
        $model = NotificationConfiguration::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'notification-configuration-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
	
	public function actionReport() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/user/login'));
        } else {

            $this->render('report');
        }
    }
	
	public function actionManagement() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/user/login'));
        } else {
            $this->render('management');
        }
    }
    
    public function actionGetValue()
    {
        $str = trim($_GET['term']);
        if($str !='')
        {
            $model =NotificationConfiguration::model()->findAll(array("condition"=>"Value like '$$str%'"));
            $data = array();
            
            foreach ($model as $get)
            {
                $data[] = $get->Value;
            }
            $this->layout='empty';
            echo json_encode($data);
        }
    }
    
    public function actionGetDescription() 
    {
        $string = $_GET['term'];
        
        if($string !='')
        {
            $model = NotificationConfiguration::model()->findAll(array('condition'=>"Description like '%$string%'"));
            $data = array();
            
            foreach ($model as $get)
            {
                $data[] = $get->Description;
            }
            $this->layout ='empty';
            echo json_encode($data);
        }
    }

}
