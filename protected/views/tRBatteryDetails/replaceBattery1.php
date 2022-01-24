<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'Battery_Details_ID',
		'Vehicle_No',
		//'Driver_ID',
		array('label'=>'Driver', 'value'=>$request->driver->Full_Name),
		//'Battery_Type_ID',
		array('label'=>'Battery Type', 'value'=>$request->batteryType->Battery_Type),
		'Approved_By',
	),
)); ?>


<div class="row buttons">
            <?php echo CHtml::button('Replaced', array('id'=>'Replaced_btn')); ?>
            
			 <script type="text/javascript">
             $(document).ready(function(){
            
                $('#Replaced_btn').click(function(){
                    window.location = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=tRBatteryDetails/replaced&batterydetailsid=<?php echo Yii::app()->request->getQuery('batterydetailsid'); ?>";
                    });	 
            });
             </script>      
</div>