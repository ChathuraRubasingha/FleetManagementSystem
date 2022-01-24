<style>
    .statusDrop
    {
        padding: 3px 0;
        min-width:72px !important;
        border: 1px solid #CCCCCC;
    }
    
    .arrowImg
    {
        float: right;
        transform:rotate(90deg);
        margin-right: 20px;
        -ms-transform:rotate(90deg);
        -moz-transform:rotate(90deg);
        -webkit-transform:rotate(90deg);
        -o-transform:rotate(90deg);
    }
    
    .rotateImg
    {
        float: right;
        margin-right: 20px;
        transform:rotate(270deg);
        -ms-transform:rotate(270deg);
        -moz-transform:rotate(270deg);
        -webkit-transform:rotate(270deg);
        -o-transform:rotate(270deg);
    }
    
    .grid-view table.items tr.selectForBooking
    {
        background-color: #90C0EA !important;
    }

    .grid-view table.items tr.selected
    {
        //background:#49B7F6;
    }
    
    #saveDisapprove,  #saveReject
    {
        margin: 5px;
        width: 75px !important;
    }
    
    .midColon
    {
        width:50px; 
        text-align:center;
    }
    .moreData
    {
        margin-left: 10%;
    }
    .moreDataTD
    {
        padding: 5px;
        font-family: 'courier new';
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
    .names
    {
        font-size:10px;
        text-align:center;
    }

    .img
    {
        border:1px solid #333;
    }
     .DisplayImage
     {
        width:150px;
        height:150px;
        margin-left:40%;
        border:2px #000 solid;
     }

     .vImg
     {
        float:left;
        width:160px;
        height:160px;
     }

     .dImg
     {
        float:left;
        width:160px;
        height:160px;
     }

     .VehicleImages
     {
        float:left;
        width:90% !important;
     }
     .DriverImages
     {
        float:left;
        margin-top:50px !important;
        width:90% !important;
     }

    .col 
    {
        min-height:400px;
        height:auto !important; 
    }

    .even
    {
        background-color: #fff;
    }
</style>

 <?php 	$LocID = Yii::app()->getModule("user")->user()->Location_ID; ?>   
    
<script>

    function getColumnMin(tableId, columnIndex) 
    {
	var table = document.getElementById(tableId);
	var rows = table.getElementsByClassName('rows');
	
	var min = '9013-12-02 06:00:00';
	for (var i = 0; i < rows.length; i++) 
	{
		var cols = rows[i].getElementsByClassName('dta');
		
		var value = (cols[columnIndex].firstChild.nodeValue); // force to integer value
		
		if (value < min)
		min = value;
	}
        return min;
    }

    function getColumnMax(tableId, columnIndex) 
    {
	var table = document.getElementById(tableId);
	var rows = table.getElementsByClassName('rows');
	
	var max = '0013-12-02 06:00:00';
	for (var i = 0; i < rows.length; i++) 
	{
            var cols = rows[i].getElementsByClassName('dta');

            var value = (cols[columnIndex].firstChild.nodeValue); // force to integer value

            if (value > max)
            max = value;
	}
        return max;
    }

    function getTimeDiff(tableId, columnIndex) 
    {
        var table = document.getElementById(tableId);
        var rows = table.getElementsByClassName('rows');

        var min = '9013-12-02 06:00:00';
        for (var i = 0; i < rows.length; i++) 
        {
            var cols = rows[i].getElementsByClassName('dta');

            var value = (cols[columnIndex].firstChild.nodeValue); // force to integer value

            if (value < min)
            min = value;
        }

        return min;
    }



    $(document).ready(function()
    {
        var height = $("body").height();        
       
        $('#saveDisapprove').click(function()
        {
            var reason = $('#txtDisapproveReason').val();
            var reqID = $('#txtReqestID').val();

            if(reason !== '')
            {
                $.ajax
                ({
                    type:'POST',
                    url : '<?php echo Yii::app()->createAbsoluteUrl("TRVehicleBooking/DisapproveBookingRequest"); ?>',
                    data : {'reqID':reqID,'reason':reason},
                    success : function(data)
                    {
                        if(data === 'OK')
                        {
                            $(".ontop").height(height);
                            $("#errorConfirm").fadeIn(500);
                            $('#errorConfirm p').html('Successfully Disapproved...!');
                            $("#popDiv").fadeIn(500);
                            setTimeout(function()
                            {
                                location.reload();
                            },3000);
                        }
                        else
                        {
                            $(".ontop").height(height);
                            $("#Confirm").fadeIn(500);
                            $('#Confirm p').html('Error occured. Please try again');
                            $("#popDiv").fadeIn(500);
                        }
                    },                   
                    dataType : 'html'

                });
            }
            else
            {
                $(".ontop").height(height);
                $("#errorConfirm").fadeIn(500);
                $('#errorConfirm p').html('Reason is required');
                $("#popDiv").fadeIn(500);
            }
        });
         
        $('#saveReject').click(function()
        {
            var reason = $('#txtRejectReason').val();
            var reqID = $('#txtReqestID').val();
            
            if(reason !== '')
            {
                $.ajax
                ({
                    type:'POST',
                    url:'<?php echo Yii::app()->createAbsoluteUrl('TRVehicleBooking/RejectBookingRequest');?>',
                    data:{'reqID':reqID, 'reason':reason},
                    success:function(data)
                    { 
                        if(data === 'ok')
                        {                            
                            $(".ontop").height(height);
                            $("#Confirm").fadeIn(500);
                            $('#Confirm p').html('Successfully Rejected...!');
                            $("#popDiv").fadeIn(500);
                            setTimeout(function()
                            {
                                location.reload();
                            },3000);
                        }
                        else
                        {
                            $(".ontop").height(height);
                            $("#Confirm").fadeIn(500);
                            $('#Confirm p').html('Error occured. Please try again');
                            $("#popDiv").fadeIn(500);
                        }
                    },
                    error:function(data)
                    {
                    },
                    dataType:'html'
                }); 
                
            }
            else
            {
                $(".ontop").height(height);
                $("#errorConfirm").fadeIn(500);
                $('#errorConfirm p').html('Reason is required');
                $("#popDiv").fadeIn(500);
            }
        });
        
        $('#btnConfirmCancel').click(function()
        {
            $('.flashMsg').hide();
            $(".statusDrop option[value='Pending']").prop("selected","selected");
            return false;
        });
        
        $('#btnConfirmOk').click(function()
        {
            var reqID = $('#txtReqestID').val();
            $.ajax
            ({
                type:'POST',
                url : '<?php echo Yii::app()->createAbsoluteUrl("TRVehicleBooking/ApproveBookingRequest"); ?>',
                data : {'reqID':reqID},
                success : function(data)
                {
                    if(data === 'ok')
                    {
                        $(".ontop").height(height);
                        $("#errorConfirm").fadeIn(500);
                        $('#errorConfirm p').html('Successfully Approved...!');
                        $("#popDiv").fadeIn(500);
                        setTimeout(function()
                        {
                            location.reload();
                        },3000);
                    }
                    else
                    {
                        $(".ontop").height(height);
                        $("#errorConfirm").fadeIn(500);
                        $('#errorConfirm p').html('Error Occured. Please try again');
                        $("#popDiv").fadeIn(500);
                    }
                },                   
                dataType : 'html'

            });
        });
	
    });


    function showFancyPop(e)
    {
        var height = $("body").height();
        var reqID = $(e).parents().eq(1).children().eq(0).html();
        $('#txtReqestID').val(reqID);
        
        var val = $(e).val();

        if(val === 'Disapprove')
        {           
            $('#statusPopShow').trigger('click');
        }
        else if(val === 'Approve')
        {
            $("#popDiv").height(height);
            $("#Confirm").fadeIn(500);
            $('#Confirm p').html('Are you sure you want to approve above request(s)?');
            $("#popDiv").fadeIn(500);
        }

    }

    function showRejectPop(e)
    {
        var reqID = $(e).parents().eq(1).children().eq(0).html();
        $('#txtReqestID').val(reqID);
        var val = $(e).val();

        if(val === 'Reject')
        {
            $('#txtReqestID').val(reqID);
            $('#rejReq').trigger('click');
        }

    }
    
    function showApprovedBookings(e)
    {
        var txt = $(e).html();
        if(txt === "View History")
        {
            $(e).html("Hide History");
            $('#arrow').removeClass('arrowImg').addClass('rotateImg');
        }
        else
        {
            $(e).html("View History");
            $('#arrow').removeClass('rotateImg').addClass('arrowImg');
        }
        $('#approvedBoodings').toggle('200');
    }

    $(".fancybox").fancybox(
    {
        maxWidth: 700,
        maxHeight: 500,
        minWidth: 200,
        minHeight: 100,
        fitToView: false,
        autoSize: false,
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
            $(".statusDrop option[value='Pending']").prop("selected","selected");
            $(".RejectDrop option[value='Approved']").prop("selected","selected");
        },
        //'onStart': function() {$("body").css({'overflow':'hidden'});},
        //'onClosed': function() {$("body").css({"overflow":"visible"});},
        helpers: {overlay: {locked: true}}
    });/**/
        

