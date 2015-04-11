<?php
include('queries.php');
if(isset($_POST['login_button']))
	{
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$con=mysqli_connect("localhost","sydmw721_admin","1914CE","sydmw721_sydmwp");
	if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	$stmt = $con->prepare("SELECT id FROM pioneers WHERE first_name = ? AND phone = ?");
		$stmt->bind_param('ss', $user, $pass);
		$stmt->execute();
		$stmt->bind_result($id);
		$stmt->fetch();
	$stmt->close();
	if ($id)
		{
		$expiry = time() + 60 * 60 * 24 * 30;
		setcookie("login",$id,$expiry);
		header("Location:index.php");
		exit();
		}
	else
		{
?>
		<!DOCTYPE html>
		<html>
		<head>
<?php
echo '
			<title>Login</title>
	';
include('head.php');
?>
		</head>
		<body>
		  <div class="content-mobile-number">
			<div class="shifts-content">
			  <div class="w-form">
				Sorry, login failed. Please try again.
				<br>
				<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" id="email-form" name="email-form" data-name="Email Form">
				  <input class="w-input mobile-text-filled square" id="Username" type="text" placeholder="Username" name="user" data-name="Username" required="required">
				  <input class="w-input mobile-text-filled square" id="Password-2" type="password" placeholder="Password" name="pass" data-name="Password 2" required="required">
				  <input class="w-button submit-mobile-number square" type="submit" name="login_button" value="Proceed">
				</form>
			  </div>
			</div>
		  </div>
		</body>
		</html>
<?php			
		exit();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<?php
echo '
	<title>Login</title>
	';
include('head.php');
?>
</head>
<body>
  <div class="content-mobile-number">
    <div class="shifts-content">
      <div class="w-form">
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" id="email-form" name="email-form" data-name="Email Form">
          <input class="w-input mobile-text-filled square" id="Username" type="text" placeholder="Username" name="user" data-name="Username" required="required">
          <input class="w-input mobile-text-filled square" id="Password-2" type="password" placeholder="Password" name="pass" data-name="Password 2" required="required">
          <input class="w-button submit-mobile-number square" type="submit" name="login_button" value="Proceed">
        </form>
      </div>
    </div>
  </div>
</body>
</html>