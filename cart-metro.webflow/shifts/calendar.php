<!DOCTYPE html>
<!-- This site was created in Webflow. http://www.webflow.com-->
<!-- Last Published: Fri Mar 13 2015 08:04:55 GMT+0000 (UTC) -->
<html data-wf-site="5501f5af8d5d8d533f7660e8" data-wf-page="5501f5af8d5d8d533f7660e9">

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
	  <form id="email-form" name="month" action="calendar.php" method="post">
		<?php
			if ($month == date('F')){
			echo '
			<input type="hidden" value="'.date('F', (strtotime('next month'))).'" name="month">
			<input type="hidden" value="'.date('Y', (strtotime('next month'))).'" name="year">			
			';
			echo strtoupper($month);?>&nbsp;&nbsp;&nbsp;<button class="w-button location-forward" type="submit"><i class="fa fa-angle-right"></i></button>
		<?php
			} if ($month == date('F', (strtotime('next month')))){
			echo '
			<input type="hidden" value="'.date('F').'" name="month">
			<input type="hidden" value="'.date('Y').'" name="year">		
			';?>
			<button class="w-button location-forward" type="submit"><i class="fa fa-angle-left"></i></button>&nbsp;&nbsp;&nbsp;<?php echo strtoupper($month);?>
		<?php	
			}?>
	  </form>
	  <div class="w-nav-button w-clearfix menu-button">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
		<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
			<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
			<form id="email-form" name="shifts_day_view" method="post" action="day_view.php">
				<input type="hidden" name="date" value="'.$date.'">
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
<?php
include('../foot.php')
?>
  </body>
  
</html>