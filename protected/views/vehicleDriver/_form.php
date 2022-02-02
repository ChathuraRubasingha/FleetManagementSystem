<style type="text/css">
    
    .error
    {
        color:red;        
    }
    
</style>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-driver-form',
	'htmlOptions' => array('enctype' => 'multipart/form-data',),
)); 
 $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");


?>

<script>

    $(document).ready(function(){

        $('#VehicleDriver_From_Date').Zebra_DatePicker();
        $('#VehicleDriver_To_Date').Zebra_DatePicker();
        
        
        $(".MaDriver").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaDriver/UpdateDriver') ?>',
                success: function(data)
                {
                    $('#VehicleDriver_Driver_ID').append(data);
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
        height:1500,
        
        helpers:{
            overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
        }

    });
        
        
    });



</script>



<?php

    $id = Yii::app()->request->getQuery('id');
    $vNo = Yii::app()->request->getQuery('vNo');
    $locID = Yii::app()->request->getQuery('loc');
    
    if ($locID != '')
    { 
        $loc = Yii::app()->db->createCommand('SELECT Location_Name FROM ma_location WHERE Location_ID='.$locID)->queryAll();
        $location = $loc[0]['Location_Name'];
    }
    else 
    {
        $location ='';
        $locID = 0;
    }

    if ($vNo == '')
    {
	$vNo = $model->Vehicle_No;
    }
?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="formTable" >
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->hiddenField($model,'Vehicle_No'); ?></div>
        <div class="tdTwo"><?php   echo $form->hiddenField($model,'Vehicle_No',array('value'=>$vNo,'size'=>10,'maxlength'=>20, 'readOnly'=>true)); ?></div>
    </div>
    
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Location_ID'); ?></div>
        <div class="tdTwo"><?php 
            if ($id == '')
            {
                echo $form->textField($model,'Location_ID', array('size'=>60, 'value'=>$location)); 
            }
            else if ($id != '') 
            {
                $preLoc = $model->Location_ID;
                $cmd = 'select Location_Name from ma_location where Location_ID='.$preLoc;
                $data = Yii::app()->db->createCommand($cmd)->queryAll();
                $prLoc = $data[0]['Location_Name']; echo $form->textField($model,'Location_ID', array('size'=>45, 'value'=>$prLoc));
            }?>
            <?php echo $form->error($model,'Location_ID'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Driver_ID'); ?></div>		
        <div class="tdTwo"> 
            <?php if($id == '')
            { 
                echo $form->dropdownlist($model,'Driver_ID', CHtml::listData(MaDriver::model()->getLocationDriver($locID), 'Driver_ID', 'Full_Name'), array('prompt'=>'--- Please Select ---', 'class'=>'midSelect'));
            }
            else if ($id != '')
            { 
                $locID = $model->Location_ID;
                $dr = $model->Driver_ID;
                $drvrN ='';
                $arr= MaDriver::model()->getLocationDriver($locID);
                if($dr !='')
                {
                    $drvrN =$model->driver->Full_Name;
                    $ar2 = array(array('Driver_ID'=>$dr, 'Full_Name'=>$drvrN));
                    $arr = array_merge($arr, $ar2);
                }
                echo $form->dropdownlist($model,'Driver_ID', CHtml::listData($arr, 'Driver_ID', 'Full_Name'), array('prompt'=>'--- Please Select ---', 'class'=>'midSelect'));
            }   ?>
                <a class="MaDriver addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maDriver/AddNew') ?>">
                    <img src="images/1Screenshot-32.png" title="Add New Driver" />
                </a>
            <?php echo $form->error($model,'Driver_ID'); ?></div>   
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'From_Date'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'From_Date',array('size'=>20,'maxlength'=>4,'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
        <?php echo $form->error($model,'From_Date'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'To_Date'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'To_Date',array('size'=>20,'maxlength'=>4,'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
        <?php echo $form->error($model,'To_Date'); ?></div>
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
	
    


    <?php 

    $id = Yii::app()->request->getQuery('id');

    if($id == '')
    {
        $arr = Yii::app()->db->createCommand('SELECT distinct Vehicle_No FROM `vehicle_driver` where Vehicle_No = "'.$vNo.'"')->queryAll();
        $count = count($arr);
        if (count($arr)>0)
        {

        }
    }
    ?>

    <div class="row" style="padding-left:37%;font-weight:bold">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
    </div><!--,array('confirm'=>'Do you want to add this record ?')-->

<?php $this->endWidget(); ?>

</div>
