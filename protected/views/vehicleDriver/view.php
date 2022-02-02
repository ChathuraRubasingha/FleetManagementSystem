<style type="text/css">

.add{
	margin-left:83%;
float:left;
	margin-top:-12px;
}
.manage
{
	margin-left:88%;
	margin-top:-12px;
	
}
.update{
	margin-left:95%;
	margin-top:-49px;
}

.back a
{
	background-color:#31E9FF !important;
}

</style>


<?php
$superUser = Yii::app()->getModule('user')->user()->superuser;

$id = Yii::app()->request->getQuery('id');
$status = Yii::app()->request->getQuery('status');
$vNo = Yii::app()->request->getQuery('vNo');

//$vNo ='';
if(!empty($id))
{
	$arr = Yii::app()->db->createCommand('select Vehicle_No from vehicle_driver where Driver_Allocation_ID='.$id)->queryAll();
	$count = count($arr);
	
	if($count>0)
	{
		$vNo = $arr[0]['Vehicle_No'];
	}
}

?>


<?php



$id = Yii::app()->request->getQuery('id');
$vNo ='';
if(!empty($id))
{
    $arr = Yii::app()->db->createCommand('select Vehicle_No from vehicle_location where Vehicle_Location_ID='.$id)->queryAll();
    $count = count($arr);

    if($count>0)
    {
        $vNo = $arr[0]['Vehicle_No'];
    }
}
if($model->Vehicle_No !='')
{
    $vNo =$model->Vehicle_No;
}

?>
<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Vehicle Registry'=>array('maVehicleRegistry/edit'),
                        'Driver Assigned Vehicles'=>array('/vehicleDriver/admin'),
                        'Assigned Driver Details'


                    );

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Assigned Driver Details</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php 
                           if($status == "History")
                            {
                            }
                            else
                            {
                                echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('vehicleDriver/admin',"menuId"=>"vreg"),array('title'=>'Manage'))."&nbsp;"; 
                                echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('vehicleDriver/update&id='.$id,"menuId"=>"vreg"),array('title'=>'Update'));
                               
                            } ?>
                        </div>
                    </div>

                    


                       
                       

                   
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h2><center><?php echo $vNo?></center></h2>
                    </div>

                    <div class="panel-body">

                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                array('label'=>'Driver', 'value'=>$model->driver->Full_Name),
                                array('label'=>'Location', 'value'=>$model->location->Location_Name),
                                'From_Date',
                                array('label'=>'To Date', 'value'=>$model->To_Date == '0000-00-00' ? '-' : CHtml::encode($model->To_Date)),
                                'add_by',
                                'add_date',
                                $model->edit_by == 'Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                $model->edit_date == 'Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false) : array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),

                            ),
                        )); ?>
                        <br/><br/>
                        <center><h2>Assigned Driver's History of the Vehicle</h2></center>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'vehicle-driver-grid',
                            'dataProvider'=>$model->AssignedDriverHistory($model->Vehicle_No),
                            #'filter'=>$model,
                            'columns'=>array(
                                //'Vehicle_Location_ID',
                                //'Vehicle_No',
                                array('name'=>'Driver_ID', 'header'=>'Driver', 'value'=>array($this, 'gridDriverName')),
                                #array('name'=>'Vehicle Category', 'type'=>'raw', 'value'=>array($this, 'gridCategoryName')),
                                #'Location_ID',
                                $superUser == 1 ? array('name'=>'Location_ID', 'header'=>'Location', 'value'=>'$data->location->Location_Name'): array('name'=>'Location_ID', 'header'=>'Location', 'visible'=>false),
                                #'Driver_ID',
                                //array('name'=>'Driver_ID', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),

                                'From_Date',
                                'To_Date',

                               /* array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{view}',
                                    'viewButtonUrl'=>'Yii::app()->createUrl("/vehicleDriver/view", array("id"=>$data["Driver_Allocation_ID"], "vNo"=>$data["Vehicle_No"], "status"=>"History"))'
                                ),*/
                            ),
                        )); ?>

                    </div>




                </div>
            </div>
            <div class="col-xs-4">




                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">
                            Menu
                        </h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">

                            <?php echo MaVehicleRegistry::model()->menuarray('VehicleRegistry'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>












