<input type="hidden" id="ThisIdIsNotAvailable" value="<?php echo Yii::app()->request->getParam('linkid') ?>" />
<input type="hidden" id="ThisIdIsAvailable" value="<?php echo Yii::app()->request->getParam('menuId') ?>" />



<style type="text/css">
    #fancybox-loading div {
        position: fixed !important;
        top: 40% !important;
        left: 10% !important;
        width: 980px !important;
        height: 100px !important;
        background-image:url("fancy/fancybox_loading@2x.gif");
    }
    
    #logoLi:hover
    {
        background-color: white !important; 
		height:60px !important;
    }
/*    .addBtn
    {
        width:19px;
        height:30px;
        display:inline-block;
        background-position: -5px 5px;
        border:none;
        background-color:transparent !important;
        background-image:url(images/1Screenshot-32.png) !important;
        background-repeat:no-repeat;
        z-index:900;
        title:"Add";
    }*/

    /*            styles noty*/
    .noty_messagemy{
        font-size: 13px;
        line-height: 16px;
        padding: 8px;
        position: relative;
        text-align: center;
        width: auto;
    }

    #close {
        -webkit-transition: -webkit-transform 0.1s ease-in;
    }

    #close:hover {
        -moz-transform: scale(1.1);
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
        -moz-box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.6);
        -webkit-box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.6);
        box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.6);
        cursor: pointer;
    }

    #cPassCloseImg {
        -webkit-transition: -webkit-transform 0.1s ease-in;
    }

    #cPassCloseImg:hover {
        -moz-transform: scale(1.1);
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
        -moz-box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.6);
        -webkit-box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.6);
        box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.6);
        cursor: pointer;
    }

    #stopAlerts {
        -webkit-transition: -webkit-transform 0.1s ease-in;
    }

    #stopAlerts:hover {
        -moz-transform: scale(1.1);
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
        -moz-box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.6);
        -webkit-box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.6);
        box-shadow: 2px 2px 10px rgba(255, 255, 255, 0.6);
        cursor: pointer;
    }

    .popUp{

        display:none; /* Hide the DIV */
        position:fixed;
        _position:absolute; /* hack for internet explorer 6 */
        height:70%;
        width:84%;
        background:#FFFBFF;
        left: 12%;
        top: 10%;
        z-index:99; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
        margin-left:63%;

        width:22%;
        height:auto;
        border-radius: 10px 10px 10px 10px;
        /* additional features, can be omitted */
        border:3px -moz-bg-solid #000000;
        padding:15px;
        /*font-size:15px;*/
        -moz-box-shadow: 0 0 5px #ff0000;
        -webkit-box-shadow: 0 0 5px #ff0000;
        box-shadow: 4px 9px 17px #373535;
    }

    #changePasswordButton
    {
        width:100px;
        margin-top:5%;
        text-align:left;
        font-size:14px;
        text-align:center;
        border:1px solid #DFDFDF;
        border-bottom-left-radius:8px;
        border-bottom-right-radius:8px;
        border-top-left-radius:8px;
        border-top-right-radius:8px;
        color:#999999;
        text-shadow:#FFFFFF 0 1px 0;
        background-image:url(../images/white.jpg);
        background-position:initial initial;
        background-repeat:repeat no-repeat;
        color:#333;
        margin-right:50px;
    }

    #changePasswordButton:hover
    {


        border:2px solid #0099FF;
        color:#0099FF;

    }

    .DynamicLinkColor a
      {
          //font-weight:  bolder !important;
          color: #0099FF !important;
          border-left: 6px solid #0099FF;
          border-bottom: 1.5px solid #0099FF;
          
      }
      
      .DynamicMenuColor a
      {
          background-color: white;
          color: #0099FF !important;
      }
     

</style>
<?php
$notifications = new Notifications();
$alertExeTime = $notifications->getAlertExeTime();

if (isset($alertExeTime) && !empty($alertExeTime)) {
    $exeTime = CPropertyValue::ensureInteger(($alertExeTime)) * 1000;
} else {
    $exeTime = 15 * 1000; //1000 1 sec 15sec)
}

$alertStatus = $notifications->chkAlertOnorOff();

if (isset($alertStatus) && !empty($alertStatus)) {

    $alertStatus = $alertStatus;
} else {
    $alertStatus = "0";
}

?>

<!doctype html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />-->
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" type="image/x-icon" />
    
    <title>Fleet Management</title>
    <link rel="stylesheet" href="css/zebra.css" type="text/css"/>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
   <link rel="stylesheet" href="css/responsive.css" type="text/css" media="screen"/>
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/fancy/jquery.fancybox.css?v=2.1.5" />
   
    <?php
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();

        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/fancy/jquery.fancybox.js?v=2.1.5');

        //importing odometer
        $cs->registerCssFile($baseUrl . '/js/odometer/themes/odometer-theme-car.css');
        $cs->registerScriptFile($baseUrl . '/js/odometer/odometer.js');
    ?>


    <!--	<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>-->



    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/global.css"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/plugins.css"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/restaurant.css"/>
<!--    <link rel="stylesheet" href="--><?php //echo Yii::app()->request->baseUrl; ?><!--/assets/css/jquery.fancybox.css"/>-->


    <script>
        
        $(document).ready(function() 
        {
            var idData = $("#ThisIdIsNotAvailable").val();
            var menuIdData = $("#ThisIdIsAvailable").val();

            $('#' + idData).addClass("DynamicLinkColor");
            $('#' + menuIdData).addClass("DynamicMenuColor");

            $('ul li a').click(function(e) 
            {                
                if ($(this).text() === "Change Password") 
                {
                    $("#cPass").css("display", "block");
                    $("#formResult").html("");
                    $("#container").css({// this is just for style
                        "opacity": "0.3"
                    });
                    $('#cPass').fadeIn("slow");
                }
            });

            $("#cPassClose").click(function() 
            {
                $("#cPass").fadeOut("slow");
            });

            $('#close').click(function() 
            {
                $('#alertbox').fadeOut("slow");
                $('#alertbox').hide();
                $.ajax({
                    url: "<?php echo $this->createAbsoluteUrl('tRVehicleBooking/AlertClosed'); ?>",
                    type: "post",
                    dataType: "json",
                    data: {alertClosed: true},
                    success: function(theResponse) {

                    }
                });
            });
        });

        $("a.pop4").fancybox({
            openEffect: 'elastic',
            openSpeed: 300,
            closeEffect: 'elastic',
            closeSpeed: 300,
            helpers: {
                overlay: {
                    css: {
                        'background': 'rgba(238,238,238,0.85)'
                    }
                }
            },
            'width': '75%',
            'height': '75%',
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'type': 'iframe'
        });

        function showChangePassword()
        {
            $("#cPass").css("display", "block");
                    $("#formResult").html("");
                    $("#container").css({// this is just for style
                        "opacity": "0.3"
                    });
                    $('#cPass').fadeIn("slow");
        }
        //            //disable alerts

        function disable_alerts() 
        {
            $.ajax({
                url: "<?php echo $this->createAbsoluteUrl('tRVehicleBooking/SetFlagOne'); ?>",
                type: "post",
                dataType: 'json',
                data: {setViewedFlag: true},
                success: function(theResponse) {

                    if ((theResponse) === "sucess") {
                        $('#alertbox').fadeOut("slow");

                    } else {
                        $('#alertbox').fadeOut("slow");
                    }
                }
            });

        }


        var alert_status = '<?php echo $alertStatus; ?>';
        var executeTimeInterval = '<?php echo $exeTime; ?>';

        if ((alert_status !== "0")) 
        {
            setInterval(function() 
            {
                $.ajax({
                    url: "<?php echo $this->createAbsoluteUrl('tRVehicleBooking/GetServices'); ?>",
                    type: "post",
                    dataType: 'json',
                    data: {get_serviceNotes: true},
                    success: function(theResponse)
                    {
    //                            alert(theResponse.length)
                        if ((theResponse.length) > 4) {

                            $("#alertData").html('');
                            $("#alertbox").fadeIn("slow");

                            $("#alertData").append(theResponse);



                            $('#alertbox').css('display', 'block');
    //                                var n = noty({
    //                                    layout: 'bottomRight',
    //                                    theme: 'defaultTheme',
    //                                    type: 'notification',
    //                                    text: theResponse, // can be html or string
    //                                    dismissQueue: false, // If you want to use queue feature set this true
    //                                    template: '<div class="noty_messagemy" ><span class="noty_text"></span><div class="noty_close"></div></div>',
    //                                    animation: {
    //                                        open: {height: 'toggle'},
    //                                        close: {height: 'toggle'},
    //                                        easing: 'swing',
    //                                        speed: 500 // opening & closing animation speed
    //                                    },
    //                                    timeout: false, // delay for closing event. Set false for sticky notifications
    //                                    force: false, // adds notification to the beginning of queue when set to true
    //                                    modal: false,
    //                                    maxVisible: true, // you can set max visible notification for dismissQueue true option,
    //                                    killer: false, // for close all notifications before show
    //                                    closeWith: ['button'], // ['click', 'button', 'hover']
    //                                    callback: {
    //                                        onShow: function() {
    //                                        },
    //                                        afterShow: function() {
    //                                        },
    //                                        onClose: function() {
    //                                        },
    //                                        afterClose: function() {
    //                                        }
    //                                    },
    //                                   buttons: false
    ////                                            [
    ////                                                {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {
    ////                                                        $noty.close();
    ////                                                        noty({dismissQueue: true, force: true, layout: layout, theme: 'defaultTheme', text: 'You clicked "Ok" button', type: 'success'});
    ////                                                    }
    ////                                                },
    ////                                                {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
    ////                                                        $noty.close();
    ////                                                        noty({dismissQueue: true, force: true, layout: layout, theme: 'defaultTheme', text: 'You clicked "Cancel" button', type: 'error'});
    ////                                                    }
    ////                                                }
    ////                                            ]
    //
    //                                });
    //                                $.noty.clearQueue();

                        } else {
                            $("#alertbox").fadeOut();

                        }
                        return;

                    }
    //                   	  error: function() {
    //                        alert('error');
    //                    }

                });
            }, executeTimeInterval);


        }



        function set_alert_status(model, id) 
        {
            var model = model;
            var id = id;

            $.ajax({
                url: "<?php echo $this->createAbsoluteUrl('tRVehicleBooking/Set_alert_status'); ?>",
                type: "post",
                dataType: 'json',
                data: {set_alert_status: true, model: model, id: id},
                success:function(theResponse)
                {
                    if (theResponse === "1") 
                    {
                        $.ajax
                        ({
                            url: "<?php echo $this->createAbsoluteUrl('tRVehicleBooking/GetServices'); ?>",
                            type: "post",
                            dataType: 'json',
                            data: {get_serviceNotes: true},
                            success: function(theResponse)
                            {
                                if ((theResponse.length) > 4) 
                                {


        //                                  $.noty.closeAll();
        //                                  var n = noty({
        //                                    layout: 'bottomRight',
        //                                    theme: 'defaultTheme',
        //                                    type: 'notification',
        //                                    text: theResponse, // can be html or string
        //                                    dismissQueue: false, // If you want to use queue feature set this true
        //                                    template: '<div class="noty_messagemy" ><span class="noty_text"></span><div class="noty_close"></div></div>',
        //                                    animation: {
        //                                        open: {height: 'toggle'},
        //                                        close: {height: 'toggle'},
        //                                        easing: 'swing',
        //                                        speed: 500 // opening & closing animation speed
        //                                    },
        //                                    timeout: false, // delay for closing event. Set false for sticky notifications
        //                                    force: false, // adds notification to the beginning of queue when set to true
        //                                    modal: false,
        //                                    maxVisible: true, // you can set max visible notification for dismissQueue true option,
        //                                    killer: false, // for close all notifications before show
        //                                    closeWith: ['button'], // ['click', 'button', 'hover']
        //                                    callback: {
        //                                        onShow: function() {
        //                                        },
        //                                        afterShow: function() {
        //                                        },
        //                                        onClose: function() {
        //                                        },
        //                                        afterClose: function() {
        //                                        }
        //                                    },
        //                                   buttons: false
        ////                                            [
        ////                                                {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {
        ////                                                        $noty.close();
        ////                                                        noty({dismissQueue: true, force: true, layout: layout, theme: 'defaultTheme', text: 'You clicked "Ok" button', type: 'success'});
        ////                                                    }
        ////                                                },
        ////                                                {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
        ////                                                        $noty.close();
        ////                                                        noty({dismissQueue: true, force: true, layout: layout, theme: 'defaultTheme', text: 'You clicked "Cancel" button', type: 'error'});
        ////                                                    }
        ////                                                }
        ////                                            ]
        //
        //                                });
        //                                $.noty.clearQueue();
        //
                                    $("#alertData").html('');
                                    $("#alertbox").fadeIn("slow");

                                    $("#alertData").append(theResponse);



                                    $('#alertbox').css('display', 'block');

                                } 
                                else 
                                {
                                    $("#alertbox").fadeOut();
                                }
                                return;

                            }


                        });
                    }
                }

            });
        }


    </script>

</head>
<body>
<?php
//date_default_timezone_set('UTC');
//$script_tz = date_default_timezone_get();
//
//if (strcmp($script_tz, ini_get('date.timezone'))){
//    echo 'Script timezone differs from ini-set timezone.';
//} else {
//    echo 'Script timezone and ini-set timezone match.';
//}
//die;
//        var_dump(Yii::app()->session['appendStringlength']);
//          var_dump(Yii::app()->session['alertClosed']);
//


$currentUser = Yii::app()->user->name;

