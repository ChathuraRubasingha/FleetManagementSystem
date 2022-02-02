
<div class="container body">
  <div id="main" role="main">
    <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant"> 
      
      <div class="col-xs-12">
        <ul class="breadcrumb">
            
        </ul>
      </div>
      <div class="col-xs-8" style="margin-left:20%">
        <div class="panel panel-default">
          <div class="panel-heading large">
            <h1 id="rest-title" class="panel-title" itemprop="name">Recover Password</h1>
            
           </div>
          
          

     

</div>


    <div class="panel panel-default">
        

        <div class="panel-body">
                        
                        <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>
                        <div class="form">

<?php echo CHtml::beginForm(); ?>


	<?php echo CHtml::errorSummary($form); ?>
    <table width="100%" border="1" class="tblle" style="">
	<div class="row">
            
		
		
	
 
    <tr><td>
		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
        </td><td>
		<?php echo CHtml::activeTextField($form,'login_or_email') ?>
		<p class="hint"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>
        </td></tr>
	</div>

	
</table>
           
	<div class="row buttons" style="padding-left:75%;font-weight:bold">
		<?php echo CHtml::submitButton(UserModule::t("Restore")); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div>
                        
      <?php endif; ?>                 
                        
                    </div>
    </div>
</div>	
 <div class="col-xs-4">
       
        
       
        
        
     
      </div>
    </div>

  </div>
</div>