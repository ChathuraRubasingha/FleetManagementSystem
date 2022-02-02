<style>
    .grid-view table.items tr.selectForBooking
    {
        background-color: #90C0EA !important;
    }

    .grid-view table.items tr.selected
    {
        //background:none !important;
    }
    
    .dropdwn
    {
        width: 200px;
    }
    
    #saveReject
    {
        width: 75px !important;
    }
    .statusDrop
    {
        padding: 3px 0;
        min-width:72px !important;
        border: 1px solid #CCCCCC;
    }
    td textArea
    {
        width: 100%;
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
 th{
	 border-bottom:1px solid #CCC; 
	 padding-top:30px;
 }
 
 .tbl
 {
	 border:1px solid #CCC; 
	 font-size:13px;
	 padding:10px;
	 background:none repeat scroll 0 0 #F3F3F3;
 }
 thead
 {
	 background:none repeat scroll 0 0 #fff;
 }
 td
 {
	 padding:5px;
 }
.even
{
	background: #fff;
}
.odd
{
	//background: #fff;
}
.col 
{
	min-height:400px;
	height:auto !important; 
}

.col5
{
}
</style>



<?php

    $LocID = Yii::app()->getModule("user")->user()->Location_ID;
    $userRole = Yii::app()->getModule("user")->user()->Role_ID;
?> 
	
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
	}/**/

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
	}/**/

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
        var userRole = <?php echo $userRole?>;
        var approved = false;
        var rejected = false;
        var height = $("body").height() ;
        var minDate = '<?php echo MaVehicleRegistry::model()->getServerDate('dateTime'); ?>';
        var maxDate = minDate;
        
        if(userRole ==='6')
        {
            //alert(userRole);
            $('#driverVehicle').hide();
            $('#reqForAssign').hide();
            $('#Approve_buttn').hide();
        }

        $('#Approve_buttn').click(function()
        {
            var vNo = $('#Vehicle_No').val();
            var driver = $('#Driver_ID').val();

            if(vNo === '')
            {
                $(".ontop").height(height);
                $("#errorConfirm").fadeIn(500);
                $('#errorConfirm p').html('Please Select a Vehicle Number...!');
                $("#popDiv").fadeIn(500);
            }
            else if(driver === '')
            {
                $(".ontop").height(height);
                $("#errorConfirm").fadeIn(500);
                $('#errorConfirm p').html('Please Select a Driver Name...!');
                $("#popDiv").fadeIn(500);					
            }
            else
            {
                approved = true;
                $(".ontop").height(height);
                $("#Confirm").fadeIn(500);
                $('#Confirm p').html('Are you sure you want to assign this vehicle and driver for above request(s)?');
                $("#popDiv").fadeIn(500);
            }

        });


        $('#btnConfirmOk').click(function()
        {
            var reason = $('#TRVehicleBooking_Booking_Status_Reason').val();
            if(approved)
            {
                ids = new Array();

                /*var minDate = getColumnMin('AssignTableID', '3');
                var maxDate = getColumnMax('AssignTableID', '4');*/

                var vNo = $('#Vehicle_No').val();
                var driver = $('#Driver_ID').val();

                $('.chkBoxAssign').each(function(e)
                {
                    var bookId =this.id;

                    if($('#'+bookId).attr("checked"))
                    {
                        ids.push(bookId);
                    }

                });

                var approveID = '0';
                $.ajax
                ({
                    type:'POST',
                    url:'<?php echo Yii::app()->createAbsoluteUrl('TRVehicleBooking/AssignDriverAndVehicle');?>',
                    data:{'ids':ids, 'NewBookingDate':minDate, 'maxToDate':maxDate, 'vNo':vNo, 'driver':driver, 'approveID':approveID},
                    success:function(data)
                    {

                        $(".ontop").height(height);
                        $("#errorConfirm").fadeIn(500);
                        $('#errorConfirm p').html('Successfully Assigned...!');
                        $("#popDiv").fadeIn(500);
                        //location.reload();
                    },
                    error:function(data)
                    {
                        //alert('err');
                    },
                    dataType:'html'
                });/**/
            setTimeout(function()
            {
                location.reload()},3000);
            }
            if(rejected)
            {
           
                var ids = new Array();

                $('.chkBoxAssign').each(function(e)
                {
                    var bookId =this.id;

                    if($('#'+bookId).attr("checked"))
                    {
                        ids.push(bookId);
                    }

                });
              
                $.ajax
                ({
                    type:'POST',
                    url:'<?php echo Yii::app()->createAbsoluteUrl('TRVehicleBooking/RejectApprovedRequests');?>',
                    data:{'ids':ids, 'reason':reason},
                    success:function(data)
                    {                       
                        $(".ontop").height(height);
                        $("#Confirm").fadeIn(500);
                        $('#Confirm p').html('Successfully Rejected...!');
                        $("#popDiv").fadeIn(500);
                    },
                    error:function(data)
                    {
                    },
                    dataType:'html'
                });
                
                setTimeout(function()
                {
                    location.reload();
                },3000);
            }
            
        });
		
        		
		
        $('#RjctBtn').click(function()
        {
            var reason = $('#TRVehicleBooking_Booking_Status_Reason').val();
            
            $("#popDiv").height(height);
            $("#Confirm").fadeIn(500);
            if(reason =='')
            {
                $('.tblRow').show();
                $('#Confirm p').html('Reason is required');
            }
            else
            {
                rejected = true;
                $('#Confirm p').html('Are you sure you want to reject above request(s)?');
            }
            
            $("#popDiv").fadeIn(500);
            return false;
        });
            
       
		
		
        $('#Vehicle_No').change(function()
        {
            var vNo = $(this).val();

            $.ajax
            ({
                url: "<?php echo $this->createAbsoluteUrl('TRVehicleBooking/getDefaultDriver'); ?>",
                type: "post",
                dataType: 'json',
                data: {'vNo': vNo},
                success: function(data)
                {
                    //alert(data);
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
                    //alert(passengers);
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

        });
        
        
        
        $(".chkBoxAssign").bind("click", function()
        {
            
        });
        $('.chkBoxAssign').click(function()
        {
            


        });
    
        $('#saveReject').click(function()
        {
            var reason = $('#txtReason').val();
            var reqID = $('#txtReqestID').val();

            if(reason != '')
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
                        $('#errorConfirm p').html('Successfully Rejected...!');
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


    });
        
        function getRequestForAssigning(ele)
        {
            var reqID = $(ele).id;
            var ids = new Array();
            var checked = $('#'+reqID).attr('checked');
            if(checked)
            {
                $(this).parent().parent().addClass("selectForBooking");
            }
            else
            {
                $(this).parent().parent().removeClass("selectForBooking");
            }
            //alert(e);
            $('.chkBoxAssign').each(function(e)
            {
                var bookId =this.id;
                if($('#'+bookId).attr("checked"))
                {
                    ids.push(bookId);
                }
            });
            var length = ids.length;
            if(length >= 1)
            {
                $('.AssignForm').show();
                if(length === 1)
                {
                    $('#RjctBtn').show();
                }
                else
                {
                    $('#RjctBtn').hide();
                }
            }
            else
            {
                $('.AssignForm').hide();
            }

            $.ajax
            ({
                type:'POST',
                url : '<?php echo Yii::app()->createAbsoluteUrl("TRVehicleBooking/GetRequestsForAssigning"); ?>',
                data : {'ids':ids},
                success : function(data)
                {
                    minDate = data.minDate;
                    maxDate = data.maxDate;

                    $('#RequestsForAssign').html(data.row);
                    $('#Vehicle_No').html(data.vehicle);
                    $('#Driver_ID').html(data.driver);
                },
                error : function(data)
                {
                },
                dataType : 'json'

            });
        }
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
        });/**/
        
        
        function getPassengers() 
        {
            var table = document.getElementById('AssignTableID');
            var rows = table.getElementsByClassName('rows');
            var count = 0;
            for (var i = 0; i < rows.length; i++) 
            {
                var cols = rows[i].getElementsByClassName('dta');
                if(cols[8].firstChild !== null)
                {
                    var value = (cols[8].firstChild.nodeValue); // force to integer value

                    if (value !== '')
                    {
                        count += parseInt(value);
                    }
                }
            }
            return count;
        }
</script>

 

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
                
                
                
 <div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading large" style="color:#fff; background: #c21118">
                        <h1 class="panel-title" itemprop="name">Approved Booking Requests for Assigning</h1>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12">


                <div class="panel panel-default">
                   

                    <div class="panel-body">

<?php
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();

        Yii::app()->clientScript->registerCoreScript('jquery');
       // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/script.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.yiigridview.js');
        

     
    ?>
                       
            <?php 
                    $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'trvehicle-booking-approvedList-grid',
                    'dataProvider'=>$model->getApprovedBookingRequestsDashBoard(),
                    //'filter'=>$model,
                    'columns'=>array(

                        array('name'=>'Booking_Request_ID', 'header'=>'Request ID', 'value'=>'$data->Booking_Request_ID', 'visible'=>true, 'htmlOptions'=>array('id'=>"reqID")),
                        array('name'=>'username', 'header'=>'Requested By', 'value'=>'$data->user->profile->firstname'),
                       // array('header'=>'Branch', 'value'=>'$data->user->Branch_Id ==0 ? "-" : $data->user->branch->Branch'),
                        'Place_from',
                        'Place_to',
                       array('name'=>'Vehicle_No', 'header'=>'Vehicle No', 'value'=>'$data->Vehicle_No != "" ? $data->Vehicle_No : "-"'),
                        array('name'=>'Driver_ID', 'header'=>'Driver', 'value'=>'$data->Driver_ID != "" ? $data->driver->Full_Name: "-"'),
                       /* */ array('name'=>'From',  'value'=>'$data->From', 'htmlOptions'=>array('id'=>'frmDate')),
                        'To',
                        
                        array(
                  'name' => 'Status',
                  'type' => 'raw',
                  //'value'=>'$data->Activity_Status'
                  'value' => "CHtml::dropDownlist('','', array('Approved'=>'Approved', 'Reject'=>'Reject'), array('class'=>'statusDrop', 'onchange'=>'showRejectPop(this)'))",
                ),
                        array(			  
                            'name' =>'select',
                            'class'=>'CDataColumn',
                            'value' => 'CHtml::checkBox("BookingIds[]",null,array("value"=>$data->Booking_Request_ID,"class"=>"chkBoxAssign", "onClick"=>"getRequestForAssigning(this)", "id"=>$data->Booking_Request_ID))',
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
                        )); ?>
            
            <div class="AssignForm" style="display:none">	
    <div id="reqForAssign">
    <?php	
echo '<br/><br/><br/>';
echo '<h4 style="font-weight:bold">Vehicle Booking Requests for Assigning</h4>';

	echo '<div class="grid-view"><table class="tbl items" id="AssignTableID" style="width:95%">
			<thead>	<tr>
				<th>Request<br/> ID</th>
				<th>Requested<br/> By</th>
                                <th>Place <br/>From</th>
				<th>Place <br/>To</th>
				<th>From <br/>Date/time</th>
				<th>To <br/>Date/time</th>
				<th>Vehicle<br/>No</th>
				<th>Driver</th>
				<th>Passengers</th>
				</tr></thead>';
			echo '<tbody id="RequestsForAssign">
			
             </tbody>   </table></div>';
			

		 ?>
         <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'trvehicle-booking-form',
    'enableAjaxValidation'=>false,
    )); ?>


    </div>
    
         <br/> <br/> <br/>
         
         
   <div id="driverVehicle">    
         
       <center><table width="80%" style="margin-left:50px">
            <tr>
                <td style="width:150px;"><?php echo CHtml::label('Vehicle Number', 'Vehicle_No'); ?></td>
                <td><?php echo CHtml::dropDownList('Vehicle_No', 'Vehicle_No',array(''),array('prompt' => '--- Please Select ---', 'class'=>'dropdwn'));?></td>
            </tr>

               <tr>
                   <td style="width:150px;"><?php echo CHtml::label('Driver Name', 'Driver_ID'); ?></td>
                   <td><?php echo CHtml::dropDownList('Driver_ID', 'Driver_ID', CHtml::listData( MaDriver::model()->getDrivers($LocID), 'Driver_ID', 'Full_Name'),array('prompt' => '--- Please Select ---', 'class'=>'dropdwn'));?>
               </tr>
               
               <tr>
                   <td/>
                   <td><?php echo CHtml::button('Assign', array('id'=>'Approve_buttn', 'class'=>'otherBtns', 'style'=>'width:100px; margin-right:-20px')); ?></td>
               </tr>
           </table> 
        </center>
    </div>    
        
         
         
	</div>
	
    


<?php $this->endWidget(); ?>


                    </div>
                </div>




            </div>
            
        </div>

    </div>
</div>               