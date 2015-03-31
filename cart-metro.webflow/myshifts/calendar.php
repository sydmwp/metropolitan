<!DOCTYPE html>
<html>
<head>
<?php
require('../db.php');
$month = $_POST['month'];
$year = $_POST['year'];
if (!$month)
	{
	$month = date('F');
	$year = date('Y');
	}
$first_day = date('w', (strtotime('1st '.$month.', '.$year.'')));
$days = date('t', (strtotime($month, $year)));
$select_date = $_POST['select_date'];
$date_selected = date('j', strtotime($select_date));
if (!$select_date)
	{
	$select_date = date('Y-m-d', strtotime('today'));
	$date_selected = null;
	}
$volunteer_id = $_POST['volunteer_id'];
if ($volunteer_id)
	{
	$pioneer = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$volunteer_id'");
	while ($row = mysqli_fetch_array($pioneer))
		{
		$first_name = $row[first_name];
		$last_name = $row[last_name];
		}
	}
else
	{
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
	}
echo '
	<title>'.$month.' shifts - '.$first_name.'</title>
	';
include('../head.php');
?>
</head>

<?php
if ($volunteer_id)
	{
?>
<body>
<?php
include('../menu.php');
?>
  <div class="w-nav keys-pullout" data-collapse="all" data-animation="over-left" data-duration="300" data-contain="1" data-doc-height="1">
    <div class="w-container secoundary-nav-container">
      <nav class="w-nav-menu key-pull-menu" role="navigation">
        <div class="w-clearfix key mobile">
          <div class="key-current-date"><?php echo date('j');?></div>
          <div class="key-text mobile">Current Date</div>
        </div>
		<div class="w-clearfix key mobile">
          <div class="key-current-date my-shifts"><?php echo date('j');?></div>
          <div class="key-text mobile">Shift booked</div>
        </div>
      </nav>
	  <div class="w-nav-button w-clearfix menu-button">
        <div class="icon-key"><i class="fa fa-info-circle"></i></div>
      </div>
	  <div class="w-form w-clearfix form-wrapper-submit">
	  <form class="w-clearfix form-month" id="email-form-3" name="month" action="calendar.php" method="post">
		<?php
			if ($month == date('F')){
			echo '
			<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
			<input type="hidden" value="'.date('F', (strtotime('first day of next month'))).'" name="month">
			<input type="hidden" value="'.date('Y', (strtotime('first day of next month'))).'" name="year">			
			';?>
			<button class="w-button last-month-text" type="submit"><?php echo strtoupper($month);?>&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i></button>
		<?php
			} if ($month == date('F', (strtotime('first day of next month')))){
			echo '
			<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
			<input type="hidden" value="'.date('F').'" name="month">
			<input type="hidden" value="'.date('Y').'" name="year">		
			';?>
			<button class="w-button last-month-text" type="submit"><i class="fa fa-angle-left"></i>&nbsp;&nbsp;&nbsp;<?php echo strtoupper($month);?></button>
		<?php	
			}?>
	  </form>
	  </div>
    </div>
  </div>
  <div class="w-section cal-section">
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
		if ($month == date('F') AND $result == date('j'))
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
		$result++;
		$output_class = "";
		}
?>
        
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
		$result++;
		$output_class = "";
		}
?>
        </div>
      </div>
    </div>
    <div class="w-clearfix content-cal">
<?php
include('week.php');
?>
    </div>
    <div class="w-clearfix content-cal">
<?php
include('week.php');
?>
    </div>
    <div class="w-clearfix content-cal">
<?php
include('week.php');
?>
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
	if ($month == date('F') AND $result == date('j'))
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
		$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
		if ($month == date('F') AND $result == date('j'))
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
	$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
	$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
	$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
	$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
	$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
	$shift_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id')");
		while ($row = mysqli_fetch_array($shift_test))
			{
			$shift = $row[id];
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button shift-full my-shift';
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
						<input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			}
		else
			{
			echo '
			<div class="no-shift '.$output_class.'">'.$result.'</div>
			';
			}
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
  </div>
<?php
$shift_detail = mysqli_query($con,"SELECT * FROM shifts WHERE (overseer_id = '$volunteer_id' OR pioneer_id = '$volunteer_id' OR pioneer_b_id = '$volunteer_id') AND date = '$select_date'");
while ($row = mysqli_fetch_array($shift_detail))
	{
	$shift_id = $row[id];
	$location_id = $row[location_id];
	$time = $row[time];
	$overseer_id = $row[overseer_id];
	$pioneer_id = $row[pioneer_id];
	$pioneer_b_id = $row[pioneer_b_id];
	}
