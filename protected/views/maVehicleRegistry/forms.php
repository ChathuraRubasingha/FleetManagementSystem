 <?php
	$this->breadcrumbs=array(
	'Vehicle Registry'=>array('maVehicleRegistry/newTyreTube'),	
	
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
<style type="text/css">
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

	<div  class="group" style="padding-left:50px; margin-left:30%;">
    	<div align="center"><h1>Request Vehicle Service Form</h1></div>
	<img src="images/print.jpg" onclick="printDiv('forms')"  />
<?php	
    	$vehicleID = Yii::app()->request->getQuery('id');
		//echo $estimateID;
		//exit;
		$list=MaVehicleRegistry::model()->getRequestservice($vehicleID);
    	$VehicleNo=$list[0]['Vehicle_No'];
	    $Service_Station_ID=$list[0]['Srvice_Station_Name'];
		
	    // echo $Service_Station_ID;exit;
		$date=$list[0]['Max(services.Service_Date)'];
		if($date>=1)
			{
			 $dates=$list[0]['Max(services.Service_Date)'];
			}
		else
			{
			  $dates='No';
			}
		$LastOdd=$list[0]['Meter_Reading'];
		if($LastOdd>=1)
			{
			 $LastOdds=$odometer=$LastOdd=$list[0]['Meter_Reading'];
			}
		else
			{
			  $LastOdds='No';
			}
		$odometer=$list[0]['odometer'];
		$Distance=$list[0]['(ma_vehicle_registry.odometer - services.Meter_Reading)'];
		
	
	
	echo"<div id='forms'>";
	echo "<table width='900' border='1' align='center'>
			 <tr>
			<td colspan='2' rowspan='2'><table width='689' border='1'>
			  <tr>
				<td width='665' align='left'>රාජ්‍ය පරිපාලන සහ ස්වදේශ කටයුතු අමාත්‍යංශය කාර්යය සංග්‍රහය </td>
			  </tr>
			  <tr>
				<td height='37' align='center'><b><u>වාහන සේවා කිරීමේ ඉල්ලුම් පත්‍රය</u></b></td>
			  </tr>
			</table></td>
			<td width='195' height='39'>&nbsp;</td>
		  </tr>
		  <tr>
			<td align='right'><b>IAD/TR 02</b></td>
		  </tr>
		  <tr>
			<td width='500'><table width='605' border='1'>
			  <tr>
				<td width='440'>01. වාහනයේ අංකය</td>
				<td width='11'>:-</td>
				<td width='252'>".$VehicleNo."</td>
			  </tr>
			  <tr>
				<td>02. මෙයට පෙර සේවා කල දිනය </td>
				<td>:-</td>
				<td>".$dates."</td>
			  </tr>
			  <tr>
				<td>03. එදිනට මයිලෝ මීටරය කියවීම </td>
				<td>:-</td>
				<td>".$LastOdds."</td>
			  </tr>
			  <tr>
				<td>04. අද දිනට මයිලෝ මීටරය කියවීම </td>
				<td>:-</td>
				<td>".$odometer."</td>
			  </tr>
			  <tr>
				<td>05. ධාවනය කර ඇති කි.මීටර ගණන</td>
				<td>:-</td>
				<td>".$Distance."</td>
			  </tr>
			  <tr>
				<td>06. කලින් වතාවේ සේවා කල ස්ථානයේ නම </td>
				<td>:-</td>
				<td>".$Service_Station_ID."</td>
			  </tr>
			  <tr>
				<td height='32'>07. අවසන් වරට ඔයිල් ෆිල්ටරය මාරුකල දිනය </td>
				<td>:-</td>
				<td>".$date."</td>
			  </tr>
			</table></td>
			<td colspan='2'>&nbsp;</td>
		  </tr>
		  <tr>
			<td height='43' colspan='3'><table width='800' border='1'>
			  <tr>
				<td>දිනය : ...........................................</td>
				<td align='right'>රියදුරාගේ නම / අත්සන :- .........................................</td>
			  </tr>
			</table></td>
		  </tr>
		  <tr>
			<td colspan='3'><table width='900' border='1'>
			  <tr>
				<td width='900'><b>වාහනය භාර මාණ්ඩලික නිලධාරියාගේ නිර්දේශය</b></td>
			  </tr>
			  <tr>
				<td>.................................................................................... අංක දරණ රථය සේවා කිරීම නිර්දේශ කරමි.</td>
			  </tr>
			  <tr>
				<td align='right'>...................................................<br>
				  මාණ්ඩලික නිලධාරියාගේ අත්සන</td>
			  </tr>
			</table></td>
		  </tr>
		  <tr>
			<td colspan='3'><table width='900' border='1'>
			  <tr>
				<td colspan='2'>සහාකාර ලේකම් (පාලන)<br>
				  පරිපාලන නිලධාරි (පාලන) මගින්</td>
				</tr>
			  <tr>
				<td colspan='2'>අංක දරණ රථයේ ලොග් පොතට සහ ගොනු අංක .......................... අනුව ඉහත තොරතුරු නිවැරදිය. පහත සඳහන් අයිතම ද්‍රව්‍ය පමණක් යොදා සේවා කිරීම සුදුසුය.</td>
				</tr>
			  <tr>
				<td>01.............................................................<br>
				  නිර්දේශ කරමි/නොකරමි<br>
				  ......................................<br>
				  පරිපාලන නිලධාරි (පාලන)</td>
				<td align='right'>03................................................................................<br>
				  ප්‍රවාහන අංශ  ප්‍රධානිගේ අත්සන ..................................<br>
				  නම    :- .........................................................<br>
				  දිනය :- ................................<br>
				  </td>
			  </tr>
			  <tr>
				<td colspan='2'><table width='900' border='1'>
				  <tr>
					<td>පරිපාලන නිලධාරි (පාලන) මගින්<br>
					  අංශ ප්‍රධානි ප්‍රවාහන අංශය</td>
					</tr>
				  <tr>
					<td>           ......................................................................................................................... ආයතනයේ සේවා කිරීම සිදු කරවන්න.</td>
					</tr>
				  <tr>
					<td>අයිතම අංක ........................................................................ සිට ................................................................................පමණක් යෙදීම් අනුමත කරමි.</td>
					</tr>
				  <tr>
					<td align='right'>.............................................<br>
					  සහකාර ලේකම් (පාලන)</td>
					</tr>
				  </table></td>
			  </tr>
			</table></td>
		  </tr>
		</table>
		";
		echo "</div>";				
						
		?>
		</div>
