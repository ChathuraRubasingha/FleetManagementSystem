
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'VehicleStatusDialog',
                'options'=>array(
                    'title'=>Yii::t('vehicleStatus','Vehicle Status'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'500px',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>



