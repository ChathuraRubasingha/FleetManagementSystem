
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'MaReplacementOfServiceDialog',
                'options'=>array(
                    'title'=>Yii::t('maReplacementOfService','Service Replacements'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'500px',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>



