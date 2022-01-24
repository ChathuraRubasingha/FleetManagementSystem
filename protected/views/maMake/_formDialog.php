
<div class="form" id="MaMakeDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-make-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
    'htmlOptions'=>array('style'=>'height:120px;'),
)); 
 $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");
?>

    <table width="100%" >
    
        <div class="row">
            <tr>
                <td width="150px"><?php echo $form->labelEx($model,'Make'); ?></td>
                <td><?php echo $form->textField($model,'Make',array('size'=>30,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'Make'); ?></td>
            </tr>
	</div>

        <?php date_default_timezone_set('Asia/Colombo'); ?>
        <div class="row" style="display: none">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
		}
		 ?>
	</div>

	<div class="row" style="display: none">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>$curDateTime));
		} else {
		echo $form->hiddenField($model,'add_date',array());	
		}
		?>
	</div>
 
    </table>
	<div class="row buttons" style="margin-left:65%;">
    
    <?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeMaMakeDialog').click(function()
			{
				$('#MaMake_Make').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaMake','Create'),CHtml::normalizeUrl(array('MaMake/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#MaVehicleRegistry_Make_ID").append(data);
			  $("#MaModel_Make_ID").append(data);
             $("#MaMakeDialog").dialog("close");                       			                       
		}                         
		else
		{                        
			                     
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaMakeDialog')); 
	 
	 ?>
    
<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaMake','Create'),CHtml::normalizeUrl(array('MaMake/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Make_ID").append(data);
                        $("#MaMakeDialog").dialog("close");
                    }'),array('id'=>'closeMaMakeDialog'));*/ ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->		
