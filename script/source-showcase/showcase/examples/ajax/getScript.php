<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Get Script" id="btnGetScript" />
<button id="goAnimation">&raquo; Run</button>
<div class="block" style="background-color: blue; 
                          width: 150px;
                          height: 70px; margin: 10px;">
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnGetScript')
  ->execute(
    YsJQuery::getScript(
      'http://dev.jquery.com/view/trunk/plugins/color/jquery.color.js',
      new YsJsFunction('
      $("#goAnimation").click(function(){
        $(".block").animate( { backgroundColor: "pink" }, 1000)
          .animate( { backgroundColor: "blue" }, 1000);
      });
      ')
    )
  )
?>
</div>