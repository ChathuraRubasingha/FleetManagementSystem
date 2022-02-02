<?php
$marign_Top = "4.2%;";
$marign_TopMenu = "0px;";


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function()
{
	
	if ($('.search-form').is(':hidden')) 
	{
		$('.search-form').toggle();
		return false;
	}
	else 
	{
		location.reload();
		return false;
	}
	
	
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ma-vehicle-registry-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="group" style="height:140px; width:20%; float:left; margin-left:3%; margin-top:<?php echo $marign_TopMenu; ?>">
    <div id="menu" style="padding-left:0%; padding-top:2%;">


        <ul>
            <li><?php echo CHtml::link('ඔඩෝමීටර විස්තරය සම්පූර්ණ කිරිම', array('/tRVehicleBooking/vehiclelist')); ?></li>
            <li><?php echo CHtml::link('සම්පූර්ණ කල අයදුම්', array('/tRVehicleBooking/completedBooking')); ?></li> 
            <li><?php echo CHtml::link('ඔඩෝමීටරය යාවත්කාලීන කිරීම ', array('/odometerUpdate/vehicleListForOdometer')) ?></li>
            <li><?php echo CHtml::link('සම්පූර්ණ කල ඔඩෝමීටර යාවත්කාලීන කිරිම්', array('/odometerUpdate/completedOdo')); ?></li>
        </ul>

    </div>
</div>  
<div class="group" style="width:85%; margin-left:30%; margin-top: 2.4%;">
    <h1 style="margin-bottom:5%;">ඔඩෝමීටරය යාවත්කාලීන කිරිම සඳහා වාහනය තෝරාගන්න</h1>



    <div style="margin-left:93%; margin-top:-83px; ">
        <?php echo CHtml::link('<img src="images/search_btn2.png"  width="40px" height="40px"/>', '#', array('class' => 'search-button')); ?>
    </div>
    <div class="search-form" style="display:none">
        <?php
        $this->renderPartial('_searchVehicle', array(
            'model' => $model,
        ));
        ?>
    </div><!-- search-form -->
    <?php
    $superUser = Yii::app()->getModule("user")->user()->superuser;
    ?>
    
    <?php
//    var_dump($model->getVehicleListLocationWiseForOdo());
//        die;
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'ma-vehicle-registry-grid',
        'dataProvider' => $model->getVehicleListLocationWiseForOdo(),
        
        //'filter'=>$model,
//        'rowCssClassExpression' => function($data) {
//            $ct = new CDbCriteria();
//            $ct->condition = "out_time !='' AND out_odo_reading !='' AND in_time = '0000-00-00 00:00:00' AND in_odo_reading = '0' AND  Vehicle_No ='$dataProvider->Vehicle_No'";
//            $ct->select = "max(update_id) as update_id, out_time, out_odo_reading";
//
//            $odoUpdateId = OdometerUpdate::model()->find($ct);
//            
//            if(($odoUpdateId['out_time'] !=='')&&($odoUpdateId['out_time'] !=='')) {
//                return "Wwarning";
//            }else{
//                return "even";
//            }
//        },
        'columns' => array(
//		'Vehicle_No',
            array('name' => 'Vehicle_No', 'header' => 'වාහන අංකය', 'value' => '$data->Vehicle_No'),
            array('name' => 'Category_Name', 'header' => 'වර්ගය', 'value' => '$data->vehicleCategory->Category_Name'),
            //'Model',
            $superUser == 1 ? array('name' => 'Location_ID', 'header' => 'Location', 'type' => 'raw', 'value' => array($this, 'gridLocation')) : array('name' => 'Location_ID', 'visible' => false),
            array('name' => 'Make_ID', 'header' => 'වාහන වර්ගය', 'value' => '$data->makeID->Make'),
            /* array('name'=>'Model', 'type'=>'raw', //because of using html-code
              'value'=>array($this,'gridModel'), //call this controller method for each row
              ),
             */
            array('name' => 'Fuel_Type', 'header' => 'ඉන්ධන වර්ගය', 'value' => '$data->fuelType->Fuel_Type'),
            //array('name'=>'Vehicle_Status', 'header'=>'Vehicle Status', 'value'=>'$data->vehicleStatus->Vehicle_Status'),
//		array('name'=>'Allocation_Type_ID', 'header'=>'Allocation Type', 'value'=>'$data->allocationType->Allocation_Type'),
            array(
                'class' => 'CButtonColumn',
                'template' => '{view}',
                'viewButtonUrl' => 'Yii::app()->createUrl("/odometerUpdate/create", array("id" =>     
			$data["Vehicle_No"],"aid" =>     
			$data["Allocation_Type_ID"]))',
            ),
        ),
    ));
    ?>




</div>
