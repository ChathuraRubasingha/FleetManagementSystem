<style>
    .label
    {
        color: #000000;
    }
</style>

    

    
    <div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
                        $this->breadcrumbs=array(
                        UserModule::t("Profile"),
                    );
                    ?>  
                </ul>
            </div>
            <div class="col-xs-8" style="margin-left: 20%">

                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><?php echo UserModule::t('Your profile'); ?></h1>
                    </div>

                    <div class="panel-body">

                        <ul>
                            <?php echo CHtml::link('<img src="images/manage.png" style="height:40px; width:30px"  />',array('/user/admin'),array('title'=>'Manage'));
                         ?>
                         </ul>

                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-body">



    <?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
    <div class="success">
    <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
    </div>
    <?php endif; ?>

                        <table class="dataGrid" style="margin-left: 35%">
    <tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('username')); ?></th>
        <td><?php echo CHtml::encode($model->username); ?></td>
    </tr>
    <?php 
        $profileFields=ProfileField::model()->forOwner()->sort()->findAll();
        if ($profileFields)
        {
            foreach($profileFields as $field) 
            {
    ?>
    <tr>
        <th class="label"><?php echo CHtml::encode(UserModule::t($field->title)); ?></th>
        <td><?php echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); ?></td>
    </tr>
            <?php
            }//$profile->getAttribute($field->varname)
        }
    ?>
    <tr>
        <th class="label"><?php echo CHtml::encode($model->getAttributeLabel('email')); ?></th>
        <td><?php echo CHtml::encode($model->email); ?></td>
    </tr>
    <tr>
        <th class="label"><?php echo CHtml::encode($model->getAttributeLabel('createtime')); ?></th>
        <td><?php echo date("d.m.Y H:i:s",$model->createtime); ?></td>
    </tr>
    <tr>
        <th class="label"><?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?></th>
        <td><?php echo date("d.m.Y H:i:s",$model->lastvisit); ?></td>
    </tr>
    <tr>
        <th class="label"><?php echo CHtml::encode($model->getAttributeLabel('status')); ?></th>
        <td><?php echo CHtml::encode(User::itemAlias("UserStatus",$model->status));?></td>
    </tr>
</table>

                    </div>
                </div>
            </div>
            <div class="col-xs-4">




                

            </div>
        </div>

    </div>
</div>
