<?php
require('../db.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php
include('../head.php');
?>
  <title>Manage Pioneers</title>
  <script type="text/javascript">
   $(document).ready(function () {
       $('#last_name').keyup(function () { alert('test'); });
   });
</script>
</head>
<body>
<?php
include('../menu.php');
?>
  <div class="content-placments">
    <div class="w-form form-wrapper">
      <form id="email-form" name="email-form" action="confirm_pioneer.php" method="post">
		<input class="w-input books square select-date" id="first_name" type="text" placeholder="First Name" name="first_name" required="required">
		<input class="w-input books square select-date" id="last_name" type="text" placeholder="Last Name" name="last_name" required="required">
	    <select class="w-select select-shift square" id="gender" name="gender" required="required">
          <option value="">Gender...</option>
          <option value="m">Male</option>
          <option value="f">Female</option>
        </select>
        <input class="w-input books square" id="books" type="tel" placeholder="Phone" name="phone" required="required">
        <input class="w-input magazines square" id="Magazines" type="email" placeholder="Email" name="email">
        <input class="w-input brochures square" id="Brochures" type="text" placeholder="Congregation" name="congregation">		
		<select class="w-select select-shift square" id="married" name="spouse">
		  <option value="">Married to...</option> 
		</select>
        <textarea class="w-input comments square" formid="email_form" id="Comments" placeholder="Comments..." name="comments"></textarea>
        <input class="w-button submit square" type="submit" value="Record">
      </form>
    </div>
  </div>
 </body>
</html>