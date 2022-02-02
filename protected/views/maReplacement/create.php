
<?php $userRole = Yii::app()->getModule('user')->user()->Role_ID;?>


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
                            'Replacement'=>array('/maReplacement/admin'),
                            'Add Replacement',
                        );
                    }

                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Add Replacement</h1>
                        <div style="float: right; margin-top: -30px">
 <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('maReplacement/admin',"menuId"=>"configuration"),array('title'=>'Manage')); ?>
                        </div>
                    </div>


                    
                </div>

                <div class="panel panel-default">



                    <div class="panel-body">
                        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
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