<style type="text/css">
    
 
    
    #fancybox-loading div {
        position: fixed;
        top: 0;
        left: 50%;
        width: 40px;
        height: 480px;
        background-image:'url(fancy/fancybox_loading@2x.gif)';
    }
    
    #TRFitnessTest_Garage_ID
    {
        margin-left: -4px !important;
    }
</style>

<script type="text/javascript">


$(document).ready(function(){

    $('#TRFitnessTest_Fitness_Test_Date').Zebra_DatePicker();
    $('#TRFitnessTest_Valid_From').Zebra_DatePicker();
    $('#TRFitnessTest_Valid_To').Zebra_DatePicker();


	$("#TRFitnessTest_Amount").keyup(function(){
            var cost = $("#TRFitnessTest_Amount").val();
            var sepVal = thousandSep(cost);
            $("#TRFitnessTest_Amount").val(sepVal);
	});
        
       
        
        $(".MaGarages").fancybox({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("MaGarages/UpdateGarage") ?>',
                    success: function(data)
                    {
                        $('#TRFitnessTest_Garage_ID').append(data);
                    },
                    error: function() {
                    },
                    dataType: 'html'
                    });
                },
                onOpen: function()
                {
                    alert('ddddd');
                },
            openEffect: 'elastic',
            openSpeed: 300,
            closeEffect: 'elastic',
            closeSpeed: 300,
            width: 700,
            height:1500,

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
	'id'=>'trfitness-test-form',
	'enableAjaxValidation'=>false,
));

  	$vehicleId = Yii::app()->session['maintenVehicleId'];

	date_default_timezone_set('Asia/Colombo');
$curDate = MaVehicleRegistry::model()->getServerDate("date");
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

if(!isset($model->Fitness_Test_Date))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
            $('#TRFitnessTest_Fitness_Test_Date').val(curDate);      
            

        });

    </script>
<?php

}
?>



	<?php echo $form->errorSummary($model); ?>
    
  

<p class="note">Fields with <span class="required">*</span> are required.</p>

<div class="formTable">
	
    <?php echo $form->hiddenfield($model,'Vehicle_No'); ?>
        <?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
       
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Garage_ID'); ?></div> 
        <div class="tdTwo"><?php echo $form->dropDownList($model,'Garage_ID',CHtml::listData(MaGarages::model()->findAll(),'Garage_ID','Garage_Name'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
            <a class="MaGarages addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maGarages/AddNew') ?>">
                <img src="images/1Screenshot-32.png" title="Add New Garage" />
            </a>
            <?php echo $form->error($model,'Garage_ID'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne">
		<?php echo $form->labelEx($model,'Fitness_Test_Date'); ?>
        </div><div class="tdTwo">
            <?php echo $form->textField($model,'Fitness_Test_Date',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
		<?php echo $form->error($model,'Fitness_Test_Date'); ?>
        </div></div>
	
    
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Valid_From'); ?>
        </div><div class="tdTwo">
            <?php echo $form->textField($model,'Valid_From',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
		<?php echo $form->error($model,'Valid_From'); ?>
        </div>
    </div>
    
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Valid_To'); ?>
        </div><div class="tdTwo">
            <?php echo $form->textField($model,'Valid_To',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
		<?php echo $form->error($model,'Valid_To'); ?>
        </div>
    </div>
	
    
   
	
    
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Fitness_Test_Result'); ?>
        </div><div class="tdTwo">
        <?php echo $form->dropDownList($model,'Fitness_Test_Result',array("Pass"=>"Pass","Fail"=>"Fail"), array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); 				  		?>
        <?php echo $form->error($model,'Fitness_Test_Result'); ?>
        </div></div>
	
    
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Amount'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'Amount',array('class'=>'midText','maxlength'=>50,"onkeypress"=>"return isNumberKey(event)")); ?>
		<?php echo $form->error($model,'Amount'); ?>
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
	
    
	


	<div class="row" style="padding-left:36.5%;font-weight:bold">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
        </div>
    <!--<h1>Fitness Test History</h1>-->

<?php $this->endWidget(); ?>



</div><!-- form -->