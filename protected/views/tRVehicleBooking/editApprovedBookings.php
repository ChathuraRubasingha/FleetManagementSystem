<style>
    .grid-view table.items tr.selectForBooking
    {
        background-color: #90C0EA !important;
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
    #saveReject
    {
        width: 75px !important;
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
        //border-radius: 10px;
        font-family: 'courier new';
        font-weight: bold;
    }
    
    #fancybox-loading div 
    {
        position: fixed;
        top: 0;
        left: 51%;
        width: 40px;
        height: 480px;
        background-image:url('fancy/fancybox_loading@2x.gif');
    }
    .dropdwn
    {
        width: 200px;
    }
    .bttnn
    {
        width: 100px;
    }
    .names
    {
        font-size:10px;
        text-align:center;
    }

    th
    {
        border-bottom:1px solid #CCC; 
        padding-top:30px;
    }

    .tbl
    {
        border:1px solid #CCC; 
        padding:10px;
        background:none repeat scroll 0 0 #F3F3F3;
    }
    thead
    {
        background:none repeat scroll 0 0 #fff;
    }
    td
    {
        padding:5px !important;
    }
    .even
    {
            background: #fff;
    }
    /*.odd
    {
            background: #fff;
    }*/
    .col 
    {
        min-height:400px;
        height:auto !important; 
    }

    select
    {
        border-radius: 0 !important;
        box-shadow: none !important;
        border: 1px solid #0099FF !important;
    }
</style>

<?php

    $LocID = Yii::app()->getModule("user")->user()->Location_ID;

    $vehicleNo = Yii::app()->request->getQuery('VNo');
    $ApproveID = Yii::app()->request->getQuery('ApproveID');
    $driver = Yii::app()->request->getQuery('drvr');

?>


 <script>
     
    $(document).ready(function()
    {
        var approveID='<?php echo $ApproveID; ?>';
        var appVehicle='<?php echo $vehicleNo; ?>';
        var height = $("body").height() ;
        //var approvedVehicle= appVehicle.replace(/\+/g," ");
        var approvedDriver='<?php echo $driver; ?>';

	$.ajax(
        {
            type:'POST',
            url:"<?php echo Yii::app()->createAbsoluteUrl("TRVehicleBooking/ApprovedRequestsForApproval")?>",
            data:{'id':approveID, 'appVehicle':appVehicle, 'approvedDriver':approvedDriver},
            success: function(data)
            {
                $('#requestsForAssign').html(data.rows);               

                $('#Vehicle_No').html(data.vehicles);
                $('#Driver_ID').html(data.drivers);

            },
            error:function()
            {
               //alert('error');
            },
            dataType:'json'
	});
        
        
      
        
        $('.items tr').die('click').live('click',function(){
            var cls = $(this).attr("class");
            $(this).removeClass('selected');
        });
       
         


	$('.chkBox').click(function()
	{
            var ids = new Array();
            var id = (this).id;
            if($("#"+id).attr("checked"))
            {
                $(this).parent().parent().addClass("selectForBooking");
                //$("#"+id).attr("checked","checked");
                //ids.push(id);
            }
            else
            {
                $(this).parent().parent().removeClass("selectForBooking");
                //ids.pop(id);
            }
            
            $('.chkBox').each(function(e)
            {
                var bookId =this.id;

                if($('#'+bookId).attr("checked"))
                {
                    ids.push(bookId);
                }

            });
            var count = ids.length;
            //alert(count);
            //$('.btns').show();
            if(count ==0)
            {
                location.reload(); // to reload the vehicle numbers and drivers
               //$('.btns').hide();
            }
            else
            {
                
            }
            
            $.ajax(
            {
                type:'POST',
                url:"<?php echo Yii::app()->createAbsoluteUrl("TRVehicleBooking/RequestsForApproval")?>",
                data:{'approveID':approveID,'ids':ids, 'appVehicle':appVehicle, 'approvedDriver':approvedDriver},
                success: function(data)
                {
                    $('#requestsForAssign').html(data.rows);               

                    $('#Vehicle_No').html(data.vehicles);
                    $('#Driver_ID').html(data.drivers);

                },
                error:function()
                {
                   //alert('error');
                },
                dataType:'json'
            });
            
        });


                var assign = false;
                var disapproved = false;
               
		$('#Approve_btn').click(function()
		{
                    var vNo = $('#Vehicle_No').val();
                    var driver = $('#Driver_ID').val();

                    if(vNo === '')
                    {
                        //Svar height = $("body").height() ;//- $("#header").height() + $("#footer").height()
                        $(".ontop").height(height);
                        $("#errorConfirm").fadeIn(500);
                        $('#errorConfirm p').html('Please Select a Vehicle Number...!');
                        $("#popDiv").fadeIn(500);
                    }
                    else if(driver === '')
                    {
                        //var height = $("body").height() ;//- $("#header").height() + $("#footer").height()
                        $(".ontop").height(height);
                        $("#errorConfirm").fadeIn(500);
                        $('#errorConfirm p').html('Please Select a Driver Name...!');
                        $("#popDiv").fadeIn(500);
                    }
                    else
                    {
                        assign = true;
                        disapproved = false;
                        
                        $(".ontop").height(height);
                        $("#Confirm").fadeIn(500);
                        $('#Confirm p').html('Are you sure you want to Assign this request?');
                        $("#popDiv").fadeIn(500);
                    }

		});

		$('#btnConfirmOk').click(function()
		{
                    if(assign)
                    {
                        var minDate = getColumnMin('AssignListTable', '3');
                        var maxToDate = getColumnMax('AssignListTable', '4');

                        var vNo = $('#Vehicle_No').val();
                        var driver = $('#Driver_ID').val();

                        var ids = new Array();
                        ids = getBookIDs('AssignListTable', '0');

                        $.ajax
                        ({
                            type:'POST',
                            url:'<?php echo Yii::app()->createAbsoluteUrl('TRVehicleBooking/AssignDriverAndVehicle');?>',
                            data:{'ids':ids, 'NewBookingDate':minDate, 'maxToDate':maxToDate, 'vNo':vNo, 'driver':driver, 'approveID':approveID},
                            success:function(data)
                            {
                                $(".ontop").height(height);
                                $("#errorConfirm").fadeIn(500);
                                $('#errorConfirm p').html('Successfully Assigned');
                                $("#popDiv").fadeIn(500);
                                //location.reload();
                                window.location = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=TRVehicleBooking/DashboardAssignedBooking";
  
                            },
                            error:function(data)
                            {
                                //alert('err');
                            },
                            dataType:'html'
                        });



                        /*var index = val.indexOf('?r=');
                        var indexLoc = parseInt(index) + 3;
                        var first = val.substr(0, indexLoc);
                        var dashBoard = 'dashboard/index';
                        var fulDashUrl = first + dashBoard;*/
                        return false;
                        setTimeout(function()
                        {
                            //window.location = fulDashUrl;
                        },3000);
                    }
                    if(disapproved)
                    {

                    }

		});


		$('#Cancel_btn').click(function()
		{
			window.location = "index.php?r=dashboard/index";
		});
                
                $('#saveReject').click(function()
                {
                    var reason = $('#txtReason').val();
                    var reqID = $('#txtReqestID').val();

                    if(reason !== '')
                    {
                        $.ajax
                        ({
                            type:'POST',
                            url : '<?php echo Yii::app()->createAbsoluteUrl("TRVehicleBooking/RejectBookingRequest"); ?>',
                            data : {'reqID':reqID,'reason':reason},
                            success : function(data)
                            {
                                $(".ontop").height(height);
                                $("#errorConfirm").fadeIn(500);
                                $('#errorConfirm p').html('Successfully required');
                                $("#popDiv").fadeIn(500);
                                setTimeout(function()
                                {
                                    location.reload();
                                },3000);
                            },
                            error : function(data)
                            {
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
                        //alert("Please specify the reason...!");
                    }
                });
                
                
                $('#btnConfirmOk').click(function()
                {
                    var reqID = $('#txtReqestID').val();
                    $.ajax
                    ({
                        type : 'POST',
                        url : '<?php echo Yii::app()->createAbsoluteUrl("TRVehicleBooking/RemoveRequestFromAssignedList") ?>',
                        data : {'reqID':reqID},
                        success : function(data)
                        {
                           var height = $("body").height();//- $("#header").height() + $("#footer").height()
                           $(".ontop").height(height);
                           $("#errorConfirm").fadeIn(500);
                           $('#errorConfirm p').html('Successfully Removed');
                           $("#popDiv").fadeIn(500);

                           setTimeout(function()
                           {
                               location.reload();
                           },3000);
                        },
                        dataType:'html'
                    });
                });
                
                $('#btnConfirmCancel').click(function()
                {
                    $('.flashMsg').hide();
                    $(".statusDrop option[value='Assigned']").prop("selected","selected");
                    return false;
                });

	});
// });


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
                {
                    min = value;
                }
                
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
                {
                    max = value;
                }
                
            }/**/

             return max;
	}

	function getBookIDs(tableId, columnIndex)
	{
            var table = document.getElementById(tableId);
            var rows = table.getElementsByClassName('rows');
            var idArray = new Array();

            for (var i = 0; i < rows.length; i++)
            {
                var cols = rows[i].getElementsByClassName('dta');
                var value = (cols[columnIndex].firstChild.nodeValue); // force to integer value

                idArray.push(value);
            }

             return idArray;
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
            $(".statusDrop option[value='Assigned']").prop("selected","selected");
        },
        //'onStart': function() {$("body").css({'overflow':'hidden'});},
        //'onClosed': function() {$("body").css({"overflow":"visible"});},
        helpers: {overlay: {locked: true}}
    });


    function getDefaultDriver(e)
    {
        var height = $("body").height() ;
        var vNo = $(e).val();
        
        $.ajax
        ({
            url: "<?php echo $this->createAbsoluteUrl('TRVehicleBooking/getDefaultDriver'); ?>",
            type: "post",
            dataType: 'json',
            data: {'vNo': vNo},
            success: function(data)
            {
                $("#Driver_ID option[value='"+data.driver+"']").prop("selected","selected");
                var passengers = data.passengers;
                var passengersInRequests = getPassengers() ;                
                
                if(passengers)
                {
                    if(passengers < passengersInRequests)
                    {
                        $(".ontop").height(height);
                        $("#errorConfirm").fadeIn(500);
                        $('#errorConfirm p').html('Number of passengers in the Booking list is exceeded the number of passengers for this vehicle');
                        $("#popDiv").fadeIn(500);
                    }
                }

                //alert(data);
                //$("#Driver_ID option[value='"+data+"']").prop("selected","selected");
                 /*var rowNo = data.split('=');
                var dID = rowNo[0];
                var dName = rowNo[1];
                var drvID = dID;

               jQuery("#Driver_ID").find("option:contains('"+dName+"')").each(function()
                {
                    if( jQuery(this).text() == dName )
                    {
                        jQuery(this).attr("selected","selected");
                    }
                });*/
            }
        });
    }
    
    function getPassengers() 
    {
        var table = document.getElementById('AssignListTable');
        var rows = table.getElementsByClassName('rows');
        var count = 0;
        for (var i = 0; i < rows.length; i++) 
        {
            var cols = rows[i].getElementsByClassName('dta');
            if(cols[7].firstChild !== null)
            {
                var value = (cols[7].firstChild.nodeValue); // force to integer value

                if (value !== '')
                {
                    count += parseInt(value);
                }
            }
        }
        return count;
    }
    
    function showRejectPop(e)
    {
        var reqID = $(e).parents().eq(1).children().eq(0).html();
        var val = $(e).val();
        var height = $("body").height() ;
        
        if(val === 'Reject')
        {
            $('#txtReqestID').val(reqID);
            $('#rejReq').trigger('click');
        }
        if(val === 'Remove')
        {
            $('#txtReqestID').val(reqID);
            $(".ontop").height(height);
            $("#Confirm").fadeIn(500);
            $('#Confirm p').html('Are you sure you want to remove this request form the assigned requst?');
            $("#popDiv").fadeIn(500);
        }

    }
    
   
 </script>


 
 
 
 
 
 <div class="container body">
    <div id="main" role="main">
        <div class="row rest-view">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading large" style="color:#fff; background: #c21118">
                        <h1 class="panel-title" itemprop="name">Assigned Vehicle Booking Requests</h1>
                    </div>
                </div>
            </div>
            
            
            <div class="col-xs-12">
                <div class="panel panel-default">
                   

                    <div class="panel-body">
                        
                        <a href="#moreDetails" class="fancybox" id="viewMore" style="display:none;">View</a>
                        <div  id="moreDetails"  style="display: none; width: auto; height: auto; margin-left: 10px;">
                        </div>
                        
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

                       
                    <?php

                      /*  $BookingApproval = new BookingApproval();

                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'trvehicle-booking-grid',
                            'dataProvider'=>$model->getAssignedRequests($ApproveID),
                            //'filter'=>$model,
                            'columns'=>array(
                                array('name'=>'Booking_Request_ID', 'header'=>'Request ID', 'value'=>'$data->Booking_Request_ID', 'visible'=>true, 'htmlOptions'=>array('id'=>"reqID")),
                        
                                array('name'=>'username', 'header'=>'Requested By', 'value'=>'$data->user->profile->firstname'),
                                array('name'=>'Branch', 'value'=>'$data->user->Branch_Id ==="0" || $data->user->Branch_Id !=="" ? "" : $data->user->branch->Branch '),
                                'Place_from',
                                'Place_to',
                                array('name'=>'Vehicle_No', 'value'=>'$data->approval->Vehicle_No'),
                                array('name'=>'Full_Name', 'header'=>'Assigned Driver', 'value'=>'$data->approval->drivers->Full_Name'),

                                array('name'=>'New_Booking_Request_Date', 'header'=>'From Date/Time', 'value'=>'$data->approval->New_Booking_Request_Date'),
                                array('name'=>'New_Booking_To_Date', 'header'=>'To Date/Time', 'value'=>'$data->approval->New_Booking_To_Date'),
                               
                                array(
                  'name' => 'Status',
                  'type' => 'raw',
                  //'value'=>'$data->Activity_Status'
                  'value' => "CHtml::dropDownlist('','', array('Assigned'=>'Assigned','Remove'=>'Remove', 'Reject'=>'Reject'), array('class'=>'statusDrop', 'onchange'=>'showRejectPop(this)'))",
                ),*/
                                /*array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Request',
                                        'imageUrl'=>Yii::app()->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/tRVehicleBooking/rejectVehicleBooking", array("requestId" =>$data["Booking_Request_ID"],"appID" =>$data["approval"]["Booking_Approval_ID"],"vid" =>$data["approval"]["Vehicle_No"], "driver" =>$data["approval"]["Driver_ID"]))'
                                    )),
                                ),*/

