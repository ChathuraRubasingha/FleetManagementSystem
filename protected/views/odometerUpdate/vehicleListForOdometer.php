<?php
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
$superUser = Yii::app()->getModule("user")->user()->superuser;

 $title = "Select Vehicle to Update Odometer";
	$vehicle_no = "Vehicle No";
	$category ="Vehicle Category";
	$make = "Make";
	$model = "Model";
	$out_odo_reading = "Out Odometer Reading";
	$in_odo_reading = "In Odometer Reading";

//if($userRole!=3 && $userRole !=4)
//{
//    $title = "Select Vehicle to Update Odometer";
//	$vehicle_no = "Vehicle No";
//	$category ="Vehicle Category";
//	$make = "Make";
//	$model = "Model";
//	$out_odo_reading = "Out Odometer Reading";
//	$in_odo_reading = "In Odometer Reading";
//
//} else {
//
//    $title = "ඔඩෝමීටරය සම්පූර්ණ කිරීම සඳහා අදාළ වාහනය තෝරා ගන්න";
//	$vehicle_no = "වාහන අංකය";
//	$category ="වාහන වර්ගය";
//	$make = "වාහන ප්‍රභේදය";
//	$model = "වාහන මාදිලිය";
//	$out_odo_reading = "පිටත් වන විට ඔඩෝමීටර කියවීම";
//	$in_odo_reading = "ආපසු පැමිණෙන විට ඔඩෝමීටර කියවීම ";
//}



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
	$.fn.yiiGridView.update('odometer-update-grid', {
		data: $(this).serialize(),

	});
	return false;
});
");



?>

<script>
    $(document).ready(function()
    {
        $(".items tr td").click(function()
        {
            //var a =  $(this).parent("tr").children().eq(7).children('a').attr('href');
            var a =  $(this).parent("tr").children('td').eq(6).children('a').attr('href');
           
            window.location = a;
            
        });
    });
   
</script>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    if (($userRole !== '3') && ($userRole !== '4'))
                    {
                        $this->breadcrumbs = array(
                            'Vehicle Booking' => array('tRVehicleBooking/booking'),
                            'Completed Booking Requests'
                        );
                    }

                    ?>
                </ul>
            </div>
            <div class="col-xs-8" style="margin-left: 20%">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo $title?></h1>
                    </div>


                </div>

                <div class="panel panel-default">


                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'odometer-update-grid',
                            'dataProvider'=>$modelVehicle->getVehicleListLocationWiseForOdo(),
                            'rowCssClassExpression'=>'$data["out_odo_reading"] !== "0" && $data["in_odo_reading"] ==="0" ?"warning":"even"',
                            'columns'=>array(
                                array(
                                    'header'=>Yii::t('odometer_update',$vehicle_no),
                                    'name'=>'Vehicle_No',
                                    'type'=>'raw',
                                ),
                                array(
                                    'header'=>Yii::t('odometer_update', $category ),
                                    'name'=>'Category_Name',
                                    'type'=>'raw',
                                ),
                                //'Make',
                                array(
                                    'header'=>Yii::t('odometer_update', $make ),
                                    'name'=>'Make',
                                    'type'=>'raw',
                                ),
                                array(
                                    'header'=>Yii::t('odometer_update', $model ),
                                    'name'=>'Model',
                                    'type'=>'raw',
                                ),
                                array(
                                    'header'=>Yii::t('odometer_update', $out_odo_reading),
                                    'name'=>'out_odo_reading',
                                    'type'=>'raw',
                                ),
                                array(
                                    'header'=>Yii::t('odometer_update', $in_odo_reading),
                                    'name'=>'in_odo_reading',
                                    'type'=>'raw',
                                ),
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array('view'=>array(
                                        'label'=>'Select Vehicle',
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/go_arrow.png',
                                        'url'=>'Yii::app()->createUrl("/odometerUpdate/create", array("id" =>
                                        $data["Vehicle_No"], "menuId"=>"odometerMnu"))'))
                                ),
                                /*array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/odometerUpdate/create", array("id" =>
                                        $data["Vehicle_No"], "menuId"=>"odometerMnu"))',
                                   // 'viewButtonUrl'=>'Yii::app()->createUrl("/odometerUpdate/create", array("id" =>$data["Vehicle_No"]))',
                                ),*/
                            ),
                        )); ?>
                    </div>
                </div>




            </div>
           <!-- <div class="col-xs-4">




                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">
                            Menu
                        </h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">

                            <?php
                            if(($userRole ==='2')||($userRole ==='6'))
                            {
                                echo MaVehicleRegistry::model()->menuarray('VehicleBookingLow');
                            }
                            elseif($userRole ==='3' || $userRole ==='4')
                            {
                                echo MaVehicleRegistry::model()->menuarray('OdometerSinhala');
                            }
                            else
                            {
                                echo MaVehicleRegistry::model()->menuarray('VehicleBooking');
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>-->
        </div>

    </div>
</div>