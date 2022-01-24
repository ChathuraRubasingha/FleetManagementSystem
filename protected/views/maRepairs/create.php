<?php
$this->breadcrumbs=array(
	'Manage'=>array('maVehicleRegistry/maintenanceRegistry'),
	'Create',
);

$this->menu=array(
	//array('label'=>'Repairs', 'url'=>array('index')),
	//array('label'=>'Manage Repairs', 'url'=>array('admin')),
);
?>

<div id="maindiv" style="width:1200px">
    <div class="group" style="width:200px; float:left; margin-left:30px;">
    <div id="menu"  style="width:200px; float:left; padding-left:10px; padding-top:20px">
    
    <ul>
            
                <li><?php echo CHtml::link('Services',array('/tRServices/Create')); ?></li>
                
                <li><?php echo CHtml::link('Insurance',array('/tRInsurance/Create')); ?></li>
                
                <li><?php echo CHtml::link('Emission Test',array('/tREmissionTest/Create')); ?></li>
                
                <li><?php
				$status=Yii::app()->session['fitnessStatus'];
                        if($status == 'Yes')
                        {
                            echo CHtml::link('Fitness Test',array('/tRFitnessTest/Create')); 
                        }	
                    ?>
                </li>
                
                <li><?php echo CHtml::link('License',array('/tRLicense/Create')); ?></li>
                
                <li><?php echo CHtml::link('Repairs',array('/maRepairs/Create')); ?></li>
                  
                <li><?php echo CHtml::link('Battery',array('/tRBatteryDetails/battery')); ?></li> 
                
                <li><?php echo CHtml::link('Tyre',array('/tRTyreDetails/tyre')); ?></li>      
            
            </ul>

		</div>
    
    
    </div>
    
    <div  style="width:900px; float:left; ">

<div class="group" style="padding-left:40px; margin-left:20px;">

<h1>Create Repairs</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
</div>
</div>