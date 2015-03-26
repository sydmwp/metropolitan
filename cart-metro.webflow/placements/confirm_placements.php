<!DOCTYPE html>
<!-- Last Published: Fri Mar 20 2015 07:17:45 GMT+0000 (UTC) -->
<html data-wf-site="5501f5af8d5d8d533f7660e8" data-wf-page="550b61c9afd603c85d5dc3ab">
<head>
<?php
require('../db.php');
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));
$day = date('d/m/Y',(strtotime($date)));
$location = $_POST['location'];
$time = $_POST['time'];
$books = $_POST['books'];
$magazines = $_POST['magazines'];
$brochures = $_POST['brochures'];
$comments = $_POST['comments'];
$result_location = mysqli_query($con,"SELECT * FROM locations WHERE name = '$location'");
while($row = mysqli_fetch_array($result_location))
	{
	$location_id = $row['id'];
	}
$result_shift = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND time = '$time' AND location_id = '$location_id' AND recorded != 'Y'");
while($row = mysqli_fetch_array($result_shift))
	{
	$shift_id = $row['id'];
	$shift_confirmed = $row['confirmed'];
	$shift_recorded = $row['recorded'];
	}
echo '
  <title>'.$location.', '.$day.', '.$time.'</title>
  ';
include('../head.php');
?>
</head>
<?php
if($shift_id && $shift_confirmed && !$shift_recorded)
	{
	$sql = "UPDATE shifts SET books = '$books', magazines = '$magazines', brochures = '$brochures', recorded = 'Y', comments = '$comments' WHERE id = '$shift_id'";
	if (!mysqli_query($con,$sql))
		{
		die('Error: ' . mysqli_error($con));
		}
?>
<body class="confirmed-placements">
<?php
include('../menu.php');
?>
  <div class="confirmed-tick" data-ix="confirmed">
    <div><i class="fa fa-check"></i></div>
  </div>
  <div class="thankyou">
    <div>Thank you.</div>
  </div>
  <div class="placements-entered">
    <div>Your placements have been reported.</div>
  </div>
  <?php 
include('../foot.php');
?>
</body>
<?php
	}
else
	{
?>
<body class="sorry-not-found">
<?php
include('../menu.php');
?>
  <div class="face" data-ix="confirmed">
    <div><i class="fa fa-frown-o"></i></div>
  </div>
  <div class="content-sorry">
    <div>Sorry, that shift could not be found. Please check the details you entered and try again. If your details are definitely correct, we're obviously experiencing some difficulties. Please <span class="email-text"><a class="email-text" href="mailto:support@sydmwp.com?subject=Shift%20could%20not%20be%20found">EMAIL US</a> </span>to let us know.</div>
  </div>
<?php 
include('../foot.php');
?>
</body>
<?php
	}
?>
</html>