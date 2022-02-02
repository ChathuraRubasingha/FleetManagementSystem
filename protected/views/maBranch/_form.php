 <?php

    // this code set is used in MaVehicleRegistry/_form.php to only show the selected make in creating a model
    $selectedLoc=0;
    $locID=0;
    $loc='';
    if(isset( Yii::app()->session['selectedLoc']))
    {
        $selectedLoc =  Yii::app()->session['selectedLoc'];
        $selectedLocArray = MaLocation::model()->getLastInsertedLocation($selectedLoc);

        if(count($selectedLocArray)>0)
        {
            $locID = $selectedLocArray[0]["Location_ID"];
            $loc = $selectedLocArray[0]["Location_Name"];
        }
    }
    

    ?>

    <script>

        $(document).ready(function()
        {
            var locID = '<?php echo $locID?>';
            var location ='<?php echo $loc ?>';
            if(location !='')
            {
                var option = "<option value="+locID+">"+location+"</option>";
                $('#MaBranch_Location_ID').html("");
                $('#MaBranch_Location_ID').html(option);
                $('.MaLocation').hide();
            }

            $(".MaLocation").fancybox({
                    afterClose: function()
                    {
                        $.ajax
                        ({
                            type: "POST",
                            url: "<?php echo Yii::app()->createAbsoluteUrl("MaLocation/UpdateLocation") ?>",
                            success: function(data)
                            {
                               $("#MaBranch_Location_ID").append(data);
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
    

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-branch-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="formTable">
        
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model,'Location_ID'); ?></div>
                <div class="tdTwo"><?php echo $form->dropDownList($model,'Location_ID',CHtml::listData(MaLocation::model()->findAllLocations(),'Location_ID','Location_Name'),array('prompt'=>'--- Please Select ---','class'=>'largeSelect')); ?>
                <a class="MaLocation addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maLocation/AddNew') ?>">
                    <img src="images/1Screenshot-32.png" title="Add New Location" />
                </a>
                    <?php echo $form->error($model,'Location_ID'); ?>
                </div>
            </div>
       
    <div class="tblRow">
    	<div class="tdOne"><?php echo $form->labelEx($model,'Branch'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Branch',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'Branch'); ?></div>
    </div>
	
<?php 
date_default_timezone_set('Asia/Colombo'); ?>
	
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