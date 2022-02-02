


<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'FuelTypeDialog',
                'options'=>array(
                    'title'=>Yii::t('fuelType','Fuel Type'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'500px',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_formDialog', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>