if ($currentUser != "Guest")
{
    $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
    $Fuel_Requests = $Tyre_Replacement_For_Approvel = $Battery_Replacement_For_Approvel = $Repair_for_Approvel = $Booking_for_Appovel = $Pending_License_Details = $Pending_Fitness_Test_Details = $Pending_Emmission_Test = $Pending_Insuarance_Details = "0";
    $locID = Yii::app()->getModule('user')->user()->Location_ID;

    $getPermission = $notifications->checkDashboardPermission();

    //checks weather role exists in the dashboard permission if so allowed
    if (isset($getPermission) && (count($getPermission) > "0"))
    {

        $Pending_Insuarance_Details = $getPermission[0]['Pending_Insuarance_Details'];
        $Pending_Emmission_Test = $getPermission[0]['Pending_Emmission_Test'];
        $Pending_Fitness_Test_Details = $getPermission[0]['Pending_Fitness_Test_Details'];
        $Pending_License_Details = $getPermission[0]['Pending_License_Details'];
        $Booking_for_Appovel = $getPermission[0]['Booking_for_Appoval'];

        $Approved_Booking_To_Assign = $getPermission[0]['Approved_Booking_To_Assign'];

        $Repair_for_Approvel = $getPermission[0]['Repair_for_Approvel'];
        $Battery_Replacement_For_Approvel = $getPermission[0]['Battery_Replacement_For_Approvel'];
        $Tyre_Replacement_For_Approvel = $getPermission[0]['Tyre_Replacement_For_Approvel'];
        $Fuel_Requests = $getPermission[0]['Fuel_Requests'];

//        var_dump('ins'.$Pending_Insuarance_Details);
//        var_dump('emi'.$Pending_Emmission_Test);
//        var_dump('fit'.$Pending_Fitness_Test_Details);
//        var_dump('lic'.$Pending_License_Details);
//        var_dump('boo'.$Booking_for_Appovel);
//        var_dump('re'.$Repair_for_Approvel);
//        var_dump('batt'.$Battery_Replacement_For_Approvel);
//        var_dump('tye'.$Tyre_Replacement_For_Approvel);
//        var_dump('ful'.$Fuel_Requests);
//        die;
//__ __ ______ __________________________________________________
//                 $superuserstatus = 0;
        //disabling approved booking view t the supervisor
        if(($Approved_Booking_To_Assign === "1")&&(Yii::app()->getModule("user")->user()->Role_ID !=="6"))
        {
            $Approved_Booking_To_Assign = "1";
        }
        else
        {
            $Approved_Booking_To_Assign = "0";
        }

        $delay = "0";
        $criticalPeriod = "3";
        $nonCriticalPeriod = "5";

        $criticalCount =  $warningCount =  $nonCriticalCount = 0;
       
        $Booking_Non_Critical = $Booking_Warning = $Booking_Critical = $Booking_Expiration ='';
        $bookingDelays = $notifications->getBookingDelayValues();
        $countBookingDelays = count($bookingDelays);
        
        if($countBookingDelays > 0)
        {
            $Booking_Non_Critical =$bookingDelays[5]['Value'];
            $Booking_Warning =$bookingDelays[6]['Value'];
            $Booking_Critical =$bookingDelays[7]['Value'];
            $Booking_Expiration ="-".$bookingDelays[8]['Value'];     
        }
        
        $criticalPeriodDb = $notifications->getCriticalValue();
        
        if (isset($criticalPeriodDb) && !empty($criticalPeriodDb)) 
        {
            $criticalPeriod = $criticalPeriodDb;
        }

        $nonCriticalPeriodDb = $notifications->getNonCriticalValue();
        if (isset($nonCriticalPeriodDb) && !empty($nonCriticalPeriodDb)) 
        {
            $nonCriticalPeriod = $nonCriticalPeriodDb;
        }


//--------------------------------------------------------------------------------
//all
        
        
        $fuelRequestPending = $tireReplacementPending = $batteryReplacementPending = $repair = $Fitness = $Vbooking = $ApprovedVbooking = $Emmission = $alllInsurance = 0;



        $alllInsurance = $notifications->getInsuranceAll($superuserstatus, $locID);
//------------------------------------------------------------------------------
        $Emmission = $notifications->getEmmissionAll($superuserstatus, $locID);
//------------------------------------------------------------------------------
        $Fitness = $notifications->getFitnessAll($superuserstatus, $locID);
//------------------------------------------------------------------------------------
        $License = $notifications->getLicenceAll($superuserstatus, $locID);
//------------------------------------------------------------------------------------
        $Vbooking = $notifications->getVbookingAll($superuserstatus, $locID);
//------------------------------------------------------------------------------------
        $ApprovedVbooking = $notifications->getApprovedVbookingAll($superuserstatus, $locID);
//--------------------------------------------------------------------------------------
        $repair = $notifications->getRepairAll($superuserstatus, $locID);
//------------------------------------------------------------------------------------
        $batteryReplacementPending = $notifications->getbatteryReplaceAll($superuserstatus, $locID);
//------------------------------------------------------------------------------------
        $tireReplacementPending = $notifications->gettTireRpalcementAll($superuserstatus, $locID);
//------------------------------------------------------------------------------------
        $fuelRequestPending = $notifications->getFuelRequestAll($superuserstatus, $locID);
//end of all
//
//
//
//
//
//
//
//
//
//
// start of non critical
        $fuelRequestNonCritical = $tirePendingNonCritical = $batteryPendingNonCritical = $repairNonCritical = $nonCriticalFitness = $pendingBookingNonCritical = $ApprovedVbookingNonCritical= $nonCriticalEmission = $nonCriticalInsurance = 0;

        $nonCriticalInsurance = $notifications->getInsuaranceNonCritical($superuserstatus, $locID, $nonCriticalPeriod);

        if (($Pending_Insuarance_Details !== "0") && (isset($nonCriticalInsurance) && (sizeof($nonCriticalInsurance) !== 0))) 
        {
            $nonCriticalCount += sizeof($nonCriticalInsurance);
        }
//------------------------------------------------------------------------------

        $nonCriticalEmission = $notifications->getEmmissionNonCritical($superuserstatus, $locID, $nonCriticalPeriod);

        if (($Pending_Emmission_Test !== "0") && (isset($nonCriticalEmission) && (sizeof($nonCriticalEmission) !== 0))) 
        {
            $nonCriticalCount += sizeof($nonCriticalEmission);
        }
//------------------------------------------------------------------------------

        $nonCriticalFitness = $notifications->getFitnessNonCritical($superuserstatus, $locID, $nonCriticalPeriod);

        if (($Pending_Fitness_Test_Details !== "0") && (isset($nonCriticalFitness) && (sizeof($nonCriticalFitness) !== 0))) 
        {
            $nonCriticalCount += sizeof($nonCriticalFitness);
        }
//------------------------------------------------------------------------------------
        
        $nonCriticalLicense = $notifications->getLicenceNonCritical($superuserstatus, $locID, $nonCriticalPeriod);

        if (($Pending_License_Details !== "0") && (isset($nonCriticalLicense) && (sizeof($nonCriticalLicense) !== 0))) 
        {
            $nonCriticalCount += sizeof($nonCriticalLicense);
        }
//------------------------------------------------------------------------------------

        $pendingBookingNonCritical = $notifications->getPendingBookingNonCritical($superuserstatus, $locID, $Booking_Non_Critical);

        if (($Booking_for_Appovel !== "0") && (isset($pendingBookingNonCritical) && (sizeof($pendingBookingNonCritical) !== 0))) 
        {
            $nonCriticalCount += sizeof($pendingBookingNonCritical);
        }
//---------------------------------------------------------------------------------------
        //new
        $ApprovedVbookingNonCritical = $notifications->getApprovedVbookingNonCritical($superuserstatus, $locID, $Booking_Non_Critical);
        
        if (($Approved_Booking_To_Assign !== "0") && (isset($ApprovedVbookingNonCritical) && (sizeof($ApprovedVbookingNonCritical) !== 0))) 
        {
            $nonCriticalCount += sizeof($ApprovedVbookingNonCritical);
        }
//------------------------------------------------------------------------------------
        
        $repairNonCritical = $notifications->getRepairNonCritical($superuserstatus, $locID, $criticalPeriod);

        if (($Repair_for_Approvel !== "0") && (isset($repairNonCritical) && (sizeof($repairNonCritical) !== 0))) 
        {
            $nonCriticalCount += sizeof($repairNonCritical);
        }
//------------------------------------------------------------------------------------
         // reverse order by the db
        $batteryPendingNonCritical = $notifications->getBatteryReplacementNonCritical($superuserstatus, $locID, $criticalPeriod);

        if (($Battery_Replacement_For_Approvel !== "0") && (isset($batteryPendingNonCritical) && (sizeof($batteryPendingNonCritical) !== 0))) 
        {
            $nonCriticalCount += sizeof($batteryPendingNonCritical);
        }
//------------------------------------------------------------------------------------
       // reverse order by the db
        $tirePendingNonCritical = $notifications->getTireReplacementNonCritical($superuserstatus, $locID, $criticalPeriod);

        if (($Tyre_Replacement_For_Approvel !== "0") && (isset($tirePendingNonCritical) && (sizeof($tirePendingNonCritical) !== 0))) 
        {
            $nonCriticalCount += sizeof($tirePendingNonCritical);
        }

//------------------------------------------------------------------------------------
        // fuel request non critical calculates by regarding the added date of the request. If the date 
        // difference between added date and today, & critical period 
        // Values taken from reverse order  by DB
        $fuelRequestNonCritical = $notifications->getFuelRequestPendingNonCritical($superuserstatus, $locID, $criticalPeriod);

        if (($Fuel_Requests !== "0") && (isset($fuelRequestNonCritical) && (sizeof($fuelRequestNonCritical) !== 0))) 
        {
            $nonCriticalCount += sizeof($fuelRequestNonCritical);
        }
//end of non critical  --------------------------------------------------------------------------------------------------------------------------------
//
//
//
//
// start of warnings
        $warningPendingFuelRequest = $warningPendingTyreRequest = $warningPendingBatteryRequest = $warningPendingRepair = $warningFitness = $pendingBookingWarning = $warningApprovedVbooking = $warningEmission = $warninglInsurance = 0;


        $warninglInsurance = $notifications->getInsuaranceWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod);

        if (($Pending_Insuarance_Details !== "0") && (isset($warninglInsurance) && (sizeof($warninglInsurance) !== 0))) 
        {
            $warningCount += sizeof($warninglInsurance);
        }
//------------------------------------------------------------------------------

        $warningEmission = $notifications->getEmmisionWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod);

        if (($Pending_Emmission_Test !== "0") && (isset($warningEmission) && (sizeof($warningEmission) !== 0))) 
        {
            $warningCount += sizeof($warningEmission);
        }
//------------------------------------------------------------------------------

        $warningFitness = $notifications->getFitenssWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod);

        if (($Pending_Fitness_Test_Details !== "0") && (isset($warningFitness) && (sizeof($warningFitness) !== 0))) 
        {
            $warningCount += sizeof($warningFitness);
        }
//------------------------------------------------------------------------------------
        
        $warningLicense = $notifications->getLicenseWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod);

        if (($Pending_License_Details !== "0") && (isset($warningLicense) && (sizeof($warningLicense) !== 0))) 
        {
            $warningCount += sizeof($warningLicense);
        }
//------------------------------------------------------------------------------------

        $pendingBookingWarning = $notifications->getPendingBookingWarning($superuserstatus, $locID, $Booking_Non_Critical, $Booking_Critical);

        if (($Booking_for_Appovel !== "0") && (isset($pendingBookingWarning) && (sizeof($pendingBookingWarning) !== 0))) 
        {
            $warningCount += sizeof($pendingBookingWarning);
        }
//-------------------------------------------------------------------------------------
//new
        $warningApprovedVbooking = $notifications->getApprovedVbookingWarning($superuserstatus, $locID, $Booking_Non_Critical, $Booking_Critical);

        if (($Approved_Booking_To_Assign !== "0") && (isset($warningApprovedVbooking) && (sizeof($warningApprovedVbooking) !== 0))) 
        {
            $warningCount += sizeof($warningApprovedVbooking);
        }
//------------------------------------------------------------------------------------
         // reverse order by the db
        $warningPendingRepair = $notifications->getPendingReapirWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod);

        if (($Repair_for_Approvel !== "0") && (isset($warningPendingRepair) && (sizeof($warningPendingRepair) !== 0))) 
        {
            $warningCount += sizeof($warningPendingRepair);
        }
//------------------------------------------------------------------------------------
        // reverse order by the db
        $warningPendingBatteryRequest = $notifications->getPendingBatteryReplacementWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod);

        if (($Battery_Replacement_For_Approvel !== "0") && (isset($warningPendingBatteryRequest) && (sizeof($warningPendingBatteryRequest) !== 0))) 
        {
            $warningCount += sizeof($warningPendingBatteryRequest);
        }
//------------------------------------------------------------------------------------
         // reverse order by the db
        $warningPendingTyreRequest = $notifications->getPendingTireRepalcementWarning($superuserstatus, $locID, $criticalPeriod, $criticalPeriod);

        if (($Tyre_Replacement_For_Approvel !== "0") && (isset($warningPendingTyreRequest) && (sizeof($warningPendingTyreRequest) !== 0))) 
        {
            $warningCount += sizeof($warningPendingTyreRequest);
        }
//------------------------------------------------------------------------------------
        
        $warningPendingFuelRequest = $notifications->getPendingFuelRequestWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod);
        
        if (($Fuel_Requests !== "0") && (isset($warningPendingFuelRequest) && (sizeof($warningPendingFuelRequest) !== 0))) 
        {
            $warningCount += sizeof($warningPendingFuelRequest);
        }
//end of shortdelay --------------------------------------------------------------------------------------------------------
//
//
//
//
// start of critical
        $criticalPendingFuelRequest = $criticalPendingTyreRequest = $criticalPendingBatteryRequest = $criticalPendingRepair = $criticalFitness = $pendingBookingCritical = $criticalApprovedBooking = $criticalEmission = $criticalInsurance = 0;


        $criticalInsurance = $notifications->getInsuaranceCritical($superuserstatus, $locID, $criticalPeriod);

        if (($Pending_Insuarance_Details !== "0") && (isset($criticalInsurance) && (sizeof($criticalInsurance) !== 0))) 
        {
            $criticalCount += sizeof($criticalInsurance);
        }
//------------------------------------------------------------------------------

        $criticalEmission = $notifications->getEmissionCritical($superuserstatus, $locID, $criticalPeriod);
        
        if (($Pending_Emmission_Test !== "0") && (isset($criticalEmission) && (sizeof($criticalEmission) !== 0))) 
        {
            $criticalCount += sizeof($criticalEmission);            
        }
//------------------------------------------------------------------------------

        $criticalFitness = $notifications->getFitnessCritical($superuserstatus, $locID, $criticalPeriod);

        if (($Pending_Fitness_Test_Details !== "0") && (isset($criticalFitness) && (sizeof($criticalFitness) !== 0))) 
        {
            $criticalCount += sizeof($criticalFitness);
        }
//------------------------------------------------------------------------------------
        
        $criticalLicense = $notifications->getLicenceCritical($superuserstatus, $locID, $criticalPeriod);

        if (($Pending_License_Details !== "0") && (isset($criticalLicense) && (sizeof($criticalLicense) !== 0))) 
        {
            $criticalCount += sizeof($criticalLicense);
        }
//------------------------------------------------------------------------------------
        
        $pendingBookingCritical = $notifications->getPendingBookingCritical($superuserstatus, $locID, $Booking_Critical);

        if (($Booking_for_Appovel !== "0") && (isset($pendingBookingCritical) && (sizeof($pendingBookingCritical) !== 0))) 
        {
            $criticalCount += sizeof($pendingBookingCritical);
        }
//-------------------------------------------------------------------------------------------
        //new
        $criticalApprovedBooking = $notifications->getApprovedVbookingCritical($superuserstatus, $locID, $Booking_Critical);

        if (($Approved_Booking_To_Assign !== "0") && (isset($criticalApprovedBooking) && (sizeof($criticalApprovedBooking) !== 0))) 
        {
            $criticalCount += sizeof($criticalApprovedBooking);
        }
//------------------------------------------------------------------------------------
         // reverse order by the db
        $criticalPendingRepair = $notifications->getPendingRepairCritical($superuserstatus, $locID, $nonCriticalPeriod);

        if (($Repair_for_Approvel !== "0") && (isset($criticalPendingRepair) && (sizeof($criticalPendingRepair) !== 0))) 
        {
            $criticalCount += sizeof($criticalPendingRepair);
        }
