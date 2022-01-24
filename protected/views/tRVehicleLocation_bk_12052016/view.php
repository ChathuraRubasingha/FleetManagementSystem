

<?php
$this->breadcrumbs=array(
	'Vehicle Registry'=>array('/maVehicleRegistry/edit'),
	'Location Assigned Vehicles'=>array('/tRVehicleLocation/admin'),
	'Assigned Location Details'

);


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

?>
<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs = array(
                        'Vehicle Registry' => array('edit'),
                        'View Vehicle Details'
                    );

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Assigned Location Details</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRVehicleLocation/admin',"menuId"=>"vreg"),array('title'=>'Manage'));?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRVehicleLocation/update&id='.$id,"menuId"=>"vreg"),array('title'=>'Update')); ?>
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
                                #'Vehicle_Location_ID',
                                #'Location_ID',
                                #'Vehicle_No',
                                array('label'=>'Location', 'value'=>$model->location->Location_Name),
                                #array('label'=>'Driver','value'=>$model->driver->Full_Name),
                                'From_Date',
                                //'To_Date',
                                array('label'=>'To Date', 'value'=>$model->To_Date == '0000-00-00' ? '-' : CHtml::encode($model->To_Date)),
                                #'Driver_ID',
                                'add_by',
                                'add_date',
                                $model->edit_by=='Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                $model->edit_date=='Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false) : array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),
                                /*'edit_by',
                                'edit_date',*/
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



