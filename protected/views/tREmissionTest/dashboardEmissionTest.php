              
                
                
 <div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading large" style="color:#fff; background: #9cd159">
                        <h1 class="panel-title" itemprop="name">Emission Test Details</h1>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12">

                <div class="panel panel-default">
                    
                    <div class="panel-body">


                        <?php 
                        
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'emmission-view-grid',
                                'dataProvider'=>$model->emmissionTest(),
                                'columns'=>array(
                                    'Vehicle_No',
                                    array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
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




		
