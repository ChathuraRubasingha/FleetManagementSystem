

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php

                    $this->breadcrumbs=array(
                        UserModule::t('Access')=>array('/accessPermission/accesscontrol'),
                        UserModule::t('Add User'),
                    );?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo UserModule::t("Add User"); ?></h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('admin',"menuId"=>"access"),array('title'=>'Manage')); ?>
                        </div>
                    </div>


                    
                </div>

                <div class="panel panel-default">
                    


                    <div class="panel-body">
                        <?php echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile)); ?>
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