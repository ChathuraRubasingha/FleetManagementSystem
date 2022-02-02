<link rel="stylesheet" href="css/dashboard.css" type="text/css" media="screen">

<!--link href="//agileui.com/fides-demo/assets/css/minified/aui-production.min.css" rel="stylesheet"-->

<?php
$currentUser = Yii::app()->user->name;
$superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
//Get role id
$userID = Yii::app()->getModule('user')->user()->id;
$locID = Yii::app()->getModule('user')->user()->Location_ID;
$RoleID = Yii::app()->getModule('user')->user()->Role_ID;


$join="";
$condition = "";
$bookingCondition = "";

if ($superuserstatus != 1)
{
    $join="inner join  vehicle_location vl on vl.Vehicle_No = t.Vehicle_No";
    $condition =" and vl.Current_Location_ID = $locID";
    $bookingCondition = " and u.Location_ID =$locID";
}

/// Pending Battery Requests
//$countPendingBatteryReplacementRequests = TRBatteryDetails::model()->getPendingBatteryCount($join,$condition);

/// Approved Battery Requests
//$countApprovedBatteryReplacements = TRBatteryDetails::model()->getApprovedBatteryCount($join,$condition);

/// Pending Tyre Requests
//$countPendingTyreReplacementRequests = TRTyreDetails::model()->getPendingTyreRequestCount($join, $condition);

/// Approved Tyre Requests
//$countApprovedTyreReplacements = TRTyreDetails::model()->getApprovedTyreRequestCount($join, $condition);

/// Pending Fuel Requests
//$countPendingFuelRequests = TRFuelRequestDetails::model()->getPendingRequestCount($join,$condition);

/// Approved Fuel Requests
//$countApprovedFuelRequests = TRFuelRequestDetails::model()->getApprovedRequestCount($join,$condition);

/// Pending Booking Requests
//$countBookingRequests = TRVehicleBooking::model()->getPendingBookingCount($bookingCondition);

/// Approved Booking Requests
//$countApprovedBooking = TRVehicleBooking::model()->getApprovedBookingCount($bookingCondition);

/// Pending Repair Requests
//$countRepairPending = TRRepairEstimateDetails::model()->getPendingRequestCount($join,$condition);

/// Approved Repair Requests
//$countApprovedRepairRequests = TRRepairEstimateDetails::model()->getApprovedRequestCount($join,$condition);

/// Insurance Details
//$countInsurance = TRInsurance::model()->getInsuranceCount($join,$condition);

/// Emission Test Details
//$countPendingEmmission = TREmissionTest::model()->getEmissionTestCount($join,$condition) ;

/// Fitness Test Details
//$countPendingFitnessTest = TRFitnessTest::model()->getFitnessTestCount($join,$condition) ;

/// License Details
//$countPendingLicence = TRLicense::model()->getLicenseCount($join,$condition);

/// Assigned Booking Requests
//$countAssignedBooking = TRVehicleBooking::model()->getAssignedBookingCount($bookingCondition);



// get Dashboard groups
$dashboardGroups = DashboardItems::model()->getDashboardGroups();
$groupsCount = count($dashboardGroups);


?>

<style>
    .groupName
    {
        font-size: 18px;
        margin-bottom: 5px;
        text-decoration: underline;
    }
    .dashboardItemOutDivAAA /*.groupName*/
    {
        background-color: #fff;
        border-bottom: 8px solid #0099ff;
        border-radius: 30px;
        border-top: 8px solid #0099ff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.047);
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 10px;
        margin-right: 1%;
        padding: 10px;
        text-align: center;
    /*    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);*/
        width: 90%;
    }

    .dashboardItemOutDivAAA ol
    {       
       list-style:none;
       position:relative;
       display:block;
       width:auto;
       min-width: 70%;

    /*   margin-top: -10px;*/
    }

    .dashboardItemOutDivAAA li
    {
        overflow:hidden;
        height:35px;
        background:#fff;
        width:90% !important;
        font-size: 13px;
        min-width: 70% !important;
       /* -webkit-transition:all 0.5s;
        -moz-transition:all 0.5s;
        -o-transition:all 0.5s;
        transition:all 0.5s;*/
        text-align: left;   
        padding-left: 1px;
     }

     .dashboardItemOutDivAAA:hover .groupName
    {
    /*    border-radius: 40px 40px 0 0;
        border-bottom: 0;*/
    }
    .dashboardItemOutDivAAA:hover li
    {/*
        height:auto;
        padding:10px 2.5px;
        border-bottom:1px solid rgba(0,0,0,0.1);
        -webkit-box-shadow:inset 0 1px 0 #fff;
        -moz-box-shadow:inset 0 1px 0 #fff;
        -o-box-shadow:inset 0 1px 0 #fff;
        box-shadow:inset 0 1px 0 #fff;*/
    }
    /*
    .dashboardArrow{
        float:right;
        color:#000000;
        width:0;
        height:0;
        margin-top:7px;
        border-right:4px solid transparent;
        border-bottom:4px solid #000000;
        border-left:4px solid transparent;

        -webkit-transition:all 0.3s ease-in;
           -moz-transition:all 0.3s ease-in;
             -o-transition:all 0.3s ease-in;
                transition:all 0.3s ease-in;
    }
    .dashboardItemOutDivAAA:hover .dashboardArrow{
        border-bottom-color:#000000;
        -webkit-transform:rotate(180deg);
           -moz-transform:rotate(180deg);
             -o-transform:rotate(180deg);
                transform:rotate(180deg);
    }
       */


    .infobox 
    {
        border-style: solid;
        border-width: 1px;
        padding: 92px;
        position: relative;
        text-align: left;
        text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.5);
    }
