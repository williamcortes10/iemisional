<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" id="btnScrollTop" value="Scroll Top [300]" />
<input type="button" id="btnScrollTopVal" value="Scroll Top Value" />
<div id="blockScrollTop" style="  background:#CCCCCC none repeat scroll 0 0;
                                   border:3px solid #666666;
                                   margin:5px;
                                   padding:5px;
                                   position:relative;
                                   width:200px;
                                   height:100px;
                                   overflow:auto;">
<p style="margin-top:300px;
          padding:5px;
          border:2px solid #666;
          width:1000px;
          height:1000px;">Hello</p>
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnScrollTop')
  ->execute(
    YsJQuery::scrollTop(300)->in('#blockScrollTop')
  )
?>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnScrollTopVal')
  ->execute(
    sprintf('alert(%s)',YsJQuery::scrollTop()->in('#blockScrollTop'))
  )
?>
</div>