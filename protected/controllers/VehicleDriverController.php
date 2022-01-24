<?php

class VehicleDriverController extends Controller
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
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','admin','DynamicDriverForBooking','create2','driverHistory'),
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
                            'actions'=>array('view','delete','gridDriverName','DynamicDriverForBooking','gridCategoryName'),
                            'users'=>array('admin'),
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
		
            $model=new VehicleDriver;
		
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['VehicleDriver']))
            {
                $model->attributes=$_POST['VehicleDriver'];

                $driver = $model->Driver_ID;
                $loc = $model->Location_ID;
                $frmDate = $model->From_Date;
                $toDate = $model->To_Date;
                $vNo = $model->Vehicle_No;
                $vehicleDriver = 0;
                $data = Yii::app()->db->createCommand('select Location_ID from ma_location where Location_Name="'.$loc.'"')->queryAll();
                $count = count($data);
                if(!empty($count))
                {
                    $model->Location_ID = $data[$count-1]['Location_ID'];
                }
                else
                {
                    $model->Location_ID = '';
                }
			
                $valid = $model->validate();	
                if($valid)
                {
                    $vDrData = Yii::app()->db->createCommand('select vd.Driver_ID, d.Full_Name, vd.From_Date from vehicle_driver vd
inner join ma_driver d on d.Driver_ID = vd.Driver_ID where vd.Driver_ID ='.$driver)->queryAll();
                    $driverName = '';
                    if(!empty($vDrData))
                    {
                        $count = count($vDrData);
                        $driverName = $vDrData[$count-1]['Full_Name'];
                        $vehicleDriver = $vDrData[ $count- 1]['Driver_ID'];
                        $driverFromDate = $vDrData[$count- 1]['From_Date'];
					
                    }
                    if(!empty($vDrData) && (($vehicleDriver == $driver)&& ($driverFromDate == $frmDate)))
                    #if (($vehicleDriver == $driver)&& ($driverFromDate == $frmDate))
                    {
                            Yii::app()->user->setFlash('success',$driverName." is already assign to a vehicle From ".$frmDate.".");
                    }
                    else
                    {
                        if  (($toDate == ''))
                        {
                            $isAssigned = Yii::app()->db->createCommand('select vehicle_no, driver_id from vehicle_driver where driver_id ='.$driver)->queryAll();
                            if($model->save())
                            {			
                                $count = count($isAssigned);
                                if($count>0)
                                {
								
                                    $isAssignedDriver = $isAssigned[$count-1]['driver_id'];
                                    $vehicleNo = $isAssigned[$count-1]['vehicle_no'];

                                    $AssigendDriverName = Yii::app()->db->createCommand('select Full_Name from ma_driver where Driver_ID ='.$isAssignedDriver)->queryAll();
                                    $AssigendDriverName = $AssigendDriverName[0]['Full_Name'];
                                    //echo $vehicleNo; exit;
                                    Yii::app()->user->setFlash('success',$AssigendDriverName." was assigned to ".$vehicleNo);
                                }
                                else if ($driverName != '')
                                {
                                    Yii::app()->user->setFlash('success', $driverName." is already assigned to this vehicle from ".$driverFromDate.".");
                                }

                                else
                                {
                                    Yii::app()->user->setFlash('success', "Successfully Assigned..!");
                                }
                                Yii::app()->db->createCommand('update vehicle_location set Driver_ID ='.$driver.' where vehicle_No ="'.$vNo.'"')->execute();
				
                                $this->redirect(array('view','id'=>$model->Driver_Allocation_ID));
                            }
                        }								
                        else if (($toDate != '')&&  ($frmDate < $toDate))
                        {
                            $isAssigned = Yii::app()->db->createCommand('select vehicle_no, driver_id from vehicle_driver where driver_id ='.$driver)->queryAll();
                            $count = count($isAssigned);
                            if($count>0)
                            {
                                $isAssignedDriver = $isAssigned[0]['driver_id'];
                                $vehicleNo = $isAssigned[0]['vehicle_no'];

                                Yii::app()->user->setFlash('success',$isAssignedDriver." had been assigned to ".$vehicleNo);
                            }

                            if($model->save())
                            {
                                Yii::app()->db->createCommand('update vehicle_location set Driver_ID ='.$driver.' where vehicle_No ="'.$vNo.'"')->execute();
                                Yii::app()->user->setFlash('success', "Successfully Assigned..!");
                                $this->redirect(array('view','id'=>$model->Driver_Allocation_ID));
                            }
                        }
                        else
                        {
                            Yii::app()->user->setFlash('success', "'To Date' should not be a previous date. Please select a valid 'To Date'..!");
                        }		
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
	
	
	
	public function actioncreate2()
	{
		date_default_timezone_set("Asia/Colombo");
            $model=new VehicleDriver;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            $vNo = $_POST['vNo'];
            $loc = $_POST['loc'];
            $frmDate = $_POST['frmDate'];
            $toDate = $_POST['toDate'];
            $driver = $_POST['driver'];

            $locArr = Yii::app()->db->createCommand('select Location_ID from ma_location where Location_Name ="'.$loc.'"')->queryAll();
            if(count($locArr)>0)
            {
                $loc= $locArr[0]['Location_ID'];
            }
            else
            {
                $loc='';
            }
            $curUser = Yii::app()->getModule('user')->user()->username;
            $appDate = date("Y-m-d : H:i:s", time());
		//$model->attributes=$_POST['VehicleDriver'];
		
            if($toDate == '')
            {
                Yii::app()->getClientScript()->registerScript("confirm", "alert('Success');");
                Yii::app()->db->createCommand("insert into vehicle_driver set Vehicle_No = '".$vNo."', `Location_ID`='$loc', `Driver_ID`='$driver', `From_Date`='$frmDate', `To_Date`='$toDate', `add_by`='".$curUser."', `add_date`='".$appDate."', `edit_by`='Not Edited',`edit_date`='Not Edited'")->execute();
            }
            else if (($toDate != '')&&  ($frmDate < $toDate))
            {
                Yii::app()->getClientScript()->registerScript("confirm", "alert('Success');");
                Yii::app()->db->createCommand("insert into vehicle_driver set Vehicle_No = '".$vNo."', `Location_ID`='$loc', `Driver_ID`='$driver', `From_Date`='$frmDate', `To_Date`='$toDate', `add_by`='".$curUser."', `add_date`='".$appDate."', `edit_by`='Not Edited',`edit_date`='Not Edited'")->execute();
              
            }
            else
            {
                    Yii::app()->getClientScript()->registerScript("confirm",    "alert('Success');");
                    //Yii::app()->user->setFlash('success', "'To Date' should not be a previous date. Please select a valid 'To Date'..!");
            }
		
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

            if(isset($_POST['VehicleDriver']))
            {
                $model->attributes=$_POST['VehicleDriver'];


                $driver = $model->Driver_ID;
                $loc = $model->Location_ID;
                $frmDate = $model->From_Date;
                $toDate = $model->To_Date;
                $vNo = $model->Vehicle_No;
                $vehicleDriver = 0;
                $data = Yii::app()->db->createCommand('select Location_ID from ma_location where Location_Name="'.$loc.'"')->queryAll();
                $count = count($data);
                if(!empty($count))
                {
                    $model->Location_ID = $data[$count-1]['Location_ID'];
                }
                else
                {
                    $model->Location_ID = '';
                }			
			
                $valid = $model->validate();	
                if($valid)
                {

                    #$vehicleDriverData = Yii::app()->db->createCommand('select Driver_ID, From_Date from vehicle_driver where Vehicle_No="'.$vNo.'"')->queryAll();
                    $vDrData = Yii::app()->db->createCommand('select Driver_ID, From_Date from vehicle_driver where Driver_ID ='.$driver)->queryAll();
                    $driverName = '';
                    if(!empty($vDrData))
                    {
                        $count = count($vDrData);
                        $vehicleDriver = $vDrData[ $count- 1]['Driver_ID'];
                        $driverFromDate = $vDrData[$count- 1]['From_Date'];

                        $rowDataDrvName = Yii::app()->db->createCommand('select Full_Name from ma_driver where Driver_ID="'.$vehicleDriver.'"')->queryAll();
                        $count = count($rowDataDrvName);
                        if(!empty($count))
                        {
                            $driverName = $rowDataDrvName[$count-1]['Full_Name'];
                        }
                    }
                    if(!empty($vDrData) && (($vehicleDriver == $driver)&& ($driverFromDate == $frmDate)) && ($toDate ==''))
                    #if (($vehicleDriver == $driver)&& ($driverFromDate == $frmDate))
                    {
                        Yii::app()->user->setFlash('success',$driverName." is already assign to a vehicle From ".$frmDate.".");
                    }
                    else
                    {
                        if  (($toDate == '') || ($toDate =='0000-00-00'))
                        {
                            $isAssigned = Yii::app()->db->createCommand('select vehicle_no, driver_id from vehicle_driver where driver_id ='.$driver)->queryAll();
                            if($model->save())
                            {							
                                $count = count($isAssigned);
                                if($count>0)
                                {
                                    $isAssignedDriver = $isAssigned[$count-1]['driver_id'];
                                    $vehicleNo = $isAssigned[$count-1]['vehicle_no'];

                                    $AssigendDriverName = Yii::app()->db->createCommand('select Full_Name from ma_driver where Driver_ID ='.$isAssignedDriver)->queryAll();
                                    $AssigendDriverName = $AssigendDriverName[0]['Full_Name'];
                                    //echo $vehicleNo; exit;
                                    Yii::app()->user->setFlash('success',$AssigendDriverName." was assigned to ".$vehicleNo);
                                }

                                else if ($driverName != '')
                                {
                                        //Yii::app()->user->setFlash('success', $driverName." is already assigned to this vehicle from ".$driverFromDate.".");
                                }
							
                                else
                                {
                                    Yii::app()->user->setFlash('success', "Successfully Assigned..!");
                                }
                                Yii::app()->db->createCommand('update vehicle_location set Driver_ID ='.$driver.' where vehicle_No ="'.$vNo.'"')->execute();
				$this->redirect(array('view','id'=>$model->Driver_Allocation_ID));
                            }
                        }								
                        else if (($toDate != '' || $toDate =='0000-00-00')&&  ($frmDate < $toDate))
                        {
                            $isAssigned = Yii::app()->db->createCommand('select vehicle_no, driver_id from vehicle_driver where driver_id ='.$driver)->queryAll();
                            $count = count($isAssigned);
                            if($count>0)
                            {
                                $isAssignedDriver = $isAssigned[0]['driver_id'];
                                $vehicleNo = $isAssigned[0]['vehicle_no'];

                                Yii::app()->user->setFlash('success',$isAssignedDriver." was assigned to ".$vehicleNo);
                            }

                            if($model->save())
                            {
                                Yii::app()->db->createCommand('update vehicle_location set Driver_ID ='.$driver.' where vehicle_No ="'.$vNo.'"')->execute();
                                Yii::app()->user->setFlash('success', "Successfully Assigned..!");
                                $this->redirect(array('view','id'=>$model->Driver_Allocation_ID));
                            }
                        }
                        else
                        {
                            Yii::app()->user->setFlash('success', "'To Date' should not be a previous date. Please select a valid 'To Date'..!");
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
            $dataProvider=new CActiveDataProvider('VehicleDriver');
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
            ));
	}
	
	public function actionDriverHistory()
	{
            $model=new VehicleDriver('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['VehicleDriver']))
                    $model->attributes=$_GET['VehicleDriver'];

            $this->render('driverHistory',array(
                    'model'=>$model,
            ));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VehicleDriver('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VehicleDriver']))
			$model->attributes=$_GET['VehicleDriver'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	protected function gridCategoryName($data, $row)
	{
            $sql = 'SELECT Category_Name FROM ma_vehicle_category vc INNER JOIN ma_vehicle_registry vr ON vr.Vehicle_Category_ID = vc.Vehicle_Category_ID WHERE vr.Vehicle_No ="'.$data->Vehicle_No.'"';
            $rowData = Yii::app()->db->createCommand($sql)->queryAll();

            $result = '';

            if(!empty($rowData))
            foreach ($rowData as $row)
            {
                $result = $row['Category_Name'];
            }
            return $result;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=VehicleDriver::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='vehicle-driver-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionDynamicDriverForBooking()
	{
            $from = Yii::app()->session['from'];
	
            if(isset($_POST['TRVehicleBooking']['Vehicle_No']))
            {
                $ID =$_POST['TRVehicleBooking']['Vehicle_No'];
            }
			
            $curLoc = Yii::app()->db->createCommand('select Current_Location_ID from vehicle_location where Vehicle_No ="'.$ID.'"')->queryAll();
            $curLocation=0;

            if(!empty($curLoc))
            {
                $curLocation = $curLoc[0]['Current_Location_ID'];
            }
		
            $qry ='SELECT distinct d.Driver_ID, d.Full_Name FROM `ma_driver` d Left JOIN vehicle_driver vd ON vd.Driver_ID = d.Driver_ID WHERE d.Location_ID = '.$curLocation.' and not EXISTS (select NULL from vehicle_booking vb where  ("'.$from.'" between date(vb.From) and date(vb.To)) and vb.Driver_ID = d.Driver_ID and vb.Booking_Status = "approved") ORDER BY Full_Name ASC';
		
            #$qry = 'SELECT Driver_ID, Full_Name FROM ma_driver WHERE Location_ID ='.$curLocation.' ORDER BY Full_Name ASC';
            /*$data=VehicleDriver::model()->findAll('Vehicle_No=:Vehicle_No', array(':Vehicle_No'=>(int)$ID));
            $data=CHtml::listData($data,'Driver_ID','Driver_ID');*/

            #$data = VehicleDriver::model()->findAllbySql('select vd.Driver_ID, d.Full_Name from vehicle_driver vd inner join ma_driver d on d.Driver_ID = vd.Driver_ID where vd.Vehicle_No ="'.$ID.'"');
		
            $dataAll = Yii::app()->db->createCommand($qry)->queryAll();
            $dataAll = CHtml::listData($dataAll, 'Driver_ID', 'Full_Name');
		
		
            $data = Yii::app()->db->createCommand("SELECT vd.Driver_ID, d.Full_Name
            FROM vehicle_driver vd
            INNER JOIN ma_driver d ON d.Driver_ID = vd.Driver_ID
            INNER JOIN vehicle_location vl ON vl.Current_Location_ID = vd.Location_ID
            WHERE vd.Vehicle_No = '$ID'
            AND (
            vd.Driver_Allocation_ID =(
            SELECT max( vd.Driver_Allocation_ID ) from vehicle_driver vd where vd.Vehicle_No = '$ID')
            )")->queryAll();
		
            $slctDriver ='';
            if(!empty($data))
            {
                $slctDriver = $data[0]['Driver_ID'];
            }
	
		
	
            echo CHtml::tag('option', array('value'=>''),CHtml::encode('--- Please Select ---'),true);
            foreach($dataAll as $value=>$name)
            {
                $slct ='';

                if($value == $slctDriver)
                {
                    echo CHtml::tag('option',array('value' => $value, 'selected' => 'selected'),CHtml::encode($name),true); 
                }
                else        
                {
                    echo CHtml::tag('option',array('value' => $value),CHtml::encode($name),true);
                }
            }
	}
	
	protected function gridDriverName($data, $row)
	{
            $drArray = Yii::app()->db->createCommand('select Full_Name from ma_driver where Driver_ID='.$data->Driver_ID)->queryAll();
            $result ='';
            if(!empty($drArray))
            foreach ($drArray as $row)
            {
                $result = $row['Full_Name'];
            }
            return $result;
	}
    }

	function saving($frmDate, $toDate)
	{
            Yii::app()->user->setFlash('success', "'To Date' should not be a previous date. Please select a valid 'To Date'..!");

            if($model->save())
            {
			
                if  (($toDate == ''))
                {
                    Yii::app()->user->setFlash('success', "Successfully Added..!");
                    $this->redirect(array('view','id'=>$model->Driver_Allocation_ID));
                }
                else if (($toDate != '')&&  ($frmDate < $toDate))
                {
                    Yii::app()->user->setFlash('success', "Successfully Added..!");
                    $this->redirect(array('view','id'=>$model->Driver_Allocation_ID));
                }
                else
                {
                    Yii::app()->user->setFlash('success', "'To Date' should not be a previous date. Please select a valid 'To Date'..!");
                }
            }
		
	}
	