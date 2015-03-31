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
$first_day = date('w', (strtotime('first day of '.$month.', '.$year.'')));
$days = date('t', (strtotime($month, $year)));
$today = "2015-04-04";
//$today = date('Y-m-d', strtotime('today'));
$select_date = $_POST['select_date'];
if (!$select_date)
	{
	$select_date = date('Y-m-d', strtotime('today'));
	}
$max_shifts = 8;
echo '
	<title>'.$month.' Calendar</title>
	';
include('../head.php');
?>
</head>

<body>
<?php
include('../menu.php');
?>
  <div class="w-nav keys-pullout current-month" data-collapse="all" data-animation="over-left" data-duration="300" data-contain="1" data-doc-height="1">
    <div class="w-container secoundary-nav-container current-month">
      <nav class="w-nav-menu w-clearfix key-pull-menu" role="navigation">
        <div class="key mobile">
          <div class="key-current-date shifts-available"><?php echo date('j');?></div>
          <div class="key-text mobile">No Shifts</div>
        </div>
        <div class="key mobile">
          <div class="key-current-date"><?php echo date('j');?></div>
          <div class="key-text mobile">Current Date</div>
        </div>
        <div class="key mobile">
          <div class="no-shifts"><?php echo date('j');?></div>
          <div class="key-text mobile">Shift Available</div>
        </div>
        <div class="key mobile">
          <div class="key-current-date full mobile"><?php echo date('j');?></div>
          <div class="key-text mobile">Shifts Full</div>
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
			<input type="hidden" value="'.date('F', (strtotime('next month'))).'" name="month">
			<input type="hidden" value="'.date('Y', (strtotime('next month'))).'" name="year">			
			';?>
			<button class="w-button last-month-text" type="submit"><?php echo strtoupper($month);?>&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i></button>
		<?php
			} if ($month == date('F', (strtotime('next month')))){
			echo '
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
 <div class="w-section cal-section current-month">
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
				<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
				<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
				<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
				<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
				<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
				<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
?>
        </div>
      </div>
      <div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
	$full_count = 0;
	$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
	while ($row = mysqli_fetch_array($full_test))
		{
		$full = $row[full];
		if ($full)
			{
			++$full_count;
			}
		}
	if ($full_count == $max_shifts)
		{
		$output_class = 'shift-full';
		}
		else
		{
		$output_class = 'shift-available';
		}
	if ($month == date('F') AND $result == date('j'))
		{
		$output_class.= ' current-date';
		}	
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
		</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
		$full_count = 0;
		$full_test = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id != '50'");
		while ($row = mysqli_fetch_array($full_test))
			{
			$full = $row[full];
			if ($full)
				{
				++$full_count;
				}
			}
		if ($full_count == $max_shifts)
			{
			$output_class = 'shift-full';
			}
			else
			{
			$output_class = 'shift-available';
			}
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}	
		echo '
			<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
				<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
				<input class="w-button '.$output_class.'" type="submit" value="'.$result.'">
			</form>
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
  </div>
  <div class="w-row date-cal">
	<div class="w-col w-col-8 w-col-small-8 w-col-tiny-8">
      <div class="date-quickview"><?php echo date('l d F', strtotime($select_date)); ?></div>
    </div>
  </div>
  <div class="w-tabs overview-shifts-tab" data-duration-in="300" data-duration-out="100">
	<div class="w-tab-menu w-clearfix">
      <a class="w-tab-link w--current w-inline-block tabs" data-w-tab="Tab 1">
        <div>HYDE PARK</div>
      </a>
      <a class="w-tab-link w-inline-block tabs" data-w-tab="Tab 2">
        <div>ROVING 1</div>
      </a>
      <a class="w-tab-link w-inline-block tabs" data-w-tab="Tab 3">
        <div>ROVING 2</div>
      </a>
    </div>
	<div class="w-tab-content">
	  <div class="w-tab-pane w--tab-active" data-w-tab="Tab 1">
        <div class="quickview-content">
          <div class="w-row row">
            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
              <div class="am-pm-shifts">AM</div>
            </div>
            <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
<?php
$location_id = "1";
$hp_am = mysqli_query($con,"SELECT * FROM shifts WHERE date == '$select_date' AND location_id == '$location_id' AND time == 'AM'");
while ($row = mysqli_fetch_array($hp_am))
	{
	$time_a = $row[time];
	$overseer_id_a = $row[overseer_id_a];
	$pioneer_id_a = $row[pioneer_id_a];
	$pioneer_b_id_a = $row[pioneer_b_id_a];
	}
