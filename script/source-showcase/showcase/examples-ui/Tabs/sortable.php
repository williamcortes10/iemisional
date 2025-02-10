<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
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
      <p>Tab 2 Content.</p>
    <?php echo YsUITabs::endTabContent() ?>

    <?php echo YsUITabs::initTabContent('tabs-3') ?>
      <p>Tab 3 Content.</p>
    <?php echo YsUITabs::endTabContent() ?>

  <?php echo YsUITabs::endWidget() ?>

<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_width(500)
      ->_modal(true)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  )
?>
<?php echo YsUITabs::build('#tabsId')
            ->sortable()
            ->execute()
?>