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
$fontname = TCPDF_FONTS::addTTFfont('meiryo_bold.ttf', 'TrueTypeUnicode', '', 32);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

function createRows($number, $color = 1) {
	$td = '';
	$colors = ["white", "#fafff0"];
	for ($i=0; $i < $number; $i++) { 
		$color = $colors[$i%2];
		$td .= 
			"<tr>
				<td class=\"last solid-left solid-right\"></td>
				<td class=\"table__row-1 solid-right\"></td>
				<td class=\"table__row-1 solid-left solid-right\"></td>
				<td class=\"table__row-1 solid-left solid-right\"></td>
				<td class=\"table__row-1 solid-left solid-right\"></td>
				<td class=\"table__row-1 solid-right\"></td>
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
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetMargins(PDF_MARGIN_LEFT - 10, 2, PDF_MARGIN_RIGHT);
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
// $pdf->SetFont('meiryo', '', 9, '', false);
// $pdf->SetFont('meiryo_b', 'b', 9);
// $pdf->SetFont('times', 'B', 16);

// add a page
$pdf->AddPage();

// create columns content
$left_column = '
<p>
<br/>
<br/>
<span>★テスト★ソリマチ（株） 御中</span>
<br/><span>渡辺 ケンタロウ 様</span>
<br/>[お客様コード:1000-000000-00 ] 
</p>
';
$left_column2 = '
<table>
	<tr>
		<td style="border-bottom: 1px solid black;" align="left" class="solid-left solid-right"><b>合計金額</b></td>
	</tr>
</table>
';

		
$left_column3 = '<p>76,200 円 (税込)</p>';

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

$right_column2 = '<br/>事業者登録: T1234567890123';
$right_column4 = "<img src=\"images/sorimachi_kabu_logo.png\" alt=\"test alt attribute\" width=\"160\" border=\"0\"/><span>登録番号:T1234567890123</span>";
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
	background-color: #D9D9D9;
	border-top: 1px solid black; 
	border-left: 1px solid black; 
	border-right: 1px solid black; 
	border-bottom: 1px solid black;
}

.solid-bottom {
	border-bottom: 1px solid black;
}

.solid-left {
	border-left: 1px solid black; 
}

.solid-right {
	border-right: 1px solid black; 
}

.dotted-right {
	border-right: 0.1px dotted #98FB98; 
}


</style>
<table border="0" width="100%" cellpadding="4">
    <tr>
		<th style="width:11%;" align="center"><span style="" >入金日</span></th>
		<th style="width:12%;" align="center"><span style="" >伝票番号</span></th>
		<th style="width:46%;" align="center"><span style="" >商品</span></th>
		<th style="width:5%;" align="center"><span style="" >数量</span></th>
		<th style="width:13%;" align="center"><span style="" >単価</span></th>
		<th style="width:13%;" align="center"><span style="" >お買上額</span></th>
    </tr>
	<tr>
		<td class="solid-left solid-right">2023/08/12</td>
		<td class="table__row-1 solid-right">123456789012</td>
		<td class="table__row-1 solid-left solid-right">みんなの確定申告＜平成２９年度申告版＞　ＳＡＡＧ　Ｅｄｉｔｉｏｎ</td>
		<td align="right" class="table__row-1 solid-left solid-right">1</td>
		<td align="right" class="table__row-1 solid-left solid-right">30,000 円</td>
		<td align="right" class="table__row-1 solid-right">30,000 円</td>
	</tr>
	<tr>
		<td class="solid-left solid-right">2023/08/12</td>
		<td class="table__row-1 solid-right">123456789012</td>
		<td class="table__row-1 solid-left solid-right">バリューサポート 販売王販仕在 ３ライセンス 更新</td>
		<td align="right" class="table__row-1 solid-left solid-right">2</td>
		<td align="right" class="table__row-1 solid-left solid-right">20,000 円</td>
		<td align="right" class="table__row-1 solid-right">40,000 円</td>
	</tr>
	';

	$table .= createRows(7,1);

	$table .='
    <tr>
        <td class="solid-bottom solid-left solid-right" ></td>
        <td class="solid-bottom solid-right"></td>
        <td class="solid-bottom solid-left solid-right"></td>
        <td class="solid-bottom solid-left solid-right"></td>
        <td class="solid-bottom solid-left solid-right"></td>
        <td class="solid-bottom solid-right"></td>
    </tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #D9D9D9" class="solid-bottom"><span style="font-family:'.$fontname.';font-weight:bold">本体価格小計</span></td>
		<td align="right" class="solid-bottom">70,000 円</td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #D9D9D9" class="solid-bottom"><span style="font-family:'.$fontname.';font-weight:bold">消費税</span></td>
		<td align="right" class="solid-bottom">6,200 円</td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #D9D9D9" class="solid-bottom"><span style="font-family:'.$fontname.';font-weight:bold">合計</span></td>
		<td align="right" class="solid-bottom">76,200 円</td>
	</tr>

	<tr>
		<td style="" colspan="4"></td>
		<td class="solid-bottom"></td>
		<td class="solid-bottom"></td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #D9D9D9" class=""><span style="font-family:'.$fontname.';font-weight:bold">本体価格</span></td>
		<td align="right" class="">70,000円</td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #F2F2F2" align="center" class="">10％対象分</td>
		<td align="right" class="">30,000円</td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #F2F2F2" align="center" class="">8％対象分</td>
		<td align="right" class="">40,000円</td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #F2F2F2" class="solid-bottom"></td>
		<td class="solid-bottom"></td>
	</tr>

	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #D9D9D9" class=""><span style="font-family:'.$fontname.';font-weight:bold">消費税額</span></td>
		<td align="right" class="">6,200円</td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #F2F2F2" align="center" class="">10％対象分</td>
		<td align="right" class="">3,000円</td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #F2F2F2" align="center" class="">8％対象分</td>
		<td align="right" class="">3,200円</td>
	</tr>
	<tr>
		<td style="" colspan="4"></td>
		<td style="background-color: #F2F2F2" class="solid-bottom"></td>
		<td class="solid-bottom"></td>
	</tr>
</table>';


//echo $fontname;

// $html='<span style="font-family:'.$fontname.';font-weight:bold">my text in bold</span>: my normal text';
// $pdf->writeHTMLCell($w=0,$h=0,$x=11,$y=201,$html,$border=0,$ln=0,$fill=false,$reseth=true,$align='L',$autopadding=false);

// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// get current vertical position
$y = $pdf->getY();

// set color for background
// $pdf->SetFillColor(255, 255, 200);

// set color for text
// $pdf->SetTextColor(0, 63, 127);
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
// $pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);


// write the first column
// $pdf->SetFont('helvetica', 'B', 12); // 'B' stands for bold
// $pdf->SetFont('meiryo', 'B', 20, '', false);
$pdf->SetFont('meiryo_b', 'b', 15);

// $pdf->writeHTMLCell('', '20', '', '', '<p style="text-align:center;">Some Text</p>', DEBUG, 1, 1, true, 'C', true);
$pdf->Cell(0, 10, '請求明細', 1, $ln=1, 'C', true, '', 0, false, 'C', 'C');

$pdf->SetFont('meiryo', '', 9, '', false);
$pdf->SetFillColor(215, 235, 255);
$pdf->SetTextColor(0, 0, 0);	
// $pdf->Ln(5);
$pdf->writeHTMLCell(90, '', '','', $left_column, DEBUG, 0, 0, true, 'J', true);
// write the first column

// set color for background

// set color for text
// $pdf->SetTextColor(127, 31, 0);


// $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 255)));

// write the second column
// $pdf->SetFillColor(50,205,50);
// $pdf->SetTextColor(255, 255, 255);
// $pdf->SetFont('meiryo', '', 12, '', false);

// $pdf->writeHTMLCell(100, '', '105', '', $right_column1, DEBUG, 1, 1, true, 'J', true);

// $pdf->SetTextColor(0, 0, 0);
// $pdf->SetFont('meiryo', '', 5, '', false);
// $pdf->writeHTMLCell(100, '', '105', '', $right_column2, DEBUG, 1, 0, true, 'J', true);

$pdf->Ln(3);
$pdf->SetFont('meiryo', '', 8, '', false);
$pdf->writeHTMLCell('', '', '', '', $right_column3, DEBUG, 1, 0, true, 'R', true);
$pdf->Ln(2);



$pdf->SetFont('meiryo_b', '', 8, '', false);
$pdf->writeHTMLCell('', '', '140', '', $right_column4, DEBUG, 1, 0, true, 'L', true);

// $pdf->SetFont('meiryo_b', '', 8, '', false);
// $pdf->writeHTMLCell('', '', '140', '', "登録番号:T1234567890123", DEBUG, 1, 1, true, 'L', true);

$pdf->Ln(10);
$pdf->SetFont('meiryo_b', '', 11, '', false);
$pdf->writeHTMLCell(90, '', '','', $left_column2, DEBUG, 0, 0, true, 'J', true);

$pdf->SetFont('meiryo', '', 11, '', false);
$pdf->writeHTMLCell(45, '', '60','', $left_column3, DEBUG, 0, 0, true, 'R', true);

// $pdf->SetFont('meiryo', '', 5, '', false);
// $pdf->writeHTMLCell(100, '', '105', '', $right_column6, DEBUG, 1, 0, true, 'J', true);
// $pdf->writeHTMLCell(100, '', '105', '', $right_column7, DEBUG, 1, 0, true, 'J', true);
// $pdf->writeHTMLCell(100, '', '105', '', $right_column8, DEBUG, 1, 0, true, 'J', true);
// $pdf->writeHTMLCell(100, '', '105', '', $right_column9, DEBUG, 1, 0, true, 'J', true);
// $pdf->writeHTMLCell(100, '', '105', '', $right_column10, DEBUG, 1, 0, true, 'J', true);
// $pdf->writeHTMLCell(100, '', '105', '', $right_column11, DEBUG, 1, 0, true, 'J', true);
// $pdf->writeHTMLCell(100, '', '105', '', $right_column12, DEBUG, 1, 0, true, 'J', true);
// $pdf->writeHTMLCell(100, '', '105', '', $right_column13, DEBUG, 1, 0, true, 'J', true);
// $pdf->writeHTMLCell(100, '', '105', '', $right_column14, DEBUG, 1, 0, true, 'J', true);

$pdf->SetFont('meiryo', '', 7, '', false);

// reset pointer to the last page
// $pdf->lastPage();
$pdf->Ln(12);
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
// $pdf->writeHTMLCell('60', '', '130', '150', $test3, DEBUG, 1, 0, true, 'L', true);
// $pdf->Ln(4);
// $pdf->writeHTMLCell('90', '', '100', '', $test4, DEBUG, 1, 0, true, 'L', true);
// $pdf->writeHTMLCell('15', '', '100', '54', '10000', DEBUG, 1, 0, true, 'L', true);
// $pdf->writeHTMLCell('15', '', '130', '54', '10000', DEBUG, 1, 0, true, 'L', true);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_007.pdf', 'I');
// $pdf->Output('example_007.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+