<style type="text/css">

/*   #fancybox-loading div {
        position: fixed;
        top: 0;
        left: 50%;
        width: 90px;
        height: 480px;
        background-image:'url(fancy/fancybox_loading@2x.gif)';
    }*/
</style>
    
    <?php 
 
$id = Yii::app()->request->getQuery('id');
if($id =='')
{
    $id='0';
}
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

$vehicleNo = '';
if($model->Vehicle_No != '')
{
    $vehicleNo = $model->Vehicle_No;
}

?>
<script type="text/javascript">

var calcEvtName = 'recalculate';

$(document).ready(function()
{    
    var vehicleNo = '<?php echo $vehicleNo; ?>';
    
    if(vehicleNo !== '')
    {
        // AS-DF-1234
        // 12-3456
        
        var underScorePos1 = vehicleNo.indexOf('-');
        var nums = vehicleNo.split("-");
        var numCount = nums.length;
        
        if(numCount === 3)
        {
            var prov = nums[0];
            $("#province_code option[value='"+prov+"']").prop("selected","selected");
        }
        
        var s_block = nums[numCount-1];
        var f_block = nums[numCount-2];
        
        $("#MaVehicleRegistry_SechondBlock").val(s_block);
        $("#MaVehicleRegistry_FirstBlock").val(f_block);
        
    }

    $('.vNumber').change(function()
    {
        var prov = $("#province_code").val();
        var f_block = $("#MaVehicleRegistry_FirstBlock").val();
        var s_block = $("#MaVehicleRegistry_SechondBlock").val();
        
        if(prov !== '')
        {
            prov =   prov + "-";
        }
        /*if(f_block !== '')
        {
            f_block =  "-" + f_block ;
        }*/
        if(s_block !== '')
        {
            s_block = "-" + s_block;
        }
        
        var vehicleNumber = prov + f_block + s_block;
        $('#MaVehicleRegistry_Vehicle_No').val(vehicleNumber);
        
        
    });
   $('#MaVehicleRegistry_Purchase_Date').Zebra_DatePicker();


    $("#MaVehicleRegistry_Purchase_Value").keyup(function(){
            var cost = $("#MaVehicleRegistry_Purchase_Value").val();
            var sepVal = thousandSepVal(cost);
            $("#MaVehicleRegistry_Purchase_Value").val(sepVal);
    });
    
     $("#MaVehicleRegistry_Registration_Fee").keyup(function(){
            var cost = $("#MaVehicleRegistry_Registration_Fee").val();
            var sepVal = thousandSepVal(cost);
            $("#MaVehicleRegistry_Registration_Fee").val(sepVal);
    });

    $('#MaVehicleRegistry_Vehicle_No').focusout(function()
    {
        var val = $('#MaVehicleRegistry_Vehicle_No').val();
        var cap = val.toUpperCase();
        $('#MaVehicleRegistry_Vehicle_No').val(cap);
    });

    $('.MaModel').click(function()
    {
        var make = $('#MaVehicleRegistry_Make_ID').val();
        if(make =='')
        {
            $("#model_Error").html("Please select a Make");
            setTimeout(function(){
                $("#model_Error").html("");
            },4000);
            return false;
        }
        else
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaModel/AddNew') ?>',
                data:{'make':make},
                success: function(data)
                {
                },
                error: function() {
                },
                dataType: 'html'
            });

        }
    });



    $(".VehicleCategory").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('VehicleCategory/UpdateVehicleCategory') ?>',
                success: function(data)
                {
                    $('#MaVehicleRegistry_Vehicle_Category_ID').append(data);
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

        $(".MaMake").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaMake/UpdateMake') ?>',
                success: function(data)
                {
                    var option = '<option value="" selected>--- Please Select ---</option>';

                    $('#MaVehicleRegistry_Make_ID').append(data);
                    $('#MaVehicleRegistry_Model_ID').html(option);
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

    $(".MaModel").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaModel/UpdateModel') ?>',
                success: function(data)
                {
                    $('#MaVehicleRegistry_Model_ID').append(data);
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

    $(".MaFuelType").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('FuelType/UpdateFuelType') ?>',
                success: function(data)
                {
                    $('#MaVehicleRegistry_Fuel_Type_ID').append(data);
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
        helpers:{
            overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
        }

    });

    $(".MaTyreSize").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaTyreSize/UpdateTyreSize') ?>',
                success: function(data)
                {
                    $('#MaVehicleRegistry_Tyre_Size_ID').append(data);
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
        helpers:{
            overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
        }

    });

    $(".MaTyreType").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaTyreType/UpdateTyreType') ?>',
                success: function(data)
                {
                    $('#MaVehicleRegistry_Tyre_Type_ID').append(data);
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
        helpers:{
            overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
        }

    });

    $(".MaBatteryType").fancybox({
        afterClose: function()
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('MaBatteryType/UpdateBatteryType') ?>',
                success: function(data)
                {
                    $('#MaVehicleRegistry_Battery_Type_ID').append(data);
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
        helpers:{
            overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
        }

    });

});

    function thousandSep(numberOrStringVal, precision, elem)
    {
        var numberOrString = numberOrStringVal.replace(/,/g,'');
        //alert(elem.id);
        var zero = 0;
        var num = parseFloat(numberOrString);
        if (!isNaN(num) && (num != Number.NaN))
        {
            if (precision)
            {
                num = num.toFixed(precision);
            }

            var val =  thousandSepVal(num);
           
            var setter = createValueSetter(elem);
             alert(setter);
            return val;
        }

       /* try
        {
            
        }
        catch (ignored)
        {
        }
        if (precision)
        {
            zero = zero.toFixed(precision);
        }
        return zero;*/
    }
    
    function createValueSetter(jqelm)
    {
        
       var recalc = function() {
            jqelm.trigger("recalculate");
        };
        var t = $(jqelm)[0];
        //return getRawValue(jqelm);
        return jqelm.get(0).innerHTML;
         //if (jqelm.get(0).innerHTML)
       /*  if(t)
        {
            return function(val) {
                jqelm.html(val);
                recalc();
            };
        }
        return function(val) 
        {
            jqelm.val(val);
            recalc();
        };*/
    }

    function getRawValue(jqelm)
    {
        if (jqelm.get(0).tagName.match(/input|select|textarea/i))
        {
            var x = jqelm.val();

            x = x.replace(/\,/g, '');// Modificated by Kavinda for Remove Thousand Seperator
            //alert(x);
            return x;
        }

        return jqelm.html();
    }
    
    function recalculate(evt)
    {
        var jqthis = $(this);
        alert(jqthis);
        var calcFcns = jqthis.calculation();
        if (calcFcns && calcFcns.length && (calcFcns.length > 0))
        {
            for (var ii = 0; ii < calcFcns.length; ++ii)
            {
                calcFcns[ii].apply(jqthis);
            }
        }
    }

    function thousandSepVal(val) 
    {        
	//var test = val.replace(/,/g,'');
	//return String(test).split("").reverse().join("").replace(/(\d{3}\B)/g, "$1,").split("").reverse().join("");
        
        var test = val.replace(/,/g, '');
        return String(test).split("").reverse().join("").replace(/(\d{3}\B)/g, "$1,").split("").reverse().join("");
        
    }
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