//------------------------------------------------------------------------------------
        // reverse order by the db
        $criticalPendingBatteryRequest = $notifications->getBatteryReplacementCritical($superuserstatus, $locID, $nonCriticalPeriod);

        if (($Battery_Replacement_For_Approvel !== "0") && (isset($criticalPendingBatteryRequest) && (sizeof($criticalPendingBatteryRequest) !== 0))) 
        {
            $criticalCount += sizeof($criticalPendingBatteryRequest);
        }
//------------------------------------------------------------------------------------
         // reverse order by the db
        $criticalPendingTyreRequest = $notifications->getTireReplacementCritical($superuserstatus, $locID, $nonCriticalPeriod);
        
        if (($Tyre_Replacement_For_Approvel !== "0") && (isset($criticalPendingTyreRequest) && (sizeof($criticalPendingTyreRequest) !== 0))) 
        {
            $criticalCount += sizeof($criticalPendingTyreRequest);
        }

//------------------------------------------------------------------------------------
        
        $criticalPendingFuelRequest = $notifications->getFuelRequestCritical($superuserstatus, $locID, $nonCriticalPeriod);
        
        if (($Fuel_Requests !== "0") && (isset($criticalPendingFuelRequest) && (sizeof($criticalPendingFuelRequest) !== 0))) 
        {
            $criticalCount += sizeof($criticalPendingFuelRequest);
        }
//end of critical
//
//

        //setting active tab all
        $tabs = array();
        if (($Pending_Insuarance_Details !== "0") && (count($alllInsurance) > "0")) 
        {
            $tabs[] = "insuarance";
        }
        if (($Pending_Emmission_Test !== "0") && (count($Emmission) > "0")) 
        {
            $tabs[] = "emmisionTest";
        }

        if (($Pending_Fitness_Test_Details !== "0") && (count($Fitness)) > "0") 
        {
            $tabs[] = "fitnessTest";
        }
        if (($Pending_License_Details !== "0") && (count($License) > "0")) 
        {
            $tabs[] = "license";
        }
        if (($Booking_for_Appovel !== "0") && (count($Vbooking) > "0")) 
        {
            $tabs[] = "vehicleBooking";
        }
        if (($Approved_Booking_To_Assign !== "0") && (count($ApprovedVbooking) > "0")) 
        {
            $tabs[] = "Approved_Booking_To_Assign";
        }
        if (($Repair_for_Approvel !== "0") && (count($repair) > "0"))             
        {            
            $tabs[] = "repair";
        }
        if (($Battery_Replacement_For_Approvel !== "0") && (count($batteryReplacementPending) > "0")) 
        {
            $tabs[] = "battReplacement";
        }
        if (($Tyre_Replacement_For_Approvel !== "0") && (count($tireReplacementPending) > "0")) 
        {
            $tabs[] = "tireReplacement";
        }
        if (($Fuel_Requests !== "0") && (count($fuelRequestPending) > "0")) 
        {
            $tabs[] = "fuelRequest";
        }
//
//                setting activeTabs VeryDelay


        $tabsNonCritical = array();

        if (($Pending_Insuarance_Details !== "0") && (count($nonCriticalInsurance) > "0")) 
        {
            $tabsNonCritical[] = "insuarance3";
        }

        if (($Pending_Emmission_Test !== "0") && (count($nonCriticalEmission) > "0")) 
        {
            $tabsNonCritical[] = "emmisionTest3";
        }

        if (($Pending_Fitness_Test_Details !== "0") && (count($nonCriticalFitness) > "0")) 
        {
            $tabsNonCritical[] = "fitnessTest3";
        }

        if (($Pending_License_Details !== "0") && (count($nonCriticalLicense) > "0")) 
        {
            $tabsNonCritical[] = "license3";
        }

        if (($Booking_for_Appovel !== "0") && (count($pendingBookingNonCritical) > "0"))
        {            
            $tabsNonCritical[] = "vehicleBooking3";
        }

        if (($Approved_Booking_To_Assign !== "0") && (count($ApprovedVbookingNonCritical) > "0")) 
        {
            $tabsNonCritical[] = "Approved_Booking_To_Assign3";
        }

        if (($Repair_for_Approvel !== "0") && (count($repairNonCritical) > "0")) 
        {
            $tabsNonCritical[] = "repair3";
        }

        if (($Battery_Replacement_For_Approvel !== "0") && (count($batteryPendingNonCritical) > "0")) 
        {
            $tabsNonCritical[] = "battReplacement3";
        }

        if (($Tyre_Replacement_For_Approvel !== "0") && (count($tirePendingNonCritical) > "0"))
        {
            $tabsNonCritical[] = "tireReplacement3";
        }

        if (($Fuel_Requests !== "0") && (count($fuelRequestNonCritical) > "0")) 
        {
            $tabsNonCritical[] = "fuelRequest3";
        }

