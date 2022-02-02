<style type="text/css">

    #fancybox-loading div {
        position: fixed;
        top: 0;
        left: 50%;
        width: 90px;
        height: 480px;
        background-image:'url(fancy/fancybox_loading@2x.gif)';
    }
</style>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-district-form',
	'enableAjaxValidation'=>false,
)); 
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

if(!isset(Yii::app()->session["Session4ProvincialOverlap"]))
{
   ?>
<script>
        $(document).ready(function()
        {
           $(".MaProvincialCouncils").fancybox
           ({
                afterClose: function()
                {
                    $.ajax
                    ({
                        type: "POST",
                        url: "<?php echo Yii::app()->createAbsoluteUrl("MaProvincialCouncils/UpdateProvincialCouncil") ?>",
                        success: function(data)
                        {
                           $("#MaDistrict_Provincial_Councils_ID").append(data);
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
                height:1500,

                helpers:{
                    overlay: {css: {"background": "rgba(238,238,238,0.85)" }}
                }

            });
        });
    </script>
<?php
}
?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>
<div class="formTable">
            
    <div class="tblrow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Provincial_Councils_ID'); ?></div>
        <div class="tdTwo"><?php echo $form->dropDownList($model,'Provincial_Councils_ID',CHtml::listData(MaProvincialCouncils::model()->findAllProvincial(),'Provincial_Councils_ID','Provincial_Councils_Name'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
            <a class="MaProvincialCouncils addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maProvincialCouncils/AddNew') ?>">
                <img src="images/1Screenshot-32.png" title="Add New Provincial Council" />
            </a>
            <?php echo $form->error($model,'Provincial_Councils_ID'); ?></div>
    </div>
	
    <div class="tblrow">
        <div class="tdOne"><?php echo $form->labelEx($model,'District_Name'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'District_Name',array('class'=>'midText','maxlength'=>200)); ?>
            <?php echo $form->error($model,'District_Name'); ?></div>
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

<?php $this->endWidget(); ?>

</div><!-- form -->