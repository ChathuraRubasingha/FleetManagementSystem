<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$id=$_POST['id'];
$firstname=$_POST['firstname'];
$secondname=$_POST['secondname'];
$dob=$_POST['dob'];
$address=$_POST['address'];
$grade=$_POST['grade'];

$con=msql_connect("localhost","root","") or die("Can't connected");
$db=mysql_select_db("abc_school",$con) or die("Can't connected to database");
$valu=mysql_query("SELECT * FROM register");
$val=mysql_query("INSERT INTO register (id,firstname,secondname,dob,address,grade) VALUES('$id','$firstname','$secondname','$dob','$address','$grade')");

if(!$row=mysql_fetch_array($val,$con))
{
	die('ERROR'.mysql_error());
	}
	echo"one recorde added";

?>
</body>
</html>