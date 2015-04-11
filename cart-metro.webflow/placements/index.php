<?php
require('../db.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php
$date = date('Y-m-d', strtotime('first day of this month'));
include('../head.php');
?>
  <title>Record Placements</title>
</head>
<body>
<?php
include('../menu.php');
?>
  <div class="content-placments">
    <div class="w-form form-wrapper">
      <form id="email-form" name="email-form" action="confirm_placements.php" method="post">
		<input class="w-input books square select-date" id="date" type="date" value="<?php echo $date; ?>" name="date" required="required">
		<select class="w-select location-shift square" id="location_select" name="location" required="required" onchange="times(this.value)">
          <option value="">Select your location...</option>
<?php
$result_location = "SELECT id, name FROM locations WHERE id != ? ORDER BY name";
$other = 50;
$stmt = $con->prepare($result_location);
	$stmt->bind_param('i', $other);
	$stmt->execute();
	$stmt->bind_result($id, $name);
	while ($stmt->fetch())
		{
		echo '
			<option value="'.$id.'">'.$name.'</option>
			';
		}
$stmt->close();	
?>
        </select>
		<select class="w-select select-shift square" id="shift_time" name="time" required="required">
			<option value="">Select time...</option>
        </select>
        <input class="w-input books square" id="books" type="number" placeholder="Books" name="books">
        <input class="w-input magazines square" id="Magazines" type="number" placeholder="Magazines" name="magazines">
        <input class="w-input brochures square" id="Brochures" type="number" placeholder="Brochures" name="brochures">
        <textarea class="w-input comments square" formid="email_form" id="Comments" placeholder="Comments..." name="comments"></textarea>
        <input class="w-button submit square" type="submit" value="Record">
      </form>
    </div>
  </div>
<script>  
function times(int) {
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
     document.getElementById("shift_time").innerHTML = xmlhttp.responseText;
  }
  xmlhttp.open("GET","time.php?location_id="+int,true);
  xmlhttp.send();
};
</script>
 </body>
</html>