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
define("DEBUG", 0);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

function createRows($number, $color = 1) {
	$td = '';
	$colors = ["white", "#fafff0"];
	for ($i=0; $i < $number; $i++) { 
		$color = $colors[$i%2];
		$td .= 
			"<tr>
				<td style=\"height: 40px; background-color:$color\" class=\"last solid-left dotted-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 solid-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 solid-left solid-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 solid-left solid-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 solid-left dotted-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 solid-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 solid-left dotted-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 dotted-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 solid-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 solid-left dotted-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 dotted-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 dotted-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 solid-right\"></td>
				<td style=\"height: 40px; background-color:$color\" class=\"table__row-1 solid-right\"></td>
			</tr>";
	}
	return $td;
	
}

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
$pdf->SetMargins(PDF_MARGIN_LEFT - 10, 2, PDF_MARGIN_RIGHT);
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
$left_column = '
<p>
0001 &nbsp;&nbsp; 200198974910 &nbsp;&nbsp; 00001
<br/>
<br/>
&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;〒940-0071
<br/>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;新潟県長岡市表町1-4-24ソリマチ第3ビル
<br/><br/>&nbsp; &nbsp;&nbsp;★テスト★ ソリマチ (株)
<br/>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;竹沢友樹様
<br/><br/>
<br/>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;お客様コード: (1001-989749-10)
<br/>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;0-01-000001
</p>';

// $left_column = '<b>LEFT COLUMN</b> left column left column left column left column left column left column left column left column left ';
$right_column = '
<p>納品書 請求書
<br/>2023年6月20日
<br/>IMG
<br/>代表收箱校長秀樹
<br/>東京本社/〒100-0004
<br/>TELOS-8773-7 7530 WEB/T940-0071 -
<br/>4-24 RITA TEL0258-33-4435
<br/>西会 299
<br/>お客様コード: 1001-989749-10
<br/>お客様コード: 1001-989749-10
</p>';

$right_column1 = '
<p>納品書 請求書</p>
';


$right_column2 = '<br/>事業者登録: T1234567890123';
$right_column3 = '<p>2023年6月20日</p>';
$right_column4 = "&nbsp; &nbsp;&nbsp; &nbsp;<img src=\"images/sorimachi_kabu_logo.png\" alt=\"test alt attribute\" width=\"170\" border=\"0\"/>";
$right_column5 = "代表收箱校長秀樹";
$right_column6 = "&nbsp; &nbsp;&nbsp; &nbsp; 東京本社/〒100-0004";
$right_column7 = "&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 事業者登録: T1234567890123";
$right_column8 = "&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 事業者登録: T1234567890123";
$right_column9 = "&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; TEL03-8773-7 7530 WEB/T940-0071";
$right_column10 = "&nbsp; &nbsp;&nbsp; &nbsp; 事業者登録/ T1234567890123";
$right_column11 = "&nbsp; &nbsp;&nbsp; &nbsp; 事業者登録/ T1234567890123";
$right_column12 = "&nbsp; &nbsp;&nbsp; &nbsp; 事業者登録/ T1234567890123";
$right_column13 = "&nbsp; &nbsp;&nbsp; &nbsp; 事業者登録/ T1234567890123";
$right_column14 = "&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;事業者登録/ T1234567890123";

$table = '
<style>

table th {
	border-top: 1px solid #32CD32; 
	border-left: 1px solid #32CD32; 
	border-right: 1px solid #32CD32; 
	border-bottom: 1px solid #32CD32;
}

.solid-bottom {
	border-bottom: 1px solid #32CD32;
}

.solid-left {
	border-left: 1px solid #32CD32; 
}

.solid-right {
	border-right: 1px solid #32CD32; 
}

.dotted-right {
	border-right: 0.1px dotted #98FB98; 
}


</style>
<table border="0" width="100%" cellpadding="4">
    <tr>
        <th style="width:50px" colspan="2"><span style="color:#32CD32">合合合</span></th>
        <th style="width:70px;" align="center"><span style="color:#32CD32">日番号</span></th>
        <th style="width:120px" align="center"><span style="color:#32CD32">合 &nbsp; &nbsp; &nbsp; 合</span></th>
        <th style="width:70px" colspan="2" align="center"><span style="color:#32CD32">合 &nbsp; &nbsp; &nbsp; 合</span></th>
        <th style="width:80px;" colspan="3" align="center"><span style="color:#32CD32">合 &nbsp; &nbsp; &nbsp; 合</span></th>
        <th style="width:100px" colspan="4" align="center"><span style="color:#32CD32">合 &nbsp; &nbsp; &nbsp; 合</span></th>
        <th style="width:150px" align="center"><span style="color:#32CD32">合 &nbsp; &nbsp; &nbsp; 合</span></th>
    </tr>
	<tr>
		<td style="background-color:#fafff0" align="right" class="solid-left dotted-right">6</td>
		<td style="background-color:#fafff0" class="table__row-1 solid-right">9</td>
		<td style="background-color:#fafff0" class="table__row-1 solid-left solid-right">2000004 995960</td>
		<td style="background-color:#fafff0" class="table__row-1 solid-left solid-right">開発 (その他)</td>
		<td style="background-color:#fafff0" class="table__row-1 solid-left dotted-right"></td>
		<td style="background-color:#fafff0" class="table__row-1 solid-right">1</td>
		<td style="background-color:#fafff0" class="table__row-1 solid-left dotted-right"></td>
		<td style="background-color:#fafff0" class="table__row-1 dotted-right"></td>
		<td style="background-color:#fafff0" class="table__row-1 solid-right"></td>
		<td style="background-color:#fafff0" class="table__row-1 solid-left dotted-right"></td>
		<td style="background-color:#fafff0" class="table__row-1 dotted-right"></td>
		<td style="white-space: nowrap; background-color:#fafff0" class="table__row-1 dotted-right"></td>
		<td style="background-color:#fafff0" class="table__row-1 solid-right"></td>
		<td style="background-color:#fafff0" class="table__row-1 solid-right"></td>
	</tr>
	';

	$table .= createRows(7,1);

	$table .='
    <tr>
        <td style="background-color:#fafff0" class="solid-bottom solid-left dotted-right" ></td>
        <td style="background-color:#fafff0" class="solid-bottom solid-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom solid-left solid-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom solid-left solid-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom solid-left dotted-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom solid-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom solid-left dotted-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom dotted-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom solid-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom solid-left dotted-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom dotted-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom dotted-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom solid-right"></td>
        <td style="background-color:#fafff0" class="solid-bottom solid-right"></td>
    </tr>
	<tr>
		<td style="" colspan="6">
			<p style="">
			お支払期限2023年 7月 4日にお支払いくださいます<br/>
			ようお願いいたします
			</p>
		</td>
		<td class="solid-bottom solid-right solid-left" colspan="3" align="center" style=""><span style="color:#32CD32"><br/>合 &nbsp; &nbsp; &nbsp; 合</span></td>
		<td class="solid-bottom dotted-right"></td>
		<td class="solid-bottom dotted-right dotted-left"></td>
		<td class="solid-bottom dotted-right"></td>
		<td class="solid-bottom solid-right"></td>
		<td class=""></td>
	</tr>
