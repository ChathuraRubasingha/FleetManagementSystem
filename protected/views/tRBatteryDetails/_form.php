<style type="text/css">
    
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

	$("#TRBatteryDetails_Cost").keyup(function(){
		var cost = $("#TRBatteryDetails_Cost").val();
		var sepVal = thousandSep(cost);
		$("#TRBatteryDetails_Cost").val(sepVal);
	});

    $('#TRBatteryDetails_Request_Date').Zebra_DatePicker();
    
    
    $(".MaDriver").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaDriver/UpdateDriver') ?>',
                success: function(data)
                {
                    $('#TRBatteryDetails_Driver_ID').append(data);
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


function thousandSep(val) {
	var test = val.replace(/,/g,'');
	return String(test).split("").reverse().join("").replace(/(\d{3}\B)/g, "$1,").split("").reverse().join("");
}


</script>


<?php
    $arr = Yii::app()->db->createCommand('SELECT NOW() as date;')->queryAll();
    $count = count($arr);
    $curDate='';
$curDateTime="";

    if($count>0)
    {
        $d = $arr[0]['date'];
        $dt = new DateTime($d);
        $curDate = $dt->format('Y-m-d');
        $curDateTime = $dt->format('Y-m-d H:i:s');

    }

    if(!isset($model->Request_Date))
    {
?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
            $('#TRBatteryDetails_Request_Date').val(curDate);

        });

    </script>
<?php

}
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trbattery-details-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
  	$vehicleId = Yii::app()->session['maintenVehicleId'];
	$view = Yii::app()->session['view'];
