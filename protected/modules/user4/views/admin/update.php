
<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        UserModule::t('Access')=>array('/accessPermission/accesscontrol'),
                        UserModule::t('Update User Details'),
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo  UserModule::t('Update User Details') ?></h1>
                    </div>


                    <div class="panel-body">


                        <?php

                        echo CHtml::link('<img src="images/add.png" style="height:50px; width:50px; margin-right:4px !important"  />',array('create'),array('title'=>'Add'));
                        echo CHtml::link('<img src="images/manage.png" style="height:40px; width:30px; margin-right:15px !important"  />',array('admin'),array('title'=>'Manage'));
                        # echo CHtml::link('<img src="images/update.png" style="height:37px; width:30px" />',array('tRServices/update&id='.$id),array('title'=>'Update'));


                        ?>

                    </div>
                </div>

                <div class="panel panel-default">
                    


                    <div class="panel-body">
                        <?php echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));  ?>
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

                            <?php echo MaVehicleRegistry::model()->menuarray('AccessInUser');
                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>

            </div>
        </div>

    </div>
</div>