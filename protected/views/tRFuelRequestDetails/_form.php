<style type="text/css">
    
    .error
    {
        color: red;
    }
    
    
    #TRFuelRequestDetails_Request_Date
    {
        margin-left: -4px !important;
    }
    
    #TRFuelRequestDetails_Reason 
    {
        margin-left: -4px !important;
    }
</style>


<?php

$curDate = MaVehicleRegistry::model()->getServerDate("date");
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

if(!isset($model->Request_Date))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
            $('#TRFuelRequestDetails_Request_Date').val(curDate);

        });
        
        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            //alert(charCode);
            if (charCode != 46 && charCode !=45 && charCode > 31 && (charCode < 48 || charCode > 57 ))
            {
                return false;
            }

            return true;
        }

    </script>
<?php

}
?>

<script>


$(document).ready(function()
{
    $('#TRFuelRequestDetails_Request_Date').Zebra_DatePicker();

});

</script>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trfuel-request-details-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$vehicleId = Yii::app()->session['VehicleIdFuel'];
$aid =Yii::app()->session['VehicleIdAllocationID'];
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
//$list=MaVehicleRegistry::model()->getnewTyreTube($vehicleID);
//$VehicleNo=$list[0]['Vehicle_No'];
$lst = '';
 if ($model->isNewRecord)
 {
	$lst = tRFuelRequestDetails::model()->getLastFuelReading(1);
 }
 else
 {
	 $lst = tRFuelRequestDetails::model()->getLastFuelReading(2);
 }

//print_r($lst); exit;
$lstMeterReding ='';
$aa=count($lst);
//print_r($aa); exit;
?>
<?php 
    if ($aa > 0)
    {
        $lstMeterReding = $lst[0]['Meter_Reading'];
    }
    else
    {
        $lstMeterReding='No previous meter reading available';	
    }
?>
<?php 
	
	$dt = 'SELECT Driver_ID FROM vehicle_driver WHERE Vehicle_No="'.$vehicleId.'"';
	$arr = Yii::app()->db->createCommand($dt)->queryAll();
	$count = count($arr);
	if ($count != 0)
	{
		$dID = $arr[$count-1]['Driver_ID'];
	}
	else
	{
		$dID = '';
	}
	

($dID != '' ? $op = array($dID =>Array ( 'selected' => 'selected' ) ): $op = array());
	

		?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($model); ?>
        <div class="formTable">
	

<?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'maxlength'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
      
      

    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Driver_ID'); ?>
        </div><div class="tdTwo">
		<?php echo $form->dropdownlist($model,'Driver_ID',CHtml::listData(
            MaDriver::model()->getDriverNamesInLocation($vehicleId),'Driver_ID','Full_Name'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect', 'options'=>$op));   ?>
            <?php echo $form->error($model,'Driver_ID'); ?>
	    </div></div>
	
    
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Required_Fuel_Capacity'); ?>
           </div><div class="tdTwo">
        <?php echo $form->textField($model,'Required_Fuel_Capacity',array('class'=>'midText','maxlength'=>4, "onkeypress"=>"return isNumberKey(event)")); ?>
		<?php echo $form->error($model,'Required_Fuel_Capacity'); ?>
    </div></div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Request_Date'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Request_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
            <?php echo $form->error($model,'Request_Date'); ?></div>
    </div>
            
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Reason'); ?></div>
        <div class="tdTwo"><?php echo $form->textArea($model,'Reason',array('rows'=>5, 'cols'=>55)); ?>
            <?php echo $form->error($model,'Reason'); ?></div>
    </div>
	
<?php echo $form->hiddenField($model,'Fuel_Balance',array('size'=>20,'maxlength'=>10)); ?>

  
	
     <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Fuel_Balance_Range'); ?>
         </div><div class="tdTwo">
        <?php echo $form->dropDownList($model,'Fuel_Balance_Range',array("0"=>"0","1/8"=>"1/8","1/4"=>"1/4","1/2"=>"1/2","3/4"), array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
		<?php echo $form->error($model,'Fuel_Balance_Range'); ?>
    </div></div> 
	
     <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Meter_Reading'); ?>
          </div><div class="tdTwo">
		<?php echo $form->textField($model,'Meter_Reading',array('class'=>'midText','autocomplete'=>'off',  "onkeypress"=>"return isNumberKey(event)")); ?>
        <?php 
		$previous ="Previous Reading : ".$lstMeterReding;
		if($userRole ==='3')
		{
			$previous='පෙර පැවැති මීටර කියවීම : '.$lstMeterReding;
		}
			 
		?>
       
          </div></div>
          <div class="tblRow">
          <td/>
          <div class="tdTwo">
		
        <!--p style="color:#008000; font-weight:bold"><?php //echo $previous?></p-->
        
         </div>
         </div>
	
    

<?php date_default_timezone_set('Asia/Colombo'); ?>

         
		<?php 
		if ($model->isNewRecord)
                {
                    echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
		}
		 ?>
	
         
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>$curDateTime));
		} else {
		echo $form->hiddenField($model,'add_date',array());	
		}
		?>
	
         
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));   	
		}
		?>
	
         
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_date',array('value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_date',array('value'=>$curDateTime));
		}
		?>
	
         
        <div class="row" style="padding-left:37%;font-weight:bold">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
        </div>
<?php $this->endWidget(); ?>

</div><!-- form -->