//                setting activeTabs shortDelay

        $tabsWarning = array();

        if (($Pending_Insuarance_Details !== "0") && (count($warninglInsurance) > "0")) {

            $tabsWarning[] = "insuarance2";
        }

        if (($Pending_Emmission_Test !== "0") && (count($warningEmission) > "0")) {
            $tabsWarning[] = "emmisionTest2";
        }

        if (($Pending_Fitness_Test_Details !== "0") && (count($warningFitness) > "0")) {

            $tabsWarning[] = "fitnessTest2";
        }

        if (($Pending_License_Details !== "0") && (count($warningLicense) > "0")) {

            $tabsWarning[] = "license2";
        }

        if (($Booking_for_Appovel !== "0") && (count($pendingBookingWarning) > "0")) {

            $tabsWarning[] = "vehicleBooking2";
        }

        if (($Approved_Booking_To_Assign !== "0") && (count($warningApprovedVbooking) > "0")) {

            $tabsWarning[] = "Approved_Booking_To_Assign2";
        }

        if (($Repair_for_Approvel !== "0") && ($Repair_for_Approvel !== "0") && (count($warningPendingRepair) > "0")) {
            $tabsWarning[] = "repair2";
        }

        if (($Battery_Replacement_For_Approvel !== "0") && (count($warningPendingBatteryRequest) > "0")) {
            $tabsWarning[] = "battReplacement2";
        }

        if (($Tyre_Replacement_For_Approvel !== "0") && (count($warningPendingTyreRequest) > "0")) {

            $tabsWarning[] = "tireReplacement2";
        }

        if (($Fuel_Requests !== "0") && (count($warningPendingFuelRequest) > "0")) {

            $tabsWarning[] = "fuelRequest2";
        }



        //                setting activeTabs noDelay

        $tabsCritical = array();

        if (($Pending_Insuarance_Details !== "0") && (count($criticalInsurance) > "0")) {

            $tabsCritical[] = "insuarance1";
        }

        if (($Pending_Emmission_Test !== "0") && (count($criticalEmission) > "0")) {
            $tabsCritical[] = "emmisionTest1";
        }

        if (($Pending_Fitness_Test_Details !== "0") && (count($criticalFitness) > "0")) {

            $tabsCritical[] = "fitnessTest1";
        }

        if (($Pending_License_Details !== "0") && (count($criticalLicense) > "0")) {

            $tabsCritical[] = "license1";
        }

        if (($Booking_for_Appovel !== "0") && (count($pendingBookingCritical) > "0")) {

            $tabsCritical[] = "vehicleBooking1";
        }
        //new
        if (($Approved_Booking_To_Assign !== "0") && (count($criticalApprovedBooking) > "0")) {

            $tabsCritical[] = "Approved_Booking_To_Assign1";
        }

        if (($Repair_for_Approvel !== "0") && (count($criticalPendingRepair) > "0")) {
            $tabsCritical[] = "repair1";
        }

        if (($Battery_Replacement_For_Approvel !== "0") && (count($criticalPendingBatteryRequest) > "0")) {
            $tabsCritical[] = "battReplacement1";
        }

        if (($Tyre_Replacement_For_Approvel !== "0") && (count($criticalPendingTyreRequest) > "0")) {

            $tabsCritical[] = "tireReplacement1";
        }

        if (($Fuel_Requests !== "0") && (count($criticalPendingFuelRequest) > "0")) {

            $tabsCritical[] = "fuelRequest1";
        }

        ?>


        <!-- div tab all       -->
        <div id="tab-container" >
        <div>
            <table style="width:250px;">
                <tr>
                    <td>Critical
                        <svg width="20" height="10">
                            <rect width="20" height="10" style="fill:rgb(255,182,193);stroke-width:2;stroke:rgb(0,0,0)" />
                        </svg></td>


                    <td>Warning
                        <svg width="20" height="10">
                            <rect width="20" height="10" style="fill:rgb(255,215,0);stroke-width:2;stroke:rgb(0,0,0)" />
                        </svg></td>
                    <td>Non Critical
                        <svg width="20" height="10">
                            <rect width="20" height="10" style="fill:rgb(135,206,250);stroke-width:2;stroke:rgb(0,0,0)" />
                        </svg></td>
                </tr>
            </table>
        </div>
        <ul class="tab-menu">
            <?php
            if (($Pending_Insuarance_Details !== "0") && (count($alllInsurance) > "0")) {
                ?>
                <li id="insuarance" class="" >Insurance</li>
            <?php
            }
            if (($Pending_Emmission_Test !== "0") && (count($Emmission) > "0")) {
                ?>
                <li id="emmisionTest" class="" >Emission Test</li>
            <?php
            }
            if (($Pending_Fitness_Test_Details !== "0") && count($Fitness) > "0") {
                ?>
                <li id="fitnessTest" class="" >Fitness Test</li>
            <?php
            }
            if (($Pending_License_Details !== "0") && (count($License) > "0")) {
                ?>
                <li id="license" class="" >License</li>
            <?php
            }
            if (($Booking_for_Appovel !== "0") && (count($Vbooking) > "0")) {
                ?>
                <li id="vehicleBooking" class="" >Booking</li>
            <?php
            }
            //new
            if (($Approved_Booking_To_Assign !== "0") && (count($ApprovedVbooking) > "0")) {
                ?>
                <li id="Approved_Booking_To_Assign" class="" >Approved Booking(s)</li>
            <?php
            }
            if (($Repair_for_Approvel !== "0") && (count($repair) > "0")) {
                ?>
                <li id="repair" class="" >Repair</li>
            <?php
            }
            if (($Battery_Replacement_For_Approvel !== "0") && (count($batteryReplacementPending)) > "0") {
                ?>
                <li id="battReplacement" class="" >Battery</li>
            <?php
            }
            if (($Tyre_Replacement_For_Approvel !== "0") && (count($tireReplacementPending) > "0")) {
                ?>
                <li id="tireReplacement" class="" >Tyre</li>
            <?php
            }
            if (($Fuel_Requests !== "0") && (count($fuelRequestPending)  > "0")) {
                ?>
                <li id="fuelRequest" class="" >Fuel</li>
            <?php } ?>

        </ul>

        <div class="clear"></div>
        <div class="tab-top-border"></div>
        <div id="insuarance-Tab" class="tab-content">

            <h1>Pending Insurance Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($alllInsurance); $i++) {
                    ?>
                    <tr
                        <?php
                        if (($criticalPeriod >= $alllInsurance[$i]['dateCount']) && (($alllInsurance[$i]['dateCount']) >= $delay )) {
                            echo 'id= "error"';
                        } elseif (($nonCriticalPeriod > $alllInsurance[$i]['dateCount']) && (($alllInsurance[$i]['dateCount']) > $criticalPeriod )) {
                            echo 'id= "warning"';
                        } else {
                            echo 'id= "notice"';
                        }
                        ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $alllInsurance[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $alllInsurance[$i]['Location_Name'] ?></td>
                        <td><?php echo $alllInsurance[$i]['Valid_To'] ?></td>
                        <td><?php echo $alllInsurance[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="emmisionTest-Tab" class="tab-content">

            <h1>Pending Emission Test </h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($Emmission); $i++) {
                    ?>
                    <tr
                        <?php 
                        if (($criticalPeriod >= $Emmission[$i]['dateCount']) && (($Emmission[$i]['dateCount']) >= $delay )) {
                            echo 'id= "error"';
                        } elseif (($nonCriticalPeriod > $Emmission[$i]['dateCount']) && (($Emmission[$i]['dateCount']) > $criticalPeriod )) {
                            echo 'id= "warning"';
                        } else {
                            echo 'id= "notice"';
                        }
                        
                       
                        ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $Emmission[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $Emmission[$i]['Location_Name'] ?></td>
                        <td><?php echo $Emmission[$i]['Valid_To'] ?></td>
                        <td><?php echo $Emmission[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="fitnessTest-Tab" class="tab-content">

            <h1>Pending Fitness Test Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                    <tbody>
                    <?php
                    for ($i = 0; $i < count($Fitness); $i++) {
                    ?>
                <tr
                    <?php
                        if (($criticalPeriod >= $Fitness[$i]['dateCount']) && (($Fitness[$i]['dateCount']) >= $delay )) {
                            echo 'id= "error"';
                        } elseif (($nonCriticalPeriod > $Fitness[$i]['dateCount']) && (($Fitness[$i]['dateCount']) > $criticalPeriod )) {
                            echo 'id= "warning"';
                        } else {
                            echo 'id= "notice"';
                        }
                    
                    ?>>
                    <td> <?php echo $i + 1; ?></td>
                    <td><?php echo $Fitness[$i]['Vehicle_No'] ?></td>
                    <td><?php echo $Fitness[$i]['Location_Name'] ?></td>
                    <td><?php echo $Fitness[$i]['Valid_To'] ?></td>
                    <td><?php echo $Fitness[$i]['remainingDays'] ?></td>

                </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div id="license-Tab" class="tab-content">

            <h1>Pending License Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($License); $i++) {
                    ?>
                    <tr
                        <?php
                        if (($criticalPeriod >= $License[$i]['dateCount']) && (($License[$i]['dateCount']) >= $delay )) {
                            echo 'id= "error"';
                        } elseif (($nonCriticalPeriod > $License[$i]['dateCount']) && (($License[$i]['dateCount']) > $criticalPeriod )) {
                            echo 'id= "warning"';
                        } else {
                            echo 'id= "notice"';
                        }                      
                      
                        ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $License[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $License[$i]['Location_Name'] ?></td>
                        <td><?php echo $License[$i]['Valid_To'] ?></td>
                        <td><?php echo $License[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="vehicleBooking-Tab" class="tab-content">

            <h1>Pending Vehicle Booking Requests</h1>

            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Requested Date/Time</th>
                    <th>Requested By</th>
                    <th>Vehicle Category</th>
                    <th>Place From</th>
                    <th>Place To</th>
                    <th>From Date/Time</th>
                    <th>To Date/Time</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($Vbooking); $i++) {
                    ?>
                    <tr
                        <?php
                        if($Vbooking[$i]['dateCount'] < $Booking_Expiration)
                        {
                            TRVehicleBooking::model()->DisApprove($Vbooking[$i]['Booking_Request_ID'], "Automatically disapproved by the system as it was expired.", "System");
                        }
                        elseif (($Booking_Critical >= $Vbooking[$i]['dateCount']) && (($Vbooking[$i]['dateCount']) >= $Booking_Expiration )) {
                            echo 'id= "error"';
                        } elseif (($Booking_Non_Critical > $Vbooking[$i]['dateCount']) && (($Vbooking[$i]['dateCount']) > $Booking_Critical )) {
                            echo 'id= "warning"';
                        } else {
                            echo 'id= "notice"';
                        }
                      
                        ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $Vbooking[$i]['Requested_Date'] ?></td>
                        <td><?php echo $Vbooking[$i]['username'] ?></td>
                        <td><?php echo $Vbooking[$i]['Category_Name'] ?></td>
                        <td><?php echo $Vbooking[$i]['Place_from'] ?></td>
                        <td><?php echo $Vbooking[$i]['Place_to'] ?></td>
                        <td><?php echo $Vbooking[$i]['From'] ?></td>
                        <td><?php echo $Vbooking[$i]['To'] ?></td>
                        <td><?php
                            echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl('TRVehicleBooking/DashboardPendingBooking&menuId=dashboard')
                            )
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>

        <!---new--->
        <div id="Approved_Booking_To_Assign-Tab" class="tab-content">

            <h1>Approved Vehicle Booking Requests</h1>

            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Requested Date/Time</th>
                    <th>Requested By</th>
                    <th>Vehicle Category</th>
                    <th>Place From</th>
                    <th>Place To</th>
                    <th>From Date/Time</th>
                    <th>To Date/Time</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($ApprovedVbooking); $i++) {
                    ?>
                    <tr
                        <?php
                        if (($Booking_Critical >= $ApprovedVbooking[$i]['dateCount']) && (($ApprovedVbooking[$i]['dateCount']) >= $Booking_Expiration )) {
                            echo 'id= "error"';
                        } elseif (($Booking_Non_Critical > $ApprovedVbooking[$i]['dateCount']) && (($ApprovedVbooking[$i]['dateCount']) > $Booking_Critical )) {
                            echo 'id= "warning"';
                        } else {
                            echo 'id= "notice"';
                        }
                                              
                        ?>>
                        <td> <?php echo $i + 1; ?> </td>
                        <td> <?php echo $ApprovedVbooking[$i]['Requested_Date'] ?> </td>
                        <td> <?php echo $ApprovedVbooking[$i]['username'] ?> </td>
                        <td> <?php echo $ApprovedVbooking[$i]['Category_Name'] ?> </td>
                        <td> <?php echo $ApprovedVbooking[$i]['Place_from'] ?> </td>
                        <td> <?php echo $ApprovedVbooking[$i]['Place_to'] ?> </td>
                        <td> <?php echo $ApprovedVbooking[$i]['From'] ?> </td>
                        <td> <?php echo $ApprovedVbooking[$i]['To'] ?> </td>
                        <td> <?php echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl('TRVehicleBooking/DashboardApprovedBooking&menuId=dashboard')); ?> </td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>

        <div id="repair-Tab" class="tab-content">

            <h1>Repair Estimate for Approval</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Garage</th>
                    <th>Total Estimate</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($repair); $i++) {
                    ?>
                    <tr
                        <?php
                                              
                        if (($criticalPeriod >= $repair[$i]['dateCount']) && (($repair[$i]['dateCount']) >= $delay )) {
                            echo 'id= "notice"';
                        } elseif (($nonCriticalPeriod > $repair[$i]['dateCount']) && (($repair[$i]['dateCount']) > $criticalPeriod )) {
                            echo 'id= "warning"';
                        } else {
                            echo 'id= "error"';
                        }
                        ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $repair[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $repair[$i]['Location_Name'] ?></td>
                        <td><?php echo $repair[$i]['Garage_Name'] ?></td>
                        <td><?php echo $repair[$i]['Total_Estimate'] ?></td>
                        <td> <?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRRepairEstimateDetails/DashboardPendingRepair&menuId=dashboard"))
                           
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRRepairEstimateDetails/approveEstimate", array("estimateId" =>
                                $repair[$i]["Estimate_ID"], "requestId" => $repair[$i]["Request_ID"])))*/
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="battReplacement-Tab" class="tab-content">

            <h1>Pending Battery Replacement Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Battery Type</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($batteryReplacementPending); $i++) {
                    ?>
                    <tr
                        <?php
                        if (($criticalPeriod >= $batteryReplacementPending[$i]['dateCount']) && (($batteryReplacementPending[$i]['dateCount']) >= $delay )) {
                            echo 'id= "notice"';
                        } elseif (($nonCriticalPeriod > $batteryReplacementPending[$i]['dateCount']) && (($batteryReplacementPending[$i]['dateCount']) > $criticalPeriod )) {
                            echo 'id= "warning"';
                        } else {
                            echo 'id= "error"';
                        }
                        ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $batteryReplacementPending[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $batteryReplacementPending[$i]['Location_Name'] ?></td>
                        <td><?php echo $batteryReplacementPending[$i]['dName'] ?></td>
                        <td><?php echo $batteryReplacementPending[$i]['Battery_Type'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRBatteryDetails/DashboardPendingBatteryRequests&menuId=dashboard"))
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRBatteryDetails/approveBattery", array("batterydetailsid" =>
                                $batteryReplacementPending[$i]["Battery_Details_ID"], "vid" =>
                                $batteryReplacementPending[$i]["Vehicle_No"])))*/
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="tireReplacement-Tab" class="tab-content">

            <h1>Pending Tyre Replacements Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Tyre Type</th>
                    <th>Tyre Size</th>
                    <th>Tyre Quantity</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                $cntTyre = count($tireReplacementPending);
                for ($i = 0; $i < $cntTyre; $i++) {
                    ?>
                    <tr
                        <?php
                        if (($criticalPeriod >= $tireReplacementPending[$i]['dateCount']) && (($tireReplacementPending[$i]['dateCount']) >= $delay )) {
                            echo 'id= "notice"';
                        } elseif (($nonCriticalPeriod > $tireReplacementPending[$i]['dateCount']) && (($tireReplacementPending[$i]['dateCount']) > $criticalPeriod )) {
                            echo 'id= "warning"';
                        } else {
                            echo 'id= "error"';
                        }
                        ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $tireReplacementPending[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $tireReplacementPending[$i]['Location_Name'] ?></td>
                        <td><?php echo $tireReplacementPending[$i]['Dname'] ?></td>
                        <td><?php echo $tireReplacementPending[$i]['Tyre_Type'] ?></td>
                        <td><?php echo $tireReplacementPending[$i]['Tyre_Size'] ?></td>
                        <td><?php echo $tireReplacementPending[$i]['Tyre_quantity'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRTyreDetails/DashboardPendingTyreRequests&menuId=dashboard"))
                                
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRTyreDetails/approveTyre", array("tyreDetailsId" =>
                                $tireReplacementPending[$i]["Tyre_Details_ID"], "Vid" =>
                                $tireReplacementPending[$i]["Vehicle_No"])))*/
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div id="fuelRequest-Tab" class="tab-content">

            <h1>Pending Fuel Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Request Date</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Required Fuel Capacity (l)</th>
                    <th>Fuel Balance (l)</th>
                    <th>Meter Reading</th>
                    <th>View</th>

                </tr>
                <tbody>
                <?php
                $cntFuel = count($fuelRequestPending);
                for ($i = 0; $i < $cntFuel ; $i++) {
                    ?>
                    <tr
                        <?php
                        if (($criticalPeriod >= $fuelRequestPending[$i]['dateCount']) && (($fuelRequestPending[$i]['dateCount']) >= $delay )) {
                            echo 'id= "notice"';
                        } elseif (($nonCriticalPeriod > $fuelRequestPending[$i]['dateCount']) && (($fuelRequestPending[$i]['dateCount']) > $criticalPeriod )) {
                            echo 'id= "warning"';
                        } else {
                            echo 'id= "error"';
                        }                        
                       
                        ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $fuelRequestPending[$i]['Request_Date'] ?></td>
                        <td><?php echo $fuelRequestPending[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $fuelRequestPending[$i]['Location_Name'] ?></td>
                        <td><?php echo $fuelRequestPending[$i]['Dname'] ?></td>
                        <td><?php echo $fuelRequestPending[$i]['Required_Fuel_Capacity'] ?></td>
                        <td><?php echo $fuelRequestPending[$i]['Fuel_Balance'] ?></td>
                        <td><?php echo $fuelRequestPending[$i]['Meter_Reading'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRFuelRequestDetails/dashboardPendingFuelRequests&menuId=dashboard"))
                                
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRFuelRequestDetails/approveFuelRequest", array("requestId" =>
                                $fuelRequestPending[$i]["Fuel_Request_ID"], "Vid" => $fuelRequestPending[$i]["Vehicle_No"])))*/
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>

        </div>







        <!--delay  tab       -->
        <div id="tab-container1" >
        <table style="width:250px;">
            <tr>
                <td>Critical
                    <svg width="20" height="10">
                        <rect width="20" height="10" style="fill:rgb(255,182,193);stroke-width:2;stroke:rgb(0,0,0)" />
                    </svg></td>

            </tr>
        </table>
        <ul class="tab-menu1">
            <?php
            if (($Pending_Insuarance_Details !== "0") && (count($criticalInsurance) > "0")) {
                ?>
                <li id="insuarance1" class="" >Insurance</li>
            <?php
            }
            if (($Pending_Emmission_Test !== "0") && (count($criticalEmission) > "0")) {
                ?>
                <li id="emmisionTest1" class="" >Emission Test</li>
            <?php
            }
            if (($Pending_Fitness_Test_Details !== "0") && count($criticalFitness) > "0") {
                ?>
                <li id="fitnessTest1" class="" >Fitness Test</li>
            <?php
            }
            if (($Pending_License_Details !== "0") && (count($criticalLicense) > "0")) {
                ?>
                <li id="license1" class="" >License</li>
            <?php
            }
            if (($Booking_for_Appovel !== "0") && (count($pendingBookingCritical) > "0")) {
                ?>
                <li id="vehicleBooking1" class="" >Booking</li>
            <?php
            }
            //new
            if (($Approved_Booking_To_Assign !== "0") && (count($criticalApprovedBooking) > "0")) {
                ?>
                <li id="Approved_Booking_To_Assign1" class="" >Approved Booking(s)</li>
            <?php
            }
            if (($Repair_for_Approvel !== "0") && (count($criticalPendingRepair) > "0")) {
                ?>
                <li id="repair1" class="" >Repair</li>
            <?php
            }
            if (($Battery_Replacement_For_Approvel !== "0") && (count($criticalPendingBatteryRequest)) > "0") {
                ?>
                <li id="battReplacement1" class="" >Battery</li>
            <?php
            }
            if (($Tyre_Replacement_For_Approvel !== "0") && (count($criticalPendingTyreRequest) > "0")) {
                ?>
                <li id="tireReplacement1" class="" >Tyre</li>
            <?php
            }
            if (($Fuel_Requests !== "0") && (count($criticalPendingFuelRequest) > "0")) {
                ?>
                <li id="fuelRequest1" class="" >Fuel</li>
            <?php } ?>

        </ul>

        <div class="clear"></div>
        <div class="tab-top-border"></div>
        <div id="insuarance1-Tab" class="tab-content">

            <h1>Pending Insurance Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($criticalInsurance); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "error"';  ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $criticalInsurance[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $criticalInsurance[$i]['Location_Name'] ?></td>
                        <td><?php echo $criticalInsurance[$i]['Valid_To'] ?></td>
                        <td><?php echo $criticalInsurance[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="emmisionTest1-Tab" class="tab-content">

            <h1>Pending Emission Test </h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($criticalEmission); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "error"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $criticalEmission[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $criticalEmission[$i]['Location_Name'] ?></td>
                        <td><?php echo $criticalEmission[$i]['Valid_To'] ?></td>
                        <td><?php echo $criticalEmission[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div id="fitnessTest1-Tab" class="tab-content">

            <h1>Pending Fitness Test Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                    <tbody>
                    <?php
                    for ($i = 0; $i < count($criticalFitness); $i++) {
                    ?>
                <tr
                    <?php echo 'id= "error"';  ?>>
                    <td> <?php echo $i + 1; ?></td>
                    <td><?php echo $criticalFitness[$i]['Vehicle_No'] ?></td>
                    <td><?php echo $criticalFitness[$i]['Location_Name'] ?></td>
                    <td><?php echo $criticalFitness[$i]['Valid_To'] ?></td>
                    <td><?php echo $criticalFitness[$i]['remainingDays'] ?></td>

                </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div id="license1-Tab" class="tab-content">

            <h1>Pending License Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($criticalLicense); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "error"';  ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $criticalLicense[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $criticalLicense[$i]['Location_Name'] ?></td>
                        <td><?php echo $criticalLicense[$i]['Valid_To'] ?></td>
                        <td><?php echo $criticalLicense[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="vehicleBooking1-Tab" class="tab-content">

            <h1>Pending Vehicle Booking Requests</h1>

            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Requested Date/Time</th>
                    <th>Requested By</th>
                    <th>Vehicle Category</th>
                    <th>Place From</th>
                    <th>Place To</th>
                    <th>From Date/Time</th>
                    <th>To Date/Time</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                //echo count($pendingBookingNonCritical).'dfsdf';exit;
                for ($i = 0; $i < count($pendingBookingCritical); $i++) { 
                    $abc = $pendingBookingCritical[0]['Requested_Date'];
                    ?>
                    <tr
                        <?php
                        echo 'id= "error"';?> >
                        <td> <?php echo $i+1; ?></td>
                        <td><?php echo $pendingBookingCritical[$i]['Requested_Date']; ?></td>
                        <td><?php echo $pendingBookingCritical[$i]['username'] ?></td>
                        <td><?php echo $pendingBookingCritical[$i]['Category_Name'] ?></td>
                        <td><?php echo $pendingBookingCritical[$i]['Place_from'] ?></td>
                        <td><?php echo $pendingBookingCritical[$i]['Place_to'] ?></td>
                        <td><?php echo $pendingBookingCritical[$i]['From'] ?></td>
                        <td><?php echo $pendingBookingCritical[$i]['To'] ?></td>
                        <td><?php
                            echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl('TRVehicleBooking/DashboardPendingBooking&menuId=dashboard')
                            )
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <!---new--->
        <div id="Approved_Booking_To_Assign1-Tab" class="tab-content">

            <h1>Approved Vehicle Booking Requests</h1>

            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Requested Date/Time</th>
                    <th>Requested By</th>
                    <th>Vehicle Category</th>
                    <th>Place From</th>
                    <th>Place To</th>
                    <th>From Date/Time</th>
                    <th>To Date/Time</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($criticalApprovedBooking); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "error"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $criticalApprovedBooking[$i]['Requested_Date'] ?></td>
                        <td><?php echo $criticalApprovedBooking[$i]['username'] ?></td>
                        <td><?php echo $criticalApprovedBooking[$i]['Category_Name'] ?></td>
                        <td><?php echo $criticalApprovedBooking[$i]['Place_from'] ?></td>
                        <td><?php echo $criticalApprovedBooking[$i]['Place_to'] ?></td>
                        <td><?php echo $criticalApprovedBooking[$i]['From'] ?></td>
                        <td><?php echo $criticalApprovedBooking[$i]['To'] ?></td>
                        <td><?php
                            echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl('TRVehicleBooking/DashboardApprovedBooking&menuId=dashboard')
                            )
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="repair1-Tab" class="tab-content">

            <h1>Repair Estimate for Approval</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Garage</th>
                    <th>Total Estimate</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($criticalPendingRepair); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "error"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $criticalPendingRepair[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $criticalPendingRepair[$i]['Location_Name'] ?></td>
                        <td><?php echo $criticalPendingRepair[$i]['Garage_Name'] ?></td>
                        <td><?php echo $criticalPendingRepair[$i]['Total_Estimate'] ?></td>
                        <td> <?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRRepairEstimateDetails/DashboardPendingRepair&menuId=dashboard"))
                                
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRRepairEstimateDetails/approveEstimate", array("estimateId" =>
                                $repairNonCritical[$i]["Estimate_ID"], "requestId" => $repairNonCritical[$i]["Request_ID"])))*/
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="battReplacement1-Tab" class="tab-content">

            <h1>Pending Battery Replacement Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Battery Type</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($criticalPendingBatteryRequest); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "error"'; ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $criticalPendingBatteryRequest[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $criticalPendingBatteryRequest[$i]['Location_Name'] ?></td>
                        <td><?php echo $criticalPendingBatteryRequest[$i]['dName'] ?></td>
                        <td><?php echo $criticalPendingBatteryRequest[$i]['Battery_Type'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRBatteryDetails/DashboardPendingBatteryRequests&menuId=dashboard"))
                                
                           /* echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRBatteryDetails/approveBattery", array("batterydetailsid" =>
                                $batteryPendingNonCritical[$i]["Battery_Details_ID"], "vid" =>
                                $batteryPendingNonCritical[$i]["Vehicle_No"])))*/
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="tireReplacement1-Tab" class="tab-content">

            <h1>Pending Tyre Replacements Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Tyre Type</th>
                    <th>Tyre Size</th>
                    <th>Tyre Quantity</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($criticalPendingTyreRequest); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "error"'; ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $criticalPendingTyreRequest[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $criticalPendingTyreRequest[$i]['Location_Name'] ?></td>
                        <td><?php echo $criticalPendingTyreRequest[$i]['Dname'] ?></td>
                        <td><?php echo $criticalPendingTyreRequest[$i]['Tyre_Type'] ?></td>
                        <td><?php echo $criticalPendingTyreRequest[$i]['Tyre_Size'] ?></td>
                        <td><?php echo $criticalPendingTyreRequest[$i]['Tyre_quantity'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRTyreDetails/DashboardPendingTyreRequests&menuId=dashboard"))
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRTyreDetails/approveTyre", array("tyreDetailsId" =>
                                $tirePendingNonCritical[$i]["Tyre_Details_ID"], "Vid" =>
                                $tirePendingNonCritical[$i]["Vehicle_No"]))) */
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div id="fuelRequest1-Tab" class="tab-content">

            <h1>Pending Fuel Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Request Date</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Required Fuel Capacity (l)</th>
                    <th>Fuel Balance (l)</th>
                    <th>Meter Reading</th>
                    <th>View</th>

                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($criticalPendingFuelRequest); $i++) {
                    ?>
                    <tr
                        <?php  echo 'id= "error"'; ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $criticalPendingFuelRequest[$i]['Request_Date'] ?></td>
                        <td><?php echo $criticalPendingFuelRequest[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $criticalPendingFuelRequest[$i]['Location_Name'] ?></td>
                        <td><?php echo $criticalPendingFuelRequest[$i]['Dname'] ?></td>
                        <td><?php echo $criticalPendingFuelRequest[$i]['Required_Fuel_Capacity'] ?></td>
                        <td><?php echo $criticalPendingFuelRequest[$i]['Fuel_Balance'] ?></td>
                        <td><?php echo $criticalPendingFuelRequest[$i]['Meter_Reading'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRFuelRequestDetails/dashboardPendingFuelRequests&menuId=dashboard"))
                           
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRFuelRequestDetails/approveFuelRequest", array("requestId" =>
                                $fuelRequestNonCritical[$i]["Fuel_Request_ID"], "Vid" => $fuelRequestNonCritical[$i]["Vehicle_No"])))
                           */ ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>

        </div>
        <!--end of delay tab-->

        <!-- start short delay tab -->
        <div id="tab-container2" >
        <table style="width:250px;">
            <tr>
                <td>Warning
                    <svg width="20" height="10">
                        <rect width="20" height="10" style="fill:rgb(255,215,0);stroke-width:2;stroke:rgb(0,0,0)" />
                    </svg></td>
            </tr>
        </table>
        <ul class="tab-menu2">
            <?php
            if (($Pending_Insuarance_Details !== "0") && (count($warninglInsurance) > "0")) {
                ?>
                <li id="insuarance2" class="" >Insurance</li>
            <?php
            }
            if (($Pending_Emmission_Test !== "0") && (count($warningEmission) > "0")) {
                ?>
                <li id="emmisionTest2" class="" >Emission Test</li>
            <?php
            }
            if (($Pending_Fitness_Test_Details !== "0") && count($warningFitness) > "0") {
                ?>
                <li id="fitnessTest2" class="" >Fitness Test</li>
            <?php
            }
            if (($Pending_License_Details !== "0") && (count($warningLicense) > "0")) {
                ?>
                <li id="license2" class="" >License</li>
            <?php
            }
            if (($Booking_for_Appovel !== "0") && (count($pendingBookingWarning) > "0")) {
                ?>
                <li id="vehicleBooking2" class="" >Booking</li>
            <?php
            }
            //new
            if (($Approved_Booking_To_Assign !== "0") && (count($warningApprovedVbooking) > "0")) {
                ?>
                <li id="Approved_Booking_To_Assign2" class="" >Approved Booking(s)</li>
            <?php
            }
            if (($Repair_for_Approvel !== "0") && (count($warningPendingRepair) > "0")) {
                ?>
                <li id="repair2" class="" >Repair</li>
            <?php
            }
            if (($Battery_Replacement_For_Approvel !== "0") && (count($warningPendingBatteryRequest)) > "0") {
                ?>
                <li id="battReplacement2" class="" >Battery</li>
            <?php
            }
            if (($Tyre_Replacement_For_Approvel !== "0") && (count($warningPendingTyreRequest) > "0")) {
                ?>
                <li id="tireReplacement2" class="" >Tyre</li>
            <?php
            }
            if (($Fuel_Requests !== "0") && (count($warningPendingFuelRequest) > "0")) {
                ?>
                <li id="fuelRequest2" class="" >Fuel</li>
            <?php } ?>

        </ul>

        <div class="clear"></div>
        <div class="tab-top-border"></div>
        <div id="insuarance2-Tab" class="tab-content">

            <h1>Pending Insurance Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($warninglInsurance); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "warning"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $warninglInsurance[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $warninglInsurance[$i]['Location_Name'] ?></td>
                        <td><?php echo $warninglInsurance[$i]['Valid_To'] ?></td>
                        <td><?php echo $warninglInsurance[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="emmisionTest2-Tab" class="tab-content">

            <h1>Pending Emission Test </h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($warningEmission); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "warning"';?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $warningEmission[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $warningEmission[$i]['Location_Name'] ?></td>
                        <td><?php echo $warningEmission[$i]['Valid_To'] ?></td>
                        <td><?php echo $warningEmission[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="fitnessTest2-Tab" class="tab-content">

            <h1>Pending Fitness Test Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                    <tbody>
                    <?php
                    for ($i = 0; $i < count($warningFitness); $i++) {
                    ?>
                <tr
                    <?php echo 'id= "warning"'; ?>>
                    <td> <?php echo $i + 1; ?></td>
                    <td><?php echo $warningFitness[$i]['Vehicle_No'] ?></td>
                    <td><?php echo $warningFitness[$i]['Location_Name'] ?></td>
                    <td><?php echo $warningFitness[$i]['Valid_To'] ?></td>
                    <td><?php echo $warningFitness[$i]['remainingDays'] ?></td>

                </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div id="license2-Tab" class="tab-content">

            <h1>Pending License Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($warningLicense); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "warning"';?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $warningLicense[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $warningLicense[$i]['Location_Name'] ?></td>
                        <td><?php echo $warningLicense[$i]['Valid_To'] ?></td>
                        <td><?php echo $warningLicense[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="vehicleBooking2-Tab" class="tab-content">

            <h1>Pending Vehicle Booking Requests</h1>

            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Requested Date/Time</th>
                    <th>Requested By</th>
                    <th>Vehicle Category</th>
                    <th>Place From</th>
                    <th>Place To</th>
                    <th>From Date/Time</th>
                    <th>To Date/Time</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($pendingBookingWarning); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "warning"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $pendingBookingWarning[$i]['Requested_Date'] ?></td>
                        <td><?php echo $pendingBookingWarning[$i]['username'] ?></td>
                        <td><?php echo $pendingBookingWarning[$i]['Category_Name'] ?></td>
                        <td><?php echo $pendingBookingWarning[$i]['Place_from'] ?></td>
                        <td><?php echo $pendingBookingWarning[$i]['Place_to'] ?></td>
                        <td><?php echo $pendingBookingWarning[$i]['From'] ?></td>
                        <td><?php echo $pendingBookingWarning[$i]['To'] ?></td>
                        <td><?php
                            echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl('TRVehicleBooking/DashboardPendingBooking&menuId=dashboard')
                            )
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>

        <!--new-->

        <div id="Approved_Booking_To_Assign2-Tab" class="tab-content">

            <h1>Approved Vehicle Booking Requests</h1>

            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Requested Date/Time</th>
                    <th>Requested By</th>
                    <th>Vehicle Category</th>
                    <th>Place From</th>
                    <th>Place To</th>
                    <th>From Date/Time</th>
                    <th>To Date/Time</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($warningApprovedVbooking); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "warning"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $warningApprovedVbooking[$i]['Requested_Date'] ?></td>
                        <td><?php echo $warningApprovedVbooking[$i]['username'] ?></td>
                        <td><?php echo $warningApprovedVbooking[$i]['Category_Name'] ?></td>
                        <td><?php echo $warningApprovedVbooking[$i]['Place_from'] ?></td>
                        <td><?php echo $warningApprovedVbooking[$i]['Place_to'] ?></td>
                        <td><?php echo $warningApprovedVbooking[$i]['From'] ?></td>
                        <td><?php echo $warningApprovedVbooking[$i]['To'] ?></td>
                        <td><?php
                            echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl('TRVehicleBooking/DashboardApprovedBooking&menuId=dashboard')
                            )
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>

        <div id="repair2-Tab" class="tab-content">

            <h1>Repair Estimate for Approval</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Garage</th>
                    <th>Total Estimate</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($warningPendingRepair); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "warning"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $warningPendingRepair[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $warningPendingRepair[$i]['Location_Name'] ?></td>
                        <td><?php echo $warningPendingRepair[$i]['Garage_Name'] ?></td>
                        <td><?php echo $warningPendingRepair[$i]['Total_Estimate'] ?></td>
                        <td> <?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRRepairEstimateDetails/DashboardPendingRepair&menuId=dashboard"))
                                
                           /* echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRRepairEstimateDetails/approveEstimate", array("estimateId" =>
                                $warningPendingRepair[$i]["Estimate_ID"], "requestId" => $warningPendingRepair[$i]["Request_ID"]))) */
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="battReplacement2-Tab" class="tab-content">

            <h1>Pending Battery Replacement Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Battery Type</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($warningPendingBatteryRequest); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "warning"'; ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $warningPendingBatteryRequest[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $warningPendingBatteryRequest[$i]['Location_Name'] ?></td>
                        <td><?php echo $warningPendingBatteryRequest[$i]['dName'] ?></td>
                        <td><?php echo $warningPendingBatteryRequest[$i]['Battery_Type'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRBatteryDetails/DashboardPendingBatteryRequests&menuId=dashboard"))
                                
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRBatteryDetails/approveBattery", array("batterydetailsid" =>
                                $warningPendingBatteryRequest[$i]["Battery_Details_ID"], "vid" =>
                                $warningPendingBatteryRequest[$i]["Vehicle_No"])))*/
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="tireReplacement2-Tab" class="tab-content">

            <h1>Pending Tyre Replacements Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Tyre Type</th>
                    <th>Tyre Size</th>
                    <th>Tyre Quantity</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($warningPendingTyreRequest); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "warning"';  ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $warningPendingTyreRequest[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $warningPendingTyreRequest[$i]['Location_Name'] ?></td>
                        <td><?php echo $warningPendingTyreRequest[$i]['Dname'] ?></td>
                        <td><?php echo $warningPendingTyreRequest[$i]['Tyre_Type'] ?></td>
                        <td><?php echo $warningPendingTyreRequest[$i]['Tyre_Size'] ?></td>
                        <td><?php echo $warningPendingTyreRequest[$i]['Tyre_quantity'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRTyreDetails/DashboardPendingTyreRequests&menuId=dashboard"))
                                
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRTyreDetails/approveTyre", array("tyreDetailsId" =>
                                $warningPendingTyreRequest[$i]["Tyre_Details_ID"], "Vid" =>
                                $warningPendingTyreRequest[$i]["Vehicle_No"])))*/
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div id="fuelRequest2-Tab" class="tab-content">

            <h1>Pending Fuel Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Request Date</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Required Fuel Capacity (l)</th>
                    <th>Fuel Balance (l)</th>
                    <th>Meter Reading</th>
                    <th>View</th>

                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($warningPendingFuelRequest); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "warning"'; ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $warningPendingFuelRequest[$i]['Request_Date'] ?></td>
                        <td><?php echo $warningPendingFuelRequest[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $warningPendingFuelRequest[$i]['Location_Name'] ?></td>
                        <td><?php echo $warningPendingFuelRequest[$i]['Dname'] ?></td>
                        <td><?php echo $warningPendingFuelRequest[$i]['Required_Fuel_Capacity'] ?></td>
                        <td><?php echo $warningPendingFuelRequest[$i]['Fuel_Balance'] ?></td>
                        <td><?php echo $warningPendingFuelRequest[$i]['Meter_Reading'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRFuelRequestDetails/dashboardPendingFuelRequests&menuId=dashboard"))
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRFuelRequestDetails/approveFuelRequest", array("requestId" =>
                                $warningPendingFuelRequest[$i]["Fuel_Request_ID"], "Vid" => $warningPendingFuelRequest[$i]["Vehicle_No"])))*/
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>

        </div>
        <!--end of short delay tab-->



        <!-- no delay  tab       -->
        <div id="tab-container3" >
        <table style="width:250px;">
            <tr>
                <td>Non Critical
                    <svg width="20" height="10">
                        <rect width="20" height="10" style="fill:rgb(135,206,250);stroke-width:2;stroke:rgb(0,0,0)" />
                    </svg></td>
            </tr>
        </table>
        <ul class="tab-menu3">
            <?php
            if (($Pending_Insuarance_Details !== "0") && (count($nonCriticalInsurance) > "0")) {
                ?>
                <li id="insuarance3" class="" >Insurance</li>
            <?php
            }
            if (($Pending_Emmission_Test !== "0") && (count($nonCriticalEmission) > "0")) {
                ?>
                <li id="emmisionTest3" class="" >Emission Test</li>
            <?php
            }
            if (($Pending_Fitness_Test_Details !== "0") && count($nonCriticalFitness) > "0") {
                ?>
                <li id="fitnessTest3" class="" >Fitness Test</li>
            <?php
            }
            if (($Pending_License_Details !== "0") && (count($nonCriticalLicense) > "0")) {
                ?>
                <li id="license3" class="" >License</li>
            <?php
            }
            if (($Booking_for_Appovel !== "0") && (count($pendingBookingNonCritical) > "0")) {
                ?>
                <li id="vehicleBooking3" class="" >Booking</li>
            <?php
            }
            //new
            if (($Approved_Booking_To_Assign !== "0") && (count($ApprovedVbookingNonCritical) > "0")) {
                ?>
                <li id="Approved_Booking_To_Assign3" class="" >Approved Booking(s)</li>
            <?php
            }
            if (($Repair_for_Approvel !== "0") && (count($repairNonCritical) > "0")) {
                ?>
                <li id="repair3" class="" >Repair</li>
            <?php
            }
            if (($Battery_Replacement_For_Approvel !== "0") && (count($batteryPendingNonCritical)) > "0") {
                ?>
                <li id="battReplacement3" class="" >Battery</li>
            <?php
            }
            if (($Tyre_Replacement_For_Approvel !== "0") && (count($tirePendingNonCritical) > "0")) {
                ?>
                <li id="tireReplacement3" class="" >Tyre</li>
            <?php
            }
            if (($Fuel_Requests !== "0") && (count($fuelRequestNonCritical) > "0")) {
                ?>
                <li id="fuelRequest3" class="" >Fuel</li>
            <?php } ?>

        </ul>

        <div class="clear"></div>
        <div class="tab-top-border"></div>
        <div id="insuarance3-Tab" class="tab-content">

            <h1>Pending Insurance Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($nonCriticalInsurance); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "notice"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $nonCriticalInsurance[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $nonCriticalInsurance[$i]['Location_Name'] ?></td>
                        <td><?php echo $nonCriticalInsurance[$i]['Valid_To'] ?></td>
                        <td><?php echo $nonCriticalInsurance[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="emmisionTest3-Tab" class="tab-content">

            <h1>Pending Emission Test </h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($nonCriticalEmission); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "notice"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $nonCriticalEmission[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $nonCriticalEmission[$i]['Location_Name'] ?></td>
                        <td><?php echo $nonCriticalEmission[$i]['Valid_To'] ?></td>
                        <td><?php echo $nonCriticalEmission[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="fitnessTest3-Tab" class="tab-content">

            <h1>Pending Fitness Test Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                    <tbody>
                    <?php
                    for ($i = 0; $i < count($nonCriticalFitness); $i++) {
                    ?>
                <tr
                    <?php echo 'id= "notice"'; ?>>
                    <td> <?php echo $i + 1; ?></td>
                    <td><?php echo $nonCriticalFitness[$i]['Vehicle_No'] ?></td>
                    <td><?php echo $nonCriticalFitness[$i]['Location_Name'] ?></td>
                    <td><?php echo $nonCriticalFitness[$i]['Valid_To'] ?></td>
                    <td><?php echo $nonCriticalFitness[$i]['remainingDays'] ?></td>

                </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div id="license3-Tab" class="tab-content">

            <h1>Pending License Details</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Valid To</th>
                    <th>Remaining Days</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($nonCriticalLicense); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "notice"';  ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $nonCriticalLicense[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $nonCriticalLicense[$i]['Location_Name'] ?></td>
                        <td><?php echo $nonCriticalLicense[$i]['Valid_To'] ?></td>
                        <td><?php echo $nonCriticalLicense[$i]['remainingDays'] ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="vehicleBooking3-Tab" class="tab-content">

            <h1>Pending Vehicle Booking Requests</h1>

            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Requested Date/Time</th>
                    <th>Requested By</th>
                    <th>Vehicle Category</th>
                    <th>Place From</th>
                    <th>Place To</th>
                    <th>From Date/Time</th>
                    <th>To Date/Time</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($pendingBookingNonCritical); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "notice"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $pendingBookingNonCritical[$i]['Requested_Date'] ?></td>
                        <td><?php echo $pendingBookingNonCritical[$i]['username'] ?></td>
                        <td><?php echo $pendingBookingNonCritical[$i]['Category_Name'] ?></td>
                        <td><?php echo $pendingBookingNonCritical[$i]['Place_from'] ?></td>
                        <td><?php echo $pendingBookingNonCritical[$i]['Place_to'] ?></td>
                        <td><?php echo $pendingBookingNonCritical[$i]['From'] ?></td>
                        <td><?php echo $pendingBookingNonCritical[$i]['To'] ?></td>
                        <td><?php
                            echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl('TRVehicleBooking/DashboardPendingBooking&menuId=dashboard')
                            )
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>

        <!--new-->
        <div id="Approved_Booking_To_Assign3-Tab" class="tab-content">

            <h1>Approved Vehicle Booking Requests</h1>

            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Requested Date/Time</th>
                    <th>Requested By</th>
                    <th>Vehicle Category</th>
                    <th>Place From</th>
                    <th>Place To</th>
                    <th>From Date/Time</th>
                    <th>To Date/Time</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($ApprovedVbookingNonCritical); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "notice"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $ApprovedVbookingNonCritical[$i]['Requested_Date'] ?></td>
                        <td><?php echo $ApprovedVbookingNonCritical[$i]['username'] ?></td>
                        <td><?php echo $ApprovedVbookingNonCritical[$i]['Category_Name'] ?></td>
                        <td><?php echo $ApprovedVbookingNonCritical[$i]['Place_from'] ?></td>
                        <td><?php echo $ApprovedVbookingNonCritical[$i]['Place_to'] ?></td>
                        <td><?php echo $ApprovedVbookingNonCritical[$i]['From'] ?></td>
                        <td><?php echo $ApprovedVbookingNonCritical[$i]['To'] ?></td>
                        <td><?php
                            echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl('TRVehicleBooking/DashboardApprovedBooking&menuId=dashboard')
                            )
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>


        <div id="repair3-Tab" class="tab-content">

            <h1>Repair Estimate for Approval</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Garage</th>
                    <th>Total Estimate</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($repairNonCritical); $i++) {
                    ?>
                    <tr
                        <?php echo 'id= "notice"'; ?>>
                        <td> <?php echo $i + 1; ?></td>
                        <td><?php echo $repairNonCritical[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $repairNonCritical[$i]['Location_Name'] ?></td>
                        <td><?php echo $repairNonCritical[$i]['Garage_Name'] ?></td>
                        <td><?php echo $repairNonCritical[$i]['Total_Estimate'] ?></td>
                        <td> <?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRRepairEstimateDetails/DashboardPendingRepair&menuId=dashboard"))
                                
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRRepairEstimateDetails/approveEstimate", array("estimateId" =>
                                $criticalPendingRepair[$i]["Estimate_ID"], "requestId" => $criticalPendingRepair[$i]["Request_ID"])))*/
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="battReplacement3-Tab" class="tab-content">

            <h1>Pending Battery Replacement Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Battery Type</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($batteryPendingNonCritical); $i++) {
                    ?>
                    <tr <?php echo 'id= "notice"'; ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $batteryPendingNonCritical[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $batteryPendingNonCritical[$i]['Location_Name'] ?></td>
                        <td><?php echo $batteryPendingNonCritical[$i]['dName'] ?></td>
                        <td><?php echo $batteryPendingNonCritical[$i]['Battery_Type'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRBatteryDetails/DashboardPendingBatteryRequests&menuId=dashboard"))
                                
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRBatteryDetails/approveBattery", array("batterydetailsid" =>
                                $criticalPendingBatteryRequest[$i]["Battery_Details_ID"], "vid" =>
                                $criticalPendingBatteryRequest[$i]["Vehicle_No"])))*/
                            ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>

        </div>
        <div id="tireReplacement3-Tab" class="tab-content">

            <h1>Pending Tyre Replacements Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Tyre Type</th>
                    <th>Tyre Size</th>
                    <th>Tyre Quantity</th>
                    <th>View</th>
                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($tirePendingNonCritical); $i++) {
                    ?>
                    <tr <?php echo 'id= "notice"'; ?>>
                        
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $tirePendingNonCritical[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $tirePendingNonCritical[$i]['Location_Name'] ?></td>
                        <td><?php echo $tirePendingNonCritical[$i]['Dname'] ?></td>
                        <td><?php echo $tirePendingNonCritical[$i]['Tyre_Type'] ?></td>
                        <td><?php echo $tirePendingNonCritical[$i]['Tyre_Size'] ?></td>
                        <td><?php echo $tirePendingNonCritical[$i]['Tyre_quantity'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRTyreDetails/DashboardPendingTyreRequests&menuId=dashboard"))
                           /* echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRTyreDetails/approveTyre", array("tyreDetailsId" =>
                                $criticalPendingTyreRequest[$i]["Tyre_Details_ID"], "Vid" =>
                                $criticalPendingTyreRequest[$i]["Vehicle_No"])))*/
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div id="fuelRequest3-Tab" class="tab-content">

            <h1>Pending Fuel Requests</h1>
            <table class="tblDashboard">
                <tr>
                    <th>No</th>
                    <th>Request Date</th>
                    <th>Vehicle No</th>
                    <th>Location</th>
                    <th>Driver Name</th>
                    <th>Required Fuel Capacity (l)</th>
                    <th>Fuel Balance (l)</th>
                    <th>Meter Reading</th>
                    <th>View</th>

                </tr>
                <tbody>
                <?php
                for ($i = 0; $i < count($fuelRequestNonCritical); $i++) {
                    ?>
                     <tr <?php echo 'id= "notice"'; ?>>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $fuelRequestNonCritical[$i]['Request_Date'] ?></td>
                        <td><?php echo $fuelRequestNonCritical[$i]['Vehicle_No'] ?></td>
                        <td><?php echo $fuelRequestNonCritical[$i]['Location_Name'] ?></td>
                        <td><?php echo $fuelRequestNonCritical[$i]['Dname'] ?></td>
                        <td><?php echo $fuelRequestNonCritical[$i]['Required_Fuel_Capacity'] ?></td>
                        <td><?php echo $fuelRequestNonCritical[$i]['Fuel_Balance'] ?></td>
                        <td><?php echo $fuelRequestNonCritical[$i]['Meter_Reading'] ?></td>
                        <td><?php
                        echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRFuelRequestDetails/dashboardPendingFuelRequests&menuId=dashboard"))
                                
                            /*echo CHtml::link('<img title="View" src="./images/view1.png">', Yii::app()->createUrl("/tRFuelRequestDetails/approveFuelRequest", array("requestId" =>
                                $criticalPendingFuelRequest[$i]["Fuel_Request_ID"], "Vid" => $criticalPendingFuelRequest[$i]["Vehicle_No"])))*/
                            ?></td>

                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>

        </div>
        <!--end of no delay tab-->

    <?php

    }

}

?>
<script type="text/javascript">
    
$(document).ready(function() {

    $("a.pop").fancybox({
        openEffect: 'elastic',
        openSpeed: 300,
        closeEffect: 'elastic',
        closeSpeed: 300,
        helpers: {
            overlay: {
                css: {
                    'background': 'rgba(238,238,238,0.85)'
                }
            }
        }
    });



    var activeTabIndex = -1;
    var tabNames = ["insuarance", "emmisionTest", "fitnessTest", "license", "vehicleBooking", "Approved_Booking_To_Assign", "repair", "battReplacement", "tireReplacement", "fuelRequest"];

    $(".tab-menu > li").click(function(e) {
        for (var i = 0; i < tabNames.length; i++) {
            if (e.target.id === tabNames[i]) {
                activeTabIndex = i;
            } else {
                $("#" + tabNames[i]).removeClass('active');
                $("#" + tabNames[i] + "-Tab").css("display", "none");
            }
        }
        $("#" + tabNames[activeTabIndex] + "-Tab").fadeIn();
        $("#" + tabNames[activeTabIndex]).addClass('active');
        return false;
    });


    var tab = (<?php
        if (isset($tabs)) {
            for ($index = 0; $index < count($tabs); $index++) {

                $activeTab = ($tabs[0]);

                break;
            }
        }
        if (isset($activeTab) && ($activeTab !== '')) {
            echo json_encode($activeTab);
        } else {

            $activeTab = 0;
            echo json_encode($activeTab);
        }
        ?>);


    if (tab.length !== 0) {
        $("#" + tab).addClass('active');
        $("#" + tab + "-Tab").fadeIn();


    }

});


$(document).ready(function() {
        //       delay
        $("a.pop1").fancybox({
            openEffect: 'elastic',
            openSpeed: 300,
            closeEffect: 'elastic',
            closeSpeed: 300,
            helpers: {
                overlay: {
                    css: {
                        'background': 'rgba(238,238,238,0.85)'
                    }
                }
            }
        });



//                        alert(tabsNonCritical);
        var activeTabIndex = -1;
        var tabNames = ["insuarance1", "emmisionTest1", "fitnessTest1", "license1", "vehicleBooking1", "Approved_Booking_To_Assign1", "repair1", "battReplacement1", "tireReplacement1", "fuelRequest1"];

        $(".tab-menu1 > li").click(function(e) {
            for (var i = 0; i < tabNames.length; i++) {
                if (e.target.id === tabNames[i]) {
                    activeTabIndex = i;
                } else {
                    $("#" + tabNames[i]).removeClass("active");
                    $("#" + tabNames[i] + "-Tab").css("display", "none");
                }
            }
            $("#" + tabNames[activeTabIndex] + "-Tab").fadeIn();
            $("#" + tabNames[activeTabIndex]).addClass("active");
            return false;
        });

        //stting active tabs
        var tabsNonCritical = (<?php
        if (isset($tabsNonCritical)) 
        {
            for ($index = 0; $index < count($tabsNonCritical); $index++) 
            {
                $activeTabVdelay = ($tabsNonCritical[0]);
                break;
            }
        }
        if (isset($activeTabVdelay) && ($activeTabVdelay !== '')) 
        {
            echo json_encode($activeTabVdelay);
        } 
        else 
        {
            $activeTabVdelay = 0;
            echo json_encode($activeTabVdelay);
        }
        ?>);


        if (tabsNonCritical.length !== 0) {
            $("#" + tabsNonCritical).addClass('active');
            $("#" + tabsNonCritical + "-Tab").fadeIn();


        }
    }
);
$(document).ready(function() {
    //       shortdelay
    $("a.pop2").fancybox({
        openEffect: 'elastic',
        openSpeed: 300,
        closeEffect: 'elastic',
        closeSpeed: 300,
        helpers: {
            overlay: {
                css: {
                    'background': 'rgba(238,238,238,0.85)'
                }
            }
        }
    });


    var activeTabIndex = -1;
    var tabNames = ["insuarance2", "emmisionTest2", "fitnessTest2", "license2", "Approved_Booking_To_Assign2","vehicleBooking2", "repair2", "battReplacement2", "tireReplacement2", "fuelRequest2"];

    $(".tab-menu2 > li").click(function(e) 
    {
        for (var i = 0; i < tabNames.length; i++) 
        {
            if (e.target.id === tabNames[i]) 
            {
                activeTabIndex = i;
            }
            else 
            {
                $("#" + tabNames[i]).removeClass("active");
                $("#" + tabNames[i] + "-Tab").css("display", "none");
            }
        }
        $("#" + tabNames[activeTabIndex] + "-Tab").fadeIn();
        $("#" + tabNames[activeTabIndex]).addClass("active");
        return false;
    });

    //stting active tabs shortDelay

    var tabsWarning = (<?php
        if (isset($tabsWarning)) {
            for ($index = 0; $index < count($tabsWarning); $index++) {

                $activeTabShortDelay = ($tabsWarning[0]);

                break;
            }
        }
        if (isset($activeTabShortDelay) && ($activeTabShortDelay !== '')) {
            echo json_encode($activeTabShortDelay);
        } else {
            $activeTabShortDelay = 0;
            echo json_encode($activeTabShortDelay);
        }
        ?>);

//        alert(tabsWarning);
    if (tabsWarning.length !== 0) {
        $("#" + tabsWarning).addClass('active');
        $("#" + tabsWarning + "-Tab").fadeIn();


    }
});

$(document).ready(function() {
    //     no  delay
    $("a.pop3").fancybox({
        openEffect: 'elastic',
        openSpeed: 300,
        closeEffect: 'elastic',
        closeSpeed: 300,
        helpers: {
            overlay: {
                css: {
                    'background': 'rgba(238,238,238,0.85)'
                }
            }
        }
    });


    var activeTabIndex = -1;
    var tabNames = ["insuarance3", "emmisionTest3", "fitnessTest3", "license3", "vehicleBooking3", "Approved_Booking_To_Assign3", "repair3", "battReplacement3", "tireReplacement3", "fuelRequest3"];

    $(".tab-menu3 > li").click(function(e) {
        for (var i = 0; i < tabNames.length; i++) {
            if (e.target.id === tabNames[i]) {
                activeTabIndex = i;
            } else {
                $("#" + tabNames[i]).removeClass("active");
                $("#" + tabNames[i] + "-Tab").css("display", "none");
            }
        }
        $("#" + tabNames[activeTabIndex] + "-Tab").fadeIn();
        $("#" + tabNames[activeTabIndex]).addClass("active");
        return false;
    });


    //stting active tabs no delay

    var tabsCritical = (<?php
        if (isset($tabsCritical)) {
            for ($index = 0; $index < count($tabsCritical); $index++) {

                $activeTabNoDelay = ($tabsCritical[0]);

                break;
            }
        }
        if (isset($activeTabNoDelay) && ($activeTabNoDelay !== '')) {
            echo json_encode($activeTabNoDelay);
        } else {
            $activeTabNoDelay = 0;
            echo json_encode($activeTabNoDelay);
        }
        ?>);

    if (tabsCritical.length !== 0) {
        $("#" + tabsCritical).addClass('active');
        $("#" + tabsCritical + "-Tab").fadeIn();


    }
});


function logOut()
{
     var basePath = window.location.href;

     var ProjectName = '<?php echo Yii::app()->baseUrl?>';
     var eqIndex = basePath.indexOf(ProjectName);

     var base = basePath.substr(0,(eqIndex)) ;
     var url = base+ProjectName+"/index.php?r=user/logout";
     window.location.href = url;

}

function gotoProfile()
{
    var basePath = window.location.href;

     var ProjectName = '<?php echo Yii::app()->baseUrl?>';
     var eqIndex = basePath.indexOf(ProjectName);

     var base = basePath.substr(0,(eqIndex)) ;
     var url = base+ProjectName+"/index.php?r=user/profile";
     window.location.href = url;
}


function changeToggleButton()
{
    var src = $('#toggleButton').attr('src');
    if(src.indexOf("down")>0)
    {
        if ( $("#userPannel").is(":visible") )
        {
            $('#toggleButton').attr('src',"images/toggle_down.png");
        }
        else
        {
            $('#toggleButton').attr('src',"images/toggle_up.png");
        }

    }
    else
    {
        if ( $("#userPannel").is(":visible") )
        {
            $('#toggleButton').attr('src',"images/toggle_down.png");
        }
        else
        {
            $('#toggleButton').attr('src',"images/toggle_up.png");
        }
    }
}
</script>
<div id="alertbox" style="border-radius: 5px; border: 1px solid darkgray; background-color:#FFFFFF">
    <img src="./images/close.png" id="close" title="Close" style="float: right;"/>
    <table id="alertData" style="padding: 5px; width:365px">
        <span><img id="stopAlerts" title="Stop alerts !" src="./images/disableAlerts.png"  onclick="disable_alerts()"/></span>
    </table>
</div>

<?php
//if (Yii::app()->user->hasFlash('success')) {
//
//    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//        'options' => array(
//            'show' => 'explod',
//            'hide' => 'explode',
//            'modal' => 'true',
//
//            'autoOpen' => true,
//            'buttons' => array(
//                'OK' => 'js:function(){$(this).dialog("close");}',),),));
//    printf('<span class="dialog">%s</span>', Yii::app()->user->getFlash('success'));
//    $this->endWidget('zii.widgets.jui.CJuiDialog');
//}
?>


<?php

date_default_timezone_set('Asia/Colombo'); ?>
<!-- Start Header -->
<header>

    <div class="subheader clearfix">
        <div class="inner-subheader">

            <div class="subheader2">

        <?php if(Yii::app()->user->isGuest)
            {
                //echo "<span style='margin-top:15px;'>".CHtml::link('Login',array('/user/login'))."</span>";
            }
            else
            {
                ?>
                <div id="content">
                    <div class="loggedUser">
                        <div class="summaryCore">
                            <img src="images/logged_user.png"/> <?php echo Yii::app()->getModule('user')->user()->username; ?>&nbsp;&nbsp;
                            <span class="arrow"></span>
                        </div>
                        <ul>
                            <li>
                                <a href="index.php?r=user/profile"><span><img src="images/profile.png" width="15px" height="15px" style="margin-right:10px;"/>View Profile</span>
                                </a></li>
                            <li>
                                <span onClick="showChangePassword()"><img src="images/changePW.png" width="15px" height="15px" style="margin-right:10px;"/>Change Password</span>
                            </li>
                            <li>
                                <span ><img src="images/help.png" width="10px" height="15px" style="margin-right:10px;"/>
                                <a href="User_Manual_Fleet_Management.pdf" target="_blank">Help</a>
                                </span>
                            </li>
                            <li>
                                <span onClick="logOut()"><img src="images/logout.png" width="15px" height="15px" style="margin-right:10px;"/>Logout</span>
                            </li>

                        </ul>

                    </div>
                </div>



              <?php
                //

            }/**/?>






                <?php  #if(!Yii::app()->user->isGuest){?>
<!--                <div style="color:#FFFFFF; margin-left: 5px"><?php #echo 'Welcome "'.Yii::app()->getModule('user')->user()->username.'"'; ?></div>-->

                    <?php #}?>
            </div>




            <div class="socials">
                <?php
                if (isset($Pending_Insuarance_Details) && isset($Pending_Emmission_Test) && isset($Pending_Fitness_Test_Details) && isset($Pending_License_Details) && isset($Booking_for_Appovel) &&(isset($Approved_Booking_To_Assign)) && isset($Repair_for_Approvel) && isset($Battery_Replacement_For_Approvel) && isset($Tyre_Replacement_For_Approvel) && isset($Fuel_Requests))
                {
                    if (($Pending_Insuarance_Details || $Pending_Emmission_Test || $Pending_Fitness_Test_Details || $Pending_License_Details || $Booking_for_Appovel || $Approved_Booking_To_Assign || $Repair_for_Approvel || $Battery_Replacement_For_Approvel || $Tyre_Replacement_For_Approvel || $Fuel_Requests) == '1')
                    {
                        if ((isset($alllInsurance) && (count($alllInsurance) > 0 )) || ( isset($Emmission) && (count($Emmission) > 0)) || (isset($Fitness) && (count($Fitness) > 0)) || ((isset($License) && (count($License) > 0)) || ((isset($License) && (count($License) > 0))) || ((isset($Vbooking) && (count($Vbooking) > 0))) || (isset($ApprovedVbooking)&&(count($ApprovedVbooking)>0))|| (isset($repair) && (count($repair) > 0)) || (isset($batteryReplacementPending)) && (count($batteryReplacementPending) > 0) || ((isset($tireReplacementPending) && (count($tireReplacementPending) > 0)) || (isset($fuelRequestPending) && (count($fuelRequestPending) > 0)))))
                        {
                           //echo $criticalCount;exit;
                            if ((isset($nonCriticalCount) && ($nonCriticalCount) > 0) || ((isset($warningCount) && ($warningCount) > 0)) || ((isset($criticalCount) && ($criticalCount) > 0)))
                            {
                                $allCount = 0;
                                if ((isset($nonCriticalCount) && ($nonCriticalCount) > 0))
                                {
                                    $allCount+=$nonCriticalCount;
                                }
                                if ((isset($warningCount) && ($warningCount) > 0))
                                {
                                    $allCount+=$warningCount;
                                }
                                if ((isset($criticalCount) && ($criticalCount) > 0))
                                {
                                    $allCount+=$criticalCount;
                                }
                                ?>
                                <div  style="margin-left: 10%; float:right;  width: auto; display:inline-flex;">
                                    <a class="pop"  href="#tab-container" >
                                        <img  src="images/bell.png" title="All Notifications" width="31px" height="39px" style="margin-top:-1%; margin-right:-5px" /><sup class="countNoti" style="margin-left:-5px;font-weight: bold"><?php echo $allCount; ?></sup></a>

                                    <?php
                                    if (isset($criticalCount) && ($criticalCount) > 0) {
                                        ?>
                                    <a class="pop1"  href="#tab-container1" ><img src="images/red_bell.png" title="Critical Notifications" width="25px" height="30px"/><sup class="countNoti" style="margin-left:-5px;font-weight: bold"><?php echo $criticalCount; ?></sup></a>
                                    <?php
                                    }

                                    if (isset($warningCount) && ($warningCount) > 0) {
                                        ?>
                                        <a class="pop2"  href="#tab-container2" ><img src="images/yellow_bell.png" title="Warning Notifications" width="25px" height="30px"/><sup class="countNoti" style="margin-left:-5px;font-weight: bold"><?php echo $warningCount; ?></sup></a>
                                    <?php
                                    }

                                    if (isset($nonCriticalCount) && ($nonCriticalCount) > 0) {
                                        ?>
                                        <a class="pop3"   href="#tab-container3" ><img src="images/blue_bell.png" title="Non Critical Notifications" width="25px" height="30px"/><sup class="countNoti" style="font-weight: bold"><?php echo $nonCriticalCount; ?></sup></a>
                                    <?php
                                    }
                                    ?>


                                </div>

                            <?php
                            }
                        }
                    }
                }
                ?>
            </div>

        </div>

    </div>

    <div class="row2">

    </div>


    <nav id="nav">


        <?php

        if (Yii::app()->user->isGuest)
        {?>
    <ul id="navlist" class="sf-menu clearfix">
        <li><div id="hedlable" style="text-align: center;"><?php echo Yii::app()->params['sysName_short']; ?></div></li>
    </ul>
    <?php
        }
        else
        {
            $userRole = Yii::app()->getModule('user')->user()->Role_ID;

            if ($userRole === '4')
            {
       ?>
         <ul id="navlist" class="sf-menu clearfix"> <li> </li>
         <li id="vehibooking"><?php echo CHtml::link('Vehicle Booking',array('/tRVehicleBooking/vehiclelist',"menuId"=>'vehiclelist')); ?></li>
         <li id="odometerMnu"><?php echo CHtml::link('Odometer',array('/odometerUpdate/vehicleListForOdometer',"menuId"=>'odometerMnu')); ?></li>
         </ul>
       <?php
            }
            else if ($userRole === '3')
            {
                ?>
                <ul id="navlist" class="sf-menu clearfix">
       <!--           <div id="logo"><?php echo CHtml::link('<img width="91px" height="50px" src="images/logo.png" style="margin-top: -5px;margin-left: -14">',array('/site/index')); ?></div>
                  <li><?php //echo CHtml::link('Odometer',array('/tRVehicleBooking/vehiclelist')); ?></li>-->
                    <li id="fuel"><?php echo CHtml::link('Fuel',array('/maVehicleRegistry/fuelRequest',"menuId"=>'fuel')); ?></li>
                    <li id="maintenance"><?php echo CHtml::link('Maintenance',array('/maVehicleRegistry/maintenanceRegistry',"menuId"=>'maintenance')); ?></li>

                    

                </ul>
            <?php

            }
            else if ($userRole === "2")
            {
                ?>
                <ul id="navlist" class="sf-menu clearfix">
<!--                <div id="logo"><?php //echo CHtml::link('<img width="91px" height="50px" src="images/logo.png" style="margin-top: -5px;margin-left: -14">',array('/site/index')); ?></div>-->
                    <li id="vehibooking"><?php echo CHtml::link('Vehicle Booking',array('/tRVehicleBooking/booking',"menuId"=>'vehibooking')); ?></li>
                </ul>
            <?php

            }
            elseif ($userRole === "6")
            {
                ?>
                <ul id="navlist" class="sf-menu clearfix">
<!--                <div id="logo"><?php echo CHtml::link('<img width="91px" height="50px" src="images/logo.png" style="margin-top: -5px;margin-left: -14">',array('/site/index')); ?></div>-->
                    <li id="dashboard"> <?php echo CHtml::link('Dashboard',array('/TRVehicleBooking/dashboardPendingBooking',"menuId"=>'dashboard')); ?></li>
                    <li id="vehibooking"><?php echo CHtml::link('Vehicle Booking',array('/tRVehicleBooking/booking',"menuId"=>'vehibooking')); ?></li>
                </ul>
            <?php

            }
            elseif ($userRole === "5")
            {
                ?>
<!--         <div id="logo"><?php echo CHtml::link('<img width="140px" style="margin-top: -3px;margin-left: -4" src="images/logo.png">',array('/site/index')); ?></div>-->
                <ul id="navlist" class="sf-menu clearfix">
                    <li style="display: none;">  <?php echo CHtml::link('Home',array('/site/index')); ?></li>
                    <li id="Dashboard"><?php echo CHtml::link('Dashboard',array('/dashboard/index',"menuId"=>'Dashboard')); ?></li>
                    <li id="vregistry"><?php echo CHtml::link('Vehicle Registry',array('/maVehicleRegistry/edit',"menuId"=>'vregistry')); ?></li>
                    <li id="dregistry"><?php echo CHtml::link('Driver',array('/maDriver/admin',"menuId"=>'dregistry')); ?></li>
                    <li id="vehibooking"><?php echo CHtml::link('Vehicle Booking',array('/tRVehicleBooking/booking',"menuId"=>'vehibooking')); ?></li>
                    <li id="maintenance"><?php echo CHtml::link('Maintenance',array('/maVehicleRegistry/maintenanceRegistry',"menuId"=>'maintenance')); ?></li>
                    <li id="fuelReg"><?php echo CHtml::link('Fuel',array('/maVehicleRegistry/fuelRequest',"menuId"=>'fuelReg')); ?></li>
                    <li id="odometerMnu"><?php echo CHtml::link('Odometer',array('/odometerUpdate/vehicleListForOdometer',"menuId"=>'odometerMnu')); ?></li>
                    <li id="accidentReg"><?php echo CHtml::link('Accident',array('/tRAccident/accidentHistory',"menuId"=>'accidentReg')); ?></li>
                    <li id="reports"><?php echo CHtml::link('Reports',array('/notificationConfiguration/report',"menuId"=>'reports')); ?></li>
<!--                <li id="configuration"><?php //echo CHtml::link('Configuration',array('/notificationConfiguration/management',"menuId"=>'configuration')); ?></li>-->
                    <li><?php //echo CHtml::link('Access',array('/site/hotel')); ?></li>

                </ul>
            <?php

            }
            else
            {
                ?>
                
                <ul id="navlist" class="sf-menu clearfix">
                    <li><div id="logo"><?php echo CHtml::link('<img width="140px" style="margin-top: -3px;margin-left: -4" src="images/logo.png">',array('/site/index'), array('id'=>'logoLi')); ?></div></li>
                    <li style="display: none;">  <?php echo CHtml::link('Home',array('/site/index')); ?></li>
                    <li id="dashboard"> <?php echo CHtml::link('Dashboard',array('/dashboard/index',"menuId"=>'dashboard')); ?></li>
                    <li id="vreg"><?php echo CHtml::link('Vehicle Registry',array('/maVehicleRegistry/edit',"menuId"=>'vreg')); ?></li>
                    <li id="driver"><?php echo CHtml::link('Driver',array('/maDriver/admin',"menuId"=>'driver')); ?></li>
                    <li id="vehibooking"><?php echo CHtml::link('Vehicle Booking',array('/tRVehicleBooking/booking',"menuId"=>'vehibooking')); ?></li>
                    <li id="maintenance"><?php echo CHtml::link('Maintenance',array('/maVehicleRegistry/maintenanceRegistry',"menuId"=>'maintenance')); ?></li>
                    <li id="fuel"><?php echo CHtml::link('Fuel',array('/maVehicleRegistry/fuelRequest',"menuId"=>'fuel')); ?></li>
                    <li id="odometerMnu"><?php echo CHtml::link('Odometer',array('/odometerUpdate/vehicleListForOdometer',"menuId"=>'odometerMnu')); ?></li>
                    <li id="accident"><?php echo CHtml::link('Accident',array('/tRAccident/accidentHistory',"menuId"=>'accident')); ?></li>
                    <li id="reports"><?php echo CHtml::link('Reports',array('/notificationConfiguration/report',"menuId"=>'reports')); ?></li>
                    <li id="configuration"><?php echo CHtml::link('Configuration',array('/notificationConfiguration/management',"menuId"=>'configuration')); ?></li>
                    <li id="access"><?php echo CHtml::link('Access',array('/accessPermission/accesscontrol',"menuId"=>'access')); ?></li>

                </ul>
            <?php



            }
        }
        ?>




    </nav>
    <!-- Navigation -->

</header>


<!-- End Header -->

<?php if(isset($this->breadcrumbs)):?>
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->
<?php endif?>


<?php

if (($currentUser != "Guest"))
{
    ?>
    <div id="cPass" class="popUp" >
        <a id="cPassClose"><img id="cPassCloseImg" src="images/close.png"  width="20" height="20" style="float: right;" /></a>
        <p align="center" style="font-size:20px;">Change Password</p>
        <?php
        $model = new changePasswordForm;


        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'changePassword-form',
            'action' => $this->createUrl('//site/changePassword'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ), 'htmlOptions' => array('enctype' => 'multipart/form-data'),));
        ?>

        <div style="width:84.5%; margin-left:10%; float:left; margin-top:1.8%">

            <div class="form">

                <div style="font-weight: bold; font-size: 14px; color: green;" id="formResult"></div>

                <p class="note">Field with <span class="required">*</span> is required.</p>


                <div>
                    <?php echo $form->labelEx($model, 'currentPassword'); ?>
                    <?php echo $form->passwordField($model, 'currentPassword', array('autofill' => 'false')); ?>
                    <?php echo $form->error($model, 'currentPassword'); ?>

                </div>

                <div>
                    <?php echo $form->labelEx($model, 'newPassword'); ?>
                    <?php echo $form->passwordField($model, 'newPassword'); ?>
                    <?php echo $form->error($model, 'newPassword'); ?>

                </div>

                <div>
                    <?php echo $form->labelEx($model, 'newPassword_repeat'); ?>
                    <?php echo $form->passwordField($model, 'newPassword_repeat'); ?>
                    <?php echo $form->error($model, 'newPassword_repeat'); ?>

                </div>
                <div>

                    <?php
                    echo CHtml::ajaxButton('Submit', array('//site/changePassword'), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                               
                        if(data.status=="success"){
                         $("#formResult").html("Password changed successfully");
                         $("#changePassword-form")[0].reset();
                         setTimeout(function(){$("#cPass").fadeOut("slow");},2000);
                         btnClicked = null;
			 changed = false;
                        }

                    }',
//                                'beforeSend' => 'function(){
//                           $("#AjaxLoader").show();
//                      }'
                        ), array(
                            'id' => 'changePasswordButton'
                        )
                    )
                    ?>
                </div>
                <?php $this->endWidget(); ?>

            </div>
        </div>
    </div>

