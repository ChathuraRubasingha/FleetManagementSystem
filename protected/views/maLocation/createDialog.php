
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'MaLocationDialog',
                'options'=>array(
                    'title'=>Yii::t('maLocation','Location'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'750px',
                    'height'=>'auto',
                    'min-height'=>'480px'
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>



