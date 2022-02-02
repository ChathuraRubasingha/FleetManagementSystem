
<script type="text/javascript">


$(document).ready(function()
{
    $('#TRTyreDetails_Replace_Date').Zebra_DatePicker();

	$("#TRTyreDetails_Cost").keyup(function(){
		var cost = $("#TRTyreDetails_Cost").val();
		var sepVal = thousandSep(cost);
		$("#TRTyreDetails_Cost").val(sepVal);
	});

});


function thousandSep(val) {
	var test = val.replace(/,/g,'');
	return String(test).split("").reverse().join("").replace(/(\d{3}\B)/g, "$1,").split("").reverse().join("");
}

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
	'id'=>'trtyre-details-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
  	$vehicleId = Yii::app()->session['maintenVehicleId'];
	$type = Yii::app()->request->getQuery('type');
    $curDate = MaVehicleRegistry::model()->getServerDate("date");
    $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");




    if(!isset($model->Service_Date))
    {
        ?>
        <script>
            $(document).ready(function()
            {
                var curDate ='<?php echo $curDate; ?>';
                $('#TRTyreDetails_Replace_Date').val(curDate);

            });

        </script>
<?php

    }
?>

<?php 
			
		
			$locData = Yii::app()->db->createCommand('select Current_Location_ID from vehicle_location where Vehicle_No ="'.$vehicleId.'"')->queryAll();
		if (!empty($locData))
		{
			$curLoc = $locData[count($locData)-1]['Current_Location_ID'];
		
			
			$dt = 'SELECT distinct d.Driver_ID, d.Full_Name FROM vehicle_driver vd inner join ma_driver d On d.Driver_ID = vd.Driver_ID  inner join vehicle_location vl on d.Location_ID = vl.Current_Location_ID where vd.Vehicle_No = "'.$vehicleId.'" and vl.Current_Location_ID = "'.$curLoc.'"';

			#$dt = 'SELECT Driver_ID FROM vehicle_driver WHERE Vehicle_No="'.$vehicleId.'"';
			$arr = Yii::app()->db->createCommand($dt)->queryAll();
			$count = count($arr);
			if($count != 0)
			{
				$dID = $arr[$count-1]['Driver_ID'];
			}
			else
			{
				$dID = '';
			}
		}
		else
		{
			$dID ='';
		}
			
			
		($dID != '' ? $op = array($dID =>Array ( 'selected' => 'selected' ) ): $op = array());
        	

		?>


<?php date_default_timezone_set('Asia/Colombo'); ?>



	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <div class="formTable">
        
       <?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
        

    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Tyre_Details_ID');?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Tyre_Details_ID', array('class'=>'midText','readOnly'=>true));?>
            <?php echo $form->error($model,'Tyre_Details_ID');?></div>
    </div>

    	<div class="tblRow">
        	<div class="tdOne"><?php echo $form->labelEx($model,'Meter_Reading');?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Meter_Reading', array('class'=>'midText', "onkeypress"=>"return isNumberKey(event)"));?>
            	<?php echo $form->error($model,'Meter_Reading');?></div>
        </div>
    
    	<div class="tblRow">
        	<div class="tdOne"><?php echo $form->labelEx($model,'Life_Time');?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Life_Time', array('class'=>'midText',"onkeypress"=>"return isNumberKey(event)"));?>
            	<?php echo $form->error($model,'Life_Time');?></div>
        </div>
  
    	<div class="tblRow">
        	<div class="tdOne"><?php echo $form->labelEx($model,'Cost');?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Cost',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
            	<?php echo $form->error($model,'Cost');?></div>
         </div>

	<div class="tblRow">
    	<div class="tdOne"><?php echo $form->labelEx($model,'Replace_Date');?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Replace_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"datepicker" )); ?>
				
				<?php echo $form->error($model,'Replace_Date');?></div>
	</div>

    	<?php echo $form->hiddenfield($model,'Replace_Status',array('value'=>'Replaced'));?>
        

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