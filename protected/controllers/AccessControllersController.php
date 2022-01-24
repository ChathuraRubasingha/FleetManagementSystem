<?php

class AccessControllersController extends Controller
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
	
	public function accessRules()
	{

		//echo Yii::app()->user->name;die;
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','Assignpermission','getCreatetable','AccessControl','DisplayName'),
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
					'actions'=>array('view','delete','getCreatetable','AccessControl','DisplayName'),
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
		/**
	 * Created by Sasanka on 17/May/2013
	 * Performs to add all controllers and views to the database.	
	 * Use for access permissions
	 */

		$model=new AccessControllers;
			
		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		if(isset($_POST['AccessControllers']))
		{
			$controllers = array();
			$files = CFileHelper::findFiles(realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'controllers'));
			$totfiles=count($files);
			$controllerId=0;
			for($i=0;$i<$totfiles;$i++)
			{
				$controllers = array();
				$ControllerName1='';
				$filename=basename($files[$i], '.php');
				if( ($pos = strpos($filename, 'Controller')) > 0)
				{
					$controllers[] = substr($filename, 0, $pos);
				}	
				$count = count($controllers);
				if ($count > 0)
				{
					$ControllerName=$controllers[0];
					
					$ControllerName1='';
					if($ControllerName=='Access')
					{
						$ControllerName1='AccessControllers';
					}
					else if($ControllerName=='AccessPermission')
					{
						$ControllerName1='accessPermission';
					}
					else
					{
						$ControllerName1=$ControllerName;
					}

	 				$ControllerName1=strtolower($ControllerName1);

	 			//--add controllers names to db--

					$sqlcmd="select Controller_Name,ID from access_controllers where Controller_Name='".$ControllerName1."'";
					$result = Yii::app()->db->createCommand($sqlcmd)->queryAll(); 
					$cntID='';
					//print_r($result)	;die;
               
					if(count($result)== 0 )
					{
						$controllerId++;
						
						
						$query = "INSERT INTO access_controllers(Contoller_ID, Controller_Name) VALUES('".$controllerId."', '".$ControllerName1."') ";
						//$query = "INSERT INTO access_controllers(Controller_Name) VALUES ('".$ControllerName1."') ";							 	
						Yii::app()->db->createCommand($query)->execute();
	
						//--get the saved controller name from db--		
						
						$mycmd="select ID from access_controllers where Controller_Name='".$ControllerName1."'";				
						$contID = Yii::app()->db->createCommand($mycmd)->queryAll();
						$cntID=$contID[0]['ID'];
					}
					else
					{
						$cntID=$result[0]['ID'];
					}               

					$viewfiles = CFileHelper::findFiles(realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views'));
					$fullFile=realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views/'.$ControllerName1);	
					
					if(is_dir($fullFile))
					{
						//--directry exists----
						$Viewfiles = CFileHelper::findFiles($fullFile);
						$viewdirfilecnt=count($Viewfiles);
						
						for($a=0;$a<$viewdirfilecnt;$a++)
						{
							//---Get available views in the appropriate file--
							$views = array();
							$myViewfilename=basename($Viewfiles[$a], '.php');
							$myViewfilename=strtolower($myViewfilename);
							
							$sql="select action_id  from access_control_actions where controller_Id='".$cntID."' and action_name='".$myViewfilename."'";
							$res = Yii::app()->db->createCommand($sql)->queryAll();
							$res=count($res);
							if($res == 0)
							{						
								$query = "INSERT INTO access_control_actions(action_name,controller_Id ) VALUES ('".$myViewfilename."','".$cntID."') ";
								Yii::app()->db->createCommand($query)->execute();			 										
							}
						
						}
					
					}
					Yii::app()->user->setFlash('success', "Controllers and Actions successful updated!");
				}

			}

			$this->redirect(array('create'));
			}

			
		else
		{

			$this->render('create',array('model'=>$model,));
		}

	
}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccessControllers']))
		{
			$model->attributes=$_POST['AccessControllers'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->Contoller_ID));
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
				Yii::app()->user->setFlash('success','Successfully Deleted');
			else
				#echo "<div class='flash-success'>Successfully Deleted</div>";
				echo '<script>
				
				var height = $("body").height() /*- $("#header").height() + $("#footer").height()*/;
		$(".ontop").height(height);
		$("#Confirm").fadeIn(500);
			$("#popDiv").fadeIn(500);
