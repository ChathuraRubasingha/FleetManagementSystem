<style type="text/css">

    #fancybox-loading div {
        position: fixed;
        top: 0;
        left: 50%;
        width: 40px;
        height: 480px;
        background-image:'url(fancy/fancybox_loading@2x.gif)';
    }
    
    #MaLocation_GN_Division_ID
    {
        margin-left: -4px;
    }
    #MaLocation_DS_Division_ID
    {
        margin-left: -4px;
    }
    #MaLocation_District_ID
    {
        margin-left: -4px;
    }
</style>

 <?php

    // this code set is used in MaVehicleRegistry/_form.php to only show the selected make in creating a model
    $selectedDist=0;
    $DistID=0;
    $Dist='';
    if(isset( Yii::app()->session['selectedDist']))
    {
        $selectedDist =  Yii::app()->session['selectedDist'];
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
            
            $.ajax
            ({
                type:"POST",
                url:'<?php echo Yii::app()->createAbsoluteUrl("MaDsDivision/GetDsDivs")?>',
                data:{'dist':distID},
                success:function(data)
                {
                    var option ='<option value="">--- Please Select ---</option>';
                               
                    $.each(data, function(i, val)
                    {
                        var dsID = val['DS_Division_ID'];
                        var dsDiv = val['DS_Division'];

                        
                        option += '<option value="'+dsID+'">' + dsDiv + '</option>';
                       

                    });
                
                   $('#MaLocation_DS_Division_ID').html(option);
                },
                error:function()
                {
                },
                dataType:"json"
                
            });
            
            var option = "<option value="+distID+">"+dist+"</option>";
            
            $('#MaLocation_District_ID').html("");
            $('#MaLocation_District_ID').html(option);
            
            $('.MaDistrict').hide();
        }

           
                
        $(".MaDistrict").fancybox
        ({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaDistrict/UpdateDistrict') ?>',
                    success: function(data)
                    {
                        var option ='<option value="">--- Please Select ---</option>';
                        if(data !=='')
                        {
                            $('#MaLocation_District_ID').append(data);
                            $('#MaLocation_DS_Division_ID').html(option);
                            $('#MaLocation_GN_Division_ID').html(option);
                        }
                        
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
        
        $('.MaDsDivision').click(function()
        {
            var dist = $('#MaLocation_District_ID').val();
            
            if(dist =='')
            {
                $("#DsDivision_Error").html("Please select a District");
                setTimeout(function(){
                    $("#DsDivision_Error").html("");
                },4000);
                return false;
            }
            else
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaDsDivision/AddNew') ?>',
                    data:{'dist':dist},
                    success: function(data)
                    {
                    },
                    error: function() {
                    },
                    dataType: 'html'
                });

                // uses not to overlapping the add new service type form in the service popup
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaDsDivision/Session4RemoveBtn') ?>',
                    dataType: 'html'
                });
            }
       });
        
        
        $('.MaDistrict').click(function()
        {
            // uses not to overlapping the add new provincial council form in the district popup
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaDistrict/Session4ProvincialOverlap') ?>',
                dataType: 'html'
            });
        });
        
        $(".MaDsDivision").fancybox 
        ({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaDsDivision/UpdateDsDivision') ?>',
                    success: function(data)
                    {
                        var option ='<option value="">--- Please Select ---</option>';
                        $('#MaLocation_DS_Division_ID').append(data);
                        
                        $('#MaLocation_GN_Division_ID').html(option);
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
        
              
        
        $('.MaGnDivision').click(function()
        {
            var dsDiv = $('#MaLocation_DS_Division_ID').val();
            
            if(dsDiv =='')
            {
                $("#GnDivision_Error").html("Please select a DS Division");
                setTimeout(function(){
                    $("#GnDivision_Error").html("");
                },4000);
                return false;
            }
            else
            {              
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaGnDivision/AddNew') ?>',
                    data:{'dsDiv':dsDiv},
                    success: function(data)
                    {
                    },
                    error: function() {
                        alert('data');
                    },
                    dataType: 'html'
                });

            }
        });
        
        $(".MaGnDivision").fancybox 
        ({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaGnDivision/UpdateGnDivision') ?>',
                    success: function(data)
                    {
                        $('#MaLocation_GN_Division_ID').append(data);
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

        $("#MaLocation_District_ID").change(function() 
        {
            var option ='<option value="">--- Please Select ---</option>';
            $('#MaLocation_DS_Division_ID').html(option);
            $('#MaLocation_GN_Division_ID').html(option);
        })

        $("#MaLocation_DS_Division_ID").change(function() 
        {

            /*if ($("#MaLocation_DS_Division_ID").val() === "") {

                $("#MaLocation_GN_Division_ID").val("");
            }*/
        })

    });

</script>
<?php
/* @var $this MaLocationController */
/* @var $model MaLocation */
/* @var $form CActiveForm */

$AccessModule = new Access();

$id = Yii::app()->request->getQuery('id');
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

if ($id != '') {
    //echo $model->Location_ID; exit;
    $rowData = Yii::app()->db->createCommand('SELECT District_ID, DS_Division_ID, GN_Division_ID FROM ma_location WHERE Location_ID="' . $id . '"')->queryAll();
    $count = count($rowData);
    if ($count != 0) {
        $dsDivID = $rowData[$count - 1]['DS_Division_ID'];
        $gnDivID = $rowData[$count - 1]['GN_Division_ID'];
        $districtID = $rowData[$count - 1]['District_ID'];

        //echo $dsDivID. '  ' . $gnDivID. '  '. $districtID; exit;
    } else {
        $dsDivID = '';
        $gnDivID = '';
        $districtID = '';
    }

    if (($dsDivID != '') && ($gnDivID != '')) {
        $data1 = Yii::app()->db->createCommand('SELECT DS_Division FROM ma_ds_division WHERE DS_Division_ID =' . $dsDivID)->queryAll();
        $count1 = count($data1);
        if ($count1 != 0) {
            $dsDivName = $data1[$count1 - 1]['DS_Division'];
        } else {
            $dsDivName = '';
        }

        $data2 = Yii::app()->db->createCommand('SELECT GN_Division FROM ma_gn_division WHERE GN_Division_ID =' . $gnDivID)->queryAll();
        $count2 = count($data2);
        if ($count2 != 0) {
            $gnDivName = $data2[$count2 - 1]['GN_Division'];
        } else {
            $gnDivName = '';
        }
    }

    ($dsDivID != '' ? $op1 = array($dsDivID => Array('selected' => 'selected')) : $op1 = array());
    ($gnDivID != '' ? $op2 = array($gnDivID => Array('selected' => 'selected')) : $op2 = array());
} else {

    $dsDivID = '';
    $gnDivID = '';
    $districtID = '';
}

?>








    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ma-location-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>


    <div class="formTable">

       
            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model, 'District_ID'); ?></div>
                <div class="tdTwo"><?php
                        $Division = CHtml::listData(MaDistrict::model()->findAllDistricts(), 'District_ID', 'District_Name');
                        echo $form->DropDownList($model, 'District_ID', $Division, array('ajax' =>
                            array(
                                'type' => 'POST', //request type
                                'url' => CController::createUrl('MaDsDivision/DynamicDsDivisions'), //url to call.
                                'update' => '#' . CHtml::activeId($model, 'DS_Division_ID'),
                            // 'data'=>'js:jQuery(this).serialize()'
                            ),
                            'empty' => '--- Please Select ---', 'class' => 'midSelect')
                        );
                        ?>
                        <a class="MaDistrict addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maDistrict/AddNew') ?>">
                            <img src="images/1Screenshot-32.png" title="Add New District" />
                        </a>
                    <?php echo $form->error($model, 'District_ID'); ?>
                </div>
            </div>




            <div class="tblRow">
                <div class="tdOne"><?php echo $form->labelEx($model, 'DS_Division_ID'); ?></div>
                <div class="tdTwo">

                        <?php
                        $district = '';
                        $dsDivision = '';
                        if (isset(Yii::app()->session['district']) && Yii::app()->session['district'] != '') 
                        {
                            $district = Yii::app()->session['district'];
                            if (isset(Yii::app()->session['dsDivision']) && Yii::app()->session['dsDivision'] != '') 
                            {
                                $district = Yii::app()->session['district'];
                                $dsDivision = Yii::app()->session['dsDivision'];

                                if ((($id != '') && ($dsDivID != '')) || ($dsDivision != '')) 
                                {
                                    echo $form->dropdownlist($model, 'DS_Division_ID', CHtml::listData(
                                                    MaDsDivision::model()->getDsDiv($district), 'DS_Division_ID', 'DS_Division'), array('ajax' =>
                                        array(
                                            'type' => 'POST', //request type
                                            'url' => CController::createUrl('MaGnDivision/DynamicGnDivisions'), //url to call.
                                            'update' => '#' . CHtml::activeId($model, 'GN_Division_ID'),
                                        // 'data'=>'js:jQuery(this).serialize()'
                                        ),
                                        'empty' => '--- Please Select ---', 'class' => 'midSelect')
                                    );
                                } 
                                else 
                                {
                                    echo $form->dropdownlist($model, 'DS_Division_ID', array(), array('ajax' =>
                                        array(
                                            'type' => 'POST', //request type
                                            'url' => CController::createUrl('MaGnDivision/DynamicGnDivisions'), //url to call.
                                            'update' => '#' . CHtml::activeId($model, 'GN_Division_ID'),
                                        // 'data'=>'js:jQuery(this).serialize()'
                                        ),
                                        'empty' => '--- Please Select ---', 'class' => 'midSelect')
                                    );
                                }
                            } 
                            else 
                            {
                                if ((($id != '') && ($dsDivID != ''))) 
                                {
                                    echo $form->dropdownlist($model, 'DS_Division_ID', CHtml::listData(
                                                    MaDsDivision::model()->getDsDiv($district), 'DS_Division_ID', 'DS_Division'), array('ajax' =>
                                        array(
                                            'type' => 'POST', //request type
                                            'url' => CController::createUrl('MaGnDivision/DynamicGnDivisions'), //url to call.
                                            'update' => '#' . CHtml::activeId($model, 'GN_Division_ID'),
                                        // 'data'=>'js:jQuery(this).serialize()'
                                        ),
                                        'empty' => '--- Please Select ---', 'class' => 'midSelect')
                                    );
                                } 
                                else 
                                {
                                    echo $form->dropdownlist($model, 'DS_Division_ID', array(), array('ajax' =>
                                        array(
                                            'type' => 'POST', //request type
                                            'url' => CController::createUrl('MaGnDivision/DynamicGnDivisions'), //url to call.
                                            'update' => '#' . CHtml::activeId($model, 'GN_Division_ID'),
                                        // 'data'=>'js:jQuery(this).serialize()'
                                        ),
                                        'empty' => '--- Please Select ---', 'class' => 'midSelect')
                                    );
                                }
                            }
                        } 
                        else 
                        {
                            if (($id != '') && ($dsDivID != '')) 
                            {
                                echo $form->dropdownlist($model, 'DS_Division_ID', CHtml::listData(
                                                MaDsDivision::model()->getDsDiv($districtID), 'DS_Division_ID', 'DS_Division'), array('ajax' =>
                                    array(
                                        'type' => 'POST', //request type
                                        'url' => CController::createUrl('MaGnDivision/DynamicGnDivisions'), //url to call.
                                        'update' => '#' . CHtml::activeId($model, 'GN_Division_ID'),
                                    // 'data'=>'js:jQuery(this).serialize()'
                                    ),
                                    'empty' => '--- Please Select ---', 'class' => 'midSelect', 'options' => $op1)
                                );
                            } 
                            else 
                            {
                                echo $form->dropdownlist($model, 'DS_Division_ID', array(), array('ajax' =>
                                    array(
                                        'type' => 'POST', //request type
                                        'url' => CController::createUrl('MaGnDivision/DynamicGnDivisions'), //url to call.
                                        'update' => '#' . CHtml::activeId($model, 'GN_Division_ID'),
                                    // 'data'=>'js:jQuery(this).serialize()'
                                    ),
                                    'empty' => '--- Please Select ---', 'class' => 'midSelect')
                                );
                            }
                        }
                        ?>

                        <script>
                            $(document).ready(function()
                            {

                                $('#showMaDsDivisionDialog').click(function()
                                {
                                    var txt = $('#MaLocation_District_ID').val();

                                    //alert(txt);

                                    $.ajax({
                                        type: 'POST',
                                        data: {txt: txt},
                                        url: 'storesession.php',
                                        success: function(data) {
                                        },
                                        error: function() {
                                        }
                                    });

                                    /*jQuery.ajax({
                                     url: 'storesession.php',
                                     type: 'POST',
                                     data: {
                                     txt: txt,
                                     },
                                     dataType : 'json',
                                     success: function(data, textStatus, xhr) {
                                     //alert('pfsldjfl');
                                     console.log(data); // do with data e.g success message
                                     },
                                     error: function(xhr, textStatus, errorThrown) {
                                     console.log(textStatus.reponseText);
                                     }
                                     });*/
                                });
                            });
                        </script>

                        <a class="MaDsDivision addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maDsDivision/AddNew') ?>">
                            <img src="images/1Screenshot-32.png" title="Add New DS Division" />
                        </a>
                        <div id="DsDivision_Error" style="color:#FF0000"></div>
                    <?php echo $form->error($model, 'DS_Division_ID'); ?>

                </div>
                </div>



            <div class="tblRow"><div class="tdOne">
                    <?php echo $form->labelEx($model, 'GN_Division_ID'); ?>
                </div>
                <div class="tdTwo"><?php
                        $district = '';
                        $dsDivision = '';
                        $gnDivision = '';

                        if (isset(Yii::app()->session['district']) && Yii::app()->session['district'] != '') {
                            $district = Yii::app()->session['district'];

                            if (isset(Yii::app()->session['dsDivision']) && Yii::app()->session['dsDivision'] != '') {
                                $dsDivision = Yii::app()->session['dsDivision'];

                                if (isset(Yii::app()->session['gnDivision']) && Yii::app()->session['gnDivision'] != '') {
                                    $gnDivision = Yii::app()->session['gnDivision'];


                                    if ((($id != '') && ($gnDivID != '')) || ($gnDivision != '') || ($dsDivision != '') || ($district != '')) {

                                        echo $form->dropdownlist($model, 'GN_Division_ID', CHtml::listData(MaGnDivision::model()->getGnDiv($dsDivision), 'GN_Division_ID', 'GN_Division'), array('prompt' => '--- Please Select ---', 'class' => 'midSelect'));
                                    } else {
                                        //echo $dsDivision; exit;
                                        echo $form->dropdownlist($model, 'GN_Division_ID', array(), array('empty' => '--- Please Select ---', 'class' => 'midSelect'));
                                    }
                                } else {
                                    if ((($id != '') && ($gnDivID != '')) || ($gnDivision != '')) {
                                        echo $form->dropdownlist($model, 'GN_Division_ID', CHtml::listData(
                                                        MaGnDivision::model()->getGnDiv($dsDivision), 'GN_Division_ID', 'GN_Division'), array('prompt' => '--- Please Select ---', 'class' => 'midSelect'));
                                    } else {
                                        echo $form->dropdownlist($model, 'GN_Division_ID', array(), array('empty' => '--- Please Select ---', 'class' => 'midSelect'));
                                    }
                                }
                            } else {
                                if ((($id != '') && ($gnDivID != '')) || ($gnDivision != '') || ($district != '')) {
                                    echo $form->dropdownlist($model, 'GN_Division_ID', CHtml::listData(MaGnDivision::model()->getGnDiv($dsDivID), 'GN_Division_ID', 'GN_Division'), array('prompt' => '--- Please Select ---', 'class' => 'midSelect'));
                                } else {
                                    echo $form->dropdownlist($model, 'GN_Division_ID', array(), array('empty' => '--- Please Select ---', 'class' => 'midSelect'));
                                }
                            }
                        } else {
                            if (($id != '') && ($gnDivID != '')) {
                                echo $form->dropdownlist($model, 'GN_Division_ID', CHtml::listData(MaGnDivision::model()->getGnDiv($dsDivID), 'GN_Division_ID', 'GN_Division'), array('prompt' => '--- Please Select ---', 'class' => 'midSelect', 'options' => $op2));
                            } else {
                                echo $form->dropdownlist($model, 'GN_Division_ID', array(), array('empty' => '--- Please Select ---', 'class' => 'midSelect'));
                            }
                        }
                        ?>
                        <a class="MaGnDivision addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maGnDivision/AddNew') ?>">
                            <img src="images/1Screenshot-32.png" title="Add New GN Division" />
                        </a>
                    <div id="GnDivision_Error" style="color:#FF0000"></div>
                    <?php echo $form->error($model, 'GN_Division_ID'); ?>

                </div>

<!-- <div class="tdOne">
                <?php /* ?><?php echo $form->textField($model,'GN_Division_ID'); ?><?php */ ?>
                <?php //echo $form->dropdownlist($model,'GN_Division_ID',CHtml::listData(MaGnDivision::model()->findAll(),'GN_Division_ID','GN_Division'),array('empty'=>'-Please Select-'));  ?>
                <?php #echo $form->dropdownlist($model,'GN_Division_ID',array(),array('empty'=>'--- Please Select ---')); ?>
                <?php #echo $form->error($model,'GN_Division_ID'); ?>

</div>--></div>
       
            
            <div class="tblRow"><div class="tdOne">
                    <?php echo $form->labelEx($model, 'Location_Name'); ?>
                </div><div class="tdTwo">
                    <?php echo $form->textField($model, 'Location_Name', array('size' => 60, 'maxlength' => 200)); ?>
                    <?php echo $form->error($model, 'Location_Name'); ?>
                </div></div>
      
            <div class="tblRow"><div class="tdOne">
                    <?php echo $form->labelEx($model, 'Email'); ?>
                </div><div class="tdTwo">
                    <?php echo $form->textField($model, 'Email', array('size' => 60, 'maxlength' => 100)); ?>
                    <?php echo $form->error($model, 'Email'); ?>
                </div></div>


            
            <div class="tblRow"><div class="tdOne">
                    <?php echo $form->labelEx($model, 'Telephone'); ?>
                </div><div class="tdTwo">
                    <?php echo $form->textField($model, 'Telephone', array('class' => 'midText', 'maxlength' => 10)); ?>
                    <?php echo $form->error($model, 'Telephone'); ?>
                </div></div>
        
            
            <div class="tblRow"><div class="tdOne">
                    <?php echo $form->labelEx($model, 'Fax'); ?>
                </div><div class="tdTwo">
                    <?php echo $form->textField($model, 'Fax', array('class' => 'midText',  'maxlength' => 10)); ?>
                    <?php echo $form->error($model, 'Fax'); ?>
                </div></div>
        
            
            
        
            <div class="tblRow"><div class="tdOne">
                    <?php echo $form->labelEx($model, 'Address'); ?>
                </div><div class="tdTwo">
                    <?php echo $form->textArea($model, 'Address', array('rows' => 3, 'cols' => 56)); ?>
                    <?php #echo $form->textField($model,'Address',array('size'=>60,'maxlength'=>200)); ?>
                    <?php echo $form->error($model, 'Address'); ?>
                </div></div>
        
            

        <?php date_default_timezone_set('Asia/Colombo'); ?>
        
            <?php
            if ($model->isNewRecord) {
                echo $form->hiddenField($model, 'add_by', array('size' => 50, 'maxlength' => 50, 'value' => Yii::app()->getModule('user')->user()->username));
            } else {
                echo $form->hiddenField($model, 'add_by', array('size' => 50, 'maxlength' => 50));
            }
            ?>
       
            <?php
            if ($model->isNewRecord) {
                echo $form->hiddenField($model, 'add_date', array('value' => $curDateTime));
            } else {
                echo $form->hiddenField($model, 'add_date', array());
            }
            ?>
       
            <?php
            if ($model->isNewRecord) {
                echo $form->hiddenField($model, 'edit_by', array('size' => 50, 'maxlength' => 50, 'value' => 'Not Edited'));
            } else {
                echo $form->hiddenField($model, 'edit_by', array('size' => 50, 'maxlength' => 50, 'value' => Yii::app()->getModule('user')->user()->username));
            }
            ?>
     
            <?php
            if ($model->isNewRecord) {
                echo $form->hiddenField($model, 'edit_date', array('value' => 'Not Edited'));
            } else {
                echo $form->hiddenField($model, 'edit_date', array('value' => $curDateTime));
            }
            ?>
       

    <div class="row" style="padding-left:37%;font-weight:bold">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->