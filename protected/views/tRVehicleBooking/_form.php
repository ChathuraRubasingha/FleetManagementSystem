
<?php //


$id = Yii::app()->request->getQuery('id');

if($id =='')
{
    $id ='0';
}

?>
<style>

.ui-widget
{
    font-size: 13px;
}

.noImagePara
{
    color:#F00; 
    font-size:16px; 
    padding-top:60px;
}
.selected
{
    width:150px; 
    height:150px; 
    float:left; 
    border:5px solid #0F0;
    margin-top:10px;
}
.default 
{
    border-color: #666 !important;
}
.clsVehicle
{
    float: left;
    border: 5px solid #CCC;
    padding: 5px;
    margin: 5px;
    cursor: pointer;
}
.clsDriver
{
    float: left;
    border: 5px solid #CCC;
    padding: 5px;
    margin: 5px;
    cursor: pointer;
}
#selectedVehicle1
{
    border: 5px solid #0f0;
    float: left;
    height: 118px;
    margin-left: -10px;
    margin-top: 5px;
    width: 118px;
}
#selectedDriver1
{
    border: 5px solid #0f0;
    float: left;
    height: 118px;
    margin-left: -10px;
    margin-top: 5px;
    width: 118px;
}

.noImagePara1 
{
    color: #f00;
    font-size: 16px;
    padding-top: 25px;
}
.displayNames
{
   font-weight: bold;
   text-align: center;

}
.removeSelected
{
    position: relative; 
    margin-bottom: -35px; 
    z-index: 997; 
    left: -20px; 
    top: -7px;
    cursor: pointer;
}

</style>
<?php 
    $curDate =  MaVehicleRegistry::model()->getServerDate("date");
	date_default_timezone_set("Asia/Colombo");
?>
<script>


$(document).ready(function () 
{	
    var curDate ='<?php echo MaVehicleRegistry::model()->getServerDate('dateTime'); ?>';
    var dateToday = new Date();
    var dates = $("#from_date, #to_date").datetimepicker({
        // defaultDate: "+1w",
        changeMonth: true,
        dateFormat:'yy-mm-dd',
        //  numberOfMonths: 3,
        minDate: curDate,
       // minTime: curTime,


        /* onSelect: function(selectedDate) {
            var option = this.id == "from_date" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }*/
        });
        
        
        //////////
        
    var selectedVehicle = $('#TRVehicleBooking_Vehicle_No').val();
    var selectedDriver = $('#TRVehicleBooking_Driver_ID').val();
    var vCat = $('#TRVehicleBooking_Vehicle_Category_ID').val();

    if(vCat !== '')
    {
        $('#TRVehicleBooking_Vehicle_Category_ID').val(vCat).trigger('change');
        setTimeout(function()
        {
            if(selectedVehicle !== '')
            {
                var selectedVId = selectedVehicle.replace(/ /g, '');
                $('#vGallery #'+selectedVId).trigger('click');    
            }
            else
            {
                if(selectedDriver !== '')
                {
                    $('#vGallery .clsVehicle').each(function()
                    {
                        $(this).trigger('click');
                        $(this).removeClass('default');
                        $('#selectedVehicle1').html('<center><p class="noImagePara1 noVImg">No Vehicle <br/>Selected</p></center><img id="selectedVehicleImg" src="" style="display:none; width:108px; max-height: 108px; height: 108px" />');

                    });    
                }
            }

        },300);
    }
      
    $('#vContainer #removeVehicle').click(function()
    {
        $('#selectedVehicle1').html('<center><p class="noImagePara1 noVImg">No Vehicle <br/>Selected</p></center><img id="selectedVehicleImg" src="" style="display:none; width:108px; max-height: 108px; height: 108px" />');
        $('#TRVehicleBooking_Vehicle_No').val('');
        $('.clsVehicle').each(function()
        {
            $(this).removeClass('default');
        });
    });

    $('#dContainer #removeDriver').click(function()
    {
        $('#selectedDriver1').html('<center><p class="noImagePara1 noDImg">No Driver <br/>Selected</p></center><img id="selectedDriverImg" src="" style="display:none; width:108px; max-height: 108px; height: 108px" />');
        $('#TRVehicleBooking_Driver_ID').val('');
        $('.clsDriver').each(function()
        {
            $(this).removeClass('default');
        });
    });
});

