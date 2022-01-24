<?php
//$this->breadcrumbs=array(
//	'Management'=>array('notificationConfiguration/management'),
//	'Manage',
//);

$this->menu=array(
	//array('label'=>'List MaDriver', 'url'=>array('index')),
	array('label'=>'Create New Driver', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ma-driver-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


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
.portlet-content { padding: 0.8em; font-size:12px !important; color: #333; border-top:1px solid #999 !important; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;}

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


<div class="portlet" style="margin-left:40px; margin-top:23px; min-height:auto; width:300px">
	<div class="title_report">
    	 <img src="images/Vehicle_movement.png" width="80" height="80" alt="Comments"/><p>Vehicle Movement</p>
    </div>             
     <div class="portlet-content">                
		<?php //echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Location wise</span></p>',array('report/VehicleDetails'));?>
		<?php //echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Inventory</span></p>',array('report/vehicleinventry'));?>
		<?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Allocation Report</span></p>',array('report/vehicleAllocation'));?>
		<?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Booking Report</span></p>',array('report/vehicleBooking'));?>
        <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Bookings Made for a Vehicle</span></p>',array('report/BookingsForVehicle'));?>
		<?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">User wise Vehicle Booking Report</span></p>',array('report/UserwiseBooking'));?>
        <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Driver Performance Report - by Driver</span></p>',array('report/DrverPerformanceByDriver'));?>
        <?php echo CHtml::link('<p class="info" id="success"><span class="info_inner">Driver Performance Summary Report</span></p>',array('report/DriverPerformance'));?>
		<?php //echo CHtml::link('<p class="info" id="success"><span class="info_inner">Vehicle Allocation Slip</span></p>',array('report/vehicleStatus '));?>
    </div>	
</div>


<div  class="group" style="margin-left:440px; margin-top:-206px">
<h1>Select driver</h1>



<?php echo CHtml::link('<img src="images/Search.gif"  width="0px" height="0px"/>','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('//maDriver/_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ma-driver-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		//'Driver_ID',
		'Full_Name',
		//'Location_ID',
		'NIC',
		'Status',
		'Mobile',
		/*
		'Private_Address',
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
			array(
			'class'=>'CButtonColumn',
			 'template'=>'{view}',
			  'buttons'=>array
        (
        'view' => array
        (
             //'url'=>'Yii::app()->createUrl("/report/vehicleRepaireService",  array("ReportGridMemberID" =>$data["Vehicle_No"]))',
			 'url'=>'Yii::app()->createUrl("/report/DriverPerformanceByDriverDate",  array("ID" =>$data["Driver_ID"]))',
        ),
		),
			
		),
	),
)); ?>
</div>
