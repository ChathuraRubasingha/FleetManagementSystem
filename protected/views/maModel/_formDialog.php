

<div class="form" id="MaModelDialogForm">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-model-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
     'htmlOptions'=>array('style'=>'height:120px;'),
));  $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

?>

<script>

$(document).ready(function()
{
	//location.reload();
});
</script>
<?php
$var = Yii::app()->session['make'];

//var_dump($_POST['make_Id']);

if(isset($_POST['make_Id'])&&($_POST['make_Id'] !=="")){
    
    $make_id = $_POST['make_Id'];
    
?>


	<?php echo $form->errorSummary($model); ?>

	<table width="100%" >
    
    <div class="row" style="display: none;">
      
        <tr>
            <td width="150px" style="display: none;">
		<?php echo $form->labelEx($model,'Make_ID'); 
		if($var != '')
		{
			echo $var;
			exit;
		}
		?></td>
        
         
 <?php echo $form->error($model,'Make_ID'); ?>
                           <td>
            

                
           <?php echo $form->hiddenField($model,'Make_ID',array('value'=>$make_id));?>     
        </tr>
	</div>
	
	<div class="row">
            <tr>
                <td><?php echo $form->labelEx($model,'Model'); ?></td>
                <td><?php echo $form->textField($model,'Model',array('size'=>30,'maxlength'=>50)); ?>
                    <?php echo $form->error($model,'Model'); ?></td>
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
			$('#closeMaModelDialog').click(function()
			{
				$('#MaModel_Model').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaModel','Create'),CHtml::normalizeUrl(array('MaModel/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			$("#MaVehicleRegistry_Model_ID").append(data);
            $("#MaModelDialog").dialog("close");                      			                       
		}                         
		else
		{                        
			                     
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaModelDialog')); 
	 
	 ?>
     
     
<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaModel','Create'),CHtml::normalizeUrl(array('maModel/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Model_ID").append(data);
                        $("#MaModelDialog").dialog("close");
                    }'),array('id'=>'closeMaModelDialog'));*/ ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
}else{
    Yii::app()->user->setFlash("success", "Please select a make..!");
}
?>