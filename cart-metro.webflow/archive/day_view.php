<!DOCTYPE html>
<html data-wf-site="5501f5af8d5d8d533f7660e8" data-wf-page="55027b58fc33269b048286ac">
<head>
<?php
require('../db.php');	
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));
$day = date('d F Y',(strtotime($date)));
$today = "2015-04-04";
//$today = date('Y-m-d', strtotime('today'));
$location_id = $_POST['location_id'];
if (!$location_id)
	{
	$location_id = 1;
	}
$location_next = $location_id + 1;
$location_previous = $location_id - 1;
$location_name = mysqli_query($con,"SELECT * FROM locations WHERE id = '$location_id'");
while ($row = mysqli_fetch_array($location_name))
	{
	$location = strtoupper($row[name]);
	}
echo '
	<title>'.$day.'</title>
	';
include('../head.php');
?>
</head>
<body>
<?php
include('../menu.php');
?>
<?php
if($location_id ==1)
	{
?>
  <div class="location-select">
    <div class="w-row">
      <div class="w-col w-col-3 w-col-small-3 w-col-tiny-3">
        <div class="w-form">
        </div>
      </div>
      <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
        <div class="location-text">
<?php		
		echo $location;
?>
		</div>
	  </div>
      <div class="w-col w-col-3 w-col-small-3 w-col-tiny-3">
        <div class="w-form">
<?php
$location_test = mysqli_query($con,"SELECT * FROM locations WHERE id = '$location_next'");
while ($row = mysqli_fetch_array($location_test))
	{
	$location_forward = $row[id];
	}
if ($location_forward)
	{	
	echo '
			<form id="email-form-2" name="next" action="day_view.php" method="post">
				<input type="hidden" name="location_id" value="'.$location_forward.'">
				<input type="hidden" name="date" value="'.$date.'">
				<button class="w-button location-forward" type="submit"><i class="fa fa-angle-right"></i></button>
			</form>
	';
	}
?>		  
        </div>
      </div>
    </div>
  </div>
  <div class="content-day-view">
	<a class="w-inline-block date-calandur" href="../shifts/calendar.php">
<?php
	echo '
	<div><i class="fa fa-calendar"></i>&nbsp;'.$day.'</div>
	';
?>		
    </a>
    <div class="shifts-content">
      <div class="w-row">
        <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
          <div class="am-pm-shifts">AM</div>
        </div>	
        <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10">
          
<?php
$shift_result = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id = '$location_id' AND time = 'AM'");
	while ($row = mysqli_fetch_array($shift_result))
		{
		$time_a = $row[time];
		$overseer_id = $row[overseer_id];
		$pioneer_id = $row[pioneer_id];
		$pioneer_b_id = $row[pioneer_b_id];
		}
	if ($time_a)
		{
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
							<input type="hidden" name="time" value="'.$time_a.'">
							<input class="w-button volunteer-add" type="submit" value="Volunteer">
						</form>
					</div>
					';
				}
			}
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
							<input type="hidden" name="time" value="'.$time_a.'">
							<input class="w-button volunteer-add" type="submit" value="Volunteer">
						</form>
					</div>
					';
				}
			}
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
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
		if($date >= $today)
			{
			echo '
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$date.'">
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
        <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10">
<?php
$shift_result = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id = '$location_id' AND time = 'PM'");
	while ($row = mysqli_fetch_array($shift_result))
		{
		$time_b = $row[time];
		$overseer_id = $row[overseer_id];
		$pioneer_id = $row[pioneer_id];
		$pioneer_b_id = $row[pioneer_b_id];
		}
	if ($time_b)
		{
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
							<input type="hidden" name="time" value="'.$time_b.'">
							<input class="w-button volunteer-add" type="submit" value="Volunteer">
						</form>
					</div>
					';
				}
			}
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
							<input type="hidden" name="time" value="'.$time_b.'">
							<input class="w-button volunteer-add" type="submit" value="Volunteer">
						</form>
					</div>
					';
				}
			}
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
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
		if($date >= $today)
			{
			echo '
				<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
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
<?php
	}