/*
                            ),
                        ));*/ ?>

                        <?php

                        $approvedArr = $model->getApprovedBookingRequestsCount();
                        
                        if($approvedArr > 0)
                        {
                           // echo "<div style='height:40px;'></div>";
                            echo "<h4 style='font-weight: bold;'>Select Approved Requests to merge the following Assigned Request</h4>";
                          
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'trvehicle-booking-grid',
                                'dataProvider'=>$model->getApprovedBookings(),
                                'columns'=>array(
                                    'Booking_Request_ID',
                                    //array('name'=>'Requested vehicle Category','header'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
                                    array('name'=>'username', 'header'=>'Requested By', 'value'=>'$data->user->profile->firstname'),
                                    //array('name'=>'Branch', 'value'=>'isset($data->user->Branch_Id) && $data->user->Branch_Id !="0" ? $data->user->branch->Branch : ""'),
                                    
                                    'From',
                                    'To',
                                    'Place_from',
                                    'Place_to',
                                    array('name'=>'Vehicle_No', 'header'=>'Vehicle No', 'value'=>'$data->Vehicle_No != "" ? $data->Vehicle_No : "-"'),
                                    array('name'=>'Driver_ID', 'header'=>'Driver', 'value'=>'$data->Driver_ID != "" ? $data->driver->Full_Name: "-"'),
                       
                                    'No_of_Passengers',
                                    array(

                                        'name' =>'select',
                                        'class'=>'CDataColumn',
                                        'value' => 'CHtml::checkBox("BookingIds[]",null,array("value"=>$data->Booking_Request_ID,"class"=>"chkBox", "id"=>$data->Booking_Request_ID))',
                                        'type'=>'raw',
                                        'htmlOptions' => array('width'=>5),
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
                                                   //alert(reqID);
                                                   //var Pclass = $(this).parents("#reqID").html();
                                                    $.ajax
                                                    ({
                                                    type: "post",
                                                        url: "'. $this->createAbsoluteUrl("TRVehicleBooking/getOtherBookingDetails").'",

                                                        dataType: "html",
                                                        data: {"reqID": reqID, "status":"Pending"},
                                                        success: function(data)
                                                        {
                                                            //alert(data);
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
                            ));
                            
                            
                        }
                        ?>

                            <div class="formq">

                                <?php
                                echo '<br/><br/><br/>';
                                echo '<h4 style="font-weight: bold;">Vehicle Booking Requests for Assigning</h4>';

                                echo '<div class="grid-view"><table class="tbl items" id="AssignListTable" style="width:95%; font-size:13px;">
				<thead><tr>
				<th>Request ID</th>
				<th>Requested By</th>
				<th>Place To</th>
				<th>From Date/time</th>
				<th>To Date/time</th>
				<th>Vehicle No</th>
				<th>Driver</th>
				<th>Number of Passengers</th>
                                <th>Status</th>
				</tr></thead>';
                                echo '<tbody id="requestsForAssign">
			
             </tbody>   </table></div>';


                                ?>


                            </div>


                            <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'trvehicle-booking-form',
                            'enableAjaxValidation'=>false,
                        )); ?>




                            <br/> <br/> <br/>



                            <center><table width="550" border="1" class="tblle" >
                                <tr>
                                    <td style="width:150px;"><?php echo CHtml::label('Vehicle Number', 'Vehicle_No'); ?></td>
                                    <td><?php echo CHtml::dropDownList('Vehicle_No', 'Vehicle_No',array(''),array('prompt' => '--- Please Select ---', 'class'=>'dropdwn', 'onchange'=>'getDefaultDriver(this)'));?></td>

                                </tr>

                                <tr>
                                    <td style="width:150px;"><?php echo CHtml::label('Driver Name', 'Driver_ID'); ?></td>
                                    <td><?php echo CHtml::dropDownList('Driver_ID', 'Driver_ID', array(''),array('prompt' => '--- Please Select ---', 'class'=>'dropdwn'));?>
                                        <?php #echo $form->error($model,'Driver_ID'); ?></td>
                                </tr>
                                <tr>
                                    <td/>
                                    <td><?php echo CHtml::button('Assign', array('id'=>'Approve_btn', 'class'=>'otherBtns', 'style'=>'margin-right:-20px')); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php //echo CHtml::button('Exit', array('id'=>'Cancel_btn','class'=>'otherBtns')); ?></td>
                                </tr>
                            </table></center>


                            <div class="btns" style="margin-left:50%; margin-top:10px; margin-bottom:20px; ">
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;

                                <?php #echo CHtml::button('Disapprove', array('id'=>'DisApprove_btn', 'style'=>'display:none')); ?>
                                </div>
                            <a style="display:none" id="goTomain" href="<?php echo Yii::app()->createAbsoluteUrl("dashboard/index")?>"/>
                            <?php $this->endWidget(); ?>
                        


                    </div>
                </div>




            </div>
            
        </div>

    </div>
</div>