<?php
}

?>

<?php echo $content; ?>



<!-- Footer -->
<footer>


    <div class="end-footer">
        <div class="lastdiv">
            <div class="copyright" style="float:none !important; text-align: center">
               Copyright &copy; <?php 
			   date_default_timezone_set('Asia/Colombo');
			   echo date('Y'); ?> by Sky Management Systems (Pvt) Ltd.<br/>
		All Rights Reserved.(2.1)<br/>
		<?php echo Yii::powered(); ?>
            </div>

            <div id="back-to-top">
                <a href="#top">Back to Top</a>
            </div>

            <div class="clear"></div>
        </div>
    </div>
</footer>



<script src="js/jquery.flexslider.js"></script>
<script type="text/javascript" charset="utf-8">
    $(window).load(function() {
        $('.flexslider').flexslider();
    });
</script>
<script type="text/javascript" src="js/jquery.superfish.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/accordion.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/zebra_datepicker.js"></script>
<script type="text/javascript" src="js/core.js"></script>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php
if (Yii::app()->user->hasFlash('success')) {

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'options' => array(
            'show' => 'explod',
            'hide' => 'explode',
            'modal' => 'true',
            /*    'title' => 'rtgdf', */
            'autoOpen' => true,
            'buttons' => array(
                'OK' => 'js:function(){$(this).dialog("close");}',),),));
    echo '<span class="dialog"></span>', Yii::app()->user->getFlash('success');
    $this->endWidget('zii.widgets.jui.CJuiDialog');
}
?>






