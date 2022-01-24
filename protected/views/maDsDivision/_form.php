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

<?php

    // this code set is used in MaVehicleRegistry/_form.php to only show the selected make in creating a model
    $selectedDist=0;
    $DistID=0;
    $Dist='';
    if(isset( Yii::app()->session['selectedDistrict']))
    {
        $selectedDist =  Yii::app()->session['selectedDistrict'];
        $selectedDistArray = MaDistrict::model()->getLastInsertedDistrict($selectedDist);

        if(count($selectedDistArray)>0)
        {
            $DistID = $selectedDistArray[0]["District_ID"];
            $Dist = $selectedDistArray[0]["District_Name"];
        }
    }
    

    ?>

<script type="text/javascript">

    $(document).ready(function()
    {
        var distID = '<?php echo $DistID; ?>';
        var dist ='<?php echo $Dist ?>';

        if(dist !='')
        {   
            var option = "<option value="+distID+">"+dist+"</option>";
            
            $('#MaDsDivision_District_ID').html("");
            $('#MaDsDivision_District_ID').html(option);
            
            $('.MaDistrict').hide();
        }
    
    
    
    $('.MaDistrict').click(function()
    {
        // uses not to overlapping the add new provincial council form in the district popup
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl('MaDistrict/Session4ProvincialOverlap') ?>',
            dataType: 'html'
        });
    });
    
   
});


</script>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-ds-division-form',
	'enableAjaxValidation'=>false,
)); 
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

if(!isset(Yii::app()->session["RemoveBtnSession"]))
{
    ?>
<script type="text/javascript">

$(document).ready(function()
{    
    $(".MaDistrict").fancybox
    ({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaDistrict/UpdateDistrict') ?>',
                success: function(data)
                {
                    $('#MaDsDivision_District_ID').append(data);
                },
                error: function() {

                },
                dataType: 'html'
            });
        },
        openEffect: 'elastic',
        openSpeed: 300,
        closeEffect: 'elastic',
        closeSpeed: 600,
        width: 500,
        helpers:{
            overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
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
        <div class="tdOne"><?php echo $form->labelEx($model,'District_ID'); ?></div>
        <div class="tdTwo"><?php echo $form->dropDownList($model,'District_ID',CHtml::listData(MaDistrict::model()->findAllDistricts(),'District_ID','District_Name'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
            <a class="MaDistrict addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maDistrict/AddNew') ?>">
                <img src="images/1Screenshot-32.png" title="Add New District" />
            </a>
            <?php echo $form->error($model,'District_ID'); ?></div>
    </div>
	
    <div class="tblrow">
        <div class="tdOne"><?php echo $form->labelEx($model,'DS_Division'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'DS_Division',array('class'=>'midText','maxlength'=>200)); ?>
            <?php echo $form->error($model,'DS_Division'); ?></div>
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