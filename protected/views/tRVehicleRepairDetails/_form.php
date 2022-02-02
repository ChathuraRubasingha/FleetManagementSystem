
<script type="text/javascript">


$(document).ready(function(){

	$("#TRVehicleRepairDetails_Repair_Cost").keyup(function(){
		var cost = $("#TRVehicleRepairDetails_Repair_Cost").val();
		var sepVal = thousandSep(cost);
		$("#TRVehicleRepairDetails_Repair_Cost").val(sepVal);
	});

    $('#TRVehicleRepairDetails_Repaired_Date').Zebra_DatePicker();
    
	$(".PriceValue").keyup(function()
        {

            var curid = this.id;
            var tot = 0;
            var cost = $("#"+curid).val();

            tot = serviceCost();

            var sepVal = thousandSep(cost);
            $("#"+curid).val(sepVal);

            $("#TRVehicleRepairDetails_Repair_Cost").val(tot);

        });
});


function thousandSep(val) {
	var test = val.replace(/,/g,'');
	return String(test).split("").reverse().join("").replace(/(\d{3}\B)/g, "$1,").split("").reverse().join("");
}

function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    //alert(charCode);
    if (charCode != 46 && charCode !=45 && charCode > 31
        && (charCode < 48 || charCode > 57 ))
        return false;

    return true;
}

    function serviceCost()
    {
        var other =0;
        var tot=0;
        var serviceCost =0;

        $(".PriceValue").each(function()
        {
            if($(this).val() !== '')
            {
                var val = $(this).val().replace(/,/g,'');
                val = parseFloat(val);
                tot += val
            }


        });
        serviceCost = (tot).toFixed(2);
        return serviceCost

    }
</script>



<?php

 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trvehicle-repair-details-form',
	'enableAjaxValidation'=>false,
));

?>
<?php

    $vehicleId = Yii::app()->session['maintenVehicleId'];
    $repairID = Yii::app()->request->getQuery('id');

    $estimateId = Yii::app()->request->getQuery('estimateId');
    $garageId = Yii::app()->request->getQuery('garageId');

    $curDate = MaVehicleRegistry::model()->getServerDate("date");
    $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

    if(!isset($model->Service_Date))
    {
        ?>
        <script>
            $(document).ready(function()
            {
                var curDate ='<?php echo $curDate; ?>';
                $('#TRVehicleRepairDetails_Repaired_Date').val(curDate);

            });

        </script>
    <?php

    }

    if ($garageId == '')
    {
	$rawData = Yii::app()->db->createCommand('select Garage_ID  from vehicle_repair_details where Repair_ID ='.$repairID)->queryAll();
	$count = count($rawData);
	if ($count != 0)
	{
		$garageId = $rawData[$count-1]['Garage_ID'];
	}
    }

    $grNameData = Yii::app()->db->createCommand('select Garage_Name from ma_garages where Garage_ID ='.$garageId)->queryAll();
    $garageName = '';

    if(!empty($grNameData))
    {
            $garageName = $grNameData[0]['Garage_Name'];
    }
