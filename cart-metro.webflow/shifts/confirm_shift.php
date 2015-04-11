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
$existing = $_POST['existing'];
$volunteer_id = $user;
$stmt = $con->prepare($pioneer_select);
	$stmt->bind_param('i', $volunteer_id);
	$stmt->execute();
	$stmt->bind_result($f, $l, $volunteer_gender, $p);
	$stmt->fetch();
$stmt->close();
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
	$stmt = $con->prepare($pioneer_phone_select);
		$stmt->bind_param('s', $phone_a);
		$stmt->execute();
		$stmt->bind_result($pioneer_id, $f, $l, $gender_a);
		$stmt->fetch();
	$stmt->close();
	}
if ($phone_b)
	{
	$stmt = $con->prepare($pioneer_phone_select);
		$stmt->bind_param('s', $phone_b);
		$stmt->execute();
		$stmt->bind_result($pioneer_b_id, $f, $l, $gender_b);
		$stmt->fetch();
	$stmt->close();
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
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_id);
			$stmt->execute();
			$stmt->bind_result($f, $l, $gender, $p);
			$stmt->fetch();
		$stmt->close();
		if ($gender == "f")
			{
			$stmt = $con->prepare($couple_select);
				$stmt->bind_param('ii', $overseer_id, $pioneer_id);
				$stmt->execute();
				$stmt->bind_result($couple_id);
				$stmt->fetch();
			$stmt->close();
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
$overseer_id = (int)$overseer_id;
$overseer_details = mysqli_query($con,"SELECT first_name, last_name, phone FROM pioneers WHERE id = '$overseer_id'");
while ($row = mysqli_fetch_array($overseer_details))
	{
	$overseer_name = "{$row['first_name']} {$row['last_name']}";
	$overseer_phone = $row[phone];
	}
$pioneer_id = (int)$pioneer_id;
$pioneer_details = mysqli_query($con,"SELECT first_name, last_name, phone FROM pioneers WHERE id = '$pioneer_id'");
while ($row = mysqli_fetch_array($pioneer_details))
	{
	$pioneer_name = "{$row['first_name']} {$row['last_name']}";
	$pioneer_phone = $row[phone];
	}
$pioneer_b_id = (int)$pioneer_b_id;
$pioneer_b_details = mysqli_query($con,"SELECT first_name, last_name, phone FROM pioneers WHERE id = '$pioneer_b_id'");
while ($row = mysqli_fetch_array($pioneer_b_details))
	{
	$pioneer_b_name = "{$row['first_name']} {$row['last_name']}";
	$pioneer_b_phone = $row[phone];
	}
if (!$existing)
	{
	if (!$overseer_id) {$overseer_id = "";}
	if (!$pioneer_id) {$pioneer_id = "";}
	if (!$pioneer_b_id) {$pioneer_b_id = "";}
	if (!$confirmed) {$confirmed = "";}
	if (!$full) {$full = "";}
	$stmt = $con->prepare($shift_insert);
		$stmt->bind_param('issiiiss', $location_id, $date, $time, $overseer_id, $pioneer_id, $pioneer_b_id, $confirmed, $full);
		$stmt->execute();
	$stmt->close();
	}
else
	{
	$stmt = $con->prepare($shift_select);
		$stmt->bind_param('ssi', $date, $time, $location_id);
		$stmt->execute();
		$stmt->bind_result($shift_id);
		$stmt->fetch();
	$stmt->close();
	$stmt = $con->prepare($shift_update);
		$stmt->bind_param('iiissi', $overseer_id, $pioneer_id, $pioneer_b_id, $full, $confirmed, $shift_id);
		$stmt->execute();
	$stmt->close();
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
  <a class="button" href="index.php">BACK TO BOOKINGS</a>
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