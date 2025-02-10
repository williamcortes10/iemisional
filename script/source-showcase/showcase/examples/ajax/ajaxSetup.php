<pre>
  YsJQuery::newInstance()
    ->execute(
      YsJQuery::ajaxSetup()
        ->_url('examples/response/ajaxResponse.php')
        ->_success(
            new YsJsFunction('alert(response)','response')
          )
    )

  //OR
  
  YsJQuery::ajaxSetup()
    ->_url('examples/response/ajaxResponse.php')
    ->_success(
        new YsJsFunction('alert(response)','response')
      )
  ->executeOnReady()
</pre>