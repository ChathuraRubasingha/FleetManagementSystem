<style>
    #saveReject
    {
        width: 75px !important;
        margin: 5px;
    }
    .statusDrop
    {
        padding: 3px 0;
        min-width:72px !important;
        border: 1px solid #CCCCCC;
    }
    
    .viewMoreHeader
    {
        color:#FFFFFF; 
        background:#0099FF; 
        text-align:center;
/*        border-radius: 10px;*/
        font-family: 'courier new';
        font-weight: bold;
    }
</style>

<script>
    
    $(document).ready(function()
    {
        var height = $("body").height() ;
        
        $('#saveReject').click(function()
        {
            var reason = $('#txtReason').val();
            var reqID = $('#txtReqestID').val();
            
            if(reason !== '')
            {
                $.ajax
               ({
                   type : 'POST',
                   url  : '<?php echo Yii::app()->createAbsoluteUrl("tRFuelRequestDetails/reject") ?>',
                   data : {'ReqID':reqID, "reason":reason},
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
                               location.reload();
                           },4000);
                        }
                        else
                        {
                            $(".ontop").height(height);
                            $("#errorConfirm").fadeIn(500);
                            $('#errorConfirm p').html('Error occured. Please try again.');
                            $("#popDiv").fadeIn(500);
                        }
                    }
                });
                
            }
            else
            {
                $(".ontop").height(height);
                $("#errorConfirm").fadeIn(500);
                $('#errorConfirm p').html('Reason is required');
                $("#popDiv").fadeIn(500);
                //alert("Please specify the reason...!");
            }
        });
    });
    
    function showRejectPop(e)
    {
        var reqID = $(e).parents().eq(1).children().eq(0).html();
        var val = $(e).val();

        if(val === 'Reject')
        {
            $('#txtReqestID').val(reqID);
            $('#rejReq').trigger('click');
        }

    }
    
    $(".fancybox").fancybox(
        {
            maxWidth: 700,
           // maxHeight: 500,
            minWidth: 200,
            minHeight: 100,
            fitToView: false,
            //autoSize: false,
            width: '60%',
            height: '70%',
            autoSize	: true,
                    //scrolling   : 'visible',
            closeClick: false,
            'centerOnScroll': true,
            openEffect: 'none',
            closeEffect: 'none',
            scrolling: 'hidden',
            /*onComplete: function() {
             $(document).scrollTop(0);
             },*/

            //beforeLoad: function(){$("body").css({"overflow-y":"auto"});},
            afterClose: function() {
                $("body").css({"overflow-y": "auto"});
                $(".statusDrop option[value='Approved']").prop("selected","selected");
            },
            //'onStart': function() {$("body").css({'overflow':'hidden'});},
            //'onClosed': function() {$("body").css({"overflow":"visible"});},
            helpers: {overlay: {locked: true}}
        });
</script>


<a href="#rejectReq" class="fancybox" id="rejReq" style="display:none;">View</a>
<div  id="rejectReq"  style="display: none; margin-top: -18px; background-color: rgb(234, 234, 234); width: 500px; height: auto; margin-left: 0px;">
    
    <center><h3 class="viewMoreHeader" style="font-size: 20px; height: 50px; padding: 0 10px; line-height: 2"><b>Reject Approved Booking Request</b></h3>
        <div style="width:100%; height: 25px; margin-top: -10px; background-color: #fff;"></div>
        <br/>
        <p style="text-align: left;">Reason is required</p>
        <table width="400px">
        <tr>
            <td>Reason</td>
            <td style="width:300px"><?php echo CHtml::textArea('Reject_Reason', '', array('cols'=>50, 'rows'=>3, 'id'=>'txtReason'))?></td>
            
        </tr>
        <tr>
            <td><?php echo CHtml::hiddenField('','', array('id'=>'txtReqestID')); ?></td>
            <td><?php echo CHtml::button('Reject',array('id'=>'saveReject')); ?></td>
            
            
        </tr>
    </table>
    <div style="width:100%; height: 25px; background-color: #495059;"></div>
    </center>
    
</div>            



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <div class="panel panel-default">
                   <div class="panel-heading large" style="color:#fff; background: #fa7753">
                        <h1 class="panel-title" itemprop="name">Approved Fuel Requests</h1>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12">

                <div class="panel panel-default">
                  

                    <div class="panel-body">
                        
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'trfuel-request-details-grid',
                            'dataProvider'=>$model->getFuelApprovedListDashBoard(),
                            'columns'=>array(
                                'Fuel_Request_ID',
                                'Request_Date',
                                'Vehicle_No',
                                array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
                                array('name'=>'Driver', 'header'=>'Driver Name', 'value'=>'$data->driver->Full_Name'),
                                'Required_Fuel_Capacity',
                                'Fuel_Balance',
                                'Meter_Reading',
                                array(
                                    'name' => 'Status',
                                    'type' => 'raw',
                                    'value' => "CHtml::dropDownlist('','', array('Approved'=>'Approved', 'Reject'=>'Reject'), array('class'=>'statusDrop', 'onchange'=>'showRejectPop(this)'))",
                                  ),
                                /*array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/tRFuelRequestDetails/rejectRequest", array("requestId" =>     
                                    $data["Fuel_Request_ID"],"vid" =>     
                                    $data["Vehicle_No"]))',
                                ),*/

                            ),
                    )); ?>

                    </div>
                </div>
            
            </div>

        </div>
    </div>
</div>