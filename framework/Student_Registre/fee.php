<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

$id=$_POST['id'];
$registration_fee=$_POST['registration_fee'];
$first_term_fee=$_POST['first_term_fee'];
$second_term_fee=$_POST['second_term_fee'];
$last_term_fee=$_POST['last_term_fee'];

$com=mysql_connect("localhost","root","") or die ("can't connected");
$db=mysql_select_db("abc_school",$com) or die ("can't connected to database");

$val=mysql_query(SELECT * fee);

$valu=mysql_query("INSERT INTO fee(id,registration_fee,first_term_fee,second_term_fee,last_term_fee)
						VALUES ('$id','$registration_fee','$first_term_fee','$last_term_fee')");

if(!$row=mysql_fetch_array($valu,$com))
{
	die("ERROR" . mysql_error());
	}
	echo"one record added";
	
?>



</body>
</html>