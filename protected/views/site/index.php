<style>
.box
{
    padding:10px;	
    font: normal 11px 'Open Sans', sans-serif;
}
.dark
{
    margin-left:5%;	
}
.box h4
{
    height:20px;	
}
</style>

<!-- Slider -->
<!--
<div class="slider" >
    <div class="flexslider">

        <div id="searchbox">
            <?php echo CHtml::link('<button id="submit">Let&CloseCurlyQuote;s Request a Vehicle </button>',array('/tRVehicleBooking/create',"menuId"=>'vehibooking')); ?>         
        </div>


        <ul class="slides">
            <li><img src="assets/slide02.jpg"/></li>
            <li><img src="assets/slide03.jpg"/></li>
        </ul>

    </div>

-->
    <!-- Book Apointment -->
  

  <div class="book-form mb30">
        <div class="inner-form">
            <!--form id="contact" action="accommotation-list.html" method="post"-->
                <div class="inputs">
                    <p id="popular"><span><?php echo yii::app()->params['sysName'] ?></span>&nbsp;&nbsp; <?php echo yii::app()->params['companyName'] ?></p>
                </div>
            <!--/form-->

        </div>
    </div>
    <!-- End Book Apointment -->
</div>
<!-- End SLider -->


<!-- Container -->
<div class="wrapper">

    <!-- Latest Deals -->
    <div class="latest mb30">

        <div class="dark">
            <?php echo CHtml::link('<div class="column4 box"><div class="box-img"><h4>Dashboard</h4><img src="assets/1394119936_Gadgets_alt.png" alt=""></div></div>	',array('dashboard/index')); ?>
            <?php echo CHtml::link('<div class="column4 box"><div class="box-img"><h4>Vehicle Registry</h4><img src="assets/1394119990_Device_Manager.png" alt=""></div></div>',array('maVehicleRegistry/edit')); ?>
            <?php echo CHtml::link('<div class="column4 box"><div class="box-img"><h4>Driver Details</h4><img src="assets/1394119971_Personal.png" alt=""></div></div>',array('/maDriver/admin')); ?>
            <?php echo CHtml::link('<div class="column4 box"><div class="box-img"><h4>Vehicle Booking</h4><img src="assets/1394120922_Mac_iCal.png" alt=""></div></div>',array('tRVehicleBooking/booking')); ?>
            <?php echo CHtml::link('<div class="column4 box"><div class="box-img"><h4>Maintenance</h4><img src="assets/1394120206_Administrative_Tools.png" alt=""></div></div>',array('maVehicleRegistry/maintenanceRegistry')); ?>
            <?php echo CHtml::link('<div class="column4 box"><div class="box-img"><h4>Accident</h4><img src="assets/1394120485_Homegroup.png" alt=""></div></div>',array('tRAccident/accidentHistory')); ?>
            <?php echo CHtml::link('<div class="column4 box"><div class="box-img"><h4>Reports</h4><img src="assets/1394121024_Sticky_Notes.png" alt=""></div></div>',array('notificationConfiguration/report')); ?>

            <div class="clear"></div>
        </div>
    </div>


    <div class="clear"></div>

</div>
<!-- End Row3 -->


</div>
<!-- End Wrapper -->