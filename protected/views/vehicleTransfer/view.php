<style type="text/css">

.update{
	margin-left:94.4%;
	margin-top:-8.6px;}
</style>
<?php


$id = Yii::app()->request->getQuery('id');

if(!empty($id))
{
	$arr = Yii::app()->db->createCommand('select Vehicle_No from vehicle_transfer where VehicleTransfer_ID='.$id)->queryAll();
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
                    $this->breadcrumbs=array(
                        'Vehicle Registry'=>array('maVehicleRegistry/edit'),
                        'Transfer Vehicle'=>array('tRVehicleLocation/transferVehicle'),
                        'Transfered Vehicle Details',
                    );

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Transferred Vehicle Details</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('vehicleTransfer/update&id='.$id,"menuId"=>"vreg"),array('title'=>'Update')); ?>
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
                                #'VehicleTransfer_ID',
                                #'Vehicle_No',
                                #'From_Location_ID',
                                array('label'=>'From Location','value'=>$model->fromLocation->Location_Name),
                                array('label'=>'To Location','value'=>$model->toLocation->Location_Name),
                                #'To_Location_ID',
                                'From_Date',
                                #'To_Date',
                                array('label'=>'To Date', 'value'=>$model->To_Date == '0000-00-00' ? '-' :CHtml::encode($model->To_Date) ),
                                'add_by',
                                'add_date',
                                $model->edit_by=='Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                $model->edit_date=='Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false) : array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),
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

