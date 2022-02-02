<?php

class TRVehicleLocationController extends Controller
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
					'actions'=>array('GetBranch'),
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
	 
        protected function gridCategoryName($data, $row)
        {
             $sql = 'select Category_Name from ma_vehicle_category vc inner join ma_vehicle_registry vr ON vr.Vehicle_Category_ID = vc.Vehicle_Category_ID where vr.Vehicle_No = "'.$data->Vehicle_No.'"';
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
		 
		 
            $result = '';
            if(!empty($rows))
            {
                foreach ($rows as $row) 
                {
                    # $url = $this->createUrl('create',array('Vehicle_Category_ID'=>$row['Category_Name']));
                    #$result .= CHtml::link($row['Category_Name'],$url) .'<br/>'; 
                    $result = $row['Category_Name'];
                }  
            }
            return $result; 
  
        }
         
         
	public function actionCreate()
	{
            if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
            {
                unset(Yii::app()->session['btnClick']);
            }
	
            $model=new TRVehicleLocation;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

            if(isset($_POST['TRVehicleLocation']))
            {
                //var_dump($_POST['TRVehicleLocation']);exit;
                $model->attributes=$_POST['TRVehicleLocation'];

                $vehicleAllocationID =$model->Vehicle_Location_ID;
                $vehicleNo =$model->Vehicle_No;
               
                $model->Current_Location_ID = $model->Location_ID;
                 $model->Branch_Id =  intval($_POST['TRVehicleLocation']['Branch_Id'])==0?null:$_POST['TRVehicleLocation']['Branch_Id'];
                $valid = $model->validate();	
                
                if($valid)
                {
                    if($model->save())
                    {
                        $data=MaVehicleRegistry::model()->updateByPk($vehicleNo, array('Vehicle_Location'=>$model->Location_ID,'Vehicle_Allocation_ID'=>"$vehicleAllocationID"));
                        Yii::app()->user->setFlash('success', "Successfully Assigned..!");
                        $this->redirect(array('view','id'=>$model->Vehicle_Location_ID));
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

            if(isset($_POST['TRVehicleLocation']))
            {
                $model->attributes=$_POST['TRVehicleLocation'];
               
                $vehicleAllocationID =$model->Vehicle_Location_ID;
                $LocID = $model->Location_ID;
                $vehicleNo =$model->Vehicle_No;

                $model->Current_Location_ID = $model->Location_ID;
                $model->Branch_Id =  intval($_POST['TRVehicleLocation']['Branch_Id'])==0?null:$_POST['TRVehicleLocation']['Branch_Id'];
                
                $valid = $model->validate();	
                if($valid)
                {   
                    if($model->save())
                    {
                        $data=MaVehicleRegistry::model()->updateByPk($vehicleNo, array('Location_ID'=>$model->Location_ID,'Vehicle_Allocation_ID'=>"$vehicleAllocationID"));
                        Yii::app()->user->setFlash('success', "Successfully Assigned..!");
                        $this->redirect(array('view','id'=>$model->Vehicle_Location_ID));
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
		$dataProvider=new CActiveDataProvider('TRVehicleLocation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TRVehicleLocation('searchVehicles');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRVehicleLocation']))
			$model->attributes=$_GET['TRVehicleLocation'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/*protected function gridCategoryName($data, $row)
	{
		$sql = 'SELECT Category_Name FROM ma_vehicle_category vc INNER JOIN ma_vehicle_registry vr ON vr.Vehicle_Category_ID = vc.Vehicle_Category_ID WHERE vr.Vehicle_No ="'.$data->Vehicle_No.'"';
		$rowData = Yii::app()->db->createCommand($sql)->queryAll();
		
		$result = '';
		if(!empty($rowData))
		foreach ($rowData as $row)
		{
			$url = $this->createUrl('create', array('Vehicle_Category_ID'=>$row['Category_Name']));
			$result = CHtml::link($row['Category_Name'], $url).'<br/>';
		}
		return $result;
	}*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=TRVehicleLocation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


public function actionTransferVehicle()
	{
		$model=new TRVehicleLocation('transferVehicle');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRVehicleLocation']))
			$model->attributes=$_GET['TRVehicleLocation'];

		$this->render('transferVehicle',array(
			'model'=>$model,
		));
	}
	
	
	public function actionAssignedVehicles()
	{
		$model=new TRVehicleLocation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRVehicleLocation']))
			$model->attributes=$_GET['TRVehicleLocation'];

		$this->render('AssignedVehicles',array(
			'model'=>$model,
		));
	}
	
	public function actionNotAssignedVehicles()
	{
		$model=new TRVehicleLocation('getNotAssignedVehiclesLocationwise');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRVehicleLocation']))
			$model->attributes=$_GET['TRVehicleLocation'];

		$this->render('notAssignedVehicles',array(
			'model'=>$model,
		));
	}
	
	public function actionAssignedVehiclesForDriverHistory()
	{
		$model=new TRVehicleLocation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRVehicleLocation']))
			$model->attributes=$_GET['TRVehicleLocation'];

		$this->render('assignedVehiclesForDriverHistory',array(
			'model'=>$model,
		));
	}
	
	public function actionLocationAssignedVehicels()
	{
		$model=new TRVehicleLocation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRVehicleLocation']))
			$model->attributes=$_GET['TRVehicleLocation'];

		$this->render('locationAssignedVehicels',array(
			'model'=>$model,
		));
	}
	
	
	public function actionLocationHistory()
	{
		$model=new TRVehicleLocation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TRVehicleLocation']))
			$model->attributes=$_GET['TRVehicleLocation'];

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
		if(isset($_POST['ajax']) && $_POST['ajax']==='trvehicle-location-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionGetBranch()
        {
            $location_id = $_POST['location_id'];
			$branch_id = $_POST['branch_id'];
            $sql = "select  Branch_Id,Branch from ma_branch where Location_ID='$location_id'";
            $branchDetails = Yii::app()->db->createCommand($sql)->queryAll();
            $options = "<option>--- Please Select --- </option>";
            foreach ($branchDetails as $branch)
            {
				if($branch['Branch_Id']==$branch_id)
				{
					$options .= "<option value='".$branch['Branch_Id']."' selected='selected'>".$branch['Branch']."</option>";
				}
				else{
					$options .= "<option value='".$branch['Branch_Id']."'>".$branch['Branch']."</option>";
				}
            }
            echo $options;
            
        }
}