if ($time_a)
	{
	if ($overseer_id_a)
		{
		$overseer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id_a'");
		while ($row = mysqli_fetch_array($overseer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_a.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id_a)
		{
		$pioneer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id_a'");
		while ($row = mysqli_fetch_array($pioneer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_a.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id_a)
		{
		$pioneer_b_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id_a'");
		while ($row = mysqli_fetch_array($pioneer_b_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_a.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="AM">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
				</form>
			</div>
			';
		}
	}
?>
            </div>
          </div>
          <div class="w-row row">
            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
              <div class="am-pm-shifts">PM</div>
            </div>
            <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
<?php
$hp_pm = mysqli_query($con,"SELECT * FROM shifts WHERE date == '$select_date' AND location_id == '$location_id' AND time == 'PM'");
while ($row = mysqli_fetch_array($hp_pm))
	{
	$time_b = $row[time];
	$overseer_id_b = $row[overseer_id_b];
	$pioneer_id_b = $row[pioneer_id_b];
	$pioneer_b_id_b = $row[pioneer_b_id_b];
	}
if ($time_b)
	{
	if ($overseer_id_b)
		{
		$overseer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id_b'");
		while ($row = mysqli_fetch_array($overseer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_b.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id_b)
		{
		$pioneer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id_b'");
		while ($row = mysqli_fetch_array($pioneer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_b.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id_b)
		{
		$pioneer_b_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id_b'");
		while ($row = mysqli_fetch_array($pioneer_b_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_b.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="PM">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
				</form>
			</div>
			';
		}
	}
?>
            </div>
          </div>
        </div>
      </div>
	  <div class="w-tab-pane" data-w-tab="Tab 2">
        <div class="quickview-content">
          <div class="w-row row">
            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
              <div class="am-pm-shifts">8:30am</div>
            </div>
            <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
<?php
$location_id = "2";
$ro_a = mysqli_query($con,"SELECT * FROM shifts WHERE date == '$select_date' AND location_id == '$location_id' AND time == '8:30'");
while ($row = mysqli_fetch_array($ro_a))
	{
	$time_c = $row[time];
	$overseer_id_c = $row[overseer_id_c];
	$pioneer_id_c = $row[pioneer_id_c];
	$pioneer_b_id_c = $row[pioneer_b_id_c];
	}
if ($time_c)
	{
	if ($overseer_id_c)
		{
		$overseer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id_c'");
		while ($row = mysqli_fetch_array($overseer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_c.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id_c)
		{
		$pioneer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id_c'");
		while ($row = mysqli_fetch_array($pioneer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_c.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id_c)
		{
		$pioneer_b_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id_c'");
		while ($row = mysqli_fetch_array($pioneer_b_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_c.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="8:30">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
				</form>
			</div>
			';
		}
	}
?>			  
            </div>
          </div>
          <div class="w-row row">
            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
              <div class="am-pm-shifts">11:30am</div>
            </div>
            <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
<?php
$ro_b = mysqli_query($con,"SELECT * FROM shifts WHERE date == '$select_date' AND location_id == '$location_id' AND time == '11:30'");
while ($row = mysqli_fetch_array($ro_b))
	{
	$time_d = $row[time];
	$overseer_id_d = $row[overseer_id_d];
	$pioneer_id_d = $row[pioneer_id_d];
	$pioneer_b_id_d = $row[pioneer_b_id_d];
	}
if ($time_d)
	{
	if ($overseer_id_d)
		{
		$overseer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id_d'");
		while ($row = mysqli_fetch_array($overseer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_d.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id_d)
		{
		$pioneer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id_d'");
		while ($row = mysqli_fetch_array($pioneer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_d.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id_d)
		{
		$pioneer_b_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id_d'");
		while ($row = mysqli_fetch_array($pioneer_b_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_d.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="11:30">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
				</form>
			</div>
			';
		}
	}
?>              
            </div>
          </div>
          <div class="w-row row">
            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
              <div class="am-pm-shifts">2:30pm</div>
            </div>
            <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
<?php
$ro_c = mysqli_query($con,"SELECT * FROM shifts WHERE date == '$select_date' AND location_id == '$location_id' AND time == '2:30'");
while ($row = mysqli_fetch_array($ro_c))
	{
	$time_e = $row[time];
	$overseer_id_e = $row[overseer_id_e];
	$pioneer_id_e = $row[pioneer_id_e];
	$pioneer_b_id_e = $row[pioneer_b_id_e];
	}
if ($time_e)
	{
	if ($overseer_id_e)
		{
		$overseer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id_e'");
		while ($row = mysqli_fetch_array($overseer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_e.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id_e)
		{
		$pioneer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id_e'");
		while ($row = mysqli_fetch_array($pioneer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_e.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id_e)
		{
		$pioneer_b_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id_e'");
		while ($row = mysqli_fetch_array($pioneer_b_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_e.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="2:30">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
				</form>
			</div>
			';
		}
	}
?>              
            </div>
          </div>
        </div>	  
	  </div>
	  <div class="w-tab-pane" data-w-tab="Tab 3">
        <div class="quickview-content">
          <div class="w-row row">
            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
              <div class="am-pm-shifts">8:30am</div>
            </div>
            <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
<?php
$location_id = "3";
$rt_a = mysqli_query($con,"SELECT * FROM shifts WHERE date == '$select_date' AND location_id == '$location_id' AND time == '8:30'");
while ($row = mysqli_fetch_array($rt_a))
	{
	$time_f = $row[time];
	$overseer_id_f = $row[overseer_id_f];
	$pioneer_id_f = $row[pioneer_id_f];
	$pioneer_b_id_f = $row[pioneer_b_id_f];
	}
if ($time_f)
	{
	if ($overseer_id_f)
		{
		$overseer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id_f'");
		while ($row = mysqli_fetch_array($overseer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_f.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id_f)
		{
		$pioneer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id_f'");
		while ($row = mysqli_fetch_array($pioneer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_f.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id_f)
		{
		$pioneer_b_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id_f'");
		while ($row = mysqli_fetch_array($pioneer_b_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_f.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="8:30">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
				</form>
			</div>
			';
		}
	}
?>			  
            </div>
          </div>
          <div class="w-row row">
            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
              <div class="am-pm-shifts">11:30am</div>
            </div>
            <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
<?php
$rt_b = mysqli_query($con,"SELECT * FROM shifts WHERE date == '$select_date' AND location_id == '$location_id' AND time == '11:30'");
while ($row = mysqli_fetch_array($rt_b))
	{
	$time_g = $row[time];
	$overseer_id_g = $row[overseer_id_g];
	$pioneer_id_g = $row[pioneer_id_g];
	$pioneer_b_id_g = $row[pioneer_b_id_g];
	}
if ($time_g)
	{
	if ($overseer_id_g)
		{
		$overseer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id_g'");
		while ($row = mysqli_fetch_array($overseer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_g.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id_g)
		{
		$pioneer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id_g'");
		while ($row = mysqli_fetch_array($pioneer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_g.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id_g)
		{
		$pioneer_b_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id_g'");
		while ($row = mysqli_fetch_array($pioneer_b_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_g.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="11:30">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
				</form>
			</div>
			';
		}
	}
?>              
            </div>
          </div>
          <div class="w-row row">
            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
              <div class="am-pm-shifts">2:30pm</div>
            </div>
            <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
<?php
$rt_c = mysqli_query($con,"SELECT * FROM shifts WHERE date == '$select_date' AND location_id == '$location_id' AND time == '2:30'");
while ($row = mysqli_fetch_array($rt_c))
	{
	$time_f = $row[time];
	$overseer_id_h = $row[overseer_id_h];
	$pioneer_id_h = $row[pioneer_id_h];
	$pioneer_b_id_h = $row[pioneer_b_id_h];
	}
if ($time_f)
	{
	if ($overseer_id_h)
		{
		$overseer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$overseer_id_h'");
		while ($row = mysqli_fetch_array($overseer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_f.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id_h)
		{
		$pioneer_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_id_h'");
		while ($row = mysqli_fetch_array($pioneer_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_f.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id_h)
		{
		$pioneer_b_info = mysqli_query($con,"SELECT * FROM pioneers WHERE id = '$pioneer_b_id_h'");
		while ($row = mysqli_fetch_array($pioneer_b_info))
			{
			$first_name = $row[first_name];
			$last_name = $row[last_name];
			$phone = $row[phone];
			$phone = str_replace(' ', '', $phone);
			}
		echo '
			<div class="volunteer-accepted">
				<div class="w-row">
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					</div>
					<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
						<div class="text-volunteer">'.$phone.'</div>
					</div>
				</div>
			</div>
			';
		}
	else
		{
		if ($select_date >= $today)
			{
			echo ' 
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time_f.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="2:30">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
					<input class="w-button volunteer-add" type="submit" value="Volunteer">
				</form>
			</div>
			';
		}
	}
?>              
            </div>
          </div>
        </div>	  
	  </div>
	</div>
  </div>
  </body>
</html>