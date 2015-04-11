<?php
require('../db.php');
echo '
	<option value="">Select time...</option>
';
$location_select = $_GET['location_id'];
$query = "SELECT id, time FROM times WHERE location_id = ? ORDER BY id";
$stmt=$con->prepare($query);
	$stmt->bind_param('i', $location_select);
	$stmt->execute();
	$stmt->bind_result($id, $time);
	while ($stmt->fetch())
		{
		echo '
			<option value="'.$time.'">'.$time.'</option>
			';
		}
$stmt->close();
?>