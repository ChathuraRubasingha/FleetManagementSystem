<style type="text/css"> 
    .error
    {
        color:red;        
    }

    .PriceValue
    {
        text-align: right;
        min-width: 150px;
    }
    
    .grid-view
    {
        float: left;
        width: 90%;
        margin:20px 0px 20px 2%;
    }
    #replacement-grid_c1{
		text-align: center;
	}
    #replacement-grid_c2{
		text-align: center;
	}
    #replacement-grid_c3{
		text-align: center;
	}	
    #fancybox-loading div {
        position: fixed;
        top: 0;
        left: 50%;
        width: 40px;
        height: 480px;
        background-image:'url(fancy/fancybox_loading@2x.gif)';
    }
</style>

<script type="text/javascript">

    $(document).ready(function()
    {    
        $('#TRServices_Service_Date').Zebra_DatePicker();
        $('#TRServices_Next_Service_Date').Zebra_DatePicker();

        $("#TRServices_Estimate_Cost").keyup(function()
        {
            var cost = $("#TRServices_Estimate_Cost").val();
            var sepVal = thousandSep(cost);
            $("#TRServices_Estimate_Cost").val(sepVal);
        });

        $("#TRServices_Other_Costs").keyup(function()
        {
            var cost = $("#TRServices_Other_Costs").val();
            var sepVal = thousandSep(cost);
            $("#TRServices_Other_Costs").val(sepVal);
        });


        $(".PriceValue").keyup(function()
        {
            var curid = this.id;
            var tot = 0;
            var cost = $("#"+curid).val();

            tot = serviceCost();

            var sepVal = thousandSep(cost);
            $("#"+curid).val(sepVal);

            $("#TRServices_Estimate_Cost").val(tot);

        });

        $("#TRServices_Other_Costs").keyup(function()
        {
            var tot = serviceCost();
            $("#TRServices_Estimate_Cost").val(tot);

        });

        $('.checkBox').each(function()
        {
            var chkID = this.id;
            var id = chkID.substr(3);

            if($(this).is(':checked'))
            {
                $('#price_'+id).attr("style","background-color:#FFFFFF;min-width:20%");
            }
            else
            {
                $('#price_'+id).attr("style","background-color:#E9E8E8;min-width:20%");
            }

        });


        $('.checkBox').live("click",function()
        {
            var chkID = this.id;
            var id = chkID.substr(3);

            if($("#"+chkID).is(':checked'))
            {

                $('#price_'+id).removeAttr("readOnly");
                $('#price_'+id).attr("style","background-color:#FFFFFF;min-width:20%");
                $('#price_'+id).get(0).focus();
            }
            else
            {
                $('#price_'+id).val("");
                $('#price_'+id).attr("readOnly",true);
                $('#price_'+id).attr("style","background-color:#E9E8E8;min-width:20%");
            }

        });

        $("#submit_btn").click(function()
        {
            $('.checkBox').each(function()
            {
                var chkID = this.id;
                var id = chkID.substr(3);

                if($(this).is(':checked'))
                {
                   if($('#price_'+id).val() ==='')
                   {
                       $('#price_'+id).val("0.00");
                   }
                }

            });

        });

        $(".MaServiceStation").fancybox({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaServiceStation/UpdateServiceStation') ?>',
                    success: function(data)
                    {
                        $('#TRServices_Service_Station_ID').append(data);
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
            width: 650,
            height:900,
           helpers:
           {
                overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
           }

        });
        
        $(".MaServiceType").fancybox({
            afterClose: function()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('MaServiceType/UpdateServiceType') ?>',
                    success: function(data)
                    {
                        $('#TRServices_Service_Type_ID').append(data);
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
            width: 650,
            height:900,
           helpers:
           {
                overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
           }

        });
        
        $(".MaReplacementOfService").fancybox({
            afterClose: function()
            {
                $("#replacement-grid").yiiGridView.update("replacement-grid");
                    
            },
            openEffect: 'elastic',
            openSpeed: 300,
            closeEffect: 'elastic',
            closeSpeed: 300,
            width: 650,
            height:900,
           helpers:
           {
                overlay: {css: {'background': 'rgba(238,238,238,0.85)' }}
           }

        });


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

    function thousandSep(costVal)
    {
        var test = costVal.replace(/,/g,'');
        return String(test).split("").reverse().join("").replace(/(\d{3}\B)/g, "$1,").split("").reverse().join("");
    }

    function serviceCost()
    {
        var other =0;
        var tot=0;
        var serviceCost =0;

        if($("#TRServices_Other_Costs").val() !=='')
        {
            other = $("#TRServices_Other_Costs").val().replace(/,/g,'');
        }

        $(".PriceValue").each(function()
        {
            if($(this).val() !== '')
            {
                var val = $(this).val().replace(/,/g,'');
                val = parseFloat(val);
                tot += val
            }


        });
        serviceCost = (tot + parseFloat(other)).toFixed(2);
        return serviceCost

    }

</script>

<?php

    $curDate = MaVehicleRegistry::model()->getServerDate("date");
    $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

    if(!isset($model->Service_Date))
    {
        ?>
        <script>
            $(document).ready(function()
            {
                var curDate ='<?php echo $curDate; ?>';
                $('#TRServices_Service_Date').val(curDate);

            });

        </script>
    <?php

    }
    ?>



    <?php
        $vehicleId = Yii::app()->session['maintenVehicleId'];
        $id = Yii::app()->request->getQuery('id');
        $locData = Yii::app()->db->createCommand('select Current_Location_ID from vehicle_location where Vehicle_No ="'.$vehicleId.'"')->queryAll();
        
        if (!empty($locData))
        {
            $curLoc = $locData[count($locData)-1]['Current_Location_ID'];
            $dt = 'SELECT distinct d.Driver_ID, d.Full_Name FROM vehicle_driver vd inner join ma_driver d On d.Driver_ID = vd.Driver_ID  inner join vehicle_location vl on d.Location_ID = vl.Current_Location_ID where vd.Vehicle_No = "'.$vehicleId.'" and vl.Current_Location_ID = "'.$curLoc.'"';

            $arr = Yii::app()->db->createCommand($dt)->queryAll();
            $count = count($arr);
            if($count != 0)
            {
                $dID = $arr[$count-1]['Driver_ID'];
            }
            else
            {
                $dID = '';
            }
        }
        else
        {
            $dID ='';
        }

        ($dID != '' ? $op = array($dID =>Array ( 'selected' => 'selected' ) ): $op = array());


    ?>


        
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'services-form',
    'enableAjaxValidation'=>false,
));

    date_default_timezone_set('Asia/Colombo'); 
?>

	<?php echo $form->errorSummary($model); ?>



    <div class="formTable" >

           <?php echo $form->hiddenField($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
       

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Driver_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->dropdownlist($model,'Driver_ID',CHtml::listData(MaDriver::model()->getDriverNamesInLocation($vehicleId),'Driver_ID','Full_Name'),array('prompt' => '--- Please Select ---', 'class'=>'midSelect', 'options'=>$op));   ?>
                <?php echo $form->error($model,'Driver_ID'); ?></div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Service_Station_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->dropDownList($model,'Service_Station_ID',CHtml::listData(MaServiceStation::model()->findAll(),'Service_Station_ID','Srvice_Station_Name'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                    <a class="MaServiceStation addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('MaServiceStation/AddNew') ?>">
                        <img src="images/1Screenshot-32.png" title="Add New Service Station" />
                    </a>
                <?php echo $form->error($model,'Service_Station_ID'); ?>
            </div>
        </div>

        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Service_Type_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->dropDownList($model,'Service_Type_ID',CHtml::listData(MaServiceType::model()->findAll(),'Service_Type_ID','Service_Type'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                    <a class="MaServiceType addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('MaServiceType/AddNew') ?>">
                        <img src="images/1Screenshot-32.png" title="Add New Service Type" />
                    </a>
                <?php echo $form->error($model,'Service_Type_ID'); ?>
            </div>
        </div>
	
        <div class="tblRow">
            <div class="tdOne"><?php echo $form->labelEx($model,'Service_Date'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model,'Service_Date',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                    <?php echo $form->error($model,'Service_Date'); ?>
            </div>
        </div>
	
    <?php
	$notValid =false;
	if(isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !='')
	{
            $notValid = true;
	}
	
	if($notValid)
	{
            if(isset(Yii::app()->session['checkBoxValues']) && Yii::app()->session['checkBoxValues'] !='')
            {
                $checkBoxValues = array();
                $priceValues = array();
                $checkBoxValues = Yii::app()->session['checkBoxValues'];
                if(isset(Yii::app()->session['priceValues']) && Yii::app()->session['priceValues'] !='')
                {
                    $priceValues = Yii::app()->session['priceValues'];
                }
				$countChk = count($checkBoxValues);
                $countPrice = count($priceValues);
                $r =0;

                if ($countPrice > 0)
                {
                    for($i=0; $i<$countPrice; $i++)
                    {
                        $price = $priceValues[$i];
                        
                        if($price !=='')
                        {
                            $repID = $checkBoxValues[$r];
                            echo "
                            <script>
                                $(document).ready(function()
                                {
                                    $('#id_".$repID."').attr('checked',true);
                                    $('#price_".$repID."').removeAttr('readOnly');
                                    $('#price_".$repID."').attr('style','background-color:#FFFFFF;min-width:20%');
                                    $('#price_".$repID."').val('$price');
                                });
                            </script>";

                            $r++;
                        }
                    }
                }
            }
            unset(Yii::app()->session['checkBoxValues']);
	}
	else if ($id != '')
	{
            $arr = Yii::app()->db->createCommand('select Replacement_of_Service_ID,Price,Next_Service_Milage from service_replacement where Services_ID ='.$id)->queryAll();
            $count = count($arr);

            if ($count > 0)
            {
                for($i=0; $i<$count; $i++)
                {
                    $repID = $arr[$i]['Replacement_of_Service_ID'];
                    $price = $arr[$i]['Price'];
					$NextMil = $arr[$i]['Next_Service_Milage'];

                    echo "
                        <script>
                            $(document).ready(function()
                            {
                                $('#id_".$repID."').attr('checked',true);
                                $('#price_".$repID."').removeAttr('readOnly');
                                $('#price_".$repID."').attr('style','background-color:#FFFFFF;min-width:20%');
                                $('#price_".$repID."').val('$price');
                                $('#Next_Service_Milage_".$repID."').removeAttr('readOnly');
                                $('#Next_Service_Milage_".$repID."').attr('style','background-color:#FFFFFF;min-width:20%');
                                $('#Next_Service_Milage_".$repID."').val('$NextMil');								
                            });
                        </script>
                    ";

                }
            }		
	}
    ?>

    <div class="tblRow">
        

        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'replacement-grid',
             'template' => '{items}{pager}',
            'dataProvider'=>MaReplacementOfService::model()->searchRep(),
            'ajaxUpdate'=>true,
            'selectableRows'=>2,
            'columns'=>array(
                'Service_Replacement',
                array('name' =>'select', 'class'=>'CDataColumn', 'value' => 'CHtml::checkBox("ids[]",null,array("value"=>$data->Replacement_of_Service_ID, "class"=>"checkBox", "id"=>"id_".$data->Replacement_of_Service_ID))','type'=>'raw', 'htmlOptions' => array('width'=>'20%'), ),
                array(
                    'name' =>'Next Replacement (in Km)',
                    'class'=>'CDataColumn',
                    'value' => 'CHtml::textField("Next_Service_Milage[]",null,array("value"=>$data->Replacement_of_Service_ID, "style"=>"min-width:20%", "class"=>"NextMillageValue", "onkeypress"=>"return isNumberKey(event)", "id"=>"Next_Service_Milage_".$data->Replacement_of_Service_ID))',
                    'type'=>'raw',
                    'htmlOptions' => array('style'=>'text-align:left', 'width'=>'20%'),),
	            array(
                    'name' =>'Price',
                    'class'=>'CDataColumn',
                    'value' => 'CHtml::textField("prices[]",null,array("value"=>$data->Replacement_of_Service_ID, "readOnly"=>"true", "style"=>"min-width:20%", "class"=>"PriceValue", "onkeypress"=>"return isNumberKey(event)", "id"=>"price_".$data->Replacement_of_Service_ID))',
                    'type'=>'raw',
                    'htmlOptions' => array('style'=>'text-align:left', 'width'=>'20%'),),
            ),
	
        )); ?>        
        
        <a class="MaReplacementOfService addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('maReplacementOfService/AddNew') ?>">
            <img src="images/1Screenshot-32.png" title="Add New Replacement Of Service" />
        </a>
    </div>

 
<br/><br/>

    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Other_Costs'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Other_Costs',array('maxlength'=>50, 'class'=>'money_mask midText')); ?>
            <?php echo $form->error($model,'Other_Costs'); ?></div>
    </div>

    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Estimate_Cost'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Estimate_Cost',array('maxlength'=>50, 'readOnly'=>true, 'class'=>'money_mask midText', 'style'=>'background-color:#E7E6E6')); ?>
            <?php echo $form->error($model,'Estimate_Cost'); ?>
        </div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Meter_Reading'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Meter_Reading',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
            <?php echo $form->error($model,'Meter_Reading'); ?></div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Next_Service_Date'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Next_Service_Date',array('autocomplete'=>'off','class'=>"zDatepicker" )); ?>
            <?php echo $form->error($model,'Next_Service_Date'); ?>
        </div>
    </div>
	
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Next_Service_Milage'); ?></div>
        <div class="tdTwo"><?php echo $form->textField($model,'Next_Service_Milage',array('class'=>'midText','maxlength'=>50, "onkeypress"=>"return isNumberKey(event)")); ?>
            <?php echo $form->error($model,'Next_Service_Milage'); ?>
        </div>
    </div>
	
    
    
    <div class="tblRow">
        <div class="tdOne"><?php echo $form->labelEx($model,'Description'); ?></div>
        <div class="tdTwo"><?php echo $form->textArea($model,'Description',array('rows'=>6, 'cols'=>54)); ?>
            <?php echo $form->error($model,'Description'); ?></div>
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
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id'=>'submit_btn'));?>
        </div>

<?php $this->endWidget(); ?>
       
<?php

$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.money_mask',
    'currency' => 'PHP',
    'config' => array(
        //  'showSymbol'=>true,
        'symbolStay' => true,
        'decimal' => '.',
        'allowNegative' => true,
        'precision' => 2,
    )
));


$this->widget('application.extensions.EJqCalculator.EJqCalculator', array(

));

?>

</div>
