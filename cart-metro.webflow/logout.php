<?php
$expiry = time() - 3600;
unset($_COOKIE["login"]);
setcookie("login","",$expiry);
header("Location:index.php");
exit();
?>