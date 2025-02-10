<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <ol id="olForEach" >
    <li></li>
    <li></li>
    <li></li>
  </ol>
  <input type="button" id="btnRunEach" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunEach')
  ->execute(
    YsJQuery::each()
      ->in('#olForEach > li')
      ->setFunction(
        new YsJsFunction(
          YsJQuery::html(
            YsArgument::value('"Html value. Index = " + index')
          )->in('this')
          ,'index'
        )
      )
  )
?>
</div>