</style>



<!--div class="panel panel-default" >
    <div class="larger" style="background-color: #c21118">
        <h1 id="Dash-title" class="panel-title" itemprop="name">Vehicle Booking</h1>
    </div>
    <div class="panel-body" >
        <ul>
            <li>fffs</li>
            <li>fffs</li>
            <li>fffs</li>
        </ul>
    </div>
</div>

<div class="panel panel-default" >
    <div class="larger" style="background-color: #5bccf6">
<h1 id="Dash-title" class="panel-title" itemprop="name">Statutory Alerts </h1>
</div>
<div class="panel-body"> 
        <ul>
            <li>fffs</li>
            <li>fffs</li>
            <li>fffs</li>
        </ul>
</div>
</div>


<div class="panel panel-default" >
    <div class="larger" style="background-color: #9cd159" >
<h1 id="Dash-title" class="panel-title" itemprop="name">Statutory Alerts </h1>
</div>
<div class="panel-body">
        <ul>
            <li>fffs</li>
            <li>fffs</li>
            <li>fffs</li>
        </ul>
</div>
</div>

<div class="panel panel-default" >
    <div class="larger" style="background-color: #fa7753">
<h1 id="Dash-title" class="panel-title" itemprop="name">Statutory Alerts </h1>
</div>
<div class="panel-body">
        <ul>
            <li>fffs</li>
            <li>fffs</li>
            <li>fffs</li>
        </ul>
</div>
</div-->

<?php


// get Dashboard groups
$dashboardGroups = DashboardItems::model()->getDashboardGroups();
$groupsCount = count($dashboardGroups);

?>