//	echo $view;exit;
	$type = Yii::app()->request->getQuery('type');
	$id = Yii::app()->request->getQuery('id');
	
	if ($id != '')
	{
		$rData = Yii::app()->db->createCommand('select Approved_Status from battery_details where Battery_Details_ID ='.$id)->queryAll();
		$count1 = count($rData);
		if($count1 != 0)
		{
			$status = $rData[$count1-1]['Approved_Status'];
		}
		else
		{
			$status = '';
		}
	}
	
	
	$bTypeArr = Yii::app()->db->createCommand('SELECT distinct mb.Battery_Type FROM ma_vehicle_registry b inner join ma_battery_type mb on mb.Battery_Type_ID = b.Battery_Type_ID
where b.Vehicle_No ="'.$vehicleId.'"')->queryAll();
if(!empty($bTypeArr))
{
	$battryType = $bTypeArr[0]['Battery_Type'];
}
else
{
	$battryType = '';
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
   
		<?php echo $form->hiddenfield($model,'Vehicle_No'); ?>
			<?php /*?><?php echo $form->textField($model,'Vehicle_No',array('size'=>20,'maxlength'=>20)); ?><?php */?>
            <?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
		<?php echo $form->error($model,'Vehicle_No'); ?>
        
	
		<?php
			if($type == 'replace')
			{
				

			}
			else
			{
				echo "<div class='tblRow'><div class='tdOne'>";
				echo $form->labelEx($model,'Driver_ID').'</div>';
				echo "<div class='tdTwo'>";
				echo $form->dropdownlist($model,'Driver_ID',CHtml::listData(
		MaDriver::model()->getDriverNamesInLocation($vehicleId),'Driver_ID','Full_Name'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect', 'options'=>$op));
			
 echo '<a class="MaDriver addBtn" data-fancybox-type="iframe" href="'. Yii::app()->createUrl("maDriver/AddNew").'">
                    <img src="images/1Screenshot-32.png" title="Add New Driver" />
                </a>';
				echo $form->error($model,'Driver_ID');
				echo '</div></div>';
			}
		?>
     

    	<?php
            if($type == 'replace')
            {

            }
            else
            {
                echo "<div class='tblRow'><div class='tdOne'>". $form->labelEx($model,'Battery_Type_ID').'</div>';
                echo "<div class='tdTwo'>". $form->textField($model, 'Battery_Type_ID', array('class'=>'midText','value'=>$battryType, 'readOnly'=>true/**/));

                echo $form->error($model,'Battery_Type_ID');
                echo "</div></div>";

            }
		?>

    	<?php
            if($type == 'replace')
            {

            }
            else
            {
                echo "<div class='tblRow'><div class='tdOne'>". $form->labelEx($model,'Request_Date').'</div>';
    echo "<div class='tdTwo'>". $form->textField($model,'Request_Date',array('class'=>'midText', 'autocomplete'=>'off','class'=>"zDatepicker" ));
                #echo "<div class='rowx' style='margin-top:-20px;'>". $form->dropDownList($model, 'Battery_Type_ID', CHtml::listData( MaVehicleRegistry::model()->getBatteryType($vehicleId), 'Battery_Type_ID', 'Battery_Type'));
                #echo "</div>";
                echo $form->error($model,'Request_Date');
                                                    echo "</div></div>";

            }
		?>
		
    	<?php
            if($type == 'replace')
            {

            }
            else
            {
                echo "<div class='tblRow'><div class='tdOne'>". $form->labelEx($model,'Quantity').'</div>';
                echo "<div class='tdTwo'>". $form->textField($model, 'Quantity', array('class'=>'midText','value'=>'1', ));

                echo $form->error($model,'Quantity');
                echo "</div></div>";

            }
		?>		

    	<?php
            if($type == 'replace')
            {

            }
            else
            {
                echo "<div class='tblRow'><div class='tdOne'>". $form->labelEx($model,'Remarks').'</div>';
                echo "<div class='tdTwo'>". $form->textField($model, 'Remarks', array('class'=>'midText',));

                echo $form->error($model,'Remarks');
                echo "</div></div>";

            }
		?>		
		
    	<?php
            if($type == 'replace')
            {

            }
            else
            {
                echo "<div class='tblRow'><div class='tdOne'>". $form->labelEx($model,'Meter_Reading').'</div>';
                echo "<div class='tdTwo'>". $form->textField($model, 'Meter_Reading', array('class'=>'midText',));

                echo $form->error($model,'Meter_Reading');
                echo "</div></div>";

            }
		?>				

    	<?php
            if($type == 'replace')
            {
                echo "<div class='tblRow'><div class='tdOne'>". $form->labelEx($model,'Life_Time').'</div>';

                echo "<div class='tdTwo'>". $form->textField($model,'Life_Time', array('class'=>'midText' ));
                #echo '</div>';
                echo $form->error($model,'Life_Time');
                echo '</div></div>';
            }	
		?>
  
        <?php
            if(($type == 'replace') || ($view == 'all'))
            {
                echo "<div class='tblRow'><div class='tdOne'>". $form->labelEx($model,'Cost').'</div>';

                echo "<div class='tdTwo'>". $form->textField($model,'Cost',array('class'=>'midText','maxlength'=>50)); 
                #echo '</div>';
                echo $form->error($model,'Cost');
                echo '</div></div>';
            }
        ?>
 
    	<?php 
            if($type == 'replace')
            {
                echo "<div class='tblRow'><div class='tdOne'>". $form->labelEx($model,'Replace_Date').'</div>';
                echo "<div class='tdTwo'>". $form->textField($model,'Replace_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" ));
                echo $form->error($model,'Replace_Date');
                echo '</div></div>';
            }
		?>
    
    	<?php
            if($type == 'replace')
            {
                echo "<div class='tblRow'><div class='tdOne'>". $form->hiddenfield($model,'Replace_Status').'</div>';

                echo "<div class='tdTwo'>". $form->hiddenfield($model,'Replace_Status',array('value'=>'Replaced'));
                #echo '</div>';
                echo $form->error($model,'Replace_Status');
                echo '</div></div>';
            }	
        ?>
        
    
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
