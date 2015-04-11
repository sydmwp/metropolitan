<?php
require('../db.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php
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
$today = date('Y-m-d', strtotime('today'));
$first_date = date('Y-m-d', (strtotime('1st '.$month.', '.$year.'')));
if (!$select_date)
	{
	$stmt = $con->prepare($shift_user_select);
		$stmt->bind_param('iii', $user, $user, $user);
		$stmt->execute();
		$stmt->bind_result($shift_date);
		while ($stmt->fetch())
			{
			if ($shift_date >= $today AND $shift_date >= $first_date)
				{
				$select_date = $shift_date;
				}
			}
	$stmt->close();
	}
echo '
	<title>'.$month.' shifts - '.$first_name.'</title>
	';
include('../head.php');
?>
</head>

<?php
if ($user)
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
          <div class="key-text mobile">Confirmed Shift</div>
        </div>
		<div class="w-clearfix key mobile">
          <div class="key-current-date unconfirmed-key"><?php echo date('j');?></div>
          <div class="key-text mobile">Unconfirmed Shift</div>
        </div>
      </nav>
	  <div class="w-nav-button w-clearfix menu-button">
        <div class="icon-key"><i class="fa fa-info-circle"></i></div>
      </div>
	  <div class="w-form w-clearfix form-wrapper-submit">
	  <form class="w-clearfix form-month" id="email-form-3" name="month" action="index.php" method="post">
		<?php
			if ($month == date('F')){
			echo '
			<input type="hidden" value="'.date('F', (strtotime('first day of next month'))).'" name="month">
			<input type="hidden" value="'.date('Y', (strtotime('first day of next month'))).'" name="year">			
			';?>
			<button class="w-button last-month-text" type="submit"><?php echo strtoupper($month);?>&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i></button>
		<?php
			} if ($month == date('F', (strtotime('first day of next month')))){
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
$stmt = $con->prepare($shift_detail);
	$stmt->bind_param('iiis', $user, $user, $user, $select_date);
	$stmt->execute();
	$stmt->bind_result($shift_id, $location_id, $time, $overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
$stmt->close();
if($shift_id)
	{
	$stmt = $con->prepare($location_select);
		$stmt->bind_param('i', $location_id);
		$stmt->execute();
		$stmt->bind_result($location_name);
		$stmt->fetch();
	$stmt->close();
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
	$stmt = $con->prepare($pioneer_select);
		$stmt->bind_param('i', $overseer_id);
		$stmt->execute();
		$stmt->bind_result($first_name, $last_name, $g, $phone);
		$stmt->fetch();
	$stmt->close();	
	echo '
				<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
					<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					<div class="text-volunteer">'.$phone.'</div>
				</div>
				<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
				  <div class="w-form">
		';
				if ($select_date >= $today)
				{
	echo '		
					<form id="email-form-2" name="overseer" method="post" action="confirm_delete.php">
					  <input type="hidden" name="month" value="'.$month.'">
					  <input type="hidden" name="overseer_id" value="'.$overseer_id.'">
					  <input type="hidden" name="shift_id" value="'.$shift_id.'">
					  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
					</form>
		';
				}
	echo '			
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
	$stmt = $con->prepare($pioneer_select);
		$stmt->bind_param('i', $pioneer_id);
		$stmt->execute();
		$stmt->bind_result($first_name, $last_name, $g, $phone);
		$stmt->fetch();
	$stmt->close();	
	echo '
				<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
					<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					<div class="text-volunteer">'.$phone.'</div>
				</div>
				<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
				  <div class="w-form">
		';
				if ($select_date >= $today)
				{
	echo '		
					<form id="email-form-2" name="overseer" method="post" action="confirm_delete.php">
					  <input type="hidden" name="month" value="'.$month.'">
					  <input type="hidden" name="pioneer_id" value="'.$pioneer_id.'">
					  <input type="hidden" name="shift_id" value="'.$shift_id.'">
					  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
					</form>
		';
				}
	echo '
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
	$stmt = $con->prepare($pioneer_select);
		$stmt->bind_param('i', $pioneer_b_id);
		$stmt->execute();
		$stmt->bind_result($first_name, $last_name, $g, $phone);
		$stmt->fetch();
	$stmt->close();	
	echo '
				<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
					<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
					<div class="text-volunteer">'.$phone.'</div>
				</div>
				<div class="w-col w-col-6 w-col-small-6 w-col-tiny-6">
				  <div class="w-form">
		';
				if ($select_date >= $today)
				{
	echo '		
					<form id="email-form-2" name="overseer" method="post" action="confirm_delete.php">
					  <input type="hidden" name="month" value="'.$month.'">
					  <input type="hidden" name="pioneer_b_id" value="'.$pioneer_b_id.'">
					  <input type="hidden" name="shift_id" value="'.$shift_id.'">
					  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
					</form>
		';
				}
	echo '
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
        <div class="am-pm-shifts"><?php echo $time; ?></div>
      </div>
      <div class="w-col w-col-10 w-col-small-10 w-col-tiny-10 column-shifts">
        <div class="volunteer-accepted">
          <div class="w-row">
<?php
if ($overseer_id)
	{
	$stmt = $con->prepare($pioneer_select);
		$stmt->bind_param('i', $overseer_id);
		$stmt->execute();
		$stmt->bind_result($first_name, $last_name, $g, $phone);
		$stmt->fetch();
	$stmt->close();
	echo '
				<div class="w-col w-col-4">
					<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
				 </div>
				<div class="w-col w-col-4">
					<div class="text-volunteer">'.$phone.'</div>
				</div>
				<div class="w-col w-col-4">
				  <div class="w-form">
		';
				if ($select_date >= $today)
				{
	echo '		
					<form id="email-form-2" name="overseer" method="post" action="confirm_delete.php">
					  <input type="hidden" name="month" value="'.$month.'">
					  <input type="hidden" name="overseer_id" value="'.$overseer_id.'">
					  <input type="hidden" name="shift_id" value="'.$shift_id.'">
					  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
					</form>
		';
				}
	echo '
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
	$stmt = $con->prepare($pioneer_select);
		$stmt->bind_param('i', $pioneer_id);
		$stmt->execute();
		$stmt->bind_result($first_name, $last_name, $g, $phone);
		$stmt->fetch();
	$stmt->close();
	echo '
				<div class="w-col w-col-4">
					<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
				 </div>
				<div class="w-col w-col-4">
					<div class="text-volunteer">'.$phone.'</div>
				</div>
				<div class="w-col w-col-4">
				  <div class="w-form">
		';
				if ($select_date >= $today)
				{
	echo '		
					<form id="email-form-2" name="overseer" method="post" action="confirm_delete.php">
					  <input type="hidden" name="month" value="'.$month.'">
					  <input type="hidden" name="pioneer_id" value="'.$pioneer_id.'">
					  <input type="hidden" name="shift_id" value="'.$shift_id.'">
					  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
					</form>
		';
				}
	echo '
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
	$stmt = $con->prepare($pioneer_select);
		$stmt->bind_param('i', $pioneer_b_id);
		$stmt->execute();
		$stmt->bind_result($first_name, $last_name, $g, $phone);
		$stmt->fetch();
	$stmt->close();
	echo '
				<div class="w-col w-col-4">
					<div class="text-volunteer">'.$first_name.' '.$last_name.'</div>
				 </div>
				<div class="w-col w-col-4">
					<div class="text-volunteer">'.$phone.'</div>
				</div>
				<div class="w-col w-col-4">
				  <div class="w-form">
		';
				if ($select_date >= $today)
				{
	echo '		
					<form id="email-form-2" name="overseer" method="post" action="confirm_delete.php">
					  <input type="hidden" name="month" value="'.$month.'">
					  <input type="hidden" name="pioneer_b_id" value="'.$pioneer_b_id.'">
					  <input type="hidden" name="shift_id" value="'.$shift_id.'">
					  <button class="w-button delete-shift" type="submit"><i class="fa fa-trash-o"></i></button>
					</form>
		';
				}
	echo '
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
?>
  </body>
</html>