<?php

class vehicleCategoryForm extends CFormModel
{

	//public $Vehicle_No;
	public $Vehicle_Category_ID;

	
	
	public function rules()
	{
		return array(
			array('Vehicle_Category_ID', 'required')	
			
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
		$pdf->Cezpdf($paper='A4',$orientation='landscape');
		$pdf->selectFont('./protected/class/fonts/Courier.afm');
		
		//--Get data array 
		$mystr=$DataSource->ArrayVehicleCategory($vCatID);		
		$ArrCount = count($mystr);	
		
		 
		if ($ArrCount > 0)  // $ArrCount start
		{				
		//--add company Heddings		 
		 $pdf->ezText(Yii::app()->params['companyName'],14);
		 $pdf->ezText('',2);
		 //add system name	
		 $pdf->ezText(Yii::app()->params['sysName'],12);
		 $pdf->ezText('',5);
		 $pdf->ezText('Vehicle Registry - Category wise ',12);
		 $pdf->ezText('',5);
		 $pdf->ezText('Category - '.$mystr[0]['Category_Name'],10);
		 $pdf->ezText('',28);		
		 $pdf->addJpegFromFile("./images/NationalSymbol.jpg",'700','490','71','87');
		 //$pdf->addText(650,480,8,"<i>'Towards Next Generation Government'</i>",0);		
		
		 $pdf->ezText('',15);
		 //--add Line to report
		 $pdf->line(800,460,30,460);
		 $pdf->line(800,462,30,462);
                 
                 $pdf->ezText('',5);
		 //--set the table line style
		 //$pdf->setLineStyle(1);			 
		 //$pdf->line(580,20,15,20);		 
		 		 
		 $Top=690;
		 $Right=330;
		 $LeftFront=152;
		 $LeftBack=150;
		 
	
	$pdf->ezTable($mystr,array('Vehicle_No'=>'Vehicle No.', 'Model'=>'Model', 'Make'=>'Make','Purchase_Value'=>'Purchase Value (Rs)','Purchase_Date'=>'Purchase Date','Engine_No'=>'Engine No.', 'Chassis_No'=>'Chassis No.', 'Allocation_Type'=>'Allocation Type', 'odometer'=>'Odometer','Vehicle_Status'=>'Status')
,'',array('cols' => array('Purchase_Value'=>array('justification' => 'right'),'odometer'=>array('justification' => 'right')),'xPos'=>'right','xOrientation'=>'left','width'=>780));
		}
		else
		{
			$pdf->ezText('* No data available for selected criteria',10);
			$pdf->ezStream();
		} 
		 
		 $pdf->setColor(0.0,0.0,0.0);
		
			//--add Line to report (Page footer)---
			$pdf->line(820,20,15,20);
			$pdf->addText(420,10,8,"Generated by- ".Yii::app()->getModule('user')->user()->username);			
			$Time = date("Y/m/d");
			$pdf->addText(540,10,8,$Time,0);					
			$pdf->ezStartPageNumbers(60,10,8);					
			//---Footer End here----
				
			$pdf->ezStream();					
		
	}	
}

?>
