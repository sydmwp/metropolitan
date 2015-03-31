<?php
echo '
	<div class="calendar-date">	
		<div class="w-form form-wrapper">
	';
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

echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
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
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
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
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
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
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
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
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
';
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
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
';
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
echo '
		</div>
	</div>
	';
?>