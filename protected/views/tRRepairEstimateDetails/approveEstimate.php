<style>

    input[type="submit"]
    {
        margin-right: 0px;
    }

</style>

<script type="text/javascript">
    $(document).ready(function()
    {
        var approved = false;
        var disapproved = false;
        var height = $("body").height();

        $('#Approve_btn').click(function()
        {
            approved = true;
            disapproved = false;
            $('.tblRow').hide();
            $("#popDiv").height(height);
            $("#Confirm").fadeIn(500);
            $('#Confirm p').html('Are you sure you want to approve above request(s)?');
            $("#popDiv").fadeIn(500);
            return false;
        });

        $('#btn_disapprove').click(function()
        {
            var reason = $('#TRRepairEstimateDetails_Estimate_Status_Reason').val();
            approved = false;
            
            $("#popDiv").height(height);
            $("#Confirm").fadeIn(500);
            if(reason =='')
            {
                $('.tblRow').show();
                $('#Confirm p').html('Disapprove Reason is required');
            }
           else
            {
                
                disapproved = true;
                
                $('#Confirm p').html('Are you sure you want to disapprove above request(s)?');
            }
            
            $("#popDiv").fadeIn(500); /**/
            return false;

        });


        $('#btnConfirmOk').click(function()
        {
            var reason = $('#TRRepairEstimateDetails_Estimate_Status_Reason').val();
            var estID = '<?php echo Yii::app()->request->getQuery('estimateId'); ?>';

            if(approved)
            {
                $.ajax
                ({
                    type:'POST',
                    url:'<?php echo Yii::app()->createAbsoluteUrl('TRRepairEstimateDetails/approve');?>',
                    data:{'estID':estID},
                    success:function(data)
                    {
                        $(".ontop").height(height);
                        $("#errorConfirm").fadeIn(500);
                        $('#errorConfirm p').html('Successfully Approved');
                        $("#popDiv").fadeIn(500);
                    },
                    error:function(data)
                    {
                        return false;
                    },
                    dataType:'html'
                });


               setTimeout(function(){
                    gotoPerviousUrl()
               },3000);
            }
            if(disapproved)
            {
                $.ajax
                ({
                    type:'POST',
                    url:'<?php echo Yii::app()->createAbsoluteUrl('TRRepairEstimateDetails/disapprove');?>',
                    data:{'estID':estID, 'reason':reason},
                    success:function(data)
                    {
                        $(".ontop").height(height);
                        $("#errorConfirm").fadeIn(500);
                        $('#errorConfirm p').html('Successfully Disapproved');
                        $("#popDiv").fadeIn(500);

                    },
                    error:function(data)
                    {
                        //alert('err');
                    },
                    dataType:'html'
                });


                setTimeout(function()
                {
                    gotoPerviousUrl()
                },3000);
            }


        });

		
        $('#Cancel_btn').click(function()
        {
            location.reload();
        });
	
    });
    
    function gotoPerviousUrl()
    {
        var loc = '<?php echo Yii::app()->baseUrl; ?>';
        window.location = loc+"/index.php?r=TRRepairEstimateDetails/DashboardPendingRepair";
    }

</script>


 


<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            
            
            <div class="col-xs-11">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Approve Repair Estimate</h1>
                    </div>

                    <div class="panel-body">
                        
                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                'Vehicle_No',
                                array('label'=>'Driver', 'value'=>$request->request->driver->Full_Name),
                                array('label'=>'Description', 'value'=>$request->request->Description_Of_Failure =='' ? '-' : $request->request->Description_Of_Failure ),
                                array('label'=>'Requested Date', 'value'=>$request->request->Request_Date),
                                array('label'=>'Request Status', 'value'=>$request->request->Request_Status),
                                'Estimate_Date',
                                array('label'=>'Garage', 'value'=>$request->garage->Garage_Name),
                                array('name' => 'Total_Estimate','value'=> number_format($model->Total_Estimate,2),),


                            ),
                        )); ?>
                        
                        
                        <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'trvehicle-booking-form',
                            'enableAjaxValidation'=>false,
                        )); ?>





  <br/> <br/> <br/> 
  <div class="tblRow" style="display: none;">
        <div class="tdOne"><?php echo CHtml::label('Disapprove Reason', 'Estimate_Status_Reason'); ?></div>
            <div class="tdTwo"><?php echo $form->textArea($model, 'Estimate_Status_Reason', array('rows' => 2, 'cols' => 56)); ?>
                <?php //echo $form->error($model, 'Estimate_Status_Reason'); ?></div>
        </div>
   
         <br/> <br/> <br/>

                        <div class="row buttons" style="margin-top: 10px; float: left; margin-left: 413px; ">
                            <?php echo CHtml::submitbutton('Approve', array('id'=>'Approve_btn')); ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo CHtml::submitbutton('Disapprove', array('id'=>'btn_disapprove')); ?>
                        </div>
                             <?php $this->endWidget(); ?>
                    </div>
                </div>
            
            </div>

        </div>
    </div>
</div>