</script>


<!--    Show More Details Pop-up    -->
<a href="#moreDetails" class="fancybox" id="viewMore" style="display:none;">View</a>
<div  id="moreDetails"  style="display: none; width: auto; height: auto; margin-left: 10px;">
</div>

<!--    Show Disapprove Pop-up    -->
<a href="#statusPop" class="fancybox" id="statusPopShow" style="display:none;">View</a>
<div  id="statusPop"  style="display: none; margin-top: -18px; background-color: rgb(234, 234, 234); width: 500px; height: auto; margin-left: 0px;">
    <center>
        <h3 class="viewMoreHeader" style="font-size: 20px; height: 50px; padding: 0 10px; line-height: 2"><b>Disapprove Booking Request</b></h3>
        <div style="width:100%; height: 25px; margin-top: -10px; background-color: #fff;"></div>
        <br/>
        <p style="text-align: left;">Reason is required</p>
        <table width="400px">
            <tr>
                <td>Reason</td>
                <td style="width:300px"><?php echo CHtml::textArea('Disapprove_Reason', '', array('cols'=>50, 'rows'=>3, 'id'=>'txtDisapproveReason'))?></td>

            </tr>
            <tr>
                <td></td>
                <td><?php echo CHtml::button('Disapprove',array('id'=>'saveDisapprove')); ?></td>
            </tr>
        </table>
        <div style="width:100%; height: 25px; background-color: #495059;"></div>
    </center>
    
