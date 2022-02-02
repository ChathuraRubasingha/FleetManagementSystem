	<?php
$this->breadcrumbs=array(
	'Battery Replacement History'=>array('tRBatteryDetails/battery'),
	'Replaced Battery Requests'
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('replaced-battery-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
?>
<script type="text/javascript">

/*$(document).ready(function(){

        $(".slidingDiv").hide();
        $(".show_hide").show();

	$('.show_hide').click(function(){
	$(".slidingDiv").slideToggle();
	});

});*/

</script>


<div class="group" style="width:20%;  height:280px; float:left; margin-left:3%; margin-top:2.4%">
    <div id="menu"  style="width:20%; float:left; padding-left:2%; padding-top:2%">
        
        <ul>
               <?php echo CHtml::link('<img src="images/back.png" alt="back" width="25px" style="padding:0 125px 0 50px;"/>',array('/maVehicleRegistry/maintanenceview&id='.$vehicleId)); ?>
                
                <li><?php echo CHtml::link('Battery Requests',array('/tRBatteryDetails/battery')); ?></li>
                                
               <!-- <li><?php #echo CHtml::link('Approve Repair Estimate',array('/tRRepairEstimateDetails/estimate')); ?></li>-->
                
                 <li><?php echo CHtml::link('Battery Replacement',array('/tRBatteryDetails/replace&type=replace')); ?></li>
                 
                <li><?php echo CHtml::link('Pending Battery Requests',array('/tRBatteryDetails/pendingBatteryRequests')); ?></li>
                <li><?php echo CHtml::link('Approved Battery Requests',array('/tRBatteryDetails/approvedBatteryRequests')); ?></li>
                <li><?php echo CHtml::link('Disapproved Battery Requests',array('/tRBatteryDetails/disapprovedBatteryRequests')); ?></li>
                <li><?php echo CHtml::link('Rejected Battery Requests',array('/tRBatteryDetails/rejectedBatteryRequests')); ?></li>
                <li><?php echo CHtml::link('Completed Battery Requests',array('/tRBatteryDetails/completedBatteryRequests')); ?></li>
            </ul>
            
            <!--<ul>
            	<li><?php #echo CHtml::link('Back to main',array('/tRLicense/Create')); ?></li>
            
                <li><?php #echo CHtml::link('New Battery Request',array('/tRBatteryDetails/create')); ?></li>
                
                <li><?php #echo CHtml::link('Approve Battery Requests',array('/tRBatteryDetails/admin')); ?></li>
                
                <li><?php #echo CHtml::link('Battery Replacement',array('/tRBatteryDetails/replaceBatteryDetails')); ?></li>
                            
            </ul>-->

	</div>
</div>


    

<?php #echo CHtml::link('<img src="images/Approved-1.png"  width="0px" height="0px"/>','#',array('class'=>'show_hide')); ?>
   

    <div  style="width:900px; float:left; ">
        <div class="group" style="width:900px; margin-left:330px; margin-top:-290px">
                <h1>Replaced Battery Requests</h1>
                 <div class="classname" style="width:200px; height:28px; margin-left:340px; margin-bottom:50px; font-size:25px">
 <p align="center"><b><?php echo $vehicleId; ?></b></p>
 </div>
               <!-- <div style="margin-left:800px">
                <?php #echo CHtml::link('<img src="images/Search.gif"  width="0px" height="0px"/>','#',array('class'=>'search-button')); ?>
                </div>
                <div class="search-form" style="display:none">
                <?php /*$this->renderPartial('_search',array(
                    'model'=>$model, 
                ));*/ ?>
                </div>  search-form -->
                
                <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'replaced-battery-grid',
	'dataProvider'=>$model->getReplacedBatteryRequests(),
	#'filter'=>$model,
	'columns'=>array(
		//'Battery_Details_ID',
		//'Vehicle_No',
		array('name'=>'Full_Name', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
		//'Driver_ID',
		array('name'=>'Battery_Type', 'header'=>'Battery Type', 'value'=>'$data->batteryType->Battery_Type'),
		#'Approved_Date',
		#'Cost',
		//'Battery_Type_ID',
		//'Approved_By',
		//'Approved_Date',
		/*
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
	
		array(
			'class'=>'CButtonColumn',
			#'template'=>array('view'),
		),
	),
)); ?>
        </div>
</div>

   
