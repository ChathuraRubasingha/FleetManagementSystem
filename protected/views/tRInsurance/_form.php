<style type="text/css">
    
    .error{
        color: red;
    }
    
    #fancybox-loading div {
        position: fixed;
        top: 0;
        left: 50%;
        width: 40px;
        height: 480px;
        background-image:'url(fancy/fancybox_loading@2x.gif)';
    }
</style>

<script type="text/javascript">


$(document).ready(function(){


        $('#TRInsurance_Date_of_Insurance').Zebra_DatePicker();
        $('#TRInsurance_Valid_From').Zebra_DatePicker();
        $('#TRInsurance_Valid_To').Zebra_DatePicker();


	$("#TRInsurance_Amount").keyup(function(){
		var cost = $("#TRInsurance_Amount").val();
		var sepVal = thousandSep(cost);
		$("#TRInsurance_Amount").val(sepVal);
	});
	
	$("#TRInsurance_Sum_Insured").keyup(function(){
		var cost = $("#TRInsurance_Sum_Insured").val();
		var sepVal = thousandSep(cost);
		$("#TRInsurance_Sum_Insured").val(sepVal);
	});
        
        
        $(".MaInsuranceCompany").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaInsuranceCompany/UpdateInsuranceCompany') ?>',
                success: function(data)
                {
                    $('#TRInsurance_Insurance_Company_ID').append(data);
                },
                error: function() {
                },
                dataType: 'html'
            });
        },
        openEffect: 'elastic',
        openSpeed: 300,
        closeEffect: 'elastic',
        closeSpeed: 300,
        width: 600,
        helpers:{
            overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
        }

    });

    $(".MaInsuranceType").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaInsuranceType/UpdateInsuranceType') ?>',
                success: function(data)
                {
                    $('#TRInsurance_Insurance_Type_ID').append(data);
                },
                error: function() {
                },
                dataType: 'html'
            });
        },
        openEffect: 'elastic',
        openSpeed: 300,
        closeEffect: 'elastic',
        closeSpeed: 300,
        width: 600,
        helpers:{
            overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
        }

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
	'id'=>'insurance-form',
	'enableAjaxValidation'=>false,
));

  	$vehicleId = Yii::app()->session['maintenVehicleId'];


	date_default_timezone_set('Asia/Colombo');

        $curDate = MaVehicleRegistry::model()->getServerDate("date");
        $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

if(!isset($model->Date_of_Insurance))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
            $('#TRInsurance_Date_of_Insurance').val(curDate);

        });

    </script>
<?php

}
?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>

    <div class="formTable" >
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->hiddenfield($model,'Vehicle_No'); ?></div>
            <div class="tdTwo"><?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?></div>
        </div>
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Insurance_Company_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->dropDownList($model,'Insurance_Company_ID',CHtml::listData(MaInsuranceCompany::model()->findInsurance(),'Insurance_Company_ID','Insurance_Company_Name'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                <a class="MaInsuranceCompany addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maInsuranceCompany/AddNew') ?>">
                    <img src="images/1Screenshot-32.png" title="Add New Insurance Company" />
                </a>
                <?php echo $form->error($model,'Allocation_Type_ID'); ?></div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Insurance_Type_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->dropDownList($model,'Insurance_Type_ID',CHtml::listData(MaInsuranceType::model()->findInsuranceType(),'Insurance_Type_ID','Insurance_Type'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                <a class="MaInsuranceType addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maInsuranceType/AddNew') ?>">
                    <img src="images/1Screenshot-32.png" title="Add New Insurance Type" />
                </a>
                <?php echo $form->error($model,'Allocation_Type_ID'); ?></div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Amount'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Amount',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
		<?php echo $form->error($model,'Amount'); ?></div>
        </div>
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Sum_Insured'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Sum_Insured',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
		<?php echo $form->error($model,'Sum_Insured'); ?></div>
        </div>
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Date_of_Insurance'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Date_of_Insurance',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                <?php echo $form->error($model,'Date_of_Insurance'); ?></div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Valid_From'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Valid_From',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                <?php echo $form->error($model,'Valid_From'); ?>
            </div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Valid_To'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Valid_To',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                <?php echo $form->error($model,'Valid_To'); ?></div>
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