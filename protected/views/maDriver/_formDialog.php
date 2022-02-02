
<div class="form"  id="MaDriverDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-driver-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table width="550" border="1" class="tblle" >

<div class="row">
     <tr><td>
       <?php  echo $form->labelEx($model,'Location_ID'); ?>
     </td>
       <td> <div id="MaLocation">
    <?php echo $form->dropDownList($model, 'Location_ID', CHtml::listData(
    MaLocation::model()->findAllLocations(), 'Location_ID', 'Location_Name'),array('prompt' => '--- Please Select ---', 'class'=>'largeSelect'));   ?>
    <?php /*echo CHtml::ajaxButton(Yii::t('MaLocation',' '),$this->createUrl('MaLocation/addNew'),array(
        'onclick'=>'if (MaLocationAjaxComplete) { $("#MaLocationDialog").dialog("open"); return false; } else { MaLocationAjaxComplete = true; }',
        'update'=>'#MaLocationDialog'
        ),array('id'=>'showMaLocationDialog', 'class'=>'addBtn', 'title'=>'Add New Item'));*/ ?>
    <div id="MaLocationDialog"></div>
</div>
 <?php echo $form->error($model,'Location_ID'); ?>

</td>
       </tr>
    </div>


	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Full_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'Full_Name',array('size'=>18,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Full_Name'); ?>
        </td></tr>
	</div>

    <div class="row">
     <tr><td>
		<?php echo $form->labelEx($model,'Complete_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'Complete_Name',array('size'=>53,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Complete_Name'); ?>
        </td></tr>
     </div>



	<div class="row">
     <tr><td>
		<?php echo $form->labelEx($model,'NIC'); ?>
         </td><td>
		<?php echo $form->textField($model,'NIC',array('size'=>18,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'NIC'); ?>
        </td></tr>
	</div>

	<div class="row">
     <tr><td>
		<?php echo $form->labelEx($model,'Status'); ?>
         </td><td>
		<?php echo $form->dropDownList($model,'Status',array(""=>"--- Please Select ---","Active"=>"Active","Inactive"=>"Inactive")); ?>
		<?php echo $form->error($model,'Status'); ?>
        </td></tr>
	</div>

	<div class="row">
     <tr><td>
		<?php echo $form->labelEx($model,'Mobile'); ?>
         </td><td>
		<?php echo $form->textField($model,'Mobile',array('size'=>18,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Mobile'); ?>
        </td></tr>
	</div>

    <div class="row">
	<tr><td>
		<?php echo $form->labelEx($model,'Private_Address'); ?>
         </td><td>
         <?php echo $form->textArea($model,'Private_Address',array('rows'=>6, 'cols'=>56)); ?>

		<?php echo $form->error($model,'Private_Address'); ?>
        </td></tr>
        </div>
        <script>
    $(document).ready(function()
	{
		var dID = 0;

		$('#MaDriver_Driver_Image').change(function()
		{
            var file = $(this).get(0).files[0];
            var imageType = /image.*/;
            var fd = new FormData();
            fd.append('file', file);

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("MaDriver/SaveImageTemporary"); ?>',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {

                },
                error: function(data) { // if error occured
                    //alert("Error occured.please try again");

                },
                dataType: 'html'
            });

            if (!file.type.match(imageType))
			{
                alert("Invalid File Type");
            }
			else
			{
                $('#viewDriverImage').html('');
                var img = document.createElement("img");
				//alert(img);
                img.setAttribute('width', '150px');
                img.setAttribute('height', '150px');

                var pre = document.getElementById("viewDriverImage");

                img.classList.add("obj");

                img.file = file;
                pre.appendChild(img);

                var reader = new FileReader();
                reader.onload = (function(aImg)
				{
                    return function(e)
					{
                        aImg.src = e.target.result;
                    };
                })(img);
                reader.readAsDataURL(file);
            }
        });
		$('a').click(function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("MaDriver/DestroyImageSession"); ?>',
                data: {destroy: 'destroy'},
                processData: false,
                contentType: false,
                success: function() {
                },
                error: function() { // if error occured

                },
                dataType: 'html'
            });

        });
		$('#removeImgBtn').click(function()
		{
				$.ajax
				({
					url: "<?php echo $this->createAbsoluteUrl('MaDriver/RemoveImage') ?>",
					type: "post",
					dataType: "html",
					data: {'dID':dID},
					success: function(data)
					{
						if(data !=='no')
						{
							$('#viewDriverImage').html('<center><img src="DriverImages/Default.jpg" width="100px" height="100px" style="margin-top:20px"/></center>');
							$('#MaDriver_Driver_Image').val("");
							return false;
						}
						else
						{
							$('#MaDriver_Driver_Image').val("");

							$('#viewDriverImage').html('<center><img src="DriverImages/Default.jpg" width="100px" height="100px" style="margin-top:20px"/></center>');
							return false;

						}

					},
				});

		});


	});

	function clearFileInputField(tagId)
	{
		document.getElementById(tagId).innerHTML =document.getElementById(tagId).innerHTML;
	//alert(document.getElementById(tagId).innerHTML);
    }


    </script>
        <?php

