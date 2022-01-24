<style type="text/css">

    .error{
        
        color: red;
    }
</style>

<script>

    $(document).ready(function(){

        $('#VehicleTransfer_From_Date').Zebra_DatePicker();
        $('#VehicleTransfer_To_Date').Zebra_DatePicker();
        
        $(".MaLocation").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaLocation/UpdateLocation') ?>',
                success: function(data)
                {
                    $('#VehicleTransfer_To_Location_ID').append(data);
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



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-transfer-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
    $vNo = Yii::app()->request->getQuery('vNo');
    $vID = Yii::app()->request->getQuery('id');
    $type = Yii::app()->request->getQuery('type');
    $fromLoc = Yii::app()->request->getQuery('fromLoc');
    $id = Yii::app()->request->getQuery('id');
    $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");


    if ($fromLoc != '')
    {
	$data = Yii::app()->db->createCommand('SELECT Location_ID, Location_Name from ma_location where Location_ID ='.$fromLoc)->queryAll();
	$fromLocation = $data[0]['Location_Name'];
    }
    else if ($id != '')
    {
	$fromLoc = $model->From_Location_ID;
	$data = Yii::app()->db->createCommand('SELECT Location_ID, Location_Name from ma_location where Location_ID ='.$fromLoc)->queryAll();
	$fromLocation = $data[0]['Location_Name'];
    }/**/

    
    if ($vID != '')
    {
	$cmd = 'Select Vehicle_No ,Location_ID from vehicle_location where Vehicle_Location_ID ='.$vID;
	$rowData = Yii::app()->db->createCommand($cmd)->queryAll();
	
	$count = count($rowData);
	if ($count != 0)
	{
		$vNo = $rowData[$count-1]['Vehicle_No'];
		$locID = $rowData[$count-1]['Location_ID'];
	}
	else
	{
		$vNo = '';
		$locID = '';
	}
	
    }
    
    $vNo = Yii::app()->request->getQuery('vNo');
    if ($vNo == '')
    {
        $vNo = $model->Vehicle_No;
    }   
?>



    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="formTable" >
        
        <?php echo $form->hiddenField($model,'Vehicle_No', array('value'=>$vNo, 'readOnly'=>true))?>
   
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'From_Location_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->hiddenField($model,'From_Location_ID', array('size'=>39, 'value'=>$fromLoc, 'readOnly'=>true))?>
                <?php echo CHtml::textField('From_Location_ID',$fromLocation, array('size'=>39, 'readOnly'=>true))?>
                <?php echo $form->error($model,'From_Location_ID'); ?></div>
        </div>
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'To_Location_ID'); ?></div>
            <div class="tdTwo"> <?php echo $form->dropDownList($model, 'To_Location_ID', CHtml::listData(MaLocation::model()->findAllLocations(), 'Location_ID', 'Location_Name'),array('prompt' => '--- Please Select ---'));   ?>
                <a class="MaLocation addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('MaLocation/AddNew') ?>">
                    <img src="images/1Screenshot-32.png" title="Add New Location" />
                </a>
                    <?php echo $form->error($model,'To_Location_ID'); ?>
            </div>		
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
	
                

	<div class="row" style="padding-left:37%;font-weight:bold">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
        </div>
        <br/>
         <br/>
        <center><h2>Transfer Summary</h2></center>
                <div id="statusMsg">
                </div>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'vehicle-location-grid',
                    'dataProvider'=>$model->getTransferDetails(),
                    //'filter'=>$model,
                    'columns'=>array(
                        array('name'=>'Location_ID', 'header'=>'From', 'value'=>'$data->fromLocation->Location_Name'),
                        array('name'=>'Location_ID', 'header'=>'To', 'value'=>'$data->toLocation->Location_Name'),
                        'From_Date',
                        'To_Date',

                        array(
                            'class'=>'CButtonColumn',
                            'updateButtonUrl'=>'Yii::app()->createUrl("/vehicleTransfer/update", array("id" =>
                                $data["VehicleTransfer_ID"], "menuId"=>"vreg"))',
                            'viewButtonUrl'=>'Yii::app()->createUrl("/vehicleTransfer/view", array("id" =>
                                $data["VehicleTransfer_ID"], "menuId"=>"vreg"))',
                            'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
                        ),
                    ),
                )); ?>

<?php $this->endWidget(); ?>

</div>