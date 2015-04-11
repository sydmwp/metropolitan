  <div class="w-nav uni-nav" data-collapse="all" data-animation="over-left" data-duration="300" data-contain="1">
    <div class="w-container main-nav-container">
      <a class="w-nav-brand" href="../index.php">
        <div class="logo-text">SYDNEY METROPOLITAN</div>
      </a>
      <nav class="w-nav-menu main-nav-pull-out" role="navigation">
		<a class="w-nav-link nav-link" href="../index.php">HOME</a>
		<a class="w-nav-link nav-link" href="../placements">PLACEMENTS</a>
		<a class="w-nav-link nav-link" href="../shifts">BOOKINGS</a>
		<a class="w-nav-link nav-link" href="../myshifts">MY SHIFTS</a>
<?php
if ($user == 122 || $user == 72)
	{
?>
		<a class="w-nav-link nav-link" href="../stats">STATS</a>
		<a class="w-nav-link nav-link" href="../pioneers">PIONEERS</a>
<?php
	}
else
	{
?>
		<a class="w-nav-link nav-link" href="../contact">CONTACT</a>
<?php
	}
?>
		<a class="w-nav-link nav-link" href="../logout.php">LOG OUT</a>
      </nav>
      <div class="w-nav-button menu-burger">
        <div class="w-icon-nav-menu icon-burger"></div>
      </div>
    </div>
  </div>