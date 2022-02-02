<style>

div.form .rowx {
	margin-left:150px;
	
}

.error
{   
    color: red;
}

.ui-widget
{
    font-size: 12px;
}

#removeImg 
{
    border: medium none !important;
    cursor: pointer;
    height: 25px !important;
    left: 70px;
    margin-bottom: -35px;
    position: relative;
    top: -100px;
    width: 25px !important;
    z-index: 997;
}
</style>



<script type="text/javascript">

$(document).ready(function()
{
    var curDate ='<?php 
	$arr = Yii::app()->db->createCommand('SELECT NOW() as date;')->queryAll();
	$count = count($arr);
	$curDate='';
	if($count>0)
	{
            $d = $arr[0]['date'];
            $dt = new DateTime($d);

            $curDate = $dt->format('Y-m-d H:i:s');

	}
	echo $curDate;?>';



	$("#TRAccident_Accident_Type").change(function()
        {
            var typeA = $("#TRAccident_Accident_Type").val();

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("TRAccident/GetAtype"); ?>',
                data: {'typeA':typeA},
                success:function(data){
                        //alert(data);
                        $("#TRAccident_Driver_Rating").val(data);
                },
                error: function(data) { // if error occured
                        //alert("Error occured.please try again");
                        //alert(data);
                        //alert(RateId);
                },
                dataType:'html'
            });
	});
        
        
	var dateToday = new Date();
	var dates = $("#Date_and_Time").datetimepicker({
        // defaultDate: "+1w",
        changeMonth: true,
	dateFormat:'yy-mm-dd',
        //  numberOfMonths: 3,
        maxDate: curDate
	//minTime: curTime,
	
	
        /* onSelect: function(selectedDate) {
            var option = this.id == "from_date" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }*/
    });

});

$('.ui-datepicker-close').live("click",function()
 {
     $('#ui-datepicker-div').toggle();
 });
 
 $('#Date_and_Time').live("focus",function()
 {
    $('#ui-datepicker-div').toggle();
 });
 
 
 

</script>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'traccident-form',
	'enableAjaxValidation'=>false,
	
'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>



<?php

    $id = Yii::app()->request->getQuery('id');
    if($id =='')
    {
        $id =0;
    }

    $vehicleId = Yii::app()->session['accidentVehicleId'];
    $curDate = MaVehicleRegistry::model()->getServerDate("date");
    $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");
		
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
        	


    date_default_timezone_set('Asia/Colombo'); 
?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

        <div class="formTable">
            

                <?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Driver_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->dropdownlist($model,'Driver_ID',CHtml::listData(
                MaDriver::model()->getDriverNamesInLocation($vehicleId),'Driver_ID','Full_Name'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect', 'options'=>$op));   ?>
                <?php echo $form->error($model,'Driver_ID'); ?>		</div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Odometer_After_Accident'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Odometer_After_Accident',array('class'=>'midText','maxlength'=>100, "onkeypress"=>"return isNumberKey(event)")); ?>
                <?php echo $form->error($model,'Odometer_After_Accident'); ?></div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Date_and_Time'); ?></div>
            <div class="tdTwo"><?php $this->widget('application.extensions.timepicker.timepicker', array('model' => $model, 'name' => 'Date_and_Time', 'id' => 'Date_and_Time')); ?>
                <?php echo $form->error($model,'Date_and_Time'); ?></div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Accident_Place'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Accident_Place',array('class'=>'midText','maxlength'=>200)); ?>
                <?php echo $form->error($model,'Accident_Place'); ?></div>
        </div>  
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Details'); ?></div>
            <div class="tdTwo"><?php echo $form->textArea($model,'Details',array('rows'=>5, 'cols'=>55)); ?>
                <?php echo $form->error($model,'Details'); ?></div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Police_Station'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Police_Station',array('class'=>'midText','maxlength'=>150)); ?> 
                <?php echo $form->error($model,'Police_Station'); ?></div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Address'); ?></div>
            <div class="tdTwo"><?php echo $form->textArea($model,'Address',array('rows'=>5, 'cols'=>55)); ?>
                <?php echo $form->error($model,'Address'); ?></div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Police_Report_No'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Police_Report_No',array('class'=>'midText','maxlength'=>50)); ?>
                <?php echo $form->error($model,'Police_Report_No'); ?></div>
        </div>
	
        <?php echo $this->renderPartial('_images', array('model' => $model)); ?>
            
            
        <?php date_default_timezone_set('Asia/Colombo'); ?>

        <?php 
            if ($model->isNewRecord){
            echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
            }
            else {
            echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
            }
      
            if ($model->isNewRecord){
            echo $form->hiddenField($model,'add_date',array('value'=>$curDateTime));
            } else {
            echo $form->hiddenField($model,'add_date',array());	
            }
		

            if ($model->isNewRecord){
            echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>'Not Edited'));
            } else {
            echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));   	
            }
		
            
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