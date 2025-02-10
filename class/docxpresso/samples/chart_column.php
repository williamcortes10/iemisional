<?php
/**
 * This sample script inserts a basic column chart
 */
require_once '../CreateDocument.inc';
$doc = new Docxpresso\createDocument();
$format = '.odt';//.pdf, .doc, .docx, .odt, .rtf
//insert a basic column bar chart
$data = array(
                'series' => array('First series', 'Second series'),
                'Category 1' => array(20,40),
                'Category 2' => array(30,10),
                'Category 3' => array(12.5, 54),
              );
$doc->chart('column', array('data' => $data));
//include in the render method the path where you want your document to be saved
$doc->render('basic_column_chart' . $format); 
//echo a link to the generated document
echo 'You may download the generated document from the link below:<br/>';
echo '<a href="' . 'basic_column_chart' . $format . '">Download document</a>';