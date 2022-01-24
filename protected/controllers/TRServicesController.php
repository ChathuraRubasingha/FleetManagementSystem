<?php

class TRServicesController extends Controller
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
                array('allow',  // allow all users to perform 'index' and 'view' actions
                    'actions'=>array('view','delete','ServiceRequestReport'),
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
		date_default_timezone_set("Asia/Colombo");
        if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
        {
            unset(Yii::app()->session['btnClick']);
        }


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $model=new TRServices;
        $checkId = array();
        $priceID = array();
		$NextMilageValues = array();

        if(isset($_POST['ids']))
        {
            $checkId = $_POST['ids'];
            Yii::app()->session['checkBoxValues'] = $checkId;
        }

        if(isset($_POST['prices']))
        {
            $priceID = $_POST['prices'];
            Yii::app()->session['priceValues'] = $priceID;
			$NextMilageValues =	$_POST['Next_Service_Milage'];
			Yii::app()->session['Next_Service_Milage'] = $priceID;
        }

        if(isset($_POST['TRServices']))
        {
            $model->attributes=$_POST['TRServices'];
            $appDate = date("Y-m-d");
            $serviceDate = $model-> Service_Date;
            $nextServiceDate = $model->Next_Service_Date;
            $vNo = $model->Vehicle_No;
            //echo $nextServiceDate ; exit;
            $model->Estimate_Cost = str_replace(',','', $model->Estimate_Cost);
            $model->Other_Costs = str_replace(',','', $model->Other_Costs);

            $srvDateDetails = Yii::app()->db->createCommand('select Service_Date from services where Vehicle_No ="'.$vNo.'" and Service_Date="'.$serviceDate.'"')->queryAll();
            $count = count($srvDateDetails);

            $srvDate ='';
            if($count>0)
            {
                $srvDate = $srvDateDetails[0]['Service_Date'];
            }
            $valid = $model->validate();



            if($valid)
            {
                if($srvDate == $serviceDate)
                {
                    Yii::app()->user->setFlash('success', "Service Details are existed");
                    Yii::app()->session['btnClick'] = "1";
                }
                elseif($serviceDate > $appDate)
                {
                    Yii::app()->user->setFlash('success', "'Service Date' should be a previous date..!");
                    Yii::app()->session['btnClick'] = "1";
                }
                elseif (!empty($nextServiceDate) &&  ($nextServiceDate < $serviceDate))
                {
                    Yii::app()->user->setFlash('success', "'Next Service Date' should not be a previous date..!");
                    Yii::app()->session['btnClick'] = "1";
                }
                elseif($model->save())
                {
				/*
                    $total_cost = $model->Estimate_Cost + $model->Other_Costs;
                    $vehicleLocation = TRVehicleLocation::model()->find("Vehicle_No = '$model->Vehicle_No'");
					
					if(isset($vehicleLocation->locations->Project_Code))
					{
						$project_id = $vehicleLocation->locations->Project_Code;
						if($project_id != "")
						{
							$proCodeExistsCmd = "SELECT Project_Code FROM ma_project WHERE Project_Code = '$project_id'";
							$proCodeExists = Yii::app()->db_pms->createCommand($proCodeExistsCmd)->queryScalar();
							//---add cost to PMS--
							if($proCodeExists != '')
							{
								$serviceID = $model->Services_ID;
								$randomNumber = mt_rand(10,100);
								$billNumber = $randomNumber;
								$remark = $model->Description." - Service ID".$serviceID;
								$cost_to_pms = "INSERT INTO overhead_for_project(Overhead_Category_Id, project_code, start_date, end_date, project_overhead_cost, bill_number,payment_method,remark,create_by,create_date)
										VALUES(142, '".$project_id."','".$serviceDate."','".$serviceDate."',".$total_cost.",'".$billNumber."','2','".$remark."','fleet w/s','".date("Y-m-d")."')";
								$kk = Yii::app()->db_pms->createCommand($cost_to_pms)->execute();

								//---add cost to Accounts--
								$cmd = "SELECT business_id FROM acc_business WHERE PMS_project_id = '$project_id'";
								$accProjectcode = Yii::app()->db_acc->createCommand($cmd)->queryScalar();
								if($accProjectcode != "")
								{
									$cost_to_accu = "INSERT INTO tbl_payable(project_id , payee_id, due_date, payable_amount, description, expense_category, period_from, period_to, added_by,payable_status)
											VALUES(".$accProjectcode.",'1','".$serviceDate."',".$total_cost.",'".$remark."','5','".$serviceDate."','".$serviceDate."','fleet w/s','Not Paid')";
									$uu = Yii::app()->db_acc->createCommand($cost_to_accu)->execute();
								}
							}
						}
					}					
					*/
                    $countCheck =count($checkId);
                    $countPrice =count($priceID);


                    if(isset($_POST['ids']) && ($_POST['prices'] || $_POST['Next_Service_Milage']))
                    {
                        $model->savereplacement($_POST['ids'],$_POST['prices'], $_POST['Next_Service_Milage'], $model->Services_ID);
                    }

                    $vid = Yii::app()->session['maintenVehicleId'];

                    $Previous_Next_Service_Date_Array = Yii::app()->db->createCommand('SELECT Next_Service_Date FROM services WHERE Vehicle_No= "'.$vid.'" ORDER BY Services_ID DESC LIMIT 1 , 1')->queryAll();
                    //$Previous_Max_ID = $Previous_Max[0]['Fuel_Request_ID'];
                    $Previous_Next_Service_Date='';

                    if (count($Previous_Next_Service_Date_Array)> 0)
                    {
                        $Previous_Next_Service_Date = $Previous_Next_Service_Date_Array[0]['Next_Service_Date'];

                        $date1 = strtotime($Previous_Next_Service_Date);
                        $date2 = strtotime(date("Y-m-d", time()));

                        $dateDiff = $date1 - $date2;
                        $fullDays = floor($dateDiff/(60*60*24));

                        $Allocated_Rate=0;

                        if(($fullDays <= 5 && $fullDays >= 0) || ($fullDays >= -5 && $fullDays <= 0))
                        {
                            $Allocated_Rate=1;
                        }
                        else
                        {
                            $Allocated_Rate='-1';
                        }

                        $Max_ID_Array = Yii::app()->db->createCommand('SELECT Max(Services_ID) as ID FROM services WHERE Vehicle_No= "'.$vid.'"')->queryAll();

                        if (count($Max_ID_Array) >0)
                        {
                            $Max_Service_ID = $Max_ID_Array[0]['ID'];
                            //$data = "UPDATE ma_driver SET Rating =".$CalculateRating." WHERE Driver_ID = ".$model->Driver_ID."";
                            $data = "INSERT INTO driver_rating(Driver_ID, Services_ID, Rate_By_Service, Date_Rated)
							VALUES(".$model->Driver_ID.",".$Max_Service_ID.",".$Allocated_Rate.",'".date("Y-m-d", time())."')";
                            $rawData = Yii::app()->db->createCommand($data)->execute();
                        }
                    }
                    Yii::app()->user->setFlash('success', "Successfully Added..!");
                    #$this->redirect(array('create','id'=>$model->Services_ID));
                    $this->redirect(array('view','id'=>$model->Services_ID));
                }

            }
            else
            {
                Yii::app()->session['btnClick'] = "1";
            }
        }

        $this->render('create',array(
            'model'=>$model
        ));


    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
		date_default_timezone_set("Asia/Colombo");
        if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
        {
            unset(Yii::app()->session['btnClick']);
        }
        //$id = 3;
        $model=$this->loadModel($id);


        $checkId = array();
        $priceID = array();
		$NextMilageValues = array();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['TRServices']))
        {
            if(isset($_POST['ids']))
            {
                $checkId = $_POST['ids'];
                Yii::app()->session['checkBoxValues'] = $checkId;
                //$model->savereplacement($_POST['ids'],$model->Services_ID);
            }

            if(isset($_POST['prices']) || isset($_POST['Next_Service_Milage']))
            {
                $priceID = $_POST['prices'];
				$NextMilageValues = $_POST['Next_Service_Milage'];
				
				
                Yii::app()->session['priceValues'] = $priceID;
				Yii::app()->session['NextMilageValues'] = $NextMilageValues;
                
				//var_dump($priceID);exit;
                //$model->savereplacement($_POST['ids'],$model->Services_ID);
            }
         
            $model->attributes=$_POST['TRServices'];
            $appDate = date("Y-m-d");
            $serviceDate = $model->Service_Date;
            $nextServiceDate = $model->Next_Service_Date;
            $model->Estimate_Cost = str_replace(',','', $model->Estimate_Cost);
            $model->Other_Costs = str_replace(',','', $model->Other_Costs);

            $valid = $model->validate();
            if($valid)
            {
                if($serviceDate > $appDate)
                {
                    Yii::app()->user->setFlash('success', "'Service Date' should be a previous date..!");
                    Yii::app()->session['btnClick'] = "1";
                }
                //echo $nextServiceDate;exit;
                elseif((!empty($nextServiceDate)) &  ($nextServiceDate != '0000-00-00') && ($nextServiceDate < $serviceDate))
                {
                    Yii::app()->user->setFlash('success', "'Next Service Date' should not be a previous date..!");
                    Yii::app()->session['btnClick'] = "1";
                }

                else
                {
                    $countCheck =count($checkId);
                    $countPrice =count($priceID);

                    if($model->save())
                    {
                        if(isset($_POST['ids']) && ($_POST['prices']||$_POST['Next_Service_Milage']))
                        {
                            $model->savereplacement($_POST['ids'],$_POST['prices'], $_POST['Next_Service_Milage'],$model->Services_ID);
                        }
                        else
                        {
                            $model->deleteReplacement($model->Services_ID);
                        }


                        Yii::app()->user->setFlash('success', "Successfully Updated..!");
                        $this->redirect(array('view','id'=>$model->Services_ID));
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
        $dataProvider=new CActiveDataProvider('TRServices');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new TRServices('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TRServices']))
            $model->attributes=$_GET['TRServices'];

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
        $model=TRServices::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='trservices-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
	public function actionServiceRequestReport($id)
	{
		if($type="pdf")
		{
			$cri = new CDbCriteria();
			$cri->condition="Services_ID = " . $id;
			$arr = TRServices::model()->find($cri);			

			$htmlHead = "VEHICLE SERVICE REPORT";
			$html = "<table style='padding-left: 20px; padding-top: 10px'>
			<tr><td>Estimate Id </td><td>:</td><td>$arr->Services_ID</td></tr>
			<tr><td>Srvice Station Name </td><td>:</td><td>{$arr->serviceStation->Srvice_Station_Name}</td></tr>
			<tr><td>Contact Details</td><td>:</td><td>{$arr->serviceStation->Contact_Person} {$arr->serviceStation->Land_phone_No} {$arr->serviceStation->Mobile_No}</td></tr>
			<tr><td>Service Date</td><td>:</td><td>$arr->Service_Date</td></tr>
			<tr><td>Service Type </td><td>:</td><td>{$arr->serviceType->Service_Type}</td></tr>";
			
			$q = "SELECT
				ma_location.Location_Name
				FROM
				vehicle_transfer
				INNER JOIN ma_location ON vehicle_transfer.To_Location_ID = ma_location.Location_ID
				where vehicle_transfer.Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date DESC
				limit 1";	

			$q_date = "SELECT
				vehicle_transfer.From_Date
				FROM
				vehicle_transfer
				INNER JOIN ma_location ON vehicle_transfer.To_Location_ID = ma_location.Location_ID
				where vehicle_transfer.Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date DESC
				limit 1";
				
			$LastLocation = Yii::app()->db->createCommand($q)->queryScalar();			
			
			if ($LastLocation == "") 
			{
			$q = "SELECT
				ma_location.Location_Name
				FROM
				vehicle_transfer
				INNER JOIN ma_location ON vehicle_transfer.From_Location_ID = ma_location.Location_ID
				where vehicle_transfer.Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date DESC
				limit 1";
				
			$q_date = "SELECT
				vehicle_transfer.From_Date
				FROM
				vehicle_transfer
				INNER JOIN ma_location ON vehicle_transfer.To_Location_ID = ma_location.Location_ID
				where vehicle_transfer.Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date DESC
				limit 1";											
			}
			
			$LastLocation = Yii::app()->db->createCommand($q)->queryScalar(). " " .  Yii::app()->db->createCommand($q_date)->queryScalar();	
			
			if ($LastLocation == " ")
			{
				$q = "SELECT
				CONCAT(ma_location.Location_Name, ' ' , IFNULL(From_Date, ''))
				FROM
				vehicle_location
				INNER JOIN ma_location ON vehicle_location.Current_Location_ID = ma_location.Location_ID
				where Vehicle_No = '" . $arr->Vehicle_No . "'
				ORDER BY From_Date desc";
				
				$LastLocation = Yii::app()->db->createCommand($q)->queryScalar();
			}
			
			$html .= "<tr><td>Current Location </td><td>:</td><td>$LastLocation</td></tr></table>";

			
			$html .= "
			<br/>
			<table class='tbl'>"
                        . "<thead><tr>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Vehicle No</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Meter Reading</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Next Service Mileage (km)</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px'>Service Replacement</th>"
                        . "<th style='border-bottom:2px solid black;padding:5px; text-align: right'>Cost(Rs.)</th>"
						. "</thead>";
			
			$cmd1 = "SELECT ma_replacement_of_service.Service_Replacement,service_replacement.Price
			FROM
			services
			INNER JOIN service_replacement ON services.Services_ID = service_replacement.Services_ID
			INNER JOIN ma_replacement_of_service ON service_replacement.Replacement_of_Service_ID = ma_replacement_of_service.Replacement_of_Service_ID where services.Services_ID = " . $id;
			
			$rows =  Yii::app()->db->createCommand($cmd1)->queryAll();
			
			$cmd2 = "SELECT services.Meter_Reading, services.Next_Service_Milage
			FROM services where  Vehicle_No = '" . $arr->Vehicle_No  .  "' and Services_ID != " . $id . " ORDER BY Services_ID DESC limit 1";
			
			$rowsPre =  Yii::app()->db->createCommand($cmd2)->queryRow();			
			
			$x = 0;
			$Sum = 0;
			foreach ($rows as $value) 
			{   
				if ($x == 0) $html .= "<tr><td rowspan = '{{No}}' style = 'text-align: center' >" . $arr->Vehicle_No . "</td><td rowspan = '{{No}}' style = 'text-align: left'>Previous : " .  $rowsPre['Meter_Reading'] . '<BR/>Current : ' .  $arr->Meter_Reading .  '<BR/>Last Proposed : ' . $rowsPre['Next_Service_Milage'] . "</td><td rowspan = '{{No}}' style = 'text-align: center'>" . $arr->Next_Service_Milage .  "</td><td>" . $value['Service_Replacement'] . "</td><td style = 'text-align: right'>" .number_format($value['Price'],2) . "</td></tr>";				
				else $html .= "<tr><td>"  . $value['Service_Replacement'] . "</td><td style = 'text-align: right'>" .number_format($value['Price'],2) . "</td></tr>";
				$x += 1;
				$Sum += $value['Price'];
			}
			$Sum += $arr->Other_Costs;
			if ($x > 0)
			{
				$html .= "<tr><td>Other Costs</td><td style = 'text-align: right'>" .number_format($arr->Other_Costs,2) . "</td></tr>";
				$html .= "<tr><td><b>Total Costs<b></td><td style = 'text-align: right'><b>" .number_format($Sum,2) . "</b></td></tr>";
			}
			else
			{
				$html .= "<tr><td colspan='4'>Other Costs</td><td style = 'text-align: right'>" .number_format($arr->Other_Costs,2) . "</td></tr>";
				$html .= "<tr><td colspan='4'><b>Total Costs<b></td><td style = 'text-align: right'><b>" .number_format($Sum,2) . "</b></td></tr>";				
			}
			$html = str_replace( "{{No}}", $x+2, $html); 
			$html .= "</table><br/>";
			
			$html .= "&nbsp;&nbsp;" . $arr->Description;

			$PreparedBy = $arr->add_by;
			$PreparedDate = $arr->add_date;
			$RoleID = Yii::app()->db->createCommand("Select Role_ID from tbl_users where username = '$PreparedBy'" )->queryScalar();	
			$RoleName = ($RoleID != null ? Yii::app()->db->createCommand("Select Role from ma_role where Role_ID = $RoleID" )->queryScalar() : '');
			
			$AprBy = $AppDate = $RoleIDApr = $RoleNameApr = '';
			
			$htmlFoot =  "<hr/>
	
					<table width='100%' >
					<tr>
					<td>							
    						<p><b>Prepared By<b></p>
							<p>Signature : ................................................</p>
                            <p>Name : $PreparedBy </p>
                            <p>Designation : $RoleName</p>
							<p>Date/Time : $PreparedDate</p>
					</td>
					<td>
    						<p><b>Approved By<b></p>
							<p>Signature : ...............................................</p>
                            <p>Name : $AprBy</p>
                            <p>Designation : $RoleNameApr</p>
							<p>Date/Time : $AppDate</p>
					</td>
					</tr>

					</table>";
					
			$css = '.tbl{
                        width:100%;
                        padding: 10px;
                        border: 1px solid black;
                        border-collapse: collapse;
                            }

                    .tbl th,.tbl td{
                        padding: 10px;
                        border: 1px solid black;
                        border-collapse: collapse;
                    }
                    ';
					
			$dompdf = new makePdf;
			$dompdf->setSize('A4', 'Potrait');
			$dompdf->renderPartial('/layouts/A4ReportTemplate', array('page_content' => $html, 'page_header' => $htmlHead, 'page_footer' => $htmlFoot, 'report_name' => 'VEHICLE REPAIR ESTIMATE REPORT', 'tel' => '', 'address' => '', 'fax' => '', 'vat_no' => '', 'doc_no' => ' ', 'issue_no' => ' ', 'issue_date' => ' ',  'css_styles' => $css));
			$dompdf->stream($id . ' - VEHICLE REPAIR ESTIMATE REPORT.pdf');
		}
	}	
}
