<!DOCTYPE html>
<!-- Last Published: Fri Mar 20 2015 07:17:45 GMT+0000 (UTC) -->
<html data-wf-site="5501f5af8d5d8d533f7660e8" data-wf-page="550b4ba95b7ee5ba660e4dbc">
<head>
<?php
$con=mysqli_connect("localhost","sydmw721_admin","1914CE","sydmw721_sydmwp");
if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
$date = date('Y-m-d', strtotime(''));
?>
  <meta charset="utf-8">
  <title>Record Placements</title>
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
  <div class="content-placments">
    <div class="w-form form-wrapper">
      <form id="email-form" name="email-form" action="confirm_placements.php" method="post">
<?php
echo '
		<input class="w-input books square select-date" id="date" type="date" value="2015-01-01" name="date" required="required">
	';
?>
	  <select class="w-select select-shift square" id="Shift-time" name="time" required="required">
          <option value="">Select shift time...</option>
          <option value="AM">AM - Hyde Park</option>
          <option value="PM">PM - Hyde Park</option>
		  <option value="8:30">8:30</option>
		  <option value="11:30">11:30</option>
		  <option value="2:30">2:30</option>
        </select>
        <select class="w-select location-shift square" id="field-2" name="location" required="required">
          <option value="Location">Select your location...</option>
<?php
$result_location = mysqli_query($con,"SELECT * FROM locations WHERE id != '50' ORDER BY name");
while($row = mysqli_fetch_array($result_location))
	{
		$output_location.='<option value="'.$row['name'].'">'.$row['name'].'</option>';
	}
echo $output_location;
?>
        </select>
        <input class="w-input books square" id="books" type="number" placeholder="Books" name="books">
        <input class="w-input magazines square" id="Magazines" type="number" placeholder="Magazines" name="magazines">
        <input class="w-input brochures square" id="Brochures" type="number" placeholder="Brochures" name="brochures">
        <textarea class="w-input comments square" formid="email_form" id="Comments" placeholder="Comments..." name="comments"></textarea>
        <input class="w-button submit square" type="submit" value="Record">
      </form>
    </div>
  </div>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/webflow.js"></script>
  <!--[if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
</body>
</html>