$('.ui-datepicker-close').live("click",function()
 {
     $('#ui-datepicker-div').hide();
 });

  $('#from_date, #to_date').live("focus",function()
 {
    $('#ui-datepicker-div').toggle();
 });
 
    
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    //alert(charCode);
    if (charCode != 46 && charCode !=45 && charCode > 31 && (charCode < 48 || charCode > 57 ))
    {
        return false;
    }

    return true;
}
    
    
    ///
    
function getVehicles()
{
    var vCat = $('#TRVehicleBooking_Vehicle_Category_ID').val();
    var from = $('#from_date').val();
    var to = $('#to_date').val();
    $('#TRVehicleBooking_Vehicle_No').val('');
    $('#selectedVehicle1').html('<center><p class="noImagePara1 noVImg">No Vehicle <br/>Selected</p></center><img id="selectedVehicleImg" src="" style="display:none; width:108px; max-height: 108px; height: 108px" />');
   
    var selectedVehicle = $('#TRVehicleBooking_Vehicle_No').val();
    if(vCat !== "")
    {
        
        $.ajax(
        {
            type : 'POST', 
            url  : '<?php echo Yii::app()->createAbsoluteUrl('TRVehicleBooking/GetVehiclesForBooking') ?>',
            data : {'vCat':vCat, 'from':from, 'to':to, 'selectedVehicle':selectedVehicle },
            success: function(data)
            {
                if(typeof(data.error) != "undefined")
                {
                    var height = $("body").height() ;
                    $(".ontop").height(height);
                    $("#errorConfirm").fadeIn(500);
                    $('#errorConfirm p').html(data.error);
                    $("#popDiv").fadeIn(500);

                    $("#TRVehicleBooking_Vehicle_Category_ID option[value=\'\']").prop("selected","selected");
                }
                if(typeof(data.vehicles) !== "undefined")
                {
                    //alert(data.vehicles);
                    $('#vContainer').show();
                    $('#selectedVehicle1').show();
                    $("#vGallery").html(data.vehicles);
                    $("#vGallery").show();
                    //$("#TRVehicleBooking_Vehicle_Category_ID option[value=\'\']").prop("selected","selected");
                }
                if(typeof(data.vCat) !== "undefined")
                {
                    //alert(data.vehicles);
                    $('#vContainer').hide();
                    $('#selectedVehicle1').hide();
                    $("#vGallery").html("");
                    $("#vGallery").hide();
                    //$("#TRVehicleBooking_Vehicle_Category_ID option[value=\'\']").prop("selected","selected");
                }

            },
            dataType : 'json'

        });
    }
    else
    {
        $('#vContainer').hide();
        $('#dContainer').hide();
        $('#selectedVehicle1').hide();
        $('#selectedDriver1').html('<center><p class="noImagePara1 noDImg">No Driver <br/>Selected</p></center><img id="selectedDriverImg" src="" style="display:none; width:108px; max-height: 108px; height: 108px" />');
        $('#TRVehicleBooking_Driver_ID').val("");
        $("#vGallery").html("");
        $("#vGallery").hide();
    }

}

function getDrivers(vID, vImg)
{
    var height = $("body").height();
    var wdt = $("body").width();
    
    var from = $('#from_date').val();
    var to = $('#to_date').val();
    var selectedDriver = $('#TRVehicleBooking_Driver_ID').val();
    var id =  vID.replace(/ /g,'');
    var booked = false;

    if($('#'+id).hasClass('booked'))
    {
        booked = true;
        $(".ontop").height(height);
        $("#errorConfirm").fadeIn(500);
        $('#errorConfirm p').html('This vehicle is already booked for this time period');
        $("#popDiv").fadeIn(500);
    }
    else
    {
         booked = false;
    }


    if(!booked)
    {            
        $('.clsVehicle').each(function()
        {            
            $(this).removeClass('default');
        });

        $('#'+id).addClass('clsVehicle default');

        $.ajax
        ({
            type:'POST',
            url:'<?php echo Yii::app()->createAbsoluteUrl("TRVehicleBooking/GetDrivers") ?>',
            data:{"vID":vID, "from":from, "to":to, 'selectedDriver':selectedDriver},
            success:function(data)
            {
                $('#dContainer').show();
                $('#selectedDriver1').show();
                $('#dGallery').html(data.drivers);

                setTimeout(function()
                {
                    $('#dGallery #d_'+selectedDriver).trigger('click');      
                },300);

            },
            error:function(data)
            {

            },
            dataType:'json'
        });
        $('#selectedVehicleImg').attr('src',"VechicleReg/"+vImg);
        $('#TRVehicleBooking_Vehicle_No').val(vID);
        $('.noVImg').remove();
        $('#selectedVehicleImg').show();
    }
}

