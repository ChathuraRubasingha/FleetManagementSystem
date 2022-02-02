<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'MaInsuranceTypeDialog',
                'options'=>array(
                    'title'=>Yii::t('maInsuranceType','Insurance Type'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'750px',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>



