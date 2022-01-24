 <?php
	$this->breadcrumbs=array(
	'Vehicle Registry'=>array('maVehicleRegistry/requestService'),	
	'Request Vehical Service',
	);
?>
 
 <script language="javascript">
	function printDiv(divName)
	 {
     	var printContents = document.getElementById(divName).innerHTML;
     	var originalContents = document.body.innerHTML;

     	document.body.innerHTML = printContents;

     	window.print();

     	document.body.innerHTML = originalContents;
	}
</script>
<style type='text/css'>
.td {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	}
.topic {
	font-size: 20px;
	font-style: normal;
	line-height: normal;
	font-weight: bold;
	font-variant: normal;
	text-transform: capitalize;
	
	}
.topic11 {
	font-size: 16px;
	font-style: normal;
	line-height: normal;
	font-weight: bold;
	font-variant: normal;
	text-transform: capitalize;
	
	}
</style>
	<div  class='group' style='padding-left:50px;  margin-left:30%;'>
    <div align="center"><h1>Request Tyre Tube Change Form</h1></div>
	<img src='images/print.jpg' onclick="printDiv('form01')"  />
<?php	

  $vehicleID = Yii::app()->request->getQuery('id');
		//echo  $vehicleID;
		//exit;
		$list=MaVehicleRegistry::model()->getnewTyreTube($vehicleID);
    	$VehicleNo=$list[0]['Vehicle_No'];
	    $quantity=$list[0]['Tyre_quantity'];
		
		$date=$list[0]['Max(tyre_details.Replace_Date)'];
		if ($date>=1)
		{
		$dates=$list[0]['Max(tyre_details.Replace_Date)'];
		}
		else 
		{
			$dates='No';
		}
//	     echo $Service_Station_ID;exit;
        $driver=$list[0]['Full_Name'];
		
		$LastOdd=$list[0]['Max(tyre_details.Meter_Reading)'];
		if ($LastOdd>=1)
		{
		$LastOdds=$list[0]['Max(tyre_details.Meter_Reading)'];
		}
		else 
		{
			$LastOdds='No';
		}
		$odmeter=$list[0]['odometer'];
		$Distance=$list[0]['(ma_vehicle_registry.odometer - Max(tyre_details.Meter_Reading))'];
		if ($Distance>=1)
		{
			$Distances=$Distance=$list[0]['(ma_vehicle_registry.odometer - Max(tyre_details.Meter_Reading))'];
		}
		else
		{
			$Distances=$odmeter=$list[0]['odometer'];
		}



               echo"<div id='form01'>";

               echo "<table width='900' border='0' align='center'>
  <tr>
    <td colspan='2'>රාජ්‍ය පරිපාලන සහ ස්වදේශ කටයුතු අමාත්‍යංශය - කාර්යය සංග්‍රහය </td>
  </tr>
  <tr>
    <td colspan='2' align='right'>IAD/TR 08</td>
  </tr>
  <tr>
    <td colspan='2' style='text-align:center;'><U>රාජ්‍ය පරිපාලන සහ ස්වදේශ කටයුතු අමාත්‍යංශයේ ටයර් හා ටියුබ් මාරු කිරීම සඳහා අයදුම්පත්‍රය </U></td>
  </tr>
  <tr>
  <td/>
  </tr>
  <tr>
    <td height='40'>01. 
    වාහනයේ අංකය</td>
    <td height='40'>:- ".$VehicleNo." </td>
  </tr>
  <tr>
    <td width='300' height='32'>02.
    වාහනයේ ටයර් ටියුබ් කලින් මාරු කරන ලද දිනය </td>
    <td width='452'>:- ".$dates." </td>
  </tr>
  <tr>
  
    <td height='39'>03. 
    ටයර් මාරු කරන දිනයේ මයිලෝ මීටරය</td>
    <td height='39'>:- ".$LastOdds." </td>
  </tr>
  <tr>
    <td height='30'>04. 
    දැනට පවතින මයිලෝ මීටරය </td>
    <td height='30'>:- ".$odmeter." </td>
  </tr>
  <tr>
    <td height='38'>05. ධාවනය කර ඇති කිලෝමීටර් ගණන</td>
    <td height='38'>:- ".$Distances." </td>
  </tr>
  <tr>
    <td><br>
    06. 
     අවශ්‍ය ටයර් හා ටියුබ් ගණන     <br></td>
    <td>:- ".$quantity."</td>
  </tr>
  <tr>
    <td colspan='2'><table width='800' border='0' align='center'>
      <tr>
        <td>රියදුරුගේ නම 
          :- ".$driver."</td>
        <td>අත්සන 
          : ....................................................</td>
      </tr>
      <tr>
        <td colspan='2'>මාණ්ඩලික නිලධාරියාගේ නිර්දේශය 
          : ..................................................................................</td>
        </tr>
      <tr>
        <td colspan='2'>මාණ්ඩලික නිලධාරියාගේ 
          නම 
          : ..................................................................................</td>
        </tr>
      <tr>
        <td>අත්සන : ........................................</td>
        <td>දිනය : ....................................................</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan='2'><table width='750' border='0'>
      <tr>
        <td colspan='2'><br>
          ඉහත සඳහන් විස්තර ලොග් පොතට අනුව නිවැරදිය. ටයර් .......... ක් හා ටියුබ් ............ සැපයීම නිර්දේශ කරමි.
          ..................................</td>
        </tr>
      <tr>
        <td width='356'>දිනය : ................................</td>
        <td width='383'> : ...........................................</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan='2'><table width='750' border='0'>
      <tr>
        <td colspan='2'>ටයර් ................ ක් හා ටියුබ් ............... ක් සැපයීමට මිල ගණන් කැඳවා අවශ්‍ය කටයුතු කරන්න.<br /></td>
        </tr>
      <tr>
        <td width='353' rowspan='2' valign='bottom'>දිනය : ........................</td>
        <td width='384'>.................................................</td>
      </tr>
      <tr>
        <td>ස.ලේ /ජෙ .ස.ලේ</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan='2'><table width='750' border='0'>
      <tr>
        <td colspan='2'><br />
          ටයර් ................ ක් හා ටියුබ්   ............... ක් ......................... ආයතනයෙන්   ................................... මුදලකට ලබා ගැනීම අනුමත කරමි.</td>
        </tr>
      <tr>
        <td width='351' rowspan='2' valign='bottom'>දිනය : .............................................</td>
        <td width='384'>...................................</td>
      </tr>
      <tr>
        <td>ස.ලේ/ ජෙ.ස.ලේ </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan='2'><table width='892' border='0'>
      <tr>
        <td colspan='2'><br />
          දින ටයර් ටියුබ් මාරු කරන ලදී. ටයර් ................. ක් හා ටියුබ්   .................. ක් ප්‍රවාහන නිලධාරී වෙත භාර දුනිමි.</td>
        </tr>
      <tr>
        <td width='305'>දිනය : ..................................</td>
        <td width='571'>රියදුරුගේ අත්සන : ............................................</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan='2'><table width='750' border='0'>
      <tr>
        <td colspan='2'><br />
          භාරගත් බවට සහතික කරමි.</td>
        </tr>
      <tr>
        <td>දිනය : ..........................</td>
        <td>ප්‍රවාහන නිලධාරී 
          ........................................</td>
      </tr>
    </table></td>
  </tr>
</table>";
	echo "</div>";		
?>
</div>