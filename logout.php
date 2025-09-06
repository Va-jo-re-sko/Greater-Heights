<?php
session_start();
session_unset();
session_destroy();

// Remove remember me cookie
setcookie('remember_email', '', time() - 3600, "/");

header("Location: login.html");
exit;
?>
