<style>

/*.row img {
  height:0px;
  margin-left:0px;
  width:0px;
}
div.form .rowx {
	margin-left:150px;
	
}*/
.error
{
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

<script>

    $(document).ready(function()
    {
        $('#TRTyreDetails_Request_Date').Zebra_DatePicker();
        
        $(".MaDriver").fancybox({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("MaDriver/UpdateDriver") ?>',
                    success: function(data)
                    {
                        $('#TRTyreDetails_Driver_ID').append(data);
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
                    height:1500,

                    helpers:{
                        overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
                    }

                });
        
    });

</script>

<?php

$curDate = MaVehicleRegistry::model()->getServerDate("date");
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trtyre-details-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
    $vehicleId = Yii::app()->session['maintenVehicleId'];
    $type = Yii::app()->request->getQuery('type');


    $tyreTypeArr = Yii::app()->db->createCommand("SELECT T.Tyre_Type_ID, T.Tyre_Type FROM ma_tyre_type T INNER JOIN ma_vehicle_registry V  ON T.Tyre_Type_ID = V.Tyre_Type_ID WHERE V.Vehicle_No = '".$vehicleId."'")->queryAll();

    if (count($tyreTypeArr) >0)
    {
            $TyreType = $tyreTypeArr[0]['Tyre_Type'];
            $typeID = $tyreTypeArr[0]['Tyre_Type_ID'];
    }

    $tyreSizeArr = Yii::app()->db->createCommand("SELECT T.Tyre_Size_ID, T.Tyre_Size FROM ma_tyre_size T INNER JOIN ma_vehicle_registry V  ON T.Tyre_Size_ID = V.Tyre_Size_ID WHERE V.Vehicle_No = '".$vehicleId."'")->queryAll();
	$TyreSize = "";
	$TyreSizeID = "";
    if (count($tyreSizeArr) >0)
    {
            $TyreSize = $tyreSizeArr[0]['Tyre_Size'];
			$TyreSizeID = $tyreSizeArr[0]['Tyre_Size_ID'];
    }


    $tyreSizeArr = Yii::app()->db->createCommand("SELECT T.Tyre_Size_ID, T.Tyre_Size FROM ma_tyre_size T INNER JOIN ma_vehicle_registry V  ON T.Tyre_Size_ID = V.Tyre_Size_ID_2 WHERE V.Vehicle_No = '".$vehicleId."'")->queryAll();
	$TyreSize2 = "";
	$TyreSizeID2 = "";
    if (count($tyreSizeArr) >0)
    {
            $TyreSize2 = $tyreSizeArr[0]['Tyre_Size'];
			$TyreSizeID2 = $tyreSizeArr[0]['Tyre_Size_ID'];
    }
	
	

if(!isset($model->Request_Date))
{
    ?>
    <script>
        $(document).ready(function()
        {
            var curDate ='<?php echo $curDate; ?>';
            $('#TRTyreDetails_Request_Date').val(curDate);

        });

    </script>
<?php

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
        
       <?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
                   
             <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Request_Date'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Request_Date',array('class'=>'midText', 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                    <?php echo $form->error($model,'Request_Date'); ?>
                </div>
            </div>

             <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Meter_Reading'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Meter_Reading',array('class'=>'midText', 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                    <?php echo $form->error($model,'Meter_Reading'); ?>
                </div>
            </div>
			
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Driver_ID'); ?></div>
                <div class="tdTwo"><?php echo $form->dropDownList($model, 'Driver_ID', CHtml::listData(MaDriver::model()->getDriverNamesInLocation($vehicleId), 'Driver_ID', 'Full_Name'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect', 'options'=>$op)); ?>
                <a class="MaDriver addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maDriver/AddNew') ?>">
                <img src="images/1Screenshot-32.png" title="Add New Driver" />
            </a>
                <?php echo $form->error($model,'Driver_ID');?></div>
            </div>
        
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Tyre_Type_ID'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Tyre_Type_ID', array('class'=>'midText', 'value'=>$TyreType, 'id'=>$typeID, 'readOnly'=>true)); /*echo $form->dropDownList($model, 'Tyre_Type_ID', CHtml::listData(MaVehicleRegistry::model()->getTyreType($vehicleId), 'Tyre_Type_ID', 'Tyre_Type'));*/ ?>
                <?php echo $form->error($model,'Tyre_Type_ID');?></div>
            </div>
        
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Tyre_Size_ID'); ?></div>
                <div class="tdTwo"><?php echo $TyreSize ?>
                <?php echo $form->hiddenField($model,'Tyre_Size_ID', array('class'=>'midText', 'value'=>$TyreSizeID, 'readOnly'=>true));/*echo $form->dropDownList($model, 'Tyre_Size_ID', CHtml::listData(MaVehicleRegistry::model()->getTyreSize($vehicleId), 'Tyre_Size_ID', 'Tyre_Size'));*/ ?>
                <?php echo $form->error($model,'Tyre_Size_ID');?></div>
            </div>
        
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Tyre_quantity'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Tyre_quantity',array('class'=>'midText', 'maxLength'=>1));?>
                    <?php echo $form->error($model,'Tyre_quantity');?></div>
            </div>
			<?php if($TyreSize2 != "") { ?>
             <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Tyre_Size_ID_2'); ?></div>
                <div class="tdTwo"><?php echo $TyreSize2 ?>
                <?php echo $form->hiddenField($model,'Tyre_Size_ID_2', array('class'=>'midText', 'value'=>$TyreSizeID2, 'readOnly'=>true));/*echo $form->dropDownList($model, 'Tyre_Size_ID', CHtml::listData(MaVehicleRegistry::model()->getTyreSize($vehicleId), 'Tyre_Size_ID', 'Tyre_Size'));*/ ?>
                <?php echo $form->error($model,'Tyre_Size_ID_2');?></div>
            </div>
        
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Tyre_quantityType2'); ?></div>
                <div class="tdTwo"><?php echo $form->textField($model,'Tyre_quantityType2',array('class'=>'midText', 'maxLength'=>1));?>
                    <?php echo $form->error($model,'Tyre_quantityType2');?></div>
            </div>     
            <?php
			}
            if ($model->isNewRecord){
            echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
            }
            else {
            echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));
            }
             ?>
       
            <?php
            if ($model->isNewRecord){
            echo $form->hiddenField($model,'add_date',array('value'=>date("Y-m-d : H:i:s", time())));
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
            echo $form->hiddenField($model,'edit_date',array('value'=>date("Y-m-d : H:i:s", time())));
            }
            ?>
       
    <div class="row" style="padding-left:37%;font-weight:bold">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->