?>
	
    <?php
	// start from here 
	
	$notValid =false;
	$id = Yii::app()->request->getQuery('id');
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
                                    $('#price_" . $repID."').removeAttr('readOnly');
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
            $arr = Yii::app()->db->createCommand('select repair_replacement_details.Repair_Details_ID, repair_replacement_details.Price, repair_replacement_details.Next_Millage from repair_replacement_details where repair_replacement_details.Replacement_ID = '.$id)->queryAll();
            $count = count($arr);

            if ($count > 0)
            {
                for($i=0; $i<$count; $i++)
                {
                    $repID = $arr[$i]['Repair_Details_ID'];
                    $price = $arr[$i]['Price'];
					$NextMil = $arr[$i]['Next_Millage'];

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
                array('name' =>'select', 'class'=>'CDataColumn', 'value' => 'CHtml::checkBox("ids[]",null,array("value"=>$data->Replacement_of_Service_ID, "class"=>"checkBox", "id"=>"id_".$data->Replacement_of_Service_ID))','type'=>'raw', 'htmlOptions' => array('width'=>'1%'), ),
                array(
                    'name' =>' ',
                    'class'=>'CDataColumn',
                    'value' => 'CHtml::hiddenField("ItemID[]",$data->Replacement_of_Service_ID,array("style"=>"min-width:20%", "class"=>"ItemID", "onkeypress"=>"return isNumberKey(event)", "value"=>$data->Replacement_of_Service_ID, "id"=>"ItemID_" . $data->Replacement_of_Service_ID))',
                    'type'=>'raw',
                    'htmlOptions' => array('style'=>'text-align:left', 'width'=>'20%'),),
                array(
                    'name' =>'Next Replacement (in Km)',
                    'class'=>'CDataColumn',
                    'value' => 'CHtml::textField("Next_Service_Milage[]",null,array("value"=>$data->Replacement_of_Service_ID, "style"=>"min-width:20%", "class"=>"NextMillageValue", "onkeypress"=>"return isNumberKey(event)", "id"=>"Next_Service_Milage_".$data->Replacement_of_Service_ID))',
                    'type'=>'raw',
                    'htmlOptions' => array('style'=>'text-align:left', 'width'=>'20%'),),
	            array(
                    'name' =>'Price',
                    'class'=>'CDataColumn',
                    'value' => 'CHtml::textField("prices[]",null,array("value"=>$data->Replacement_of_Service_ID, "style"=>"min-width:20%", "class"=>"PriceValue", "onkeypress"=>"return isNumberKey(event)", "id"=>"price_".$data->Replacement_of_Service_ID))',
                    'type'=>'raw',
                    'htmlOptions' => array('style'=>'text-align:left', 'width'=>'20%'),),
            ),
	
        )); ?>  


<?php date_default_timezone_set('Asia/Colombo'); ?>



	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <div class="formTable">
        
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Estimate_ID'); ?>
        </div><div class="tdTwo">
		<?php /*?><?php echo $form->textField($model,'Estimate_ID'); ?><?php */?>
        <?php echo $form->textField($model,'Estimate_ID',array('class'=>'midText','value'=>$estimateId,'readonly'=>true)); ?>
		<?php echo $form->error($model,'Estimate_ID'); ?>
        </div></div> <!--end tblRow-->
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->hiddenfield($model,'Vehicle_No'); ?>
         </div><div class="tdTwo">
		<?php echo $form->hiddenfield($model,'Vehicle_No',array('class'=>'midText','value'=>$vehicleId,'readonly'=>true)); ?>
		<?php echo $form->error($model,'Vehicle_No'); ?>
        </div></div> <!--end tblRow-->
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Garage_ID'); ?>
         </div><div class="tdTwo">
		<?php echo $form->textField($model,'Garage_ID', array('class'=>'midText','value'=>$garageName,'readonly'=>true)); ?>
        <?php #echo $form->dropdownlist($model,'Garage_ID',CHtml::listData(TRVehicleRepairDetails::model()->getGarage($garageId),'Garage_ID','Garage_Name'),array('readonly'=>true));  ?>
		<?php echo $form->error($model,'Garage_ID'); ?>
        </div></div> <!--end tblRow-->
	
     <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Repair_Cost'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'Repair_Cost',array('class'=>'midText','maxlength'=>50,  "onkeypress"=>"return isNumberKey(event)")); ?>
		<?php echo $form->error($model,'Repair_Cost'); ?>
        </div></div> <!--end tblRow-->
	
     <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Description_Of_Repair'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textArea($model,'Description_Of_Repair',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Description_Of_Repair'); ?>
        </div></div> <!--end tblRow-->
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Repaired_Date'); ?>
        </div><div class="tdTwo">
            <?php echo $form->textField($model,'Repaired_Date',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
		<?php echo $form->error($model,'Repaired_Date'); ?>
        </div></div> <!--end tblRow-->
	
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