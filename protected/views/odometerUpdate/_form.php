<style type="text/css">
    .error{
        color: red;
    }
</style>

<?php
//$vehicleId = Yii::app()->session['VehicleIdFuel'];
$aid = Yii::app()->session['VehicleIdAllocationID'];

$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'odometer-update-form',
    'enableAjaxValidation' => false,
        ));

$locID = Yii::app()->getModule('user')->user()->Location_ID;
$vehicleId = Yii::app()->request->getQuery('id');
Yii::app()->session['OdoUpdateVehicle'] = $vehicleId;
$dID = '';
if($vehicleId !='')
{
	$dt = 'SELECT distinct d.Driver_ID, d.Full_Name FROM vehicle_driver vd inner join ma_driver d On d.Driver_ID = vd.Driver_ID  inner join vehicle_location vl on d.Location_ID = vl.Current_Location_ID where vd.Vehicle_No = "'.$vehicleId.'"';


	$arr = Yii::app()->db->createCommand($dt)->queryAll();
	$count = count($arr);
	if($count != 0)
	{
		$dID = $arr[$count-1]['Driver_ID'];
	}

}
			#$qry = 'SELECT Full_Name FROM ma_driver WHERE Driver_ID='.$dID;
			#$rawData = Yii::app()->db->createCommand($qry)->queryAll();
			#$dr = count($rawData);
			#$drivr = $rawData[$dr-1]['Full_Name'];
			
		($dID != '' ? $op = array($dID =>Array ( 'selected' => 'selected' ) ): $op = array());
        	

		
//Yii::app()->session['VehicleIdOdo'] = $vehicleId;

//sytem date and time
date_default_timezone_set('Asia/Colombo');
$dateTime = date("Y-m-d H:i:s");

//var_dump(($model->update_id));
//if in time or out time empty to get initial record if one exists
if ($model->update_id !== null) {
    
   //for partially completed records
        $outTime = $model->out_time;
        $inTime = $dateTime;
        $outOdo = $model->out_odo_reading;
        $inOdo = '';
   
} else {
    //for very first record of the specific vehicle
    $outTime = $dateTime;
    $inTime = '';
    $outOdo = '';
    $inOdo = '';
}


$result = TRVehicleBooking::model()->getcurrentMilage($vehicleId);
if ($result == "") {
    $odo = 0000;
} else {
    $odo = (int)$result;
}
?>
<style type="text/css">
    .odometer {
        font-size: 25px;
    }
</style>
<script>

    $(document).ready(function() 
    {
        var el = document.querySelector('#odometer');

        od = new Odometer({
            el: el,
            format: '(,ddd)', // Change how digit groups are formatted, and how many digits are shown after the decimal point
            duration: 3000, // Change how long the javascript expects the CSS animation to take
            theme: 'car', // Specify the theme (if you have more than one theme css file on the page)
            animation: 'count', // Count is a simpler animation method which just increments the value,
            // value: 00000,     // use it when you're looking for something more subtle.
        });
//        od.render();
        od.update(<?php echo $odo ?>);
        
        $(".OdometerUpdateRemark").fancybox
           ({
                afterClose: function()
                {
                    $.ajax
                    ({
                        type: "POST",
                        url: "<?php echo Yii::app()->createAbsoluteUrl("OdometerUpdateRemark/UpdateOdometerUpdateRemark") ?>",
                        success: function(data)
                        {
                           $("#OdometerUpdate_remark_id").append(data);
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
                height:1500,

                helpers:{
                    overlay: {css: {"background": "rgba(238,238,238,0.85)" }}
                }

            });
    });

</script>




    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model, 'Vehicle_No', array('value' => $vehicleId)); ?>
    
    <div class="formTable">
        <div class="tblrow">
            <div class="tdOne"><?php echo $form->labelEx($model, 'Driver_ID'); ?></div>
            <div class="tdTwo"><?php echo $form->dropDownList($model, 'Driver_ID', CHtml::listData(MaDriver::model()->findAll(array("condition"=>"Location_ID=$locID")), 'Driver_ID', 'Full_Name'), array('prompt' => '--- Please Select ---', 'class' => 'midSelect', 'options'=>$op)); ?>
                <?php echo $form->error($model, 'Driver_ID'); ?></div>
        </div>
        
        <div class="tblrow">
            <div class="tdOne"><?php echo $form->labelEx($model, 'remark_id'); ?></div>
            <div class="tdTwo"><?php echo $form->dropDownList($model,'remark_id',CHtml::listData(OdometerUpdateRemark::model()->findAll(),'remark_id','description'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                        <a class="OdometerUpdateRemark addBtn" data-fancybox-type="iframe" href="<?php echo Yii::app()->createUrl('odometerUpdateRemark/AddNew') ?>">
                            <img src="images/1Screenshot-32.png" title="Add New Provincial Council" />
                        </a>
                <?php echo $form->error($model, 'remark_id'); ?>
            </div>
        </div>
        
        <div class="tblrow">
            <div class="tdOne"><?php echo $form->labelEx($model, 'out_time'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model, 'out_time', array('value' => $outTime)); ?>
                    <?php echo $form->error($model, 'out_time'); ?></div>
        </div>
        
        <div class="tblrow">
            <div class="tdOne"><?php echo $form->labelEx($model, 'out_odo_reading'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model, 'out_odo_reading', array('value' => $outOdo)); ?>
                    <?php echo $form->error($model, 'out_odo_reading'); ?></div>
        </div>
        
        <?php
        if (($outTime !== '') && ($inTime !== '')) {
            ?>
                <div class="tblrow">
                    <div class="tdOne"><?php echo $form->labelEx($model, 'in_time'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model, 'in_time', array('value' => $inTime)); ?>
                                <?php echo $form->error($model, 'in_time'); ?></div>
                </div>            

        <?php } ?>
        
         <?php if ($outOdo !== '') { ?>

        <div class="tblrow" >
                    <div class="tdOne"><?php echo $form->labelEx($model, 'in_odo_reading'); ?></div>
                    <div class="tdTwo"><?php echo $form->textField($model, 'in_odo_reading',array('value'=>$inOdo)); ?>
                        <?php echo $form->error($model, 'in_odo_reading'); ?></div>
        </div> 

        <?php } ?>
        
        <div class="tblrow">
            <div class="tdOne"> Current Odometer
                <?php // if (($userRole !== '3') && ($userRole !== '4')) {?>
                        <!--Current Odometer-->
                    <?php
//                    }else{
                        ?>
                        <!--වර්තමාන කිලෝමීටර කියවීම-->
                    <?php //   }?></div>
            <div class="tdTwo"><span style="float: left; margin-right: 5%;"></span><div id="odometer" style="margin-left: 0; margin-right:50px; float: left; "></div></div>
        </div> 
        

        



        


<?php echo $form->hiddenField($model, 'added_by', array('value' => Yii::app()->getModule('user')->user()->username)); ?>
<?php 
        if ($model->isNewRecord){
        echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>''));
        } else {
        echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));   	
        }
?>
	
        <div class="tblrow" style="display: none">
            <div class="tdOne"><?php echo $form->labelEx($model, 'description'); ?></div>
            <div class="tdTwo"><?php echo $form->textField($model, 'description'); ?>
                <?php echo $form->error($model, 'description'); ?></div>
        </div> 


       <div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>
   
    <?php $this->endWidget(); ?>

</div><!-- form -->