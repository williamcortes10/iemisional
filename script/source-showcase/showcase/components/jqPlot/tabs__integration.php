<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id');

$serie1 = new YsPlotSerie();
$serie1->setLinealData(1,2,3,5.12,13.1,33.6);
$plot1->addSerie($serie1);

$plot2 = new YsPlot('plot2Id');

$serie1 = new YsPlotSerie();
$serie1->setLinealData(33.6,13.1,5.12,3,2,1);
$plot2->addSerie($serie1);

?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
   <?php echo YsUITabs::initWidget('tabsId') ?>
      <?php echo YsUITabs::initHeader() ?>
        <?php echo YsUITabs::tab('Tab 1', '#tabs-1') ?>
        <?php echo YsUITabs::tab('Tab 2', '#tabs-2') ?>
        <?php echo YsUITabs::tab('Tab 3', '#tabs-3') ?>
      <?php echo YsUITabs::endHeader() ?>

      <?php echo YsUITabs::initTabContent('tabs-1') ?>
        <p>Tab 1 Content.</p>
      <?php echo YsUITabs::endTabContent() ?>

      <?php echo YsUITabs::initTabContent('tabs-2') ?>
        <?php echo $plot1->renderTemplate('style="width:70%"'); ?>
      <?php echo YsUITabs::endTabContent() ?>

      <?php echo YsUITabs::initTabContent('tabs-3') ?>
        <?php echo $plot2->renderTemplate('style="width:70%"'); ?>
      <?php echo YsUITabs::endTabContent() ?>

    <?php echo YsUITabs::endWidget() ?>       
<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->execute(
    $plot1->UITabsIntegration('#tabsId'),
    $plot1->build(),
    $plot2->UITabsIntegration('#tabsId'),
    $plot2->build()
  )
?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_width(670)
      ->_height(500)
      ->_buttons(array(
        'Ok' => new YsJsFunction('alert("Hello world")'),
        'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       ),
    YsUITabs::build('#tabsId')
  )
?>