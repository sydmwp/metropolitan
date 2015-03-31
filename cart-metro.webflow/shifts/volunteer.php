<!DOCTYPE html>
<html>
<head>
<?php
require('../db.php');
$location_id = $_POST['location_id'];
$location_name = mysqli_query($con,"SELECT * FROM locations WHERE id = '$location_id'");
while ($row = mysqli_fetch_array($location_name))
	{
	$location = $row[name];
	}
$date = $_POST['date'];
$day = date('d F Y',(strtotime($date)));
$time = $_POST['time'];
echo '
  <title>'.$location.', '.$day.', '.$time.'</title>
  ';
include('../head.php');
?>
</head>
<body>
<?php
include('../menu.php');
?>
  <div class="content-mobile-number">
    <div class="shifts-content">
      <div class="w-form">
        <form id="email-form" name="email-form" action="confirm_volunteer.php" method="post">
<?php
echo '
			<input type="hidden" name="location_id" value="'.$location_id.'">
			<input type="hidden" name="date" value="'.$date.'">
			<input type="hidden" name="time" value="'.$time.'">
			<input class="w-input mobile-text-filled square" id="Mobile-number" type="tel" placeholder="Enter your mobile number" name="phone" required="required">
			<input class="w-button submit-mobile-number square" type="submit" value="Proceed">
	';
?>
		</form>
      </div>
    </div>
  </div>
</body>
</html>