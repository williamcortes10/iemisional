<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT); ?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
      <div id="container">
      <?php echo YsUIPanel::initWidget('panelOne', 'style="height:100px;width:100px"') ?>
        <?php echo YsUIPanel::title('One', YsUIConstant::ICON_ALERT) ?>
      <?php echo YsUIPanel::endWidget() ?>

      <?php echo YsUIPanel::initWidget('panelTwo', 'style="height:100px;width:100px"') ?>
        <?php echo YsUIPanel::title('Two', YsUIConstant::ICON_ALERT) ?>
      <?php echo YsUIPanel::endWidget() ?>

      <?php echo YsUIPanel::initWidget('panelThree', 'style="height:100px;width:100px"') ?>
        <?php echo YsUIPanel::title('Three', YsUIConstant::ICON_ALERT) ?>
      <?php echo YsUIPanel::endWidget() ?>

      <?php echo YsUIPanel::initWidget('panelFour', 'style="height:100px;width:100px"') ?>
        <?php echo YsUIPanel::title('Four', YsUIConstant::ICON_ALERT) ?>
      <?php echo YsUIPanel::endWidget() ?>

      <?php echo YsUIPanel::initWidget('panelFive', 'style="height:100px;width:100px"') ?>
        <?php echo YsUIPanel::title('Five', YsUIConstant::ICON_ALERT) ?>
      <?php echo YsUIPanel::endWidget() ?>

      </div>
  <button id="btnBuildLayout">Layout</button>
<?php echo YsUIDialog::endWidget() ?>



<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_width("auto")
  );
  
echo
YsJQuery::newInstance()
  ->onClick()
  ->in("#btnBuildLayout")
  ->execute(
    YsJLayout::build("#container")
      ->_type(YsJLayout::GRID_TYPE)
      ->_rows(2)
      ->_columns(3)
  )
?>