<!-- SHOW confirmation when leaving the page without saving data
/////////////////////////////////////////////////////////////-->
<div class="container" id="page">
<div id="mainmenu" style="background-color:#000; padding-right:-20px !important">
<?php
if (isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] !== '') {
    echo '<script>
            btnClicked = "1";
            changed = true;
        </script>';

    unset(Yii::app()->session['btnClick']);
}
?>

<script type="text/javascript">

    var changed = false;
    var isChanged = false;
    var isTxtFocus = false;
    var addressValue = document.referrer;
    var notValid = false;

    document.onkeydown = function(evt)
    {
        evt = evt || window.event;
        var curUrl = document.URL;
        var isInReports = curUrl.indexOf("r=user/login");

        if(isInReports <1)
        {
            if (evt.keyCode === 8) // check for backspace button click
            {

                if(isTxtFocus)
                {
                    return true;
                   // evt.preventDefault();
                }
                if (changed && !isTxtFocus)
                {
                    return pop();
                }
                else if ((typeof (btnClicked) !== "undefined") && (btnClicked !== null))
                {
                    return pop();
                }
                else
                {
                    window.location = addressValue;
                }
            }
        }



        if (evt.keyCode === 27) // check escape button
        {
            hide();
            $('.fancybox-close').trigger('click');
        }
    };


    function pop()
    {
        var bodyHeight = $("body").height() /*- $("#header").height() + $("#footer").height()*/;
        var headHeight =  $("header").height();
        var footerHeight =  $("footer").height();
        //var winHeight =  $(window).height();
        var height = bodyHeight + headHeight + footerHeight;

        $('#BlockPopDiv').height(height);
        $('#BlockPopDiv').fadeIn(500);
        $("#popup_contentChange").fadeIn(500);

        return false;
    }

    function hide()
    {
        $('#BlockPopDiv').fadeOut(500);
        $("#popup_contentChange").fadeOut(500);
        return true;
    }



    $(document).ready(function()
    {
        $("input[type=text], textarea, select").live("keyup" , function()
        {
            var Pclass = $(this).parents().eq(4).attr("class");
            changed = false;
            
            if(Pclass !=="search-form")
            {
                changed = true;
            }
        });

        $("select").live("change" , function()
        {
            var Pclass = $(this).parents().eq(4).attr("class");
            changed = false;
            if(Pclass !=="search-form")
            {
                changed = true;
            }
        });


        $("input[type='text'], input[type='password'], textarea").live("focus", function()
        {
            
            var Pclass = $(this).parents().eq(4).attr("class");
            isTxtFocus = false;
            
            if(Pclass !=="search-form")
            {
                isTxtFocus = true;
            }
        });

        $("input[type=text]").live("focusout", function()
        {
            isTxtFocus = false;
        });

        $("a").click(function() // check if a link is clicked
        {
            var curUrl = document.URL;
            var aClass = $(this).attr("class");
            var addClass=-1;
            if ((typeof(aClass) !== "undefined") && (aClass !== null))
            {
                addClass = aClass.indexOf("addBtn");
            }


            var isInReports = curUrl.indexOf("r=report/");
            var isAccessPermission = curUrl.indexOf("r=accessControllers/assignpermission");
            var isApprovedBooking = curUrl.indexOf("r=tRVehicleBooking/editApprovedBookings");
            var isDashboard = curUrl.indexOf("/dashboard");
            
            if ((isInReports < 0) && (isAccessPermission < 0 && isDashboard < 0))// check whether report forms or not
            {
                if ((typeof(btnClicked) !== "undefined") && (btnClicked !== null))
                {
                    notValid = true;
                }

                addressValue = $(this).attr("href");
                var isSearchForm = addressValue.indexOf('#');
                isUserLog = addressValue.indexOf('user/Logout');


                if ((isSearchForm < 0)) // check whether search form or not
                {
                    if(addClass <0)
                    {
                        if (changed)
                        {
                            return pop('popDiv');
                        }
                        else if (notValid)
                        {
                            return pop('popDiv');
                        }
                        else
                        {
                            return true;
                            //e.preventDefault();
                        }

                    }

                }
            }

        });

        $('#btnOk').click(function()
        {
            hide('BlockPopDiv');
            window.location = addressValue;
        });

        $('#btnCancel').click(function()
        {
            preventKeyPress = false;
            hide('BlockPopDiv');
        });
    });
