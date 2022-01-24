




<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="formTable">
            
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'username'); ?></div>
		<div class="tdTwo"><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'username',
                                'attribute'=>'username',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("user/username"),
                                'htmlOptions'=>array('class'=>'midText',

                                    'data-value'=>'',
                                ),
                            ));?></div>
	</div>
	
	
<?php 
		$superUser = Yii::app()->getModule('user')->user()->superuser;
                 if($superUser == 1)
                 {
	?>
        <div class="tblrow">
            <div class="tdOne"><?php echo $form->label($model,'Role_ID'); ?></div>
            <div class="tdTwo"><?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Role_ID',
                                'attribute'=>'Role_ID',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>  Yii::app()->createAbsoluteUrl("Role/Role"),
                                'htmlOptions'=>array('class'=>'largeText',
                                
                                   'data-value'=>'',
                                ),
                            ));?></div>
	</div>
    
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Location_ID'); ?></div>
		<div class="tdTwo"><?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Location_ID',
                                'attribute'=>'Location_ID',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>  Yii::app()->createAbsoluteUrl("MaLocation/location"),
                                'htmlOptions'=>array('class'=>'largeText',
                                
                                   'data-value'=>'',
                                ),
                            ));?></div>
	</div>
    <?php 
                 }
    ?>
	
	<div class="tblrow">
            	<div class="tdOne"><?php echo CHtml::activeLabel($model,'status'); ?></div>
		<div class="tdTwo"><?php echo CHtml::activeDropDownList($model,'status',User::itemAlias('UserStatus'), array('class'=>'midSelect')); ?></div>
	</div>


	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
	</div>




	


	

<?php $this->endWidget(); ?>

</div><!-- search-form -->

