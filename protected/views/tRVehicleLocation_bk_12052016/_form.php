
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-location-form',
	'htmlOptions' => array('enctype' => 'multipart/form-data',),
    )); 

$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");
    $vID = Yii::app()->request->getQuery('id');
    $type = Yii::app()->request->getQuery('type');
    $vNo = Yii::app()->request->getQuery('vNo');
    ($vID != '' ? $op = array($vID =>Array ( 'selected' => 'selected' ) ): $op = array());



    if ($vID != '')
    {
        $cmd = 'Select Vehicle_No from vehicle_location where Vehicle_Location_ID ='.$vID;
        $rowData = Yii::app()->db->createCommand($cmd)->queryAll();
        $count = count($rowData);
        $vNo = $rowData[$count-1]['Vehicle_No'];
    }
?>

<script>

    $(document).ready(function(){

        $('#TRVehicleLocation_From_Date').Zebra_DatePicker();
        $('#TRVehicleLocation_To_Date').Zebra_DatePicker();
    });

</script>


    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="formTable" >
	
    <div class="tblRow">
        <div class="tdOne"><?php
        if ($type != 'transfer')
	{
		echo $form->hiddenfield($model,'Vehicle_No'); 
                echo '</div><div class="tdTwo">';
		echo $form->hiddenfield($model,'Vehicle_No', array('value'=>$vNo, 'readOnly'=>true));
		echo $form->error($model,'Vehicle_No'); 
		
	}
	else if($type == 'transfer')
	{
            echo $form->labelEx($model,'Vehicle_No'); 
            echo '</div><div class="tdTwo">';
            echo $form->dropdownlist($model,'Vehicle_No',CHtml::listData(
		MaVehicleRegistry::model()->getVehicles($vNo),'Vehicle_No','Vehicle_No')); 
        
		echo $form->error($model,'Vehicle_No'); 
	}
	?>
        </div></div>
	
    
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Location_ID'); ?></div>
            <div class="tdTwo"><?php  echo $form->dropDownList($model,'Location_ID',CHtml::listData(MaLocation::model()->findAllLocations(),'Location_ID','Location_Name'),array('prompt'=>'--- Please Select ---','class'=>'largeSelect')); ?>
                    <?php /*echo CHtml::ajaxButton(Yii::t('MaLocation',' '),$this->createUrl('MaLocation/addNew'),array(
                        'onclick'=>'if (MaLocationAjaxComplete) { $("#MaLocationDialog").dialog("open"); return false; } else { MaLocationAjaxComplete = true; }',
                        'update'=>'#MaLocationDialog'
                        ),array('id'=>'showMaLocationDialog', 'class'=>'addBtn', 'title'=>'Add New Item'));*/?>
                <?php echo $form->error($model,'Location_ID'); ?>
            </div>
        </div>
    
        <div class="tblRow">
            <div class="tdOne">

                <?php
                if ($type != 'transfer')
                {
                }
                else
                {
                    $model->From_Date = null;
                    $model->To_Date = null;
                }
                echo $form->labelEx($model,'From_Date'); ?>
            </div>
            <div class="tdTwo"><?php echo $form->textField($model,'From_Date',array('maxlength'=>4,'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                <?php echo $form->error($model,'From_Date'); ?>
            </div>
        </div>
    
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'To_Date'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'To_Date',array('maxlength'=>4,'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                <?php echo $form->error($model,'To_Date'); ?>
            </div>
        </div>
        
        <div class="tblRow">
            <div class="tdOne"></div>
            <div class="tdTwo"><?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?></div>
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
	


        <?php $this->endWidget(); ?>

    </div>

