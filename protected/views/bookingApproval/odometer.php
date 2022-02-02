<?php
$userRole = Yii::app()->getModule('user')->user()->Role_ID;


//sytem date and time
date_default_timezone_set('Asia/Colombo');
$dateTime = date("Y-m-d H:i:s");

//getting booking approval id to check the in out time
$bId = Yii::app()->request->getQuery('Booking_Approval_ID');

$ct = new CDbCriteria();
$ct->condition = 'Booking_Approval_ID=:bId';
$ct->params = array(':bId' => $bId);
$ct->select = array('In_Time', 'Out_Time');

$result1 = BookingApproval::model()->find($ct);

  $header ="Odometer Details";
//                            if (($userRole !== '3') && ($userRole !== '4'))
//                            {
//                                $header ="Odometer Details";
//
//                            }
//                            else
//                            {
//                                $header="ඔඩෝමීටර විස්තරය";
//                            }

if (($result1['Out_Time'] === null)) {

    $outTime = $dateTime;
    $inTime = '';
} elseif (($result1['Out_Time'] !== null) && ($result1['In_Time'] === null)) {

    $outTime = $result1['Out_Time'];
    $inTime = $dateTime;
} else {
    $this->redirect(array('tRVehicleBooking/vehiclelist'));
}

$vehicleId = Yii::app()->request->getQuery('vehicleId');

$status = Yii::app()->session['status'];
$mileage = $model->Mileage;
Yii::app()->session['earlyMileage'] = $mileage;

$result = TRVehicleBooking::model()->getcurrentMilage($vehicleId);
if ($result == "") {
    $odo = 0000;
} else {
    $odo = (int) $result;
}
?>
<style type="text/css">
    .odometer {
        font-size: 25px;
    }
</style>
<script>

    $(document).ready(function() {
        var el = document.querySelector('#odometer');

        od = new Odometer({
            el: el,
            format: '(,ddd)', // Change how digit groups are formatted, and how many digits are shown after the decimal point
            duration: 3000, // Change how long the javascript expects the CSS animation to take
            theme: 'car', // Specify the theme (if you have more than one theme css file on the page)
            animation: 'count' // Count is a simpler animation method which just increments the value,
            // value: 00000,     // use it when you're looking for something more subtle.
        });
//        od.render();
        od.update(<?php echo $odo ?>)
    });

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        {
            return false;
        }            

        return true;
    }


</script>


<?php
    if (isset(Yii::app()->session['status']) && Yii::app()->session['status'] != '') 
    {
        unset(Yii::app()->session['status']);
    }
?>




<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php $this->breadcrumbs=array(
                        'Vehicle Registry'=>array('maVehicleRegistry/edit'),
                        'Assign Driver'=>array('/tRVehicleLocation/notAssignedVehicles'),
                        'Assign Driver to Vehicle'

                    );?>
                </ul>
            </div>
            
            
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $header?></h1>
                    </div>
                </div>
                
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <center><h1 id="rest-title" class="panel-title" itemprop="name"><p align="center"><b><?php echo $vehicleId; ?></b></p></h1></center>
                    </div>


                    <div class="panel-body">
                        <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'trvehicle-booking-form',
                                'enableAjaxValidation' => false,
                            ));
                        ?>
                        
                        <?php echo $form->errorSummary($model); ?>
                        
                        <div class="formTable">
                            <div class="tblRow">
                                <div class="tdOne"><?php echo $form->labelEx($model, 'Out_Time'); ?></div>
                                <div class="tdTwo"><?php echo $form->textField($model, 'Out_Time', array('readonly' => 'readonly', 'value' => $outTime)); ?>
                                    <?php echo $form->error($model, 'Out_Time'); ?></div>
                            </div>

                            <?php
                                if (($outTime !== '') && ($inTime !== '')) 
                                {
                                    ?>

                                   <div class="tblRow">
                                        <div class="tdOne"><?php echo $form->labelEx($model, 'In_Time'); ?></div>
                                        <div class="tdTwo"><?php echo $form->textField($model, 'In_Time', array('readonly' => 'readonly', 'value' => $inTime));?>
                                            <?php echo $form->error($model, 'In_Time'); ?></div>
                                    </div> 

                                    <div class="tblRow">
                                        <div class="tdOne"><?php echo $form->labelEx($model, 'Mileage'); ?></div>
                                        <div class="tdTwo"><?php echo $form->textField($model, 'Mileage', array('onkeypress' => 'return isNumberKey(event)', 'autocomplete' => "off", 'class'=>"midText")); ?>
                                            <?php echo $form->error($model, 'Mileage'); ?></div>
                                    </div> 

                                    <div class="tblRow">
                                        <div class="tdOne"><?php echo $form->labelEx($model, 'No_of_Pessengers'); ?></div>
                                        <div class="tdTwo"><?php echo $form->textField($model, 'No_of_Pessengers', array('onkeypress' => 'return isNumberKey(event)', 'autocomplete' => "off", 'class'=>"midText")); ?>
                                            <?php echo $form->error($model, 'No_of_Pessengers'); ?></div>
                                    </div> 
                            <?php 
                                }
                                ?>


                        </div>
                    
                        <div class="tblRow">
                            <div class="tdOne"><h3 style="font-size:14px; padding-left: 25px">Current Mileage
<!--                                            <?php // if (($userRole !== "3") && ($userRole !== "4")) {
                                                ?>Current Mileage
                                            <?php
//                                            } else {
                                                ?>
                                                වර්තමාන කිලෝමීටර කියවීම
                                            <?php
//                                            }
                                            ?>
-->
</h3></div>
                            <div class="tdTwo"><div id="odometer" class="odometer" style="float:left"></div></div>
                        </div>
                        
                        <div class="tblRow">
                            <div class="tdOne"></div> 
                            <div class="tdTwo"> <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save'); ?></div>
                        </div>                        
                 
                        <?php $this->endWidget();?>
                            
                    </div>
                </div>


            </div>
            <div class="col-xs-4">
               <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">
                            Menu
                        </h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">

                            <?php
                            if(($userRole ==='2')||($userRole ==='6'))
                            {
                                echo MaVehicleRegistry::model()->menuarray('VehicleBookingLow');
                            }
                            elseif($userRole ==='3' || $userRole ==='4')
                            {
                                echo MaVehicleRegistry::model()->menuarray('OdometerSinhala');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('VehicleBooking');
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>













