<div class="group3">
    <h1>Manage Users</h1>
    <?php

    $this->title = Yum::t('');

    $this->breadcrumbs = array(
        Yum::t('Access') => array('/site/accesscontrol'),
        Yum::t('Manage Users'));

    echo Yum::renderFlash();
echo '<div id="statusMsg">
                        </div>';
    $this->widget('application.modules.user.components.CsvGridView', array(
        'dataProvider'=>$model->search(),

        'columns'=>array(
            array(
                'name'=>'id',
                'filter' => false,
                'type'=>'raw',
                'value'=>'CHtml::link($data->id,
				array("//user/user/update","id"=>$data->id))',
            ),
            array(
                'name'=>'username',
                'type'=>'raw',
                'value'=>'CHtml::link(CHtml::encode($data->username),
				array("//user/user/view","id"=>$data->id))',
            ),
            array(
                'name'=>'createtime',
                'filter' => false,
                'value'=>'date(UserModule::$dateFormat,$data->createtime)',
            ),
            //array(
            //	'name'=>'lastvisit',
            //	'filter' => false,
            //	'value'=>'date(UserModule::$dateFormat,$data->lastvisit)',
            //),
            array(
                'name'=>'status',
                'filter' => false,
                'value'=>'YumUser::itemAlias("UserStatus",$data->status)',
            ),
            array(
                'name'=>Yum::t('Roles'),
                'type' => 'raw',
                'visible' => Yum::hasModule('role'),
                'filter' => false,
                'value'=>'$data->getRoles()',
            ),

            array(
                'class'=>'CButtonColumn',
                'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
            ),
        ))); ?>
    <div style="height:17px;"></div>

</div>