else
	{
?>
  <div class="location-select">
    <div class="w-row">
      <div class="w-col w-col-3 w-col-small-3 w-col-tiny-3">
        <div class="w-form">
<?php
$location_previous_test = mysqli_query($con,"SELECT * FROM locations WHERE id = '$location_previous'");
while ($row = mysqli_fetch_array($location_previous_test))
	{
	$location_backward = $row[id];
	}
if ($location_backward)
	{		
	echo '
			<form class="w-clearfix" id="email-form-2" name="previous" action="day_view.php" method="post">
				<input type="hidden" name="location_id" value="'.$location_backward.'">
				<input type="hidden" name="date" value="'.$date.'">
				<button class="w-button location-back" type="submit"><i class="fa fa-angle-left"></i></button>
			</form>
		';
	}
?>
        </div>
      </div>
      <div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
        <div class="location-text">
<?php		
		echo $location;
?>
		</div>
	  </div>
      <div class="w-col w-col-3 w-col-small-3 w-col-tiny-3">
        <div class="w-form">
<?php
$location_next_test = mysqli_query($con,"SELECT * FROM locations WHERE id = '$location_next'");
while ($row = mysqli_fetch_array($location_next_test))
	{
	$location_forward = $row[id];
	}
if ($location_forward)
	{	
	echo '
		<form id="email-form-2" name="next" action="day_view.php" method="post">
			<input type="hidden" name="location_id" value="'.$location_forward.'">
			<input type="hidden" name="date" value="'.$date.'">
			<button class="w-button location-forward" type="submit"><i class="fa fa-angle-right"></i></button>
		</form>
	';
	}
?>		  	
        </div>
      </div>
    </div>
  </div>
  <div class="content-day-view">
    <div class="shifts-content">
      <a class="w-inline-block date-calandur" href="../shifts/current_month.php">
<?php
		echo '
        <div><i class="fa fa-calendar"></i>&nbsp;'.$day.'</div>
		';
?>		
      </a>
    </div>
    <div class="shifts-content">
      <div class="w-row">
        <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
          <div class="am-pm-shifts">8:30</div>
        </div>	
        <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10">
          
<?php
$shift_result = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id = '$location_id' AND time = '8:30'");
	while ($row = mysqli_fetch_array($shift_result))
		{
		$time_a = $row[time];
		$overseer_id = $row[overseer_id];
		$pioneer_id = $row[pioneer_id];
		$pioneer_b_id = $row[pioneer_b_id];
		}
	if ($time_a)
		{
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
							<input type="hidden" name="time" value="'.$time_a.'">
							<input class="w-button volunteer-add" type="submit" value="Volunteer">
						</form>
					</div>
					';
				}
			}
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
							<input type="hidden" name="time" value="'.$time_a.'">
							<input class="w-button volunteer-add" type="submit" value="Volunteer">
						</form>
					</div>
					';
				}
			}
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
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
		if($date >= $today)
			{
			echo '
				<div class="w-form">
					<form id="email-form" name="email-form" method="post" action="volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$date.'">
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
          <div class="am-pm-shifts">11:30</div>
        </div>
        <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10">
<?php
$shift_result = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id = '$location_id' AND time = '11:30'");
	while ($row = mysqli_fetch_array($shift_result))
		{
		$time_b = $row[time];
		$overseer_id = $row[overseer_id];
		$pioneer_id = $row[pioneer_id];
		$pioneer_b_id = $row[pioneer_b_id];
		}
	if ($time_b)
		{
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
							<input type="hidden" name="time" value="'.$time_b.'">
							<input class="w-button volunteer-add" type="submit" value="Volunteer">
						</form>
					</div>
					';
				}
			}
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
							<input type="hidden" name="time" value="'.$time_b.'">
							<input class="w-button volunteer-add" type="submit" value="Volunteer">
						</form>
					</div>
					';
				}
			}
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
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
		if($date >= $today)
			{
			echo '
				<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
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
          <div class="am-pm-shifts">2:30</div>
        </div>
        <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10">
<?php
$shift_result = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id = '$location_id' AND time = '2:30'");
	while ($row = mysqli_fetch_array($shift_result))
		{
		$time_c = $row[time];
		$overseer_id = $row[overseer_id];
		$pioneer_id = $row[pioneer_id];
		$pioneer_b_id = $row[pioneer_b_id];
		}
	if ($time_c)
		{
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
							<input type="hidden" name="time" value="'.$time_c.'">
							<input class="w-button volunteer-add" type="submit" value="Volunteer">
						</form>
					</div>
					';
				}
			}
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
							<input type="hidden" name="time" value="'.$time_c.'">
							<input class="w-button volunteer-add" type="submit" value="Volunteer">
						</form>
					</div>
					';
				}
			}
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
			if ($date >= $today)
				{
				echo ' 
					<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
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
		if($date >= $today)
			{
			echo '
				<div class="w-form">
						<form id="email-form" name="email-form" method="post" action="volunteer.php">
							<input type="hidden" name="location_id" value="'.$location_id.'">
							<input type="hidden" name="date" value="'.$date.'">
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
<?php
	}
?>
	</body>
</html>