<?php
$login = $id;
if (!$login)
	{	
	$user = $_POST['user'];
	$password = $_POST['password'];
	if (!$user)
		{
?>
		<!DOCTYPE html>
		<html>
			<head>
<?php
				echo '
				<title>Login</title>
					';
				include('../head.php');
?>
			</head>
			<body>
			  <div class="content-mobile-number">
				<div class="shifts-content">
				  <div class="w-form">
					<form id="email-form" name="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
					  <input class="w-input mobile-text-filled" id="Username" type="text" placeholder="Username" name="user" data-name="Username" required="required">
					  <input class="w-input mobile-text-filled" id="Password-2" type="password" placeholder="Password" name="password" data-name="Password 2" required="required">
					  <input class="w-button submit-mobile-number" type="submit" value="Proceed">
					</form>
				  </div>
				</div>
			  </div>
			</body>
		</html>
<?php
		}
	else
		{
		require('../db.php');
		$pioneer = mysqli_query($con,"SELECT * FROM pioneers WHERE first_name = '$user' AND phone = '$password'");
		while ($row = mysqli_fetch_array($pioneer))
			{
			$id = $row[id];
			}
?>
			<!DOCTYPE html>
			<html>
				<head>
				<body>
					<form id="refresh" name="email-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
<?php
echo '
						<input type="hidden" name="id" value="'.$id.'">
	';		
?>
					</form>
					<script type="text/javascript">
					document.getElementById('refresh').submit();
					</script>
				</body>
				</head>
			</html>
<?php
		}
	}
?>