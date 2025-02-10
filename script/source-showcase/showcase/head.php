<?php error_reporting(E_ALL) // Configuration optional?> 
<?php ini_set('display_errors', 1) // Configuration optional?>
<?php include_once('php_tags.php')// Configuration optional?>

<?php
//Required to load the jQuery4PHP library
include_once dirname(__FILE__) . '/../lib/YepSua/Labs/RIA/jQuery4PHP/YsJQueryAutoLoader.php';
YsJQueryAutoLoader::register();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>jQuery4PHP</title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <script type="text/javascript" src="/jquery4php/public_html/js/jquery.min.js"></script>
  </head>
  <body>