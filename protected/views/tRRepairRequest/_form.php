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
    
    #TRRepairRequest_Driver_ID
    {
        margin-left: -4px;
    }
</style>

<script>
    $(document).ready(function(){


        $('#TRRepairRequest_Request_Date').Zebra_DatePicker();
        
        
        
        $(".MaDriver").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaDriver/UpdateDriver') ?>',
                success: function(data)
                {
                    $('#TRRepairRequest_Driver_ID').append(data);
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

</script>

<?php
$curDate = MaVehicleRegistry::model()->getServerDate("date");
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");
//echo $curDate;

if(!isset($model->Request_Date))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
//alert(curDate);
            $('#TRRepairRequest_Request_Date').val(curDate);

        });

    </script>
<?php

}
?>

    

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trrepair-request-form',
	'enableAjaxValidation'=>false,
)); 

  	$vehicleId = Yii::app()->session['maintenVehicleId'];
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
    #$qry = 'SELECT Full_Name FROM ma_driver WHERE Driver_ID='.$dID;
    #$rawData = Yii::app()->db->createCommand($qry)->queryAll();
    #$dr = count($rawData);
    #$drivr = $rawData[$dr-1]['Full_Name'];

($dID != '' ? $op = array($dID =>Array ( 'selected' => 'selected' ) ): $op = array());
        	

		?>
<?php date_default_timezone_set('Asia/Colombo');

$reqDate = $curDate;
if(isset($model->Request_Date))
{
    $reqDate = $model->Request_Date;

}

?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="formTable" >

    
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->hiddenfield($model,'Vehicle_No'); ?></div>
            <div class="tdTwo"><?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
		        <?php echo $form->error($model,'Vehicle_No'); ?>
            </div>
        </div> <!--end tblRow-->
		
		<!-- inspected by InspectedBy -->	
        <div class="tblRow">
            <div class="tdOne"><?php
			echo $form->labelEx($model,'InspectedBy'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'InspectedBy',array('size'=>20)); ?>
		        <?php echo $form->error($model,'InspectedBy'); ?>
            </div>
        </div> <!--end tblRow-->
		<!--end tblRow-->
		
		<!-- Meter_Reading -->	
        <div class="tblRow">
            <div class="tdOne"><?php
			echo $form->labelEx($model,'Meter_Reading'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Meter_Reading',array('size'=>20)); ?>
		        <?php echo $form->error($model,'Meter_Reading'); ?>
            </div>
        </div> <!--end tblRow-->

		<!--end tblRow-->
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Driver_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->dropdownlist($model,'Driver_ID',CHtml::listData(
                        MaDriver ::model()->getDriverNamesInLocation($vehicleId),'Driver_ID','Full_Name'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect', 'options'=>$op));   ?>
                        <a class="MaDriver addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maDriver/AddNew') ?>">
                            <img src="images/1Screenshot-32.png" title="Add New Driver" />
                        </a>
                <?php echo $form->error($model,'Driver_ID'); ?>
            </div>
        </div> <!--end tblRow-->		
		
		
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Request_Date'); ?>
        </div><div class="tdTwo">
            <?php echo $form->textField($model,'Request_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
		<?php echo $form->error($model,'Request_Date'); ?>
        </div></div> <!--end tblRow-->

    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Description_Of_Failure'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textArea($model,'Description_Of_Failure',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Description_Of_Failure'); ?>
        </div></div> <!--end tblRow-->

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