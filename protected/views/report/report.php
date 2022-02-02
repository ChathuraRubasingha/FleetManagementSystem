<?php
$this->breadcrumbs=array(
	//'Management'=>array('notificationConfiguration/management'),
	'Reports',
);
?>
<html>
<style type="text/css">
.info  {
	display: block;
	/*background: url('./images/informationbar_right.gif') no-repeat right top;*/
	height: 25px;
	overflow: hidden;
	margin-top: 5px;
	margin-bottom:10px !important;
/*	padding: 0px !important;*/
	font-size: 12px !important;
	font-weight: bold;
	cursor: pointer;
	border: 0px;
	font-style: italic;	
}
.info .info_inner {
  display: block;
  height: 30px;
  padding: 6px 10px 0px 35px;
}
#success .info_inner {
  color:#4985B2;
  background: url('./images/icon_success.gif') no-repeat left top;
  border: 0px;
}

#portlets { padding:0px 10px; }
.column { width: 450px; float: left; padding-bottom: 0px; }
.column#left { margin-right:17px; }
.portlet { margin: 0 0em 1em 0; }
.portlet-header { 
margin: 0em; padding-bottom: 5px; padding-left: 6px; padding-top:4px; padding-right:6px; font-size:12px; border: none !important; color: #333 !important; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif; cursor:move;
background-image:-webkit-linear-;
 }
.portlet-header .ui-icon { float: right; cursor:pointer; }
.portlet-header img { float:left; margin-right:5px; }
#portlets .fixed { cursor:auto; } 

.title_report {
	  -webkit-box-shadow:rgba(0, 0, 0, 0.498039) 0 2px 6px, rgba(255, 255, 255, 0.298039) 0 1px inset, rgba(255, 255, 255, 0.2) 0 10px inset, rgba(255, 255, 255, 0.247059) 0 10px 20px inset, rgba(0, 0, 0, 0.298039) 0 -15px 30px inset;
  border-bottom-left-radius:10px;
  border-bottom-right-radius:10px;
  border-top-left-radius:10px;
  border-top-right-radius:10px;
  box-shadow:rgba(0, 0, 200, 0.498039) 0 2px 6px, rgba(255, 255, 255, 0.298039) 0 1px inset, rgba(255, 255, 255, 0.2) 0 10px inset, rgba(0, 0, 255, 0.247059) 0 10px 20px inset, rgba(30, 120, 250, 0.298039) 0 -15px 30px inset;
  height:50px;
  margin-bottom:20px;
  padding-left:15px;
}

.title_report p {
  font-size:15px;
  margin-top:-65px; 
  font-size:18px;
  text-align:center;
  text-decoration:none;
}

</style>

<body>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

<?php $this->pageTitle=Yii::app()->name; ?>
<?php 
/*echo CHtml::link('<p class="menup">Vehicle Inventory</p>',array('report/vehicleinventry'));?>
<?php echo CHtml::link('<p class="menup">Vehicle Booking</p>',array('report/vehicleinventry'));?>
<?php echo CHtml::link('<p class="menup">Booking Details</p>',array('report/vehicleinventry'));?>
<?php echo CHtml::link('<p class="menup">Drivers Details</p>',array('report/vehicleinventry'));?>
<?php echo CHtml::link('<p class="menup">Allocation</p>',array('report/vehicleinventry'));?>
<?php echo CHtml::link('<p class="menup">Location</p>',array('report/vehicleinventry'));
*/
?>

