<style type="text/css">

    #fancybox-loading div {
        position: fixed;
        top: 0;
        left: 50%;
        width: 90px;
        height: 480px;
        background-image:'url(fancy/fancybox_loading@2x.gif)';
    }
    #Profile_firstname
    {
        margin-left: 4px;
    }
    #Profile_lastname
    {
        margin-left: 4px;
    }
    #Profile_birthday
    {
        margin-left: 4px;
    }
</style>
    
<script>
    $(document).ready(function()
    {
        $('#verifyPassword').focusout(function()
        {
            var password = $('#User_password').val();
            alert(password);
        });
    });
</script>
    
    <?php
$upId = Yii::app()->request->getQuery('id');
$district = Yii::app()->getModule('user')->user()->District_ID;
$superuser = Yii::app()->getModule('user')->user()->superuser;
$role = Yii::app()->getModule('user')->user()->Role_ID;
$loc = Yii::app()->getModule('user')->user()->Location_ID;



if($upId == '')
{
    $upId = 0;
}


if($superuser != '1')
{
    ?>
<style>
    
    #roleBtn, #locBtn
    {
        display: none;
    }
</style>

<?php
}


?>

<script>

    $('document').ready(function()
    {
        $('#User_District_ID').change(function()
        {
            var option ='<option value="0">--- Please Select ---</option>';
            $('#User_Location_ID').html(option);
            $('#User_Branch_Id').html(option);
        });
        
        
        $(".Role").fancybox 
        ({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('Role/UpdateRole') ?>',
                    success: function(data)
                    {
                        $('#User_Role_ID').append(data);
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
            width: 500,
           helpers:
           {
                overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
           }

        });
        
        $('.MaBranch').click(function()
        {
            var location = $('#User_Location_ID').val();
            
            if(location =='')
            {
                $("#branch_error").html("Please select a Location");
                setTimeout(function(){
                    $("#branch_error").html("");
                },4000);
                return false;
            }
            else
            {
               
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaBranch/AddNew') ?>',
                    data:{'location':location},
                    success: function(data)
                    {
                    },
                    error: function() {
                    },
                    dataType: 'html'
                });

            }
        });
        $(".MaBranch").fancybox 
        ({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaBranch/UpdateBranch') ?>',
                    success: function(data)
                    {
                        $('#User_Branch_Id').append(data);
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
            width: 500,
           helpers:
           {
                overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
           }

        });
        
        $(".MaDesignation").fancybox 
        ({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaDesignation/UpdateDesignation') ?>',
                    success: function(data)
                    {
                        $('#User_Designation_ID').append(data);
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
            width: 500,
           helpers:
           {
                overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
           }

        });
        
        $('.MaLocation').click(function()
        {
            var district = $('#User_District_ID').val();
            
            if(district =='')
            {
                $("#location_error").html("Please select a District");
                setTimeout(function(){
                    $("#location_error").html("");
                },4000);
                return false;
            }
            else
            {
               
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaLocation/AddNew') ?>',
                    data:{'district':district},
                    success: function(data)
                    {
                    },
                    error: function() {
                    },
                    dataType: 'html'
                });

            }
        });
        
        
        $(".MaLocation").fancybox 
        ({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaLocation/UpdateLocation') ?>',
                    success: function(data)
                    {
                        $('#User_Location_ID').append(data);
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
           helpers:
           {
                overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
           }

        });
        
    });

</script>

<?php


if(isset($model->scenario)&&($model->scenario === 'update')):  ?>
    
<script>
    $(document).ready(function()
    {
        var pw = $('#User_password').val();
        if($('#User_verifyPassword').attr('class') !== 'error')
        {
            $('#User_verifyPassword').val(pw);
        }
    });
</script>
  <?php  
endif;
?>


<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>

<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

<?php //echo CHtml::errorSummary(array($model,$profile)); ?>

