<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    list-style: none;
    text-decoration: none;
  }

  #fancybox-loading div {
    position: fixed;
    top: 0;
    left: 800;
    width: 40px;
    height: 480px;
    background-image: 'url(fancy/fancybox_loading@2x.gif)';
  }

  .names {
    font-size: 10px;
    text-align: center;
  }

  .img {
    border: 1px solid #333;
  }

  .DisplayImage {
    width: 150px;
    height: 150px;
    margin-left: 40%;
    border: 2px #000 solid;

  }

  .vImg {

    float: left;
    width: 160px;
    height: 160px;
  }

  .dImg {
    float: left;
    width: 160px;
    height: 160px;
  }

  .VehicleImages {
    float: left;
    width: 90% !important;

  }

  .DriverImages {
    float: left;
    margin-top: 50px !important;
    width: 90% !important;
  }

  /* th{
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
	 padding:5px;
 }
.even
{
	background: #fff;
}
.odd
{
	background: #fff;
}*/
  .col {
    min-height: 400px;
    height: auto !important;
  }

  .subheader {
    position: fixed;
    width: 100%;
  }

  .sidebar {
    position: fixed;
    top: 93px;
    width: 15%;
    float: left;
    height: 100%;
    background: #042331;
  }

  .sidebar ul li a {
    text-decoration: none;
    display: block;
    padding: 16px 25px;
    border-bottom: 1px solid #03374e;
    color: #0e94d4;
  }

  .sidebar ul li a .icon {
    font-size: 18px;
    color: white;
    vertical-align: middle;
  }

  .sidebar ul li a .text {
    margin-left: 15px;
    color: #fff;
    font-family: sans-serif;
    font-size: 14px;
    letter-spacing: 2px;
  }

  .sidebar ul li a:hover {
    background: #0e94d4;
    color: #fff;
  }

  #nav {
    background-color: red;
    position: absolute;
    visibility: hidden;
  }

  .subheader2 {
    position: absolute;
    right: 10px;
    top: 5px;
    float: right;
    z-index: 1;
  }

  .summaryCore {
    z-index: 1;
  }

  .top_navbar2 {
    position: fixed;
    top: 47px;
    left: 0;
    width: 100%;
    height: 46px;
    background: #323233;
    box-shadow: 1px 0 2px rgba(0, 0, 0, 0.125);
    display: flex;
    align-items: center;
  }

  .end-footer {
    visibility: hidden;
  }

  .top_navbar2 .menu {
    width: calc(100% - 250px);
    padding: 0 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .top_navbar2 .hamburger {
    font-size: 25px;
    cursor: pointer;
    color: white;
  }

  .top_navbar2 .hamburger:hover {
    color: #007dc3;
  }

  .hover_collapse .sidebar {
    position: fixed;
    width: 70px;

  }

  .hover_collapse .sidebar ul li a .text {
    display: none;
  }

  .container2 {
    float: right;
    width: 85%;
    background-color: lavender;
    height: 100%;
    margin-top: 93px;
  }

  /* Add a black background color to the top navigation */
  .topnav {
    position: fixed;
    float: top;
    width: 100%;
    background-color: #042331;
    overflow: hidden;
  }

  /* Style the links inside the navigation bar */
  .topnav a {
    float: left;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 15px;
    border-right: 1px solid #03374e;
  }

  /* Change the color of links on hover */
  .topnav a:hover {
    background-color: #ddd;
    color: black;
  }

  /* Add a color to the active/current link */
  .active {
    background-color: #03374e;
    color: white;
  }

  .innercontainer {

  }

  .table {
    float: left;
    width: 70%;
    height: 100%;
  }

  .charts {
    float: right;
    width: 30%;
    height: 100%;
    background-color: green;
  }

  .upper {
    background-color: blue;
    height: 50%;
    float: top;
  }

  .lower {
    background-color: green;
    height: 50%;
    float: bottom;
  }
  .innerhedder h1{
    color: grey;
    font-weight: bold;
    margin: 0px;
    padding: 5px;
    font-size: 18px;
  }
  .spacefiling{
    width: 100%;
    background-color: red;
    height: 51px;
  }
</style>

<?php
$LocID = Yii::app()->getModule("user")->user()->Location_ID;
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
?>
<!-- <div class="wrapper hover_collapse"> -->
<!-- Top bar -->
<div class="top_navbar2">
  <!-- menu button -->
  <div class="menu">
    <ul>
      <div class="hamburger">
        <i class="fas fa-bars"></i>
      </div>
    </ul>
  </div>

</div>
<!-- Sidebar -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<div class="container_dashboard">
  <div class="sidebar">
    <div class="sidebar_inner">
      <ul>
        <li>
          <a href="/fleet/index.php?r=site/index">
            <span class="icon"><i class="fa fa-home"></i></span>
            <span class="text">HOME</span>
          </a>
        </li>
        <li class="active">
          <a href="/fleet/index.php?r=dashboard/index&menuId=dashboard">
            <span class="icon"><i class="fa fa-qrcode"></i></span>
            <span class="text">DASHBOARD</span>
          </a>
        </li>

        <li>
          <a href="/fleet/index.php?r=maVehicleRegistry/edit&menuId=vreg">
            <span class="icon"><i class="fa fa-registered"></i></span>
            <span class="text">REGISTRY</span>
          </a>
        </li>
        <li>
          <a href="/fleet/index.php?r=maDriver/admin&menuId=driver">
            <span class="icon"><i class="fa fa-user"></i></span>
            <span class="text">DRIVER</span>
          </a>
        </li>
        <li>
          <a href="/fleet/index.php?r=tRVehicleBooking/booking&menuId=vehibooking">
            <span class="icon"><i class="fa fa-book"></i></span>
            <span class="text">BOOKING</span>
          </a>
        </li>
        <li>
          <a href="/fleet/index.php?r=maVehicleRegistry/maintenanceRegistry&menuId=maintenance">
            <span class="icon"><i class="fa fa-cog"></i></span>
            <span class="text">MAINTENANCE</span>
          </a>
        </li>
        <li>
          <a href="/fleet/index.php?r=maVehicleRegistry/fuelRequest&menuId=fuel">
            <span class="icon"><i class="fa fa-question-circle"></i></span>
            <span class="text">FUEL</span>
          </a>
        </li>
        <li>
          <a href="/fleet/index.php?r=odometerUpdate/vehicleListForOdometer&menuId=odometerMnu">
            <span class="icon"><i class="fa fa-pen"></i></span>
            <span class="text">ODOMETER</span>
          </a>
        </li>
        <li>
          <a href="/fleet/index.php?r=tRAccident/accidentHistory&menuId=accident">
            <span class="icon"><i class="fa fa-car"></i></span>
            <span class="text">ACCIDENT</span>
          </a>
        </li>
        <li>
          <a href="/fleet/index.php?r=notificationConfiguration/report&menuId=reports">
            <span class="icon"><i class="fa fa-newspaper"></i></span>
            <span class="text">REPORT</span>
          </a>
        </li>
        <li>
          <a href="/fleet/index.php?r=notificationConfiguration/management&menuId=configuration">
            <span class="icon"><i class="fa fa-wrench"></i></span>
            <span class="text">CONFIGURATION</span>
          </a>
        </li>
        <li>
          <a href="/fleet/index.php?r=accessPermission/accesscontrol&menuId=access">
            <span class="icon"><i class="fa fa-key"></i></span>
            <span class="text">ACCESS</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
  <!-- </div> -->
  <div class="container2">
    <div class="topnav">
      <a class="active" href="#home">SUMMARY</a>
      <a href="#news">ALLOCATED VEHICLE</a>
      <a href="#contact">IDLE VEHICLE</a>
    </div>
    <div class="innercontainer">
      <div class="table">
      <div class="spacefiling"></div>
        <div class="innerhedder">
          <h1>VEHICLE OVERVIEW</h1>
          <div class="bar1">

          </div>
        </div>
      </div>
      <div class="charts">
        <div class="upper">
        </div>
        <div class="lower">
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var li_items = document.querySelectorAll(".sidebar ul li");
  var hamburger = document.querySelector(".hamburger");
  var wrapper = document.querySelector(".wrapper");

  li_items.forEach((li_item) => {
    li_item.addEventListener("mouseenter", () => {

      li_item.closest(".wrapper").classList.remove("hover_collapse");

    })
  })

  li_items.forEach((li_item) => {
    li_item.addEventListener("mouseleave", () => {

      li_item.closest(".wrapper").classList.add("hover_collapse");

    })
  })

  hamburger.addEventListener("click", () => {

    hamburger.closest(".wrapper").classList.toggle("hover_collapse");
  })
</script>