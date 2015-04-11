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
	$result++;
	$full_count = null;
	$unconfirmed = null;
	$output_class = null;
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}
		if ($result == $date_selected)
			{
			$output_class.= ' date-selected';
			}
		else
			{
			$full_count = 0;
			$stmt = $con->prepare($day_check);
				$stmt->bind_param('s', $date);
				$stmt->execute();
				$stmt->bind_result($confirmed, $full);
				while ($stmt->fetch())
					{
					if ($full)
						{
						++$full_count;
						}
					if (!$confirmed)
						{
						$unconfirmed = 'y';
						}
					}
			$stmt->close();
			if ($full_count == $max_shifts)
				{
				$output_class.= ' shift-full';
				}
			elseif ($date >= $today AND $unconfirmed)
				{
				$output_class.= ' unconfirmed';
				}
			else
				{
				$output_class.= ' shift-available';
				}
			}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="index.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$full_count = null;
	$unconfirmed = null;
	$output_class = null;
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}
		if ($result == $date_selected)
			{
			$output_class.= ' date-selected';
			}
		else
			{
			$full_count = 0;
			$stmt = $con->prepare($day_check);
				$stmt->bind_param('s', $date);
				$stmt->execute();
				$stmt->bind_result($confirmed, $full);
				while ($stmt->fetch())
					{
					if ($full)
						{
						++$full_count;
						}
					if (!$confirmed)
						{
						$unconfirmed = 'y';
						}
					}
			$stmt->close();
			if ($full_count == $max_shifts)
				{
				$output_class.= ' shift-full';
				}
			elseif ($date >= $today AND $unconfirmed)
				{
				$output_class.= ' unconfirmed';
				}
			else
				{
				$output_class.= ' shift-available';
				}
			}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="index.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$full_count = null;
	$unconfirmed = null;
	$output_class = null;
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}
		if ($result == $date_selected)
			{
			$output_class.= ' date-selected';
			}
		else
			{
			$full_count = 0;
			$stmt = $con->prepare($day_check);
				$stmt->bind_param('s', $date);
				$stmt->execute();
				$stmt->bind_result($confirmed, $full);
				while ($stmt->fetch())
					{
					if ($full)
						{
						++$full_count;
						}
					if (!$confirmed)
						{
						$unconfirmed = 'y';
						}
					}
			$stmt->close();
			if ($full_count == $max_shifts)
				{
				$output_class.= ' shift-full';
				}
			elseif ($date >= $today AND $unconfirmed)
				{
				$output_class.= ' unconfirmed';
				}
			else
				{
				$output_class.= ' shift-available';
				}
			}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="index.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$full_count = null;
	$unconfirmed = null;
	$output_class = null;
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
	';
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}
		if ($result == $date_selected)
			{
			$output_class.= ' date-selected';
			}
		else
			{
			$full_count = 0;
			$stmt = $con->prepare($day_check);
				$stmt->bind_param('s', $date);
				$stmt->execute();
				$stmt->bind_result($confirmed, $full);
				while ($stmt->fetch())
					{
					if ($full)
						{
						++$full_count;
						}
					if (!$confirmed)
						{
						$unconfirmed = 'y';
						}
					}
			$stmt->close();
			if ($full_count == $max_shifts)
				{
				$output_class.= ' shift-full';
				}
			elseif ($date >= $today AND $unconfirmed)
				{
				$output_class.= ' unconfirmed';
				}
			else
				{
				$output_class.= ' shift-available';
				}
			}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="index.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$full_count = null;
	$unconfirmed = null;
	$output_class = null;
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
';
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}
		if ($result == $date_selected)
			{
			$output_class.= ' date-selected';
			}
		else
			{
			$full_count = 0;
			$stmt = $con->prepare($day_check);
				$stmt->bind_param('s', $date);
				$stmt->execute();
				$stmt->bind_result($confirmed, $full);
				while ($stmt->fetch())
					{
					if ($full)
						{
						++$full_count;
						}
					if (!$confirmed)
						{
						$unconfirmed = 'y';
						}
					}
			$stmt->close();
			if ($full_count == $max_shifts)
				{
				$output_class.= ' shift-full';
				}
			elseif ($date >= $today AND $unconfirmed)
				{
				$output_class.= ' unconfirmed';
				}
			else
				{
				$output_class.= ' shift-available';
				}
			}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="index.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$full_count = null;
	$unconfirmed = null;
	$output_class = null;
echo '
        </div>
    </div>
    <div class="calendar-date">
        <div class="w-form form-wrapper">
';
	$date = date('Y\-m\-d', (strtotime("$result $month this year")));
	if ($month == date('F') AND $result == date('j'))
			{
			$output_class.= ' current-date';
			}
		if ($result == $date_selected)
			{
			$output_class.= ' date-selected';
			}
		else
			{
			$full_count = 0;
			$stmt = $con->prepare($day_check);
				$stmt->bind_param('s', $date);
				$stmt->execute();
				$stmt->bind_result($confirmed, $full);
				while ($stmt->fetch())
					{
					if ($full)
						{
						++$full_count;
						}
					if (!$confirmed)
						{
						$unconfirmed = 'y';
						}
					}
			$stmt->close();
			if ($full_count == $max_shifts)
				{
				$output_class.= ' shift-full';
				}
			elseif ($date >= $today AND $unconfirmed)
				{
				$output_class.= ' unconfirmed';
				}
			else
				{
				$output_class.= ' shift-available';
				}
			}
	echo '
		<form id="email-form" name="shifts_day_view" method="post" action="index.php">
			<input type="hidden" name="select_date" value="'.$date.'">
			<input type="hidden" name="month" value="'.$month.'">
			<input class="w-button dates '.$output_class.'" type="submit" value="'.$result.'">
		</form>
		';
	$result++;
	$full_count = null;
	$unconfirmed = null;
	$output_class = null;
echo '
		</div>
	</div>
	';
?>