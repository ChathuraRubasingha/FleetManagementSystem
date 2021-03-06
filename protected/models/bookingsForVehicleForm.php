<?php

class bookingsForVehicleForm extends CFormModel {
    
    public $Vehicle_No;
    public $Valid_From;
    public $Valid_To;
    
    public function rules() {
        return array(
            array('Valid_To, Valid_From, Vehicle_No', 'required')
        );
    }
    
    public function attributeLabels() {
        return array(
            'Vehicle_No'=>'Vehicle_No',
            'Valid_To'=> 'To',
            'Valid_From'=>'From',
            
        ); 
    }
    
    public function rprint($Vehicle_No, $Valid_From, $Valid_To)
    {
        $DataSource = new ReportDataSource;
        require_once('./protected/class/class.ezpdf.php');
        $pdf = new Cezpdf();	  
        $pdf->Cezpdf($paper='A4',$orientation='landscape');
        $pdf->selectFont('./protected/class/fonts/Courier.afm');
      
        $result = $DataSource->ArrayBookingForVehicle($Vehicle_No, $Valid_From, $Valid_To);
        $ArrCount = count($result);
    
          
       	$pdf->ezText(Yii::app()->params['companyName'],14);
	
		
		 $pdf->ezText('',2);
			
		 $pdf->ezText(Yii::app()->params['sysName'],12);
		 $pdf->ezText('',5);
		 $pdf->ezText('Bookings From - '.$Valid_From.' to '.$Valid_To,12);
		 $pdf->ezText('Vehicle No -'.$Vehicle_No,12); 
		 $pdf->ezText('',28);		
		 $pdf->addJpegFromFile("./images/NationalSymbol.jpg",'700','490','71','87');
		 //$pdf->addText(650,480,8,"<i>'Towards Next Generation Government'</i>",0);		
		
		 $pdf->ezText('',10);
		 //--add Line to report
		   
                $pdf->line(800,473,30,473);
                $pdf->line(800,475.5,30,475.5);
		 		 
		 		 
		 $Top=690;
		 $Right=330;
		 $LeftFront=32;
		 $LeftBack=150;
		 
                if($ArrCount > 0)
                {
                   $pdf->ezTable($result, array('req_by'=>'Requested By','Full_Name'=>'Assigned Driver', 
                 'FromDate'=>'Rrequested Date','Place_from'=>'Form','Place_to'=>'To','Description'=>'Reason','Out_Time'=>'Out Time','In_Time'=>'In Time'),'',array('xPos'=>'right','xOrientation'=>'left','width'=>780));
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
