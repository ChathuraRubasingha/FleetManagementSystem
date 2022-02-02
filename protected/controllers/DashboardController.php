<?php

class DashboardController extends Controller
{
	/*
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/*
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
					'actions'=>array('view','delete', 'booking','index_bk'),
					'users'=>array('*'),
				),				
				array('deny',  // deny all users
					'users'=>array('*'),
				),		

			);

		}		
		
	}
	
	public function actionIndex()
	{
		if(Yii::app()->user->isGuest)
		{
	     $this->redirect(array('/user/login'));
		}
		else
		{
			
			
	// edited by damith
	// re edited by Mathu -- During on May 1 week
	
	$model = TRFitnessTest::model()->fitnessTest();
	
	$Insurance = TRInsurance::model()->insurance();
	
	$Emmission = TREmissionTest::model()->emmissionTest();
	
	$LicenseD = TRLicense::model()->License();
	
	$pending= TRVehicleBooking::model()->getPendingBookingRequests();
	
	$approvalBooking =BookingApproval::model()->newModel();
	//$pending = new BookingApproval();
	//$approved= TRVehicleBooking::model()->getApprovedBookingRequests();
	$approved= TRVehicleBooking::model()->getApprovedBookingRequestsDashBoard();//  one by one requests
	//$approved= BookingApproval::model()->getApprovedBookingRequestsDashBoard();
	$assigned= BookingApproval::model()->getAssignedBookingRequestsDashBoard();
	//$repair= TRRepairEstimateDetails::model()->getPendingEstimates();
	$repair= TRRepairEstimateDetails::model()->getPendingEstimatesDashBoard();
	
	//$repairApproved= TRRepairRequest::model()->getRepairRequest();
	$repairApproved= TRRepairEstimateDetails::model()->getApprovedEstimatesDashBoard();
	
	$batteryReplacementPending= TRBatteryDetails::model()->getPendingBatteryRequestsDashBoard();
	
	$batteryReplacementApproved= TRBatteryDetails::model()->getPendingBatteryReplacementsDashBoard();
	
	$tireReplacementPending= TRTyreDetails::model()->getPendingTyreRequestsDashBoard();
	
    $tireReplacementApproved = TRTyreDetails::model()->getPendingTyreReplacementsDashBoard();
	
	$fuelRequestPending = TRFuelRequestDetails::model()->getFuelRequestDetailsDashBoard();
	
	$fuelRequestApproved = TRFuelRequestDetails::model()->getFuelApprovedListDashBoard();
	
	
	$this->render('index',array('fitness'=>$model,
	'insuarance'=>$Insurance,
	'emmission'=>$Emmission,
	'License'=>$LicenseD,
	'pending'=>$pending,
	'approved'=>$approved,
	'assigned'=>$assigned,
	'repair'=>$repair,
	'repairApproved' =>$repairApproved, 
	'batteryReplacementPending' =>$batteryReplacementPending,
	'batteryReplacementApproved' =>$batteryReplacementApproved,
	'tireReplacementPending' =>$tireReplacementPending,
	'tireReplacementApproved' =>$tireReplacementApproved,
	'fuelRequestPending' =>$fuelRequestPending,
	'fuelRequestApproved' =>$fuelRequestApproved));
	
	
		}
		/*$usage_data1 = array (
			array (
				'id' => 0,
				'event' => 'Total',
				'channels' => rand(10,100),
			),
			array (
				'id' => 0,
				'event' => 'Dial In',
				'channels' => rand(10,100),
			),
			array (
				'id' => 0,
				'event' => 'Dial Out',
				'channels' =>rand(10,100),	
			),
			array (
				'id' => 0,
				'event' => 'Idle',
				'channels' => rand(10,100),
			),
		);
		
		$usageDataProvider1 = new CArrayDataProvider($usage_data1, array (
			'pagination' => false
		));
		
		$this->render('index', array('usageDataProvider1' => $usageDataProvider1));*/
				
				
	}
	
	public function actionIndex_bk()
	{
            $this->render('index_bk', array());
	
	
	}/**/
	
	public function actionView()
	{
		//
		$this->render('view');
	}
	
	public function loadModel($id)
	{
		$model=VehicleStatus::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='vehicle-status-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	protected function gridLocation($data, $raw)
	{
		 $sql = 'select l.Location_Name from vehicle_location vl inner join ma_location l ON l.Location_ID = vl.Current_Location_ID  where vl.Vehicle_No = "'.$data->Vehicle_No.'"';
		 $rows = Yii::app()->db->createCommand($sql)->queryAll();	
		 	
		 	
      $result = '';			
       if(!empty($rows))			
        foreach ($rows as $row) 			
           {			
              /*$url = $this->createUrl('create',array('Model_ID'=>$row['Model']));			
              $result .= CHtml::link($row['Model'],$url) .'<br/>'; 	*/		
			  $result = $row['Location_Name'];
       }      			
       return $result; 	
	}
	
	public function actionBooking()
	{
		
		$pending= TRVehicleBooking::model()->getPendingBookingRequests();
		//$this->renderPartial('_pending',array('pending' =>$pending));
		$this->redirect(array('/dashboard/index','id'=>'booking'));
		
	}
}