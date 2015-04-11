<?php
require('../db.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php
$overseer = $_POST['overseer_id'];
$pioneer = $_POST['pioneer_id'];
$pioneer_b = $_POST['pioneer_b_id'];
$shift_id = $_POST['shift_id'];

$month = $_POST['month'];
$stmt = $con->prepare($empty_check);
	$stmt->bind_param('i', $shift_id);
	$stmt->execute();
	$stmt->bind_result($overseer_id, $pioneer_id, $pioneer_b_id);
	$stmt->fetch();
$stmt->close();
if ($pioneer_id)
	{
	$stmt = $con->prepare($pioneer_select);
		$stmt->bind_param('i', $pioneer_id);
		$stmt->execute();
		$stmt->bind_result($f, $l, $gender_a, $p);
		$stmt->fetch();
	$stmt->close();
	}
if ($pioneer_b_id)
	{
	$stmt = $con->prepare($pioneer_select);
		$stmt->bind_param('i', $pioneer_b_id);
		$stmt->execute();
		$stmt->bind_result($f, $l, $gender_b, $p);
		$stmt->fetch();
	$stmt->close();
	}
if ($overseer)
	{
	$overseer_id = "";
	if ($gender_a =="m")
		{
		$overseer_id = $pioneer_id;
		$pioneer_id = null;
		if ($pioneer_b_id)
			{
			$pioneer_id = $pioneer_b_id;
			$pioneer_b_id = null;
			}
		}
	elseif ($gender_b =="m")
		{
		$overseer_id = $pioneer_b_id;
		$pioneer_b_id = null;
		}
	}
elseif ($pioneer)
	{
	$pioneer_id = "";
	if ($pioneer_b_id)
		{
		$pioneer_id = $pioneer_b_id;
		$pioneer_b_id = null;
		}
	}
elseif ($pioneer_b)
	{
	$pioneer_b_id = null;
	}
if ($overseer_id)
	{
	if ($pioneer_id && !$pioneer_b_id)
		{
		$stmt = $con->prepare($pioneer_select);
			$stmt->bind_param('i', $pioneer_id);
			$stmt->execute();
			$stmt->bind_result($f, $l, $gender, $p);
			$stmt->fetch();
		$stmt->close();
		if ($gender == "f")
			{
			$stmt = $con->prepare($couple_select);
				$stmt->bind_param('ii', $overseer_id, $pioneer_id);
				$stmt->execute();
				$stmt->bind_result($couple_id);
				$stmt->fetch();
			$stmt->close();
			if ($couple_id)
				{
				$confirmed = "y";
				}
			else
				{
				$confirmed = null;
				}
			}
		else
			{
			$confirmed = "y";
			}
		}
	else
		{
		$confirmed = null;
		}	
	}
else
	{
	$confirmed = null;
	}
if (!$overseer_id && !$pioneer_id && !$pioneer_b_id)
	{
	$stmt = $con->prepare($shift_delete);
		$stmt->bind_param('i', $shift_id);
		$stmt->execute();
	$stmt->close();
	}
else
	{
	if (!$overseer_id) {$overseer_id = "";}
	if (!$pioneer_id) {$pioneer_id = "";}
	if (!$pioneer_b_id) {$pioneer_b_id = "";}
	if (!$confirmed) {$confirmed = "";}
	if (!$full) {$full = "";}
	$stmt = $con->prepare($shift_update);
		$stmt->bind_param('iiissi', $overseer_id, $pioneer_id, $pioneer_b_id, $full, $confirmed, $shift_id);
		$stmt->execute();
	$stmt->close();
	}
echo '
	<title>Shift updated</title>
	';
include('../head.php');
?>
</head>
<body class="confirmed-placements">
<?php
include('../menu.php');
?>
  <div class="confirmed-tick" data-ix="confirmed">
    <div><i class="fa fa-check"></i></div>
  </div>
  <div class="thankyou">
    <div>Thank you</div>
  </div>
  <div class="placements-entered">
    <div>The shift has been updated</div>
  </div>
  <div class="back-to-my-shifts-div">
    <div class="w-form">
      <form id="email-form" name="email-form" data-name="Email Form" action="index.php" method="post">
<?php	
echo '
		<input type="hidden" name="month" value="'.$month.'">
	';
?>
        <input class="w-button back-to-my-shifts-button" type="submit" value="Back to my shifts">
      </form>
    </div>
  </div>
</body>
</html>