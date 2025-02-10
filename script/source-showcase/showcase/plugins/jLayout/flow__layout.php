<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT); ?>

<?php echo YsJLayout::initFlowLayout(array(YsJLayout::RESIZE => false,YsJLayout::ALIGNMENT => 'right'),'id="flow-left" style="width:200px;height:50px"') ?>
  <div class="c small" style="font-size: 2em; display: inline-block; background-color: rgb(220,220,220);">
    One
  </div>
  <div class="c medium" style="font-size: 3em;  display: inline-block; background-color: rgb(220,220,220);">
    Two
  </div>
  <div class="c medium" style="font-size: 3em;  display: inline-block; background-color: rgb(220,220,220);">
    Three
  </div>
  <div class="c large" style="font-size: 3.5em;  display: inline-block; background-color: rgb(220,220,220);">
    Four
  </div>
  <div class="c small" style="font-size: 2em;  display: inline-block; background-color: rgb(220,220,220);">
    Five
  </div>
<?php echo YsJLayout::endFlowLayout() ?>