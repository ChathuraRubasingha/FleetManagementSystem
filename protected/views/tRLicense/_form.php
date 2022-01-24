<style>
    #TRLicense_Valid_To
    {
        margin-left: -4px;
    }
    #TRLicense_Valid_From
    {
        margin-left: -4px;
    }
    #TRLicense_Date_of_License
    {
        margin-left: -4px;
    }
</style>

<script type="text/javascript">


$(document).ready(function(){

	$("#TRLicense_Amount").keyup(function(){
		var cost = $("#TRLicense_Amount").val();
		var sepVal = thousandSep(cost);
		$("#TRLicense_Amount").val(sepVal);
	});

    $('#TRLicense_Date_of_License').Zebra_DatePicker();
    $('#TRLicense_Valid_From').Zebra_DatePicker();
    $('#TRLicense_Valid_To').Zebra_DatePicker();
	
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
	'id'=>'license-form',
	'enableAjaxValidation'=>false,
));

  	$vehicleId = Yii::app()->session['maintenVehicleId'];

	date_default_timezone_set('Asia/Colombo');


$curDate = MaVehicleRegistry::model()->getServerDate("date");
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

if(!isset($model->Date_of_License))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
            $('#TRLicense_Date_of_License').val(curDate);

        });

    </script>
<?php

}
?>



	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="formTable">
	
<?php echo $form->hiddenfield($model,'Vehicle_No'); ?>
        <?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
	
	
   
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Date_of_License'); ?></div>
            <div class="tdTwo">
                <?php echo $form->textField($model,'Date_of_License',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                <?php echo $form->error($model,'Date_of_License'); ?>
            </div>
        </div> <!--end tblRow-->

	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Valid_From'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Valid_From',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                <?php echo $form->error($model,'Valid_From'); ?>
            </div>
        </div> <!--end tblRow-->
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Valid_To'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Valid_To',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                <?php echo $form->error($model,'Valid_To'); ?>
            </div>
        </div> <!--end tblRow-->
        
         <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Amount'); ?>
        </div><div class="tdTwo">
        
		<?php echo $form->textField($model,'Amount',array('class'=>'midText','maxlength'=>50,"onkeypress"=>"return isNumberKey(event)")); ?>
		<?php echo $form->error($model,'Amount'); ?>
        </div></div> <!--end tblRow-->
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Emission_test_ID'); ?>
        </div><div class="tdTwo">
        <?php 
            $result = TREmissionTest::model()->getEmissionTestResult();

            $count = count($result);

            if($count == 0)
            {
                echo "Emission test is not available";
            }
            else
            {
                $date = MaVehicleRegistry::model()->getServerDate("date");

                $emissionTestId = $result[$count-1]['Emission_test_ID'];
                $emissionTestValid_From = $result[$count-1]['Valid_From'];
                $emissionTestValid_To = $result[$count-1]['Valid_To'];
                $emissionTestResult = $result[$count-1]['Emission_Test_Result'];

                if($date >= $emissionTestValid_From AND $date <= $emissionTestValid_To)
                {
                    if($emissionTestResult == 'Pass')
                    {
                        echo $form->hiddenField($model, 'Emission_test_ID', array('class'=>'midText', 'value'=>$emissionTestId, 'readOnly'=>true));
                        echo $form->textField($model, '', array('class'=>'midText', 'value'=>$emissionTestResult, 'readOnly'=>true));
                        #echo $form->dropDownList($model,'Emission_test_ID',array($emissionTestId=>$emissionTestResult)); 		
                    }
                    else
                    {
                        echo "Emission test was fail";
                    }
                }
                else
                {
                    echo "Emission test is out of date";
                }
            }
        ?>
        <?php echo $form->error($model,'Emission_test_ID'); ?>
        </div></div> <!--end tblRow-->
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Fitness_ID'); ?>
        </div><div class="tdTwo">
        <?php
            $result = TRFitnessTest::model()->getFitnessTestVehicles();
            $count = count($result);
            if ($count != 0)
            {
                $status = $result[0]['Fitness_test'];
            }
            else
            {
                $status = '';
            }

            if($status == 'Yes')
            {
                $result2 = TRFitnessTest::model()->getFitnessTestResult();
                $count = count($result2);
                if($count == 0)
                {
                    echo "Fitness test is not available";
                }
                else
                {
                    $date = date('Y-m-d');
                    $fitnessTestId = $result2[$count-1]['Fitness_Test_ID'];
                    $fitnessTestValid_From = $result2[$count-1]['Valid_From'];
                    $fitnessTestValid_To = $result2[$count-1]['Valid_To'];
                    $fitnessTestResult = $result2[$count-1]['Fitness_Test_Result'];

                    if($date >= $fitnessTestValid_From &&  $date <= $fitnessTestValid_To)
                    {
                        if($fitnessTestResult == 'Pass')
                        {
                            echo $form->hiddenField($model, 'Fitness_ID', array('class'=>'midText','value'=>$fitnessTestId, 'readOnly'=>true));							
                            echo $form->textField($model, '', array('class'=>'midText','value'=>$fitnessTestResult, 'readOnly'=>true));
                                #echo $form->dropDownList($model,'Fitness_ID',array($fitnessTestId=>$fitnessTestResult));				
                        }
                        else
                        {
                            echo "Fitness test was fail";
                        }
                    }
                    else
                    {
                        echo "Fitness test is out of date";
                    }
                }
            }
            else
            {
                echo "Fitness test is not nessasary for this vehicle";
            }
        ?>
        <?php echo $form->error($model,'Fitness_ID'); ?>
        </div></div> <!--end tblRow-->
	

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