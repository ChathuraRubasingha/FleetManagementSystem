<?php

class VehicleDetailsForm extends CFormModel
{

	public $Vehicle_No;
	public $Vehicle_Category_ID;

	
	public function rules()
	{
		return array(
			
		);
	}
	
	 public function attributeLabels()
    {
        return array(
			'DS_Division_ID'=>'DS Division',
			'GN_Division_ID'=>'GN Division',
			'Member_ID'=>'Member'
		);
                      
               
    }
	
	
    public function rprint($Vehicle_No)
	{
		$DataSource = new ReportDataSource;
		require_once('./protected/class/class.ezpdf.php');
		$pdf = new Cezpdf();
        $pdf->selectFont('./protected/class/fonts/Courier.afm');
		
		//--Get data array 
		$mystr=$DataSource->ArrayVehicleDetails($Vehicle_No);		
		$ArrCount = count($mystr);	
		
						
			//--add Heddings
		 
		 $pdf->ezText(Yii::app()->params['companyName'],14);
		 $pdf->ezText('',2);		
		 $pdf->ezText(Yii::app()->params['sysName'],12);
		 $pdf->ezText('',5);
		 $pdf->ezText('Vehicle Details Report ',12);
		 $pdf->ezText('',5);
		 $pdf->ezText('Vehicle No. '.$Vehicle_No,10);
		 $pdf->ezText('',10);		
		 $pdf->addJpegFromFile("./images/NationalSymbol.jpg",'500','740','71','87');
		 //$pdf->addText(400,730,8,"<i>'Towards Next Generation Government'</i>",0);
		
		 //--add Line to report
		 $pdf->line(560,723,30,723);
		 $pdf->line(560,724.5,30,724.5);
		 //--set the table line style
		 $pdf->setLineStyle(1);			 
		 $pdf->line(580,20,15,20);		 
		 		 
		 $Top=690;
		 $Right=330;
		 $LeftFront=32;
		 $LeftBack=150;
		 
		 $pdf->line(560,723,30,723);
		 $pdf->line(560,724.5,30,724.5);
		 //--set the table line style
		 $pdf->setLineStyle(1);			 
		 $pdf->line(580,20,15,20);		 
		 		 
		 $Top=630;
		 $Right=330;
		 $LeftFront=32;
		 $LeftBack=150;
		 
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30, $Top,530,20);
		 $pdf->setColor(0,0,0);
		 if ($ArrCount > 0)  // $ArrCount start
		{
			$VehImg=$mystr[0]['Vehicle_image'];
			if($VehImg!='')
		 	{				
				$VehImg="./VechicleReg/".$VehImg;		
		 		$pdf->addJpegFromFile($VehImg,450,'655','100','50');		  	
		 	}
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Category</b>",0); //////// start
		 $pdf->addText($LeftFront+100, $Top+7,10,":",0); 
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Category_Name']."</i>",0);
		 
		 $pdf->addText($Right, $Top+7,10,"<b>Status</b>",0);
		 $pdf->addText($Right+110, $Top+7,10,":",0);
		 $pdf->addText($Right+130, $Top+7,10,"<i>" .$mystr[0]['Vehicle_Status']."</i>",0);
		 
		 
		 $Top=$Top-20;
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Make</b>",0);
		 $pdf->addText($LeftFront+100, $Top+7,10,":",0); 
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Make']."</i>",0);
		 		 
		 
		 $pdf->addText($Right, $Top+7,10,"<b>Model</b>",0);
		 $pdf->addText($Right+110, $Top+7,10,":",0);
     	 $pdf->addText($Right+130, $Top+7,10,"<i>" .$mystr[0]['Model']."</i>",0);
		 
		 $Top=$Top-20;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Engine No.</b>",0);
		 $pdf->addText($LeftFront+100, $Top+7,10,":",0); 
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Engine_No']."</i>",0);
		 
		 $pdf->addText($Right, $Top+7,10,"<b>Chassi No</b>",0);
		 $pdf->addText($Right+110, $Top+7,10,":",0);
     	 $pdf->addText($Right+130, $Top+7,10,"<i>" .$mystr[0]['Chassis_No']."</i>",0);
		 
		 
		 $Top=$Top-20;
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Purchase Date</b>",0);
		 $pdf->addText($LeftFront+100, $Top+7,10,":",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Purchase_Date']."</i>",0);
		 
    	 $pdf->addText($Right, $Top+7,10,"<b>Purchase Value (Rs.)</b>",0);
		 $pdf->addText($Right+110, $Top+7,10,":",0);
     	 $pdf->addText($Right+130, $Top+7,10,"<i>" .number_format($mystr[0]['Purchase_Value'],2)."</i>",0);
		 
		 $Top=$Top-20;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Fuel Type</b>",0);
		 $pdf->addText($LeftFront+100, $Top+7,10,":",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Fuel_Type']."</i>",0);
		 
		 
		 
		 $pdf->addText($Right, $Top+7,10,"<b>Fuel Consumption</b>",0);
		 $pdf->addText($Right+110, $Top+7,10,":",0);
     	 $pdf->addText($Right+130, $Top+7,10,"<i>" .$mystr[0]['Fuel_Consumption']."</i>",0);
		 
		 $Top=$Top-20;
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Tyre Type</b>",0);
		 $pdf->addText($LeftFront+100, $Top+7,10,":",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Battery_Type']."</i>",0);/////
		 
    	 $pdf->addText($Right, $Top+7,10,"<b>Tyre Size</b>",0);
		 $pdf->addText($Right+110, $Top+7,10,":",0);
     	 $pdf->addText($Right+130, $Top+7,10,"<i>" .$mystr[0]['Tyre_Size']."</i>",0);
		 
		 $Top=$Top-20;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText($LeftFront, $Top+7,10,"<b>No of Tyres</b>",0);
		 $pdf->addText($LeftFront+100, $Top+7,10,":",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['No_of_Tyres']."</i>",0);
		 
		 $pdf->addText($Right, $Top+7,10,"<b>Battery Type</b>",0);
		 $pdf->addText($Right+110, $Top+7,10,":",0);
     	 $pdf->addText($Right+130, $Top+7,10,"<i>" .$mystr[0]['Battery_Type']."</i>",0);
		 
		 $Top=$Top-20;
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Service Mileage</b>",0);
		 $pdf->addText($LeftFront+100, $Top+7,10,":",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Service_Mileage']."</i>",0);/////
		 
    	 $pdf->addText($Right, $Top+7,10,"<b>Servicing Period</b>",0);
		 $pdf->addText($Right+110, $Top+7,10,":",0);
     	 $pdf->addText($Right+130, $Top+7,10,"<i>" .$mystr[0]['Servicing_Period']."</i>",0);
		 
		 $Top=$Top-20;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Allocation Type</b>",0);
		 $pdf->addText($LeftFront+100, $Top+7,10,":",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Allocation_Type']."</i>",0);
		 
		 $pdf->addText($Right, $Top+7,10,"<b>Eligible for Fitness Test</b>",0);
		 $pdf->addText($Right+110, $Top+7,10,":",0);
     	 $pdf->addText($Right+130, $Top+7,10,"<i>" .$mystr[0]['Fitness_test']."</i>",0);
		 
		 $Top=$Top-20;
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Current Odometer</b>",0);
		 $pdf->addText($LeftFront+100, $Top+7,10,":",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['odometer']."</i>",0);/////
		 ############################################################################################################
		 
		
		 }
		else
		{
			$pdf->ezText('* No data available for selected criteria',10);
			$pdf->ezStream();
		}


		 $pdf->setColor(0.0,0.0,0.0);
		
			//--add Line to report (Page footer)---
			$pdf->line(580,20,15,20);
			 $pdf->addText(420,10,8,"Generated by- ".Yii::app()->getModule('user')->user()->username);			
			$Time = date("Y/m/d");
			$pdf->addText(540,10,8,$Time,0);					
			$pdf->ezStartPageNumbers(60,10,8);					
			//---Footer End here----
				
			$pdf->ezStream();					
		
	}	
}

?>