</div> 
      
<!--    Show Reject Pop-up    -->
<a href="#rejectReq" class="fancybox" id="rejReq" style="display:none;">View</a>
<div  id="rejectReq"  style="display: none; margin-top: -18px; background-color: rgb(234, 234, 234); width: 500px; height: auto; margin-left: 0px;">
    
    <center><h3 class="viewMoreHeader" style="font-size: 20px; height: 50px; padding: 0 10px; line-height: 2"><b>Reject Approved Booking Request</b></h3>
        <div style="width:100%; height: 25px; margin-top: -10px; background-color: #fff;"></div>
        <br/>
        <p style="text-align: left;">Reason is required</p>
        <table width="400px">
        <tr>
            <td>Reason</td>
            <td style="width:300px"><?php echo CHtml::textArea('Reject_Reason', '', array('cols'=>50, 'rows'=>3, 'id'=>'txtRejectReason'))?></td>
            
        </tr>
        <tr>
            <td><?php //echo CHtml::hiddenField('','', array('id'=>'txtReqestID')); ?></td>
            <td><?php echo CHtml::button('Reject',array('id'=>'saveReject')); ?></td>
            
            
        </tr>
    </table>
    <div style="width:100%; height: 25px; background-color: #495059;"></div>
    </center>
    
</div> 

 
    
