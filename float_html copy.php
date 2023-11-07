<?php
//============================================================+
// File name   : example_007.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 007 for TCPDF class
//               Two independent columns with WriteHTMLCell()
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Two independent columns with WriteHTMLCell()
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 007');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 007', PDF_HEADER_STRING);

// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// $pdf->setCellHeightRatio(2);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
// $pdf->SetFont('times', '', 12);
$pdf->SetFont('meiryo', '', 9, '', false);

// add a page
$pdf->AddPage();

// create columns content
$left_column = '<hr><b>LEFT COLUMN</b> <p>940-0071</p>
<p>新潟県長岡市表町1-4-24ソリマチ第3 ビル</p>
<p>★テスト★ ソリマチ (株)</p>;
<p>「竹沢友樹様</p>
<p>お客様コード: 1001-989749-10</p>';

$left_column = '<b>LEFT COLUMN</b> left column left column left column left column left column left column left column left column left ';
$right_column = '<b>LEFT COLUMN</b> left column left column left column left column left column left column left column left column left ';

$table = '
<style>
th {
	border-left-color:green;
	border-bottom-color:green;
	border-top-color:green;
	border-right-color:green;
	
}



</style>
<table style="border: 1px solid green;" border="0" width="100%">
    <tr>
        <th style="width:50px" colspan="2">#11</th>
        <th style="width:70px" align="right">#2</th>
        <th style="width:120px" align="left">#3</th>
        <th style="width:70px" colspan="2">#4</th>
        <th style="width:80px;" colspan="3" align="right">#5</th>
        <th style="width:100px" colspan="4" align="left">#6</th>
        <th style="width:150px">#7</th>

    </tr>
    <tr>
        <td style="height:200px; border-right: 0.1px dotted green;">1</td>
        <td >1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>4</td>
        <td>5</td>
        <td>5</td>
        <td>5</td>
        <td>6</td>
        <td>6</td>
        <td>6</td>
        <td>6</td>
        <td>7</td>
    </tr>
	<tr>
		<td style="border-right: 0px dotted white;">1</td>
		<td >1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>4</td>
		<td>5</td>
		<td>5</td>
		<td>5</td>
		<td>6</td>
		<td>6</td>
		<td>6</td>
		<td>6</td>
		<td>7</td>
	</tr>
</table>';

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// get current vertical position
$y = $pdf->getY();

// set color for background
$pdf->SetFillColor(255, 255, 200);

// set color for text
$pdf->SetTextColor(0, 63, 127);

// write the first column
$pdf->writeHTMLCell(90, '', '', $y, $left_column, 1, 0, 1, true, 'J', true);

// set color for background
$pdf->SetFillColor(215, 235, 255);

// set color for text
$pdf->SetTextColor(127, 31, 0);


// $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 255)));

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
// write the second column
$pdf->writeHTMLCell(100, '', '', '', $right_column, 1, 1, 0, true, 'J', true);

// reset pointer to the last page
// $pdf->lastPage();
$pdf->Ln(20);

$pdf->writeHTMLCell('', '', '', '', $table, 0, 1, 0, true, 'J', true);
$pdf->Ln(20);

$test1 = '
<table style="border: 1px solid red;" width="100%">
    <tr>
        <th  style="width:33.3%" align="right">RIGHT align</th>
        <th  style="width:33.3%" align="left">LEFT align</th>
    </tr>
</table>';

$test2 = "<p style=\"border-left-style: dotted;\"></p>";

$test3 = "
<style>
p {
	line-height: 3px;
}
</style>
<p>お支払期限2023年 7月 4日にお支払いくださいます</p>
<p>ようお願いいたします</p>";

// $pdf->writeHTMLCell('', '', '', '', $test2, 0, 1, 1, true, 'J', true);
$pdf->writeHTMLCell('', '', '', '', $test3, 1, 1, 1, true, 'J', true);



// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_007.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+