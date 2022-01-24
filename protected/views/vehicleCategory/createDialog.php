


<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'VehicleCategoryDialog',
                'options'=>array(
                    'title'=>Yii::t('vehicleCategory','Vehicle Category'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'500px',
                    'height'=>'auto',
                    'min-height'=>'500px',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>



