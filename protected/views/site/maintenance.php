<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>


</head>

<body>
	<div id="maintenance" > 
    
    	<div id="menu" class="group" style="width:200px; float:left">

            <ul>
            
                <li><?php echo CHtml::link('Services',array('/tRServices/admin')); ?></li>
                
                <li><?php echo CHtml::link('Insurance',array('/tRInsurance/admin')); ?></li>
                
                <li><?php echo CHtml::link('Emission Test',array('/tREmissionTest/admin')); ?></li>
                
                <li><?php
                        if($status == 'Yes')
                        {
                            echo CHtml::link('Fitness Test',array('/tRFitnessTest/admin')); 
                        }	
                    ?>
                </li>
                
                <li><?php echo CHtml::link('License',array('/tRLicense/admin')); ?></li>
                
                <li><?php echo CHtml::link('Repairs',array('/maRepairs/admin')); ?></li>    
            
            </ul>

		</div>
        
        <div id="view" class="group" style="width:400px; float:left; margin-left:20px">
        
        	<?php echo $this->renderPartial('//maVehicleRegistry/view', array('vehicleRegistry'=>$vehicleRegistry)); ?>	
        
        </div>
    
    </div>
	






<div style="height:380px" ></div>


</body>
</html>
