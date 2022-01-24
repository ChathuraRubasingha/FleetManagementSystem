<style>
.col-xs-8
{
width:86%;
margin-left:7%;
margin-right:7%;
font-size:10px;
}

.grdh
{
	font-size:12px;
	background-color:#FAFEF5;
	padding:5px;
}
.cus_name
{
	font-weight:bold;
	margin-right:5px;
	font-size:14px;
}
span
{
	margin-right:5px;
}
.cus_bookid
{
	font-weight:bold;
	margin-right:5px;
	font-size:14px;
	color:#690;
}
.witems img 
{
	width:20px;
	padding:0px;
	margin-right:1%;
}
.rdate
{
	margin-left:15px;
	font-weight:bold;
	margin-right:5px;
	font-size:14px;
	color:#F00;
	
}
.ver
{
	color:#090;
}
.staus
{
	margin:0px;
	width:12%;
	line-height:25px;
	font-weight:bold;

}
.na
{
	color:#F00;
}
</style>


  <div id="main" role="main">
    <div class="row rest-view"> 
      
      <div class="col-xs-12">
        <ul class="breadcrumb">
        
        </ul>
      </div>
      <div class="col-xs-8">
        <div class="panel panel-default">
          <div class="panel-heading large">
      <h1 id="rest-title" class="panel-title" itemprop="name">Pending Booking Request</h1>
          </div>
          
          <div class="panel-body">
           
        <div class="grdm">
        
         <?php  $reqlist =  TourMaking::model()->bookinglist(1);
        
        foreach ($reqlist as $bookings) 
	    {
       echo  '<div class="grdh"><span class="rdate">'.$bookings['requested_date'].'</span><span class="cus_bookid">#'.$bookings['booking_no'].'</span><span class="cus_name">'.$bookings['customer_name'].'</span><span class="cus_tel">'.$bookings['telephone'].'/'.$bookings['mobile'].'</span><span class="cus_add">'.$bookings['address'].'</span></div>';
           
	if(isset($bookings['booking_no']))
	{
  	        $tlist =  TourMakingDetails::model()->propertylist($bookings['booking_no']);
			$cost =  TourMakingDetails::model()->totalbudget($bookings['booking_no']);
			
			foreach ($tlist as $value) 
		   { 
		   $status='<div class="wiitem staus">Pending<img src="images/ajax-loader2.gif" /></div>';
		   if($value['status']==2)
		   {
			   $status='<div class="wiitem staus ver">Verified</div>';
		   }
		   else if($value['status']==1)
		   {
			   $status='<div class="wiitem staus na">Not Available</div>';
		   }
			   
	
		   
	     echo  ' <div class="witems">'.$status.CHtml::link('<img src="images/delete-32.png" />',array('/propertyReg/notAvalible', 'id'=>$value['tour_dcode'])).CHtml::link('<img src="images/Screenshot-32.png" />',array('/propertyReg/verified', 'id'=>$value['tour_dcode'],'bid'=>$bookings['booking_no']));
	     echo '<div class="price">'.number_format($value['cost'], 2, '.', '').'</div>';		  
         echo '<div class="wiitem">'.'<span>Adults</span>'.$value['adults'].'<br>'.'<span>Children</span>'.$value['children'].'</div>';
	   	 echo '<div class="wiitem">'.'<span>Check In</span>'.$value['check_in'].'<br>'.'<span>Check Out</span>'.$value['check_out'].'</div>';
		 echo '<div class="prname">'.$value['property_name'].'<br><span class="address">'.$value['address'].'</span></div></div>';
	  }

		   echo '<div class="witems total"><div class="pricet">'.number_format($cost[0]['cost'], 2, '.', '').'</div><div class="tcost">Total Budget</div></div>';
	}
	else
	{
		
		   echo '<div class="witems total">Please make your tour as wish </div>';
	}
		}
      ?>
           
           
           </div>
           
         
         
          
          
          </div>
        </div>
        
        
    
        <div class="panel panel-default bottombox mtop">
          <div class="panel-heading">
                     <h1 id="rest-title" class="panel-title" itemprop="name">Verified Booking</h1>
        
           
          </div>
          <div class="panel-body">
           <div class="grdm">
          <?php  $reqlist =  TourMaking::model()->bookinglist(2);
        
        foreach ($reqlist as $bookings) 
	    {
       echo  '<div class="grdh"><span class="rdate">'.$bookings['requested_date'].' / '.$bookings['verified_date'].' / '.$bookings['verified_by'].'</span><span class="cus_bookid">#'.$bookings['booking_no'].'</span><span class="cus_name">'.$bookings['customer_name'].'</span><span class="cus_tel">'.$bookings['telephone'].'/'.$bookings['mobile'].'</span><span class="cus_add">'.$bookings['address'].'</span></div>';
           
	if(isset($bookings['booking_no']))
	{
  	        $tlist =  TourMakingDetails::model()->propertylist($bookings['booking_no']);
			$cost =  TourMakingDetails::model()->totalbudget($bookings['booking_no']);
			
			foreach ($tlist as $value) 
		   { 
		   $status='<div class="wiitem staus">Pending<img src="images/ajax-loader2.gif" /></div>';
		   if($value['status']==2)
		   {
			   $status='<div class="wiitem staus ver">Verified</div>';
		   }
			   
	  else if($value['status']==1)
		   {
			   $status='<div class="wiitem staus na">Not Available</div>';
		   }
		   
	      echo  ' <div class="witems">'.$status;
	     echo '<div class="price">'.number_format($value['cost'], 2, '.', '').'</div>';		  
         echo '<div class="wiitem">'.'<span>Adults</span>'.$value['adults'].'<br>'.'<span>Children</span>'.$value['children'].'</div>';
	   	 echo '<div class="wiitem">'.'<span>Check In</span>'.$value['check_in'].'<br>'.'<span>Check Out</span>'.$value['check_out'].'</div>';
		 echo '<div class="prname">'.$value['property_name'].'<br><span class="address">'.$value['address'].'</span></div></div>';
	  }

		   echo '<div class="witems total">'.CHtml::link('<img src="images/payment-card.png" title="Paid" alt="Paid" />',array('/tourMaking/payment', 'bid'=>$bookings['booking_no'])).'<div class="pricet">'.number_format($cost[0]['cost'], 2, '.', '').'</div><div class="tcost">Total Budget</div></div>';
	}
	else
	{
		
		   echo '<div class="witems total">Please make your tour as wish </div>';
	}
		}
      ?>
           
           
           
           </div>
          </div>
        </div>
        
         <div class="panel panel-default bottombox mtop">
          <div class="panel-heading">
                     <h1 id="rest-title" class="panel-title" itemprop="name">Confirmed Bookings</h1>
        
           
          </div>
          <div class="panel-body">
     <?php  $reqlist =  TourMaking::model()->bookinglist(3);
        
        foreach ($reqlist as $bookings) 
	    {
       echo  '<div class="grdh"><span class="rdate">'.$bookings['requested_date'].' / '.$bookings['verified_date'].' / '.$bookings['verified_by'].'</span><span class="cus_bookid">#'.$bookings['booking_no'].'</span><span class="cus_name">'.$bookings['customer_name'].'</span><span class="cus_tel">'.$bookings['telephone'].'/'.$bookings['mobile'].'</span><span class="cus_add">'.$bookings['address'].'</span></div>';
           
	if(isset($bookings['booking_no']))
	{
  	        $tlist =  TourMakingDetails::model()->propertylist($bookings['booking_no']);
			$cost =  TourMakingDetails::model()->totalbudget($bookings['booking_no']);
			
			foreach ($tlist as $value) 
		   { 
		   $status='<div class="wiitem staus">Pending<img src="images/ajax-loader2.gif" /></div>';
		   if($value['status']==2)
		   {
			   $status='<div class="wiitem staus ver">Verified</div>';
		   }
			   
	  else if($value['status']==1)
		   {
			   $status='<div class="wiitem staus na">Not Available</div>';
		   }
		   
	      echo  ' <div class="witems">'.$status;
	     echo '<div class="price">'.number_format($value['cost'], 2, '.', '').'</div>';		  
         echo '<div class="wiitem">'.'<span>Adults</span>'.$value['adults'].'<br>'.'<span>Children</span>'.$value['children'].'</div>';
	   	 echo '<div class="wiitem">'.'<span>Check In</span>'.$value['check_in'].'<br>'.'<span>Check Out</span>'.$value['check_out'].'</div>';
		 echo '<div class="prname">'.$value['property_name'].'<br><span class="address">'.$value['address'].'</span></div></div>';
	  }

		   echo '<div class="witems total"><div class="pricet">'.number_format($cost[0]['cost'], 2, '.', '').'</div><div class="tcost">Total Budget</div></div>';
	}
	else
	{
		
		   echo '<div class="witems total">Please make your tour as wish </div>';
	}
		}
      ?>
          </div>
        </div>
        
        
      </div>
    	

  </div>
</div>
