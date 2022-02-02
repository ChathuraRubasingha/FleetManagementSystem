<?php

class AdminController extends Controller
{
	public $defaultAction = 'admin';
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
		
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','view'),
				'users'=>UserModule::getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} */
	
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
                        'actions'=>array('Make'),
                        'users'=>array('*'),
                    ),				
                    array('deny',  // deny all users
                        'users'=>array('*'),
                    ),		

                );

            }		
		
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            $model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
                
           
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
            $model = $this->loadModel();
            $this->render('view',array(
                    'model'=>$model,
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
        
        $profile=new Profile;
        $model=new User;

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];

            $model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
            $model->createtime=time();
            $model->lastvisit=time();
            $profile->attributes=$_POST['Profile'];
            //$model->username=$_POST['User']['username'];

           // $profile->user_id=0;
            if($model->validate())
            {
                if($profile->validate())
                {
                    if($model->save())
                    {                        
                        $password=Yii::app()->controller->module->encrypting($model->password); 
                        User::model()->updateByPk($model->id, array("password"=>$password));
                        
                        $profile->user_id=$model->id;
                        $profile->save();
                        Yii::app()->user->setFlash("success", "Successfully Added..!  <br/><br/>  Verify Permission of this user's role");
                        $this->redirect(array('admin','id'=>$model->id));
                        
                    }                    
                }
                Yii::app()->session['btnClick'] = "1";
            }
            else
            {
                Yii::app()->session['btnClick'] = "1";
                $profile->validate();
            }
        }

        $this->render('create',array(
            'model'=>$model,
            'profile'=>$profile,

        ));/**/
        //$this->redirect(array('admin','id'=>$model->id));

    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	/*public function actionUpdate()
	{
            if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
            {
                unset(Yii::app()->session['btnClick']);
            }

            $model=$this->loadModel();
            $profile=$model->profile;

            if(isset($_POST['User']))
            {
                $model->attributes=$_POST['User'];
                $profile->attributes=$_POST['Profile'];

                if($model->validate()) 
                {
                    if($profile->validate())
                    {
                        $model->Branch_Id=$_POST['User']['Branch_Id'];                        
                        
                        if($model->save())
                        {
                            $old_password = User::model()->notsafe()->findByPk($model->id);
                            if ($old_password->password !== $model->password) 
                            {                            
                                $password=Yii::app()->controller->module->encrypting($model->password);
                                $activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
                                
                                User::model()->updateByPk($model->id, array("password"=>$password, "activkey"=>$activkey));
                            }
                            $profile->save();
                            Yii::app()->user->setFlash("success", "Successfully Updated..!  <br/><br/>  Verify Permission of this user's role");
                            $this->redirect(array('admin','id'=>$model->id));
                        }
                        
                    }
                    else
                    {
                        Yii::app()->session['btnClick'] = "1";
                    }
                }
                else
                {
                    Yii::app()->session['btnClick'] = "1";
                    $profile->validate();
                }
            }

            $this->render('update',array(
                    'model'=>$model,
                    'profile'=>$profile,

            ));
	}*/
        
        
        public function actionUpdate()
	{
            $model=$this->loadModel();
            $profile=$model->profile;		
		
            if(isset($_POST['User']))
            {
                $model->attributes=$_POST['User'];
                $profile->attributes=$_POST['Profile'];
			
                if($model->validate()&&$profile->validate()) 
                {                    
                    $model->Branch_Id=$_POST['User']['Branch_Id'];

                    $old_password = User::model()->notsafe()->findByPk($model->id);
                    if($model->save())
                    {
                        
                        //echo $model->password;exit;
                        if($old_password->password!=$model->password) 
                        {
                            
                        $password=Yii::app()->controller->module->encrypting($model->password);
                            $activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
                            //echo $password;exit;
                            User::model()->updateByPk($model->id, array("password"=>$password, "activkey"=>$activkey));
                        }
                        $profile->save();
                        //Yii::app()->user->setFlash('success',"Successfully Updated..!");
                        Yii::app()->user->setFlash("success", "Successfully Updated..!  <br/><br/>  Verify Permission of this user's role");

                        $this->redirect(array('admin','id'=>$model->id));
                    }
                    
                }
                else $profile->validate();
            }

            $this->render('update',array(
                'model'=>$model,
                'profile'=>$profile,
			
            ));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 
	public function actionDelete()
	{
            if(Yii::app()->request->isPostRequest)
            {
                // we only allow deletion via POST request
                $model = $this->loadModel();
                $profile = Profile::model()->findByPk($model->id);
                $profile->delete();
                $model->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if(!isset($_POST['ajax']))
                    $this->redirect(array('/user/admin'));
            }
            else
            {
                Yii::app()->clientScript->registerScript('search', "
	alert('sdfsdf');
	");
            }
                //throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}*/
        
        public function actionDelete()
	{
            try
            {
                $model = $this->loadModel();
                $profile = Profile::model()->findByPk($model->id);
                $profile->delete();
                $model->delete();
                if(!isset($_GET['ajax']))
                {
                    echo '<script>

                        var bodyHeight = $("body").height();//- $("#header").height() + $("#footer").height();
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

                        var bodyHeight = $("body").height() ;//- $("#header").height() + $("#footer").height();
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
                        var bodyHeight = $("body").height(); //- $("#header").height() + $("#footer").height();
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
                        var bodyHeight = $("body").height(); //- $("#header").height() + $("#footer").height();
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
                $this->redirect(array('/user/admin'));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		
	
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
}