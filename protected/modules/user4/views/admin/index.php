

<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        UserModule::t('Access')=>array('/accessPermission/accesscontrol'),
                        UserModule::t('Manage User'),
                    );
                    ?>
                </ul>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo UserModule::t("User Registry"); ?></h1>
                    </div>

                    <div class="panel-body">


                        <?php  echo  CHtml::link('<img src="images/add.png" style="height:50px; width:50px"  />',array('create'), array('title'=>'Add'));?>
                        <?php #echo CHtml::link('<img src="images/search.png"  width="38px" height="38px"/>','#',array('class'=>'search-button','title'=>'Search')); ?>


                    </div>
                </div>

                <div class="panel panel-default">
                   
                    <div class="panel-body">


                        <div id="statusMsg">
                        </div>
                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'dataProvider'=>$dataProvider,
                            'columns'=>array(
                                array(
                                    'name' => 'id',
                                    'type'=>'raw',
                                    //'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
                                    'value' => 'CHtml::encode($data->id)',
                                ),
                                array(
                                    'name' => 'username',
                                    'type'=>'raw',
                                    //'value' => 'CHtml::link(CHtml::encode($data->username),array("admin/view","id"=>$data->id))',
                                    'value' => 'CHtml::encode($data->username)',
                                ),
                                array(
                                    'name'=>'Role_ID',
                                    'type'=>'raw',
                                    // 'value' => 'CHtml::link(CHtml::encode($data->role->Role),array("admin/view","id"=>$data->role->Role))',
                                    'value' => 'CHtml::encode($data->role->Role)',
                                ),
                                /* array(
                                     'name'=>'email',
                                     'type'=>'raw',
                                     'value'=>'CHtml::link(CHtml::encode($data->email), "mailto:".$data->email)',
                                 ),*/
                                /*array(
                                     'name' => 'createtime',
                                     'value' => 'date("d.m.Y H:i:s",$data->createtime)',
                                ),
                                 array(
                                     'name' => 'lastvisit',
                                     'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):UserModule::t("Not visited"))',
                                 ),*/
                                array(
                                    'name'=>'status',
                                    'value'=>'User::itemAlias("UserStatus",$data->status)',
                                ),
                                array(
                                    'name'=>'superuser',
                                    'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
                                ),
                                array(
                                    'name'=>'District_ID',
                                    'value'=>'$data->district->District_Name',
                                ),
                                array(
                                    'name'=>'Location_ID',
                                    'value'=>'$data->location ->Location_Name',
                                ),
                                array(
                                    'class'=>'CButtonColumn',
                                ),
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