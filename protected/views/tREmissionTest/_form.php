
<style type="text/css">
    
    .error{
        
        color: red;
    }
    
    #fancybox-loading div 
    {
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

    $('#TREmissionTest_Emission_Test_Date').Zebra_DatePicker();
    $('#TREmissionTest_Valid_From').Zebra_DatePicker();
    $('#TREmissionTest_Valid_To').Zebra_DatePicker();


    $("#TREmissionTest_Amount").keyup(function(){
		var cost = $("#TREmissionTest_Amount").val();
		var sepVal = thousandSep(cost);
		$("#TREmissionTest_Amount").val(sepVal);
	});
        
        
         $(".MaEmissionTestCompany").fancybox({
                afterClose: function()
                {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createAbsoluteUrl('MaEmissionTestCompany/UpdateEmissionTestCompany') ?>',
                        success: function(data)
                        {
                            $('#TREmissionTest_Emission_Test_Company_ID').append(data);
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
                width: 700,
                height:1000,

                helpers:{
                    overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
                }

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
	'id'=>'tremission-test-form',
	'enableAjaxValidation'=>false,
));

  	$vehicleId = Yii::app()->session['maintenVehicleId'];

$curDate = MaVehicleRegistry::model()->getServerDate("date");
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

if(!isset($model->Emission_Test_Date))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
            $('#TREmissionTest_Emission_Test_Date').val(curDate);          

        });

    </script>
<?php

}
?>


<?php date_default_timezone_set('Asia/Colombo'); ?>
	<?php echo $form->errorSummary($model); ?>
    
    

<p class="note">Fields with <span class="required">*</span> are required.</p>

<div class="formTable">
	
    <?php echo $form->hiddenfield($model,'Vehicle_No'); ?>
    <?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>

	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Emission_Test_Company_ID'); ?></div>        
        <div class="tdTwo"><?php echo $form->dropDownList($model,'Emission_Test_Company_ID',CHtml::listData(MaEmissionTestCompany::model()->findEmission(),'Emission_Test_Company_ID','Company_Name'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
            <a class="MaEmissionTestCompany addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maEmissionTestCompany/AddNew') ?>">
                <img src="images/1Screenshot-32.png" title="Add New Emission Test Company" />
            </a>
            <?php echo $form->error($model,'Emission_Test_Company_ID'); ?></div>
   </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Emission_Test_Date'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Emission_Test_Date',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
            <?php echo $form->error($model,'Emission_Test_Date'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Valid_From'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Valid_From',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
		<?php echo $form->error($model,'Valid_From'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Valid_To'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Valid_To',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
            <?php echo $form->error($model,'Valid_To'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Emission_Test_Result'); ?></div>
        <div class="tdTwo"><?php echo $form->dropDownList($model,'Emission_Test_Result',array("Pass"=>"Pass","Fail"=>"Fail"), array('prompt'=>'--- Please Select ---' , 'class'=>'midSelect')); 		?>
            <?php echo $form->error($model,'Emission_Test_Result'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Amount'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Amount',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
            <?php echo $form->error($model,'Amount'); ?></div>
    </div>
	
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