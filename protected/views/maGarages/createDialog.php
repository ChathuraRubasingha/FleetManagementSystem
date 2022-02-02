<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'MaGaragesDialog',
                'options'=>array(
                    'title'=>Yii::t('maGarages','Garage'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'750px',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>



