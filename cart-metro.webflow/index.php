<?php
require('db.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php
include('head.php');
?>
  <title>Metro</title>
</head>
<body>
  <div class="full-page">
    <a class="w-inline-block home-section placements" href="placements">
      <div class="home-content">
        <div><i class="fa fa-book"></i> PLACEMENTS</div>
      </div>
    </a>
    <a class="w-inline-block home-section bookings" href="shifts">
      <div class="home-content">
        <div><i class="fa fa-calendar"></i> BOOKINGS</div>
      </div>
    </a>
    <a class="w-inline-block home-section my-shifts" href="myshifts">
      <div class="home-content">
        <div><i class="fa fa-search"></i> MY SHIFTS</div>
      </div>
    </a>
  </div>
</body>
</html>