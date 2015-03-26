<!DOCTYPE html>
<!-- This site was created in Webflow. http://www.webflow.com-->
<!-- Last Published: Fri Mar 13 2015 08:04:55 GMT+0000 (UTC) -->
<html data-wf-site="5501f5af8d5d8d533f7660e8" data-wf-page="5501f5af8d5d8d533f7660e9">
<head>
<?php
$con=mysqli_connect("localhost","sydmw721_admin","1914CE","sydmw721_sydmwp");
// Check connection
if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
date_default_timezone_set('Australia/Sydney');
$month = $_POST['month'];
if (!$month)
	{
	$month = date('F');
	}
$first_day = date('w', (strtotime('first day of '.$month.'')));
$days = date('t', ($month));
$phone = $_POST['phone'];
$phone = str_replace('+61', '0', $phone);
$phone = str_replace(' ', '', $phone);
$pioneer = mysqli_query($con,"SELECT * FROM pioneers WHERE phone = '$phone'");
while ($row = mysqli_fetch_array($pioneer))
	{
	$volunteer_id = $row[id];
	$first_name = $row[first_name];
	$last_name = $row[last_name];
	}
echo '
	<title>'.$month.' Calendar</title>
	';
?>
  <meta charset="utf-8">
  <meta name="robots" content="noindex">
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
  <div class="w-nav uni-nav" data-collapse="all" data-animation="over-left" data-duration="300" data-contain="1">
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
  <div class="w-nav keys-pullout" data-collapse="all" data-animation="over-left" data-duration="300" data-contain="1" data-doc-height="1">
    <div class="w-container secoundary-nav-container">
      <nav class="w-nav-menu w-clearfix key-pull-menu" role="navigation">
        <div class="key mobile">
          <div class="no-shifts"><?php echo date('j');?></div>
          <div class="key-text mobile">No Shifts</div>
        </div>
        <div class="key mobile">
          <div class="key-current-date"><?php echo date('j');?></div>
          <div class="key-text mobile">Current Date</div>
        </div>
        <div class="key mobile">
          <div class="key-current-date shifts-available"><?php echo date('j');?></div>
          <div class="key-text mobile">Shift Available</div>
        </div>
        <div class="key mobile">
          <div class="key-current-date full mobile"><?php echo date('j');?></div>
          <div class="key-text mobile">Shifts Full</div>
        </div>
      </nav>
	  <form name="month_nav" method="post" action="calendar.php">
		<?php?>
	  <?php if($month == date('F')) {
	  echo '<input type="hidden" name="month" value="'.date("F", (strtotime("next month"))).'">'; ?>
	  <button type="submit" class="w-button next-month-link"><?php echo strtoupper(date('F'));?>&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;</button>
	  <?php } if($month == (date('F', (strtotime('next month'))))) {
	  echo '<input type="hidden" name="month" value="'.date("F").'">'; ?>
	  <button type="submit" class="w-button next-month-link"><i class="fa fa-angle-left"></i>&nbsp;&nbsp;&nbsp;<?php echo strtoupper(date('F', (strtotime('next month'))));?>&nbsp;</button>
	  <?php } ?>
	  </form>
      <div class="w-nav-button w-clearfix menu-button">
		<?php echo '
		'.$firstname.' '.$lastname.'
		'; ?>
        <div class="icon-key"><i class="fa fa-info-circle"></i></div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="w-clearfix content-cal">
      <div class="calendar-date">
        <div class="week-day-text">S</div>
      </div>
      <div class="calendar-date">
        <div class="week-day-text">M</div>
      </div>
      <div class="calendar-date">
        <div class="week-day-text">T</div>
      </div>
      <div class="calendar-date">
        <div class="week-day-text">W</div>
      </div>
      <div class="calendar-date">
        <div class="week-day-text">T</div>
      </div>
      <div class="calendar-date">
        <div class="week-day-text">F</div>
      </div>
      <div class="calendar-date">
        <div class="week-day-text">S</div>
      </div>
    </div>
    <div class="w-clearfix content-cal">
      <div class="calendar-date">
        <div class="w-form form-wrapper">	
<?php
	if ($first_day == 0)
		{
		$result = 1;
		$output_class = 'no-shift';
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}
		echo '
			<div class ="'.$output_class.'">
				'.$result.'
			</div>
			';
		$result++; $output_class = "";
		}
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($first_day == 1)
		{
		$result = 1;
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	elseif ($result)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	if ($result)
		{
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($first_day == 2)
		{
		$result = 1;
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	elseif ($result)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	if ($result)
		{
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($first_day == 3)
		{
		$result = 1;
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	elseif ($result)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	if ($result)
		{
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($first_day == 4)
		{
		$result = 1;
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	elseif ($result)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	if ($result)
		{
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($first_day == 5)
		{
		$result = 1;
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	elseif ($result)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	if ($result)
		{
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($first_day == 6)
		{
		$result = 1;
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	elseif ($result)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		}
	if ($result)
		{
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
    </div>
    <div class="w-clearfix content-cal">
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$output_class = 'no-shift';
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}
	echo '
		<div class ="'.$output_class.'">
				'.$result.'
		</div>
		';
	$result++; $output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
    </div>
    <div class="w-clearfix content-cal">
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$output_class = 'no-shift';
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}
	echo '
		<div class ="'.$output_class.'">
				'.$result.'
		</div>
		';
	$result++; $output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
    </div>
    <div class="w-clearfix content-cal">
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$output_class = 'no-shift';
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}
	echo '
		<div class ="'.$output_class.'">
				'.$result.'
		</div>
		';
	$result++; $output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
	while ($row = mysqli_fetch_array($shift_query))
		{
		$shift_id = $row[id];
		}
	if ($shift_id)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<input type="hidden" name="date" value="'.$date.'">
		<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		';
	$result++;
	$output_class = "";
?>
        </div>
      </div>
    </div>
<?php
if ($result <= $days)
	{
?>
    <div class="w-clearfix content-cal">
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$output_class = 'no-shift';
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}
		echo '
			<div class ="'.$output_class.'">
				'.$result.'
			</div>
			';
		$result++; $output_class = "";
		}
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
	  <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
    </div>
<?php
	}
?>
<?php
if ($result <= $days)
	{
?>
    <div class="w-clearfix content-cal">
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$output_class = 'no-shift';
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}
		echo '
			<div class ="'.$output_class.'">
				'.$result.'
			</div>
			';
		$result++; $output_class = "";
		}
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
	  <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
				<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
		$date = date('Y\-m\-d', (strtotime("$result $month this year")));
		$shift_query = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_query))
			{
			$shift_id = $row[id];
			}
		if ($shift_id)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<input type="hidden" name="date" value="'.$date.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			';
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
    </div>
<?php
	}
?>
  </div>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/webflow.js"></script>
  <!--[if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
</body>
</html>