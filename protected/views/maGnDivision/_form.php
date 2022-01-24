<style>
    #MaGnDivision_DS_Division_ID
    {
        margin-left: -4px;
    }
</style>

<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();

$cs->registerCssFile($baseUrl . '/fancy/jquery.fancybox.css');

$cs->registerScriptFile($baseUrl . '/fancy/jquery.fancybox.pack.js');
?>

<?php

    // this code set is used in MaVehicleRegistry/_form.php to only show the selected make in creating a model
    $selectedDs=0;
    $DsID=0;
    $DsDiv='';
    if(isset( Yii::app()->session['selectedDs']))
    {
        $selectedDs =  Yii::app()->session['selectedDs'];
        $selectedDsArray = MaDsDivision::model()->getLastInsertedDsDiv($selectedDs);

        if(count($selectedDsArray)>0)
        {
            $DsID = $selectedDsArray[0]["DS_Division_ID"];
            $DsDiv = $selectedDsArray[0]["DS_Division"];
        }
    }
    

    ?>

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

<script>
    
    $(document).ready(function()
    {
        var DsID = '<?php echo $DsID; ?>';
        var DsDiv ='<?php echo $DsDiv ?>';

        if(DsDiv !='')
        {   
            var option = "<option value="+DsID+">"+DsDiv+"</option>";
            
            $('#MaGnDivision_DS_Division_ID').html("");
            $('#MaGnDivision_DS_Division_ID').html(option);
            
            $('.MaDsDivision').hide();
        }
        
        
        $('.MaDsDivision').click(function()
        {
            // uses not to overlapping the add new service type form in the service popup
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaDsDivision/Session4RemoveBtn') ?>',
                dataType: 'html'
            });
        });

        $(".MaDsDivision").fancybox({
            afterClose: function()
            {
                $.ajax
                ({
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl("MaDsDivision/UpdateDsDivision") ?>",
                    success: function(data)
                    {
                       $("#MaGnDivision_DS_Division_ID").append(data);
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
	'id'=>'ma-gn-division-form',
	'enableAjaxValidation'=>false,
)); 
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    
        <div class="formTable"> 
        
    <div class="tblrow">
        <div class="tdOne"><?php echo $form->labelEx($model,'DS_Division_ID'); ?></div>
        <div class="tdTwo"><?php echo $form->dropDownList($model,'DS_Division_ID',CHtml::listData(MaDsDivision::model()->findAllDsDivisions(),'DS_Division_ID','DS_Division'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
            <a class="MaDsDivision addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maDsDivision/AddNew') ?>">
                <img src="images/1Screenshot-32.png" title="Add New DS Division" />
            </a>
            <?php echo $form->error($model,'DS_Division_ID'); ?>
                    
        </div>
    </div>
	
    <div class="tblrow"><div class="tdOne">
		<?php echo $form->labelEx($model,'GN_Division'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'GN_Division',array('class'=>'midText','maxlength'=>200)); ?>
		<?php echo $form->error($model,'GN_Division'); ?>
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
	

<div class="row" style="padding-left:37%;font-weight:bold">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->