<div class="dashboadLeftPanel">
    
    <?php 
    
        if($groupsCount>0)
        {
            for($i=0; $i<$groupsCount; $i++)
            {
                $groupID = $dashboardGroups[$i]['Dashboard_Group_ID'];
                $groupName = $dashboardGroups[$i]['Display_Order'];
                $Colour_Class = $dashboardGroups[$i]['Url'];
                if($Colour_Class === '')
                {
                   $Colour_Class = "bg-red-alt";
                }
                // get dashboard items
                $dashboardItems = DashboardItems::model()->getDashboardItems($RoleID, $groupID,'1');
                $itemsCount = count($dashboardItems);
                if($itemsCount >0)
                {
                    echo "<div class='col-md-4'>
                            <div class='profile-box content-box'>
        
                                <div class='content-box-header clearfix $Colour_Class'>
                                    <img width='36' alt='' src='images/1.png'>
                                    <div class='user-details'>
                                        $groupName<span></span>
                                    </div>
                                </div>
                            
                                <div class='nav-list'>
                                <ul>";
                    
                    for($j=0; $j<$itemsCount; $j++)
                    {
                        $itemName = $dashboardItems[$j]['Display_Name'];
                        $url = $dashboardItems[$j]['Url'];
                        $itemID = $dashboardItems[$j]['Dashboard_Item_ID'];
                        $separatorIndex = (int)strpos($url, '/');
                        $modelName = substr($url, 0,  $separatorIndex);
                        $functionName = substr($url, $separatorIndex+1); // ♣ important ♣ here function name is declared as action name
                        $count="(0)";
                        if($itemID !== '18' && $itemID !== '19')
                        {
                            if($groupID !== '7')
                            {
                                $count = "(".$modelName::model()->$functionName($superuserstatus, $locID).")";
                            }
                            else 
                            {
                                $count='';
                            }
                        }
                        else
                        {
                            $count="(0)";
                        }
						if($itemID=="16")
						{

							 echo "
                                <li>
                                    <a title='' href='http://www.orongps.com/' target='_blank'> 
                                    <i class='glyph-icon font-purple icon-dashboard'></i>
                                    $itemName&nbsp;&nbsp; 
                                    <i class='glyph-icon icon-chevron-right float-right'></i>
                                    </a>
                                </li>";
						}
                                               else if($itemID=="19")
						{

							 echo "
                                <li>
                                    <a title='' href='http://eskymedia.com/tms' target='_blank'> 
                                    <i class='glyph-icon font-purple icon-dashboard'></i>
                                    $itemName&nbsp;&nbsp;
                                    <i class='glyph-icon icon-chevron-right float-right'></i>
                                    </a>
                                </li>";
						}
						else
						{
                        echo "
                                <li>
                                    <a title='' href=".Yii::app()->createAbsoluteUrl($url)."&menuId=dashboard"."> 
                                    <i class='glyph-icon font-purple icon-dashboard'></i>
                                    $itemName&nbsp;&nbsp;$count 
                                    <i class='glyph-icon icon-chevron-right float-right'></i>
                                    </a>
                                </li>";
						}
                    
                    }
                    
                   
                    echo "                
                            </ul>
                        </div>
                    </div>
                </div>";
                    
                }
                
                
            }
        }
    
    ?>
    <?php 
    if($RoleID == '1')
    {
    ?>
<!--    <div style="height: 20px">
        <a href="<?php echo yii::app()->createAbsoluteUrl('dashboardPermission/admin')?>"><span style="padding-left: 40px; font-weight: bold; text-decoration: underline">Change Dashboard Permission</span></a>
    </div>-->
    <div style="height: 20px"></div>
    <?php
    }
    ?>
</div>


<!--

<div class="col-md-4">
    <div class="profile-box content-box">
        <div class="content-box-header clearfix bg-red-alt">
            <img width="36" alt="" src="images/1.png">
                <div class="user-details">
                Title Goes Here
                <span>This is a sample description</span>
                </div>
        </div>
        <div class="nav-list">
            <ul>
                <li>
                    <a title="" href="javascript:;">    
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>



<div class="col-md-4">
    <div class="profile-box content-box">
        <div class="content-box-header clearfix bg-blue-alt">
            <img width="36" alt="" src="images/1.png">
                <div class="user-details">
                Title Goes Here
                <span>This is a sample description</span>
                </div>
        </div>
        <div class="nav-list">
            <ul>
                <li>
                    <a title="" href="javascript:;">    
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class="col-md-4">
    <div class="profile-box content-box">
        <div class="content-box-header clearfix bg-green-alt">
            <img width="36" alt="" src="images/1.png">
                <div class="user-details">
                Title Goes Here
                <span>This is a sample description</span>
                </div>
        </div>
        <div class="nav-list">
            <ul>
                <li>
                    <a title="" href="javascript:;">    
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class="col-md-4">
    <div class="profile-box content-box">
        <div class="content-box-header clearfix bg-orange-alt">
            <img width="36" alt="" src="images/1.png">
                <div class="user-details">
                Title Goes Here
                <span>This is a sample description</span>
                </div>
        </div>
        <div class="nav-list">
            <ul>
                <li>
                    <a title="" href="javascript:;">    
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class="col-md-4">
    <div class="profile-box content-box">
        <div class="content-box-header clearfix bg-purple-alt">
            <img width="36" alt="" src="images/1.png">
                <div class="user-details">
                Title Goes Here
                <span>This is a sample description</span>
                </div>
        </div>
        <div class="nav-list">
            <ul>
                <li>
                    <a title="" href="javascript:;">    
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="profile-box content-box">
        <div class="content-box-header clearfix bg-pink-alt">
            <img width="36" alt="" src="images/1.png">
                <div class="user-details">
                Title Goes Here
                <span>This is a sample description</span>
                </div>
        </div>
        <div class="nav-list">
            <ul>
                <li>
                    <a title="" href="javascript:;">    
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
                <li>
                    <a title="" href="javascript:;">
                    <i class="glyph-icon font-purple icon-dashboard"></i>
                    Dashboard 
                    <i class="glyph-icon icon-chevron-right float-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>-->