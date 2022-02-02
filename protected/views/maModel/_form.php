<?php $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime"); ?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-model-form',
	'enableAjaxValidation'=>false,
)); ?>

    <?php

    // this code set is used in MaVehicleRegistry/_form.php to only show the selected make in creating a model
    $selectedMake=0;
    $makeID=0;
    $make='';
    if(isset( Yii::app()->session['selectedMake']))
    {
        $selectedMake =  Yii::app()->session['selectedMake'];
        $selectedMakeArray = MaMake::model()->getLastInsertedMake($selectedMake);

        if(count($selectedMakeArray)>0)
        {
            $makeID = $selectedMakeArray[0]["Make_ID"];
            $make = $selectedMakeArray[0]["Make"];
        }
    }
    ?>

    <script>

        $(document).ready(function()
        {
            var makeID = '<?php echo $makeID?>';
            var make ='<?php echo $make ?>';
            if(make !='')
            {
                var option = "<option value="+makeID+">"+make+"</option>";
                $('#MaModel_Make_ID').html("");
                $('#MaModel_Make_ID').html(option);
                $('.MaMake').hide();
            }

            $(".MaMake").fancybox({
                afterClose: function()
                {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createAbsoluteUrl('MaMake/UpdateMake') ?>',
                        success: function(data)
                        {
                            $('#MaVehicleRegistry_Make_ID').append(data);
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
                width: 600,
                helpers: {
                    overlay: {
                        css: {
                            'background': 'rgba(238,238,238,0.85)'
                        }
                    }
                } /**/

            });

        });
    </script>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="formTable">
    <div class="tblRow"><div class="tdOne">		
		<?php echo $form->labelEx($model,'Make_ID'); ?></div>
         <div class="tdTwo"><?php echo $form->dropDownList($model, 'Make_ID', CHtml::listData(
    MaMake::model()->findAllMakes(), 'Make_ID', 'Make'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect'));   ?>
             <a class="MaMake addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('MaMake/AddNew') ?>">
                 <img src="images/1Screenshot-32.png" title="Add New Make" />
             </a>
 <?php echo $form->error($model,'Make_ID'); ?>
                    
</div>
        
       <!-- <div class="tdOne">
		<?php #echo $form->dropDownList($model, 'Make_ID', CHtml::listData(
   # MaMake::model()->findAll(), 'Make_ID', 'Make'),array('prompt' => '--- Please Select ---'));   ?>
		<?php #echo $form->error($model,'Make_ID'); ?></div>-->
        </div>
	
    <div class="tblRow">
    <div class="tdOne">
		<?php echo $form->labelEx($model,'Model'); ?></div>
		<div class="tdTwo"><?php echo $form->textField($model,'Model',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'Model'); ?></div>
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