

<?php
$id = Yii::app()->request->getQuery('id');
$userRole = Yii::app()->getModule('user')->user()->Role_ID;
?>



<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    if($userRole !=='3')
                    {
                        $this->breadcrumbs=array(
                            'Configurations'=>array('/notificationConfiguration/management'),
                            'Insurance Company'=>array('/maInsuranceCompany/admin'),
                            'Insurance Company Details',
                        );
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Insurance Company Details</h1>
                        <div style="float: right; margin-top: -30px">
<?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('maInsuranceCompany/create',"menuId"=>"configuration"), array('title'=>'Add'));?>
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('maInsuranceCompany/admin',"menuId"=>"configuration"),array('title'=>'Manage')); ?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('maInsuranceCompany/update&id='.$id,"menuId"=>"configuration"),array('title'=>'Update')); ?>
                        </div>
                    </div>

                    
                </div>


                <div class="panel panel-default">


                    <div class="panel-body">

                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                'Insurance_Company_Name',
                                'Address',
                                array('label'=>'Land phone', 'value'=>(!empty($model->Land_phone_No))? CHtml::encode($model->Land_phone_No): '-'),
                                array('label'=>'Mobile', 'value'=>(!empty($model->Mobile))? CHtml::encode($model->Mobile): '-'),
                                array('label'=>'Fax', 'value'=>(!empty($model->Fax))? CHtml::encode($model->Fax): '-'),
                                array('label'=>'Email', 'value'=>(!empty($model->Email))? CHtml::encode($model->Email): '-'),
                                array('label'=>'Contact Person', 'value'=>(!empty($model->Contact_Person))? CHtml::encode($model->Contact_Person): '-'),
                                'Registration_No',
                                'add_by',
                                'add_date',
                                $model->edit_by == "Not Edited" ? array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>false):array('label'=>'Edit By', 'value'=>$model->edit_by, 'visible'=>true),
                                $model->edit_date == "Not Edited" ? array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>false):array('label'=>'Edit Date', 'value'=>$model->edit_date, 'visible'=>true),

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
                        <div class="verticalaccordion">
                            <ul>
                                <?php echo MaVehicleRegistry::model()->menuarray('configurations');      ?>

                            </ul>
                        </div>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>
