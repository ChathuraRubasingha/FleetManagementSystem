<style type="text/css">

    #fancybox-loading div 
    {
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
        $(".MaReplacement").fancybox({
            afterClose: function()
            {
                $.ajax
                ({
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl("MaReplacement/UpdateReplacement") ?>",
                    success: function(data)
                    {
                       $("#MaSupplierCategory_Replacement_ID").append(data);
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
           // height:300,

            helpers:{
                overlay: {css: {"background": "rgba(238,238,238,0.85)" }}
            }

        });
        
        
        $(".MaSupplier").fancybox({
            afterClose: function()
            {
                $.ajax
                ({
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl("MaSupplier/UpdateSupplier") ?>",
                    success: function(data)
                    {
                       $("#MaSupplierCategory_Supplier_ID").append(data);
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
           // height:300,

            helpers:{
                overlay: {css: {"background": "rgba(238,238,238,0.85)" }}
            }

        });
    });
</script>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-supplier-category-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime"); ?>
    
    
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
   
        <div class="formTable">
        
        
     <div class="tblRow"><div class="tdOne">
       <?php  echo $form->labelEx($model,'Replacement_ID'); ?>
     </div><div class="tdTwo">
     
     <?php echo $form->dropDownList($model, 'Replacement_ID', CHtml::listData(
   MaReplacement::model()->findAll(), 'Replacement_ID', 'Replacement'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect'));   ?>
    <a class="MaReplacement addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maReplacement/AddNew') ?>">
        <img src="images/1Screenshot-32.png" title="Add New Replacement" />
    </a>
     
     

       <?php echo $form->error($model,'Replacement_ID'); ?>
    </div></div>
   
     <div class="tblRow"><div class="tdOne">
       <?php  echo $form->labelEx($model,'Supplier_ID'); ?>
     </div><div class="tdTwo">
     <?php echo $form->dropDownList($model, 'Supplier_ID', CHtml::listData(
   MaSupplier::model()->findAll(), 'Supplier_ID', 'Supplier_Name'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect'));   ?>
    <a class="MaSupplier addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maSupplier/AddNew') ?>">
        <img src="images/1Screenshot-32.png" title="Add New Supplier" />
    </a>
       <?php echo $form->error($model,'Supplier_ID'); ?>
    </div></div>
   
    

	

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