</script>

<!---->



<div id="popup_contentChange">
    <div id="popup_title">&nbsp;&nbsp;&nbsp;Content was changed.
        <img id="popupBoxClose" src="images/close.png" width="20px" onClick="return hide('BlockPopDiv');" style="cursor: pointer"/>
    </div>

    <div>
        <p style="text-align:center; margin-top:15px;font-size: 13px;">You have edited some data and they have not been saved.<br/> Are you sure you want to leave this page before saving the data?<br/><br/>Are you sure you want to leave this page.</p>

        <div style="margin-top:15px; text-align:right; margin-right: 20px">  

            <?php echo CHtml::button("Leave this page", array('title' => "Leave Page", 'id' => 'btnOk', 'class' => 'flashBtn')); ?>
               &nbsp;&nbsp;
            <?php echo CHtml::button("Stay on this page", array('title' => "Stay on Page", 'id' => 'btnCancel', 'class' => 'flashBtn')); ?>  <br/>

        </div>
    </div>
</div>

<div id="BlockPopDiv" class="ontop">

</div>


<script>
    $(document).ready(function()
    {
        $(document).keypress(function(e) 
        {
            if (e.which === 13) 
            {
                $("#errorConfirm").fadeOut(500);
                $("#popDiv").fadeOut(500);
                $("#Confirm").fadeOut(500);
                $("#popDiv").fadeOut(500);
            }
            if (e.keyCode === 27)
            {
                $("#errorConfirm").fadeOut(500);
                $("#popDiv").fadeOut(500);
                $("#Confirm").fadeOut(500);
                $("#popDiv").fadeOut(500);
            }

        });
        function closeFlash()
        {
            $(".flashMsg").live("keyup", function(e)
            {
                if (e.keyCode === 13)
                {
                    $('.flashBtn').click();
                }
            });
        }



        $('#btnErrorOk').click(function()
        {
            $("#errorConfirm").fadeOut(500);/**/
            $("#popDiv").fadeOut(500);

            /*document.getElementById("errorConfirm").style.display = 'none';
             document.getElementById("popDiv").style.display = 'none';*/
        });

        $('#btnConfirmOk').click(function()
        {
            $("#Confirm").fadeOut(500);
            $("#popDiv").fadeOut(500);/**/


            /*document.getElementById("Confirm").style.display = 'none';
             document.getElementById("popDiv").style.display = 'none';*/
        });

        $('#btnConfirmCancel').click(function()
        {
            $("#Confirm").fadeOut(500);
            $("#popDiv").fadeOut(500);/**/


            /*document.getElementById("Confirm").style.display = 'none';
             document.getElementById("popDiv").style.display = 'none';*/
        });


    });

