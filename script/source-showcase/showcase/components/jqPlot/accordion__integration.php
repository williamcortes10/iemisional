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

?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo YsUIAccordion::initWidget('acordionId','style="display=none"') ?>
    <?php echo YsUIAccordion::initSection('Section 1')?>
      <p>Section 1 Content.</p>
      THIS IS THE INDEX = 0;
    <?php echo YsUIAccordion::endSection()?>

    <?php echo YsUIAccordion::initSection('Section 2')?>
      <?php echo $plot1->renderTemplate('style="width:70%"'); ?>
      THIS IS THE INDEX = 1;
    <?php echo YsUIAccordion::endSection()?>

    <?php echo YsUIAccordion::initSection('Section 3')?>
      <p>Section 3 Content.</p>
      THIS IS THE INDEX = 2;
    <?php echo YsUIAccordion::endSection()?>

  <?php echo YsUIAccordion::endWidget() ?>
   
<?php echo YsUIDialog::endWidget() ?>


<?php
echo
YsJQuery::newInstance()
  ->execute(
    $plot1->UIAccordionIntegration('#acordionId', $accordionIndex = 1),
    $plot1->build()
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
    YsUIAccordion::build('#acordionId')
      ->_fillSpace(true)
      ->_autoHeight(false)
      ->_navigation(true)
      ->_collapsible(true)
  )
?>