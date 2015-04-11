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
$today = date('Y-m-d', strtotime('today'));
$select_date = $_POST['select_date'];
$date_selected = date('j', strtotime($select_date));
if (!$select_date)
	{
	$select_date = date('Y-m-d', strtotime('today'));
	$date_selected = null;
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
          <div class="no-shifts"><?php echo date('j');?></div>
          <div class="key-text mobile">No Shifts</div>
        </div>
        <div class="key mobile">
          <div class="key-current-date"><?php echo date('j');?></div>
          <div class="key-text mobile">Current Date</div>
        </div>
		<div class="w-clearfix key mobile">
          <div class="key-current-date unconfirmed-green"><?php echo date('j');?></div>
          <div class="key-text mobile">Unconfirmed Shift</div>
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
		$result++;
		$output_class = null;
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
		$result++;
		$full_count = null;
		$unconfirmed = null;
		$output_class = null;
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
		if ($result == $date_selected)
			{
			$output_class.= ' date-selected';
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
		}
?>
        </div>
      </div><div class="calendar-date">
        <div class="w-form form-wrapper">
<?php
	if ($result <= $days)
		{
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
  <div class="date-quickview"><?php echo date('l d F', strtotime($select_date)); ?></div>
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
$time = "AM";
$stmt = $con->prepare($shift_record_select);
	$stmt->bind_param('sis', $select_date, $location_id, $time);
	$stmt->execute();
	$stmt->bind_result($id, $overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
$stmt->close();
if ($id)
	{
	if ($overseer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $overseer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_b_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	$id = null;
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="'.$time.'">
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
$time = "PM";
$stmt = $con->prepare($shift_record_select);
	$stmt->bind_param('sis', $select_date, $location_id, $time);
	$stmt->execute();
	$stmt->bind_result($id, $overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
$stmt->close();
if ($id)
	{
	if ($overseer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $overseer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_b_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	$id = null;
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="'.$time.'">
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
$time = "8:30";
$stmt = $con->prepare($shift_record_select);
	$stmt->bind_param('sis', $select_date, $location_id, $time);
	$stmt->execute();
	$stmt->bind_result($id, $overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
$stmt->close();
if ($id)
	{
	if ($overseer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $overseer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_b_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	$id = null;
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="'.$time.'">
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
$time = "11:30";
$stmt = $con->prepare($shift_record_select);
	$stmt->bind_param('sis', $select_date, $location_id, $time);
	$stmt->execute();
	$stmt->bind_result($id, $overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
$stmt->close();
if ($id)
	{
	if ($overseer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $overseer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_b_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	$id = null;
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="'.$time.'">
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
$time = "2:30";
$stmt = $con->prepare($shift_record_select);
	$stmt->bind_param('sis', $select_date, $location_id, $time);
	$stmt->execute();
	$stmt->bind_result($id, $overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
$stmt->close();
if ($id)
	{
	if ($overseer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $overseer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_b_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	$id = null;
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="'.$time.'">
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
$time = "8:30";
$stmt = $con->prepare($shift_record_select);
	$stmt->bind_param('sis', $select_date, $location_id, $time);
	$stmt->execute();
	$stmt->bind_result($id, $overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
$stmt->close();
if ($id)
	{
	if ($overseer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $overseer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_b_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	$id = null;
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="'.$time.'">
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
$time = "11:30";
$stmt = $con->prepare($shift_record_select);
	$stmt->bind_param('sis', $select_date, $location_id, $time);
	$stmt->execute();
	$stmt->bind_result($id, $overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
$stmt->close();
if ($id)
	{
	if ($overseer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $overseer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_b_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	$id = null;
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="'.$time.'">
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
$time = "2:30";
$stmt = $con->prepare($shift_record_select);
	$stmt->bind_param('sis', $select_date, $location_id, $time);
	$stmt->execute();
	$stmt->bind_result($id, $overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
$stmt->close();
if ($id)
	{
	if ($overseer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $overseer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	if ($pioneer_b_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_b_id);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $g, $phone);
			$stmt->fetch();
		$stmt->close();
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
					<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
						<input type="hidden" name="location_id" value="'.$location_id.'">
						<input type="hidden" name="date" value="'.$select_date.'">
						<input type="hidden" name="time" value="'.$time.'">
						<input class="w-button volunteer-add" type="submit" value="Volunteer">
					</form>
				</div>
				';
			}
		}
	$id = null;
	}
else
	{
	if($select_date >= $today)
		{
		echo '
			<div class="w-form">
				<form id="email-form" name="email-form" method="post" action="confirm_volunteer.php">
					<input type="hidden" name="location_id" value="'.$location_id.'">
					<input type="hidden" name="date" value="'.$select_date.'">
					<input type="hidden" name="time" value="'.$time.'">
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