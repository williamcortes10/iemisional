<?php
/**
 * This sample script generates a document custom margins and borders
 */
require_once '../CreateDocument.inc';
$doc = new Docxpresso\CreateDocument();
$format = '.odt';//.pdf, .doc, .docx, .odt, .rtf
//set the required options
$options = array(
    'style' => 'margin: 1cm 0.5cm; padding: 2cm 1cm; border: 1pt solid #b70000',
    );
$doc->pageLayout($options);
$doc->paragraph()
    ->text(array('text' => 'A document with custom margins and borders with an additional padding.'));
//include in the render method the path where you want your document to be saved
$doc->render('margins_borders_paddings' . $format); 
//echo a link to the generated document
echo 'You may download the generated document from the link below:<br/>';
echo '<a href="' . 'margins_borders_paddings' . $format . '">Download document</a>';  