</script>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-vehicle-registry-form',
	'enableAjaxValidation'=>true,
	'focus'=>array($model,'Vehicle_No'), 
	'htmlOptions' => array('enctype' => 'multipart/form-data',),
));


$var = array();
?>




<div class="panel panel-default">
    <div class="panel-heading large">
        <h2 id="rest-title" class="panel-title" itemprop="name">GENERAL DETAILS</h2>
    </div>

    <div class="panel-body">
        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>
        <div class="formTable" >
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Vehicle_No'); ?></div>
                    <div class="tdTwo"><?php echo CHtml::dropDownList('province_code', '', array(""=>"","WP"=>"WP", "CP"=>"CP", "NW"=>"NW", "NC"=>"NC", "SP"=>"SP", "NP"=>"NP", "UP"=>"UP", "SG"=>"SG", "EP"=>"EP"), array('style'=>'width:60px', 'class'=>'vNumber')) ?>
                        &nbsp;&nbsp;<?php echo $form->textField($model,'FirstBlock', array('maxLength'=>'3','style'=>'width:50px', 'class'=>'vNumber')) ?>
                        &nbsp;&nbsp;<?php echo $form->textField($model,'SechondBlock', array('maxLength'=>'4','style'=>'width:50px', 'class'=>'vNumber')) ?>
                        &nbsp;&nbsp;<?php echo CHtml::label('Ex:- WP GD 2595 or 23 3421','Vehicle_No', array('style'=>'color:#ccc')); ?>
                        <?php echo $form->hiddenField($model,'Vehicle_No',array('class'=>'midText', 'size'=>20,'maxlength'=>20)); ?>
                            <?php echo $form->error($model,'FirstBlock'); ?>
                            <?php echo $form->error($model,'SechondBlock'); ?>
                            <?php echo $form->error($model,'Vehicle_No'); ?></div>
                </div>
                
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Registration_Fee'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Registration_Fee',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
                        <?php echo $form->error($model,'Registration_Fee'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Make_Year'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Make_Year',array('class'=>'midText', 'size'=>20,'maxlength'=>4,'autocomplete'=>'off' , "onkeypress"=>"return isNumberKey(event)")); ?>
                        <?php echo $form->error($model,'Make_Year'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Purchase_Date'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Purchase_Date',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                    <?php echo $form->error($model,'Purchase_Date'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php  echo $form->labelEx($model,'Allocation_Type_ID'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Allocation_Type_ID',CHtml::listData(MaAllocationType::model()->findAllocation(),'Allocation_Type_ID','Allocation_Type'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                        <?php echo $form->error($model,'Allocation_Type_ID'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php  echo $form->labelEx($model,'Vehicle_Category_ID'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Vehicle_Category_ID',CHtml::listData(VehicleCategory::model()->findAll(new CDbCriteria(array("order" => "Category_Name asc"))),'Vehicle_Category_ID','Category_Name'),array('class'=>'midSelect', 'prompt'=>'--- Please Select ---')); ?>
                        <a class="VehicleCategory addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('vehicleCategory/AddNew') ?>">
                            <img src="images/1Screenshot-32.png" title="Add New Vehicle Category" />
                        </a>
                        <?php echo $form->error($model,'Vehicle_Category_ID'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Make_ID'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Make_ID',CHtml::listData(MaMake::model()->findAll(new CDbCriteria(array("order"=>'Make ASC'))),'Make_ID','Make'),array('ajax' =>
                            array(
                                'type'=>'POST', //request type
                                'url'=>CController::createUrl('MaModel/DynamicModels'), //url to call.
                                'update'=>'#'.CHtml::activeId($model,'Model_ID'),

                                'data'=>'js:jQuery(this).serialize()'
                            ),
                            'prompt'=>'--- Please Select ---', 'class'=>'midSelect')
                        ); ?>

                        <a class="MaMake addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('MaMake/AddNew') ?>">
                            <img src="images/1Screenshot-32.png" title="Add New Make" />
                        </a>
                        <?php echo $form->error($model,'Make_ID'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Model_ID'); ?></div>
                    <div class="tdTwo"><?php
                        if(isset($model->Make_ID) && $model->Make_ID !=='')
                        {
                            echo $form->dropdownlist($model,'Model_ID',CHtml::listData(
                                MaModel::model()->getModels($model->Make_ID),'Model_ID','Model'),array('value'=>'asd','prompt' => '--- Please Select ---', 'class'=>'midSelect'));

                        }
                        else
                        {
                            echo $form->dropDownList($model,'Model_ID',array(),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect'));
                        }

                            ?>
                        <a class="MaModel addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maModel/AddNew') ?>">
                            <img src="images/1Screenshot-32.png" title="Add New Model" />
                        </a>
                         <div id="model_Error" style="color:#FF0000"></div>
                        <?php echo $form->error($model,'Model_ID'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Purchase_Value'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Purchase_Value',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
                        <?php echo $form->error($model,'Purchase_Value'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Engine_No'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Engine_No',array('class'=>'midText','maxlength'=>50)); ?>
                        <?php echo $form->error($model,'Engine_No'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Chassis_No'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Chassis_No',array('class'=>'midText','maxlength'=>50)); ?>
                        <?php echo $form->error($model,'Chassis_No'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Number_of_Passenger'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Number_of_Passenger',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
                        <?php echo $form->error($model,'Number_of_Passenger'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Ac_Statues'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Ac_Statues',array("Yes"=>"Yes","No"=>"No"),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                        <?php echo $form->error($model,'Ac_Statues'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Fuel_Type_ID'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Fuel_Type_ID',CHtml::listData(FuelType::model()->findAllFuelType(),'Fuel_Type_ID','Fuel_Type'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                        <a class="MaFuelType addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('fuelType/AddNew') ?>">
                            <img src="images/1Screenshot-32.png" title="Add New Fuel Type" />
                        </a>
                        <?php echo $form->error($model,'Fuel_Type_ID'); ?></div>
                </div>
           
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Fuel_Tank_Capacity'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Fuel_Tank_Capacity',array('class'=>'midText','maxlength'=>10, "onkeypress"=>"return isNumberKey(event)")); ?>&nbsp;Liters
                        <?php echo $form->error($model,'Fuel_Tank_Capacity'); ?></div>
                </div>
            
        </div>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading large">
        <h2 id="rest-title" class="panel-title" itemprop="name">SPARE PARTS </h2>
    </div>
    <div class="panel-body">
        <div class="formTable" >
           
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Tyre_Size_ID'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Tyre_Size_ID',CHtml::listData(MaTyreSize::model()->findAllTyreSize(),'Tyre_Size_ID','Tyre_Size'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                            <a class="MaTyreSize addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maTyreSize/AddNew') ?>">
                                <img src="images/1Screenshot-32.png" title="Add New Tyre Size" />
                            </a>
                       <?php echo $form->error($model,'Tyre_Size_ID'); ?></div>
                </div>
           
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->label($model,'Tyre_Size_ID_2'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Tyre_Size_ID_2',CHtml::listData(MaTyreSize::model()->findAllTyreSize(),'Tyre_Size_ID','Tyre_Size'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                       <?php echo $form->error($model,'Tyre_Size_ID_2'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Tyre_Type_ID'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Tyre_Type_ID',CHtml::listData(MaTyreType::model()->findAllTyreType(),'Tyre_Type_ID','Tyre_Type'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                            <a class="MaTyreType addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maTyreType/AddNew') ?>">
                                <img src="images/1Screenshot-32.png" title="Add New Tyre Types" />
                            </a>
                        <?php echo $form->error($model,'Tyre_Type_ID'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'No_of_Tyres'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'No_of_Tyres',array('class'=>'midText','maxlength'=>2, "onkeypress"=>"return isNumberKey(event)")); ?>
                        <?php echo $form->error($model,'No_of_Tyres'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Battery_Type_ID'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Battery_Type_ID',CHtml::listData(MaBatteryType::model()->findAllBatteryType(),'Battery_Type_ID','Battery_Type'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                        <a class="MaBatteryType addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maBatteryType/AddNew') ?>">
                            <img src="images/1Screenshot-32.png" title="Add New Battery Types" />
                        </a>
                        <?php echo $form->error($model,'Battery_Type_ID'); ?></div>
                </div>
            
        </div>
    </div>
</div>




<div class="panel panel-default">
    <div class="panel-heading large">
        <h2 id="rest-title" class="panel-title" itemprop="name">MAINTENANCE</h2>
    </div>

    <div class="panel-body">
        <div class="formTable" >
            
                <div class="tblRow">
                     <div class="tdOne"><?php echo $form->labelEx($model,'Vehicle_Status_ID'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Vehicle_Status_ID',CHtml::listData(VehicleStatus::model()->findAllVehicleStatus(),'Vehicle_Status_ID','Vehicle_Status'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                        <?php echo $form->error($model,'Vehicle_Status_ID'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Service_Mileage'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Service_Mileage',array('class'=>'midText','maxlength'=>100, "onkeypress"=>"return isNumberKey(event)")); ?>
                        <?php echo $form->error($model,'Service_Mileage'); ?></div>
                </div>
           
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Servicing_Period'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Servicing_Period',array('class'=>'midText','maxlength'=>10, "onkeypress"=>"return isNumberKey(event)")); ?>&nbsp;Months
                        <?php echo $form->error($model,'Servicing_Period'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'Fuel_Consumption'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'Fuel_Consumption',array('class'=>'midText','maxlength'=>10, "onkeypress"=>"return isNumberKey(event)")); ?>&nbsp;km
                        <?php echo $form->error($model,'Fuel_Consumption'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->labelEx($model,'odometer'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model,'odometer',array('class'=>'midText','maxlength'=>100, "onkeypress"=>"return isNumberKey(event)")); ?>
                        <?php echo $form->error($model,'odometer'); ?></div>
                </div>
            
                <div class="tblRow">
                    <div class="tdOne"><?php echo $form->label($model,'Fitness_test'); ?></div>
                    <div class="tdTwo"><?php echo $form->dropDownList($model,'Fitness_test',array("Yes"=>"Yes","No"=>"No"), array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                        <?php echo $form->error($model,'Fitness_test'); ?></div>
                </div>
           
            <?php

                $filename=$model->Vehicle_image;


                $wdth = substr($filename,5,1);
                $dotPos = strpos($filename, '.');

                if($dotPos != ''  && $id !='')
                {
                    $img = '<img src="VechicleReg/'.$filename.'"/>';
                }
                else
                {
                    $img ='<center><img src="VechicleReg/Default.png"/></center>';
                }
            ?>


            

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model, 'Vehicle_image');?></div>
            <div class="tdTwo">
                <div id="viewImage" data-provides="fileinput" style=""><?php echo  $img ?></div></div>
</div>
                <br />
                <div class="tblRow">
                    <div class="tdOne"></div>
                    <div class="tdTwo">
                    <div id="uploadFile_div">
                        <input type="button" value="Remove" id="removeImg" data-dismiss="fileinput" href="javascript:noAction()"/>
                    </div>
                        <?php echo CHtml::activeFileField($model, 'Vehicle_image', array('class'=>'fileField', 'htmlOptions'=>'onkeydown="return false;"'));?>

                    <?php echo $form->error($model, 'Vehicle_image');?>
                    </div>
                </div>
        

                <div class="tblRow">
                    <div class="tdOne">
                        <?php
                        $filename = $model->Vehicle_image;

                        ?>
                        <input type="hidden" name="last_uploaded_image" value="<?php
                        if (isset($_SESSION['selected_image'])) 
                        {
                            $file = $_SESSION['selected_image'];
                            echo $file;
                        }
                        ?>">
                        <input type="hidden" name="old_image_file_name" value="<?php echo $filename ?>">
                    </div>
                </div>
          <div class="row" style="padding-left:37%;font-weight:bold">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id'=>'btnSave'));?>
    </div>
        </div>
    </div>


    <script>

        $(document).ready(function()
        {
            var url = document.URL;
            var vNo ='0';
            //http://localhost/fleet_pension_svn/index.php?r=maVehicleRegistry/update&id=KH-5740
            var idPos = url.indexOf('&id='); //71 + 4 = 75
            
            if(idPos>0)
            {
                vNo = url.substr(parseInt(idPos)+ 4)
            }

            $('#MaVehicleRegistry_Vehicle_image').change(function()
            {
                var file = $(this).get(0).files[0];
                var imageType = /image.*/;
                var fd = new FormData();
                fd.append('file', file);

                $.ajax
                ({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("MaVehicleRegistry/SaveImageTemporary"); ?>',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(data) {
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
                    reader.onload = (function(aImg) {
                        return function(e) {
                            aImg.src = e.target.result;
                        };
                    })(img);
                    reader.readAsDataURL(file);
                }
            });
            $('a').click(function() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("MaVehicleRegistry/DestroyImageSession"); ?>',
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
                        url: "<?php echo $this->createAbsoluteUrl('MaVehicleRegistry/RemoveImage') ?>",
                        type: "post",
                        dataType: "html",
                        data: {'vNo':vNo},
                        success: function(data)
                        {
                            if(data !=='no')
                            {
                                $('#viewImage').html('<center><img src="VechicleReg/Default.png"/></center>');
                                $('#MaVehicleRegistry_Vehicle_image').val("");
                                return false;
                            }
                            else
                            {
                                $('#MaVehicleRegistry_Vehicle_image').val("");
                                $('#viewImage').html('<center><img src="VechicleReg/Default.png"/></center>');
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

    
</div>

    <?php date_default_timezone_set('Asia/Colombo'); ?>
    
        <?php
            if ($model->isNewRecord)
            {
                echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
            }
            else
            {
                echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));
            }
        ?>
   
        <?php
            if ($model->isNewRecord)
            {
                echo $form->hiddenField($model,'add_date',array('value'=>$curDateTime));
            } else
            {
                echo $form->hiddenField($model,'add_date',array());
            }
        ?>
   
        <?php
            if ($model->isNewRecord)
            {
                echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>'Not Edited'));
            } else
            {
                echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
            }
        ?>
    
    <?php
        if ($model->isNewRecord)
        {
            echo $form->hiddenField($model,'edit_date',array('value'=>'Not Edited'));
        } else
        {
            echo $form->hiddenField($model,'edit_date',array('value'=>$curDateTime));
        }
    ?>
  
<?php $this->endWidget(); ?>

<!-- form --> 

