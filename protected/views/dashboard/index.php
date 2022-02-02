<link rel="stylesheet" href="css/dashboard2.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/boostrap4.0.0.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/boostrap3.3.7.css" type="text/css" media="screen">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<div class="navbar-header fixed-brand">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" id="menu-toggle">
    <span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
  </button>
</div>
<!-- navbar-header-->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"> <span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
  </button>
</div>

<div id="wrapper">
  <!-- Sidebar -->
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
      <li>
        <div class="logo">
          <img width="140px" style="margin-top: -3px;margin-left: -4" src="images/logo.png">
        </div>
      </li>
      <li>
        <a href="/fleet/index.php?r=site/index"><span class="fa-stack fa-lg pull-left"><i class="fa fa-home fa-stack-1x "></i></span>Home</a>
      </li>
      <li class="active">
        <a href="/fleet/index.php?r=dashboard/index&menuId=dashboard"><span class="fa-stack fa-lg pull-left"><i class="fa fa-dashboard fa-stack-1x "></i></span> Dashboard</a>
        <ul class="nav-pills nav-stacked" style="list-style-type:none;">
          <li><a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-circle- fa-stack-1x "></i></span>Summary</a></li>
          <li><a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa- fa-stack-1x "></i></span>Allocated vehicle</a></li>
          <li><a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa- fa-stack-1x "></i></span>Idle vehicle</a></li>
        </ul>
      </li>
      <li>
        <a href="/fleet/index.php?r=maVehicleRegistry/edit&menuId=vreg"><span class="fa-stack fa-lg pull-left"><i class="fa fa-registered fa-stack-1x "></i></span>Registry</a>
      </li>
      <li>
        <a href="/fleet/index.php?r=maDriver/admin&menuId=driver"><span class="fa-stack fa-lg pull-left"><i class="fa fa-user fa-stack-1x "></i></span>Driver</a>
      </li>
      <li>
        <a href="/fleet/index.php?r=tRVehicleBooking/booking&menuId=vehibooking"> <span class="fa-stack fa-lg pull-left"><i class="fa fa-book fa-stack-1x "></i></span>Booking</a>
      </li>
      <li>
        <a href="/fleet/index.php?r=maVehicleRegistry/maintenanceRegistry&menuId=maintenance"><span class="fa-stack fa-lg pull-left"><i class="fa fa-cog fa-stack-1x "></i></span>Maintenance</a>
      </li>
      <li>
        <a href="/fleet/index.php?r=maVehicleRegistry/fuelRequest&menuId=fuel"><span class="fa-stack fa-lg pull-left"><i class="fa fa-question-circle fa-stack-1x "></i></span>Fual</a>
      </li>
      <li>
        <a href="/fleet/index.php?r=odometerUpdate/vehicleListForOdometer&menuId=odometerMnu"><span class="fa-stack fa-lg pull-left"><i class="fa fa-pencil fa-stack-1x "></i></span>Odometer</a>
      </li>
      <li>
        <a href="/fleet/index.php?r=tRAccident/accidentHistory&menuId=accident"><span class="fa-stack fa-lg pull-left"><i class="fa fa-car fa-stack-1x "></i></span>Accident</a>
      </li>
      <li>
        <a href="/fleet/index.php?r=notificationConfiguration/report&menuId=reports"><span class="fa-stack fa-lg pull-left"><i class="fa fa-newspaper-o fa-stack-1x "></i></span>Report</a>
      </li>
      <li>
        <a href="/fleet/index.php?r=notificationConfiguration/management&menuId=configuration"><span class="fa-stack fa-lg pull-left"><i class="fa fa-wrench fa-stack-1x "></i></span>Configuration</a>
      </li>
      <li>
        <a href="/fleet/index.php?r=accessPermission/accesscontrol&menuId=access"><span class="fa-stack fa-lg pull-left"><i class="fa fa-key fa-stack-1x "></i></span>Access</a>
      </li>
    </ul>
  </div>
  <!-- /#sidebar-wrapper -->
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <!-- summary page -->
    <?php $this->renderPartial('//dashboard/summary', array()); ?>
  </div>
  <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->
<!-- jQuery -->