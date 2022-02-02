

<script type="text/javascript">


$(document).ready(function()
{   
    var estimate = $('#TREstimateDetails_Damage_Estimate').val();
    if(estimate != '')
    {
        getAccidentType('#TREstimateDetails_Damage_Estimate');
       
    }

    $('#TREstimateDetails_Estimated_Date').Zebra_DatePicker();

    $("#TREstimateDetails_Damage_Estimate").keyup(function()
    {
        var cost = $("#TREstimateDetails_Damage_Estimate").val();
        var sepVal = thousandSep(cost);
        $("#TREstimateDetails_Damage_Estimate").val(sepVal);
    });
    
    $('#TREstimateDetails_Damage_Estimate').live("focusout",function()
    {
        getAccidentType("#TREstimateDetails_Damage_Estimate");
    });
/*
$('#TREstimateDetails_Damage_Estimate').focusout(function()
    {
        estimate = $(this).val();
        
        if(estimate != '')
        {
            estimate = estimate.replace(/,/g,'');

            $.ajax
            ({
                type:'POST',
                url : '<?php echo Yii::app()->createAbsoluteUrl("TREstimateDetails/GetAccidentType"); ?>',
                data:{'estimateCost':estimate},
                success:function(data)
                {
                    if(data != '')
                    {
                        $('#accTypeRow').show();
                        $('#accType').html(data);
                    }
                }
            });
        }
        else
        {
            $('#accTypeRow').hide();
        }
    });*/
    

});

function getAccidentType(e)
{
    var estimate = $(e).val();

    if(estimate != '')
        {
            estimate = estimate.replace(/,/g,'');

            $.ajax
            ({
                type:'POST',
                url : '<?php echo Yii::app()->createAbsoluteUrl("TREstimateDetails/GetAccidentType"); ?>',
                data:{'estimateCost':estimate},
                success:function(data)
                {
                    if(data != '')
                    {
                        $('#accTypeRow').show();
                        $('#accType').html(data);
                    }
                }
            });
        }
        else
        {
            $('#accTypeRow').hide();
        }
}

function thousandSep(val) 
{
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
	'id'=>'trestimate-details-form',
	'enableAjaxValidation'=>false,
));

date_default_timezone_set('Asia/Colombo');
$vehicleId = Yii::app()->session['accidentVehicleId'];
$accidentID = Yii::app()->request->getQuery('accidentId');

$curDate = MaVehicleRegistry::model()->getServerDate("date");
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

    if(!isset($model->Estimated_Date))
    {
        ?>
        <script>
            $(document).ready(function()
            {
                var curDate ='<?php echo $curDate; ?>';
                $('#TREstimateDetails_Estimated_Date').val(curDate);

            });

        </script>
    <?php

    }
    ?>



    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="formTable">
	
        <?php echo $form->hiddenfield($model,'Accident_ID',array('size'=>20,'value'=>$accidentID,'readonly'=>true)); ?>	
        <?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
		
    	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Damage_Estimate'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Damage_Estimate',array('class'=>'midText','maxlength'=>150, "onfocusout"=>"getAccidentType(this)",  "onkeypress"=>"return isNumberKey(event)")); ?>
		<?php echo $form->error($model,'Damage_Estimate'); ?></div>
        </div>
        
        <div class="tblRow" id='accTypeRow' style="display: none">
            <div class="tdOne"><?php echo CHtml::label('Accident Type',''); ?></div>
            <div class="tdTwo" id="accType"></div>
        </div>	
	
        
    	<div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Estimated_Date'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Estimated_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"datepicker" )); ?>
                <?php echo $form->error($model,'Estimated_Date'); ?></div>
        </div>
	
    	<div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Description'); ?></div>
            <div class="tdTwo"><?php echo $form->textArea($model,'Description',array('rows'=>6, 'cols'=>50)); ?>
                <?php echo $form->error($model,'Description'); ?></div>
        </div>
	

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