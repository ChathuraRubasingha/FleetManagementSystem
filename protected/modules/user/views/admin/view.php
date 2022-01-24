<?php $id = Yii::app()->request->getQuery('id'); ?>

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        UserModule::t('Access')=>array('/accessPermission/accesscontrol'),
                        UserModule::t('User Details'),
                    );

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo UserModule::t('User Details'); ?></h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/add.png" class="addIcon"  />',array('create',"menuId"=>"access"), array('title'=>'Add'));?>
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('admin',"menuId"=>"access"),array('title'=>'Manage')); ?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('update&id='.$id,"menuId"=>"access"),array('title'=>'Update')); ?>
                        </div>
                    </div>

                    
                </div>


                <div class="panel panel-default">
                    

                    <div class="panel-body">

                        <?php

                        $attributes = array(
                            //'id',
                            'username',
                            //array('label'=>'Role', 'value'=>$model->Role->Role),
                            array(
                                'name' => 'Role_ID',
                                'value' => $model->role->Role,
                            ),
                            array(
                                'name' => 'superuser',
                                'value' => User::itemAlias("AdminStatus",$model->superuser),
                            ),
                            array(
                                'name' => 'status',
                                'value' => User::itemAlias("UserStatus",$model->status),
                            )

                        );

                        $profileFields=ProfileField::model()->forOwner()->sort()->findAll();
                        if ($profileFields) 
                        {
                            foreach($profileFields as $field) 
                            {
                                array_push($attributes,array(
                                    'label' => UserModule::t($field->title),
                                    'name' => $field->varname,
                                    'type'=>'raw',
                                    'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),
                                ));
                            }
                        }

                        array_push($attributes,
                            //'password',
                            //'email',
                            array(
                                'name' => 'Phone_Number',
                                'value' => $model->Phone_Number ==""? "-" : $model->Phone_Number,
                            ),
                            array(
                                'name' => 'email',
                                'value' => $model->email ==""? "-" : $model->email,
                            ),

                            array(
                                'name' => 'Designation_ID',
                                'value' => $model->Designation_ID ==""? "-" : $model->designation->Designation,
                            ),

                            array(
                                'name' => 'District_ID',
                                'value' => $model->district->District_Name,
                            ),
                            array(
                                'name' => 'Location_ID',
                                'value' => $model->location->Location_Name,
                            ),
                            array(
                                'name' => 'Branch_Id',
                                'value' => $model->Branch_Id =="" || $model->Branch_Id =="0" ? "-" : $model->branch->Branch,
                            ),
                            //'activkey',

                            array(
                                'name' => 'createtime',
                                'value' => date("d.m.Y H:i:s",$model->createtime),
                            ),
                            array(
                                'name' => 'lastvisit',
                                'value' => (($model->lastvisit)?date("d.m.Y H:i:s",$model->lastvisit):UserModule::t("Not visited")),
                            )

                        );

                        $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>$attributes,
                        ));


                        ?>
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

                            <?php
                            echo MaVehicleRegistry::model()->menuarray('AccessInUser');

                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>