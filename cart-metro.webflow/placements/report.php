<!DOCTYPE html>
<!-- Last Published: Fri Mar 20 2015 07:17:45 GMT+0000 (UTC) -->
<html data-wf-site="5501f5af8d5d8d533f7660e8" data-wf-page="550b4ba95b7ee5ba660e4dbc">
<head>
<?php
require('../db.php');
$date = date('Y-m-d', strtotime(''));
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
<?php
echo '
		<input class="w-input books square select-date" id="date" type="date" value="2015-01-01" name="date" required="required">
	';
?>
	  <select class="w-select select-shift square" id="Shift-time" name="time" required="required">
          <option value="">Select shift time...</option>
          <option value="AM">AM - Hyde Park</option>
          <option value="PM">PM - Hyde Park</option>
		  <option value="8:30">8:30</option>
		  <option value="11:30">11:30</option>
		  <option value="2:30">2:30</option>
        </select>
        <select class="w-select location-shift square" id="field-2" name="location" required="required">
          <option value="Location">Select your location...</option>
<?php
$result_location = mysqli_query($con,"SELECT * FROM locations WHERE id != '50' ORDER BY name");
while($row = mysqli_fetch_array($result_location))
	{
		$output_location.='<option value="'.$row['name'].'">'.$row['name'].'</option>';
	}
echo $output_location;
?>
        </select>
        <input class="w-input books square" id="books" type="number" placeholder="Books" name="books">
        <input class="w-input magazines square" id="Magazines" type="number" placeholder="Magazines" name="magazines">
        <input class="w-input brochures square" id="Brochures" type="number" placeholder="Brochures" name="brochures">
        <textarea class="w-input comments square" formid="email_form" id="Comments" placeholder="Comments..." name="comments"></textarea>
        <input class="w-button submit square" type="submit" value="Record">
      </form>
    </div>
  </div>
<?php
include('../foot.php');
?>  
  </body>
</html>