function setDriver(dID, dImg)
{
    var booked = false;
    var height = $("body").height();
    
    if($('#d_'+dID).hasClass('booked'))
    {
        booked = true;
        $(".ontop").height(height);
        $("#errorConfirm").fadeIn(500);
        $('#errorConfirm p').html('This Driver is already booked for this time period');
        $("#popDiv").fadeIn(500);
    }
    else
    {
         booked = false;
    }
    if(!booked)
    {            
        $('.clsDriver').each(function()
        {
            $(this).removeClass('default');
        });
        $('#d_'+dID).addClass('clsDriver default');

        $('#TRVehicleBooking_Driver_ID').val(dID);
        $('#selectedDriverImg').attr('src',"DriverImages/"+dImg);

        $('.noDImg').remove();
        $('#selectedDriverImg').show();
    }
}
    
</script>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'trvehicle-booking-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <?php
        $currentUsrLoc = (Yii::app()->getModule('user')->user()->Location_ID);

        $rowData = Yii::app()->db->createCommand('select Location_Name from ma_location where Location_ID =' . $currentUsrLoc)->queryAll();
        $locName = $rowData[0]['Location_Name'];


        if(isset($model->Place_from))
        {
            $locName = $model->Place_from;
        }

        $curDate = MaVehicleRegistry::model()->getServerDate("date");
        $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");
 
    ?>
    
        
   
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>


    <div class="formTable">
 
    <?php $user = Yii::app()->getModule('user')->user()->id; ?>
 
 
        <?php echo $form->hiddenField($model, 'User_ID', array('value' => $user, 'readonly' => true)); ?>

    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model, 'From'); ?></div>
        <div class="tdTwo">
            <?php $this->widget('application.extensions.timepicker.timepicker', 
                    array(
                        'model' => $model, 
                        'name' => 'From', 
                        'id' => 'from_date'
                        )); 
            ?>
            <?php echo $form->error($model, 'From'); ?>
        </div>
    </div>

    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model, 'To'); ?></div>
        <div class="tdTwo">
            <?php $this->widget('application.extensions.timepicker.timepicker', array('model' => $model, 'name' => 'To', 'id' => 'to_date')); ?> 
            <?php echo $form->error($model, 'To'); ?>
        </div>
    </div>

    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model, 'Vehicle_Category_ID'); ?></div>
        <div class="tdTwo">
    <?php 
        echo $form->dropdownlist($model, 'Vehicle_Category_ID', CHtml::listData(VehicleCategory::model()->findCategoriesForBooking(), 'Vehicle_Category_ID', 'Category_Name'), 
            array(/*'ajax' =>
                array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('TRVehicleBooking/GetVehiclesForBooking'), 
                    'data' => array(
                        'vCat' => "js: $(this).find('option:selected').val()",
                        'from' => "js: $('#from_date').val()", 
                        'to' => "js: $('#to_date').val()", 
                    ),
                    'success' => 'js:function(data)
                    {
                        if(typeof(data.error) != "undefined")
                        {
                            alert(data.error);
                            $("#TRVehicleBooking_Vehicle_Category_ID option[value=\'\']").prop("selected","selected");
                        }
                        if(typeof(data.vehicles) != "undefined")
                        {
                            //alert(data.vehicles);
                            $("#vGallery").html(data.vehicles);
                            $("#vGallery").show();
                            //$("#TRVehicleBooking_Vehicle_Category_ID option[value=\'\']").prop("selected","selected");
                        }

                    }',
                    'dataType' =>'json',
                    ),*/
                'onchange'=>'getVehicles()',
                    'class' => 'midSelect',
                    'empty'=>' Please Select'
                )
            );

    ?>
            
            <?php //echo $form->dropdownlist($model, 'Vehicle_Category_ID', CHtml::listData(VehicleCategory::model()->findCategoriesForBooking(), 'Vehicle_Category_ID', 'Category_Name'), array('empty' => '--- Please Select ---', 'class' => 'midSelect', 'onchange' => 'get_vehicles()')); ?>
            <?php echo $form->error($model, 'Vehicle_Category_ID'); ?>
        </div>
    </div>

