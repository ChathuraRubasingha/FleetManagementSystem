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

    <?php $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime"); ?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-garages-form',
	'enableAjaxValidation'=>false,
)); 


if(!isset(Yii::app()->session["RemoveBtnSession"]))
{
    ?><script>
        $(document).ready(function()
        {
           $(".MaGarageType").fancybox({
                    afterClose: function()
                    {
                        $.ajax
                        ({
                            type: "POST",
                            url: "<?php echo Yii::app()->createAbsoluteUrl("MaGarageType/UpdateGarageType") ?>",
                            success: function(data)
                            {
                               $("#MaGarages_Garage_Type_ID").append(data);
                            },
                            error: function() {
                            },
                            dataType: "html"
                        });
                    },
                    openEffect: "elastic",
                    openSpeed: 300,
                    closeEffect: "elastic",      
                    closeSpeed: 300,
                    width: 500,
                   //height:1500,

                    helpers:{
                        overlay: {css: {"background": "rgba(238,238,238,0.85)" }}
                    }

                });
        });
    </script>
    <?php
}

// 
                      
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
       <div class="formTable">
	
    <div class="tblRow">
        
        <div class="tdOne"><?php echo $form->labelEx($model,'Garage_Type_ID'); ?></div>
        <div class="tdTwo"><?php echo $form->dropDownList($model,'Garage_Type_ID',CHtml::listData(MaGarageType::model()->findAll(),'Garage_Type_ID','Garage_Type'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
            <a class="MaGarageType addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maGarageType/AddNew') ?>">
                <img src="images/1Screenshot-32.png" title="Add New Garage" />
            </a>
            <?php echo $form->error($model,'Garage_Type_ID'); ?>
        </div> 
        
        
       
        </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Garage_Name'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Garage_Name',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'Garage_Name'); ?></div>
    </div>
           
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Owner_Name'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Owner_Name',array('size'=>60,'maxlength'=>200)); ?>
            <?php echo $form->error($model,'Owner_Name'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Email'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Email',array('size'=>60,'maxlength'=>100)); ?>
            <?php echo $form->error($model,'Email'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Registration_No'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Registration_No',array('class'=>'midText','maxlength'=>50)); ?>
            <?php echo $form->error($model,'Registration_No'); ?></div>
    </div>    
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Land_Phone_No'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Land_Phone_No',array('class'=>'midText','maxlength'=>10)); ?>
            <?php echo $form->error($model,'Land_Phone_No'); ?></div>
    </div>
           
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Fax'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Fax',array('class'=>'midText', 'maxlength'=>10)); ?>
            <?php echo $form->error($model,'Fax'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Contact_No'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Contact_No',array('class'=>'midText','maxlength'=>10)); ?>
            <?php echo $form->error($model,'Contact_No'); ?></div>
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
	

	<div class="row" style="padding-left:36.5%;font-weight:bold">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->