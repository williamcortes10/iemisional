<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  <?php echo YsUIAccordion::initWidget('acordionId','style="display=none"') ?>

    <?php echo YsUIAccordion::initSection('Section 1')?>
      <p>Section 1 Content.</p>
    <?php echo YsUIAccordion::endSection()?>

    <?php echo YsUIAccordion::initSection('Section 2')?>
      <p>Section 2 Content.</p>
    <?php echo YsUIAccordion::endSection()?>

    <?php echo YsUIAccordion::initSection('Section 3')?>
      <p>Section 3 Content.</p>
      <ul>
        <li>List item one</li>
        <li>List item two</li>
        <li>List item three</li>
      </ul>
    <?php echo YsUIAccordion::endSection()?>

    <?php echo YsUIAccordion::initSection('Section 4')?>
      <p>Section 4 Content.</p>
      <p>Another.</p>
    <?php echo YsUIAccordion::endSection()?>
  <?php echo YsUIAccordion::endWidget() ?>

<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );
echo
YsJQuery::newInstance()
  ->execute(
    YsUIAccordion::build('#acordionId')
      ->_fillSpace(true)
      ->_autoHeight(false)
      ->_navigation(true)
      ->_collapsible(true)
  );
?>