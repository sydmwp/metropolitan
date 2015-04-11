<?php
require('../db.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));
$day = date('d/m/Y',(strtotime($date)));
$location_id = $_POST['location'];
$time = $_POST['time'];
$books = $_POST['books'];
$magazines = $_POST['magazines'];
$brochures = $_POST['brochures'];
$comments = $_POST['comments'];
$stmt = $con->prepare($location_select);
	$stmt->bind_param('i', $location_id);
	$stmt->execute();
	$stmt->bind_result($location_name);
	$stmt->fetch();
$stmt->close();
$stmt = $con->prepare($shift_unrecorded_select);
	$stmt->bind_param('ssi', $date, $time, $location_id);
	$stmt->execute();
	$stmt->bind_result($shift_id, $shift_confirmed, $shift_recorded);
	$stmt->fetch();
$stmt->close();
echo '
  <title>'.$location_name.', '.$day.', '.$time.'</title>
  ';
include('../head.php');
?>
</head>
<?php
if($shift_id && $shift_confirmed && !$shift_recorded)
	{
	$stmt = $con->prepare($placements_record);
		$stmt->bind_param('iiisi', $books, $magazines, $brochures, $comments, $shift_id);
		$stmt->execute();
	$stmt->close();
?>
<body class="confirmed-placements">
  <div class="confirm-background"><img class="happy-cart" src="../images/happy cart-purple number-03-03.svg" width="650" alt="5519ba6ccd49715f162597f2_happy%20cart-purple%20number-03-03.svg">
    <div class="thankyou">
      <div>THANK YOU</div>
      <div class="placements-entered">
        <div>Your placements have been confirmed</div>
      </div>
    </div>
    <div class="w-clearfix backhome">
      <a class="w-inline-block back-home" href="../index.php">
        <div><i class="fa fa-angle-left"></i> &nbsp;&nbsp;&nbsp;Back Home</div>
      </a>
      <a class="w-inline-block next" href="../shifts">
        <div>Bookings&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;</div>
      </a>
    </div>
  </div>
</body>
<?php
	}
else
	{
?>
<body class="sorry-not-found">
  <div class="sorry-background"><img class="sad-cart" src="../images/sad cart grey-04.svg" width="650" alt="5519c0b4cd49715f162598fb_sad%20cart%20grey-04.svg">
    <div class="content-sorry">
      <div class="thankyou">SORRY</div>
      <div>That shift could not be found. If your details are definitely correct, we're obviously experiencing some difficulties. Please email us to let us know.</div>
    </div>
    <div class="w-clearfix backhome">
      <a class="w-inline-block add-placements" href="index.php">
        <div><i class="fa fa-angle-left"></i>&nbsp;&nbsp;&nbsp;&nbsp;Placements</div>
      </a>
      <a class="w-inline-block next" href="mailto:support@sydmwp.com?subject=Shift%20could%20not%20be%20found">
        <div>Email Placements&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</div>
      </a>
    </div>
  </div>
</body>
<?php
	}
?>
</html>