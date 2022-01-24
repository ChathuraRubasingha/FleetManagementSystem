


<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'MaModelDialog',
                'options'=>array(
                    'title'=>Yii::t('maModel','Model Type'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'500px',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>



