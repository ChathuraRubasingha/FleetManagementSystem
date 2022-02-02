


      <?php $vehicleId = Yii::app()->request->getQuery('vehicleId');
	  $status = Yii::app()->session['status'];
	  $mileage = $model->Mileage;
	  Yii::app()->session['earlyMileage'] = $mileage;
	  
	  ?>






<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Vehicle Booking'=>array('tRVehicleBooking/booking'),
                        'Odometer'=>array('tRVehicleBooking/vehiclelist'),
                        'Odometer Details'
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Odometer Details</h1>
                    </div>

                    <div class="panel-body">
                        <div class="group" style="width:86.9%; margin-left:29.7%; margin-top:2.4%">
                            <div class="form" style="margin-top:10px;">

                                <?php
                                $form=$this->beginWidget('CActiveForm', array(
                                    'id'=>'trvehicle-booking-form',
                                    'enableAjaxValidation'=>false,
                                )); ?>

                                <!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

                                <?php echo $form->errorSummary($model); ?>

                                <div class="classname" style="width:200px; height:28px; font-size:25px; margin-left:38%; margin-bottom:20px;"><p align="center"><b><?php echo $vehicleId; ?></b></p></div>
                                <table width="550" style="margin-left:50px">
                                    <tr>
                                        <td>

                                            <table >
                                                <?php /*?><div class="row" style="display:none">
    	<?php $user = Yii::app()->getModule('user')->user()->id;?>
		<?php echo $form->labelEx($model,'User_ID'); ?>
		<?php echo $form->textField($model,'User_ID',array('value'=>$user,'readonly'=>true)); ?>
		<?php echo $form->error($model,'User_ID'); ?>
	</div><?php */?>




                                                <div class="row" >
                                                    <tr>
                                                        <td><?php echo $form->labelEx($model,'Out_Time'); ?></td>
                                                        <td><?php //echo $form->textField($model,'Out_Time'); ?>
                                                            <?php $this->widget('application.extensions.timepicker.timepicker', array(
                                                                'model'=>$model,
                                                                'name'=>'Out_Time',
                                                            )); ?>
                                                            <?php echo $form->error($model,'Out_Time'); ?></td>
                                                    </tr>
                                                </div>

                                                <div class="row" >
                                                    <tr><td>
                                                            <?php echo $form->labelEx($model,'In_Time'); ?>
                                                        </td><td>
                                                            <?php //echo $form->textField($model,'In_Time'); ?>

                                                            <?php $this->widget('application.extensions.timepicker.timepicker', array(
                                                                'model'=>$model,
                                                                'name'=>'In_Time',
                                                            )); ?>
                                                            <?php echo $form->error($model,'In_Time'); ?>
                                                        </td></tr>
                                                </div>

                                                <div class="row" >
                                                    <tr><td>
                                                            <?php echo $form->labelEx($model,'Mileage'); ?>
                                                        </td><td>
                                                            <?php echo $form->textField($model,'Mileage'); ?>
                                                            <?php echo $form->error($model,'Mileage'); ?>
                                                        </td></tr>
                                                </div>


                                            </table>

                                        </td>
                                        <td >






                                        </td>
                                    </tr>

                                    <tr><td>


                                        </td></tr>

                                </table>
                                <div class="row buttons" style="padding-left:550px;margin-top:20px;">
                                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save'); ?>
                                </div>

                            </div>
                            <?php
                            if(isset(Yii::app()->session['status']) && Yii::app()->session['status'] !='')
                            {
                                unset(Yii::app()->session['status']);
                            }

                            $this->endWidget();

                            ?>

                        </div>
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