<div class="formTable">
    

    <div class="tblrow">
        <div class="tdOne"><?php echo CHtml::activeLabelEx($model,'username'); ?></div>
        <div class="tdTwo"><?php echo CHtml::activeTextField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
            <?php echo CHtml::error($model,'username'); ?></div>
    </div>

    
    <div class="tblrow">
        <div class="tdOne"><?php echo CHtml::activeLabelEx($model,'password'); ?></div>
        <div class="tdTwo"><?php echo CHtml::activePasswordField($model,'password',array('size'=>47,'maxlength'=>128)); ?>
            <?php echo CHtml::error($model,'password'); ?></div>
    </div>
    
    <div class="tblrow">
        <div class="tdOne"><?php echo CHtml::activeLabelEx($model,'verifyPassword'); ?></div>
        <div class="tdTwo"><?php echo CHtml::activePasswordField($model,'verifyPassword',array('size'=>47,'maxlength'=>128)); ?>
            <?php //echo CHtml::error('','verifyPassword'); ?></div>
    </div>

    
    <div class="tblrow">
        <div class="tdOne"><?php echo CHtml::activeLabelEx($model,'email'); ?></div>
        <div class="tdTwo"><?php echo CHtml::activeTextField($model,'email',array('size'=>47,'maxlength'=>128)); ?>
            <?php echo CHtml::error($model,'email'); ?></div>
    </div>

    
    <div class="tblrow">
        <div class="tdOne"><?php  echo CHtml::activeLabelEx($model,'Role_ID'); ?></div>
        <div class="tdTwo"><?php echo CHtml::activeDropDownList($model, 'Role_ID', CHtml::listData( Role::model()->findRole(), 'Role_ID', 'Role'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect'));   ?>
            <a class="Role addBtn" id="roleBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('role/AddNew') ?>">
                <img src="images/1Screenshot-32.png" title="Add New Role" />
            </a>
            <?php echo CHtml::error($model,'Role_ID'); ?>
        </div>
    </div>

    
    <div class="tblrow">
        <div class="tdOne"><?php  echo CHtml::activeLabelEx($model,'Designation_ID'); ?></div>
        <div class="tdTwo"><?php echo CHtml::activeDropDownList($model, 'Designation_ID', CHtml::listData(
                    MaDesignation::model()->findDesignation(), 'Designation_ID', 'Designation'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect'));   ?>
                <a class="MaDesignation addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maDesignation/AddNew') ?>">
                    <img src="images/1Screenshot-32.png" title="Add New Designation" />
                </a>
            <?php echo CHtml::error($model,'Designation_ID'); ?></div>
    </div>

    
    <div class="tblrow">
        <div class="tdOne"><?php  echo CHtml::activeLabelEx($model,'District_ID'); ?></div>
        <div class="tdTwo">   <?php
            $Division = CHtml::listData(MaDistrict::model()->findAllDistricts(), 'District_ID', 'District_Name');

            if($role == '1' && $superuser =='0')
            {
                echo CHtml::activeDropDownList($model, 'District_ID', $Division, array('ajax' =>
                        array(
                            'type' => 'POST', //request type
                            'url' => Yii::app()->request->baseUrl."/index.php?r=MaDsDivision/DynamicLocations",
                            'update' => '#' . CHtml::activeId($model, 'Location_ID'),
                            // 'data'=>'js:jQuery(this).serialize()'
                        ),
                        'class' => 'midSelect')
                );
                //echo CHtml::activeDropDownList($model, 'District_ID', array(""));
            }
            else
            {
                echo CHtml::activeDropDownList($model, 'District_ID', $Division, array('ajax' =>
                        array(
                            'type' => 'POST', //request type
                            'url' => Yii::app()->request->baseUrl."/index.php?r=MaDsDivision/DynamicLocations",
                            'update' => '#' . CHtml::activeId($model, 'Location_ID'),
                            // 'data'=>'js:jQuery(this).serialize()'
                        ),
                        'prompt' => '--- Please Select ---', 'class' => 'midSelect')
                );
            }





            ?>
            <?php echo CHtml::error($model,'District_ID'); ?>
        </div>
    </div>

    
    <div class="tblrow">
        <div class="tdOne"><?php  echo CHtml::activeLabelEx($model,'Location_ID'); ?></div>

        <div class="tdTwo"><?php
            if($upId === 0)
            {
                if($role == '1' && $superuser =='0')
                {
                    echo CHtml::activeDropDownList($model, 'Location_ID', Chtml::listdata(MaLocation::model()->findLocations($district),"Location_ID", "Location_Name"), array('ajax' =>
                            array(
                                'type' => 'POST', //request type
                                'url' => Yii::app()->request->baseUrl."/index.php?r=MaBranch/DynamicBranches",
                                'update' => '#' . CHtml::activeId($model, 'Branch_Id'),
                                // 'data'=>'js:jQuery(this).serialize()'
                            ),
                            'class' => 'midSelect')
                    );
                }
                else
                {
                    $arry = array();
                    if(isset($model->District_ID) && $model->District_ID !='')
                    {
                        $arry = Chtml::listdata(MaLocation::model()->findLocations($model->District_ID),"Location_ID", "Location_Name");
                    }

                    echo CHtml::activeDropDownList($model, 'Location_ID', $arry, array('ajax' =>
                            array(
                                'type' => 'POST', //request type
                                'url' => Yii::app()->request->baseUrl."/index.php?r=MaBranch/DynamicBranches",
                                'update' => '#' . CHtml::activeId($model, 'Branch_Id'),
                                // 'data'=>'js:jQuery(this).serialize()'
                            ),
                            'prompt' => '--- Please Select ---', 'class' => 'midSelect')
                    );
                }
            }
            else
            {
                $arry = array();
                if(isset($model->District_ID) && $model->District_ID !='')
                {
                    $arry = Chtml::listdata(MaLocation::model()->findLocations($model->District_ID),"Location_ID", "Location_Name");
                }

                echo CHtml::activeDropDownList($model, 'Location_ID', $arry, array('ajax' =>
                        array(
                            'type' => 'POST', //request type
                            'url' => Yii::app()->request->baseUrl."/index.php?r=MaBranch/DynamicBranches",
                            'update' => '#' . CHtml::activeId($model, 'Branch_Id'),
                            // 'data'=>'js:jQuery(this).serialize()'
                        ),
                        'prompt' => '--- Please Select ---', 'class' => 'midSelect')
                );

            }
            ?>
            <a class="MaLocation addBtn" id="locBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maLocation/AddNew') ?>">
                    <img src="images/1Screenshot-32.png" title="Add New Location" />
                </a>
            <div id="location_error" style="color:#FF0000"></div>
            <?php echo CHtml::error($model,'Location_ID'); ?>
        </div>
    </div>

    
    <div class="tblrow">
        <div class="tdOne"><?php  echo CHtml::activeLabelEx($model,'Branch_Id'); ?></div>
        <div class="tdTwo">
           <?php
                if($upId == 0)
                {
                    if($role == '1' && $superuser =='0')
                    {
                        echo CHtml::activeDropDownList($model, 'Branch_Id', CHtml::listData(
                            MaBranch::model()->findBranches($loc), 'Branch_Id', 'Branch'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect'));

                    }
                    else
                    {
                        $arryBrnch = array();
                        if(isset($model->Location_ID) && $model->Location_ID !=='')
                        {
                            $arryBrnch = CHtml::listData(
                                MaBranch::model()->findBranches($model->Location_ID), 'Branch_Id', 'Branch');
                        }

                        echo CHtml::activeDropDownList($model, 'Branch_Id', $arryBrnch,array('prompt' => '--- Please Select ---', 'class'=>'midSelect'));
                    }
                }
                else
                {
                    $arryBrnch = array();

                    if(isset($model->Location_ID) && $model->Location_ID !=='')
                    {
                        $arryBrnch = CHtml::listData(
                            MaBranch::model()->findBranches($model->Location_ID), 'Branch_Id', 'Branch');
                    }

                    echo CHtml::activeDropDownList($model, 'Branch_Id', $arryBrnch,array('prompt' => '--- Please Select ---', 'class'=>'midSelect'));


                }
                ?>
                <a class="MaBranch addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maBranch/AddNew') ?>">
                    <img src="images/1Screenshot-32.png" title="Add New Branch" />
                </a>
            <div id="branch_error" style="color:#FF0000"></div>
            <?php echo CHtml::error($model,'Branch_Id'); ?></div>
    </div>

    
    <div class="tblrow" style="display:none">
        <div class="tdOne"><?php echo CHtml::activeLabelEx($model,'superuser'); ?></div>
        <div class="tdTwo"> <?php echo CHtml::activeDropDownList($model,'superuser',User::itemAlias('AdminStatus'), array('class'=>'midSelect')); ?>
            <?php echo CHtml::error($model,'superuser'); ?></div>
    </div>

    
    <div class="tblrow">
        <div class="tdOne"><?php echo CHtml::activeLabelEx($model,'status'); ?></div>
        <div class="tdTwo"><?php echo CHtml::activeDropDownList($model,'status',User::itemAlias('UserStatus'), array('class'=>'midSelect')); ?>
            <?php echo CHtml::error($model,'status'); ?></div>
    </div>

    
    <div class="tblrow">
        <div class="tdOne"><?php echo CHtml::activeLabelEx($model,'Phone_Number'); ?></div>
        <div class="tdTwo"><?php echo CHtml::activeTextField($model,'Phone_Number',array('class'=>'midText','maxlength'=>10)); ?>
            <?php echo CHtml::error($model,'Phone_Number'); ?></div>
    </div>

    

<?php
$profileFields=$profile->getFields();
if ($profileFields) 
{
    foreach($profileFields as $field) 
    {
        ?>
      
    
            <div class="tblrow"><div class="tdOne">
                    <?php echo CHtml::activeLabelEx($profile,$field->varname); ?>
                </div><div class="tdTwo">
                    <?php
                    if ($field->widgetEdit($profile)) {
                        echo $field->widgetEdit($profile);
                    } elseif ($field->range) {
                        echo CHtml::activeDropDownList($profile,$field->varname,Profile::range($field->range));
                    } elseif ($field->field_type=="TEXT") {
                        echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
                    } else {
                        echo CHtml::activeTextField($profile,$field->varname,array('class'=>'midText','maxlength'=>(($field->field_size)?$field->field_size:255)));
                    }
                    ?>
                    <?php echo CHtml::error($profile,$field->varname); ?>
                </div></div> 
            
    <?php
    }
}
?>
            
<div class="row" style="padding-left:37%;font-weight:bold">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</div>


<?php echo CHtml::endForm(); ?>

</div><!-- form -->