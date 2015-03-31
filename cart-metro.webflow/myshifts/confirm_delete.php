<!DOCTYPE html>
<html>
<head>
<?php
require('../db.php');
$volunteer_id = $_POST['volunteer_id'];
$overseer_id = $_POST['overseer_id'];
$pioneer_id = $_POST['pioneer_id'];
$pioneer_b_id = $_POST['pioneer_b_id'];
$shift_id = $_POST['shift_id'];
if ($overseer_id)
	{
	$empty_check = mysqli_query($con,"SELECT * FROM shifts WHERE id = '$shift_id'");
	while ($row = mysqli_fetch_array($empty_check))
		{
		$pioneer_id = $row[pioneer_id];
		$pioneer_b_id = $row[pioneer_b_id];
		}
	if (!$pioneer_id AND !$pioneer_b_id)
		{
		$sql = "DELETE FROM shifts WHERE id = '$shift_id'";
		if (!mysqli_query($con,$sql))
			{
			die('Error: ' . mysqli_error($con));
			}
		}
	else
		{
		$sql = "UPDATE shifts SET overseer_id = null WHERE id = '$shift_id'";
		if (!mysqli_query($con,$sql))
			{
			die('Error: ' . mysqli_error($con));
			}
		}
	}
elseif ($pioneer_id)
	{
	$empty_check = mysqli_query($con,"SELECT * FROM shifts WHERE id = '$shift_id'");
	while ($row = mysqli_fetch_array($empty_check))
		{
		$overseer_id = $row[overseer_id];
		$pioneer_b_id = $row[pioneer_b_id];
		}
	if (!$overseer_id AND !$pioneer_b_id)
		{
		$sql = "DELETE FROM shifts WHERE id = '$shift_id'";
		if (!mysqli_query($con,$sql))
			{
			die('Error: ' . mysqli_error($con));
			}
		}
	else
		{
		$sql = "UPDATE shifts SET pioneer_id = null WHERE id = '$shift_id'";
		if (!mysqli_query($con,$sql))
			{
			die('Error: ' . mysqli_error($con));
			}
		}
	}
elseif ($pioneer_b_id)
	{
	$empty_check = mysqli_query($con,"SELECT * FROM shifts WHERE id = '$shift_id'");
	while ($row = mysqli_fetch_array($empty_check))
		{
		$overseer_id = $row[overseer_id];
		$pioneer_id = $row[pioneer_id];
		}
	if (!$overseer_id AND !$pioneer_id)
		{
		$sql = "DELETE FROM shifts WHERE id = '$shift_id'";
		if (!mysqli_query($con,$sql))
			{
			die('Error: ' . mysqli_error($con));
			}
		}
	else
		{
		$sql = "UPDATE shifts SET pioneer_b_id = null WHERE id = '$shift_id'";
		if (!mysqli_query($con,$sql))
			{
			die('Error: ' . mysqli_error($con));
			}
		}
	}
echo '
	<title>Shift updated</title>
	';
include('../head.php');
?>
</head>
<body class="confirmed-placements">
<?php
include('../menu.php');
?>
  <div class="confirmed-tick" data-ix="confirmed">
    <div><i class="fa fa-check"></i></div>
  </div>
  <div class="thankyou">
    <div>Thank you</div>
  </div>
  <div class="placements-entered">
    <div>The shift has been updated</div>
  </div>
  <div class="back-to-my-shifts-div">
    <div class="w-form">
      <form id="email-form" name="email-form" data-name="Email Form" action="calendar.php" method="post">
<?php
echo '
		<input type="hidden" name="volunteer_id" value="'.$volunteer_id.'">
	';
?>
        <input class="w-button back-to-my-shifts-button" type="submit" value="Back to my shifts">
      </form>
    </div>
  </div>
</body>
</html>