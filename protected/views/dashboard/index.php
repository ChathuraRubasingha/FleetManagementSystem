<style>
  .clearfix {
    position: fixed;
    width: 100%;
    z-index: 10;
    box-shadow: grey;
    min-height: 70px;
  }

  #nav {
    background-color: red;
    position: absolute;
    visibility: hidden;
  }

  .nav-pills>li>a {
    border-radius: 0;
  }

  #wrapper {
    padding-left: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
    overflow: hidden;
  }

  #wrapper.toggled {
    padding-left: 250px;
    overflow: hidden;
  }

  #sidebar-wrapper {
    z-index: 12;
    position: fixed;
    top: 0px;
    left: 250px;
    width: 0;
    height: 100%;
    margin-left: -250px;
    overflow-y: auto;
    background: #00004d;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
  }

  #wrapper.toggled #sidebar-wrapper {
    width: 250px;
  }

  #page-content-wrapper {
    /* position: absolute; */
    /* padding: 15px; */
    width: 100%;
    overflow-x: hidden;
    background-color: green;
  }

  .xyz {
    min-width: 360px;
    background-color: #f8f8ff;
    height: 100%;
    width: 60%;
    float: left;
    top: 52px;
  }

  .chart_container {
    background-color: #f0ffff;
    height: 100%;
    width: 40%;
    float: right;
    top: 52px;
  }

  #wrapper.toggled #page-content-wrapper {
    position: relative;
    margin-right: 0px;
  }

  .fixed-brand {
    width: auto;
  }

  /* Sidebar Styles */

  .sidebar-nav {
    position: absolute;
    top: 0;
    width: 250px;
    margin: 0;
    padding: 0;
    list-style: none;
    margin-top: 2px;
  }

  .sidebar-nav li {
    text-indent: 15px;
    line-height: 40px;
  }

  .sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: #fff;
  }

  .sidebar-nav li a:hover {
    text-decoration: none;
    color: #fff;
    background: rgba(255, 255, 255, 0.2);
    border-left: #0e94d4 2px solid;
  }

  .sidebar-nav li a:active,
  .sidebar-nav li a:focus {
    text-decoration: none;
  }

  .sidebar-nav>.sidebar-brand {
    height: 65px;
    font-size: 18px;
    line-height: 60px;
  }

  .sidebar-nav>.sidebar-brand a {
    color: #fff;
  }

  .sidebar-nav>.sidebar-brand a:hover {
    color: #fff;
    background: none;
  }

  .no-margin {
    margin: 0;
  }

  @media (min-width: 768px) {
    #wrapper {
      padding-left: 250px;
    }

    .fixed-brand {
      width: 250px;
    }

    #wrapper.toggled {
      padding-left: 0;
    }

    #sidebar-wrapper {
      width: 250px;
    }

    #wrapper.toggled #sidebar-wrapper {
      width: 250px;
    }

    #wrapper.toggled-2 #sidebar-wrapper {
      width: 50px;
    }

    #wrapper.toggled-2 #sidebar-wrapper:hover {
      width: 250px;
    }

    #page-content-wrapper {
      /* padding: 20px; */
      position: relative;
      -webkit-transition: all 0.5s ease;
      -moz-transition: all 0.5s ease;
      -o-transition: all 0.5s ease;
      transition: all 0.5s ease;
    }

    #wrapper.toggled #page-content-wrapper {
      position: relative;
      margin-right: 0;
      padding-left: 250px;
    }

    #wrapper.toggled-2 #page-content-wrapper {
      position: relative;
      margin-right: 0;
      margin-left: -200px;
      -webkit-transition: all 0.5s ease;
      -moz-transition: all 0.5s ease;
      -o-transition: all 0.5s ease;
      transition: all 0.5s ease;
      width: auto;
    }
  }

  #menu-toggle,
  #menu-toggle-2 {
    z-index: 15;
    position: absolute;
    position: fixed;
    top: 0px;
    padding: 10px;
    left: 8px;
    padding: 10px;
    background-color: white;
    border-radius: 30px;
  }

  .nav-pills>li.active>a,
  .nav-pills>li.active>a:hover,
  .nav-pills>li.active>a:focus {
    background-color: #0e94d4;
  }
  
  .hedder h1 {
    color: grey;

    padding: 10px;
 
    font-size: 20px;
  }

  .table-content {
    background: white;
    padding: 20px;
    border-radius: 30px;
    

  }
  .logo{
    height: 70px;
    padding-top: 10px;
  }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Latest compiled and minified CSS -->
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

    <div class="container-fluid xyz  col-lg-8">
      <div class="hedder">
        <h1>Vehicle Overview</h1>
      </div>
      <div class="table-content">
        <?php
        $q = "SELECT
              ma_vehicle_category.Category_Name,
              Count(ma_vehicle_registry.Vehicle_No) as count1
              FROM
              ma_vehicle_registry
              INNER JOIN ma_vehicle_category ON ma_vehicle_registry.Vehicle_Category_ID = ma_vehicle_category.Vehicle_Category_ID
              INNER JOIN vehicle_transfer ON ma_vehicle_registry.Vehicle_No = vehicle_transfer.Vehicle_No
              INNER JOIN ma_vehicle_status ON ma_vehicle_registry.Vehicle_Status_ID = ma_vehicle_status.Vehicle_Status_ID
              WHERE
              vehicle_transfer.To_Date < CURDATE() AND
              ma_vehicle_registry.Vehicle_Status_ID = 1
              GROUP BY
              ma_vehicle_category.Category_Name";
        $arr = Yii::app()->db->createCommand($q)->queryAll();
        $tbl =  "<table class='tabl table-striped'><thead><tr><th scope= 'col'>Catogory</th><th scope= 'col'>Allocated</th></tr></thead>";
        foreach ($arr as $val) {
          $tbl .= "<tr><th scope='row'>" . $val['Category_Name'] . "</th><td>" . $val['count1'] . "</td></tr>";
          //$tbl .= "<tr><td>$No</td><td>" . $val['Material_ID'] . "</td><td>" . $val['Material_Name'] . "</td><td style = 'text-align: center'>" . $val['Unit_Code'] . "</td><td style = 'text-align: center'>" . $val ['Qty'] . "</td><td></td></tr>";
        }
        $tbl .= "</table>";
        echo $tbl;
        ?>
      </div>
    </div>
    <div class="chart_container col-lg-4">
      <div class="pie chart">
        
      </div>


    </div>
  </div>
  <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->
<!-- jQuery -->
<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
  $("#menu-toggle-2").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled-2");
    $('#menu ul').hide();
  });

  function initMenu() {
    $('#menu ul').hide();
    $('#menu ul').children('.current').parent().show();
    //$('#menu ul:first').show();
    $('#menu li a').click(
      function() {
        var checkElement = $(this).next();
        if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
          return false;
        }
        if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
          $('#menu ul:visible').slideUp('normal');
          checkElement.slideDown('normal');
          return false;
        }
      }
    );
  }
  $(document).ready(function() {
    initMenu();
  });
</script>