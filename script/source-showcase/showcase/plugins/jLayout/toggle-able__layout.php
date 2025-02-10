<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT); ?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo YsJLayout::initBorderlLayout(array(YsJLayout::HGAP => 3,
                                                YsJLayout::VGAP => 3)
                                         ,'style="width:99%; height:100%"'
                                          ) ?>
    <?php echo YsJLayout::initCenter('centerPanel', 'style="width:33%; height:50%"') ?>
      <input type="button" value="Toggle North" id="btnNorth">
      <input type="button" value="Toggle South" id="btnSouth">
      <input type="button" value="Toggle West" id="btnWest">
      <input type="button" value="Toggle East" id="btnEast">
    <?php echo YsJLayout::endCenter() ?>
    <?php echo YsJLayout::initEast('eastPanel', 'style="width:33%; height:50%"') ?>
      East
    <?php echo YsJLayout::endEast() ?>
    <?php echo YsJLayout::initWest('westPanel', 'style="width:33%; height:50%"') ?>
      West
      <input type="button" value="Toggle Center" id="btnCenter">
    <?php echo YsJLayout::endWest() ?>
    <?php echo YsJLayout::initNorth('northPanel', 'style="width:100%; height:20%"') ?>
      North
    <?php echo YsJLayout::endNorth() ?>
    <?php echo YsJLayout::initSouth('southPanel', 'style="width:100%; height:10%"') ?>
      South
    <?php echo YsJLayout::endSouth() ?>
  <?php echo YsJLayout::endBorderLayout()?>
<?php echo YsUIDialog::endWidget() ?>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_resizable(false)
      ->_width(600)
      ->_height(500)
   ,YsJLayout::build('.border')
  );

echo
YsJQuery::click()->in('#btnNorth')
  ->handler(YsJLayout::toggleNorthLayout(".border", "#northPanel"))->execute();

echo
YsJQuery::click()->in('#btnSouth')
  ->handler(YsJLayout::toggleSouthLayout(".border", "#southPanel"))->execute();

echo
YsJQuery::click()->in('#btnWest')
  ->handler(YsJLayout::toggleWestLayout(".border", "#westPanel"))->execute();

echo
YsJQuery::click()->in('#btnEast')
  ->handler(YsJLayout::toggleEastLayout(".border", "#eastPanel"))->execute();

echo
YsJQuery::click()->in('#btnCenter')
  ->handler(YsJLayout::toggleCenterLayout(".border", "#centerPanel"))->execute();

?>
