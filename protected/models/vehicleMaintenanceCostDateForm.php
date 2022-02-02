<?php

class vehicleMaintenanceCostDateForm extends CFormModel
{

//public $Valid_From,$Valid_To;
	public $Valid_From;
	public $Valid_To;
	public $Vehicle_Status_ID;

	
	
	public function rules()
	{
		return array(
		
		
			array('Valid_From, Valid_To', 'required')
			
		);
	}
	
	 public function attributeLabels()
    {
        return array(
			'Valid_From'=>'From Date',	
			'Valid_To'=>'To Date'		
		);
	}
	
	
	
	
    public function rprint($Vehicle_No, $vFromDate, $vToDate)
    {
		
        $DataSource = new ReportDataSource;
        require_once('./protected/class/class.ezpdf.php');
        $pdf = new Cezpdf();
        $pdf->Cezpdf($paper='A4',$orientation='landscape');
      	$pdf->selectFont('./protected/class/fonts/Courier.afm');
		
        //--Get data array 
        $mystrR=$DataSource->ArrayVehicleRepaire($Vehicle_No, $vFromDate, $vToDate);
        $ArrCountR = count($mystrR);

        $mystrS=$DataSource->ArrayVehicleService($Vehicle_No, $vFromDate, $vToDate);
        $ArrCountS = count($mystrS);

        $mystrL=$DataSource->ArrayVehicleLicense_Maintenance($Vehicle_No, $vFromDate, $vToDate);
        $ArrCountL = count($mystrL);

        $mystrF=$DataSource->ArrayVehicleFitness_Maintenance($Vehicle_No, $vFromDate, $vToDate);
        $ArrCountF = count($mystrF);

        $mystrE=$DataSource->ArrayVehicleEmissionTest_Maintenance($Vehicle_No, $vFromDate, $vToDate);
        $ArrCountE = count($mystrE);


        $mystrI=$DataSource->ArrayVehicleInsurance_Maintenance($Vehicle_No, $vFromDate, $vToDate);
        $ArrCountI = count($mystrI);


        $mystrB=$DataSource->ArrayVehicleBattery_Maintenance($Vehicle_No, $vFromDate, $vToDate);
        $ArrCountB = count($mystrB);

        $mystrT=$DataSource->ArrayVehicleTyre_Maintenance($Vehicle_No, $vFromDate, $vToDate);
        $ArrCountT = count($mystrT);

        $tbwith=770;
        $topline=820;
        $footerline=810;
        $toplinehi1=487;
        $toplinehi2=485.5;
        $timefoot=770;
        $user=400;
        $imageleft=700;
        $imageupdown=490;
        $imagetitle=490;
        $imgtileft=680;
        $dis=512;
        $ds=502;
        $gn=492;
        $Top=350;
        $Right=330;
        $LeftFront=32;
        $LeftBack=150;
		
						
			//--add Heddings
        $pdf->ezText(Yii::app()->params['companyName'],14);


        $pdf->ezText('',2);
         //$pdf->ezText('Fleet Management System',14);		
        $pdf->ezText(Yii::app()->params['sysName'],12);
        $pdf->ezText('',5);
        $pdf->ezText('Vehicle Maintenance Cost Report  - (From: '.$vFromDate.' To: '.$vToDate.')',12);
        $pdf->ezText('',5);
        $pdf->ezText('Vehicle No. '.$Vehicle_No,10);
        $pdf->ezText('',18);		
        # $pdf->ezText('',20);
        $pdf->addJpegFromFile("./images/NationalSymbol.jpg",'700','490','71','87');
        //$pdf->addText(650,480,8,"<i>'Towards Next Generation Government'</i>",0);		


         //$pdf->line($topline,$toplinehi1,30,$toplinehi1);
 //$pdf->line($topline,$toplinehi2,30,$toplinehi2);

         //--set the table line style
        $pdf->setLineStyle(1);
        $pdf->line(820,475,15,475);
        $pdf->line(820,473,15,473);
        $pdf->ezText('',15);
        //--add Report footer 
        $pdf->line($footerline,20,15,20);
        $pdf->line(580,20,15,20);
        $pdf->addText(420,10,8,"Generated by- ".Yii::app()->getModule('user')->user()->username);			
        $Time = date("Y/m/d");
        $pdf->addText(540,10,8,$Time,0);					
        $pdf->ezStartPageNumbers(60,10,8);				
		 
        if ($ArrCountR > 0 || $ArrCountS > 0 || $ArrCountL > 0 || $ArrCountI > 0 || $ArrCountF > 0 || $ArrCountE > 0 || $ArrCountB > 0 || $ArrCountT > 0 )  // $ArrCount start
        {
		 
		 	##########################################################
            // Summary Information //
            $Purchase_Price = Yii::app()->db->createCommand('SELECT Purchase_Value FROM ma_vehicle_registry WHERE Vehicle_No= "'.$Vehicle_No.'"')->queryAll();
		//$Cost_Per_Date =  $TotCost + $TotACost;
		
            $Total_Repair_Cost = Yii::app()->db->createCommand('SELECT SUM(Total_Cost) AS "CostR" FROM ma_repairs WHERE Vehicle_No= "'.$Vehicle_No.'"')->queryAll();
            $Total_Repair_Cost = $Total_Repair_Cost[0]['CostR'];


            $Total_Service_Cost = Yii::app()->db->createCommand('SELECT SUM(Estimate_Cost) AS "CostS" FROM services WHERE Vehicle_No= "'.$Vehicle_No.'"')->queryAll();
            $Total_Service_Cost = $Total_Service_Cost[0]['CostS'];	

            $Tot_Cost = $Total_Repair_Cost + $Total_Service_Cost;


            $Total_Repair_Cost_Date = Yii::app()->db->createCommand('SELECT SUM(Repair_Cost) AS "CostR" FROM vehicle_repair_details WHERE Vehicle_No= "'.$Vehicle_No.'" AND Repaired_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'" ')->queryAll();			
            $Total_Repair_Cost_Date = $Total_Repair_Cost_Date[0]['CostR'];

            $Total_Service_Cost_Date=0;	
            $Total_Service_Cost_Date = Yii::app()->db->createCommand('SELECT SUM(Estimate_Cost) AS "CostS" FROM services WHERE Vehicle_No= "'.$Vehicle_No.'" AND Service_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'" ')->queryAll();
            if(count($Total_Service_Cost_Date)>0)
            {
                $Total_Service_Cost_Date= $Total_Service_Cost_Date[0]['CostS'];
            }				
			 
			 			
            $Serviceothercost=0;
            $Serviceothercost=Yii::app()->db->createCommand('SELECT SUM(Other_Costs) AS "Other_Costs" FROM services WHERE Vehicle_No= "'.$Vehicle_No.'" AND Service_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'" ')->queryAll();
            if(count($Serviceothercost)>0)
            {
                $Serviceothercost= $Serviceothercost[0]['Other_Costs'];
            }
			
            $Total_Service_Cost_Date = $Total_Service_Cost_Date+$Serviceothercost;

            $Cost_Per_Date = $Total_Repair_Cost_Date + $Total_Service_Cost_Date;


            $Total_FitnessTest_Cost_Date = Yii::app()->db->createCommand('SELECT SUM(Amount) AS "Cost" FROM fitness_test WHERE Vehicle_No= "'.$Vehicle_No.'" AND Fitness_Test_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'" ')->queryAll();
            $Total_FitnessTest_Cost_Date = $Total_FitnessTest_Cost_Date[0]['Cost'];

            $Total_EmissionTest_Cost_Date = Yii::app()->db->createCommand('SELECT SUM(Amount) AS "Cost" FROM  emission_test WHERE Vehicle_No= "'.$Vehicle_No.'" AND Emission_Test_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'" ')->queryAll();
            $Total_EmissionTest_Cost_Date = $Total_EmissionTest_Cost_Date[0]['Cost'];

            $Total_License_Cost_Date = Yii::app()->db->createCommand('SELECT SUM(Amount) AS "Cost" FROM   license WHERE Vehicle_No= "'.$Vehicle_No.'" AND Date_of_License BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'" ')->queryAll();
            $Total_License_Cost_Date = $Total_License_Cost_Date[0]['Cost'];	

            $Total_Insurance_Cost_Date = Yii::app()->db->createCommand('SELECT SUM(Sum_Insured) AS "Cost" FROM  insurance WHERE Vehicle_No= "'.$Vehicle_No.'" AND Date_of_Insurance BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'" ')->queryAll();

            $Total_Insurance_Cost_Date = $Total_Insurance_Cost_Date[0]['Cost'];

            $Total_Battery_Cost_Date = Yii::app()->db->createCommand('SELECT SUM(Cost) AS "Cost" FROM  battery_details WHERE Vehicle_No= "'.$Vehicle_No.'" AND Replace_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'" ')->queryAll();

            $Total_Battery_Cost_Date = $Total_Battery_Cost_Date[0]['Cost'];

            $Total_Tyre_Cost_Date = Yii::app()->db->createCommand('SELECT SUM(Cost) AS "Cost" FROM tyre_details WHERE Vehicle_No= "'.$Vehicle_No.'" AND Replace_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'" ')->queryAll();

            $Total_Tyre_Cost_Date = $Total_Tyre_Cost_Date[0]['Cost'];

            $Total_Cost_Date = $Total_Repair_Cost_Date + $Total_Service_Cost_Date + $Total_FitnessTest_Cost_Date + $Total_EmissionTest_Cost_Date + $Total_License_Cost_Date + $Total_Insurance_Cost_Date + $Total_Battery_Cost_Date + $Total_Tyre_Cost_Date;											
	
 
		 
            if ($ArrCountR > 0)
            {
                $pdf->ezText('',10);
                $pdf->ezText('<b>Repair Details</b>',10);
                $pdf->ezText('',10);

                $pdf->ezTable($mystrR,'','',array('xPos'=>'right','xOrientation'=>'left','width'=>780));

                //$pdf->line('500',20,15,20);
                $pdf->ezText('',15);
                $pdf->ezText('<b>Sub Total (Repair Cost):   Rs.   '.number_format($Total_Repair_Cost_Date,2).'</b>', 8, array('left'=>575));

            }
		 		 
            if ($ArrCountS > 0)
            {
                $pdf->ezText('',5);
                $pdf->ezText('<b>Service Details</b>',10);
                $pdf->ezText('',10);
                # $pdf->ezTable($mystrS,'','',array('xPos'=>'right','xOrientation'=>'left','width'=>$tbwith));
                $pdf->ezTable($mystrS,'','', 
                array('cols' => array('Service Date' => array('width'=>'77'), 'Service Station Name' => array('width'=>'450'), 'Service Type' => array('width'=>'120'), 
                'Meter Reading' => array('width'=>'77'), 'Next Service Date' => array('width'=>'100'), 'Next Service Milage' => array('width'=>'77'), 'Service Replacement' => array('width'=>'77'), 'Estimate Cost' => array('justification' => 'right', 'width'=>'100'))));

                $pdf->ezText('',10);
                $pdf->ezText('<b>Sub Total (Service Cost):   Rs.   '.number_format($Total_Service_Cost_Date,2).'</b>', 8, array('left'=>575));
            }
		 
		 //$pdf->addText(32, 300,11,"",0);
            if ($ArrCountF > 0)
            { 
                $pdf->ezText('',10);
                $pdf->ezText('<b>Fitness Test Details</b>',10);
                $pdf->ezText('',10);
                #$pdf->ezTable($mystrF,'','',array('xPos'=>'right','xOrientation'=>'left','width'=>$tbwith));
                $pdf->ezTable($mystrF,'','', 
                array('cols' => array('Date of Fitness Test' => array('width'=>'155'), 'Valid From' => array('width'=>'155'), 'Valid To' => array('width'=>'155'), 
                'Fitness Test Result' => array('width'=>'155'), 'Amount' => array('justification' => 'right', 'width'=>'155'))));

                $pdf->ezText('',10);
                $pdf->ezText('<b>Sub Total (Fitness Test):   Rs.   '.number_format($Total_FitnessTest_Cost_Date,2).'</b>', 8, array('left'=>575));
            }
		
            if ($ArrCountE> 0)
            {
                $pdf->ezText('',10);
                $pdf->ezText('<b>Emission Test Details</b>',10);
                $pdf->ezText('',10);
                #$pdf->ezTable($mystrE,'','',array('xPos'=>'right','xOrientation'=>'left','width'=>$tbwith));
                $pdf->ezTable($mystrE,'','', 
                array('cols' => array('Date of Emission Test' => array('width'=>'155'), 'Valid From' => array('width'=>'155'), 'Valid To' => array('width'=>'155'), 
                'Emission Test Result' => array('width'=>'155'), 'Amount' => array('justification' => 'right', 'width'=>'155'))));


                 $pdf->ezText('',10);
                 $pdf->ezText('<b>Sub Total (Emission Test):  Rs.  '.number_format($Total_EmissionTest_Cost_Date,2).'</b>', 8, array('left'=>575));
			 
            }
		 
            if ($ArrCountL > 0)
            {
                $pdf->ezText('',10);
                $pdf->ezText('<b>License Details</b>',10);
                $pdf->ezText('',10);
                #$pdf->ezTable($mystrS,'','',array('xPos'=>'right','xOrientation'=>'left','width'=>$tbwith));
                $pdf->ezTable($mystrL,'','', 
                array('cols' => array('Date of License' => array('width'=>'200'), 'Valid From' => array('width'=>'185'), 'Valid To' => array('width'=>'185'), 'Amount' => array('justification' => 'right', 'width'=>'200'))));


                $pdf->ezText('',10);
                $pdf->ezText('<b>Sub Total (License Cost):  Rs.    '.number_format($Total_License_Cost_Date,2).'</b>', 8,  array('left'=>575));
			
            }
		 
            if ($ArrCountI > 0)
            {
                $pdf->ezText('',10);
                $pdf->ezText('<b>Insurance Details</b>',10);
                $pdf->ezText('',10);
                # $pdf->ezTable($mystrI,'','',array('xPos'=>'right','xOrientation'=>'left','width'=>$tbwith));
                $pdf->ezTable($mystrI,'','', 
                array('cols' => array('Date of Insurance' => array('width'=>'110'), 'Valid From' => array('width'=>'110'), 'Valid To' => array('width'=>'110'), 
                'Company Name' => array('width'=>'112'), 'Insurance Type' => array('width'=>'110'), 'Insurance Amount' => array('justification' => 'right', 'width'=>'112'), 'Sum Insured' => array('justification' => 'right', 'width'=>'112'))));



                $pdf->ezText('',10);
                $pdf->ezText('<b>Sub Total (Sum Insured):   Rs.   '.number_format($Total_Insurance_Cost_Date,2).'</b>', 8, array('left'=>575));
			
            }
		 
            if ($ArrCountB > 0)
            {
                $pdf->ezText('',10);
                $pdf->ezText('<b>Battery Details</b>',10);
                $pdf->ezText('',10);
                #$pdf->ezTable($mystrB,'','',array('xPos'=>'right','xOrientation'=>'left','width'=>$tbwith));
                $pdf->ezTable($mystrB,'','', 
                array('cols' => array('Replace Date' => array('width'=>'130'), 'Battery Type' => array('width'=>'130'), 'Approved Date' => array('width'=>'130'), 
                'Approved By' => array('width'=>'130'), 'Replace Status' => array('width'=>'130'), 'Cost' => array('justification' => 'right', 'width'=>'130'))));

                $pdf->ezText('',10);
                $pdf->ezText('<b>Sub Total (Battery Cost):  Rs.   '.number_format($Total_Battery_Cost_Date,2).'</b>', 8, array('left'=>575));
			
            }
		 
            if ($ArrCountT > 0)
            {
                $pdf->ezText('',10);
                $pdf->ezText('<b>Tire Details</b>',10);
                $pdf->ezText('',10);
                $pdf->ezTable($mystrT,'','', 
                array('cols' => array('Replace Date' => array('width'=>'130'), 'Tyre Type' => array('width'=>'130'), 'Tyre Size' => array('width'=>'130'), 
                'Approved Status' => array('width'=>'130'), 'Replace Status' => array('width'=>'130'), 'Cost' => array('justification' => 'right', 'width'=>'130'))));

                $pdf->ezText('',10);
                $pdf->ezText('<b>Sub Total (Tire Cost):   Rs.   '.number_format($Total_Tyre_Cost_Date,2).'</b>',8, array('left'=>590));
			
            }
		 
            if($Total_Cost_Date !='0.00')
            {
                $pdf->ezText('',15);
                $pdf->ezText('<b>Total Maintanence Cost:   Rs.   '.number_format($Total_Cost_Date,2).'</b>',10,array('left'=>510));
                $pdf->ezText('<b>====================</b>', 10, array('left'=>655));
            }
            else
            {
                $pdf->ezText('* No data available for selected criteria',10);
                $pdf->ezStream();
            }
            $pdf->ezStream();	 				
		 					
        }
        else
        {
                $pdf->ezText('* No data available for selected criteria',10);
                $pdf->ezStream();
        }
		
    }	
}

?>