<?php
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
 echo CHtml::hiddenField('','', array('id'=>'txtReqestID')); ?>

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view">
            
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading large" style="color:#fff; background: #c21118">
                        <h1  class="panel-title" itemprop="name">Booking Requests for Approval</h1>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4 style="font-weight: bold;">Pending Vehicle Booking Requests</h4>
                       
                            <div style="width:auto;">
                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id'=>'trvehicle-booking-grid',
                                    'dataProvider'=>$model->getPendingBookingRequests(),
                                    'columns'=>array(
                                    array('name'=>'Booking_Request_ID', 'header'=>'Request ID', 'value'=>'$data->Booking_Request_ID', 'visible'=>true, 'htmlOptions'=>array('id'=>"reqID")),
                                    array('name'=>'username', 'header'=>'Requested By', 'value'=>'$data->user->profile->firstname'),
                                    //array('header'=>'Branch', 'value'=>'$data->user->Branch_Id ==0 ? "-" : $data->user->branch->Branch'),
                                    'Vehicle_No',
                                    'Driver_ID',
                                    array('name'=>'Requested vehicle Category', 'header'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
                                    'Place_from',
                                    'Place_to',
                                    array('name'=>'From',  'value'=>'$data->From', 'htmlOptions'=>array('id'=>'frmDate')),
                                    'To',
                                    /*array(

                                        'name' =>'select',
                                        'class'=>'CDataColumn',
                                        'value' => 'CHtml::checkBox("BookingIds[]",null,array("value"=>$data->Booking_Request_ID,"class"=>"chkBox", "id"=>$data->Booking_Request_ID))',
                                        'type'=>'raw',
                                        'htmlOptions' => array('width'=>5),
                                   ),*/
                                    array(
                                        'name' => 'Status',
                                        'type' => 'raw',
                                        'value' => "CHtml::dropDownlist('','', array('Pending'=>'Pending','Approve'=>'Approve', 'Disapprove'=>'Disapprove'), array('class'=>'statusDrop', 'onchange'=>'showFancyPop(this)'))",
                                    ),
                                   array(
                                    'class' => 'CButtonColumn',
                                    'template' => '{view}',
                                    'buttons' => array
                                    (
                                        'view' => array
                                        (
                                            'url' => '""', 
                                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/ScheduleofMachineReport.png',
                                            'options'=>array('title'=>'More Details','style'=>'width:20px; height:20px'),
                                            'click' => 'function()
                                            {                             
                                               var reqID = $(this).parents().eq(1).children().eq(0).html();
                                               //var Pclass = $(this).parents("#reqID").html();
                                                $.ajax
                                                ({
                                                type: "post",
                                                    url: "'. $this->createAbsoluteUrl("TRVehicleBooking/getOtherBookingDetails").'",

                                                    dataType: "html",
                                                    data: {"reqID": reqID, "status":"Pending"},
                                                    success: function(data)
                                                    {
                                                        $("#moreDetails").html(data);
                                                        $("#viewMore").trigger("click");
                                                    }
                                                });                           


                                                return true;                        
                                            }',
                                        ),
                                    ),
                                )

                                    ),
                                ));?>
                                
                            </div>
                        <div style="text-align: right; margin-top: 10px; float: right;"><img id="arrow" class="arrowImg" src="images/dbarrow.png"/><p onclick="showApprovedBookings(this)" style="font-weight: bolder; cursor: pointer; width: 200px; padding-right: 60px;">View History</p></div>
                        <div id="approvedBoodings" style="display: none; margin-top: 50px;">
                                <h4 style="font-weight: bold;">Approved Booking Requests (Not Assigned Yet)</h4>
                                <?php 
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                    'id'=>'trvehicle-booking-approved-grid',
                                    'dataProvider'=>$model->getApprovedBookingRequestsDashBoard(),
                                    'columns'=>array(

                                    array('name'=>'Booking_Request_ID', 'header'=>'Request ID', 'value'=>'$data->Booking_Request_ID', 'visible'=>true, 'htmlOptions'=>array('id'=>"reqID")),
                                   // array('name'=>'username', 'header'=>'Requested By', 'value'=>'$data->user->profile->firstname'),
                                    //array('header'=>'Branch', 'value'=>'$data->user->Branch_Id ==0 ? "-" : $data->user->branch->Branch'),
                                    'Place_from',
                                    'Place_to',
                                    array('name'=>'From',  'value'=>'$data->From', 'htmlOptions'=>array('id'=>'frmDate')),
                                    'To',
                                    array(
                                        'name' => 'Status',
                                        'type' => 'raw',
                                        'value' => "CHtml::dropDownlist('','', array('Approved'=>'Approved', 'Reject'=>'Reject'), array('class'=>'RejectDrop', 'onchange'=>'showRejectPop(this)'))",
                                    ),
                                    /*array(			  
                                        'name' =>'select',
                                        'class'=>'CDataColumn',
                                        'value' => 'CHtml::checkBox("BookingIds[]",null,array("value"=>$data->Booking_Request_ID,"class"=>"chkBoxAssign", "id"=>$data->Booking_Request_ID))',
                                        'type'=>'raw',
                                        'htmlOptions' => array('width'=>5),
                                      ),*/
                         
                                    array(
                                    'class' => 'CButtonColumn',
                                    'template' => '{view}',
                                    'buttons' => array
                                    (
                                        'view' => array
                                        (
                                            'url' => '""', 
                                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/ScheduleofMachineReport.png',
                                            'options'=>array('title'=>'More Details','style'=>'width:20px; height:20px'),
                                            'click' => 'function()
                                            {                             
                                               var reqID = $(this).parents().eq(1).children().eq(0).html();
                                               //var Pclass = $(this).parents("#reqID").html();
                                                $.ajax
                                                ({
                                                    type: "post",
                                                    url: "'. $this->createAbsoluteUrl("TRVehicleBooking/getOtherBookingDetails").'",
                                                    dataType: "html",
                                                    data: {"reqID": reqID, "status":"Pending"},
                                                    success: function(data)
                                                    {
                                                        $("#moreDetails").html(data);
                                                        $("#viewMore").trigger("click");

                                                    }
                                                });                           


                                                return true;                        
                                            }',
                                        //'click'=>'($data->Approval==="0")? function(){ alert("OOOKKK")}:function(){ $("#approvalAlert").hide()}',
                                        //'url'=>'Yii::app()->createUrl("/Report/ResidenceChaCertificate",  array("ReportGridMemberID" =>$data["Member_ID"],))',
                                        ),
                                    ),
                                )

                            ),
                        )); ?>
                            </div>
                        </div>
                    </div>




            </div>
            
        </div>

    </div>
</div>