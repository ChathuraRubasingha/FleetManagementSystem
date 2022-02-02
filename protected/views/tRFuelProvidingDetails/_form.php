<style>
    #TRFuelProvidingDetails_Fuel_Type_ID
    {
        margin-left: -4px;
    }
</style>

<?php

$curDate = MaVehicleRegistry::model()->getServerDate("date");
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

$vehicleId = Yii::app()->session['VehicleIdFuel'];
$requestId =Yii::app()->session['requestId'];

?>

<script>


    $(document).ready(function()
    {
        $('#TRFuelProvidingDetails_Fuel_Pumped_Date').Zebra_DatePicker();
    });
    
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        //alert(charCode);
        if (charCode != 46 && charCode !=45 && charCode > 31
            && (charCode < 48 || charCode > 57 ))
            return false;

        return true;
    }
</script>




<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trfuel-providing-details-form',
	'enableAjaxValidation'=>false,
));




$fuelType = '';

$fuelData = Yii::app()->db->createCommand('select Fuel_Type_ID from ma_vehicle_registry where Vehicle_No ="'.$vehicleId.'"')->queryAll();

if(!empty($fuelData))
{
	$fuelID = $fuelData[0]['Fuel_Type_ID'];
	
	$fuelTypeData = Yii::app()->db->createCommand('select Fuel_Type from ma_fuel_type where Fuel_Type_ID ="'.$fuelID.'"')->queryAll();
	
	if(!empty($fuelTypeData))
	{
		$fuelType = $fuelTypeData[0]['Fuel_Type'];
			
	}
	
	
}



?>
<script type="text/javascript">


$(document).ready(function(){

	$("#TRFuelProvidingDetails_Payable_Amount").keyup(function(){
		var cost = $("#TRFuelProvidingDetails_Payable_Amount").val();
		var sepVal = thousandSep(cost);
		$("#TRFuelProvidingDetails_Payable_Amount").val(sepVal);
	});

});


function thousandSep(val) {
	var test = val.replace(/,/g,'');
	return String(test).split("").reverse().join("").replace(/(\d{3}\B)/g, "$1,").split("").reverse().join("");
}


</script>

    <?php

    if(!isset($model->Service_Date))
    {
        ?>
        <script>
            $(document).ready(function()
            {
                var curDate ='<?php echo $curDate; ?>';
                $('#TRFuelProvidingDetails_Fuel_Pumped_Date').val(curDate);

            });

        </script>
    <?php

    }

    ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($model); ?>
        <div class="formTable">
            
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Fuel_Request_ID'); ?>
      </div><div class="tdTwo">
		<?php echo $form->textField($model,'Fuel_Request_ID',array('class'=>'midText','maxlength'=>20,'value'=>$requestId,'readonly'=>true)); ?>
		<?php 
		echo $form->error($model,'Fuel_Request_ID'); ?>
        </div></div>
        	
     <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Fuel_Order_No'); ?>
     </div><div class="tdTwo">   
		<?php echo $form->textField($model,'Fuel_Order_No', array('class'=>'midText',)); ?>
		<?php echo $form->error($model,'Fuel_Order_No'); ?>
        </div></div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Fuel_Station'); ?>
    </div><div class="tdTwo">
		<?php echo $form->textField($model,'Fuel_Station',array('class'=>'midText','maxlength'=>100)); ?>
		<?php echo $form->error($model,'Fuel_Station'); ?>
        </div></div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->hiddenfield($model,'Vehicle_No'); ?>
      </div><div class="tdTwo">
		<?php echo $form->hiddenfield($model,'Vehicle_No',array('class'=>'midText','maxlength'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
		<?php echo $form->error($model,'Vehicle_No'); ?>
        </div></div>
	
    <div class="tblRow">
    	<div class="tdOne"><?php echo $form->labelEx($model,'Fuel_Type_ID'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Fuel_Type_ID', array('class'=>'midText','value'=>$fuelType, 'readOnly'=>true)); ?>
         <?php echo $form->error($model,'Fuel_Type_ID'); ?></div>
       
  </div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Fuel_Pumped_Date'); ?> 
        </div><div class="tdTwo">
            <?php echo $form->textField($model,'Fuel_Pumped_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>

            <?php echo $form->error($model,'Fuel_Pumped_Date'); ?>
        </div></div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Fuel_Amount'); ?>
      </div><div class="tdTwo">
        <?php echo $form->textField($model,'Fuel_Amount',array('class'=>'midText','maxlength'=>5, "onkeypress"=>"return isNumberKey(event)")); ?>
		<?php echo $form->error($model,'Fuel_Amount'); ?>
        </div></div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Payable_Amount'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'Payable_Amount',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
		<?php echo $form->error($model,'Payable_Amount'); ?>
        </div></div>
	
    
    <?php date_default_timezone_set('Asia/Colombo'); ?>
	
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
		}
		 ?>
	
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>date("Y-m-d : H:i:s", time())));
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
		echo $form->hiddenField($model,'edit_date',array('value'=>date("Y-m-d : H:i:s", time())));	
		}
	?>
<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
