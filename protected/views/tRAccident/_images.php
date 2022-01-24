<style>
    .MultiFile-remove
    {
        color: #FF0000;
        title:'Remove';
    }
    
    .imgOuter
    {
        width: auto; 
        height:auto; 
        border: thick solid #000; 
        float: left;
    }
    
    #list
    {
        min-width: 100%;
    }
    
</style>
    <!doctype html>

<link rel="stylesheet" type="text/css" href="css/upload.css">

    <div class="tblRow">
        <div class="tdOne"><?php echo CHtml::label('Accident Images','image'); ?></div>
        <div class="tdTwo">

<?php
        // echo $form->fileField($model, 'image_path', array('id' => 'files', 'name' => 'files[]', 'class' => 'fileUpload', 'multiple' => 'multiple'));
        $this->widget('CMultiFileUpload', array(
            'id' => 'files',
            'name' => 'files[]',
            'accept' => 'jpeg|jpg|gif|png',
            'duplicate' => 'Duplicate file!',
            'denied' => 'Invalid file type',
            'htmlOptions'=>array('multiple'=>'multiple'),
            'options' => array(
              
                'afterFileSelect' => "function(e)
                {
                    $('#previewImage').remove();
                    $('#newImages').html('New Image(s)');
                    if (e.files && e.files[0]) 
                    {
                        var reader = new FileReader();
                        reader.onload = (function(theFile) 
                        {
                            return function(e) 
                            {
                                // Render thumbnail.
                                var fileName = theFile.name.replace(' ','_'); 
                                var stringLen = fileName.length;
                                var newFileName = fileName.substring(0, (stringLen-4));
                                var div = document.createElement('div');
                                div.className='imgOuter';
                                div.id ='id_'+newFileName;
                                div.innerHTML = ['<img class=\'thumb\' src=',e.target.result,' id=',newFileName,' width=',100,' height=',100,' title=',fileName,' />'].join('');
//<span  class=\'deleteImage\'  id=',e.target.result,' ><img   id=\'removeImg\'   width=',25,' height=',25,' src=\'images/remove.png\' title=\'Remove Image\'></span>
                                document.getElementById('list').insertBefore(div, null);
                                                    
                            };
                        })(e.files[0]);
                        reader.readAsDataURL(e.files[0]);
                    }                    
                    
                }",
                'onFileRemove' => "function(e)
                    {                                                            
                        var fileName = e.files[0].name.replace(' ','_'); 
                        var stringLen = fileName.length;
                        var newFileName = fileName.substring(0, (stringLen-4));
                        $('#'+newFileName).remove();  
                        $('#id_'+newFileName).remove();  

                    }",
            )
        ));
        ?>

</div>
    </div>


<div class="form">

    <div style="height: auto">
        
       

        <?php
//        $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
//            'id' => 'uploadFile',
//            'config' => array(
//                'action' => Yii::app()->createUrl('TRAccident/ImageUpload'),
//                'allowedExtensions' => array("jpg", "jpeg", "gif", "png"), //array("jpg","jpeg","gif","exe","mov" and etc...
//                'sizeLimit' => 6 * 1024 * 1024, // maximum file size in bytes
//                'minSizeLimit' => 1024, // minimum file size in bytes
//                'multiple' => true, //
//            )
//        ));
        ?>

        <div id="response"></div>
        <div id="image-list">
            <?php
            $accID = Yii::app()->request->getQuery('id');
            if(isset($accID) && $accID != '')
            {
                $v_number =  Yii::app()->session['accidentVehicleId'];
                $directory = "accidentImages/$v_number/$accID";
                
                if (file_exists($directory)) 
                {
                    chdir($directory);
                    $images = glob("*.{jpg,JPG}", GLOB_BRACE);
                    echo '<div id="list"><center><h3><b>Uploaded Accident Images</b></h3></center>';
                    foreach ($images as $image) 
                    {
                        $fullImage = $image;
                        $underscorePos = strpos($image, '_');
                        $exclaPos = strpos($image, '!');

                        
                            echo '
                                <div class="imgOuter">' . CHtml::image("$directory/$image", 'DORE', array(
                                'width' => '100',
                                'height' => '100')) . "</br>" . "
                                <span  class='deleteImage' id='$directory/$fullImage'><img id='removeImg' width='25px' height='25px' src='images/remove.png' title='Remove Image'></span></div>
                                    
                                    ";
                        
                    }
                    echo '</div>';
                } 
                else 
                {
                    echo '<br/><h4>No Images for the accident</h4><div id="list"> </div>';
                }

            } 
            else 
            {
                echo "<div id='list'> </div>";
            }
            
            
            
            ?>

        </div>

    </div>



    <script type="text/javascript">
        $(document).ready(function() 
        {
            $('.deleteImage').click(function() 
            {
                var didConfirm = confirm("Are you sure?");
                if (didConfirm == true) 
                {
                    var imageId = $(this).attr('id');

                    $.ajax({
                        type: 'POST',
                        url: 'index.php?r=TRAccident/DeleteImages',
                        data: {'image_path': imageId},
                        success: function(data) {


                        }

                    });
                    $(this).parent().hide();
                }
            });
        });
    </script>  

</div>

