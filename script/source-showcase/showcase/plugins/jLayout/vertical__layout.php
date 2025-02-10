<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT); ?>

<?php echo YsJLayout::initVerticalLayout(array(YsJLayout::HGAP => 3,
                                               YsJLayout::VGAP => 3)) ?>

    <?php echo YsUIPanel::initWidget('panelOne', 'style="width: 100px;height: 100px;"') ?>
      One
    <?php echo YsUIPanel::endWidget() ?>
    <?php echo YsUIPanel::initWidget('panelTwo', 'style="width: 100px;height: 100px;"') ?>
      Two
    <?php echo YsUIPanel::endWidget() ?>
    <?php echo YsUIPanel::initWidget('panelThree', 'style="width: 100px;height: 100px;"') ?>
      Three
    <?php echo YsUIPanel::endWidget() ?>
    <?php echo YsUIPanel::initWidget('panelFour', 'style="width: 100px;height: 100px;"') ?>
      Four
    <?php echo YsUIPanel::endWidget() ?>

<?php echo YsJLayout::endVerticalLayout() ?>
<?php
echo
YsJQuery::newInstance()
  ->execute(
    YsJLayout::build('.grid')
  )
?>