</table>';


// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// get current vertical position
$y = $pdf->getY();

// set color for background
// $pdf->SetFillColor(255, 255, 200);

// set color for text
// $pdf->SetTextColor(0, 63, 127);

// write the first column
$pdf->writeHTMLCell(90, '', '', $y, $left_column, DEBUG, 0, 0, true, 'J', true);

// set color for background
$pdf->SetFillColor(215, 235, 255);

// set color for text
// $pdf->SetTextColor(127, 31, 0);
$pdf->SetTextColor(0, 0, 0);


// $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 255)));

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
// write the second column
$pdf->SetFillColor(50,205,50);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('meiryo', '', 12, '', false);

$pdf->writeHTMLCell(100, '', '105', '', $right_column1, DEBUG, 1, 1, true, 'J', true);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('meiryo', '', 5, '', false);
$pdf->writeHTMLCell(100, '', '105', '', $right_column2, DEBUG, 1, 0, true, 'J', true);

$pdf->SetFont('meiryo', '', 9, '', false);
$pdf->writeHTMLCell(100, '', '105', '', $right_column3, DEBUG, 1, 0, true, 'R', true);
$pdf->writeHTMLCell(100, '', '105', '', $right_column4, DEBUG, 1, 0, true, 'J', true);
$pdf->writeHTMLCell(100, '', '105', '20', $right_column5, DEBUG, 1, 0, true, 'C', true);

$pdf->SetFont('meiryo', '', 5, '', false);
$pdf->writeHTMLCell(100, '', '105', '', $right_column6, DEBUG, 1, 0, true, 'J', true);
$pdf->writeHTMLCell(100, '', '105', '', $right_column7, DEBUG, 1, 0, true, 'J', true);
$pdf->writeHTMLCell(100, '', '105', '', $right_column8, DEBUG, 1, 0, true, 'J', true);
$pdf->writeHTMLCell(100, '', '105', '', $right_column9, DEBUG, 1, 0, true, 'J', true);
$pdf->writeHTMLCell(100, '', '105', '', $right_column10, DEBUG, 1, 0, true, 'J', true);
$pdf->writeHTMLCell(100, '', '105', '', $right_column11, DEBUG, 1, 0, true, 'J', true);
$pdf->writeHTMLCell(100, '', '105', '', $right_column12, DEBUG, 1, 0, true, 'J', true);
$pdf->writeHTMLCell(100, '', '105', '', $right_column13, DEBUG, 1, 0, true, 'J', true);
$pdf->writeHTMLCell(100, '', '105', '', $right_column14, DEBUG, 1, 0, true, 'J', true);

$pdf->SetFont('meiryo', '', 9, '', false);

// reset pointer to the last page
// $pdf->lastPage();
$pdf->Ln(3);
$y = $pdf->getY();

$pdf->writeHTMLCell('', '', '', '', $table, 0, 0, 0, true, 'J', true);
// $pdf->Ln(4);

$test3 = "
<p>
20000 (本体) &nbsp; &nbsp;&nbsp;&nbsp;  消費税 &nbsp; &nbsp;&nbsp;&nbsp;  1,800$ <br/>
21800 (消費税)
</p>";

$test4 = "
<p>
本体(10%）&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; 1000$ &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; 消費税 &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 1000$ <br/>
本体(8%）&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 1000$ &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; 消費税 &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 800$
</p>";
// echo $pdf->getY();

// $pdf->writeHTMLCell('', '', '', '', $test2, 0, 1, 1, true, 'J', true);
$pdf->writeHTMLCell('60', '', '130', '150', $test3, DEBUG, 1, 0, true, 'L', true);
$pdf->Ln(4);
$pdf->writeHTMLCell('90', '', '100', '', $test4, DEBUG, 1, 0, true, 'L', true);
$pdf->writeHTMLCell('15', '', '100', '54', '10000', DEBUG, 1, 0, true, 'L', true);
$pdf->writeHTMLCell('15', '', '130', '54', '10000', DEBUG, 1, 0, true, 'L', true);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_007.pdf', 'I');
// $pdf->Output('example_007.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+