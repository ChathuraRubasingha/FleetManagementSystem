<style type="text/css">

    #driverImg
    {
        margin-left:40% !important;
        border:2px solid;
        width:150px;
        padding:10px;
        margin-bottom:-5px;
    }

</style>
<?php $id = Yii::app()->request->getQuery('id'); ?>

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                        $this->breadcrumbs=array(
                            'Driver'=>array('admin'),
                            'Driver Details',

                        );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Driver Details</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('maDriver/Admin',"menuId"=>"driver"),array('title'=>'Manage')); ?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('maDriver/update&id='.$id,"menuId"=>"driver"),array('title'=>'Update')); ?>
                        </div>
                    </div>

                    
                </div>


                <div class="panel panel-default">

                    <div class="panel-body">
                        <div id="driverImg">

                            <?php 
                            
                            $filename=$model->Driver_Image;  

                            $dotPos = strpos($filename, '.');
                            //echo $dashPos;exit;
                            $wdth = substr($filename,5,1);

                            if($dotPos != '')
                            {
                                ?>
                                <img src="<?php echo 'DriverImages/'.$filename; ?>" width="125px" height="150px" class="DisplayImage"/>

                            <?php
                            }
                            else
                            {
                                ?>
                                <img src="<?php echo 'DriverImages/DefaultDriver.jpg'; ?>" width="125px" height="150px"/>
                    <?php   } ?>
                        </div>
                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                'Full_Name',
                                'Complete_Name',
                                 array('label'=>'Location Name', 'value'=>$model->location->Location_Name),
                                'NIC',
                                array('label'=>'Status', 'value'=>$model->Status=='1' ? "Active" : "Inactive"),
                                $model->Mobile == '' ? array('label'=>'Mobile', 'value'=>'-') : array('label'=>'Mobile', 'value'=>$model->Mobile),
                                $model->Private_Address == '' ? array('label'=>'Private Address', 'value'=>'-') : array('label'=>'Private Address', 'value'=>$model->Private_Address),
                                'add_by',
                                'add_date',
                                $model->edit_by == 'Not Edited' ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false) : array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                $model->edit_date == 'Not Edited' ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false) : array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),

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

                            <?php echo MaVehicleRegistry::model()->menuarray('maDriver'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>
            </div>
        </div>
    </div>
</div>





