<style>
    th
    {
        border: 1px solid #666;
        padding: 6px;
        background-color: #D2D2D2;
        text-align: center;
    }
    td
    {
        border: 1px solid #666;
        padding: 5px;
        background-color: #F6F4F4;
    }
    
    td .midText, td .datepicker
    {
        width: 100%;
        border: 1px solid #ccc;
    }
    
    td label
    {
        font-weight: normal;
    }
    .error 
    {
        background: none repeat scroll 0 0 #fee;
    }
    .amount
    {
        text-align: right;
    }
    
</style>
    
<script type="text/javascript">


$(document).ready(function()
{
    $('#TRClaimeDetails_Claime_Amount').trigger('keyup');
    /*var insAmt = '<?php echo $model->Claime_Amount; ?>';
    var drAmt = '<?php echo $model->Driver_Claim_Amount; ?>';
    var tpAmt = '<?php echo $model->Thirdparty_Claim_Amount; ?>';
    var tot = parseFloat(insAmt) + parseFloat(drAmt) +parseFloat(tpAmt) ;
    //var tot = thousandSep(tot);
    $('#txtTotal').val(tot);*/
    
    
    $('.amount').keyup(function()
    {
        var total = 0;
        var totalVal=0;
        $('.amount').each(function()
        {
            var id = this.id;
            var val = $('#'+id).val();
             
            
            if(val !== '')
            {
                val = val.replace(/,/g,'');
                total += parseFloat(val);
            }
             totalVal = String(total).split("").reverse().join("").replace(/(\d{3}\B)/g, "$1,").split("").reverse().join("");
        });
        
        $('#txtTotal').val(totalVal);
    });
    $('#TRClaimeDetails_Claime_Date').Zebra_DatePicker();
    $('#TRClaimeDetails_Thirdparty_Claim_Date').Zebra_DatePicker();
    $('#TRClaimeDetails_Driver_Claim_Date').Zebra_DatePicker();

    $("#TRClaimeDetails_Claime_Amount").keyup(function(){
            var cost = $("#TRClaimeDetails_Claime_Amount").val();
            var sepVal = thousandSep(cost);
            $("#TRClaimeDetails_Claime_Amount").val(sepVal);
    });
    
    $("#TRClaimeDetails_Thirdparty_Claim_Amount").keyup(function(){
            var cost = $(this).val();
            var sepVal = thousandSep(cost);
            $(this).val(sepVal);
    });
    
    $("#TRClaimeDetails_Driver_Claim_Amount").keyup(function(){
            var cost = $(this).val();
            var sepVal = thousandSep(cost);
            $(this).val(sepVal);
    });
    

    $("#TRClaimeDetails_Sum_Insured").keyup(function(){
            var cost = $("#TRClaimeDetails_Sum_Insured").val();
            var sepVal = thousandSep(cost);
            $("#TRClaimeDetails_Sum_Insured").val(sepVal);
    });

    $("#TRClaimeDetails_Recovered_Amount").keyup(function(){
            var cost = $("#TRClaimeDetails_Recovered_Amount").val();
            var sepVal = thousandSep(cost);
            $("#TRClaimeDetails_Recovered_Amount").val(sepVal);
    });

});


    function thousandSep(val) 
    {
        var test = val.replace(/,/g,'');
        return String(test).split("").reverse().join("").replace(/(\d{3}\B)/g, "$1,").split("").reverse().join("");
    }
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




<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trclaime-details-form',
	'enableAjaxValidation'=>false,
));

date_default_timezone_set('Asia/Colombo');


$vehicleId = Yii::app()->session['accidentVehicleId'];
$estimateID = Yii::app()->request->getQuery('estimateId');

$curDate = MaVehicleRegistry::model()->getServerDate("date");
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

if(!isset($model->Claime_Date))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
           // $('#TRClaimeDetails_Claime_Date').val(curDate);

        });

    </script>
<?php

}
if(!isset($model->Thirdparty_Claim_Date))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
            //$('#TRClaimeDetails_Thirdparty_Claim_Date').val(curDate);

        });

    </script>
<?php

}
if(!isset($model->Driver_Claim_Date))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
           // $('#TRClaimeDetails_Driver_Claim_Date').val(curDate);

        });

    </script>
<?php

}

$driverID ='';
$driverName = '';
$company = '';
$companyID = '';
$tot = 0;
if ($model->getScenario() == 'insert')
{
    $estimateID = Yii::app()->request->getQuery('estimateId');
    if(isset($estimateID) && $estimateID != '')
    {
        $driverID = TREstimateDetails::model()->getAccidentDriver('Driver_ID',$estimateID);
        $driverName = TREstimateDetails::model()->getAccidentDriver('Complete_Name',$estimateID);
    }


    $arr = Yii::app()->db->createCommand('SELECT i.Insurance_ID,i.Insurance_Company_ID,c.Insurance_Company_Name FROM insurance i,ma_insurance_company c WHERE i.Insurance_Company_ID=c.Insurance_Company_ID AND Vehicle_No="'.$vehicleId.'"')->queryAll();

    if(count($arr) >0)
    {
        $company = $arr[0]['Insurance_Company_Name'];
        $companyID = $arr[0]['Insurance_Company_ID'];
    }
    else
    {
        Yii::app()->user->setFlash('success',"Insurance Details are not available");
        
    }
    
}
else
{
    $company = $model->insuranceCompany->Insurance_Company_Name;
    $companyID = $model->insuranceCompany->Insurance_Company_ID;
    $driverName = $model->estimate->accident->driver->Complete_Name;
    
    
    
    $insAmt = $drAmt = $tpAmt = 0;
    if(isset($model->Claime_Amount) && $model->Claime_Amount !== '')
    {
        $insAmt = $model->Claime_Amount;
    }
    if(isset($model->Driver_Claim_Amount) && $model->Driver_Claim_Amount !== '')
    {
        $drAmt = $model->Driver_Claim_Amount;
    }
    if(isset($model->Thirdparty_Claim_Amount) && $model->Thirdparty_Claim_Amount !== '')
    {
        $tpAmt = $model->Thirdparty_Claim_Amount;
    }
    
    $tot = floatval($insAmt) + floatval($drAmt) + floatval($tpAmt);
}

