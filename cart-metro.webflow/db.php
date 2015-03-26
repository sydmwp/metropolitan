<?php
$con=mysqli_connect("localhost","sydmw721_admin","1914CE","sydmw721_sydmwp");
if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
date_default_timezone_set('Australia/Sydney');
?>