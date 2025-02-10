<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divFind">
    <ul class="level-1">
      <li class="item-i">I</li>
      <li class="item-ii">II
        <ul class="level-2">
          <li class="item-a">A</li>
          <li class="item-b">B
            <ul class="level-3">
              <li class="item-1">1</li>
              <li class="item-2">2</li>
              <li class="item-3">3</li>
            </ul>
          </li>
          <li class="item-c">C</li>
        </ul>
      </li>
      <li class="item-iii">III</li>
    </ul>
  </div>
  <input type="button" id="btnRunFind" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunFind')
  ->execute(
    YsJQuery::find('li')->in('#divFind > ul > li.item-ii'),
    YsJQuery::css('background-color', 'red')
  )
?>
</div>