<?php
require('../db.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php
$location_id = $_POST['location_id'];
$stmt = $con->prepare($location_select);
	$stmt->bind_param('i', $location_id);
	$stmt->execute();
	$stmt->bind_result($location);
	$stmt->fetch();
$stmt->close();
$date = $_POST['date'];
$day = date('d/m/Y',(strtotime($date)));
$time = $_POST['time'];
echo '
  <title>'.$location.', '.$day.', '.$time.'</title>
  ';
include('../head.php');
?>
</head>
<?php
if ($user)
{	
	$double_up = 0;
	$stmt = $con->prepare($shift_date_select);
		$stmt->bind_param('s', $date);
		$stmt->execute();
		$stmt->bind_result($overseer_check, $pioneer_check, $pioneer_b_check);
		while ($stmt->fetch())
			{
			if ($overseer_check == $user || $pioneer_check == $user || $pioneer_b_check == $user)
				{
				++$double_up;
				}
			}
	$stmt->close();
	if ($double_up == 0)
		{
?>
<body>
<?php
include('../menu.php');
?>
  <div class="content-confirm">
	<div class="confirm-content">
<?php
echo '
		<div>'.$first_name.' '.$last_name.'</div>
		';
?>
      <div class="small-text">You are about to volunteer for the following shift</div>
    </div>
    <div class="location">
      <div><i class="fa fa-location-arrow"></i>&nbsp;&nbsp;&nbsp;<?php echo $location; ?></div>
    </div>
    <div class="date">
      <div><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;<?php echo $day; ?></div>
    </div>
    <div class="time">
      <div><i class="fa fa-clock-o"></i>&nbsp;&nbsp;&nbsp;<?php echo $time; ?></div>
    </div>
<?php
if ($location_id == 2)
	{
	echo '
	<div class="map"></div>
		';
	}
if ($location_id == 3)
	{
	echo '
    <div class="map _2"></div>
		';
	}
?>
<?php
$spaces_filled = 0;
$stmt = $con->prepare($shift_record_select);
	$stmt->bind_param('sis', $date, $location_id, $time);
	$stmt->execute();
	$stmt->bind_result($i, $overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
	$stmt->close();
	if ($overseer_id)
		{
		++$spaces_filled;
		$existing = "y";
		}
	if ($pioneer_id)
		{
		++$spaces_filled;
		$existing = "y";
		}
	if ($pioneer_b_id)
		{
		++$spaces_filled;
		$existing = "y";
		}
if ($spaces_filled == 0)
	{
?>
    <div class="confirm-content add-content">
      <div>If you would like to add other pioneers to this shift, please enter their mobile numbers below. <span class="add-mobile-special-text">Only add other pioneers if you have already made an arrangement with them.</span>
      </div>
    </div>
    <div class="w-form form-confirm">
      <form id="email-form" name="email-form" action="confirm_shift.php" method="post">
<?php
echo '
		<input type="hidden" name="location_id" value="'.$location_id.'">
		<input type="hidden" name="date" value="'.$date.'">
		<input type="hidden" name="time" value="'.$time.'">
		';
?>
        <input class="w-input add-pioneer square" id="add-pioneer" type="tel" placeholder="Add pioneer mobile number " name="phone_a">
        <input class="w-input add-pioneer square" id="add-pioneer-2" type="tel" placeholder="Add pioneer mobile number " name="phone_b">
        <input class="w-button submit-mobile-number square" type="submit" value="Proceed">
      </form>
    </div>
<?php
	}
elseif ($spaces_filled == 1)
	{
?>
    <div class="confirm-content add-content">
      <div>If you would like to add another pioneer to this shift, please enter their mobile number below. <span class="add-mobile-special-text">Only add other pioneers if you have already made an arrangement with them.</span>
      </div>
    </div>
    <div class="w-form form-confirm">
      <form id="email-form" name="email-form" action="confirm_shift.php" method="post">
<?php
echo '
		<input type="hidden" name="location_id" value="'.$location_id.'">
		<input type="hidden" name="date" value="'.$date.'">
		<input type="hidden" name="time" value="'.$time.'">
		<input type="hidden" name="existing" value="'.$existing.'">
		';
if ($overseer_id)
	{
	echo '
		<input type="hidden" name="overseer_id" value="'.$overseer_id.'">
		';
	}
if ($pioneer_id)
	{
	echo '
		<input type="hidden" name="pioneer_id" value="'.$pioneer_id.'">
		';
	}
if ($pioneer_b_id)
	{
	echo '
		<input type="hidden" name="pioneer_b_id" value="'.$pioneer_b_id.'">
		';
	}
?>
        <input class="w-input add-pioneer square" id="add-pioneer" type="tel" placeholder="Add pioneer mobile number " name="phone_b">
        <input class="w-button submit-mobile-number square" type="submit" value="Proceed">
      </form>
    </div>		
<?php		
	}
else
	{
?>
    <div class="w-form form-confirm">
      <form id="email-form" name="email-form" action="confirm_shift.php" method="post">
<?php
echo '
		<input type="hidden" name="location_id" value="'.$location_id.'">
		<input type="hidden" name="date" value="'.$date.'">
		<input type="hidden" name="time" value="'.$time.'">
		<input type="hidden" name="existing" value="'.$existing.'">
		';
if ($overseer_id)
	{
	echo '
		<input type="hidden" name="overseer_id" value="'.$overseer_id.'">
		';
	}
if ($pioneer_id)
	{
	echo '
		<input type="hidden" name="pioneer_id" value="'.$pioneer_id.'">
		';
	}
if ($pioneer_b_id)
	{
	echo '
		<input type="hidden" name="pioneer_b_id" value="'.$pioneer_b_id.'">
		';
	}
?>
        <input class="w-button submit-mobile-number square" type="submit" value="Proceed">
      </form>
    </div>		
<?php		
		}
	
?>
	</div>
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
    <div>You are already booked in a conflicting shift.
      <br>Please try another shift at a different time.</div>
  </div>
</body>
<?php
		}
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
    <div>Your number is not on file.
      <br>Please <span class="email-text"><a class="email-text" href="mailto:support@sydmwp.com?subject=Number%20not%20on%20file">EMAIL US</a> </span>to let us know.</div>
  </div>
</body>
  
<?php
	}
?>
</html>