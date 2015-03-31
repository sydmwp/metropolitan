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
	if ($result == $date_selected)
		{
		$output_class.= ' date-selected';
		}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$output_class = "";
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
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
	if ($result == $date_selected)
		{
		$output_class.= ' date-selected';
		}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$output_class = "";
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
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
	if ($result == $date_selected)
		{
		$output_class.= ' date-selected';
		}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$output_class = "";
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
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
	if ($result == $date_selected)
		{
		$output_class.= ' date-selected';
		}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$output_class = "";
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
';
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
	if ($result == $date_selected)
		{
		$output_class.= ' date-selected';
		}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$output_class = "";
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
';
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
	if ($result == $date_selected)
		{
		$output_class.= ' date-selected';
		}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="calendar.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$output_class = "";
echo '
		</div>
	</div>
	';
?>