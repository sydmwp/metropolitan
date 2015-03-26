<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/webflow.css">
  <link rel="stylesheet" type="text/css" href="../css/cart-metro.css">
  <link rel="stylesheet" type="text/css" href="../fonts/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/webflow.js"></script>
</head>
<?php
if (isset($_POST['date'] === true)
	{
	$con=mysqli_connect("localhost","sydmw721_admin","1914CE","sydmw721_sydmwp");
	if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$shift_result = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id == 1 AND time = 'AM'");
	while ($row = mysqli_fetch_array($shift_result))
		{
		$location_id = $row[location_id];
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
						<input type="hidden" name="time" value="PM">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	$shift_result = mysqli_query($con,"SELECT * FROM shifts WHERE date = '$date' AND location_id == 1 AND time = 'PM'");
	while ($row = mysqli_fetch_array($shift_result))
		{
		$location_id = $row[location_id];
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
	}