</script>';
				
		}
		catch(CDbException $e)
		{
			if(!isset($_GET['ajax']))
				Yii::app()->user->setFlash('error','Sorry! You cannot delete this record');
			else
				#echo "<div class='flash-error'>Sorry! You cannot delete this record</div>"; //for ajax
				echo '<script>var height = $("body").height() /*- $("#header").height() + $("#footer").height()*/;
		$(".ontop").height(height);
	$("#errorConfirm").fadeIn(500);/**/
			$("#popDiv").fadeIn(500);
</script>';
		}
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		
	
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AccessControllers');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$modelrole=new role;
		$model=new AccessControllers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AccessControllers']))
			$model->attributes=$_GET['AccessControllers'];

		$this->render('admin',array(
			'model'=>$model,'modelrole'=>$modelrole
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AccessControllers::model()->findByPk($id);
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
            if(isset($_POST['ajax']) && $_POST['ajax']==='access-controllers-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
	
	
    public function actionAssignpermission()
	{
			date_default_timezone_set('Asia/Colombo');		
            $modelrole=new Role();
            $views= new AccessControlActions();	
            $model=new AccessControllers();		

            
            if((isset($_POST['Role']) && $_POST['Role'] !== "") && (isset($_POST['AccessControllers']) && $_POST['AccessControllers'] !== ""))
            {
               
                $Role_ID = $_POST['Role']['Role_ID'];
                $Module_ID = $_POST['AccessControllers']['Display_Name'];

                
                if(isset($_POST['action_id']) && count($_POST['action_id']) > 0)
                {
					
                   // var_dump("inside of if");exit;
                    $date = date('Y-m-d : H:i:s');
                    $actions = $_POST['action_id'];                    
//var_dump($Module_ID);exit;
                    $model = new AccessControllers();
                    if($model->saveAccessPermission($actions,$Role_ID, $Module_ID))
                    {
                        Yii::app()->user->setFlash('success',count($_POST['action_id']).' Controllers Permission on '. $date );
                    } 
                }
                else 
                {
                    $sql="select aur.* 
                    FROM `access_user_roll` aur
                    inner join access_control_actions aca on aca.action_id = aur.action_id 
                    where aca.Main_Module = '$Module_ID' and Role_ID = '$Role_ID'"; 
                    $rawData = Yii::app()->db->createCommand($sql)->queryAll();

                    foreach ($rawData as $ac)
                    {
                        $del = "delete from access_user_roll where ID = {$ac['ID']}";
                        $delData = Yii::app()->db->createCommand($del)->execute();
                    }	
                    Yii::app()->user->setFlash('success','Controllers Permission on '. date("Y-m-d : H:i:s", time()));
                }
            }
            $this->render('assignpermission',array(
                'model'=>$model,'modelrole'=>$modelrole,'views'=>$views,
            ));
	}
	
	
        public function actionDynamicDsDivisions()
        {   
            if(isset($_POST['MaLocation']['District_ID']))
            {
                $ID =$_POST['MaLocation']['District_ID'];
            }
            else if(isset($_POST['MaLocation']['District_ID']))
            {
                $ID =$_POST['MaLocation']['District_ID'];
            }
            
            if(isset(Yii::app()->session['DS_Division_ID']) && !is_null(Yii::app()->session['DS_Division_ID']) )	
            {
                $data=MaDsDivision::model()->findAll('DS_Division_ID=:DS_Division_ID', array(':DS_Division_ID'=>(int)Yii::app()->session['DS_Division_ID']));
            }
            else
            {
                $data=MaDsDivision::model()->findAll('District_ID=:District_ID', array(':District_ID'=>(int)$ID));
            }
            
            $data=CHtml::listData($data,'DS_Division_ID','DS_Division_Name');
            echo CHtml::tag('option', array('value'=>''),CHtml::encode('--- Please Select ---'),true);		   
		
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
            } 
        }
        
        public function actionDynamicGnDivisions()
        {
		
            if(isset($_POST['MaLocation']['DS_Division_ID']))
            {
                $ID =$_POST['MaLocation']['DS_Division_ID'];
            }
            else if(isset($_POST['MaLocation']['DS_Division_ID']))
            {
                $ID =$_POST['MaLocation']['DS_Division_ID'];
            }		
	
            if(isset(Yii::app()->session['GN_Division_ID']) && !is_null(Yii::app()->session['GN_Division_ID']))	
            {
                $data=MaGnDivision::model()->findAll('GN_Division_ID=:GN_Division_ID', array(':GN_Division_ID'=>(int)Yii::app()->session['GN_Division_ID']));
            }
            else
            {
                $data=MaGnDivision::model()->findAll('DS_Division_ID=:DS_Division_ID', array(':DS_Division_ID'=>(int)$ID));
            }
            
            $data=CHtml::listData($data,'GN_Division_ID','GN_Division_Name');
            echo CHtml::tag('option', array('value'=>''),CHtml::encode(' Please Select '),true);
            
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
            }				
        }

        public function actiongetCreatetable()
        {
            $rol = $_POST['rollId'];
            $materialIds = $_POST['materialId'];
            $table = new AccessControlActions();
            $array =$table->actionNews($materialIds,$rol);
            var_dump($array);exit;
            echo '<table width="550" style="background-color: #EBECED;  border: 4px solid #9A9A9A; border-bottom-left-radius:10px;                border-bottom-right-radius:10px; border-top-left-radius:10px; border-top-right-radius:10px;" >';
            echo '<tr>';
            //echo '<td align="center">Controller Display Name</td>';
            echo '<th style="line-height:2; width:400px; text-align:center;">Action Display Name</th>';
            echo '<th style="line-height:2; text-align:center;">Grant Access</th>';
            echo '</tr>';

            foreach($array as $t=>$k)
            {
                echo '<tr>';
                echo '<td style="padding:2px 0 2px 2px">'.CHtml::label($k['Action_Display_Name'],'', array('size'=>35)).'</td>';

                if($k['status']==1)
                {
                    echo'<td style="padding-left:50px;">'.CHtml::CheckBox('action_id[]','1', array ('value'=>$k['action_id'],));'</td>';
                }
                else
                {
                    echo'<td style="padding-left:50px;">'.CHtml::CheckBox('action_id[]','', array ('value'=>$k['action_id'],));'</td>';
                }
            
            }
            
            echo '</table>';

        }
         public function actionActionsTable()
        {
            if(isset($_POST["materialId"]) && $_POST["materialId"] !== "" && isset($_POST["rollId"]) && $_POST["rollId"] !== "")
            {
                $module_id = $_POST["materialId"];
                $role_id = $_POST["rollId"];
                
                $actionsArr = AccessControlActions::model()->findAll(array("condition"=>"Main_Module='$module_id'", "order"=>"Sub_Module ASC, Action_Display_Name ASC"));
                $actionsArrOrder = CHtml::listData($actionsArr, 'action_id', 'Action_Display_Name', 'Sub_Module');
                
//                $html = "<br/><br/>
////                <div style='min-width:100%;width:100%;'>".CHtml::label('Select/Deselect All', 'chkAllActions', array('style'=>'min-width:140px !important; width:140px !important;')).
//                        CHtml::CheckBox('check_all','', array ('id'=>'chkAllActions', 'style'=>'width:20px;'))."
//                </div>
//                     <br/><br/>       
               $html ="<table id='actionsTable'>";
                foreach ($actionsArrOrder as $key1 => $arr)
                {
                    $subModule = $key1;
                    $html .= "<tr>";
                    $html .= "<th colspan='3'>$subModule</th>";                    
                    $html .= "</tr>";
                    
                    $cmd = "select aur.action_id from access_user_roll aur
                        inner join access_control_actions aca on aca.action_id = aur.action_id
                        where aca.Sub_Module = '$subModule' and aur.Role_ID = '$role_id'";
                    $permissionArr = Yii::app()->db->createCommand($cmd)->queryAll();
                    
                    foreach ($arr as $action_id => $action_name)
                    {
                        $status = '0';
                        $exist = array_search($action_id, array_column($permissionArr, 'action_id'));
                        if($exist !== false)
                        {
                            $status = '1';
                        }
                       
                        $html .= "<tr>";
                        $html .= "<td style='width:50px'/>
                            <td style='width:400px;'>".CHtml::label($action_name, 'ac_'.$action_id,array('style'=>'min-width:100% !important; width:100% !important;'))."</td>
                            <td style='width:40px;'>".CHtml::CheckBox('action_id[]',$status, array ('value'=>$action_id, 'id'=>'ac_'.$action_id))."</td>";
                        $html .= "</tr>";
                    }
                    
                }
                $html .= "</table>";
//                $html .= "<br/><br/><div style='float:right; margin-right:200px;'>
//                            ". CHtml::submitButton('Save')." 
//                        </div>";
                echo $html;exit;
            }
        }
	
	public function actionAccessControl()
	{
            $string=trim($_GET['term']);
            if($string!='')
            {
                $model=  AccessControllers::model()->findAll(array("condition"=>"Controller_Name like '%$string%'"));
                $data=array();
                foreach($model as $get)
                {
                    $data[]=$get->Controller_Name;
                }
                $this->layout='empty';
                echo json_encode($data);
            }
	}
	
	public function actionDisplayName()
	{
            $string=trim($_GET['term']);
            if($string!='')
            {
                $model=  AccessControllers::model()->findAll(array("condition"=>"Display_Name like '%$string%'"));
                $data=array();
                foreach($model as $get)
                {
                    $data[]=$get->Display_Name;
                }
                $this->layout='empty';
                echo json_encode($data);
            }
	}
	
	
	
	
}