if($shift_id)
	{
	$location_detail = mysqli_query($con,"SELECT * FROM locations WHERE id = '$location_id'");
	while ($row = mysqli_fetch_array($location_detail))
		{
		$location_name = $row[name];
		}
?>
  <div class="date-quickview"><?php echo date('l d F', strtotime($select_date)); ?> - <?php echo $location_name; ?></div>
	<div class="my-shifts-content">
	  <div class="w-row w-hidden-main w-hidden-medium row">
		<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
		  <div class="am-pm-shifts"><?php echo $time; ?></div>
		</div>
		<div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
			<div class="volunteer-accepted">
				<div class="w-row">
<?php
if ($overseer_id)
	{
	$overseer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id'");
	while ($row = mysqli_fetch_array($overseer_info))
		{
		$first_name = $row[first_name];
		$last_name = $row[last_name];
		$phone = $row[phone];
		$phone = str_replace(' ', '', $phone);
		}
		echo '
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
						<div class="text-volunteer">'.$phone.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
					  <div class="w-form">
						<form id="email-form-2" name="overseer" method="post" action="confirm_delete.php">
						  <input type="hidden" name="volunteer_id" value="'.$volunteer_id.'">
						  <input type="hidden" name="overseer_id" value="'.$overseer_id.'">
						  <input type="hidden" name="shift_id" value="'.$shift_id.'">
						  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
						</form>
					  </div>
					</div>
			';
	}
?>
				</div>
			</div>
			<div class="volunteer-accepted">
				<div class="w-row">
<?php
if ($pioneer_id)
	{
	$pioneer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id'");
	while ($row = mysqli_fetch_array($pioneer_info))
		{
		$first_name = $row[first_name];
		$last_name = $row[last_name];
		$phone = $row[phone];
		$phone = str_replace(' ', '', $phone);
		}
		echo '
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
						<div class="text-volunteer">'.$phone.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
					  <div class="w-form">
						<form id="email-form-2" name="pioneer" method="post" action="confirm_delete.php">
						  <input type="hidden" name="volunteer_id" value="'.$volunteer_id.'">
						  <input type="hidden" name="pioneer_id" value="'.$pioneer_id.'">
						  <input type="hidden" name="shift_id" value="'.$shift_id.'">
						  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
						</form>
					  </div>
					</div>
			';	
	}
?>              
            </div>
          </div>
		  <div class="volunteer-accepted">
			<div class="w-row">
<?php
if ($pioneer_b_id)
	{
	$pioneer_b_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id'");
	while ($row = mysqli_fetch_array($pioneer_b_info))
		{
		$first_name = $row[first_name];
		$last_name = $row[last_name];
		$phone = $row[phone];
		$phone = str_replace(' ', '', $phone);
		}
		echo '
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
						<div class="text-volunteer">'.$phone.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
					  <div class="w-form">
						<form id="email-form-2" name="pioneer_b" method="post" action="confirm_delete.php">
						  <input type="hidden" name="volunteer_id" value="'.$volunteer_id.'">
						  <input type="hidden" name="pioneer_b_id" value="'.$pioneer_b_id.'">
						  <input type="hidden" name="shift_id" value="'.$shift_id.'">
						  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
						</form>
					  </div>
					</div>
			';
	}
?>				
			</div>
		  </div>
        </div>	  
	  </div>
	      <div class="w-row w-hidden-small w-hidden-tiny row">
      <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
        <div class="am-pm-shifts">AM</div>
      </div>
      <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
        <div class="volunteer-accepted">
          <div class="w-row">
<?php
if ($overseer_id)
	{
	$overseer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id'");
	while ($row = mysqli_fetch_array($overseer_info))
		{
		$first_name = $row[first_name];
		$last_name = $row[last_name];
		$phone = $row[phone];
		$phone = str_replace(' ', '', $phone);
		}
		echo '
					<div class="w-col w-col-4">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					 </div>
					<div class="w-col w-col-4">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
					<div class="w-col w-col-4">
					  <div class="w-form">
						<form id="email-form-2" name="overseer" method="post" action="confirm_delete.php">
						  <input type="hidden" name="volunteer_id" value="'.$volunteer_id.'">
						  <input type="hidden" name="overseer_id" value="'.$overseer_id.'">
						  <input type="hidden" name="shift_id" value="'.$shift_id.'">
						  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
						</form>
					  </div>
					</div>
			';
	}
?>		  

          </div>
        </div>
        <div class="volunteer-accepted">
          <div class="w-row">
<?php
if ($pioneer_id)
	{
	$pioneer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id'");
	while ($row = mysqli_fetch_array($pioneer_info))
		{
		$first_name = $row[first_name];
		$last_name = $row[last_name];
		$phone = $row[phone];
		$phone = str_replace(' ', '', $phone);
		}
		echo '
					<div class="w-col w-col-4">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					 </div>
					<div class="w-col w-col-4">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
					<div class="w-col w-col-4">
					  <div class="w-form">
						<form id="email-form-2" name="pioneer" method="post" action="confirm_delete.php">
						  <input type="hidden" name="volunteer_id" value="'.$volunteer_id.'">
						  <input type="hidden" name="pioneer_id" value="'.$pioneer_id.'">
						  <input type="hidden" name="shift_id" value="'.$shift_id.'">
						  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
						</form>
					  </div>
					</div>
			';	
	}
?>
          </div>
        </div>
        <div class="volunteer-accepted">
          <div class="w-row">
<?php
if ($pioneer_b_id)
	{
	$pioneer_b_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id'");
	while ($row = mysqli_fetch_array($pioneer_b_info))
		{
		$first_name = $row[first_name];
		$last_name = $row[last_name];
		$phone = $row[phone];
		$phone = str_replace(' ', '', $phone);
		}
		echo '
					<div class="w-col w-col-4">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					 </div>
					<div class="w-col w-col-4">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
					<div class="w-col w-col-4">
					  <div class="w-form">
						<form id="email-form-2" name="pioneer_b" method="post" action="confirm_delete.php">
						  <input type="hidden" name="volunteer_id" value="'.$volunteer_id.'">
						  <input type="hidden" name="pioneer_b_id" value="'.$pioneer_b_id.'">
						  <input type="hidden" name="shift_id" value="'.$shift_id.'">
						  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
						</form>
					  </div>
					</div>
			';
	}
?>
          </div>
        </div>
      </div>
    </div>
	</div>
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
  </body>
</html>