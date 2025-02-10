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
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php
$bValidPwd = FALSE;
$sUsername = "";
$sPassword = "";

// Open connection to the database
$conn = ewrpt_Connect();
if (!IsLoggedIn()) AutoLogin(); // Auto login
$sLastUrl = LastUrl();
if ($sLastUrl == "")
	$sLastUrl = "reporteusuarios.php";
if (@$_POST["submit"] <> "") {
	$bValidPwd = FALSE;

	// Setup variables
	$sUsername = ewrpt_StripSlashes(@$_POST["username"]);
	$sPassword = ewrpt_StripSlashes(@$_POST["password"]);
	if (ValidateUser($sUsername, $sPassword)) {

		// Write cookies
		$sLoginType = strtolower(@$_POST["rememberme"]);
		$expirytime = time() + 365*24*60*60; // change cookie expiry time here
		if ($sLoginType == "a") {
			setcookie(EW_REPORT_PROJECT_NAME . '[AutoLogin]', "autologin", $expirytime);
			setcookie(EW_REPORT_PROJECT_NAME . '[UserName]', $sUsername, $expirytime);
			setcookie(EW_REPORT_PROJECT_NAME . '[Password]', TEAencrypt($sPassword, EW_REPORT_RANDOM_KEY), $expirytime);
		} elseif ($sLoginType == "u") {
			setcookie(EW_REPORT_PROJECT_NAME . '[AutoLogin]', "rememberusername", $expirytime);
			setcookie(EW_REPORT_PROJECT_NAME . '[UserName]', $sUsername, $expirytime);
		} else {
			setcookie(EW_REPORT_PROJECT_NAME . '[AutoLogin]', "", $expirytime);
		}
		$_SESSION[EW_REPORT_SESSION_STATUS] = "login";
		ob_end_clean();
		header("Location: $sLastUrl");
		exit();
	} else {
		$_SESSION[EW_REPORT_SESSION_MESSAGE] = "Incorrect user ID or password";
	}
} else {
	if (IsLoggedIn()) {
		if (@$_SESSION[EW_REPORT_SESSION_MESSAGE] == "") {
			ob_end_clean();
			header("Location: $sLastUrl");
			exit();
		}
	}
}
?>
<?php include "phprptinc/header.php"; ?>
<script type="text/javascript" src="phprptjs/ewrpt.js"></script>
<script type="text/javascript">

function ewrpt_ValidateLoginForm(form_obj) {
	if (!ewrpt_HasValue(form_obj.username)) {
		if  (!ewrpt_OnError(form_obj.username, "Please enter user ID"))
			return false;
	}
	if (!ewrpt_HasValue(form_obj.password)) {
		if (!ewrpt_OnError(form_obj.password, "Please enter password"))
			return false;
	}
	return true;
}
</script>
<table><tr><td>
<p><span class="phpreportmaker">Login Page</span></p>
<?php
if (@$_SESSION[EW_REPORT_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewMessage"><?php echo $_SESSION[EW_REPORT_SESSION_MESSAGE]; ?></span></p>
<?php
	$_SESSION[EW_REPORT_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="rlogin.php" method="post" onSubmit="return ewrpt_ValidateLoginForm(this);">
<table border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td><span class="phpreportmaker">User Name</span></td>
		<td><span class="phpreportmaker"><input type="text" name="username" size="20" value="<?php echo ewrpt_HtmlEncode(ewrpt_StripSlashes(@$_COOKIE[EW_REPORT_PROJECT_NAME]['UserName'])) ?>"></span></td>
	</tr>
	<tr>
		<td><span class="phpreportmaker">Password</span></td>
		<td><span class="phpreportmaker"><input type="password" name="password" size="20"></span></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><span class="phpreportmaker">
		<?php if (@$_COOKIE[EW_REPORT_PROJECT_NAME]['AutoLogin'] == "autologin") { ?>
		<input type="radio" name="rememberme" value="a" checked>Auto login until I logout explicitly<br /><input type="radio" name="rememberme" value="u">Save my user name<br /><input type="radio" name="rememberme" value="n">Always ask for my user name and password
		<?php } elseif (@$_COOKIE[EW_REPORT_PROJECT_NAME]['AutoLogin'] == "rememberusername") { ?>
		<input type="radio" name="rememberme" value="a">Auto login until I logout explicitly<br /><input type="radio" name="rememberme" value="u" checked>Save my user name<br /><input type="radio" name="rememberme" value="n">Always ask for my user name and password
		<?php } else { ?>
		<input type="radio" name="rememberme" value="a">Auto login until I logout explicitly<br /><input type="radio" name="rememberme" value="u">Save my user name<br /><input type="radio" name="rememberme" value="n" checked>Always ask for my user name and password
		<?php } ?>
		</span></td>
	</tr>
	</tr>
	<tr>
		<td colspan="2" align="center"><span class="phpreportmaker"><input type="submit" name="submit" value="Login"></span></td>
	</tr>
</table>
</form>
<br />
</td></tr></table>
<?php

// Close connection
$conn->Close();
?>
<?php include "phprptinc/footer.php"; ?>
