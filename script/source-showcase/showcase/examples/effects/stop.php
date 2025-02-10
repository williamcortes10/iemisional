<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Go" id="btnGoAnimation" />
<input type="button" value="Stop" id="btnStopAnimation" />
<input type="button" value="Back" id="btnBackAnimation" />
<div class="divToShowStop" style="width: 60px; 
                                  height: 60px;
                                  background-color: #3f3;
                                  position:absolute">
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnGoAnimation')
  ->execute(
    YsJQuery::animate()
      ->in('.divToShowStop')
      ->properties(array('left' => '+=100px'))
      ->duration(2000)
  )
?>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnStopAnimation')
  ->execute(
    YsJQuery::stopAnimation()
      ->in('.divToShowStop')
  )
?>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnBackAnimation')
  ->execute(
    YsJQuery::animate()
      ->in('.divToShowStop')
      ->properties(array('left' => '-=100px'))
      ->duration(2000)
  )
?>
<br/><br/><br/><br/><br/><br/>
</div>