</script>



<div id="errorConfirm" class="flashMsg">

    <div>
        

        <p style="padding-left:10px; padding-top:25px;">This record is used by another record. <br/>So you cannot delete this record.</p>
        <hr style="border-color:#AAAAAA; width:290px; margin-left:5px;"/>
        <div style="margin-left:70%; margin-top:-5px; padding-bottom: 6px;">
            <?php echo CHtml::button("OK", array('title' => "OK", 'id' => 'btnErrorOk', 'class' => 'flashBtn')); ?>
        </div>
    </div>
</div>


<div id="Confirm" class="flashMsg">

    <div>
        

        <p style="padding-left:10px; padding-top:25px;">Successfully deleted...!</p>
        <hr style="border-color:#AAAAAA; width:290px; margin-left:5px;"/>
        <div style="margin-left:40%; padding-bottom:6px">
            <?php echo CHtml::button("OK", array('title' => "OK", 'id' => 'btnConfirmOk', 'class' => 'flashBtn')); ?>
            <?php echo CHtml::button("Cancel",array('title'=>"Cancel",'id'=>'btnConfirmCancel', 'class'=>'flashBtn')); ?>
        </div>
    </div>
</div>

<div id="popDiv" class="ontop">

</div>


<!-- END show confirmation when leaving the page without saving data
/////////////////////////////////////////////////////////////-->


</body>


</html>






	