<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  <?php echo YsUIAccordion::initWidget('acordionId','style="display=none"') ?>

    <?php echo YsUIAccordion::initSection('Section 1')?>
      <p>Mauris mauris ante, blandit et, ultrices a, susceros. Nam mi.
      Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit
      eu ante scelerisque vulputate.</p>
    <?php echo YsUIAccordion::endSection()?>

    <?php echo YsUIAccordion::initSection('Section 2')?>
      <p>Mauris mauris ante, blandit et, ultrices a, susceros. Nam mi.
      Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu
      ante scelerisque vulputate.</p>
    <?php echo YsUIAccordion::endSection()?>

    <?php echo YsUIAccordion::initSection('Section 3')?>
      <p>Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque
      lobortis. Phasellus pellentesque purus in massa. Aenean in pede.
      Phasellus ac libero ac tellus pellentesque semper. Sed ac felis.
      Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu
      iaculis leo purus venenatis dui. </p>
      <ul>
        <li>List item</li>
        <li>List item</li>
        <li>List item</li>
        <li>List item</li>
        <li>List item</li>
        <li>List item</li>
        <li>List item</li>
      </ul>
      <a href="#othercontent">Link to other content</a>
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
			->_autoHeight(false)
			->_navigation(true)
  );
?>