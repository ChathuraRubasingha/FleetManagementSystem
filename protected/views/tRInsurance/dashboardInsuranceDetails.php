              
                
                
 <div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading large" style="color:#fff; background: #9cd159">
                        <h1 class="panel-title" itemprop="name">Insurance Details</h1>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">


                <div class="panel panel-default">
                    

                    <div class="panel-body">


                        <?php 


                             $this->widget('zii.widgets.grid.CGridView', array(
                                     'id'=>'insurance-view-grid',
                             'dataProvider'=>$model->insurance(),
                             'columns'=>array(
                             'Vehicle_No', 
                             //array('name'=>'Location','value'=>'$data->vehicle_location->Location_ID'),
                             //array('name'=>'Model', 'type'=>'raw', 'value'=>array($this,'gridModel'), //call this controller method for each row
                             array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
                             //'Location_ID', 
                             'Valid_To',
                             'Remaining_Days',

                      
                             ),
                             ));

                              ?>
            
            


                    </div>
                </div>




            </div>
            
        </div>

    </div>
</div>               




		
