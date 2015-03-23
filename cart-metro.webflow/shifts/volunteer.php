<!DOCTYPE html>
<!-- Last Published: Wed Mar 18 2015 05:41:20 GMT+0000 (UTC) -->
<html data-wf-site="5501f5af8d5d8d533f7660e8" data-wf-page="55081b6d86445dab7e848728">
<head>
<?php
$con=mysqli_connect("localhost","sydmw721_admin","1914CE","sydmw721_sydmwp");
// Check connection
if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
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
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/webflow.js"></script>
  <!--[if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
</body>
</html>