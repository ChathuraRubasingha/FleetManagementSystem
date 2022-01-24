<?php

class AccidentReportVehicleWiseForm extends CFormModel
{

    public $Vehicle_No;
    public $From_Date;
    public $To_Date;
    public $Show_Images;
    //public $Valid_From;
	//public $Valid_To;

	
    public function rules()
    {
        return array(
            array('Vehicle_No ,From_Date, To_Date', 'required')				
        );
    }
	
    public function attributeLabels()
    {
        return array(
            'Vehicle_No'=>'Vehicle Number',
            'From_Date'=>'From Date',
            'To_Date'=>'To Date',
            'Show_Images' =>'Show Accident Images'
            );
    }
    
    public function rprint($vNo, $fromDate, $toDate, $Show_Images)
    {
        $DataSource = new ReportDataSource;
        require_once('./protected/class/class.ezpdf.php');
        $pdf = new Cezpdf();
        $pdf->Cezpdf($paper='A4',$orientation='landscape');
        $pdf->selectFont('./protected/class/fonts/Courier.afm');
$pdf->addMessage('fdsfdsfdsfds');
        //--Get data array 
        $mystr=$DataSource->ArrayAccidentDetailsVehiclewise($vNo, $fromDate, $toDate);		
        
        $ArrCount = count($mystr);

        if ($ArrCount > 0)  // $ArrCount start
        {				
            //--add company Heddings		 
            $pdf->ezText(Yii::app()->params['companyName'],14);
            $pdf->ezText('',2);
            //add system name	
            $pdf->ezText(Yii::app()->params['sysName'],12);
            $pdf->ezText('',5);
            $pdf->ezText("Vehicle Accident Details Report",12);
             $pdf->ezText('',5);
            $pdf->ezText('Vehicle Number - '.$vNo,10);
            $pdf->ezText('',5);
             
            $pdf->ezText('',28);		
            $pdf->addJpegFromFile("./images/NationalSymbol.jpg",'700','490','71','87');
            //$pdf->addText(650,480,8,"<i>'Towards Next Generation Government'</i>",0);		

            $pdf->ezText('',5);
            //--add Line to report
            $pdf->line(820,475,15,475);
            $pdf->line(820,473,15,473);
            
           
            //--set the table line style
            //$pdf->setLineStyle(1);			 
            //$pdf->line(580,20,15,20);		 

            $Top=690;
            $Right=330;
            $LeftFront=152;
            $LeftBack=150;
            
            $midTextSize = 10;
            $yPosition=453;
            $td1 = 90;
            $td2 = 390;
            $td3 = 420;
            $a = 700;
            //$b=30;
            
            for($i = 0; $i < $ArrCount; $i++)
            {
                /*    Add Accident Images       */
                if($Show_Images === '1')
                {
                    $accID = $mystr[$i]['Accident_ID'];           
                    $v_number =  $vNo;
                    $directory = Yii::getPathOfAlias('webroot').'/accidentImages/'.CHtml::encode($vNo).'/'.CHtml::encode($accID).'/';

                    $b = $yPosition-88;
                    if (file_exists($directory)) 
                    {                    
                        chdir($directory);

                        $images = glob("*.{jpg,JPG}", GLOB_BRACE);
                        $j=0;
                        foreach ($images as $image) 
                        {
                            if($j<5) //display 5 images
                            {
                                $imgDir = "$directory$image";                            
                                $pdf->addJpegFromFile($imgDir,$a,$b,'90','70');
                                $b -= 75;
                                $j++;
                            }
                        }                    
                    } 
                }
                
                $yPosition=$yPosition-20;
               
                $pdf->setColor(0.5,0.8,1.8);
                $pdf->filledRectangle(40,$yPosition+8,750,15);
                $pdf->setColor(0.2,0.0,0.9);
                $pdf->addText(62,$yPosition+11,11,"<i>Accident Date : </i>".$mystr[$i]['Date_and_Time']."",0);
                $pdf->setColor(0.0,0.0,0.0);             
               
                $pdf->addText($td1,$yPosition,$midTextSize," ",0);
                $pdf->addText($td2,$yPosition,$midTextSize," ",0);
                $pdf->addText($td3,$yPosition,$midTextSize," ",0);                
                
                $yPosition=$yPosition-20;
               
                $pdf->addText($td1,$yPosition,$midTextSize,"Accident Place",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Accident_Place']."</i>",0);
                
                $yPosition=$yPosition-20;
                
                $pdf->addText($td1,$yPosition,$midTextSize,"Details",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Details']."</i>",0);
                
                $yPosition=$yPosition-20;
               
                $pdf->addText($td1,$yPosition,$midTextSize,"Police Station",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Police_Station']."</i>",0);
                
                $yPosition=$yPosition-20;
                               
                $pdf->addText($td1,$yPosition,$midTextSize,"Address of the Police Station",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Address']."</i>",0);
                
                $yPosition=$yPosition-20;
                
                $pdf->addText($td1,$yPosition,$midTextSize,"Police Report Number",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Police_Report_No']."</i>",0);
                
                
                $yPosition=$yPosition-20;
                
                $pdf->addText($td1,$yPosition,$midTextSize,"Accident Type",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Accident_Type']."</i>",0);
                
                $yPosition=$yPosition-20;
                                
                $pdf->addText($td1,$yPosition,$midTextSize,"Estimation of the Damage",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>Rs. ".$mystr[$i]['Damage_Estimate']."</i>",0);
                
                $yPosition=$yPosition-20;
                                
                $pdf->addText($td1,$yPosition,$midTextSize,"Estimated Date",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Estimated_Date']."</i>",0);
                
                $yPosition=$yPosition-20;
                              
                $pdf->addText($td1,$yPosition,$midTextSize,"Insurance Company",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Insurance_Company_Name']."</i>",0);
                
                $yPosition=$yPosition-20;
                                
                $pdf->addText($td1,$yPosition,$midTextSize,"Claime Amount from the Insurance Company",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>Rs. ".$mystr[$i]['Claime_Amount']."</i>",0);
                
                $yPosition=$yPosition-20;
                
                $pdf->addText($td1,$yPosition,$midTextSize,"Claime Date from the Insurance Company",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Claime_Date']."</i>",0);
                
                $yPosition=$yPosition-20;
                
                $pdf->addText($td1,$yPosition,$midTextSize,"Driver Name",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Complete_Name']."</i>",0);
                
                $yPosition=$yPosition-20;
               
                $pdf->addText($td1,$yPosition,$midTextSize,"Claime Amount from the Driver",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>Rs. ".$mystr[$i]['Driver_Claim_Amount']."</i>",0);
                
                $yPosition=$yPosition-20;
                
                $pdf->addText($td1,$yPosition,$midTextSize,"Claime Date from the Driver",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Driver_Claim_Date']."</i>",0);
              
                $yPosition=$yPosition-20;
                
                $pdf->addText($td1,$yPosition,$midTextSize,"Third Party  Name",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Thirdparty_Name']."</i>",0);
                
                $yPosition=$yPosition-20;
               
                $pdf->addText($td1,$yPosition,$midTextSize,"Claime Amount from the Third Party",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>Rs. ".$mystr[$i]['Thirdparty_Claim_Amount']."</i>",0);
                
                $yPosition=$yPosition-20;
               
                $pdf->addText($td1,$yPosition,$midTextSize,"Claime Date from the Third Party",0);
                $pdf->addText($td2,$yPosition,$midTextSize,":",0);
                $pdf->addText($td3,$yPosition,$midTextSize,"<i>".$mystr[$i]['Thirdparty_Claim_Date']."</i>",0);
                
                
                
                //$pdf->addText($td1,$yPosition=$yPosition-50,150," ",0);    
                $k = $i+1;
               
                $yPosition=$this->setNewPage($pdf, $k, $ArrCount);
                
            }

	 }
        else
        {            
            $pdf->ezText('* No data available for selected criteria',10);
            $pdf->ezStream();
        } 
		 
        $pdf->setColor(0.0,0.0,0.0);
		
			//--add Line to report (Page footer)---
       /* $pdf->line(820,20,15,20);
        $pdf->addText(420,10,8,"Generated by : ".Yii::app()->getModule('user')->user()->username);			
        $Time = date("Y/m/d");
        $pdf->addText(540,10,8,$Time,0);					
        $pdf->ezStartPageNumbers(60,10,8);	*/				
        //---Footer End here----

        $pdf->ezStream();
        
        
   
		
    }
        
    public function getVehicleListForLocation() 
    {
        $superUser = Yii::app()->getModule('user')->user()->superuser;
        $locID = Yii::app()->getModule('user')->user()->Location_ID;
        $criteria = new CDbCriteria();
        $criteria->select = "t.Vehicle_No, vc.Category_Name as Vehicle_Category_ID";
        $join = "INNER JOIN ma_vehicle_category vc on vc.Vehicle_Category_ID = t.Vehicle_Category_ID";

        if($superUser !== '1')
        {
            $join .= " INNER JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No";
            $criteria->condition="vl.Current_Location_ID =$locID";
        }

        $criteria->join=$join;
        $criteria->order="vc.Category_Name, t.Vehicle_No";
        $arr = MaVehicleRegistry::model()->findAll($criteria);
        return $arr;
    }
    
    function setNewPage($pdf, $k, $ArrCount)
    {
        $pdf->setColor(0.0,0.0,0.0);
        $pdf->line(800,20,15,20);

        $pdf->addText(420,10,8,"Generated by : ".Yii::app()->getModule('user')->user()->username);			
        $Time = date("Y/m/d");
        $pdf->addText(540,10,8,$Time,0);					
        $pdf->ezStartPageNumbers(60,10,8);	
        if($k !== $ArrCount)
        {
            $pdf->ezNewPage(); //--Go to new Page--
        }

        
        return $yPosition=555;
    }
	
}

?>
