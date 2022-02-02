
<?php
    $vehicleId = Yii::app()->session['VehicleIdFuel'];
    $requestid = Yii::app()->session['requestId'];
    $aid=Yii::app()->session['VehicleIdAllocationID'];
?>
<script type="text/javascript">
    
    $(document).ready(function()
    {
        var approved = false;
        var disapproved = false;
        var height = $("body").height();

        $('#Approve_btn').click(function()
        {
            approved = true;
            $(".ontop").height(height);
            $("#Confirm").fadeIn(500);
            $('#Confirm p').html('Are you sure you want to approve this request?');
            $("#popDiv").fadeIn(500);

        });
        $('#Disapprove_btn').click(function()
        {
            var reason = $('#TRFuelRequestDetails_Status_Reason').val();
            approved = false;
            
            $("#popDiv").height(height);
            $("#Confirm").fadeIn(500);
            if(reason === '')
            {
                $('.tblRow').show();
                $('#Confirm p').html('Disapprove Reason is required');
            }
           else
            {
                
                disapproved = true;
                
                $('#Confirm p').html('Are you sure you want to disapprove above request?');
            }
            
            $("#popDiv").fadeIn(500); /**/
            return false;

        });
        
        
        $('#btnConfirmOk').click(function()
        {
            if(approved)
            {
                $.ajax
                ({
                    type:'POST',
                    url:'<?php echo Yii::app()->createAbsoluteUrl('tRFuelRequestDetails/approve');?>',
                    data:{'reqID':'<?php echo $requestid; ?>'},
                    success:function(data)
                    {
                        if(data === "OK")
                        {
                            $(".ontop").height(height);
                            $("#errorConfirm").fadeIn(500);
                            $('#errorConfirm p').html('Successfully Approved');
                            $("#popDiv").fadeIn(500);
                            
                            setTimeout(function()
                            {
                                gotoPerviousUrl();
                            },3000);
                        }
                    },
                    error:function(data)
                    {
                        return false;
                    },
                    dataType:'html'
                });
                
                
            }
            if(disapproved)
            {
                var reason = $('#TRFuelRequestDetails_Status_Reason').val();
                $.ajax
                ({
                    type:'POST',
                    url:'<?php echo Yii::app()->createAbsoluteUrl('tRFuelRequestDetails/disapprove');?>',
                    data:{'reqID':'<?php echo $requestid; ?>', 'reason':reason},
                    success:function(data)
                    {
                        if(data === "OK")
                        {
                            $(".ontop").height(height);
                            $("#errorConfirm").fadeIn(500);
                            $('#errorConfirm p').html('Successfully Disapproved');
                            $("#popDiv").fadeIn(500);
                            
                            setTimeout(function()
                            {
                                gotoPerviousUrl();
                            },3000);
                        }

                    },
                    error:function(data)
                    {
                        //alert('err');
                    },
                    dataType:'html'
                });
                
            }


        });
    });

    function gotoPerviousUrl()
    {
        var loc = '<?php echo Yii::app()->baseUrl; ?>';
        window.location = loc+"/index.php?r=TRFuelRequestDetails/dashboardPendingFuelRequests";
    }
</script>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            
            
            <div class="col-xs-11">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Approve Fuel Requests</h1>
                    </div>

                    <div class="panel-body">
                        
                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                'Request_Date',
                                'Vehicle_No',
                                array('label'=>'Driver', 'value'=>$request->driver->Full_Name),
                                'Required_Fuel_Capacity',

                            ),
                        )); ?>

                        <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'TRFuel-Request-form',
                            'enableAjaxValidation'=>false,
                        )); ?>

               
                        <div class="tblRow" style="display: none;">
                            <br/> <br/> <br/> 
                            <div class="tdOne"><?php echo CHtml::label('Disapprove Reason', 'Status_Reason'); ?></div>
                            <div class="tdTwo"><?php echo $form->textArea($model, 'Status_Reason', array('rows' => 2, 'cols' => 56)); ?>
                              <?php //echo $form->error($model, 'Estimate_Status_Reason'); ?></div>
                        </div>

                       <br/> <br/> <br/>
                       
                        <?php $this->endWidget(); ?>
                       
                        <div class="row buttons" style="margin-left:40%; margin-top:10px">

                            <?php echo CHtml::submitbutton('Approve', array('id'=>'Approve_btn', 'style'=>'margin-right:0px !important')); ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo CHtml::submitbutton('Disapprove', array('id'=>'Disapprove_btn')); ?>
                        </div>

                    </div>
                </div>
            
            </div>

        </div>
    </div>
</div>