<!DOCTYPE html>
<html>
<head>
<?php
require('../db.php');
?>
  <title>Metro</title>
<?php
include('../head.php');
?>
</head>
<body>
<?php
include('../menu.php');
?>
  <div class="content-mobile-number">
    <div class="shifts-content">
      <div class="w-form">
        <form id="email-form" name="email-form" action="calendar.php" method="post">
			<input class="w-input mobile-text-filled square" id="Mobile-number" type="tel" placeholder="Enter your mobile number" name="phone" required="required">
			<input class="w-button submit-mobile-number square" type="submit" value="Proceed">
		</form>
	  </div>
    </div>
  </div>
  </body>
</html>