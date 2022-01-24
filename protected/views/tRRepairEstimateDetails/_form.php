<style type="text/css">

    #fancybox-loading div {
        position: fixed;
        top: 0;
        left: 50%;
        width: 100px;
        height: 480px;
        background-image:'url(fancy/fancybox_loading@2x.gif)';
    }
</style>
<script type="text/javascript">


$(document).ready(function()
{
    $('.MaGarages').click(function()
    {
        // uses not to overlap the add new service type form in the service popup
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl('MaGarages/Session4RemoveBtn') ?>',
            dataType: 'html'
        });
    });

	$("#TRRepairEstimateDetails_Total_Estimate").keyup(function(){
		var cost = $("#TRRepairEstimateDetails_Total_Estimate").val();
		var sepVal = thousandSep(cost);
		$("#TRRepairEstimateDetails_Total_Estimate").val(sepVal);
	});

        $('#TRRepairEstimateDetails_Estimate_Date').Zebra_DatePicker();
    
    
    
        $(".MaGarages").fancybox
        ({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaGarages/UpdateGarage') ?>',
                    success: function(data)
                    {
                        $('#TRRepairEstimateDetails_Garage_ID').append(data);
                    },
                    error: function() {
                        
                    },
                    dataType: 'html'
                });
            },
            openEffect: 'elastic',
            openSpeed: 300,
            closeEffect: 'elastic',
            closeSpeed: 600,
            width: 700,
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
	'id'=>'trrepair-estimate-details-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
  	$vehicleId = Yii::app()->session['maintenVehicleId'];
	$requestID = Yii::app()->request->getQuery('repairRequestId');

    $curDate = MaVehicleRegistry::model()->getServerDate("date");
    $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

if(!isset($model->Estimate_Date))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
            $('#TRRepairEstimateDetails_Estimate_Date').val(curDate);

        });

    </script>
<?php

}
?>

<?php date_default_timezone_set('Asia/Colombo'); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
   <div class="formTable" >

	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Request_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Request_ID',array('class'=>'midText','value'=>$requestID,'readonly'=>true)); ?>
		    <?php echo $form->error($model,'Request_ID'); ?></div>
        </div> <!--end tblRow-->
	
        <?php echo $form->hiddenfield($model,'Vehicle_No'); ?>
        <?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
         
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Garage_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->dropDownList($model,'Garage_ID',CHtml::listData(MaGarages::model()->findAll(array('order'=>'Garage_Name ASC')),'Garage_ID','Garage_Name'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                <a class="MaGarages addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maGarages/AddNew') ?>">
                    <img src="images/1Screenshot-32.png" title="Add New Garage" />
                </a>
                <?php echo $form->error($model,'Garage_ID'); ?></div>
        </div> <!--end tblRow-->
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Total_Estimate'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Total_Estimate',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
                <?php echo $form->error($model,'Total_Estimate'); ?></div>
        </div> <!--end tblRow-->
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Estimate_Date'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Estimate_Date',array('class'=>'midText', 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
		        <?php echo $form->error($model,'Estimate_Date'); ?></div>
        </div> <!--end tblRow-->
	
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