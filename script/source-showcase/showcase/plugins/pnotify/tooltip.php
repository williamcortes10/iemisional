<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_PNOTYFY); ?>

<input value="Hover Over Me" id="btn1" type="button" />
<input value="Hover Over Me" id="btn2" type="button" />
<input value="Hover Over Me" id="btn3" type="button" title="From the 'title' attribute" />
<input value="Hover Over Me" id="btn4" type="button" />
<input value="Hover Over Me" id="btn5" type="button" />

<div id="myTable" style="display:none">
  <table width="100%"  border="1" >
    <tr><th>jQuery</th></tr>
    <tr><th>jQueryUI</th></tr>
    <tr><th>jQuery4PHP</th></tr>
  </table>
</div>

<?php
echo
YsJQuery::newInstance()
  ->execute(
      YsPNotify::tooltip("#btn1","An error has occurred")
    );

echo
YsJQuery::newInstance()
  ->execute(
      YsPNotify::tooltip("#btn2","Tooltip 2", array(
        YsPNotify::TITLE => 'Title',
        YsPNotify::ERROR_ICON => YsPNotify::getIcon(YsUIConstant::ICON_COMMENT),
        YsPNotify::TYPE => YsPNotify::ERROR_TYPE
      ))
    );

echo
YsJQuery::newInstance()
  ->execute(
      YsPNotify::tooltip("#btn3")
    );
    
echo
YsJQuery::newInstance()
  ->execute(
      YsPNotify::tooltip("#btn4", YsJQuery::html()->in('#myTable'), array(
        YsPNotify::INSERT_BRS => false
      ))
    );
    
echo
YsJQuery::newInstance()
  ->execute(
      YsPNotify::tooltip("#btn5", '<b>X  / Y - work only in ::tooltip()</b>', array(
        YsPNotify::INSERT_BRS => false,
        YsPNotify::X => "-30",
        YsPNotify::Y => "-305"
      ))
    )
?>