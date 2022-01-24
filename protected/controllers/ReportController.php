<?php

class ReportController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $Page = null;

    public function actions() {
        return array(
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	
  /*  public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('DynamicDSDivision'),
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
         * add whole, public function accessRules(). */


        $curr_controlername = $this->getUniqueId();
        $curr_action = Yii::app()->controller->action->id;
        $access = Yii::app()->user->GetPermission($curr_controlername, $curr_action);

        if ($access == 'true') 
        {
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
                    'actions' => array('Vehicleinventry','VehicleDetails','vehicleRepaireServiceDate'),
                    'users' => array('*'),
                ),
                array('deny', // deny all users
                    'users' => array('*'),
                ),
            );
        }
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {

        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionVehicleinventry() {

        $model = new Vehicleinventryform;
        $modelvl = new MaLocation;
        $modelvc = new VehicleCategory;

        if (isset($_POST['MaLocation'])) {

            /* echo $this->ReportPermission('Vehicleinventryform'); */

            $modelvl->attributes = $_POST['MaLocation'];
            $modelvc->attributes = $_POST['VehicleCategory'];
            $model->rprint();
            //$this->render('rptHouseholderListing',array('model'=>$model));
            $this->render('vehicleinventry', array('model' => $model, 'modelvl' => $modelvl, 'modelvc' => $modelvc));
        } else {
            $this->render('vehicleinventry', array('model' => $model, 'modelvl' => $modelvl, 'modelvc' => $modelvc));
        }
    }

    public function actionVehicleDetails() {

        $model = new VehicleDetailsForm;
        $modelPer = new MaVehicleRegistry('search');
		$modelPer=new MaVehicleRegistry('search');
			$modelPer->unsetAttributes();  // clear any default values
			if(isset($_GET['MaVehicleRegistry']))
			{
				$modelPer->attributes=$_GET['MaVehicleRegistry'];
			}
				
      

        if (isset($_REQUEST['ReportGridMemberID'])) 
		{
            $model->rprint($_REQUEST['ReportGridMemberID']);
        } 
		else 
		{
            $this->render('VehicleDetails', array('model' => $model, 'modelper' => $modelPer, 'ID' => '1'));
        }
    }

    public function actionRegulataryReq() {
        $model = new RegulataryReqform;
        $modelvl = new VehicleCategory;

        if (isset($_POST['MaLocation'])) {

            /* echo $this->ReportPermission('Vehicleinventryform'); */

            $modelvl->attributes = $_POST['MaLocation'];
            $modelvc->attributes = $_POST['VehicleCategory'];
            $model->rprint();
            //$this->render('rptHouseholderListing',array('model'=>$model));
            $this->render('RegulataryReq', array('model' => $model, 'modelvl' => $modelvl, 'modelvc' => $modelvc));
        } else {
            $this->render('RegulataryReq', array('model' => $model, 'modelvl' => $modelvl, 'modelvc' => $modelvc));
        }
    }

    public function actionVehicleCategory() {
        $model = new vehicleCategoryForm;
        $modelVC = new VehicleCategory;

        if (isset($_REQUEST['vehicleCategoryForm'])) {
            $model->attributes = $_POST['vehicleCategoryForm'];
            $vCatID = $model->Vehicle_Category_ID;

            $model->rprint($vCatID);
        } else {
            $this->render('vehicleCategory', array('model' => $model, 'modelVC' => $modelVC));
        }
    }

    public function actionVehicleStatus() {
        $model = new vehicleStatusForm;
        $modelVS = new VehicleStatus;

        if (isset($_REQUEST['vehicleStatusForm'])) {
            //echo "aswerf"; exit;

            $model->attributes = $_POST['vehicleStatusForm'];
            $vStatusID = $model->Vehicle_Status_ID;

            //print_r($vCatID);exit;
            //echo $vStatusID;exit;
            //echo "aswerf"; exit;
            $model->rprint($vStatusID);
        } else {
            //echo "aswerf"; exit;
            $this->render('vehicleStatus', array('model' => $model, 'modelVS' => $modelVS));
        }
    }

    public function actionRevenueLicense() {
        $modelL = new revenueLicenseForm;
        //$modelL = new TRLicense;

        if (isset($_REQUEST['revenueLicenseForm'])) {
            $modelL->attributes = $_POST['revenueLicenseForm'];
            $valFrom = $modelL->Valid_From;
            $valTo = $modelL->Valid_To;

            $modelL->rprint($valFrom, $valTo);
        } else {
            $this->render('RevenueLicense', array('modelL' => $modelL));
        }
    }

    public function actionUserwiseBooking() {
        $modelL = new UserwiseBookingForm;
        //$modelL = new TRLicense;

        if (isset($_REQUEST['UserwiseBookingForm'])) {
            $modelL->attributes = $_POST['UserwiseBookingForm'];
            $valFrom = $modelL->Valid_From;
            $valTo = $modelL->Valid_To;
            $user = $modelL->User_ID;
//echo $user;exit;
            //echo $valFrom."-".$valTo; exit;

            $modelL->rprint($valFrom, $valTo, $user);
        } else {
            $this->render('UserwiseBooking', array('modelL' => $modelL));
        }
    }

    public function actionVehicleBooking() {
        $model = new vehicleBookingForm;

        if (isset($_REQUEST['vehicleBookingForm'])) {
            $model->attributes = $_POST['vehicleBookingForm'];
            $vFromDate = $model->Valid_From;
            $vToDate = $model->Valid_To;
			$bookingStatus = $model->Booking_Status;

            $model->rprint($vFromDate, $vToDate, $bookingStatus);
        } else {
            $this->render('vehicleBooking', array('model' => $model));
        }

        //$model = new vehicleBookingForm;
        //$modelET = new TREmissionTest;
        //echo "123"; exit;
        //if(isset($_REQUEST['vehicleBookingForm']))
        //{
        //echo "aswerf"; exit;
        //$model->attributes=$_POST['vehicleBookingForm'];			
        //$vFromDate = $_POST['vehicleBookingForm']['Valid_From'];
        //$vToDate =$_POST['vehicleBookingForm']['Valid_To'];
        //echo $vFromDate; exit;
        //print_r($vCatID);exit;
        //echo $vStatusID;exit;
        //echo "aswerf"; exit;
        //$model->rprint($vFromDate,$vToDate);	
        //}
        //else
        //{
        //echo "aswerf"; exit;
        //$this->render('vehicleBooking',array('model'=>$model));
        //}
    }

    public function actionInsurance() {
        $model = new InsuranceForm;
        $mode1ns = new MaVehicleRegistry;
        if (isset($_REQUEST['InsuranceForm'])) {

            //$vFromDate = $_POST['InsuranceForm']['Valid_From'];
            //$vToDate =$_POST['InsuranceForm']['Valid_To'];
            //$vCategory =$_POST['MaVehicleRegistry']['Vehicle_Category_ID'];

            $model->attributes = $_POST['InsuranceForm'];
            $mode1ns->attributes = $_POST['MaVehicleRegistry'];
            $vFromDate = $model->Valid_From;
            $vToDate = $model->Valid_To;
            $vCategory = $mode1ns->Vehicle_Category_ID;

            $model->rprint($vFromDate, $vToDate, $vCategory);
        } else {

            $this->render('Insurance', array('model' => $model, 'mode1ns' => $mode1ns));
        }
    }

    public function actionEmissionTest() {
        $model = new emissionTestForm;
        //$modelET = new TREmissionTest;

        if (isset($_REQUEST['emissionTestForm'])) {
            $model->attributes = $_POST['emissionTestForm'];
            $valFrom = $model->Valid_From;
            $valTo = $model->Valid_To;

            $model->rprint($valFrom, $valTo);
        } else {
            //echo "aswerf"; exit;
            $this->render('emissionTest', array('model' => $model));
        }
    }

    public function actionFitnessTest() {
        $model = new FitnessTestForm;
        $modelVC = new TRFitnessTest;
        $modelVC1 = new MaVehicleRegistry;
        if (isset($_REQUEST['FitnessTestForm'])) 
        {
            $model->attributes = $_POST['FitnessTestForm'];
            $Valid_From = $model->Valid_From;
            $Valid_To = $model->Valid_To;
            $model->rprint($Valid_From, $Valid_To);
        } else {
            $this->render('FitnessTest', array('model' => $model, 'modelVC' => $modelVC, 'modelVC1' => $modelVC1));
        }
    }

    public function actionVehicleMileage() {
        $model = new vehicleMileageForm;
        if (isset($_REQUEST['vehicleMileageForm'])) {
            $model->attributes = $_POST['vehicleMileageForm'];
            $vCatID = $model->Vehicle_Category_ID;
            //$vCatName = $model->Category_Name;
            $model->rprint($vCatID);
        } else {
            $this->render('vehicleMileage', array('model' => $model));
        }
    }

    public function actionVehicleAllocation() {
        $model = new vehicleAllocationForm;


        if (isset($_REQUEST['vehicleAllocationForm'])) {
            $model->attributes = $_POST['vehicleAllocationForm'];
            $vA_ID = $model->Allocation_Type_ID;
            //echo $vA_ID; exit;
            $model->rprint($vA_ID);
        } else {
            $this->render('vehicleAllocation', array('model' => $model));
        }
    }

    public function actionVehicleRepaireServiceDate() {

        $model = new vehicleRepaireServiceDateForm;
        //$model1=new vehicleRepaireServiceForm;

        if (isset($_REQUEST['vehicleRepaireServiceDateForm'])) {
            $model->attributes = $_POST['vehicleRepaireServiceDateForm'];

            $vFromDate = $model->Valid_From;
            $vToDate = $model->Valid_To;

            //echo $_REQUEST['ReportGridMemberID'] ,$vFromDate, $vToDate , exit; 
            #$model->rprint($_REQUEST['ReportGridMemberID'],$vFromDate,$vToDate);	
            $model->rprint($_REQUEST['ReportGridMemberID'], $vFromDate, $vToDate);
        } else {
            $this->render('vehicleRepaireServiceDate', array('model' => $model));
        }
    }

    public function actionVehicleRepaireService() {

        $model = new vehicleRepaireServiceForm;
        $modelPer = new MaVehicleRegistry;


        //if(isset($_GET['MaVehicleRegistry']))
//		{
//			
//			//echo 'test1', exit;
//			$modelPer->attributes=$_GET['MaVehicleRegistry'];
//			
//		}
//		
//		if(isset($_REQUEST['ReportGridMemberID'])){
//			
//			//echo 'test10', exit;	
//			
//			//$modelI->attributes=$_POST['vehicleBookingForm'];			
////			$vFromDate = $modelI->Valid_From;
////			$vToDate = $modelI->Valid_To;
////			echo $vFromDate; exit;
//			
//			$model->rprint($_REQUEST['ReportGridMemberID']);
//	    }

        $modelv = new MaVehicleRegistry('search');
        $modelv->unsetAttributes();  // clear any default values
        if (isset($_GET['MaVehicleRegistry']))
            $modelv->attributes = $_GET['MaVehicleRegistry'];


//		else
//		{

        $this->render('vehicleRepaireService', array('model' => $model, 'modelper' => $modelPer, 'modelv' => $modelv, 'ID' => '1'));
        //}	
    }

    public function actionVehicleMaintenanceCost() {

        $model = new vehicleMaintenanceCostForm;
        $modelPer = new MaVehicleRegistry;

        $modelv = new MaVehicleRegistry('search');
        $modelv->unsetAttributes();  // clear any default values
        if (isset($_GET['MaVehicleRegistry']))
            $modelv->attributes = $_GET['MaVehicleRegistry']; // , 'modelv'=>$modelv

        $this->render('vehicleMaintenanceCost', array('model' => $model, 'modelper' => $modelPer, 'modelv' => $modelv, 'ID' => '1'));
    }

    public function actionVehicleMaintenanceCostDate() {

        $model = new vehicleMaintenanceCostDateForm;
        //$model1=new vehicleRepaireServiceForm;

        if (isset($_REQUEST['vehicleMaintenanceCostDateForm'])) {
            $model->attributes = $_POST['vehicleMaintenanceCostDateForm'];

            $vFromDate = $model->Valid_From;
            $vToDate = $model->Valid_To;

            //echo $_REQUEST['ReportGridMemberID'] ,$vFromDate, $vToDate , exit;

            $model->rprint($_REQUEST['ReportGridMemberID'], $vFromDate, $vToDate);
        } else {
            $this->render('vehicleMaintenanceCostDate', array('model' => $model));
        }
    }

    public function actionFuelConsumptionByVehecle() {
        $model = new FuelConsumptionByVehecleDateForm;
        $modelPer = new MaVehicleRegistry;

        $modelv = new MaVehicleRegistry('search');
        $modelv->unsetAttributes();  // clear any default values
        if (isset($_GET['MaVehicleRegistry']))
            $modelv->attributes = $_GET['MaVehicleRegistry']; // , 'modelv'=>$modelv

        $this->render('FuelConsumptionByVehecle', array('model' => $model, 'modelper' => $modelPer, 'modelv' => $modelv, 'ID' => '1'));
        //}	
    }

    public function actionFuelConsumptionByVehecleDate() {
        $model = new FuelConsumptionByVehecleDateForm;
        //$model1=new vehicleRepaireServiceForm;

        if (isset($_REQUEST['FuelConsumptionByVehecleDateForm'])) {
            $model->attributes = $_POST['FuelConsumptionByVehecleDateForm'];

            $vFromDate = $model->Valid_From;
            $vToDate = $model->Valid_To;

            //echo $_REQUEST['ReportGridMemberID'] ,$vFromDate, $vToDate , exit; 

            $model->rprint($_REQUEST['ReportGridMemberID'], $vFromDate, $vToDate);
        } else {

            $this->render('FuelConsumptionByVehecleDate', array('model' => $model));
        }
    }

    public function actionFuelConsumptionVehicleAllDate() {
        $model = new FuelConsumptionAllVehicleDateForm;
        //$model1=new vehicleRepaireServiceForm;

        if (isset($_REQUEST['FuelConsumptionAllVehicleDateForm'])) {
            $model->attributes = $_POST['FuelConsumptionAllVehicleDateForm'];

            $vFromDate = $model->Valid_From;
            $vToDate = $model->Valid_To;

            //echo $vFromDate, $vToDate , exit; 

            $model->rprint($vFromDate, $vToDate);
        } else {

            $this->render('FuelConsumptionVehicleAllDate', array('model' => $model));
        }
    }

    public function actionDriverPerformance() {
        $model = new DriverPerformanceForm;
        //$model1=new vehicleRepaireServiceForm;

        if (isset($_REQUEST['DriverPerformanceForm'])) {
            $model->attributes = $_POST['DriverPerformanceForm'];

            $vFromDate = $model->Valid_From;
            $vToDate = $model->Valid_To;

            //echo $vFromDate, $vToDate , exit; 

            $model->rprint($vFromDate, $vToDate);
        } else {
            $this->render('DriverPerformance', array('model' => $model));
        }
    }

    public function actionDrverPerformanceByDriver() {
        $model = new MaDriver('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MaDriver']))
            $model->attributes = $_GET['MaDriver'];
        $this->render('DrverPerformanceByDriver', array('model' => $model,));
    }

    public function actionDriverPerformanceByDriverDate() {
        $model = new DriverPerformanceByDriverDateForm;

        if (isset($_REQUEST['DriverPerformanceByDriverDateForm'])) {
            $model->attributes = $_POST['DriverPerformanceByDriverDateForm'];

            $vFromDate = $model->Valid_From;
            $vToDate = $model->Valid_To;

            //echo $_REQUEST['ID'] ,$vFromDate, $vToDate , exit; 

            $model->rprint($_REQUEST['ID'], $vFromDate, $vToDate);
        } else {

            $this->render('DriverPerformanceByDriverDate', array('model' => $model));
        }
    }

    protected function gridModel($data, $row) {
        $sql = 'select Model from ma_model m where m.Model_ID = "' . $data->Model_ID . '"';
        $rows = Yii::app()->db->createCommand($sql)->queryAll();


        $result = '';
        if (!empty($rows))
            foreach ($rows as $row) {
                /* $url = $this->createUrl('create',array('Model_ID'=>$row['Model']));			
                  $result .= CHtml::link($row['Model'],$url) .'<br/>'; */
                $result = $row['Model'];
            }
        return $result;
    }

    public function actionBookingsForVehicle() {

        $model = new bookingsForVehicleForm;
        $modelVr = new MaVehicleRegistry;
        if (isset($_REQUEST['bookingsForVehicleForm'])) {
            $model->attributes = $_POST['bookingsForVehicleForm'];
            $modelVr->attributes = $_POST['MaVehicleRegistry'];
            $Valid_From = $model->Valid_From;
            $Valid_To = $model->Valid_To;
            $Vehicle_No = $modelVr->Vehicle_No;

            $model->rprint($Vehicle_No, $Valid_From, $Valid_To);
        } else {
            $this->render('bookingsForVehicle', array('model' => $model, 'modelVr' => $modelVr));
        }
    }

    //removed from site controller and added
    public function actionReport() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/user/login'));
        } else {

            $this->render('report');
        }
    }
    
    
    public function actionAccidentReportVehicleWise() 
    {
        $model = new AccidentReportVehicleWiseForm;
        $modelV = new MaVehicleRegistry('search');

        $modelV->unsetAttributes();  // clear any default values
        if (isset($_GET['MaVehicleRegistry']))
            $modelV->attributes = $_GET['MaVehicleRegistry'];

        
        if (isset($_REQUEST['AccidentReportVehicleWiseForm'])) 
        {
            //var_dump($_REQUEST);exit;
            $model->attributes = $_POST['AccidentReportVehicleWiseForm'];
            $Vehicle_No = $model->Vehicle_No;
            $From_Date = $model->From_Date;
            $To_Date = $model->To_Date;
            $Show_Images = $_REQUEST['AccidentReportVehicleWiseForm']['Show_Images'];
            
            $model->rprint($Vehicle_No, $From_Date, $To_Date,$Show_Images);
        } 
        else 
        {
            $this->render('AccidentReportVehicleWise', array('model' => $model, '$modelV' => $modelV));
        }
        	
    }

}

