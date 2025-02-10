<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<?php YsJQuery::usePlugin('jLayout'); ?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo YsJLayout::initBorderlLayout(array(YsJLayout::HGAP => 3,
                                                YsJLayout::VGAP => 3)
                                         ,'style="width:99%; height:100%"'
                                          ) ?>
    <?php echo YsJLayout::initEast('eastPanel', 'style="width:65%; height:50%"') ?>


    <?php echo YsUITabs::initWidget('tabsId', 'style="height:97%"') ?>
      <?php echo YsUITabs::initHeader() ?>
      <?php echo YsUITabs::tab('Tab 1', '#tabs-1') ?>
      <?php echo YsUITabs::tab('Tab 2', '#tabs-2' , $closeable = true ,'title="My Title"') ?>
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


    <?php echo YsJLayout::endEast() ?>
    <?php echo YsJLayout::initWest('westPanel', 'style="width:33%; height:50%"') ?>

      <?php echo YsUIAccordion::initWidget('acordionId', 'style="height:100%"') ?>

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
      
    <?php echo YsJLayout::endWest() ?>
    <?php echo YsJLayout::initNorth('northPanel', 'style="width:100%; height:20%"') ?>
      Date: 
      <?php echo YsUIDatepicker::input('datepickerId')?>

    <?php echo YsJLayout::endNorth() ?>
    <?php echo YsJLayout::initSouth('southPanel', 'style="width:100%; height:10%"') ?>
      <?php echo YsUIProgressbar::initWidget('progressbarId') ?>
      <?php echo YsUIProgressbar::endWidget() ?>
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
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
   ,YsUITabs::build('#tabsId')
   ,YsUIDatepicker::build('#datepickerId')
   ,YsUIAccordion::build('#acordionId')->_fillSpace(true)->_autoHeight(false)
   ,YsUIProgressbar::build('#progressbarId')->_value(20)
   ,YsUIProgressbar::widgetValueAnimated('#progressbarId', 85)
   ,YsJLayout::build('.border')
  )
?>
