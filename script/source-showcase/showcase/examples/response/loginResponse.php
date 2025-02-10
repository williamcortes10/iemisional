<?php
if($_REQUEST['user'] == 'admin' && $_REQUEST['pass'] == 'admin'){
  echo "Authenticated";
}else{
  echo "Try again";
}