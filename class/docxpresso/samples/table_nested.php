<?php
/**
 * This sample script inserts a table with a nested table
 */
require_once '../CreateDocument.inc';
$doc = new Docxpresso\createDocument();
$format = '.odt';//.pdf, .doc, .docx, .odt, .rtf
//insert a paragraph
$doc->paragraph(array('text' => 'A table with col and row spans and a nested table: '));
//inserts a table
//styles for the different cells
$rightCell = 'background-color: #f0f0f0; padding: 4px 9px 0 9px; border: 1px solid #999999;';
$leftCell = 'background-color: #fffff0;padding: 4px 9px 0 9px; border: 1px solid #999999;';
//insert the table
$doc->table(array('grid' => array('4cm', '6cm')))->style('margin: auto')
        ->row()
            ->cell(array('rowspan' => 2))->style($leftCell)
                ->table(array('grid' => array('2cm', '2cm')))
                    ->row()
                        ->cell()->paragraph(array('text' => 'One'))
                        ->cell()->paragraph(array('text' => 'Two'))
                    ->row()
                        ->cell()->paragraph(array('text' => 'Three'))
                        ->cell()->paragraph(array('text' => 'Four'))
                    ->end('table')//finish the subtable
            ->cell()->style($rightCell)
                ->paragraph(array('text' => 'Some text'))
        ->row()
            ->cell()->style($rightCell)->style('background-color: #f0f0ff')
                ->paragraph(array('text' => 'Some other random text'))
        ->row()
            ->cell(array('colspan' => 2))->style($rightCell)->style('background-color: #fff0f0')
                ->paragraph(array('text' => 'A cell spanning two columns'))
        ->row()
            ->cell(array('rowspan' => 2))->style($leftCell)
                ->paragraph(array('text' => 'Another row span of 2'))
            ->cell()->style($rightCell)
                ->paragraph(array('text' => 'A sample test'))
        ->row()
            ->cell()->style($rightCell)->style('background-color: #f0f0ff')
                ->paragraph(array('text' => 'Some other sample text'));
//include in the render method the path where you want your document to be saved
$doc->render('nested_table' . $format); 
//echo a link to the generated document
echo 'You may download the generated document from the link below:<br/>';
echo '<a href="' . 'nested_table' . $format . '">Download document</a>'; 