<table>
  
  <tr>
    	<td>    
            <div class="portlet" style="margin-top:30px; margin-left:30px; min-height:460px;">
                <!--<div class="portlet-header" style="width:150px">-->
                <div class="title_report">
                    <img src="images/Vehicle_maintenance.png" width="80" height="80" alt="Comments"/><p>Vehicle Maintenance</p></div>                
                <div class="portlet-content">                
 <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Mileage</span></p>',array('report/vehicleMileage'));?>
 <?php //echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Service Schedule</span></p>',array('report/VehicleDetails'));?>
 <?php //echo CHtml::link('<p class="info" id="success"><span class="info_inner">Fuel Consumption Report</span></p>',array('report/VehicleDetails'));?>
 <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Repair/Service Report</span></p>',array('report/vehicleRepaireService'));?>
 <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Maintenance Cost Reports</span></p>',array('report/vehicleMaintenanceCost'));?>
 <?php //echo CHtml::link('<p class="info" id="success"><span class="info_inner">Insurance Schedule</span></p>',array('report/VehicleDetails'));?>
  <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Insurance Due Date Report</span></p>',array('report/Insurance'));?>
 <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">License Due Date Report</span></p>',array('report/RevenueLicense '));?>
 <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Fitness Test Due Date Report</span></p>',array('report/FitnessTest'));?>
 <?php /*?><?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Fuel Consumption Report</span></p>',array(''));?><?php */?>
     <!--          <p class="info" id="success"><span class="info_inner"> <a href="fuel_consumption_rpt.pdf" style="color:#4985B2">Fuel Consumption Report - by vehicle</a></span></p>-->
     
      <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Fuel Consumption Report - Vehicle wise</span></p>',array('report/FuelConsumptionByVehecle'));?>
     
<!--                <p class="info" id="success"><span class="info_inner"> <a href="fuel_consumption_rpt_2.pdf" style="color:#4985B2">Fuel Consumption Report - All vehicles</a></span></p>
-->
 <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Fuel Consumption Report - All vehicles</span></p>',array('report/FuelConsumptionVehicleAllDate'));?>

<?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Emission Test Due Date Report</span></p>',array('report/emissionTest'));?>               
                
                </div>	
            </div>

   		</td>
        
    	<td>    
<div class="portlet"  style="margin-top:30px; min-height:460px;">
                <!--<div class="portlet-header" style="width:150px">-->
                 <div class="title_report">
                    <img src="images/Vehicle_movement.png" width="80" height="80" alt="Comments"/><p>Vehicle Movement</p></div>
                
                <div class="portlet-content">
                    	<?php //echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Location wise</span></p>',array('report/VehicleDetails'));?>
		<?php //echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Inventory</span></p>',array('report/vehicleinventry'));?>
		<?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Allocation Report</span></p>',array('report/vehicleAllocation'));?>
		<?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Booking Report - All</span></p>',array('report/vehicleBooking'));?>
        <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Booking Report - Vehicle wise</span></p>',array('report/BookingsForVehicle'));?>
		<?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Booking Report - Requester wise</span></p>',array('report/UserwiseBooking'));?>
        <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Driver Performance Report - by Driver</span></p>',array('report/DrverPerformanceByDriver'));?>
        <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Driver Performance Summary Report</span></p>',array('report/DriverPerformance'));?>
        
		<?php //echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Allocation Slip</span></p>',array('report/vehicleStatus '));?>

        </div>	
            </div>
    	</td>
    	<td>
        	<div class="portlet"  style="margin-top:30px; margin-right:40px; min-height:460px;">
                <!--<div class="portlet-header" style="width:150px">-->
                 <div class="title_report">
                    <img src="images/Vehicle_registry.png" width="80" height="80" alt="Comments"/><p>Vehicle Registry</p></div>                
                <div class="portlet-content">
                
 <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Details Report - Vehicle wise</span></p>',array('report/VehicleDetails'));?>
 <?php //echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Inventory</span></p>',array('report/vehicleinventry'));?>
 <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Details Report - Category wise</span></p>',array('report/vehicleCategory '));?>
 <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Details Report - Status wise</span></p>',array('report/vehicleStatus '));?>           
                    <p><br></p>
                    <p><br></p>
                    <p><br></p>
       
                
                </div>
            </div>
        </td>
  </tr>
    
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> 
    
    </td>
  </tr>
</table>
</body>
</html>