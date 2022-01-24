
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'MaBatteryTypeDialog',
                'options'=>array(
                    'title'=>Yii::t('maBatteryType','Battery Type'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'500px',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');
?>



