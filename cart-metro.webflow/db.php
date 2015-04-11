<?php
$con=mysqli_connect("localhost","sydmw721_admin","1914CE","sydmw721_sydmwp");
if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
include('queries.php');
date_default_timezone_set('Australia/Sydney');
$user = $_COOKIE['login'];
$stmt = $con->prepare($pioneer_select);
$stmt->bind_param('i', $user);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $gender, $phone);
$stmt->fetch();
$stmt->close();
if (!$user)
	{
	header("Location:http://sydmwp.com/test/login.php");
	exit();
	}
?>