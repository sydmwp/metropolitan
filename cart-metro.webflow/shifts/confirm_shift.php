<!DOCTYPE html>
<html>
<head>
<?php
require('../db.php');
$location_id = $_POST['location_id'];
$location_search = mysqli_query($con,"SELECT * FROM locations WHERE id = '$location_id'");
while ($row = mysqli_fetch_array($location_search))
	{
	$location = strtoupper($row[name]);
	}
$date = $_POST['date'];
$day = date('d/m/Y',(strtotime($date)));
$time = $_POST['time'];
$existing = $_POST['existing'];
$volunteer_id = $_POST['volunteer_id'];
$volunteer = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$volunteer_id'");
while ($row = mysqli_fetch_array($volunteer))
	{
	$volunteer_gender = $row[gender];
	}
$overseer_id = $_POST['overseer_id'];
$pioneer_id = $_POST['pioneer_id'];
$pioneer_b_id = $_POST['pioneer_b_id'];
$phone_a = $_POST['phone_a'];
$phone_a = str_replace('+61', '0', $phone_a);
$phone_a = str_replace(' ', '', $phone_a);
$phone_b = $_POST['phone_b'];
$phone_b = str_replace('+61', '0', $phone_b);
$phone_b = str_replace(' ', '', $phone_b);
echo '
  <title>'.$location.', '.$day.', '.$time.'</title>
  ';
include('../head.php');
?>
</head>
<?php
if ($phone_a)
	{
	$pioneer_a = mysqli_query($con,"SELECT * FROM pioneers WHERE phone = '$phone_a'");
	while ($row = mysqli_fetch_array($pioneer_a))
		{
		$pioneer_id = $row[id];
		$gender_a = $row[gender];
		}
	}
if ($phone_b)
	{
	$pioneer_b = mysqli_query($con,"SELECT * FROM pioneers WHERE phone = '$phone_b'");
	while ($row = mysqli_fetch_array($pioneer_b))
		{
		$pioneer_b_id = $row[id];
		$gender_b = $row[gender];
		}
	}
if (($phone_a AND !$gender_a) || ($phone_b AND !$gender_b))
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
    <div>A number is not on file.
      <br>Please <span class="email-text"><a class="email-text" href="mailto:support@sydmwp.com?subject=Number%20not%20on%20file">EMAIL US</a> </span>to let us know.</div>
  </div>
</body>
<?php
	die;
	}

if (!$overseer_id)	
	{
	if ($volunteer_gender == "m")
		{
		$overseer_id = $volunteer_id;
		$volunteer_id = null;
		}
	elseif ($volunteer_gender == "f")
		{
		if ($gender_a =="m")
			{
			$overseer_id = $pioneer_id;
			$pioneer_id = $volunteer_id;
			$volunteer_id = null;
			}
		elseif ($gender_b =="m")
			{
			$overseer_id = $pioneer_b_id;
			$pioneer_b_id = $volunteer_id;
			$volunteer_id = null;
			}
		if (!$pioneer_id)
			{
			$pioneer_id = $volunteer_id;
			$volunteer_id = null;
			}
		elseif (!$pioneer_b_id)
			{
			$pioneer_b_id = $volunteer_id;
			$volunteer_id = null;
			}
		}
	if ($volunteer_id)
		{
		$status = "invalid";
		}
	}
elseif ($overseer_id)
	{
	if (!$pioneer_id)
			{
			$pioneer_id = $volunteer_id;
			$volunteer_id = null;
			}
		elseif (!$pioneer_b_id)
			{
			$pioneer_b_id = $volunteer_id;
			$volunteer_id = null;
			}
	}
if ($overseer_id && $pioneer_id && $pioneer_b_id)
	{
	$confirmed = "y";
	$full = "y";
	}
if ($pioneer_b_id && !$pioneer_id)
	{
	$pioneer_id = $pioneer_b_id;
	$pioneer_b_id = null;
	}
if ($overseer_id)
	{
	if ($pioneer_id && !$pioneer_b_id)
		{
		$brother_check = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id'");
		while ($row = mysqli_fetch_array($brother_check))
			{
			$gender = $row[gender];
			}
		if ($gender == "f")
			{
			$couple_check = mysqli_query($con,"SELECT * FROM couples WHERE brother_id = '$overseer_id' AND sister_id = '$pioneer_id'");
			while ($row = mysqli_fetch_array($couple_check))
				{
				$couple_id = $row[id];
				}
			if ($couple_id)
				{
				$confirmed = "y";
				}
			}
		else
			{
			$confirmed = "y";
			}
		}
	}
