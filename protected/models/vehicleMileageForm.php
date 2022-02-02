<?php

class vehicleMileageForm extends CFormModel
{

	//public $Vehicle_No;
	public $Vehicle_Category_ID;

	
	
	public function rules()
	{
		return array(
			array('Vehicle_Category_ID','required')	
			
		);
	}
	
	public function attributeLabels()
    {
        return array(
			'Vehicle_Category_ID'=>'Vehicle Category'			
		);                    
            
    }
	
	
	/*public function combodata($var)
	{
		
		if($var == 'DS')
		{
		   $values=	Yii::app()->db->createCommand()
                   ->select('DS_Division_ID, DS_Division_Name')
                   ->from('ma_ds_divisions')
					   /* ->join('tbl_profile p', 'u.id=p.user_id')
						->where('id=:id', array(':id'=>$id)) */ 
				   //->queryAll();
   			
		//}
		//elseif($var == 'GN')
		//{
		   	//$values=Yii::app()->db->createCommand()
                   //->select('GN_Division_ID, GN_Division_Name')
                   //->from('ma_gn_divisions')
                   //->queryAll();
				  
		//}
		//elseif($var == 'Member')
		//{
		   	//$values=Yii::app()->db->createCommand()
                   //->select('Member_ID, Name_with_Initials')
                   //->from('personal_details')
                   //->queryAll();
				  
		//}
		
		//return($values);
	//}*/
	
    public function rprint($vCatID)
	{
		$DataSource = new ReportDataSource;
		require_once('./protected/class/class.ezpdf.php');
		$pdf = new Cezpdf();
		$pdf->selectFont('./protected/class/fonts/Times-Roman.afm');
		
		//--Get data array 
		$mystr=$DataSource->ArrayMileageInfo($vCatID);		
		$ArrCount = count($mystr);	
		$cat='';
		$catArr = Yii::app()->db->createCommand('select Category_Name from ma_vehicle_category where Vehicle_Category_ID ='.$vCatID)->queryAll();
		
		if(count($catArr)>0)
		{
			$cat=$catArr[0]['Category_Name'];
		}
						
			//--add Heddings
		 //$pdf->ezText('Ministry of Public Administration and Home Affairs',19);
		 $pdf->ezText(Yii::app()->params['companyName'],19);
	
		//$pdf->ezText('Local Governance Program',15);
		 $pdf->ezText('',2);
		 //$pdf->ezText('Fleet Management System',14);		
		 $pdf->ezText(Yii::app()->params['sysName'],14);
		 $pdf->ezText('',5);
		 $pdf->ezText('Vehicle Mileage Report - Category wise ',12);
		 $pdf->ezText('Category - '.$cat,10);
		 $pdf->ezText('',28);		
		 $pdf->addJpegFromFile("./images/NationalSymbol.jpg",'500','740','71','87');
		 $pdf->addText(436,730,8,"<i>''Towards Next Generation Government''</i>",0);		
		
		 $pdf->ezText('',5);
		 //--add Line to report
		 $pdf->line(560,723,20,723);
		 $pdf->line(560,724.5,20,724.5);
		 //--set the table line style
		 //$pdf->setLineStyle(1);			 
		 //$pdf->line(580,20,15,20);		 
		 		 
		 $Top=690;
		 $Right=330;
		 $LeftFront=32;
		 $LeftBack=150;
		 
		 /*$pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30, $Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Type</b>",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Category_Name']."</i>",0);
		 
		 $pdf->addText($Right, $Top+7,10,"<b>Status</b>",0);
		 $pdf->addText($Right+120, $Top+7,10,"<i>" .$mystr[0]['Vehicle_Status']."</i>",0);
		 
		 
		 $Top=$Top-20;
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Make</b>",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Make']."</i>",0);
		 		 
		 
		 $pdf->addText($Right, $Top+7,10,"<b>Model</b>",0);
     	 $pdf->addText($Right+120, $Top+7,10,"<i>" .$mystr[0]['Model']."</i>",0);
		 
		 $Top=$Top-20;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Purchase Value</b>",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Purchase_Value']."</i>",0);
		 
		 $pdf->addText($Right, $Top+7,10,"<b>Purchase Date</b>",0);
     	 $pdf->addText($Right+120, $Top+7,10,"<i>" .$mystr[0]['Purchase_Date']."</i>",0);
		 
		 
		 $Top=$Top-20;
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Engine No</b>",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Engine_No']."</i>",0);
		 
    	 $pdf->addText($Right, $Top+7,10,"<b>Chassi No</b>",0);
     	 $pdf->addText($Right+120, $Top+7,10,"<i>" .$mystr[0]['Chassis_No']."</i>",0);
		 
		 $Top=$Top-20;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText($LeftFront, $Top+7,10,"<b>Fuel Type</b>",0);
		 $pdf->addText($LeftBack, $Top+7,10,"<i>" .$mystr[0]['Fuel_Type']."</i>",0);
		 
		 
		 
		 $pdf->addText($Right, $Top+7,10,"<b>Tyre Size</b>",0);
     	 $pdf->addText($Right+120, $Top+7,10,"<i>" .$mystr[0]['Tyre_Size']."</i>",0);
		 
		 $Top=$Top-20;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText(32, $Top+7,10,"Serial No.",0);
		 
		 $Top=$Top-40;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText(32, $Top+7,10,"Color",0);
		 
		 $Top=$Top-40;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText(32, $Top+7,10,"Type",0);
		 
		 $Top=$Top-40;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText(32, $Top+7,10,"Type",0);
		 
		 $Top=$Top-40;
		 $pdf->setColor(0.9,0.9,0.9);
		 $pdf->filledRectangle(30,$Top,530,20);
		 $pdf->setColor(0,0,0);
		 $pdf->addText(32, $Top+7,10,"Type",0);*/
		 //$pdf->ezText('',0);
		// $pdf->ezTable($mystr,'','',array('Vehicle_No'=>'Vehicle No.', 'Chassis_No'=>'Chassis No.','Fuel_Type'=>'Fuel Type', 'Battery_Type'=>'Battery Type','Model'=>'Model','Make'=>'Make','Service_Mileage'=>'Service Mileage','Servicing_Period'=>'Servicing Period','odometer'=>'Odometer'),'',array('xPos'=>'right','xOrientation'=>'left','width'=>540));
		
		if ($ArrCount > 0)  // $ArrCount start
		{
			$pdf->ezTable($mystr,array('Vehicle_No'=>'Vehicle No.', 'Chassis_No'=>'Chassis No.','Fuel_Type'=>'Fuel Type', 'Battery_Type'=>'Battery Type','Model'=>'Model','Make'=>'Make','Service_Mileage'=>'Service Mileage','Servicing_Period'=>'Servicing Period','odometer'=>'Odometer'),'',array('xPos'=>'right','xOrientation'=>'left','width'=>540));
					
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