?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

        <div class="formTable">
            

		<?php echo $form->hiddenField($model,'Estimate_ID',array('size'=>20,'value'=>$estimateID,'readonly'=>true)); ?>
                <?php echo $form->hiddenField($model,'Driver_ID',array('size'=>20,'value'=>$driverID,'readonly'=>true)); ?>
                <?php echo $form->hiddenField($model,'Insurance_Company_ID',array('size'=>20,'value'=>$companyID,'readonly'=>true)); ?>
            
            <table style="width: 96%">
                <tr>
                    <th>Recovered From </th>
                    <th>Name</th>                    
                    <th width='100px'>Recovered Date</th>
                    <th width='100px'>Claim Amount</th>
                </tr>
                <tr>
                    <td>Insurance Company</td>
                    <td><?php echo CHtml::label($company, 'Insurance_Company_ID', array('value'=>$company, 'readOnly'=>true))?></td>
                    <td><?php echo $form->textField($model,'Claime_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"datepicker" )); ?></td>
                    <td><?php echo $form->textField($model,'Claime_Amount',array('class'=>'midText amount','maxlength'=>100, "onkeypress"=>"return isNumberKey(event)")); ?></td>
                </tr>
                <tr>
                    <td>Third Party</td>
                    <td><?php echo $form->textField($model, 'Thirdparty_Name', array('class'=>'midText'))?></td>
                    <td><?php echo $form->textField($model,'Thirdparty_Claim_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"datepicker" )); ?></td>
                    <td><?php echo $form->textField($model,'Thirdparty_Claim_Amount',array('class'=>'midText amount','maxlength'=>100, "onkeypress"=>"return isNumberKey(event)")); ?></td>                    
                </tr>
                <tr>
                    <td>Driver</td>
                    <td><?php echo CHtml::label($driverName, 'Driver_ID', array('readOnly'=>true))?></td>
                    <td><?php echo $form->textField($model,'Driver_Claim_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"datepicker" )); ?></td>
                    <td><?php echo $form->textField($model,'Driver_Claim_Amount',array('class'=>'midText amount','maxlength'=>100, "onkeypress"=>"return isNumberKey(event)")); ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right"><b>Total Amount</b></td>
                    <td><?php echo CHtml::textField('',  number_format($tot,2),array('size'=>20, 'id'=>'txtTotal', 'autocomplete'=>'off','readOnly'=>true, 'style'=>"text-align:right; width:100%; background-color:#F6F4F4; border:0 none !important;" )); ?></td>
                </tr>
            </table>
		
<!--    	<div class='tblRow'>
        	<div class="tdOne"><?php echo $form->labelEx($model,'Insurance_Company_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model, 'Insurance_Company_ID', array('class'=>'midText','value'=>$company, 'readOnly'=>true))?>
			<?php echo $form->error($model,'Insurance_Company_ID'); ?></div>
        </div>
	
    	<div class='tblRow'>
        	<div class="tdOne"><?php echo $form->labelEx($model,'Claime_Amount'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Claime_Amount',array('class'=>'midText','maxlength'=>100, "onkeypress"=>"return isNumberKey(event)")); ?>
            <?php echo $form->error($model,'Claime_Amount'); ?></div>
        </div>
	
    	<div class='tblRow'>
        	<div class="tdOne"><?php echo $form->labelEx($model,'Claime_Date'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Claime_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"datepicker" )); ?>
		<?php echo $form->error($model,'Claime_Date'); ?></div>
        </div>
	
    	<div class='tblRow'>
        	<div class="tdOne"><?php echo $form->labelEx($model,'Sum_Insured'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Sum_Insured',array('class'=>'midText','maxlength'=>200, "onkeypress"=>"return isNumberKey(event)")); ?>
            <?php echo $form->error($model,'Sum_Insured'); ?></div>
        </div>	
	
    	<div class='tblRow'>
        	<div class="tdOne"><?php echo $form->label($model,'Recoverd_From'); ?></div>
            <div class="tdTwo"><?php echo $form->dropDownList($model,'Recoverd_From',array("Insurance Company"=>"Insurance Company", "Driver"=>"Driver","Third Party"=>"Third Party"), array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
             <?php echo $form->error($model,'Recoverd_From'); ?></div>
        </div>
     
    	<div class='tblRow'>
        	<div class="tdOne"><?php echo $form->labelEx($model,'Recovered_Amount'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Recovered_Amount',array('class'=>'midText','maxlength'=>200, "onkeypress"=>"return isNumberKey(event)")); ?>
            <?php echo $form->error($model,'Recovered_Amount'); ?></div>
        </div>-->
  

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
	
<div class="row buttons" style="padding-left:75%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->