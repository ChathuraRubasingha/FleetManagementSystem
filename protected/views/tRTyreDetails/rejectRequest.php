
<?php

    $vehicleId = Yii::app()->session['maintenVehicleId'];
    $reqID = Yii::app()->request->getQuery('tyreDetailsId');

?>

   

<script type="text/javascript">
    $(document).ready(function()
    {
        var reject = false;
        var height = $("body").height();

        $('#btnConfirmOk').click(function()
        {
            var reason = $('#TRTyreDetails_Status_Reason').val();
            //alert(reason);
            if(reject)
            {
               $.ajax
               ({
                   type : 'POST',
                   url  : '<?php echo Yii::app()->createAbsoluteUrl("tRTyreDetails/reject") ?>',
                   data : {'ReqID':'<?php echo $reqID; ?>', "reason":reason},
                   success : function(data)
                   {
                       if(data === 'OK')
                       {
                           $(".ontop").height(height);
                           $("#errorConfirm").fadeIn(500);
                           $('#errorConfirm p').html('Successfully Rejected');
                           $("#popDiv").fadeIn(500);

                          setTimeout(function()
                          {
                              gotoPreviousUrl();
                          },3000);
                      }
                      else
                      {
                          alert('Please Try Again');
                      }
                   }
               });            
            }
        });


       $('#Reject_btn').click(function()
       {
           var reason = $('#TRTyreDetails_Status_Reason').val();

           $("#popDiv").height(height);
           $("#Confirm").fadeIn(500);

           if(reason === '')
           {
               $('.tblRow').show();
               $('#Confirm p').html('Reject Reason is required');
           }
           else
           {
               reject = true;
               $('#Confirm p').html('Are you sure you want to reject above request(s)?');
           }

           $("#popDiv").fadeIn(500);
           return false;

       });

       $('#Exit_btn').click(function()
       {
           gotoPreviousUrl();
       });
   });

function gotoPreviousUrl()
{
    var base = '<?php echo Yii::app()->request->baseUrl; ?>';
   window.location = base+"/index.php?r=TRTyreDetails/DashboardApprovedTyreRequests";    
}
 </script>
    
                  
                
                
 <div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            
            
            <div class="col-xs-11">


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Reject Approved Tyre Request</h1>
                    </div>

                    <div class="panel-body">

                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                array('label'=>'Driver', 'value'=>$request->driver->Full_Name),
                                array('label'=>'Tyre Type', 'value'=>$request->tyreType->Tyre_Type),
                                array('label'=>'Tyre Size', 'value'=>$request->tyreSize->Tyre_Size),
                                'Tyre_quantity',
                                'Approved_By',
                                'Approved_Date',
                            ),
                        )); ?>

 <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'TRTyre-Details-form',
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

                            <?php echo CHtml::submitbutton('Reject', array('id'=>'Reject_btn', 'style'=>'margin-right:0px !important')); ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo CHtml::submitbutton('Exit', array('id'=>'Canceled_btn')); ?>
                        </div>
                        
                    </div>
                </div>




            </div>
            
        </div>

    </div>
</div>               




		