$filename=$model->Driver_Image;

$dotPos = strpos($filename, '.');
$wdth = substr($filename,5,1);

if($dotPos != ''  && $id !='')
{
	$img = '<img src="DriverImages/'.$filename.'" width="150px" height="150px"/>';
}
else
{
   $img ='<center><img src="DriverImages/Default.jpg" width="100px" height="100px" style="margin-top:20px"/></center>';
}

?>
        <div class="row">
        <?php echo $filename=$model->Driver_Image; ?>
        <tr>
                <td><?php echo $form->labelEx($model, 'Driver_Image');?></td>
                <td><div id="viewDriverImage" data-provides="fileinput" style="height:150px; border:1px solid; width:150px;"><?php echo  $img ?></div>

				<div style="float:left" style="width:50px;">
                <input type="button" value="Remove" id="removeImgBtn" data-dismiss="fileinput" href="javascript:noAction()"/></div>
                <div id="uploadFile_div">
				<?php echo CHtml::activeFileField($model, 'Driver_Image', array('htmlOptions'=>'onkeydown="return false;"'));?></div>
                	<?php echo $form->error($model, 'Driver_Image');?>
                </td>
            </tr>


            <tr>
                    <td colspan="3" style="text-align:left;">

                        <input type="hidden" name="last_uploaded_image" value="<?php
                                if (isset($_SESSION['selected_image'])) {
                                    $file = $_SESSION['selected_image'];
                                    echo $file;
                                }
                                ?>">
                        <input type="hidden" name="old_image_file_name" value="<?php echo $filename ?>">
                    </td>
                </tr>
        </div>
	<?php date_default_timezone_set('Asia/Colombo'); ?>
	<div class="row">
		<?php
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));
		}
		 ?>
	</div>

	<div class="row">
		<?php
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>date("Y-m-d : H:i:s", time())));
		} else {
		echo $form->hiddenField($model,'add_date',array());
		}
		?>
	</div>

   <div class="row">
		<?php
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		?>
	</div>

	<div class="row">
		<?php
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_date',array('value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_date',array('value'=>date("Y-m-d : H:i:s", time())));
		}
		?>
	</div>
</table>
	<div class="row buttons" style="margin-left:80%;">
    <?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeMaDriverDialog').click(function()
			{
				$('#MaDriver_Full_Name').focus();
				$('#MaDriver_Complete_Name').focus();
				$('#MaDriver_NIC').focus();
				$('#MaDriver_Status').focus();
				$('#MaDriver_Mobile').focus();
				
				
				//alert('ok');
			});
		});
		
		");
		?>
        
         <?php echo CHtml::ajaxSubmitButton(Yii::t('MaDriver','Create'),CHtml::normalizeUrl(array('MaDriver/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'js: function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#VehicleDriver_Driver_ID").append(data);
			 $("#TRServices_Driver_ID").append(data);
			 $("#TRRepairRequest_Driver_ID").append(data);
			 $("#TRBatteryDetails_Driver_ID").append(data);
			 $("#TRTyreDetails_Driver_ID").append(data);
			 $("#TRAccident_Driver_ID").append(data);
			 
			 $("#MaDriverDialog").dialog("close");     
		}                         
		else
		{                        
			    $("#MaDriver_Full_Name").focus();            
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaDriverDialog')); 
	 
	 ?>
     
    </div>
    <?php $this->endWidget(); ?>

    </div>
    
     
        
        
    
     
     
    
        
		<?php 
		
		/*echo CHtml::ajaxSubmitButton(Yii::t('MaDriver','Create'),CHtml::normalizeUrl(array('MaDriver/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#VehicleDriver_Driver_ID").append(data);
						 $("#TRServices_Driver_ID").append(data);
						 $("#TRRepairRequest_Driver_ID").append(data);
						 $("#TRBatteryDetails_Driver_ID").append(data);
						 $("#TRTyreDetails_Driver_ID").append(data);
                        $("#MaDriverDialog").dialog("close");
                    }'),array('id'=>'closeMaDriverDialog'));*/ ?>
