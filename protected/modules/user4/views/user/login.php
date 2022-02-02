<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/prime/css/login.css" type="text/css" media="screen">
<div style="margin:30px;margin-left:70px;">
<br />
<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>
<div class="login">
<h1>Login</h1>
<?php echo CHtml::beginForm(); ?>
	
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username') ?>
	</div>	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password') ?>
	</div>	
	<div class="row">
		<p class="forgot-password">
		<?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
		</p>
	</div>	
	<div class="rows">Remember me<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
	</div>
	<div class="row">
		<?php echo CHtml::submitButton(UserModule::t("Login"), array('class'=>'Logbt')); ?>
        </p>
	</div>
	
<?php echo CHtml::endForm(); ?>
</div><!-- form -->


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>
   <div class="clear"><!-- ClearFix --></div>
                </div>
           