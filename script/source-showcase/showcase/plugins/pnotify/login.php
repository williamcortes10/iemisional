<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_PNOTYFY); ?>

<div id="login">
  <form method="post" action="" class="pf-form pform_custom">
    <h2>Login to Continue</h2>
    <p>Try: admin - admin</p>
    <table>
      <tr>
        <td><span class="pf-label">Username: </span></td>
        <td><input type="text" id="txtUser" name="username" class="pf-field ui-widget-content"></td>
      </tr>
      <tr>
        <td><span class="pf-label">Password: </span></td>
        <td><input type="password" id="txtPass" name="password" class="pf-field ui-widget-content"></td>
      </tr>
    </table>
    <input type="button" id="btnSubmit" value="Submit" name="submit" class="pf-button ui-state-default ui-corner-all ui-priority-primary">
    <input type="reset" value="Reset" name="reset" class="pf-button ui-state-default ui-corner-all ui-priority-secondary">
  </form>
</div>

<?php
echo
YsJQuery::click()
  ->in('#btnSubmit')
  ->handler(
    YsJQuery::get(
    'examples/response/loginResponse.php',
    array('user' => YsJQuery::val()->in('#txtUser'),
          'pass' => YsJQuery::val()->in('#txtPass')),
     new YsJsFunction(YsPNotify::build(YsArgument::likeVar('response')), 'response')
    )
  )->execute();
?>

<!------------------------------------------------------------------------------
LOGIN PHP CODE - SERVER SIDE

if($_REQUEST['user'] == 'admin' && $_REQUEST['pass'] == 'admin'){
  echo "Authenticated";
}else{
  echo "Try again";
}
------------------------------------------------------------------------------->