$overseer_details = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id'");
while ($row = mysqli_fetch_array($overseer_details))
	{
	$overseer_name = "{$row['first_name']} {$row['last_name']}";
	$overseer_phone = $row[phone];
	}
$pioneer_details = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id'");
while ($row = mysqli_fetch_array($pioneer_details))
	{
	$pioneer_name = "{$row['first_name']} {$row['last_name']}";
	$pioneer_phone = $row[phone];
	}
$pioneer_b_details = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id'");
while ($row = mysqli_fetch_array($pioneer_b_details))
	{
	$pioneer_b_name = "{$row['first_name']} {$row['last_name']}";
	$pioneer_b_phone = $row[phone];
	}
if (!$existing)
	{
	$sql = "INSERT INTO `sydmw721_sydmwp`.`shifts` (`id`, `location_id`, `date`, `time`, `overseer_id`, `pioneer_id`, `pioneer_b_id`, `confirmed`, `full`) VALUES (NULL, '$location_id', '$date', '$time', '$overseer_id', '$pioneer_id', '$pioneer_b_id', '$confirmed', '$full')";
	if (!mysqli_query($con,$sql))
		{
		die('Error: ' . mysqli_error($con));
		}
	}
else
	{
	$result_shift = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND time = '$time' AND location_id = '$location_id'");
	while($row = mysqli_fetch_array($result_shift))
		{
		$shift_id = $row['id'];
		}
	$sql = "UPDATE `sydmw721_sydmwp`.`shifts` SET `overseer_id` = '$overseer_id', `pioneer_id` = '$pioneer_id', `pioneer_b_id` = '$pioneer_b_id', `full` = '$full', `confirmed` = '$confirmed' WHERE `shifts`.`id` = '$shift_id'";
	if (!mysqli_query($con,$sql))
		{
		die('Error: ' . mysqli_error($con));
		}
	}

if ($status !== 'invalid')
	{
?>
<body>
<?php
include('../menu.php');
?>
  <div class="content-confirm">
    <div class="confirm-content thankyou">
      <div><span class="tick"><i class="fa fa-check"></i></span>
        <br>Thank you. Your shift has been entered</div>
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
  </div>
  <div class="overseer">
    <div class="w-row">
      <div class="w-col w-col-4 w-col-small-4">
        <div>Overseer</div>
      </div>
      <div class="w-col w-col-4 w-col-small-4">
        <div>
<?php
	if ($overseer_name)
		{
		echo $overseer_name;
		}
?>
		</div>
      </div>
      <div class="w-col w-col-4 w-col-small-4">
        <div>
<?php
	if ($overseer_phone)
		{
		echo $overseer_phone;
		}
?>
		</div>
      </div>
    </div>
  </div>
  <div class="overseer pioneer">
    <div class="w-row">
      <div class="w-col w-col-4 w-col-small-4">
        <div>Pioneer</div>
      </div>
      <div class="w-col w-col-4 w-col-small-4">
        <div>
<?php
	if ($pioneer_name)
		{
		echo $pioneer_name;
		}
?>
		</div>
      </div>
      <div class="w-col w-col-4 w-col-small-4">
        <div>
<?php
	if ($pioneer_phone)
		{
		echo $pioneer_phone;
		}
?>
		</div>
      </div>
    </div>
  </div>
  <div class="overseer pioneer">
    <div class="w-row">
      <div class="w-col w-col-4 w-col-small-4">
        <div>Pioneer</div>
      </div>
      <div class="w-col w-col-4 w-col-small-4">
        <div>
<?php
	if ($pioneer_b_name)
		{
		echo $pioneer_b_name;
		}
?>
		</div>
      </div>
      <div class="w-col w-col-4 w-col-small-4">
        <div>
<?php
	if ($pioneer_b_phone)
		{
		echo $pioneer_b_phone;
		}
?>
		</div>
      </div>
    </div>
  </div>
<?php
	if ($confirmed == "y")
		{
		echo '
	  <div class="confirmed-unconfirmed">
		<div>SHIFT STATUS – CONFIRMED</div>
	  </div>
		';
		}
	else
		{
?>
  <div class="confirmed-unconfirmed unconfirmed">
    <div>SHIFT STATUS – UNCONFIRMED</div>
  </div>
  <div class="confirmed-unconfirmed others-needed">
    <div>Your shift needs other volunteers before it is confirmed.</div>
  </div>
<?php
		}
?>  
  <a class="button" href="../shifts/calendar.php">BACK TO BOOKINGS</a>
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
    <div>That shift is not possible.
      <br>Every shift must have a brother to serve as overseer.</div>
  </div>
</body>
<?php
	}
?>
</html>