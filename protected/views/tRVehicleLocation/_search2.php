<style>

td
{
    padding:0;
}


</style>



<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


    
<?php 

#$frmTransfer = Yii::app()->session['useCurrentLoc'];
$superUser = Yii::app()->getModule('user')->user()->superuser;
$loc = Yii::app()->getModule('user')->user()->Location_ID;
?>

    <div class="formTable">
    
    
    <?php 
    
            if($superUser != 1)
            {
                echo '<div class="tblrow">
            <div class="tdOne">'.$form->label($model,'Vehicle_No')."</div>";
                echo '<div class="tdTwo">';
                    $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                        'model'=>$model,
                        'name'=>'Vehicle_No',
                        'attribute'=>'Vehicle_No',
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                            'minLength'=>'0',

                            ),
                            'source'=>$this->createUrl("MaVehicleRegistry/vehicleNumber"),
                            'htmlOptions'=>array('class'=>'midText',
                             'data-value'=>'',

                        ),
                    ));
                    echo "</div></div>";
							
                    
		}
		else
		{
                    echo '<div class="tblrow">
            <div class="tdOne">'.$form->label($model,'Current_Location_ID')."</div>";
                    echo '<div class="tdTwo">';
                        $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                            'model'=>$model,
                            'name'=>'Current_Location_ID',
                            'attribute'=>'Current_Location_ID',
                            // additional javascript options for the autocomplete plugin
                            'options'=>array(
                                    'minLength'=>'0', 
                                    
                                ),
                            'source'=>$this->createUrl("MaLocation/location"),
                            'htmlOptions'=>array('class'=>'largeText',
                            'data-value'=>'',
                                   
                            ),
                        ));
                        echo "</div></div>";
			#echo $form->dropdownlist($model,'Current_Location_ID',CHtml::listData( TRVehicleLocation::model()->findAllCurLocations(),'Location_Name','Location_Name'),array('prompt' => '--- Please Select ---')); 
			
			
			
		 	echo '<div class="tblrow"><div class="tdOne">'.$form->label($model,'Vehicle_No')."</div>";
			echo '<div class="tdTwo">';
			$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Vehicle_No',
                                'attribute'=>'Vehicle_No',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("MaVehicleRegistry/vehicleNumber"),
                                'htmlOptions'=>array('class'=>'midText',
                                    'data-value'=>'',
                                   
                                ),
                            ));
                    echo "</div></div>";
							 
            #echo $form->dropDownList($model,'Vehicle_No',CHtml::listData(MaVehicleRegistry::model()->findAllVehicles(),'Vehicle_No','Vehicle_No'),array( 'empty'=>'--- Please Select ---')); 
			
		}
	
	?>

        <div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
	</div>

<?php

if(isset(Yii::app()->session['useCurrentLoc']) && Yii::app()->session['useCurrentLoc'] !='')
{
	unset(Yii::app()->session['useCurrentLoc']);
}

 $this->endWidget(); ?>

</div><!-- search-form -->