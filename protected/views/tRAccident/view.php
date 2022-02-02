<style>

    
    .imgOuter
    {
        width: auto; 
        height:auto; 
        border: thick solid #000; 
        float: left;
    }
    
</style>

<link rel="stylesheet" type="text/css" href="css/upload.css">
<?php

$id = Yii::app()->request->getQuery('id');
$vehicleId = Yii::app()->session['accidentVehicleId'];


?>






<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <?php
                    $this->breadcrumbs=array(
                        'Accident'=>array('/tRAccident/accidentHistory'),
                        'Select Vehicle for Accident Details'=>array('/maVehicleRegistry/accident'),
                        'Accident Details'

                    );

                    ?>
                </ul>
            </div>
            
            <div class="col-xs-8">
                <div class="panel panel-default">
                    <div class="panel-heading large">
                      
                        <h1 id="rest-title" class="panel-title" itemprop="name">Accident Details</h1>
                        <div style="float: right; margin-top: -30px">
                            <?php echo CHtml::link('<img src="images/manage.png" class="manageIcon" />',array('tRAccident/Admin',"menuId"=>"accident"),array('title'=>'Manage'));?>
                            <?php echo CHtml::link('<img src="images/update.png" class="updateIcon" />',array('tRAccident/update&id='.$id,"menuId"=>"accident"),array('title'=>'Update'));?>
                        </div>
                    </div>

                    
                </div>


                <div class="panel panel-default">

                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name"><center><?php echo $vehicleId; ?></center></h1>
                    </div>
                    <div class="panel-body">

                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                array('name'=>'Driver_ID', 'value'=>$model->driver->Full_Name),
                                array('name'=>'Odometer_After_Accident', 'value'=>$model->Odometer_After_Accident != '' ? $model->Odometer_After_Accident : "-"),
                                'Accident_Place',
                                'Date_and_Time',
                                array('label'=>'Details', 'value'=>(!empty($model->Details)? CHtml::encode($model->Details): '-')),
                                'Police_Station',
                                'Address',
                                'Police_Report_No',
                                'add_by',
                                'add_date',
                                $model->edit_by == 'Not Edited' ? array('visible'=>false): array('label'=>'Edit By', 'type'=>'raw', 'value'=>$model->edit_by),
                                $model->edit_date == 'Not Edited' ? array('visible'=>false): array('label'=>'Edit Date', 'type'=>'raw', 'value'=>$model->edit_date),
                            ),
                        )); ?>
                        
                        <div id="image-list">
            <?php
            $accID = Yii::app()->request->getQuery('id');
            if(isset($accID) && $accID != '')
            {
                $v_number =  Yii::app()->session['accidentVehicleId'];
                $directory = "accidentImages/$v_number/$accID";
                
                if (file_exists($directory)) 
                {
                    chdir($directory);
                    $images = glob("*.{jpg,JPG}", GLOB_BRACE);
                    echo '<div id="list">';
                    foreach ($images as $image) 
                    {
                        $fullImage = $image;
                                                
                        echo '
                            <div class="imgOuter"><center>' . CHtml::image("$directory/$image", 'DORE', array(
                            'width' => '100',
                            'height' => '100')) . "</br>
                            </center></div>
                                    
                            ";
                        
                    }
                    echo '</div>';
                } 
                else 
                {
                    //echo '<h2>No Images for the accident</h2>';
                }

            } 
            else 
            {
                echo "<div id='list'> </div>";
            }
            
            
            
            ?>

        </div>

                    </div>
                </div>
            </div>
            <div class="col-xs-4">




                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">
                            Menu
                        </h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">

                            <?php echo MaVehicleRegistry::model()->menuarray('Accident'); ?>
                        </ul>
                    </div>
                    <div class="panel-footer text-center"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
