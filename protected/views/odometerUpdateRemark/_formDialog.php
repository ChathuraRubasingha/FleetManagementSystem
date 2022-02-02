<div class="form"  id="OdometerUpdateRemarkForm">

    <?php
	date_default_timezone_set('Asia/Colombo');
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'odometer-remark-form',
        'enableAjaxValidation'=>true,
		'enableClientValidation'=>true, 
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <table>
        <tr class="row">
            <td width="150px"><?php echo $form->labelEx($model, 'description'); ?></td>
            <td><?php echo $form->textArea($model, 'description', array('size' => 50, 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'description'); ?>
            </td>    
        </tr>

        <tr class="row">
            <?php //echo $form->labelEx($model,'added_by'); ?>
            <?php echo $form->hiddenField($model, 'add_by', array('value' => Yii::app()->getModule('user')->user()->username)); ?>
            <?php //echo $form->error($model,'added_by');  ?>
        </tr>

        <tr class="row">
            <?php //echo $form->labelEx($model,'added_date'); ?>
            <?php echo $form->hiddenField($model, 'add_date', array('value' => date('Y-m-d'))); ?>
            <?php //echo $form->error($model,'added_date');  ?>
        </tr>


    </table>
<div class="row buttons" style="margin-left:67%;">

    <?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeOdometerUpdateRemarkDialog').click(function()
			{
				$('#OdometerUpdateRemark_remark_id').focus();
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('OdometerUpdateRemark','Create'),CHtml::normalizeUrl(array('odometerUpdateRemark/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			$("#OdometerUpdate_remark_id").append(data);
            $("#OdometerUpdateRemarkDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			                       
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeOdometerUpdateRemarkDialog')); 
	 
	 ?>
     
<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaTyreType','Create'),CHtml::normalizeUrl(array('MaTyreType/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Tyre_Type_ID").append(data);
                        $("#MaTyreTypeDialog").dialog("close");
                    }'),array('id'=>'closeMaTyreTypeDialog'));*/ ?>	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


