



<div align="center">

</div>







<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs = array(
                        //'Management'=>array('notificationConfiguration/management'),
                        'Configuration',
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Configurations</h1>
                    </div>

                    <div class="panel-body">
                        <div><img src="images/configuration.png" align="middle"  width="364px" height="301px" style="margin-top:5%; margin-left:40%; max-height: 400px"/></div>
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

