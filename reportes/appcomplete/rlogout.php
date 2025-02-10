<?php
session_start();
ob_start();
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php
if (@$_COOKIE[EW_REPORT_PROJECT_NAME]['AutoLogin'] == "") // Not autologin
	setcookie(EW_REPORT_PROJECT_NAME . '[UserName]', ""); // Clear user name cookie
setcookie(EW_REPORT_PROJECT_NAME . '[Password]', ""); // Clear password cookie
setcookie(EW_REPORT_PROJECT_NAME . '[LastUrl]', ""); // Clear last url

// Unset all of the session variables
$_SESSION = array();

// Delete the session cookie and kill the session
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-42000, '/');
}

// Finally, destroy the session
@session_destroy();
header("Location: rlogin.php");
exit();
?>
