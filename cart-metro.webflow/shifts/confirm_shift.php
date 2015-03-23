<!DOCTYPE html>
<!-- Last Published: Thu Mar 19 2015 06:26:13 GMT+0000 (UTC) -->
<html data-wf-site="5501f5af8d5d8d533f7660e8" data-wf-page="550a05b5e1bdbdd24198512a">
<head>
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/webflow.css">
  <link rel="stylesheet" type="text/css" href="../css/cart-metro.css">
  <link rel="stylesheet" type="text/css" href="../fonts/css/font-awesome.min.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="generator" content="Webflow">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic","Roboto Slab:100,300,regular,700"]
      }
    });
  </script>
  <script type="text/javascript" src="../js/modernizr.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="../images/metro-favicon.png">
  <link rel="apple-touch-icon" href="../images/metropolitan.png">
<?php
$con=mysqli_connect("localhost","sydmw721_admin","1914CE","sydmw721_sydmwp");
// Check connection
if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
$location_id = $_POST['location_id'];
$location_search = mysqli_query($con,"SELECT * FROM locations WHERE id = '$location_id'");
while ($row = mysqli_fetch_array($location_search))
	{
	$location = strtoupper($row[name]);
	}
$date = $_POST['date'];
$day = date('d/m/Y',(strtotime($date)));
$time = $_POST['time'];
echo '
  <title>'.$location.', '.$day.', '.$time.'</title>
  ';
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
if ($phone_a)
	{
	$pioneer_a = mysqli_query($con,"SELECT * FROM pioneers WHERE phone = '$phone_a'");
	while ($row = mysqli_fetch_array($pioneer_a))
		{
		$pioneer_id = $row[id];
		$gender_a = $row[gender];
		}
	if (!$gender_a)
		{
?>
</head>
<body class="sorry-not-found">
  <div class="w-nav uni-nav" data-collapse="all" data-animation="over-left" data-duration="500" data-contain="1" data-doc-height="1" data-easing="ease-in" data-easing2="ease-out">
    <div class="w-container main-nav-container">
      <a class="w-nav-brand" href="../index.php">
        <div class="logo-text">SYDNEY METROPOLITAN</div>
      </a>
      <nav class="w-nav-menu main-nav-pull-out" role="navigation"><a class="w-nav-link nav-link" href="../index.php">HOME</a><a class="w-nav-link nav-link" href="../placements/report.php">PLACEMENTS</a><a class="w-nav-link nav-link" href="../shifts/current_month.php">BOOKINGS</a><a class="w-nav-link nav-link" href="../myshifts/login.php">MY SHIFTS</a><a class="w-nav-link nav-link" href="#">FAQ</a><a class="w-nav-link nav-link" href="#">CONTACT</a>
      </nav>
      <div class="w-nav-button menu-burger">
        <div class="w-icon-nav-menu icon-burger"></div>
      </div>
    </div>
  </div>
  <div class="face" data-ix="confirmed">
    <div><i class="fa fa-frown-o"></i></div>
  </div>
  <div class="content-sorry">
    <div>A number is not on file.
      <br>Please <span class="email-text"><a class="email-text" href="mailto:support@sydmwp.com?subject=Number%20not%20on%20file">EMAIL US</a> </span>to let us know.</div>
  </div>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/webflow.js"></script>
  <!--[if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
</body>
<?php
		die;
		}
	}
$phone_b = $_POST['phone_b'];
$phone_b = str_replace('+61', '0', $phone_b);
$phone_b = str_replace(' ', '', $phone_b);
if ($phone_b)
	{
	$pioneer_b = mysqli_query($con,"SELECT * FROM pioneers WHERE phone = '$phone_b'");
	while ($row = mysqli_fetch_array($pioneer_b))
		{
		$pioneer_b_id = $row[id];
		$gender_b = $row[gender];
		}
	if (!$gender_b)
		{
?>
</head>
<body class="sorry-not-found">
  <div class="w-nav uni-nav" data-collapse="all" data-animation="over-left" data-duration="500" data-contain="1" data-doc-height="1" data-easing="ease-in" data-easing2="ease-out">
    <div class="w-container main-nav-container">
      <a class="w-nav-brand" href="../index.php">
        <div class="logo-text">SYDNEY METROPOLITAN</div>
      </a>
      <nav class="w-nav-menu main-nav-pull-out" role="navigation"><a class="w-nav-link nav-link" href="../index.php">HOME</a><a class="w-nav-link nav-link" href="../placements/report.php">PLACEMENTS</a><a class="w-nav-link nav-link" href="../shifts/current_month.php">BOOKINGS</a><a class="w-nav-link nav-link" href="../myshifts/login.php">MY SHIFTS</a><a class="w-nav-link nav-link" href="#">FAQ</a><a class="w-nav-link nav-link" href="#">CONTACT</a>
      </nav>
      <div class="w-nav-button menu-burger">
        <div class="w-icon-nav-menu icon-burger"></div>
      </div>
    </div>
  </div>
  <div class="face" data-ix="confirmed">
    <div><i class="fa fa-frown-o"></i></div>
  </div>
  <div class="content-sorry">
    <div>A number is not on file.
      <br>Please <span class="email-text"><a class="email-text" href="mailto:support@sydmwp.com?subject=Number%20not%20on%20file">EMAIL US</a> </span>to let us know.</div>
  </div>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/webflow.js"></script>
  <!--[if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
</body>
<?php
		die;
		}
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
?>
</head>
<?php
if ($status !== 'invalid')
	{
?>
<body>
  <div class="w-nav uni-nav" data-collapse="all" data-animation="over-left" data-duration="400" data-contain="1" data-doc-height="1">
    <div class="w-container main-nav-container">
      <a class="w-nav-brand" href="../index.php">
        <div class="logo-text">SYDNEY METROPOLITAN</div>
      </a>
      <nav class="w-nav-menu main-nav-pull-out" role="navigation"><a class="w-nav-link nav-link" href="../index.php">HOME</a><a class="w-nav-link nav-link" href="../placements/report.php">PLACEMENTS</a><a class="w-nav-link nav-link" href="../shifts/current_month.php">BOOKINGS</a><a class="w-nav-link nav-link" href="../myshifts/login.php">MY SHIFTS</a><a class="w-nav-link nav-link" href="#">FAQ</a><a class="w-nav-link nav-link" href="#">CONTACT</a>
      </nav>
      <div class="w-nav-button menu-burger">
        <div class="w-icon-nav-menu icon-burger"></div>
      </div>
    </div>
  </div>
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
  <a class="button" href="../shifts/current_month.php">BACK TO BOOKINGS</a>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/webflow.js"></script>
  <!--[if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
</body>
<?php
	}
	else
	{
?>
<body class="sorry-not-found">
  <div class="w-nav uni-nav" data-collapse="all" data-animation="over-left" data-duration="500" data-contain="1" data-doc-height="1" data-easing="ease-in" data-easing2="ease-out">
    <div class="w-container main-nav-container">
      <a class="w-nav-brand" href="../index.php">
        <div class="logo-text">SYDNEY METROPOLITAN</div>
      </a>
      <nav class="w-nav-menu main-nav-pull-out" role="navigation"><a class="w-nav-link nav-link" href="../index.php">HOME</a><a class="w-nav-link nav-link" href="../placements/report.php">PLACEMENTS</a><a class="w-nav-link nav-link" href="../shifts/current_month.php">BOOKINGS</a><a class="w-nav-link nav-link" href="../myshifts/login.php">MY SHIFTS</a><a class="w-nav-link nav-link" href="#">FAQ</a><a class="w-nav-link nav-link" href="#">CONTACT</a>
      </nav>
      <div class="w-nav-button menu-burger">
        <div class="w-icon-nav-menu icon-burger"></div>
      </div>
    </div>
  </div>
  <div class="face" data-ix="confirmed">
    <div><i class="fa fa-frown-o"></i></div>
  </div>
  <div class="content-sorry">
    <div>That shift is not possible.
      <br>Every shift must have a brother to serve as overseer.</div>
  </div>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/webflow.js"></script>
  <!--[if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
</body>
<?php
	}
?>
</html>