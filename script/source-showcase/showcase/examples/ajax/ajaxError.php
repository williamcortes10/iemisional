<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Get Data" id="btnAjaxError" />
<div style="color:red" id="logForAjaxError">
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnAjaxError')
  ->execute(
    YsJQuery::ajax()
      ->_url('a404response.url')
      ->_success(
        new YsJsFunction('alert(response)','response')
      )
  )
?>
<?php
echo
YsJQuery::ajaxError()
  ->in('#btnAjaxError')
  ->handler(
   YsJQuery::html()->in('#logForAjaxError')
                   ->value('Error on the AJAX Call')
  )
  ->executeOnReady();
?>
</div>