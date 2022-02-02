<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'MaServiceStationDialog',
                'options'=>array(
                    'title'=>Yii::t('maServiceStation','Service Station'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'800px',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>



