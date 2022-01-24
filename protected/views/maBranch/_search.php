



<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	
    
    
	
    <div class="formTable">
        <?php
                $superUser = Yii::app()->getModule('user')->user()->superuser;
                ?>
            
        <div class="tblrow">
            
            	<div class="tdOne"><?php if($superUser == 1) echo $form->label($model,'Location_ID'); ?></div>
		<div class="tdTwo"><?php  if($superUser == 1) $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                        'model'=>$model,
                        'name'=>'Location_ID',
                        'attribute'=>'Location_ID',
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                            'minLength'=>'0',

                        ),
                        'source'=>$this->createUrl("MaLocation/Location"),
                        'htmlOptions'=>array('class'=>'largeText',
                                        'data-value'=>'',

                        ),
                    ));?></div>
	</div>
	
	<div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Branch'); ?></div>
		<div class="tdTwo"><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Branch',
                                'attribute'=>'Branch',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
									
                                    
                                ),
                                'source'=>$this->createUrl("MaBranch/branch"),
                                'htmlOptions'=>array('class'=>'midText',
                                    'data-value'=>'',
                                   
                                ),
                            ));?></div>
	</div>



	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
	</div>


    
   
	

<?php $this->endWidget(); ?>

</div><!-- search-form -->