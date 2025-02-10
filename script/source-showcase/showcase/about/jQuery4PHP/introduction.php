jQuery4PHP ( jQuery for PHP ) is a PHP 5 library. Makes easy writing javascript code (jQuery syntax) using PHP objects. Develops Rich Internet Applications in an easy way without having to know javascript language with the help and power of jQuery.
<br/><br/>
<h2><a class="title-link" >Using autoload:</a></h2>
To use the library jQuery4PHP you should load all necessary classes for it to work. jQuery4PHP fortunately provides the option to autoload.

<br/><br/>
<pre>
<?php echo htmlentities('<?php'); ?>

include_once 'path/to/YepSua/Labs/RIA/jQuery4PHP/YsJQueryAutoloader.php';
YsJQueryAutoloader::register();
<?php echo htmlentities('?>'); ?>

</pre>
<br/>
Include the jQuery library
<pre>
<?php echo htmlentities('<head>
  <script type="text/javascript" src="path/to/jquery.min.js"></script>
</head>'); ?>
</pre>
<br/>
And presto!!!.
<br/><br/>

<h2><a class="title-link" >The class 'YsJQuery':</a></h2>
This class provides all (or almost all) the functionality of the jQuery project, Using static methods for build jquery sintax.
<br/><br/>

<h2><a class="title-link" >A basic example</a></h2>
To display a message 'alert("Hello World")' in your browser when you click a button, you use this jquery sintax:
<br/><br/>
<pre>
$('#buttonId').click(function(){
  alert('Hello world');
});
</pre>
<br/>
In jQuery4PHP, you should write in this way
<br/><br/>
<pre>
<?php echo htmlentities('<?php'); ?>

echo 
YsJQuery::newInstance()
  ->onClick()
  ->in('#buttonId')
  ->execute('alert("Hello World")')
<?php echo htmlentities('?>'); ?>
</pre>
<br/>
If you don't want to use the echo constructor, you can call the 'write()' method of the YsJQuery object. Anyway echo is recommended.
<br/><br/>
<pre>
<?php echo htmlentities('<?php'); ?>

YsJQuery::newInstance()
  ->onClick()
  ->in('#buttonId')
  ->execute('alert("Hello World")')
  ->write()
<?php echo htmlentities('?>'); ?>
</pre>
<br/><br/>

<button id="btnClick">Click me</button>
<?php
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnClick')
  ->execute('alert("Hello World")')
  ->write()
?>
<br/><br/>
<h2><a class="title-link" >Another way to set an event (static method)</a></h2>

<br/>
<pre>
<?php echo htmlentities('<?php'); ?>

echo
YsJQuery::click()
  ->in('#btnClick')
  ->handler('alert("Hello World")')
  ->execute()
<?php echo htmlentities('?>'); ?>
</pre>
<br/>
This code return the next sintax:
<br/>
<br/>

<pre>
<?php
echo
YsJQuery::click()
  ->in('#btnClick')
  ->handler('alert("Hello World")')
?>
</pre>
<br/><br/>

<h2><a class="title-link" >Add the click event when button is ready</a></h2>

<br/>
<pre>
<?php echo htmlentities('<?php'); ?>

echo
YsJQuery::click()
  ->in('#btnClick')
  ->handler('alert("Hello World")')
  ->executeOnReady()
<?php echo htmlentities('?>'); ?>
</pre>
<br/>
This code return the next sintax:
<br/>
<br/>

<pre>
<?php
echo
YsJQuery::click()
  ->in('#btnClick')
  ->handler('alert("Hello World")')
  ->executeOnReady()
  ->getSintax()
?>
<br/><br/>
</pre>
<h2><a class="title-link" >A basic animation</a></h2>
You can see the jquery sintax for this example <a target="_black" href="http://api.jquery.com/animate/">here</a>.

<br/><br/>

Now with jQuery4PHP:

<br/><br/>

<pre>
<?php echo htmlentities('<button id="go1">&raquo; Animate Block1</button>
<button id="go2">&raquo; Animate Block1</button>
<button id="go3">&raquo; Animate Both</button>

<button id="go4">&raquo; Reset</button>
<div class="block_animate" id="block1">Block1</div>
<div class="block_animate" id="block2">Block1</div>') ?>


<?php echo htmlentities('<?php'); ?>

echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#go1')
  ->execute(
     YsJQuery::animate()
       ->in('#block1')
       ->properties(array('width' => "90%"))
    ,
    YsJQuery::animate()
        ->properties(array('fontSize' => '24px'))
        ->duration(1500)
    ,
    YsJQuery::animate()
        ->properties(array('borderRightWidth' => '15px'))
        ->duration(1500)
  );

echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#go2')
  ->execute(
     YsJQuery::animate()
       ->in('#block2')
       ->properties(array('width' => "90%"))
    ,
    YsJQuery::animate()
        ->properties(array('fontSize' => '24px'))
        ->duration(1500)
    ,
    YsJQuery::animate()
        ->properties(array('borderLeftWidth' => '15px'))
        ->duration(1500)
  );

YsJQuery::newInstance()
  ->onClick()
  ->in('#go3')
  ->execute(
    YsJQuery::add('#go2')->in('#go1'),
    YsJQuery::click()
  )
  ->write();

YsJQuery::newInstance()
  ->onClick()
  ->in('#go4')
  ->execute(
     YsJQuery::css()
       ->in('#block1, #block2')
       ->properties(array('width' => "", 
                          'fontSize' => "",
                          'borderWidth' => ""))
  )
  ->write()
<?php echo htmlentities('?>'); ?>
</pre>

<br/><br/>
<button id="go1">&raquo; Animate Block1</button>
<button id="go2">&raquo; Animate Block1</button>
<button id="go3">&raquo; Animate Both</button>

<button id="go4">&raquo; Reset</button>
<div class="block_animate" id="block1">Block1</div>
<div class="block_animate" id="block2">Block1</div>


<?php
echo 
YsJQuery::newInstance()
  ->onClick()
  ->in('#go1')
  ->execute(
     YsJQuery::animate()
       ->in('#block1')
       ->properties(array('width' => "90%"))
    ,
    YsJQuery::animate()
        ->properties(array('fontSize' => '24px'))
        ->duration(1500),
    YsJQuery::animate()
        ->properties(array('borderRightWidth' => '15px'))
        ->duration(1500)
  );

echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#go2')
  ->execute(
     YsJQuery::animate()
       ->in('#block2')
       ->properties(array('width' => "90%"))
    ,
    YsJQuery::animate()
        ->properties(array('fontSize' => '24px'))
        ->duration(1500),
    YsJQuery::animate()
        ->properties(array('borderLeftWidth' => '15px'))
        ->duration(1500)
  );

YsJQuery::newInstance()
  ->onClick()
  ->in('#go3')
  ->execute(
    YsJQuery::add('#go2')->in('#go1'),
    YsJQuery::click()
  )
  ->write();

YsJQuery::newInstance()
  ->onClick()
  ->in('#go4')
  ->execute(
     YsJQuery::css()
       ->in('#block1, #block2')
       ->properties(array('width' => "", 
                          'fontSize' => "",
                          'borderWidth' => ""))
  )
  ->write()
?>
<br/><br/>
<h2><a class="title-link" >The class 'YsJQueryDynamic'</a></h2>
In jQuery you can write the next code:
<br/><br/>
<pre>
  jQuery('#foo').slideUp(300).delay(800).fadeIn(400);
</pre>
<br/>
To do the same in jQuery4PHP  you must use the YsJQueryDynamic object 

<br/>
<pre>
<?php echo htmlentities('<?php'); ?>

echo
new YsJQueryDynamic(
  YsJQuery::slideUp(300)->in('#foo'),
  YsJQuery::delay(300),
  YsJQuery::fadeIn(300)
)
<?php echo htmlentities('?>'); ?>
</pre>
<br/>
This code return the next sintax:
<br/><br/>

<pre>
<?php
echo
new YsJQueryDynamic(
  YsJQuery::slideUp(300)->in('#foo'),
  YsJQuery::delay(300),
  YsJQuery::fadeIn(300)
)
?>
</pre>
<br/><br/>
<h2><a class="title-link" >And continue</a></h2>
In jQuery you can write the next code too:
<br/><br/>
<pre>
  jQuery('#foo').slideUp(300);
  jQuery('#bar').delay(800);
  jQuery('#foo-bar').fadeIn(400);
</pre>
<br/>
To do the same in jQuery4PHP  you must use the YsJQueryDynamic object
<br/>
<pre>
<?php echo htmlentities('<?php'); ?>

echo
new YsJQueryDynamic(
  YsJQuery::slideUp(300)->in('#foo'),
  YsJQuery::delay(300)->in('#bar'),
  YsJQuery::fadeIn(300)->in('#foo-bar')
)
<?php echo htmlentities('?>'); ?>
</pre>
<br/>
This code return the next sintax:
<br/><br/>

<pre>
<?php
echo
new YsJQueryDynamic(
  YsJQuery::slideUp(300)->in('#foo'),
  YsJQuery::delay(300)->in('#bar'),
  YsJQuery::fadeIn(300)->in('#foo-bar')
)
?>
</pre>
<br/><br/>
<h2><a class="title-link" >New!!! YsUICore</a></h2>

Now jQuery4PHP support the lastest jqueryUI version.
<br/>
For view all the examples, see the UI section

<br/><br/>
Remember include the jQueryUI library and styles
<pre>
<?php echo htmlentities('<head>
  <link rel="stylesheet" type="text/css" href="path/to/jquery-ui-1.8.2.custom.css">
  <script type="text/javascript" src="path/to/jquery-ui-1.8.2.custom.min.js"></script>
</head>'); ?>
</pre>

<br/><br/>
<h2><a class="title-link" >Extending jQuery4PHP</a></h2>

To be written...

<br/><br/><br/><br/><br/><br/>


For more info see the examples or go to <a href="http://sourceforge.net/projects/jquery4php/forums">jQuery4PHP forums</a> in sourceforge.net
