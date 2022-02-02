<style>
    .label
    {
        color: #000000;
        text-align: right !important;
        display: block;
        font-size: 13px;
    }
    
    .midColon
    {
        width:50px;
        text-align: center;
    }
    td
    {
        padding: 5px;
    }
    th
    {
        text-align: right;
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
                        <div style="float: right; margin-top: -30px">
                            <?php
                            $role = Yii::app()->getModule('user')->user()->Role_ID;
                            if($role ==='1')
                            {
                                echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('/user/admin'),array('title'=>'Manage')); 
                            }?>
                        </div>
                    </div>

                    
                </div>


                <div class="panel panel-default">
                    <div class="panel-body">



    <?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
    <div class="success">
    <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
    </div>
    <?php endif; 
	date_default_timezone_set("Asia/Colombo");	
	?>

                        <table class="dataGrid" style="margin-left: 30%">
    <tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('username')); ?></th>
        <td class="midColon">:</td>
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
        <td class="midColon">:</td>
        <td><?php echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); ?></td>
    </tr>
            <?php
            }//$profile->getAttribute($field->varname)
        }
    ?>
    <tr>
        <th class="label"><?php echo CHtml::encode($model->getAttributeLabel('email')); ?></th>
        <td class="midColon">:</td>
        <td><?php echo CHtml::encode($model->email); ?></td>
    </tr>
    <tr>
        <th class="label"><?php echo CHtml::encode($model->getAttributeLabel('createtime')); ?></th>
        <td class="midColon">:</td>
        <td><?php echo date("d.m.Y H:i:s",$model->createtime); ?></td>
    </tr>
    <tr>
        <th class="label"><?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?></th>
        <td class="midColon">:</td>
        <td><?php echo date("d.m.Y H:i:s",$model->lastvisit); ?></td>
    </tr>
    <tr>
        <th class="label"><?php echo CHtml::encode($model->getAttributeLabel('status')); ?></th>
        <td class="midColon">:</td>
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
