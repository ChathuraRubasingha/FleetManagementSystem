
<div class="container body">
<div id="main" role="main">
  <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">
   
    <div class="col-xs-8">
     
      <div class="panel panel-default bottombox mtop">
        <div class="panel-heading">
          <h2 class="panel-title">Categories<small class="pull-right"> <i class="icon-pencil"></i> </small></h2>
        </div>
        <div class="panel-body">
       
           
          
          
          
          
        </div>
        
        
        
      </div>
       <div class="panel panel-default">
          <div class="panel-heading large">
         <h2 class="panel-title">Items</h2>
         </div>
          
          <div class="panel-body">
        
         
    
           
         
          </div>
        </div>
      
      
   
      </div>

     <div class="col-xs-4">
        <div class="panel panel-default rating-widget">
          <div class="panel-heading large">
            <h4 class="panel-title">
           Master
            </h4>
          </div>
          <div class="panel-body">
            <ul class="list-unstyled">
             <?php echo Atributes::model()->menuarray('mas'); ?>
             </ul>
          </div>
          <div class="panel-footer text-center"> </div>
        </div>
        
       <div class="panel panel-default rating-widget">
          <div class="panel-heading large">
            <h4 class="panel-title">
           Master
            </h4>
          </div>
          <div class="panel-body">
            <ul class="list-unstyled">
             <?php echo Atributes::model()->menuarray('items'); ?>
             </ul>
          </div>
          <div class="panel-footer text-center"> </div>
        </div>
     
      </div>
    </div>

  </div>
</div>
</div>
</body></html>