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
	$stmt = $con->prepare($shift_test);
		$stmt->bind_param('siii', $date, $user, $user, $user);
		$stmt->execute();
		$stmt->bind_result($shift, $confirmed);
		$stmt->fetch();
	$stmt->close();
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button';
			if ($confirmed == 'y')
				{
				$output_class.= ' shift-full my-shift';
				}
			else
				{
				$output_class.= ' unconfirmed';
				}
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="index.php">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			$confirmed = null;
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
	$stmt = $con->prepare($shift_test);
		$stmt->bind_param('siii', $date, $user, $user, $user);
		$stmt->execute();
		$stmt->bind_result($shift, $confirmed);
		$stmt->fetch();
	$stmt->close();
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button';
			if ($confirmed == 'y')
				{
				$output_class.= ' shift-full my-shift';
				}
			else
				{
				$output_class.= ' unconfirmed';
				}
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="index.php">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			$confirmed = null;
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
	$stmt = $con->prepare($shift_test);
		$stmt->bind_param('siii', $date, $user, $user, $user);
		$stmt->execute();
		$stmt->bind_result($shift, $confirmed);
		$stmt->fetch();
	$stmt->close();
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button';
			if ($confirmed == 'y')
				{
				$output_class.= ' shift-full my-shift';
				}
			else
				{
				$output_class.= ' unconfirmed';
				}
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="index.php">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			$confirmed = null;
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
	$stmt = $con->prepare($shift_test);
		$stmt->bind_param('siii', $date, $user, $user, $user);
		$stmt->execute();
		$stmt->bind_result($shift, $confirmed);
		$stmt->fetch();
	$stmt->close();
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button';
			if ($confirmed == 'y')
				{
				$output_class.= ' shift-full my-shift';
				}
			else
				{
				$output_class.= ' unconfirmed';
				}
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="index.php">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			$confirmed = null;
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
	$stmt = $con->prepare($shift_test);
		$stmt->bind_param('siii', $date, $user, $user, $user);
		$stmt->execute();
		$stmt->bind_result($shift, $confirmed);
		$stmt->fetch();
	$stmt->close();
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button';
			if ($confirmed == 'y')
				{
				$output_class.= ' shift-full my-shift';
				}
			else
				{
				$output_class.= ' unconfirmed';
				}
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="index.php">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			$confirmed = null;
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
	$stmt = $con->prepare($shift_test);
		$stmt->bind_param('siii', $date, $user, $user, $user);
		$stmt->execute();
		$stmt->bind_result($shift, $confirmed);
		$stmt->fetch();
	$stmt->close();
		if ($month == date('F') AND $result == date('j'))
			{
			$output_class = 'w-button current-date';
			}
		if ($shift)
			{
			$output_class.= ' w-button';
			if ($confirmed == 'y')
				{
				$output_class.= ' shift-full my-shift';
				}
			else
				{
				$output_class.= ' unconfirmed';
				}
			echo '
				<div class="w-form form-wrapper">
					<form id="email-form" name="shifts_day_view" method="post" action="index.php">
						<input type="hidden" name="select_date" value="'.$date.'">
						<input type="hidden" name="month" value="'.$month.'">
						<input type="hidden" name="year" value="'.$year.'">
						<input class="'.$output_class.'" type="submit" value="'.$result.'">
					</form>
				</div>
			';
			$shift = null;
			$confirmed = null;
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