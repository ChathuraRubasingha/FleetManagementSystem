<style>
        
    </style>

<script>
    $(document).ready(function()
    {
        $(".MaLocation").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaLocation/UpdateLocation') ?>',
                success: function(data)
                {
                    $('#MaDriver_Location_ID').append(data);
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
        width: 700,
        height:1500,
        
        helpers:{
            overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
        }

    });
    });
</script>




<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-driver-form',
	'enableAjaxValidation'=>true,
	/*'focus'=>array($model,'Full_Name'),*/ 
	'htmlOptions' => array('enctype' => 'multipart/form-data',),
)); 

$id = Yii::app()->request->getQuery('id');
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");
if($id=='')
{
	$id=0;
}

?>
    
    

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<div class="formTable" >
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Full_Name'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Full_Name',array('maxlength'=>200)); ?>
		<?php echo $form->error($model,'Full_Name'); ?>
        </div>
    </div> <!--end tblRow-->

    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Complete_Name'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Complete_Name',array('maxlength'=>200)); ?>
		<?php echo $form->error($model,'Complete_Name'); ?>
            
        </div>
    </div> <!--end tblRow-->
        
     <div class="tblRow">
         <div class="tdOne"><?php  echo $form->labelEx($model,'Location_ID'); ?></div>
         <div class="tdTwo"><?php echo $form->dropDownList($model, 'Location_ID', CHtml::listData(
                MaLocation::model()->findAllLocations(), 'Location_ID', 'Location_Name'),array('prompt' => '--- Please Select ---', 'class'=>'largeSelect'));   ?>
<!--                <a class="MaLocation addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('MaLocation/AddNew') ?>">
                    <img src="images/1Screenshot-32.png" title="Add New Location" />
                </a>-->
            <?php echo $form->error($model,'Location_ID'); ?>
         </div>
     </div> <!--end tblRow-->

	
     <div class="tblRow">
         <div class="tdOne"><?php echo $form->labelEx($model,'NIC'); ?></div>
         <div class="tdTwo"><?php echo $form->textField($model,'NIC',array('class'=>'midText', 'maxlength'=>12)); ?>
		 <?php echo $form->error($model,'NIC'); ?></div>
     </div> <!--end tblRow-->

     <div class="tblRow">
         <div class="tdOne"><?php echo $form->labelEx($model,'Status'); ?></div>
         <div class="tdTwo"><?php echo $form->dropDownList($model,'Status',array("1"=>"Active","0"=>"Inactive"), array('class'=>'midText', 'prompt'=>"--- Please Select ---", 'class'=>'midSelect')); ?>
		<?php echo $form->error($model,'Status'); ?></div>
     </div> <!--end tblRow-->
	
    
     <div class="tblRow">
         <div class="tdOne"><?php echo $form->labelEx($model,'Mobile'); ?></div>
         <div class="tdTwo"><?php echo $form->textField($model,'Mobile',array('class'=>'midText', 'maxlength'=>10)); ?>
		 <?php echo $form->error($model,'Mobile'); ?></div>
     </div> <!--end tblRow-->
	
    
     <div class="tblRow">
         <div class="tdOne"><?php echo $form->labelEx($model,'Private_Address'); ?></div>
         <div class="tdTwo"><?php echo $form->textArea($model,'Private_Address',array('rows'=>6, 'cols'=>56)); ?>
         <?php echo $form->error($model,'Private_Address'); ?></div>
     </div> <!--end tblRow-->


<script>
    $(document).ready(function()
    {
        var dID = <?php echo $id;?>
		
        $('#MaDriver_Driver_Image').change(function()
        {
            var file = $(this).get(0).files[0];
            var imageType = /image.*/;
            var fd = new FormData();
            fd.append('file', file);

            $.ajax
            ({
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
                $('#viewImage').html('');
                var img = document.createElement("img");
				//alert(img);
                img.setAttribute('width', '150px');
                img.setAttribute('height', '150px');

                var pre = document.getElementById("viewImage");

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
        $('a').click(function() 
        {
            $.ajax
            ({
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
        
        $('#removeImg').click(function()
        {
            var img =  $('#viewImage').html();
            var def = img.indexOf("Default.png");
            if(def<0)
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
                            $('#viewImage').html('<center><img src="images/Default.png"/></center>');
                            $('#MaDriver_Driver_Image').val("");
                            return false;
                        }
                        else
                        {
                            $('#MaDriver_Driver_Image').val("");
                            $('#viewImage').html('<center><img src="images/Default.png"/></center>');
                            return false;
                        }
                    }
                });
            }

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
        $img = '<img src="DriverImages/'.$filename.'" />';
    }
    else
    {
       $img ='<center><img src="DriverImages/Default.png"/></center>';
    }

?>
        
        
    <div class="tblRow">
        <div class="tdOne" style="margin-top: -60px"><?php echo $form->labelEx($model, 'Driver_Image');?></div>
        <div class="tdTwo">
            <div id="viewImage" data-provides="fileinput" style=""><?php echo  $img ?></div>

                <br />
                <div id="uploadFile_div">
                    <input type="button" value="Remove" id="removeImg" data-dismiss="fileinput" href="javascript:noAction()"/>
                </div>
                <?php echo CHtml::activeFileField($model, 'Driver_Image', array('class'=>'fileField', 'htmlOptions'=>'onkeydown="return false;"'));?>
          <div style="float:left; width:50px;">  </div>
            <?php echo $form->error($model, 'Driver_Image');?>
        </div>
    </div> <!--end tblRow-->
            
            
    <div class="tblRow">

            <?php
            $filename = $model->Driver_Image;

                    ?>
            <input type="hidden" name="last_uploaded_image" value="<?php
                    if (isset($_SESSION['selected_image'])) {
                        $file = $_SESSION['selected_image'];
                        echo $file;
                    }
                    ?>">
            <input type="hidden" name="old_image_file_name" value="<?php echo $filename ?>">
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
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id'=>'btnSave'));?>
        </div>

<?php $this->endWidget(); ?>

</div>