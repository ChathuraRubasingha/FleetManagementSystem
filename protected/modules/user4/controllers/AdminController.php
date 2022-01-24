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
					'actions'=>array('view','delete', 'Make'),
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
        $superUser = Yii::app()->getModule("user")->user()->superuser;
        $locID = Yii::app()->getModule("user")->user()->Location_ID;
        $userID = Yii::app()->getModule("user")->user()->id;
        $role = Yii::app()->getModule("user")->user()->Role_ID;

        if($superUser == 0)
        {
            if($role == 1)
            {
                $criteria=new CDbCriteria;

                $criteria->compare('Location_ID',$locID);
                $criteria->compare('superuser',0);

                $dataProvider= new CActiveDataProvider('User', array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>Yii::app()->controller->module->user_page_size,

                    ),
                    'sort'=>array('defaultOrder'=>'username ASC')
                ));

                /*$dataProvider=new CActiveDataProvider('User', array(
                    'pagination'=>array(
                        'pageSize'=>Yii::app()->controller->module->user_page_size,

                    ),
                    'sort'=>array('defaultOrder'=>'username ASC')
                ));*/

            }
            else
            {
                $criteria=new CDbCriteria;

                $criteria->compare('id',$userID);

                $dataProvider= new CActiveDataProvider('User', array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>Yii::app()->controller->module->user_page_size,

                    ),
                    'sort'=>array('defaultOrder'=>'username ASC')
                ));
            }

        }
        else
        {
            $dataProvider=new CActiveDataProvider('User', array(
            'pagination'=>array(
                'pageSize'=>Yii::app()->controller->module->user_page_size,

            ),
            'sort'=>array('defaultOrder'=>'username ASC')
            ));

        }
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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
            if($model->validate()&&$profile->validate())
            {
                $model->password=Yii::app()->controller->module->encrypting($model->password);

                if($model->save())
                {
                    $profile->user_id=$model->id;
                    $profile->save();
                }
                Yii::app()->user->setFlash("success", "Successfully Added..!  <br/><br/>  Verify Permission of this user's role");
                $this->redirect(array('admin','id'=>$model->id));
            }
            else $profile->validate();
        }

        $this->render('create',array(
            'model'=>$model,
            'profile'=>$profile,

        ));

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
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
				$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) 
				{
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}
                $model->Branch_Id=$_POST['User']['Branch_Id'];

				$model->save();
				$profile->save();
				//Yii::app()->user->setFlash('success',"Successfully Updated..!");
				Yii::app()->user->setFlash("success", "Successfully Updated..!  <br/><br/>  Verify Permission of this user's role");
				
				$this->redirect(array('admin','id'=>$model->id));
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
	 */
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
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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