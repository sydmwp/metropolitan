<!DOCTYPE html>
<!-- Last Published: Fri Mar 20 2015 07:17:45 GMT+0000 (UTC) -->
<html data-wf-site="5501f5af8d5d8d533f7660e8" data-wf-page="550b61c9afd603c85d5dc3ab">
<head>
<?php
$con=mysqli_connect("localhost","sydmw721_admin","1914CE","sydmw721_sydmwp");
if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
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
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="generator" content="Webflow">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/webflow.css">
  <link rel="stylesheet" type="text/css" href="../css/cart-metro.css">
  <link rel="stylesheet" type="text/css" href="../fonts/css/font-awesome.min.css">
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
  <div class="confirmed-tick" data-ix="confirmed">
    <div><i class="fa fa-check"></i></div>
  </div>
  <div class="thankyou">
    <div>Thank you.</div>
  </div>
  <div class="placements-entered">
    <div>Your placements have been reported.</div>
  </div>
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
    <div>Sorry, that shift could not be found. Please check the details you entered and try again. If your details are definitely correct, we're obviously experiencing some difficulties. Please <span class="email-text"><a class="email-text" href="mailto:support@sydmwp.com?subject=Shift%20could%20not%20be%20found">EMAIL US</a> </span>to let us know.</div>
  </div>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/webflow.js"></script>
  <!--[if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
</body>
<?php
	}
?>
</html>