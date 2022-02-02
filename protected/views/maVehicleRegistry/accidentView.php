<?php
$this->breadcrumbs=array(
	'Accident'=>array('maVehicleRegistry/accident'),
	'Vehicle Details'

);

/*$this->menu=array(
	array('label'=>'Add New Vehicle', 'url'=>array('create')),
	array('label'=>'Manage Vehicle Registry', 'url'=>array('admin')),
);*/
?>

<?php
  	$vehicleId = Yii::app()->session['accidentVehicleId'];
	//$type = Yii::app()->request->getQuery('type');
	
?>


<!--<div id="maindiv" style="width:1100px">-->

    <!--<div class="group" style="width:20%; height:230px; float:left; margin-left:3%; margin-top:2.4%">-->
    <div class="group" style="width:20%;  height:85px; float:left; margin-left:3%; margin-top:2.4%">
    <div id="menu"  style="width:20%; float:left; padding-left:2%; padding-top:2%">

            <ul>
            
                <li><?php echo CHtml::link('Add New Accident',array('maVehicleRegistry/accident')); ?></li>
                
                <li><?php echo CHtml::link('Add Estimations',array('/tRAccident/estimateAccident')); ?></li>
                
                <li><?php echo CHtml::link('Add Claims',array('/tREstimateDetails/estimateClaime')); ?></li>
            
            </ul>

		</div>
    
    
    </div>

    
  
   <div  style="width:90%; float:left; ">
<div class="group" style="margin-left:33%; margin-top:-14.7%">
        <h1>Vehicle Details</h1> 
        <div class="classname" style="width:200px; height:28px; margin-left:270px; margin-bottom:50px; font-size:25px">
<p align="center">
<b><?php echo $vehicleId; ?></b></p>
</div>

            <table width="550" >
            <tr>
            <td>
            
                   <h2 style="margin:0 0 -40px 120px; color:#039; font-weight:bold;">General Details</h2>
                     <div > 
                   <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                       // 'Vehicle_No',
                        //'Vehicle_Category_ID',
                        array('label'=>'Allocation Type', 'value'=>$model->allocationType->Allocation_Type),
                        array('label'=>'Vehicle Category Name', 'value'=>$model->vehicleCategory->Category_Name),
                        //'Model_ID',
                       
    
                        //'Make_ID',
                        array('label'=>'Make', 'type'=>'raw','value'=>(!empty($model->makeID->Make)) ? CHtml::encode($model->makeID->Make) : '-'),
						 array('label'=>'Model', 'type'=>'raw','value'=>(!empty($model->modelID->Model)) ? CHtml::encode($model->modelID->Model) : '-'),
                        'Make_Year',
                        //'Purchase_Value',
                         array('name' => 'Purchase Value','value'=> number_format($model->Purchase_Value,2),),
                        'Purchase_Date',
                        'Engine_No',
                        'Chassis_No',
                        //'Number_of_Passenger',
                        array('label'=>'Number of Passenger', 'type'=>'raw','value'=>(!empty($model->Number_of_Passenger)) ? CHtml::encode($model->Number_of_Passenger) : '-'),
                        //'Ac_Statues',
                        array('label'=>'Air Condition Statues', 'type'=>'raw','value'=>(!empty($model->Ac_Statues)) ? CHtml::encode($model->Ac_Statues) : '-'),
                        array('label'=>'Fuel Type', 'value'=>$model->fuelType->Fuel_Type),
                        'Fuel_Tank_Capacity',
                        
                        //'Driver_ID',
                        //array('name'=>'Full_Name', 'header'=>'Insurance Company Name', 'value'=>'$data->insuranceCompany->Insurance_Company_Name'),
                        //array('name'=>'Driver Allocation', 'header'=>'Driver_ID', 'value'=>'$data->driverID->Full_Name'),
                        //array('label'=>'Vehicle Allocation', 'value'=>$model->driverID->Full_Name),
                        //array('label'=>'Fuel Type', 'value'=>$model->fuelType->Fuel_Type),
                    ),
                )); ?>
                    </div>
                    </td>
                    <td width="190px">
                    <div style="height:30px"></div>
                    <?php
						$filename=$model->Vehicle_image;
						$str = substr($filename,5,1);
					?>
                    <?php 
				if(!empty($str))
				{
					?>
				<img src="<?php echo 'VechicleReg/'.$filename; ?>" width="190px" height="190px"/>
					
				<?php
				}
				else
				{
					?>
				   <img src="<?php echo 'VechicleReg/default.jpg'; ?>" width="190px" height="190px"/>
					<?php }
				?>

                    <!--<div align="center"><img src="images/vehicle.jpg" /></div>-->
                    </td>
                    </tr>
                    </table>
        </div>
        <div class="group" style="margin-left:33%;">

                <h2 style="margin:0 0 -40px 120px; color:#039; font-weight:bold;"> Spare Parts </h2>
                <div style="margin-left:0%"> 
                
                 <?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
                
                
                array('label'=>'Tyre Size', 'value'=>$model->tyreSize->Tyre_Size),
                //'Vehicle_Category_ID',
                array('label'=>'Tyre Type', 'value'=>$model->tyreType->Tyre_Type),
               // 'No_of_Tyres',
			   array('label'=>'Number of Tyres', 'type'=>'raw','value'=>(!empty($model->No_of_Tyres)) ? CHtml::encode($model->No_of_Tyres) : '-'),
                array('label'=>'Battery Type', 'value'=>$model->batteryType->Battery_Type),
                //'Tyre_Size_ID',
                //'Tyre_Type_ID',
                
                ),
                ));?></div>
    	</div>
        <div class="group" style="margin-left:33%;">
            <h2 style="margin:0 0 -40px 120px; color:#039; font-weight:bold;"> Maintenance </h2>
                   
                    <div style="margin-left:0%"> 
                    <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$model,
                'attributes'=>array(
                    
                    //'Battery_Type_ID',
                    //'Vehicle_Status_ID',
                    array('label'=>'Vehicle Status', 'value'=>$model->vehicleStatus->Vehicle_Status),
                    //'Servicing_Period',
					 array('label'=>'Servicing Period', 'type'=>'raw','value'=>(!empty($model->Servicing_Period)) ? CHtml::encode($model->Servicing_Period) : '-'),
                   // 'Service_Mileage',
				    array('label'=>'Service Mileage', 'type'=>'raw','value'=>(!empty($model->Service_Mileage)) ? CHtml::encode($model->Service_Mileage) : '-'),
                    //'Fuel_Consumption',
					 array('label'=>'Fuel Consumption', 'type'=>'raw','value'=>(!empty($model->Fuel_Consumption)) ? CHtml::encode($model->Fuel_Consumption) : '-'),
                    //'Fitness_test',
					 array('label'=>'Fitness test', 'type'=>'raw','value'=>(!empty($model->Fitness_test)) ? CHtml::encode($model->Fitness_test) : '-'),
                    'add_by',
                    'add_date',
                    /*'edit_by',
                    'edit_date',*/
						$model->edit_by == 'Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
		$model->edit_date == 'Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false) : array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),
                ),
            )); ?></div>
        </div>
    </div>
<!--</div>-->