</div>


    
    <div id="vContainer" style="float:left; width:90%; min-height: 125px; height: auto; margin-left:5%; display: none">
        <img id="removeVehicle" class="removeSelected" title="Remove Selected Vehicle" src="images/remove.png" width="25px" height="25px" />
        <div id="selectedVehicle1" class="selected" style="display: none">
            <center><p class="noImagePara1 noVImg">No Vehicle <br/>Selected</p></center>

            <img id="selectedVehicleImg" src="" style="display:none; width:108px; max-height: 108px; height: 108px" />

        </div>

        <div id="vGallery" style="height:auto; background-color: #FF0000;">
        </div>            
    </div>
    
   
    
    <div id="dContainer" style="float:left; width:90%; min-height: 125px; height: auto; margin-left:5%; display: none">
        <img id="removeDriver" class="removeSelected" title="Remove Selected Driver" src="images/remove.png" width="25px" height="25px" />    
        <div id="selectedDriver1" class="selected" style="display: none">
            <center><p class="noImagePara1 noDImg">No Driver <br/>Selected</p></center>
            <img id="selectedDriverImg" src="" style="display:none; width:108px; max-height: 108px; height: 108px" />
        </div>
        
        <div id="dGallery" style="height:auto; background-color: #FF0000;">                
        </div>
    </div>
 
    <?php echo $form->hiddenField($model, 'Vehicle_No', array('readonly' => 'readonly')); ?>
    <?php echo $form->hiddenField($model, 'Driver_ID', array()); ?>

    <?php

        $driverName ='';
        $dId='';
        $dId =$model->Driver_ID;

        if($dId !='')
        {
            $arr = Yii::app()->db->createCommand('select Full_Name from ma_driver where Driver_ID ='.$dId)->queryAll();

            if(count($arr)>0)
            {
                $driverName=$arr[0]['Full_Name'];
            }

        }
        if(isset(Yii::app()->session['driverName']) && Yii::app()->session['driverName'] !='')
        {
            $driverName =Yii::app()->session['driverName'];
        }

    ?>

<?php echo CHtml::hiddenField('driver_name', $driverName); ?>

   <div class="formTable" >

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model, 'Place_from'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model, 'Place_from', array('value' => $locName, 'size' => 60)); ?>
                <?php echo $form->error($model, 'Place_from'); ?></div>
        </div>
       <?php 
       $branch = 'Not Set';
        $user_branch = Yii::app()->getModule('user')->user()->Branch_Id==null?"":Yii::app()->getModule('user')->user()->branch->Branch;
        if($user_branch!='' && $user_branch!=null)
        {
            $branch = $user_branch;
        }
       ?>
       <div class="tblRow">
           <div class="tdOne">Branch</div>
            <div class="tdTwo"><?php echo CHtml::textField('Branch', $branch,array("disabled"=>'disabled')); ?></div>
        </div>
    
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model, 'Place_to'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model, 'Place_to', array('size' => 60)); ?>
                <?php echo $form->error($model, 'Place_to'); ?></div>
        </div>
        

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model, 'Average_km'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model, 'Average_km', array("onkeypress"=>"return isNumberKey(event)","class"=>"midText")); ?>
                <?php echo $form->error($model, 'Average_km'); ?></div>
        </div>
   

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model, 'No_of_Passengers'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model, 'No_of_Passengers', array("onkeypress"=>"return isNumberKey(event)","class"=>"midText")); ?>
                <?php echo $form->error($model, 'No_of_Passengers'); ?></div>
        </div>
   
    <?php echo $form->hiddenField($model, 'Booking_Status', array('size' => 60, 'maxlength' => 100)); ?>
        

   
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model, 'Description'); ?></div>
            <div class="tdTwo"><?php echo $form->textArea($model, 'Description', array('rows' => 6, 'cols' => 56)); ?>
                <?php echo $form->error($model, 'Description'); ?></div>
        </div>
   
    <?php date_default_timezone_set('Asia/Colombo'); ?>
    <?php $date = $curDate ?>
    
        <?php echo $form->hiddenField($model, 'Requested_Date', array('value' => $curDateTime)); ?>
     
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
    </div>
